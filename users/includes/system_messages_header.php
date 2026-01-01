<?php
//This file prepares the proper divs as needed to display the 5 classes of
//UserSpice system messages independent of the template
//it can be included separately on pages where you don't call prep.php
//note that if you create a usersc/includes/system_messages_header.php
//your file will be included instead of ours
?>
<?php
// Set default justify if not already set
if (!isset($system_messages_justify)) { $system_messages_justify = 'left'; } // left|center|right

$justify = in_array($system_messages_justify, ['left','center','right'], true) ? $system_messages_justify : 'left';

// Map justify to Bootstrap position classes
$pos = [
  'left' => 'top-0 start-0',
  'center' => 'top-0 start-50 translate-middle-x',
  'right' => 'top-0 end-0'
][$justify];

$containerClasses = 'toast-container position-fixed ' . $pos;
?>

<style>
.us-toast {
    background: white !important;
    border: none !important;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    border-radius: 0.5rem !important;
    overflow: hidden !important;
    min-width: 30vw;
    max-width: 85vw;
}

.us-toast-bar {
    height: 4px;
    width: 100%;
}

.us-toast-bar.success {
    background: linear-gradient(90deg, #28a745, #20c997);
}

.us-toast-bar.danger {
    background: linear-gradient(90deg, #dc3545, #fd7e14);
}

.us-toast-bar.warning {
    background: linear-gradient(90deg, #ffc107, #fd7e14);
}

.us-toast-bar.info {
    background: linear-gradient(90deg, #17a2b8, #6f42c1);
}

.us-toast-bar.primary {
    background: linear-gradient(90deg, #007bff, #6610f2);
}

.us-toast-bar.dark {
    background: linear-gradient(90deg, #343a40, #6c757d);
}

.us-toast-body {
    padding: 1rem 1.25rem;
    color: #495057 !important;
    font-weight: 500;
}

.us-toast .btn-close {
    margin: 0.75rem 0.75rem 0 0;
    opacity: 0.6;
}

.us-toast .btn-close:hover {
    opacity: 1;
}

.us-toast-left .btn-close {
    order: -1;
    margin: 0.75rem 0.75rem 0 0.75rem;
}

.us-toast-left .us-toast-body {
    padding-left: 0.75rem;
}
</style>

<!-- Bootstrap 5 Toast Container for UserSpice Messages -->
<div id="us-toast-container"
     class="<?php echo htmlspecialchars($containerClasses, ENT_QUOTES, 'UTF-8'); ?>"
     data-justify="<?php echo htmlspecialchars($justify, ENT_QUOTES, 'UTF-8'); ?>">
</div>
