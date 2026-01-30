<?php
require_once '../init.php';

// Security Checks
if (!hasPerm(2)) { die(); }
if (!Token::check(Input::get('token'))) { die('A token error has occurred.'); }

$params = [];
$where = 'WHERE 1=1';

// Define the tables with aliases for the JOIN
$tables = "audit a LEFT JOIN users u ON a.user = u.id";

// Initialize DataTableRequest helper for secure ORDER BY and LIMIT handling
$dtRequest = new DataTableRequest($db);
$dtRequest->setColumns([
    0 => 'a.id',
    1 => 'u.username',
    2 => 'a.page',
    3 => 'a.ip',
    4 => 'a.timestamp',
])->loadTableColumns(['audit', 'users']);

// Handle whitelist filtering
$ignoreWhitelisted = false;
$whitelistedIPs = [];
if (!empty($_GET['w'])) {
    $w = Input::sanitize($_GET['w']);
    if ($w == 'true') {
        $ignoreWhitelisted = true;
        // Get whitelisted IPs
        $whitelistQuery = $db->query("SELECT ip FROM us_ip_whitelist")->results();
        foreach ($whitelistQuery as $ip) {
            $whitelistedIPs[] = $ip->ip;
        }

        // Add NOT IN clause if we have whitelisted IPs
        if (!empty($whitelistedIPs)) {
            $placeholders = str_repeat('?,', count($whitelistedIPs) - 1) . '?';
            $where .= " AND a.ip NOT IN ($placeholders)";
            $params = array_merge($params, $whitelistedIPs);
        }
    }
}

// Global Search
if (!empty($_GET['search']['value'])) {
    $val = Input::sanitize($_GET['search']['value']);
    $searchTerm = '%' . $val . '%';
    $where .= " AND (a.ip LIKE ? OR a.page LIKE ? OR u.username LIKE ? OR u.fname LIKE ? OR u.lname LIKE ?)";
    $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
}

// Get total records
$totalRecords = $db->query("SELECT COUNT(*) as count FROM audit")->first()->count;

// Get filtered records count
$filteredQuery = $db->query("SELECT COUNT(a.id) as count FROM {$tables} {$where}", $params);
$totalFiltered = $filteredQuery->first()->count;

// Get validated ORDER BY and LIMIT clauses
$order = $dtRequest->getOrderBy('a.id', 'DESC');
$limit = $dtRequest->getLimit();

// Final Query
$logs = $db->query("SELECT a.*, u.username, u.fname, u.lname FROM {$tables} {$where} {$order} {$limit}", $params)->results();

// Format data
$data = [];
foreach ($logs as $l) {
    $row = [];
    
    // Column 0: Log ID
    $row[] = $l->id;
    
    // Column 1: User
    $userDisplay = '';
    if ($l->user > 0) {
        if ($l->username) {
            $userDisplay = $l->fname . ' ' . $l->lname . ' (' . $l->username . ')';
        } else {
            $userDisplay = 'User ID: ' . $l->user;
        }
    } else {
        // Check if IP was last used by a known user
        $ipQuery = $db->query("SELECT user_id FROM us_ip_list WHERE ip = ? ORDER BY id DESC LIMIT 1", [$l->ip]);
        if ($ipQuery->count() > 0) {
            $lastUser = $ipQuery->first();
            $userQuery = $db->query("SELECT username, fname, lname FROM users WHERE id = ?", [$lastUser->user_id]);
            if ($userQuery->count() > 0) {
                $user = $userQuery->first();
                $userDisplay = 'IP last used by ' . $user->fname . ' ' . $user->lname . ' (' . $user->username . ')';
            } else {
                $userDisplay = 'IP last used by User ID: ' . $lastUser->user_id;
            }
        } else {
            $userDisplay = '<span style="color:red">Unknown IP</span>';
        }
    }
    $row[] = $userDisplay;
    
    // Column 2: Page Attempted
    $pageDisplay = $l->page;
    // You might want to add page name resolution here similar to echopage() function
    $row[] = $pageDisplay;
    
    // Column 3: IP
    $row[] = $l->ip;
    
    // Column 4: Timestamp
    $row[] = $l->timestamp;
    
    $data[] = $row;
}

// Output
header('Content-Type: application/json');
echo json_encode([
    "draw" => $dtRequest->getDraw(),
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalFiltered,
    "data" => $data
]);