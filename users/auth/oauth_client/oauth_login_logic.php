<?php
if(count(get_included_files()) == 1) die(); // Direct Access Not Permitted

global $user, $settings, $db;

// Only show OAuth login if enabled and user is not logged in
if ($settings->oauth == 1 && !$user->isLoggedIn()) {
    // Get all active OAuth client configurations
    $oauthClientsQ = $db->query("SELECT * FROM us_oauth_client_login_options WHERE oauth = 1 ORDER BY client_name ASC");
    
    if ($oauthClientsQ->count() > 0) {
        $oauthClients = $oauthClientsQ->results();
        
        // If there are multiple clients, we'll create multiple login options
        // If there's only one, we'll use the original single-client approach
        if (count($oauthClients) == 1) {
            $oauthClient = $oauthClients[0];
            
            // Set the link for the OAuth login
            $link = $us_url_root . "users/auth/oauth_request.php?client_id=" . $oauthClient->id;
            
            // Set display properties for the login button
            $provider = $oauthClient->login_title ?: 'OAuth Login';
            $image = 'usersc/oauth_client/assets/' . ($oauthClient->client_icon ?: '_default.png');
            
            // Check if icon file exists, fallback to default
            if (!file_exists($abs_us_root . $us_url_root . $image)) {
                $image = 'usersc/oauth_client/assets/_default.png';
                // If even the default doesn't exist, use a core fallback
                if (!file_exists($abs_us_root . $us_url_root . $image)) {
                    $image = 'users/images/oauth-default.png';
                }
            }
        } else {
            // Multiple clients - we'll need to handle this differently in the login form
            // For now, we'll create an array of clients that the login form can iterate over
            $oauth_clients = $oauthClients;
            
            // Set a generic link that will be overridden by individual client links
            $link = $us_url_root . "users/auth/oauth_request.php";
            $provider = "OAuth Login Options";
            $image = 'usersc/oauth_client/assets/_default.png';
        }
    }
}
?>