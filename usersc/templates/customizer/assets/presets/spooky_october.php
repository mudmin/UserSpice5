<?php
/**
 * Preset: Spooky October
 * Category: Themed
 * Description: Pumpkin orange, deep purple, bone white. Tasteful Halloween, not a costume.
 * Tags: dark, thematic, seasonal, halloween, dramatic
 * Mode: dark
 * Author: UserSpice Customizer Theme
 */
return array (
  'primary' => '#ff7518',
  'primary-hover' => '#e6650e',
  'primary-text-emphasis' => '#ffb380',
  'primary-bg-subtle' => '#3a1a0a',
  'primary-border-subtle' => '#ff7518',

  'secondary' => '#6a1b9a',
  'secondary-hover' => '#581577',
  'secondary-text-emphasis' => '#c39dd6',
  'secondary-bg-subtle' => '#260a35',
  'secondary-border-subtle' => '#6a1b9a',

  'success' => '#76ff03',
  'success-hover' => '#62d802',
  'success-text-emphasis' => '#c4ff85',
  'success-bg-subtle' => '#1a3300',
  'success-border-subtle' => '#76ff03',

  'info' => '#ce93d8',
  'info-hover' => '#b87ec3',
  'info-text-emphasis' => '#ead2ef',
  'info-bg-subtle' => '#2c1531',
  'info-border-subtle' => '#ce93d8',

  'warning' => '#ffd54f',
  'warning-hover' => '#f0c33b',
  'warning-text-emphasis' => '#fff1a3',
  'warning-bg-subtle' => '#332b06',
  'warning-border-subtle' => '#ffd54f',

  'danger' => '#e53935',
  'danger-hover' => '#c52e2b',
  'danger-text-emphasis' => '#f0a3a0',
  'danger-bg-subtle' => '#3a0d0c',
  'danger-border-subtle' => '#e53935',

  'light' => '#f5e6d3',
  'light-hover' => '#dccfb8',
  'light-text-emphasis' => '#3a2d1a',
  'light-bg-subtle' => '#2c1a10',
  'light-border-subtle' => '#a89578',

  'dark' => '#0a0410',
  'dark-hover' => '#1a0a26',
  'dark-text-emphasis' => '#050208',
  'dark-bg-subtle' => '#1a0a26',
  'dark-border-subtle' => '#0a0410',

  'body-color' => '#f5e6d3',
  'body-bg' => '#1a0a1f',
  'border-color' => '#3a1a4f',
  'form-control-bg' => '#2c1431',

  'secondary-color' => '#c2a98f',
  'tertiary-color' => '#8a7660',
  'emphasis-color' => '#ffffff',
  'secondary-bg' => '#2a1530',
  'tertiary-bg' => '#220f28',

  'us-menu-custom-bg' => '#0a0410',
  'us-menu-custom-text' => '#f5e6d3',
  'us-menu-custom-hover-bg' => '#ff7518',
  'us-menu-custom-hover-text' => '#0a0410',
  'us-menu-custom-active-bg' => '#6a1b9a',
  'us-menu-custom-active-text' => '#f5e6d3',
  'us-menu-custom-divider' => '#3a1a4f',
  'us-menu-custom-submenu-border' => '#ff7518',

  'headings-color' => 'var(--bs-primary)',

  'custom_css' => "
/* === SPOOKY OCTOBER === pumpkin night */
:root { color-scheme: dark; }
body {
  background:
    radial-gradient(ellipse at top, rgba(106, 27, 154, 0.35) 0%, transparent 50%),
    radial-gradient(ellipse at bottom right, rgba(255, 117, 24, 0.18) 0%, transparent 50%),
    #1a0a1f fixed;
  min-height: 100vh;
}
h1, h2, h3, .h1, .h2, .h3 {
  font-weight: 700;
  letter-spacing: 0.02em;
  text-shadow: 0 0 10px rgba(255, 117, 24, 0.4);
}
.card {
  background-color: rgba(44, 20, 49, 0.85);
  border: 1px solid #3a1a4f;
  border-left: 3px solid #ff7518;
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.5);
  color: #f5e6d3;
}
.card-header {
  background: linear-gradient(90deg, #6a1b9a, #ff7518);
  color: #f5e6d3 !important;
  border-bottom: none;
  font-weight: 700;
  letter-spacing: 0.04em;
  text-transform: uppercase;
}
.btn-primary {
  box-shadow: 0 0 12px rgba(255, 117, 24, 0.5);
}
.btn-secondary {
  box-shadow: 0 0 12px rgba(106, 27, 154, 0.5);
}
.form-control, .form-select, textarea.form-control {
  color: #f5e6d3 !important;
  border: 1px solid #3a1a4f !important;
}
.form-control:focus, .form-select:focus {
  background-color: #2c1431 !important;
  color: #f5e6d3 !important;
  border-color: #ff7518 !important;
  box-shadow: 0 0 0 0.2rem rgba(255, 117, 24, 0.3) !important;
}
/* native <select> dropdown list inherits these */
.form-select option, .form-control option { background-color: #2c1431; color: #f5e6d3; }
.table {
  --bs-table-color: #f5e6d3;
  --bs-table-bg: transparent;
  --bs-table-border-color: #3a1a4f;
  --bs-table-striped-bg: rgba(255, 117, 24, 0.06);
  --bs-table-hover-bg: rgba(106, 27, 154, 0.18);
}
.modal-content {
  background-color: #2c1431;
  border: 2px solid #ff7518;
  color: #f5e6d3;
  box-shadow: 0 0 28px rgba(255, 117, 24, 0.35);
}
a:not(.btn):not(.nav-link) { color: #ffd54f; }
a:not(.btn):not(.nav-link):hover { color: #ff7518; text-shadow: 0 0 8px rgba(255, 117, 24, 0.6); }
",
);
