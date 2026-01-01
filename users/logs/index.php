<?php
define('USERSPICE_DO_NOT_LOG', true);
$menu_override = 2;
require_once '../init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';
include $abs_us_root . $us_url_root . 'usersc/includes/active_logging_custom.php';

if (!in_array($user->data()->id, $master_account)) {
    die();
}

$errors = [];
$successes = [];

$files = glob($logDir . '/*.log.php');
$dates = [];
foreach ($files as $file) {
    $date = substr(basename($file), 0, 8);
    if (!in_array($date, $dates)) {
        $dates[] = $date;
    }
}
rsort($dates);

$searchResults = [];
if (!empty($_POST)) {
    $date = Input::get('date');
    $searchTerm = trim(Input::get('searchTerm'));
    $viewAll = Input::get('viewAll');

    if ($date) {
        $dayFiles = glob($logDir . '/' . $date . '_*.log.php');
        sort($dayFiles);

        foreach ($dayFiles as $file) {
            $lines = file($file);
            array_shift($lines);

            foreach ($lines as $line) {
                $entry = json_decode($line, true);
                if ($entry) {
                    if ($viewAll || (
                        $searchTerm && (
                            (isset($entry['page']) && stripos((string)$entry['page'], $searchTerm) !== false) ||
                            (isset($entry['ip']) && stripos((string)$entry['ip'], $searchTerm) !== false) ||
                            (isset($entry['user_id']) && stripos((string)$entry['user_id'], $searchTerm) !== false) ||
                            (isset($entry['full_url']) && stripos((string)$entry['full_url'], $searchTerm) !== false) ||
                            (isset($entry['get_data']) && stripos(json_encode($entry['get_data']), $searchTerm) !== false) ||
                            (isset($entry['post_data']) && stripos(json_encode($entry['post_data']), $searchTerm) !== false) ||
                            (isset($entry['json_data']) && stripos(json_encode($entry['json_data']), $searchTerm) !== false) ||
                            (isset($entry['additional_data']) && stripos(json_encode($entry['additional_data']), $searchTerm) !== false)
                        )
                    )) {
                        $entry['_file'] = basename($file);
                        $searchResults[] = $entry;
                    }
                }
            }
        }
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 d-flex justify-content-between align-items-center mb-3">
            <h3>Log Viewer</h3>
            <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#helpModal">
                <i class="fa fa-question-circle"></i> Help
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="" method="post">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="date">Select Date</label>
                        <select name="date" id="date" class="form-control" required>
                            <option value="">--Select--</option>
                            <?php foreach ($dates as $d) {
                                $formatted = date("F j, Y", strtotime($d));
                                $selected = Input::get('date') == $d ? 'selected' : '';
                                echo "<option value='$d' $selected>$formatted</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="searchTerm">Search Term (optional)</label>
                        <input type="text" class="form-control" id="searchTerm" name="searchTerm"
                            value="<?= Input::get('searchTerm') ?>"
                            placeholder="Search IP, UserID, Page, or content">
                    </div>
                    <div class="col-md-4">
                        <label>&nbsp;</label><br>
                        <button type="submit" class="btn btn-primary" name="search">Search</button>
                        <button type="submit" class="btn btn-secondary" name="viewAll" value="1">View All</button>
                    </div>
                </div>
            </form>

            <?php if (!empty($searchResults)) { ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>User ID</th>
                                <th>IP</th>
                                <th>URL</th>
                                <th>Method</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($searchResults as $result) { ?>
                                <tr>
                                    <td><?= safeReturn($result['timestamp']) ?></td>
                                    <td class="fetchUser text-primary" data-uid="<?= (int)$result['user_id'] ?>><?= safeReturn($result['user_id']) ?></td>
                                    <td><?= safeReturn($result['ip']) ?></td>
                                    <td><small><?= safeReturn($result['full_url'] ?? $result['page']) ?></small></td>
                                    <td><?= safeReturn($result['request_method']) ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#detailsModal<?= md5($result['timestamp'] . $result['ip']) ?>">View</button>

                                        <div class="modal modal-xl fade" id="detailsModal<?= md5($result['timestamp'] . $result['ip']) ?>"
                                            tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Log Entry Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <strong>File:</strong><br>
                                                                <?= safeReturn($result['_file']) ?>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Time:</strong><br>
                                                                <?= safeReturn($result['timestamp']) ?>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>User ID:</strong><br>
                                                                <?= safeReturn($result['user_id']) ?>
                                                            </div>
                                                        </div>

                                                        <hr>

                                                        <h6>Request Details</h6>
                                                        <div class="row mb-3">
                                                            <div class="col-md-12">
                                                                <strong>Full URL:</strong><br>
                                                                <?= safeReturn($result['full_url'] ?? $result['page']) ?>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-12">
                                                                <strong>User Agent:</strong><br>
                                                                <?= safeReturn($result['user_agent']) ?>
                                                            </div>
                                                        </div>

                                                        <?php if (!empty($result['get_data'])) { ?>
                                                            <h6>GET Data:</h6>
                                                            <pre><?= safeReturn(json_encode($result['get_data'], JSON_PRETTY_PRINT)) ?></pre>
                                                        <?php } ?>

                                                        <?php if (!empty($result['post_data'])) { ?>
                                                            <h6>POST Data:</h6>
                                                            <pre><?= safeReturn(json_encode($result['post_data'], JSON_PRETTY_PRINT)) ?></pre>
                                                        <?php } ?>

                                                        <?php if (!empty($result['json_data'])) { ?>
                                                            <h6>JSON Data:</h6>
                                                            <pre><?= safeReturn(json_encode($result['json_data'], JSON_PRETTY_PRINT)) ?></pre>
                                                        <?php } ?>

                                                        <?php if (!empty($result['additional_data'])) { ?>
                                                            <h6>Additional Data:</h6>
                                                            <pre><?= safeReturn(json_encode($result['additional_data'], JSON_PRETTY_PRINT)) ?></pre>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <p class="text-muted">Found <?= count($searchResults) ?> entries</p>
            <?php } elseif (!empty($_POST)) { ?>
                <div class="alert alert-info">No results found</div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="modal fade" id="userDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong>User ID:</strong> <span id="userDetailsId"></span>
                </div>
                <div class="mb-3">
                    <strong>Name:</strong> <span id="userDetailsName"></span>
                </div>
                <div class="mb-3">
                    <strong>Username:</strong> <span id="userDetailsUsername"></span>
                </div>
                <div class="mb-3">
                    <strong>Email:</strong> <span id="userDetailsEmail"></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="helpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Active File Logging Documentation</h5>
                <button type="button" class="btn-close" id="close-help" data-bs-dismiss="modal" aria-label="Close">X</button>
                
            </div>
            <div class="modal-body">
                <h6 class="text-primary">Enabling/Disabling Logging</h6>
                <div class="mb-3">
                    <strong>Global Enable:</strong>
                    <pre class="bg-light p-2">// In users/init.php define('USERSPICE_ACTIVE_LOGGING', true);</pre>
                </div>

                <div class="mb-3">
                    <strong>Disable Per Page:</strong>
                    <pre class="bg-light p-2">// Add at top of page before init.php define('USERSPICE_DO_NOT_LOG', true);</pre>
                    <small class="text-muted">Or add the page name to $do_not_log_files array in usersc/includes/active_logging_custom.php</small>
                </div>

                <h6 class="text-primary mt-4">File Structure</h6>
                <ul>
                    <li><strong>Base Directory:</strong> users/logs/</li>
                    <li><strong>File Format:</strong> YYYYMMDD_HH_[UserID].log.php</li>
                    <li><strong>Example:</strong> 20240321_14_123.log.php (User 123's logs for March 21, 2024, 2-3 PM)</li>
                </ul>

                <h6 class="text-primary mt-4">Key Features</h6>
                <ul>
                    <li>Each user's logs can be stored in separate files by user ID</li>
                    <li>Automatic hourly log file rotation</li>
                    <li>Built-in sensitive data filtering (passwords, etc.)</li>
                    <li>Captures GET, POST, and JSON request data</li>
                </ul>

                <h6 class="text-primary mt-4">Customization</h6>
                <div class="mb-3">
                    <p>In usersc/includes/active_logging_custom.php you can customize:</p>
                    <ul>
                        <li>Pages to exclude from logging ($do_not_log_files)</li>
                        <li>Sensitive fields to redact ($do_not_log_fields)</li>
                        <li>Log file naming convention</li>
                        <li>Log retention period can be defined in here or done via cron job.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>">
    $(document).on('click', '[data-bs-target="#helpModal"]', function() {
        $('#helpModal').modal('show');
    });

    $(document).on('click', '#close-help', function() {
        $('#helpModal').modal('hide');
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.fetchUser').forEach(function(element) {
            element.style.cursor = 'pointer';
            element.addEventListener('click', function() {
                const userId = this.getAttribute('data-uid');
                fetchUserDetails(userId);
            });
        });
    });

    function fetchUserDetails(userId) {
        const loadingModal = new bootstrap.Modal(document.getElementById('userDetailsModal'));
        loadingModal.show();
        document.getElementById('userDetailsId').textContent = 'Loading...';
        document.getElementById('userDetailsName').textContent = 'Loading...';
        document.getElementById('userDetailsUsername').textContent = 'Loading...';
        document.getElementById('userDetailsEmail').textContent = 'Loading...';

        fetch('<?= $us_url_root ?>users/parsers/fetch_user_logs.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'userId=' + encodeURIComponent(userId)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('userDetailsId').textContent = data.data.id;
                    document.getElementById('userDetailsName').textContent = data.data.name;
                    document.getElementById('userDetailsUsername').textContent = data.data.username;
                    document.getElementById('userDetailsEmail').textContent = data.data.email;
                } else {
                    document.getElementById('userDetailsId').textContent = 'Error';
                    document.getElementById('userDetailsName').textContent = 'User not found';
                    document.getElementById('userDetailsUsername').textContent = '';
                    document.getElementById('userDetailsEmail').textContent = '';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('userDetailsId').textContent = 'Error';
                document.getElementById('userDetailsName').textContent = 'Failed to fetch user details';
                document.getElementById('userDetailsUsername').textContent = '';
                document.getElementById('userDetailsEmail').textContent = '';
            });
    }
</script>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>