<?php
if (count(get_included_files()) == 1) die(); //Direct Access Not Permitted
// Function to validate date format from RSS feed
if (!function_exists('validateRSSDate')) {
    function validateRSSDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}
// UserSpice Announcements & Data Sync
$rc = @fsockopen("rss.userspice.com", 443, $errCode, $errStr, 1);

if (checkInternet() && is_resource($rc)) {
    $filename = 'https://rss.userspice.com/rss.xml';
    $file_headers = @get_headers($filename);

    if (!isset($file_headers[1]) || (($file_headers[0] != 'HTTP/1.1 200 OK') && ($file_headers[1] != 'HTTP/1.1 200 OK'))) {
        //logger($user->data()->id,"Errors","UserSpice Announcements feed not found. Please tell UserSpice!");
    } else {
        $xmlDoc = new DOMDocument();
        if (@$xmlDoc->load($filename)) {
            // --- Process UserSpice Versions ---
            $tableCheck = $db->query("SHOW TABLES LIKE 'us_versions'")->count();
            if ($tableCheck > 0) {
                $releaseNode = $xmlDoc->getElementsByTagName('release')->item(0);
                $beNode = $xmlDoc->getElementsByTagName('beversion')->item(0);
                $expNode = $xmlDoc->getElementsByTagName('experimental')->item(0);
                
                $updateFields = [];

                if ($releaseNode) {
                    $release_version = trim($releaseNode->nodeValue);
                    if (preg_match('/^[0-9\.]+$/', $release_version) && $release_version !== '') {
                        $updateFields['release_version'] = $release_version;
                    } else {
                        //  logger(1, "Admin Announcements", "Invalid UserSpice Release version received from RSS feed: {$release_version}");
                    }
                }

                if ($beNode) {
                    $be_version = trim($beNode->nodeValue);
                     if (preg_match('/^[0-9\.]+$/', $be_version) && $be_version !== '') {
                        $updateFields['bleeding_edge'] = $be_version;
                    } else {
                        //  logger(1, "Admin Announcements", "Invalid UserSpice BE version received from RSS feed: {$be_version}");
                    }
                }

                if ($expNode) {
                    $exp_version = trim($expNode->nodeValue);
                     if (preg_match('/^[0-9\.]+$/', $exp_version) && $exp_version !== '') {
                        $updateFields['experimental'] = $exp_version;
                    } else {
                        //  logger(1, "Admin Announcements", "Invalid UserSpice Experimental version received from RSS feed: {$exp_version}");
                    }
                }

                if(!empty($updateFields)){
                    $db->update('us_versions', 1, $updateFields);
                }
            }

            // --- Process PHP EOL Data ---
            $phpeol = $xmlDoc->getElementsByTagName('phpeol')->item(0);
            if ($phpeol) {
                $phpversions = $phpeol->getElementsByTagName('phpversion');
                foreach ($phpversions as $version) {
                    $release = $version->getAttribute('release');
                    $eol_date = $version->getAttribute('eol');

                    // **VALIDATION**
                    if (preg_match('/^[0-9\.]+$/', $release) && validateRSSDate($eol_date)) {
                        $db->query(
                            "INSERT INTO us_php_eol (release_version, eol_date, last_checked) VALUES (?, ?, NOW()) 
                             ON DUPLICATE KEY UPDATE eol_date = ?, last_checked = NOW()",
                            [$release, $eol_date, $eol_date]
                        );
                    } else {
                        // logger(1, "Admin Announcements", "Invalid PHP EOL data received from RSS feed. Release: {$release}, EOL: {$eol_date}");
                    }
                }
            }

            // --- Process Known Bad PHP Versions ---
            $knownbad = $xmlDoc->getElementsByTagName('knownbad')->item(0);
            if ($knownbad) {
                $bad_versions = $knownbad->getElementsByTagName('phpversion');
                foreach ($bad_versions as $versionNode) {
                    $bad_version = trim($versionNode->nodeValue);

                    // **VALIDATION**
                    if (preg_match('/^[0-9\.]+$/', $bad_version) && $bad_version !== '') {
                        $db->query(
                            "INSERT INTO us_php_known_bad (version, last_checked) VALUES (?, NOW())
                             ON DUPLICATE KEY UPDATE last_checked = NOW()",
                            [$bad_version]
                        );
                    } else {
                        // logger(1, "Admin Announcements", "Invalid Known Bad PHP version received from RSS feed: {$bad_version}");
                    }
                }
            }

            // --- Process Announcements (Existing Logic) ---
            $limit = 0;
            $dis = $db->query("SELECT * FROM us_announcements WHERE update_announcement = 0")->results();
            $dismissed = [];
            foreach ($dis as $d) {
                $dismissed[] = $d->dismissed;
            }
            $x = $xmlDoc->getElementsByTagName('item');
            for ($i = 0; $i <= 2; $i++) {
                // FIX: Cannot use isset() on the result of an expression. Use null !== instead.
                if ($limit == 1 || $x->item($i) === null) {
                    continue;
                }

                $dis = $x->item($i)->getElementsByTagName('dis')
                    ->item(0)->childNodes->item(0)->nodeValue;

                if (!in_array($dis, $dismissed) && $dis != 0) {
                    $ignore = $x->item($i)->getElementsByTagName('ignore')
                        ->item(0)->childNodes->item(0)->nodeValue;
                    if (version_compare($ignore, $user_spice_ver, '<=')) {
                        continue;
                    } else {
                        $limit = 1;
                    }
                    $title = $x->item($i)->getElementsByTagName('title')
                        ->item(0)->childNodes->item(0)->nodeValue;
                    $class = $x->item($i)->getElementsByTagName('class')
                        ->item(0)->childNodes->item(0)->nodeValue;
                    $link = $x->item($i)->getElementsByTagName('link')
                        ->item(0)->childNodes->item(0)->nodeValue;
                    $message = $x->item($i)->getElementsByTagName('message')
                        ->item(0)->childNodes->item(0)->nodeValue;
                }
            }
        } // end loadXML
    } // end get_headers
} // end checkInternet


if (isset($message) && $message != '') { ?>
    <div class="sufee-alert alert alert-<?= $class ?> alert-dismissible fade show">
        <span class="badge badge-pill bg-<?= $class ?> p-2" style="color: black; "><?php echo htmlspecialchars($title); ?></span> <a href="<?php echo htmlspecialchars($link); ?>"><?php echo htmlspecialchars($message); ?></a>
        <button type="button" class="btn-close dismiss-announcement" data-bs-dismiss="alert" aria-label="Close" data-dis="<?= $dis ?>" data-ignore="<?= $ignore ?>" data-title="<?= htmlspecialchars($title) ?>" data-class="<?= $class ?>" data-link="<?= htmlspecialchars($link) ?>" data-message="<?= htmlspecialchars($message) ?>" data-update="false"></button>
    </div>

<?php }

if (in_array($user->data()->id, $master_account)) {
    $announce = $db->query("SELECT * FROM us_announcements WHERE dismissed_by = 0 AND update_announcement = 1")->results();

    if (count($announce) > 0) { ?>
        <div class="row">
            <?php foreach ($announce as $a) { ?>
                <div class="col-12">
                    <div class="alert alert-<?= $a->class ?> alert-dismissible fade show" role="alert">
                        <b><?= $a->title ?></b><br><?= $a->message ?>
                        <button type="button" class="btn-close dismiss-announcement" data-bs-dismiss="alert" aria-label="Close" data-dis="<?= $a->dismissed ?>" data-title="<?= $a->title ?>" data-class="<?= $a->class ?>" data-link="<?= $a->link ?>" data-message="<?= $a->message ?>" data-update="<?= $a->id ?>"></button>
                    </div>
                </div>
            <?php } ?>
        </div>
<?php }
}


?>

<script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>" type="text/javascript">
    $(document).ready(function() {
        //dismiss notifications
        $(".dismiss-announcement").click(function(event) {
            event.preventDefault();
            var button = $(this);

            var formData = {
                'dismissed': $(this).attr("data-dis"),
                'link': $(this).attr("data-link"),
                'title': $(this).attr("data-title"),
                'class': $(this).attr("data-class"),
                'message': $(this).attr("data-message"),
                'update': $(this).attr("data-update"),
                'ignore': $(this).attr("data-ignore"),
                'token': "<?= Token::generate() ?>",
            };
            //
            $.ajax({
                type: 'POST',
                url: 'parsers/dismiss_announcements.php',
                data: formData,
                dataType: 'json',
                encode: true
            }).done(function(response) {
                // This function is called when the Ajax request completes successfully
                console.log("Announcement dismissed successfully", response);
                button.closest('.sufee-alert').alert('close');
            }).fail(function(jqXHR, textStatus, errorThrown) {
                // Handle failure: you might want to log the error or inform the user
                console.error("Error dismissing announcement", textStatus, errorThrown);
            });
        });
    }); //End DocReady
</script>
