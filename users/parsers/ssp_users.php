<?php
require_once '../init.php';

// Security Checks
if (!hasPerm(2)) { die(); }
if (!Token::check(Input::get('token'))) { die('A token error has occurred.'); }

$params = [];
$limit = '';
$order = '';
$where = 'WHERE 1=1';

// Define the tables with aliases
$tables = "users AS u LEFT JOIN user_permission_matches AS upm ON u.id = upm.user_id LEFT JOIN permissions AS p ON p.id = upm.permission_id";

// Global Search
if (!empty($_GET['search']['value'])) {
    $val = Input::sanitize($_GET['search']['value']);
    $searchTerm = '%' . $val . '%';
    $where .= " AND (u.username LIKE ? OR u.fname LIKE ? OR u.lname LIKE ? OR u.email LIKE ?)";
    $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
}

// Get total records
$totalRecords = $db->query("SELECT COUNT(id) as count FROM users")->first()->count;

// Get filtered records count
// To get an accurate filtered count, we must group by user ID
$filteredQuery = $db->query("SELECT COUNT(DISTINCT u.id) as count FROM {$tables} {$where}", $params);
$totalFiltered = $filteredQuery->first()->count;

// Ordering
if (isset($_GET['order'][0]['column'])) {
    $columns = [
        0 => 'u.id',
        2 => 'u.username',
        3 => 'CONCAT(u.fname, " ", u.lname)',
        4 => 'u.email',
        5 => 'u.last_login',
        6 => 'perms',
        // Columns 1 (icon) and 7 (status) are not sortable from the DB
    ];
    $colIndex = (int)Input::sanitize($_GET['order'][0]['column']);
    if (array_key_exists($colIndex, $columns)) {
        $col = $columns[$colIndex];
        $direction = Input::sanitize($_GET['order'][0]['dir']);
        $dir = ($direction === 'asc') ? 'ASC' : 'DESC';
        $order = "ORDER BY {$col} {$dir}";
    }
} else {
    // Default sort: users by ID ascending
    $order = "ORDER BY u.id ASC";
}

// Limit
if (isset($_GET['start']) && $_GET['length'] != -1) {
    $start = (int)Input::sanitize($_GET['start']);
    $length = (int)Input::sanitize($_GET['length']);
    $limit = "LIMIT {$start}, {$length}";
}

// Final Query
$userData = $db->query("
    SELECT
      u.*,
      group_concat(p.name SEPARATOR ', ') AS perms
    FROM users AS u
    LEFT JOIN user_permission_matches AS upm ON u.id = upm.user_id
    LEFT JOIN permissions AS p ON p.id = upm.permission_id
    {$where}
    GROUP BY u.id
    {$order}
    {$limit}
", $params)->results();

// Format data for DataTables
$data = [];
foreach ($userData as $v1) {
    $row = [];
    // Column 0: ID
    $row[] = '<a class="nounderline text-dark" href="admin.php?view=user&id='.$v1->id.'">'.$v1->id.'</a>';
    
    // Column 1: Force PR Icon
    $row[] = '<a class="nounderline text-danger" href="admin.php?view=user&id='.$v1->id.'">'.($v1->force_pr == 1 ? '<i class="fa fa-lock"></i>' : '').'</a>';

    // Column 2: Username
    $row[] = '<a class="nounderline text-dark" href="admin.php?view=user&id='.$v1->id.'">'.$v1->username.'</a>';
    
    // Column 3: Name
    $row[] = '<a class="nounderline text-dark" href="admin.php?view=user&id='.$v1->id.'">'.$v1->fname.' '.$v1->lname.'</a>';
    
    // Column 4: Email
    $row[] = '<a class="nounderline text-dark" href="admin.php?view=user&id='.$v1->id.'">'.$v1->email.'</a>';

    // Column 5: Last Sign In
    $row[] = ($v1->last_login != "0000-00-00 00:00:00") ? $v1->last_login : '<i>Never</i>';

    // Column 6: Permissions
    $row[] = $v1->perms;

    // Column 7: Status
    $status = '';
    $status .= ($v1->permissions == 0)
        ? '<i class="fa fa-fw fa-lock text-danger" data-bs-toggle="tooltip" title="The user\'s account is locked (banned)"></i>'
        : '<i class="fa fa-fw fa-unlock" data-bs-toggle="tooltip" title="The user\'s account is unlocked (active)"></i>';
    if ($v1->email_verified == 1) { // Assuming email activation is enabled
         $status .= ' <i class="fa fa-envelope" data-bs-toggle="tooltip" title="User email is verified"></i>';
    }
    $row[] = $status;
    
    $data[] = $row;
}

// Output
header('Content-Type: application/json');
$draw = isset($_GET['draw']) ? (int)Input::sanitize($_GET['draw']) : 0;
echo json_encode([
    "draw" => $draw,
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalFiltered,
    "data" => $data
]);