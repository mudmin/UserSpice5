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

//new debugging feature helps track down stray queries. 
//either on your page or at the top of users/init.php set the following variables
//$database_logging = true;
//$database_logging_tables_only = ["users"]; //array of tables that you want to limit your debugging to.  
//runs a stack trace on all insert/update queries for the specified tables
//logs to the logs table with the logtype of DATABASE_INSERT or DATABASE_UPDATE
class DB
{
	private static $_instance        = null;
	private ?PDO 	$_pdo 			 = null;
	private         $_query;
	private bool    $_error          = false;
	private array   $_errorInfo      = ['00000', null, null];
	private array   $_results        = [];
	private array   $_resultsArray   = [];
	private int     $_count          = 0;
	private int     $_lastId         = 0;
	private int     $_queryCount     = 0;

	private bool  $database_logging = false;
	private array $database_logging_tables_only = [];

	/*  Cached connection info for reconnect()  */
	private string  $dsn;
	private ?string $user;
	private ?string $pass;
	private array   $opts;

	private function __construct($config = [])
	{
		// Build PDO options once
		$this->opts = Config::get('mysql/options') ?: [
			PDO::MYSQL_ATTR_INIT_COMMAND => "SET SESSION sql_mode = ''",
		];
		$this->opts[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;   // always throw exceptions

		$charset = Config::get('mysql/charset') ?: 'utf8';

		/* Decide which credential/DSN set to use — identical logic to the
		   original code, but we ALSO cache the outcome so reconnect() is
		   guaranteed to hit the same server / database.  */
		if ($config === []) {
			// default db from init.php
			$this->dsn  = 'mysql:host=' . Config::get('mysql/host') .
				';dbname='    . Config::get('mysql/db') .
				';charset='  . $charset;
			$this->user = Config::get('mysql/username');
			$this->pass = Config::get('mysql/password');
		} elseif (!is_array($config) || count($config) === 1) {
			// DB::getDB('other_db')  or  DB::getDB(['other_db'])
			if (is_array($config)) $config = $config[0];
			$this->dsn  = 'mysql:host=' . Config::get('mysql/host') .
				';dbname='    . $config .
				';charset='  . $charset;
			$this->user = Config::get('mysql/username');
			$this->pass = Config::get('mysql/password');
		} elseif (in_array('init', $config, true)) {
			//this allows you to get another db from your init file that is added to your init.php config
			//array and call it like this 
			// $db2 = DB::getDB(['mysql2','init']);
			//your init file can have as many of these sets of db creds as you would like added like this
			// 'mysql'      => array(
			// 'host'         => '127.0.0.1',
			// 'username'     => 'root',
			// 'password'     => '',
			// 'db'           => '513',
			// ),
			// 'mysql2'      => array(
			// 'host'         => 'localhost',
			// 'username'     => 'root',
			// 'password'     => '',
			// 'db'           => 'dbname',
			// ),
			//be sure to give each one a unique name like mysql2, mysql3

			$group      = $config[0];
			$this->dsn  = 'mysql:host=' . Config::get("$group/host") .
				';dbname='    . Config::get("$group/db") .
				';charset='  . $charset;
			$this->user = Config::get("$group/username");
			$this->pass = Config::get("$group/password");
		} else {
			// DB::getDB(['host','db','user','pass'])
			$this->dsn  = 'mysql:host=' . $config[0] .
				';dbname='    . $config[1] .
				';charset='  . $charset;
			$this->user = $config[2];
			$this->pass = $config[3];
		}

		try {
			$this->_pdo = new PDO($this->dsn, $this->user, $this->pass, $this->opts);
			if (Config::get('mysql/force_utc_mysql') === true) {
				$this->_pdo->exec("SET time_zone = '+00:00'");
			}
			$charset = Config::get('mysql/charset');
			if ($charset != false && $charset != null && $charset != '') {
				$this->_pdo->exec("SET NAMES '" . $charset . "'");
			}
		} catch (PDOException $e) {
			//for debugging comment the line in below
			//die($e->getMessage());
			die("Could not connect to database.  Please check your configuration.");
		}
	}


	public static function getInstance()
	{
		if (!isset(self::$_instance)) {
			self::$_instance = new DB();
		}
		return self::$_instance;
	}

	public static function getDB($config)
	{
		self::$_instance = new DB($config);
		return self::$_instance;
	}


	public function beginTransaction()
	{
		return $this->_pdo->beginTransaction();
	}

	public function commit()
	{
		return $this->_pdo->commit();
	}

	public function rollBack()
	{
		return $this->_pdo->rollBack();
	}

	public function inTransaction()
	{
		return $this->_pdo->inTransaction();
	}

	public function query($sql, $params = array())
	{
		#echo "DEBUG: query(sql=$sql, params=".print_r($params,true).")<br />\n";
		$this->_queryCount++;
		$this->_error = false;
		$this->_errorInfo = array(0, null, null);
		$this->_resultsArray = [];
		$this->_count = 0;
		$this->_lastId = 0;
		if ($this->_query = $this->_pdo->prepare($sql)) {
			$x = 1;
			if (count($params)) {
				foreach ($params as $param) {
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}

			try {
				if ($this->_query->execute()) {
					if ($this->_query->columnCount() > 0) {
						$this->_results = $this->_query->fetchALL(PDO::FETCH_OBJ);
						$this->_resultsArray = json_decode(json_encode($this->_results), true) ?: [];
					} else {
						// Ensure _resultsArray is empty array for non-SELECT queries
						$this->_resultsArray = [];
					}
					$this->_count = $this->_query->rowCount();
					$this->_lastId = $this->_pdo->lastInsertId();
				} else {
					throw new Exception("db error");
				}
			} catch (Exception $e) {
				$this->_error = true;
				$this->_results = [];
				$this->_errorInfo = $this->_query->errorInfo();
			}
		}

		return $this;
	}

	public function findAll($table)
	{
		return $this->action('SELECT *', $table);
	}

	public function findById($id, $table)
	{
		return $this->action('SELECT *', $table, array('id', '=', $id));
	}

	public function action($action, $table, $where = array())
	{
		$table = $this->_sanitizeTableName($table);
		$sql    = "{$action} FROM {$table}";
		$values = array();
		$is_ok  = true;

		if ($where_text = $this->_calcWhere($where, $values, "and", $is_ok))
			$sql .= " WHERE $where_text";

		if ($is_ok)
			if (!$this->query($sql, $values)->error())
				return $this;

		return false;
	}

	private function _calcWhere($w, &$vals, $comboparg = 'and', &$is_ok = NULL)
	{
		#echo "DEBUG: Entering _calcwhere(w=".print_r($w,true).",...)<br />\n";
		if (is_array($w)) {
			#echo "DEBUG: is_array - check<br />\n";
			$comb_ops   = ['and', 'or', 'and not', 'or not'];
			$valid_ops  = ['=', '<', '>', '<=', '>=', '<>', '!=', 'LIKE', 'NOT LIKE', 'ALIKE', 'NOT ALIKE', 'REGEXP', 'NOT REGEXP'];
			$two_args   = ['IS NULL', 'IS NOT NULL'];
			$four_args  = ['BETWEEN', 'NOT BETWEEN'];
			$arr_arg    = ['IN', 'NOT IN'];
			$nested_arg = ['ANY', 'ALL', 'SOME'];
			$nested     = ['EXISTS', 'NOT EXISTS'];
			$nestedIN   = ['IN SELECT', 'NOT IN SELECT'];
			$wcount     = count($w);

			if ($wcount == 0)
				return "";

			# believe it or not, this appears to be the fastest way to check
			# sequential vs associative. Particularly with our expected short
			# arrays it shouldn't impact memory usage
			# https://gist.github.com/Thinkscape/1965669
			if (array_values($w) === $w) { // sequential array
				#echo "DEBUG: Sequential array - check!<br />\n";
				if (in_array(strtolower($w[0]), $comb_ops)) {
					#echo "DEBUG: w=".print_r($w,true)."<br />\n";
					$sql = '';
					$combop = '';
					for ($i = 1; $i < $wcount; $i++) {
						$sql .= ' ' . $combop . ' ' . $this->_calcWhere($w[$i], $vals, "and", $is_ok);
						$combop = $w[0];
					}
					return '(' . $sql . ')';
				} elseif ($wcount == 3  &&  in_array($w[1], $valid_ops)) {
					#echo "DEBUG: normal condition w=".print_r($w,true)."<br />\n";
					$vals[] = $w[2];
					return "{$w[0]} {$w[1]} ?";
				} elseif ($wcount == 2  &&  in_array($w[1], $two_args)) {
					return "{$w[0]} {$w[1]}";
				} elseif ($wcount == 4  &&  in_array($w[1], $four_args)) {
					$vals[] = $w[2];
					$vals[] = $w[3];
					return "{$w[0]} {$w[1]} ? AND ?";
				} elseif ($wcount == 3  &&  in_array($w[1], $arr_arg)  &&  is_array($w[2])) {
					$vals = array_merge($vals, $w[2]);
					return "{$w[0]} {$w[1]} (" . substr(str_repeat(",?", count($w[2])), 1) . ")";
				} elseif (($wcount == 5 || $wcount == 6 && is_array($w[5]))  &&  in_array($w[1], $valid_ops)  &&  in_array($w[2], $nested_arg)) {
					return  "{$w[0]} {$w[1]} {$w[2]}" . $this->get_subquery_sql($w[4], $w[3], $w[5], $vals, $is_ok);
				} elseif (($wcount == 3 || $wcount == 4 && is_array($w[3]))  &&  in_array($w[0], $nested)) {
					return $w[0] . $this->get_subquery_sql($w[2], $w[1], $w[3], $vals, $is_ok);
				} elseif (($wcount == 4 || $wcount == 5 && is_array($w[4]))  &&  in_array($w[1], $nestedIN)) {
					return "{$w[0]} " . substr($w[1], 0, -7) . $this->get_subquery_sql($w[3], $w[2], $w[4], $vals, $is_ok);
				} else {
					echo "ERROR: w=" . print_r($w, true) . "<br />\n";
					$is_ok = false;
				}
			} else { // associative array ['field' => 'value']
				#echo "DEBUG: Associative<br />\n";
				$sql = '';
				$combop = '';
				foreach ($w as $k => $v) {
					if (in_array(strtolower($k), $comb_ops)) {
						#echo "DEBUG: A<br />\n";
						#echo "A: k=$k, v=".print_r($v,true)."<br />\n";
						$sql .= $combop . ' (' . $this->_calcWhere($v, $vals, $k, $is_ok) . ') ';
						$combop = $comboparg;
					} else {
						#echo "DEBUG: B<br />\n";
						#echo "B: k=$k, v=".print_r($v,true)."<br />\n";
						$vals[] = $v;
						if (in_array(substr($k, -1, 1), array('=', '<', '>'))) // 'field !='=>'value'
							$sql .= $combop . ' ' . $k . ' ? ';
						else // 'field'=>'value'
							$sql .= $combop . ' ' . $k . ' = ? ';
						$combop = $comboparg;
					}
				}
				return ' (' . $sql . ') ';
			}
		} else {
			echo "ERROR: No array in $w<br />\n";
			$is_ok = false;
		}
	}

	public function get($table, $where)
	{
		return $this->action('SELECT *', $table, $where);
	}

	public function delete($table, $where)
	{
		if (is_int($where)) {
			return $this->deleteById($table, $where);
		}
		return empty($where) ? false : $this->action('DELETE', $table, $where);
	}

	public function deleteById($table, $id)
	{
		return $this->action('DELETE', $table, array('id', '=', $id));
	}

	public function insert($table, $fields = [], $update = false)
	{
		$table = $this->_sanitizeTableName($table);
		$keys    = array_keys($fields);
		$values  = [];
		$records = 0;

		foreach ($fields as $field) {
			$count = is_array($field) ? count($field) : 1;

			if (!isset($first_time)  ||  $count < $records) {
				$first_time = true;
				$records    = $count;
			}
		}

		for ($i = 0; $i < $records; $i++)
			foreach ($fields as $field)
				$values[] = is_array($field) ? $field[$i] : $field;

		$col = ",(" . substr(str_repeat(",?", count($fields)), 1) . ")";
		$sql = "INSERT INTO {$table} (`" . implode('`,`', $keys) . "`) VALUES " . substr(str_repeat($col, $records), 1);

		if ($update) {
			$sql .= " ON DUPLICATE KEY UPDATE";

			foreach ($keys as $key)
				if ($key != "id")
					$sql .= " `$key` = VALUES(`$key`),";

			if (!empty($keys))
				$sql = substr($sql, 0, -1);
		}
		$result = !$this->query($sql, $values)->error();

		if ($result) {
			$this->logQuery('INSERT', $table, $fields);
		}

		return $result;
	}

	public function update($table, $id, $fields)
	{
		$table = $this->_sanitizeTableName($table);
		$sql   = "UPDATE {$table} SET " . (empty($fields) ? "" : "`") . implode("` = ? , `", array_keys($fields)) . (empty($fields) ? "" : "` = ? ");
		$is_ok = true;

		if (!is_array($id)) {
			$sql     .= "WHERE id = ?";
			$fields[] = $id;
		} else {
			if (empty($id))
				return false;

			if ($where_text = $this->_calcWhere($id, $fields, "and", $is_ok))
				$sql .= "WHERE $where_text";
		}

		if ($is_ok) {
			if (!$this->query($sql, $fields)->error()) {
				$this->logQuery('UPDATE', $table, array_merge($fields, ['id' => $id]));
				return true;
			}
		}

		return false;
	}

	public function results($assoc = false)
	{
		if ($assoc) return ($this->_resultsArray) ? $this->_resultsArray : [];
		return ($this->_results) ? $this->_results : [];
	}

	public function first($assoc = false)
	{
		return ($this->count() > 0)  ?  $this->results($assoc)[0]  :  [];
	}

	public function count()
	{
		return $this->_count;
	}

	public function error()
	{
		return $this->_error;
	}

	public function errorInfo()
	{
		return $this->_errorInfo;
	}

	public function errorString()
	{
		return 'ERROR #' . $this->_errorInfo[0] . ': ' . $this->_errorInfo[2];
	}

	public function lastId()
	{
		return $this->_lastId;
	}

	public function getQueryCount()
	{
		return $this->_queryCount;
	}

	private function get_subquery_sql($action, $table, $where, &$values, &$is_ok)
	{
		$table = $this->_sanitizeTableName($table);
		if (is_array($where))
			if ($where_text = $this->_calcWhere($where, $values, "and", $is_ok))
				$where_text = " WHERE $where_text";

		return " (SELECT $action FROM $table$where_text)";
	}

	/* Deprecated method cell
	
	public function cell($tablecolumn, $id = [])
	{
		$input = explode(".", $tablecolumn, 2);

		if (count($input) != 2)
			return null;

		$result = $this->action("SELECT {$input[1]}", $input[0], (is_numeric($id) ? ["id", "=", $id] : $id));

		return ($result && $this->_count > 0)  ?  $this->_resultsArray[0][$input[1]]  :  null;
	}
	*/

	public function getColCount()
	{
		return $this->_query->columnCount();
	}

	public function getColMeta($counter)
	{
		return $this->_query->getColumnMeta($counter);
	}

	public function setLogging($logging, $tables_only = [])
	{
		$this->database_logging = $logging;
		$this->database_logging_tables_only = $tables_only;
	}

	private function logQuery($action, $table, $data)
	{
		global $database_logging, $database_logging_tables_only, $user;

		if (!isset($database_logging) || !$database_logging) {
			return;
		}

		if (!empty($database_logging_tables_only) && !in_array($table, $database_logging_tables_only)) {
			return;
		}

		if ($table === 'logs') {
			return;
		}

		$user_id = isset($user) && $user->isLoggedIn() ? $user->data()->id : 0;
		$logtype = "DATABASE_{$action}";
		$lognote = "Table: {$table}";
		$metadata = json_encode($data);

		// Generate stacktrace
		$stacktrace = $this->getStackTrace();

		// Add stacktrace to metadata
		$metadata = json_decode($metadata, true);
		$metadata['stacktrace'] = $stacktrace;
		$metadata = json_encode($metadata);

		logger($user_id, $logtype, $lognote, $metadata);
	}

	private function getStackTrace()
	{
		$stacktrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
		$trace = [];

		// Start from index 2 to skip the current method and logQuery method
		for ($i = 2; $i < count($stacktrace); $i++) {
			$step = $stacktrace[$i];
			$trace[] = [
				'file' => isset($step['file']) ? $step['file'] : 'unknown',
				'line' => isset($step['line']) ? $step['line'] : 'unknown',
				'function' => isset($step['function']) ? $step['function'] : 'unknown',
				'class' => isset($step['class']) ? $step['class'] : 'unknown',
			];
		}

		return $trace;
	}

	/**
	 * Check if a column exists in a table
	 * @param string $table The table name
	 * @param string $column The column name
	 * @return bool True if column exists, false otherwise
	 */
	public function columnExists($table, $column)
	{
		$table = $this->_sanitizeTableName($table);
		try {
			$sql = "SHOW COLUMNS FROM {$table} LIKE ?";
			$result = $this->query($sql, [$column]);
			return $result->count() > 0;
		} catch (Exception $e) {
			// Table doesn't exist or other error
			return false;
		}
	}


	/**
	 * Check if an index exists on a table
	 * @param string $table The table name
	 * @param string $indexName The index name
	 * @return bool True if index exists, false otherwise
	 */
	public function indexExists($table, $indexName)
	{
		$table = $this->_sanitizeTableName($table);
		try {
			$sql = "SHOW INDEX FROM {$table} WHERE Key_name = ?";
			$result = $this->query($sql, [$indexName]);
			return $result->count() > 0;
		} catch (Exception $e) {
			// Table doesn't exist or other error
			return false;
		}
	}

	/**
	 * Check if a table exists in the database
	 * @param string $table The table name
	 * @return bool True if table exists, false otherwise
	 */
	public function tableExists($table)
	{
		$table = $this->_sanitizeTableName($table);
		try {
			$sql = "SHOW TABLES LIKE {$table} ";
			$result = $this->query($sql);
			return $result->count() > 0;
		} catch (Exception $e) {
			return false;
		}
	}

	/**
	 * Get detailed information about a column
	 * @param string $table The table name
	 * @param string $column The column name
	 * @return array|null Column information array or null if not found
	 */
	public function getColumnInfo($table, $column)
	{
		$table = $this->_sanitizeTableName($table);
		try {
			$sql = "SHOW COLUMNS FROM {$table} LIKE ?";
			$result = $this->query($sql, [$column]);

			if ($result->count() > 0) {
				$columnData = $result->first(true);
				return [
					'field' => $columnData['Field'],
					'type' => $columnData['Type'],
					'null' => $columnData['Null'] === 'YES',
					'key' => $columnData['Key'],
					'default' => $columnData['Default'],
					'extra' => $columnData['Extra']
				];
			}
			return null;
		} catch (Exception $e) {
			return null;
		}
	}

	/**
	 * Safely add a column to a table with error handling and logging
	 * @param string $table The table name
	 * @param string $column The column name
	 * @param string $definition The column definition (e.g., "VARCHAR(255) DEFAULT NULL")
	 * @return bool True if successful, false otherwise
	 */
	public function addColumn($table, $column, $definition)
	{
		try {
			// Check if column already exists
			if ($this->columnExists($table, $column)) {

				return true;
			}

			$sql = "ALTER TABLE {$table} ADD COLUMN `{$column}` {$definition}";
			$result = $this->query($sql);

			if (!$result->error()) {

				return true;
			} else {
				$errorMsg = $this->errorString() ?: "Unknown error adding column {$column} to table {$table}";

				return false;
			}
		} catch (Exception $e) {

			return false;
		}
	}

	/**
	 * Safely modify/rename a column with error handling and logging
	 * @param string $table The table name
	 * @param string $oldColumn The current column name
	 * @param string $newColumn The new column name
	 * @param string $definition The new column definition
	 * @return bool True if successful, false otherwise
	 */
	public function modifyColumn($table, $oldColumn, $newColumn, $definition)
	{
		try {
			// Check if old column exists
			if (!$this->columnExists($table, $oldColumn)) {

				return false;
			}

			$sql = "ALTER TABLE {$table} CHANGE `{$oldColumn}` `{$newColumn}` {$definition}";
			$result = $this->query($sql);

			if (!$result->error()) {

				return true;
			} else {
				$errorMsg = $this->errorString() ?: "Unknown error modifying column {$oldColumn} in table {$table}";

				return false;
			}
		} catch (Exception $e) {

			return false;
		}
	}

	// detect if connection is still alive
	public function ping(): bool
	{
		try {
			if (!$this->_pdo) return false;
			$this->_pdo->query('SELECT 1');
			return true;
		} catch (PDOException $e) {
			return false;
		}
	}

	/**
	 * Reconnect to the database, resetting the PDO instance
	 * This is useful for handling connection timeouts or lost connections, especially on websockets and other long-lived connections.
	 */
	public function reconnect(): void
	{
		$this->_pdo = null;
		try {
			$this->_pdo = new PDO($this->dsn, $this->user, $this->pass, $this->opts);
			if (Config::get('mysql/force_utc_mysql') === true) {
				$this->_pdo->exec("SET time_zone = '+00:00'");
			}
			$charset = Config::get('mysql/charset');
			if ($charset != false && $charset != null && $charset != '') {
				$this->_pdo->exec("SET NAMES '" . $charset . "'");
			}
			$this->_error = false; // Reset error state on successful reconnect
			$this->_errorInfo = ['00000', null, null];
		} catch (PDOException $e) {
			$this->_error = true;
			$this->_errorInfo = $e->errorInfo ?? ['HY000', null, $e->getMessage()];
			error_log('Database reconnect failed: ' . $e->getMessage());
			throw $e;
		}
	}


	private function _sanitizeTableName(string $table): string
	{

		if (!is_string($table) || $table === '') {
			throw new InvalidArgumentException("Invalid table name.");
		}

		if (strlen($table) > 64) {
			throw new InvalidArgumentException("Table name too long (max 64 chars).");
		}

		// Allow only alphanumeric + underscore
		// Reject anything with spaces, dots, backticks, or special chars
		if (!preg_match('/^[A-Za-z0-9_]+$/', $table)) {
			throw new InvalidArgumentException("Invalid characters in table name.");
		}

		return "`{$table}`";
	}
}
