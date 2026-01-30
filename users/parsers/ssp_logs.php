<?php
require_once '../init.php';

// Security Checks
if (!hasPerm(2)) { die(); }
if (!Token::check(Input::get('token'))) { die('A token error has occurred.'); }

$params = [];
$where = 'WHERE 1=1';

$tables = "logs l LEFT JOIN users u ON l.user_id = u.id";

// Initialize DataTableRequest helper for secure ORDER BY and LIMIT handling
$dtRequest = new DataTableRequest($db);
$dtRequest->setColumns([
    0 => 'l.id',
    1 => 'l.ip',
    2 => 'CONCAT(u.fname, u.lname)',
    3 => 'l.cloak_from',
    4 => 'l.logdate',
    5 => 'l.logtype',
    6 => null, // lognote - not sortable
    7 => null, // metadata - not sortable
])->loadTableColumns(['logs', 'users']);

// Custom Filter
if (!empty($_GET['mode'])) {
    $mode = Input::sanitize($_GET['mode']);
    if ($mode == 'debug') {
        $where .= " AND (l.logtype = 'Redirect Diag' OR l.logtype = 'Form Data')";
    } elseif ($mode == 'passwordless') {
        $where .= " AND l.logtype = 'Passwordless'";
    } elseif ($mode == 'database_debug') {
        $where .= " AND l.logtype = 'Database Debug'";
    }
}

// Global Search
if (!empty($_GET['search']['value'])) {
    $val = Input::sanitize($_GET['search']['value']);
    $searchTerm = '%' . $val . '%';
    $where .= " AND (l.ip LIKE ? OR l.logtype LIKE ? OR l.lognote LIKE ? OR u.fname LIKE ? OR u.lname LIKE ?)";
    $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
}

$totalRecords = $db->query("SELECT COUNT(*) as count FROM logs")->first()->count;

$filteredQuery = $db->query("SELECT COUNT(l.id) as count FROM {$tables} {$where}", $params);
$totalFiltered = $filteredQuery->first()->count;

// Get validated ORDER BY and LIMIT clauses
$order = $dtRequest->getOrderBy('l.id', 'DESC');
$limit = $dtRequest->getLimit();

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
    $row[] = $l->cloak_from ? $l->cloak_from : null;
    $row[] = $l->logdate;
    $row[] = $l->logtype;
    $row[] = strlen($l->lognote) > 80
        ? '<textarea style="padding-top:0px; padding-left:5px;" rows="1" class="form-control" readonly>' . hed($l->lognote) . '</textarea>'
        : hed($l->lognote);
    $row[] = ($l->metadata !== null)
        ? '<i class="fa fa-fw fa-eye" style="cursor:pointer" onclick="generateMetadataModal(' . $l->id . ')" title="View Metadata"></i>'
        : '';
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