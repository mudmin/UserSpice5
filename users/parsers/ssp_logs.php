<?php
require_once '../init.php';

// Security Checks
if (!in_array($user->data()->id, $master_account)) { die(); }
if (!Token::check(Input::get('token'))) { die('A token error has occurred.'); }

$params = [];
$limit = '';
$order = '';
$where = 'WHERE 1=1';

// Define the tables with aliases for the JOIN
$tables = "logs l LEFT JOIN users u ON l.user_id = u.id";

// Custom Filter
if (!empty($_GET['mode'])) {
    $mode = Input::get('mode');
    if ($mode == 'debug') {
        $where .= " AND (l.logtype = 'Redirect Diag' OR l.logtype = 'Form Data')";
    } elseif ($mode == 'passwordless') {
        $where .= " AND l.logtype = 'Passwordless'";
    } elseif ($mode == 'database_debug') {
        $where .= " AND l.logtype = 'Database Debug'";
    }
}

// Global Search - NOW INCLUDES FNAME and LNAME
if (!empty($_GET['search']['value'])) {
    $searchTerm = '%' . $_GET['search']['value'] . '%';
    $where .= " AND (l.ip LIKE ? OR l.logtype LIKE ? OR l.lognote LIKE ? OR u.fname LIKE ? OR u.lname LIKE ?)";
    $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
}

// Get total records (no join needed, it's faster)
$totalRecords = $db->query("SELECT COUNT(*) as count FROM logs")->first()->count;

// Get filtered records count - JOIN IS NOW INCLUDED
$filteredQuery = $db->query("SELECT COUNT(l.id) as count FROM {$tables} {$where}", $params);
$totalFiltered = $filteredQuery->first()->count;

// Ordering - SORTS BY NAME INSTEAD OF ID
if (isset($_GET['order'][0]['column'])) {
    // Note: The user column now sorts by the concatenated name
    $columns = ['l.id', 'l.ip', 'CONCAT(u.fname, u.lname)', 'l.logdate', 'l.logtype', null, null];
    $col = $columns[$_GET['order'][0]['column']];
    $dir = ($_GET['order'][0]['dir'] == 'asc') ? 'ASC' : 'DESC';
    if ($col) { $order = "ORDER BY {$col} {$dir}"; }
}

// Limit
if (isset($_GET['start']) && $_GET['length'] != -1) {
    $limit = "LIMIT " . (int)$_GET['start'] . ", " . (int)$_GET['length'];
}

// Final Query - NOW SELECTS FROM JOIN
$logs = $db->query("SELECT l.*, u.fname, u.lname FROM {$tables} {$where} {$order} {$limit}", $params)->results();

// Format data
$data = [];
foreach ($logs as $l) {
    $row = [];
    $row[] = '<span class="hideMe">' . sprintf('%11d', $l->id) . '</span>' . $l->id;
    $row[] = $l->ip;

    // Display Name from JOIN results, with fallbacks for system/unknown users
    if ($l->user_id == 0) {
        $userName = 'System';
    } elseif ($l->fname) {
        $userName = $l->fname . ' ' . $l->lname;
    } else {
        $userName = 'Unknown User';
    }
    $row[] = $userName . ' (' . $l->user_id . ')';

    $row[] = $l->logdate;
    $row[] = $l->logtype;
    $row[] = strlen($l->lognote) > 80
        ? '<textarea style="padding-top:0px; padding-left:5px;" rows="1" class="form-control" readonly>' . hed($l->lognote) . '</textarea>'
        : hed($l->lognote);
    $row[] = ($l->metadata !== null)
        ? '<i class="fa fa-fw fa-sticky-note pull-right" onclick="generateMetadataModal(' . $l->id . ')" title="View Metadata"></i>'
        : '';
    $data[] = $row;
}

// Output
header('Content-Type: application/json');
echo json_encode([
    "draw" => isset($_GET['draw']) ? (int)$_GET['draw'] : 0,
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalFiltered,
    "data" => $data
]);