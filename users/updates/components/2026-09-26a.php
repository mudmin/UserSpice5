<?php
$countE = 0;
// Escape output in usersc/includes/user_manager_columns.php (name column and default case).
// Only the exact original lines are swapped; customized lines are left alone.
$umFile = $abs_us_root . $us_url_root . 'usersc/includes/user_manager_columns.php';

if (file_exists($umFile) && is_writable($umFile) && ($umContent = file_get_contents($umFile)) !== false) {
    $umSearch = "'\">' . \$user->fname . ' ' . \$user->lname . '</a>';";
    $umReplace = "'\">' . safeReturn(\$user->fname . ' ' . \$user->lname, true) . '</a>';";
    $umNew = $umContent;
    if (substr_count($umNew, $umSearch) === 1) {
        $umNew = str_replace($umSearch, $umReplace, $umNew);
    }
    $umSearch2 = "return isset(\$user->\$column) ? \$user->\$column : '';";
    $umReplace2 = "return isset(\$user->\$column) ? safeReturn(\$user->\$column, true) : '';";
    if (substr_count($umNew, $umSearch2) === 1) {
        $umNew = str_replace($umSearch2, $umReplace2, $umNew);
    }
    if ($umNew !== $umContent) {
        file_put_contents($umFile, $umNew);
    }
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
