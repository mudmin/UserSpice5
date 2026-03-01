<?php
$countE = $count = 0;

// === Part 1: Update init.php - refactor email verification skip pages to use an array ===
$file = $abs_us_root . $us_url_root . "users/init.php";

if (file_exists($file)) {
    $contents = file_get_contents($file);

    // Normalize line endings to \n for matching, then restore original endings
    $originalEndings1 = (strpos($contents, "\r\n") !== false) ? "\r\n" : "\n";
    $normalized1 = str_replace("\r\n", "\n", $contents);

    $search = "//Check to see that user is verified\nif(\$user->isLoggedIn()){\n\tif(\$user->data()->email_verified == 0 && \$currentPage != 'verify.php' && \$currentPage != 'logout.php' && \$currentPage != 'verify_thankyou.php'){\n\t\tRedirect::to(\$us_url_root.'users/verify.php');\n\t}\n}";

    $replace = "//Check to see that user is verified\nif(\$user->isLoggedIn()){\n\t\$verifySkipPages = ['verify.php', 'logout.php', 'verify_thankyou.php', 'verify_resend.php'];\n\tif(\$user->data()->email_verified == 0 && !in_array(\$currentPage, \$verifySkipPages)){\n\t\tRedirect::to(\$us_url_root.'users/verify.php');\n\t}\n}";

    if (strpos($normalized1, $search) !== false) {
        $normalized1 = str_replace($search, $replace, $normalized1);
        if ($originalEndings1 === "\r\n") {
            $normalized1 = str_replace("\n", "\r\n", $normalized1);
        }
        file_put_contents($file, $normalized1);
        $count++;
    }
}

// === Part 2: Update init.example.php - same refactor if file exists ===
$file2 = $abs_us_root . $us_url_root . "users/init.example.php";

if (file_exists($file2)) {
    $contents2 = file_get_contents($file2);

    // Normalize line endings to \n for matching, then restore original endings
    $originalEndings = (strpos($contents2, "\r\n") !== false) ? "\r\n" : "\n";
    $normalized2 = str_replace("\r\n", "\n", $contents2);

    $search2 = "//Check to see that user is verified\nif (\$user->isLoggedIn()) {\n\tif (\$user->data()->email_verified == 0 && \$currentPage != 'verify.php' && \$currentPage != 'logout.php' && \$currentPage != 'verify_thankyou.php') {\n\t\tRedirect::to(\$us_url_root . 'users/verify.php');\n\t}\n}";

    $replace2 = "//Check to see that user is verified\nif (\$user->isLoggedIn()) {\n\t\$verifySkipPages = ['verify.php', 'logout.php', 'verify_thankyou.php', 'verify_resend.php'];\n\tif (\$user->data()->email_verified == 0 && !in_array(\$currentPage, \$verifySkipPages)) {\n\t\tRedirect::to(\$us_url_root . 'users/verify.php');\n\t}\n}";

    if (strpos($normalized2, $search2) !== false) {
        $normalized2 = str_replace($search2, $replace2, $normalized2);
        // Restore original line endings
        if ($originalEndings === "\r\n") {
            $normalized2 = str_replace("\n", "\r\n", $normalized2);
        }
        file_put_contents($file2, $normalized2);
        $count++;
    }
}

// === Part 3: Update processor.php - fix custom-css to custom_css ===
$file3 = $abs_us_root . $us_url_root . "usersc/templates/customizer/assets/css/processor.php";

if (file_exists($file3)) {
    $contents3 = file_get_contents($file3);

    // Normalize line endings to \n for matching, then restore original endings
    $originalEndings3 = (strpos($contents3, "\r\n") !== false) ? "\r\n" : "\n";
    $normalized3 = str_replace("\r\n", "\n", $contents3);

    $search3 = "if(isset(\$customizations['custom-css'])){\n    \$customCSS = \$customizations['custom-css'];\n    unset(\$customizations['custom-css']);";

    $replace3 = "if(isset(\$customizations['custom_css'])){\n    \$customCSS = \$customizations['custom_css'];\n    unset(\$customizations['custom_css']);";

    if (strpos($normalized3, $search3) !== false) {
        $normalized3 = str_replace($search3, $replace3, $normalized3);
        if ($originalEndings3 === "\r\n") {
            $normalized3 = str_replace("\n", "\r\n", $normalized3);
        }
        file_put_contents($file3, $normalized3);
        $count++;
    }
}

// === Part 4: Remove leftover usersc/classes/patch directory if it exists ===
$patchDir1 = $abs_us_root . $us_url_root . "usersc/classes/patch";

function deleteDirectory($dir) {
    if (!is_dir($dir)) return false;
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $item;
        if (is_dir($path)) {
            deleteDirectory($path);
        } else {
            unlink($path);
        }
    }
    return rmdir($dir);
}

if (is_dir($patchDir1)) {
    deleteDirectory($patchDir1);
    $count++;
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
