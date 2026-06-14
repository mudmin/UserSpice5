<?php
/**
 * Preset: Winter Frost
 * Category: Themed
 * Description: Crisp and cold — pale ice-blue, silver, and frost-white. The cool seasonal pair to Autumn Harvest.
 * Tags: light, thematic, seasonal, winter, cool
 * Mode: light
 * Author: UserSpice Customizer Theme
 */
return array (
  'primary' => '#5f9bbe',
  'primary-hover' => '#3c7499',
  'primary-text-emphasis' => '#234657',
  'primary-bg-subtle' => '#dce9f0',
  'primary-border-subtle' => '#a8cbdd',

  'secondary' => '#8097a6',
  'secondary-hover' => '#657a88',
  'secondary-text-emphasis' => '#3f4d57',
  'secondary-bg-subtle' => '#e6ebef',
  'secondary-border-subtle' => '#c3ced5',

  'success' => '#51a192',
  'success-hover' => '#3c8073',
  'success-text-emphasis' => '#234c44',
  'success-bg-subtle' => '#dcefeb',
  'success-border-subtle' => '#a8d4cc',

  'info' => '#5b9bd5',
  'info-hover' => '#4a80b0',
  'info-text-emphasis' => '#2c4d6b',
  'info-bg-subtle' => '#dfecf7',
  'info-border-subtle' => '#b1cfe9',

  'warning' => '#c89a4a',
  'warning-hover' => '#a87f3c',
  'warning-text-emphasis' => '#5e4920',
  'warning-bg-subtle' => '#f3e8d2',
  'warning-border-subtle' => '#e1c896',

  'danger' => '#b5485b',
  'danger-hover' => '#963b4b',
  'danger-text-emphasis' => '#5a242e',
  'danger-bg-subtle' => '#f1dadf',
  'danger-border-subtle' => '#dca6b0',

  'light' => '#e8f0f5',
  'light-hover' => '#d6e3ea',
  'light-text-emphasis' => '#3b474f',
  'light-bg-subtle' => '#f4f8fb',
  'light-border-subtle' => '#d6e3ea',

  'dark' => '#1f2d38',
  'dark-hover' => '#2e404e',
  'dark-text-emphasis' => '#0d141a',
  'dark-bg-subtle' => '#b5c2cb',
  'dark-border-subtle' => '#5a6f7d',

  'body-color' => '#2b3a47',
  'body-bg' => '#f4f8fb',
  'border-color' => '#d2e0e8',
  'form-control-bg' => '#ffffff',

  'secondary-color' => '#5b6a76',
  'tertiary-color' => '#9aacb7',
  'emphasis-color' => '#16222b',
  'secondary-bg' => '#e4edf2',
  'tertiary-bg' => '#eff5f8',

  'us-menu-custom-bg' => '#1f2d38',
  'us-menu-custom-text' => '#cddae2',
  'us-menu-custom-hover-bg' => '#2e404e',
  'us-menu-custom-hover-text' => '#ffffff',
  'us-menu-custom-active-bg' => '#4a8db5',
  'us-menu-custom-active-text' => '#ffffff',
  'us-menu-custom-divider' => '#2e404e',
  'us-menu-custom-submenu-border' => '#2e404e',

  'headings-color' => 'var(--bs-primary)',

  'custom_css' => "
/* === WINTER FROST === cool pale, crisp */
body {
  background-color: #f4f8fb;
  background-image:
    radial-gradient(circle at 20% 12%, rgba(255, 255, 255, 0.9) 0%, transparent 38%),
    radial-gradient(circle at 82% 8%, rgba(214, 232, 242, 0.55) 0%, transparent 42%);
}
.card {
  background-color: #ffffff;
  border: 1px solid #d2e0e8;
  border-top: 3px solid #4a8db5;
  border-radius: 8px;
  box-shadow: 0 4px 14px rgba(43, 58, 71, 0.07);
}
.card-header {
  background-color: #e8f0f5;
  border-bottom: 1px solid #d2e0e8;
  color: #2b3a47;
  font-weight: 600;
  border-radius: 8px 8px 0 0 !important;
}
.btn { border-radius: 6px; font-weight: 500; }
.form-control, .form-select {
  border-radius: 6px;
  border: 1px solid #d2e0e8 !important;
}
.form-control:focus, .form-select:focus {
  border-color: #4a8db5 !important;
  box-shadow: 0 0 0 0.2rem rgba(74, 141, 181, 0.2) !important;
}
.table {
  --bs-table-border-color: #d2e0e8;
  --bs-table-striped-bg: #eef4f8;
}
.alert { border-radius: 8px; }
hr { border-color: #d2e0e8; }
a:not(.btn):not(.nav-link) { color: #3c7499; }
a:not(.btn):not(.nav-link):hover { color: #2b3a47; }
",
);
