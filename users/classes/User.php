<?php
/*
UserSpice
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
class User
{
    private $_db;
    private $_data;
    private $_sessionName;
    private $_isLoggedIn;
    private $_cookieName;
    public $tableName = 'users';

    public function __construct($user = null, $loginHandler = null)
    {
        $this->_db = DB::getInstance();
        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

        if (!$user) {
            if (Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);

                if ($this->find($user, $loginHandler)) {
                    $this->_isLoggedIn = true;
                } else {
                    //process Logout
                }
            }
        } else {
            $this->find($user, $loginHandler);
        }
    }

    public function create($fields = [])
    {
        // Hard requirement: email must be provided. Everything else can
        // be defaulted, but a user with no email is unusable.
        if (!array_key_exists('email', $fields) || $fields['email'] === null || $fields['email'] === '') {
            throw new Exception('Email is required to create a user.');
        }

        // Default username to email if the caller didn't supply one.
        if (!array_key_exists('username', $fields) || $fields['username'] === null || $fields['username'] === '') {
            $fields['username'] = $fields['email'];
        }

        // Default password: generate a strong random secret and bcrypt it.
        // Hash::unique() is bin2hex(random_bytes(32)) so it should always
        // be 64 chars; if something goes sideways and it comes back short,
        // fall back to randomString(20) so we never bcrypt a weak value.
        if (!array_key_exists('password', $fields) || $fields['password'] === null || $fields['password'] === '') {
            $secret = Hash::unique();
            if (!is_string($secret) || strlen($secret) < 32) {
                $secret = randomString(20);
            }
            $fields['password'] = password_hash($secret, PASSWORD_BCRYPT, ['cost' => 14]);
        }

        // Sanity checks: refuse to create a user whose username or email
        // collides with anyone else's username OR email. Callers like
        // join.php already validate this, but every other entry point
        // (OAuth, custom code, plugins) gets the same protection here.
        $u = $fields['username'];
        $check = $this->_db->query('SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1', [$u, $u]);
        if ($check->count() > 0) {
            throw new Exception('Username is already in use.');
        }
        $e = $fields['email'];
        $check = $this->_db->query('SELECT id FROM users WHERE email = ? OR username = ? LIMIT 1', [$e, $e]);
        if ($check->count() > 0) {
            throw new Exception('Email is already in use.');
        }

        if (!$this->_db->insert('users', $fields)) {
            throw new Exception($this->_db->errorString());
        } else {
            $user_id = $this->_db->lastId();
        }
        $query = $this->_db->insert('user_permission_matches', ['user_id' => $user_id, 'permission_id' => 1]);

        return $user_id;
    }

    public function find($user = null, $loginHandler = null)
    {
        // Cloaking: when an admin is cloaked into another user, load that user
        // instead. Prefer the instance-namespaced key; fall back to the legacy
        // un-namespaced key so older sessions / custom code keep working.
        // (Uses $this->_sessionName because find() runs during init.php, before
        // loader.php defines the INSTANCE constant.)
        if (isset($_SESSION[$this->_sessionName . '_cloak_to'])) {
            $user = $_SESSION[$this->_sessionName . '_cloak_to'];
        } elseif (isset($_SESSION['cloak_to'])) {
            $user = $_SESSION['cloak_to'];
        }

        if ($user) {
            if ($loginHandler !== null) {
                if ($loginHandler == "forceEmail") {

                    $field = 'email';
                } elseif (!filter_var($user, FILTER_VALIDATE_EMAIL) === false) {
                    $field = 'email';
                } else {
                    $field = 'username';
                }
            } else {
                if (is_numeric($user)) {
                    $field = 'id';
                } elseif (!filter_var($user, FILTER_VALIDATE_EMAIL) === false) {
                    $field = 'email';
                } else {
                    $field = 'username';
                }
            }
            $data = $this->_db->get('users', [$field, '=', $user]);

            if ($data->count()) {
                $this->_data = $data->first();

                return true;
            }
        }

        return false;
    }

    public function login($username = null, $password = null, $remember = false)
    {
        if (!$username && !$password && $this->exists()) {
            Session::put($this->_sessionName, $this->data()->id);
            $date = date('Y-m-d H:i:s');
            $this->_db->query('UPDATE users SET last_login = ?, logins = logins + 1 WHERE id = ?', [$date, $this->data()->id]);
            reauthMarkConfirmed();
        } else {
            $user = $this->find($username);
            if ($user) {
                if (password_verify($password, $this->data()->password)) {
                    Session::put($this->_sessionName, $this->data()->id);
                    if ($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('users_session', ['user_id', '=', $this->data()->id]);

                        $this->_db->insert('users_session', [
                            'user_id' => $this->data()->id,
                            'hash' => $hash,
                            'uagent' => Session::uagent_no_version(),
                        ]);

                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                    }
                    $date = date('Y-m-d H:i:s');
                    $this->_db->query('UPDATE users SET last_login = ?, logins = logins + 1 WHERE id = ?', [$date, $this->data()->id]);
                    reauthMarkConfirmed();
                    $this->_db->insert('logs', ['logdate' => $date, 'user_id' => $this->data()->id, 'logtype' => 'Login', 'lognote' => 'User logged in.', 'ip' => ipCheck()]);
                    $ip = ipCheck();
                    $q = $this->_db->query('SELECT id FROM us_ip_list WHERE ip = ?', [$ip]);
                    $c = $q->count();
                    if ($c < 1) {
                        $this->_db->insert('us_ip_list', [
                            'user_id' => $this->data()->id,
                            'ip' => $ip,
                            'timestamp' => date('Y-m-d H:i:s'),
                        ]);
                    } else {
                        $f = $q->first();
                        $this->_db->update('us_ip_list', $f->id, [
                            'user_id' => $this->data()->id,
                            'ip' => $ip,
                            'timestamp' => date('Y-m-d H:i:s'),
                        ]);
                    }

                    return true;
                }
            }
        }

        return false;
    }

    public function loginEmail($email = null, $password = null, $remember = false, $rawpassword = null)
    {
        $success = false;
        if (!$email && !$password && $this->exists()) {
            Session::put($this->_sessionName, $this->data()->id);
        } else {
            $user = $this->find($email, 1);

            if ($user && $this->data()->password !== null) {
                $strength = substr($this->data()->password, 4, 2);
                if (!is_numeric($strength)) {
                    $strength = 999;
                }

                if (password_verify($password, $this->data()->password)) {
                    $success = true;
                    //UserSpice passwords were hashed with a cost of 10, then 12, so we're going to use this to update both the hash strength and deal with passwords that were corrupted because of the Input::sanitize function.
                } elseif (!is_null($rawpassword) && $strength < 13) {
                    if (password_verify(Input::sanitize($rawpassword, true, true), $this->data()->password)) {
                        $success = true;
                    }
                }

                if ($success) {
                    if ($strength < 13) {
                        //deal with custom login forms that do not properly pass the password
                        if ($rawpassword != null && $rawpassword != "") {
                            $this->_db->update('users', $this->data()->id, ['password' => password_hash(Input::sanitize($rawpassword), PASSWORD_BCRYPT, ['cost' => 13])]);
                        }
                    }
                    Session::put($this->_sessionName, $this->data()->id);

                    if ($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('users_session', ['user_id', '=', $this->data()->id]);

                        $this->_db->insert('users_session', [
                            'user_id' => $this->data()->id,
                            'hash' => $hash,
                            'uagent' => Session::uagent_no_version(),
                        ]);

                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                    }
                    $date = date('Y-m-d H:i:s');
                    $this->_db->query('UPDATE users SET last_login = ?, logins = logins + 1 WHERE id = ?', [$date, $this->data()->id]);
                    reauthMarkConfirmed();
                    $ip = ipCheck();
                    $this->_db->insert('logs', ['logdate' => $date, 'user_id' => $this->data()->id, 'logtype' => 'login', 'lognote' => 'User logged in.', 'ip' => $ip]);

                    $q = $this->_db->query('SELECT id FROM us_ip_list WHERE ip = ?', [$ip]);
                    $c = $q->count();
                    if ($c < 1) {
                        $this->_db->insert('us_ip_list', [
                            'user_id' => $this->data()->id,
                            'ip' => $ip,
                            'timestamp' => date('Y-m-d H:i:s'),
                        ]);
                    } else {
                        $f = $q->first();
                        $this->_db->update('us_ip_list', $f->id, [
                            'user_id' => $this->data()->id,
                            'ip' => $ip,
                            'timestamp' => date('Y-m-d H:i:s'),
                        ]);
                    }

                    return true;
                }
            }
        }

        return false;
    }

    //Google oAuth Login Stuff
    //
    // Used by the legacy google_login plugin (usplugins/src/google_login_legacy).
    // Returns a user row with `->id` and `->isNewAccount`, or null if the
    // lookup/insert ultimately produced nothing.
    //
    // $gender and $locale are part of the historical signature and are
    // retained for backward compatibility; they are intentionally unused.
    public function checkUser($oauth_provider, $oauth_uid, $fname, $lname, $email, $gender, $locale, $link, $picture)
    {
        $this->_db = DB::getInstance();
        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');
        $now = date('Y-m-d H:i:s');

        // Case A: user is already linked to this oauth provider+uid.
        // Refresh only the profile fields the provider legitimately owns —
        // historically this method also clobbered username/email/active/
        // permissions on every login, which was a bug (and was silently
        // suppressed by a typo in the column list).
        $linked = $this->_db->query(
            'SELECT * FROM users WHERE oauth_provider = ? AND oauth_uid = ? LIMIT 1',
            [$oauth_provider, $oauth_uid]
        );
        if ($linked->count() > 0) {
            $existing = $linked->first();
            $this->_db->update('users', $existing->id, [
                'fname'     => $fname,
                'lname'     => $lname,
                'picture'   => $picture,
                'gpluslink' => $link,
                'modified'  => $now,
            ]);
            $result = $this->_db->query('SELECT * FROM users WHERE id = ? LIMIT 1', [$existing->id])->first();
            if ($result) {
                $result->isNewAccount = false;
            }
            return $result;
        }

        // Case B: a local user with this email exists but isn't oauth-linked
        // yet — link them. The legacy plugin links these itself before
        // calling us, so in practice this branch only fires for other
        // callers; previously it was an empty `if` and the trailing lookup
        // returned nothing, which crashed the caller.
        $byEmail = $this->_db->query('SELECT * FROM users WHERE email = ? LIMIT 1', [$email]);
        if ($byEmail->count() > 0) {
            $existing = $byEmail->first();
            $this->_db->update('users', $existing->id, [
                'oauth_provider' => $oauth_provider,
                'oauth_uid'      => $oauth_uid,
                'picture'        => $picture,
                'gpluslink'      => $link,
                'modified'       => $now,
            ]);
            $result = $this->_db->query('SELECT * FROM users WHERE id = ? LIMIT 1', [$existing->id])->first();
            if ($result) {
                $result->isNewAccount = false;
            }
            return $result;
        }

        // Case C: brand new account. Generate a username that doesn't
        // collide with any existing username OR email, then route through
        // create() so it picks up the same sanity checks as every other
        // user creation path.
        $username = $this->_uniqueOauthUsername($email);

        $newId = $this->create([
            'password'       => null,
            'username'       => $username,
            'active'         => 1,
            'oauth_provider' => $oauth_provider,
            'oauth_uid'      => $oauth_uid,
            'permissions'    => 1,
            'email_verified' => 1,
            'fname'          => $fname,
            'lname'          => $lname,
            'email'          => $email,
            'picture'        => $picture,
            'gpluslink'      => $link,
            'join_date'      => $now,
            'created'        => $now,
            'modified'       => $now,
        ]);

        $result = $this->_db->query('SELECT * FROM users WHERE id = ? LIMIT 1', [$newId])->first();
        if ($result) {
            // NOTE: $result->isNewAccount is a contract consumed by OAuth plugins
            // (e.g. usplugins/src/google_login_legacy/assets/google_oauth.php) to
            // detect first-time accounts. It is set dynamically on the returned
            // record, so static analysers can't see the read. Do not remove.
            $result->isNewAccount = true;
        }
        return $result;
    }

    private function _uniqueOauthUsername($email)
    {
        // Default to email-as-username (legacy behavior) when nothing else
        // is using it as either a username or an email.
        $taken = $this->_db->query(
            'SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1',
            [$email, $email]
        )->count();
        if ($taken === 0) {
            return $email;
        }
        $base = strstr((string)$email, '@', true);
        if ($base === false || $base === '') {
            $base = 'user';
        }
        $base = preg_replace('/[^A-Za-z0-9._-]/', '', $base);
        if ($base === '') {
            $base = 'user';
        }
        for ($i = 1; $i <= 1000; $i++) {
            $candidate = $base . $i;
            $hit = $this->_db->query(
                'SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1',
                [$candidate, $candidate]
            )->count();
            if ($hit === 0) {
                return $candidate;
            }
        }
        throw new Exception('Unable to generate a unique username for OAuth user.');
    }

    // End of Google Section

    public function exists()
    {
        return (!empty($this->_data)) ? true : false;
    }

    public function data()
    {
        return $this->_data;
    }

    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
    }

    public function notLoggedInRedirect($location)
    {
        if ($this->_isLoggedIn) {
            return true;
        } else {
            Redirect::to($location);
        }
    }

    public function logout()
    {
        if ($this->_isLoggedIn) {
            $this->_db->query('DELETE FROM users_session WHERE user_id = ? AND uagent = ?', [$this->data()->id, Session::uagent_no_version()]);
        }
        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
        session_unset();
        session_destroy();
    }

    public function update($fields = [], $id = null)
    {
        if (!$id && $this->isLoggedIn()) {
            $id = $this->data()->id;
        }

        if (!$id) {
            throw new Exception('No user id supplied for update.');
        }

        // Sanity checks: only run when the caller is actually changing
        // username or email. Password / pin / vericode / etc. updates
        // (the vast majority of update() callers) skip this entirely.
        if (array_key_exists('username', $fields) && $fields['username'] !== null && $fields['username'] !== '') {
            $u = $fields['username'];
            $check = $this->_db->query(
                'SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ? LIMIT 1',
                [$u, $u, $id]
            );
            if ($check->count() > 0) {
                throw new Exception('Username is already in use.');
            }
        }
        if (array_key_exists('email', $fields) && $fields['email'] !== null && $fields['email'] !== '') {
            $e = $fields['email'];
            $check = $this->_db->query(
                'SELECT id FROM users WHERE (email = ? OR username = ?) AND id != ? LIMIT 1',
                [$e, $e, $id]
            );
            if ($check->count() > 0) {
                throw new Exception('Email is already in use.');
            }
        }

        if (!$this->_db->update('users', $id, $fields)) {
            throw new Exception('There was a problem updating.');
        }
    }
}
