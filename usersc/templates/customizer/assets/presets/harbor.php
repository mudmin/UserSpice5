<?php
/**
 * Preset: Harbor
 * Category: Clean
 * Description: Calm cool-blue professional — teal accent on a soft cool-white page.
 * Tags: light, professional, corporate, blue, calm
 * Mode: light
 * Author: UserSpice Customizer Theme
 */
return array (
  'primary' => '#0e7490',
  'primary-hover' => '#0c5e74',
  'primary-text-emphasis' => '#0a4456',
  'primary-bg-subtle' => '#d4eef4',
  'primary-border-subtle' => '#9bd3e0',

  'secondary' => '#5a7682',
  'secondary-hover' => '#495f6a',
  'secondary-text-emphasis' => '#2e3d44',
  'secondary-bg-subtle' => '#e3e9ec',
  'secondary-border-subtle' => '#c0ccd1',

  'success' => '#0f766e',
  'success-hover' => '#0c5e58',
  'success-text-emphasis' => '#0a443f',
  'success-bg-subtle' => '#d2ece9',
  'success-border-subtle' => '#97cfc9',

  'info' => '#027bba',
  'info-hover' => '#026da3',
  'info-text-emphasis' => '#024d73',
  'info-bg-subtle' => '#d4ecf8',
  'info-border-subtle' => '#9bd2ee',

  'warning' => '#b45309',
  'warning-hover' => '#934307',
  'warning-text-emphasis' => '#5c2b05',
  'warning-bg-subtle' => '#f6e6d4',
  'warning-border-subtle' => '#e3bd92',

  'danger' => '#be123c',
  'danger-hover' => '#9c0f31',
  'danger-text-emphasis' => '#6b0a22',
  'danger-bg-subtle' => '#f7d6de',
  'danger-border-subtle' => '#ea9aac',

  'light' => '#eef4f6',
  'light-hover' => '#dde8eb',
  'light-text-emphasis' => '#3d4a4e',
  'light-bg-subtle' => '#f6f9fb',
  'light-border-subtle' => '#dde8eb',

  'dark' => '#102a33',
  'dark-hover' => '#1c3c47',
  'dark-text-emphasis' => '#081519',
  'dark-bg-subtle' => '#b8c8ce',
  'dark-border-subtle' => '#5e757e',

  'body-color' => '#1c2e36',
  'body-bg' => '#f6f9fb',
  'border-color' => '#d4e0e5',
  'form-control-bg' => '#ffffff',

  'secondary-color' => '#5a7682',
  'tertiary-color' => '#92a8b0',
  'emphasis-color' => '#0c1f26',
  'secondary-bg' => '#e6eef1',
  'tertiary-bg' => '#f1f6f8',

  'us-menu-custom-bg' => '#102a33',
  'us-menu-custom-text' => '#cfdde2',
  'us-menu-custom-hover-bg' => '#1c3c47',
  'us-menu-custom-hover-text' => '#ffffff',
  'us-menu-custom-active-bg' => '#0e7490',
  'us-menu-custom-active-text' => '#ffffff',
  'us-menu-custom-divider' => '#1c3c47',
  'us-menu-custom-submenu-border' => '#1c3c47',

  'headings-color' => 'var(--bs-dark)',

  'custom_css' => "
/* === HARBOR === clean cool-blue professional */
.card {
  border: 1px solid #d4e0e5;
  box-shadow: 0 1px 2px rgba(16, 42, 51, 0.05), 0 1px 3px rgba(16, 42, 51, 0.06);
  background-color: #ffffff;
}
.card-header {
  background-color: #eef4f6;
  border-bottom: 1px solid #d4e0e5;
  font-weight: 600;
}
.btn-primary { font-weight: 500; }
.form-control:focus, .form-select:focus {
  border-color: #0e7490 !important;
  box-shadow: 0 0 0 3px rgba(14, 116, 144, 0.15) !important;
}
.table {
  --bs-table-border-color: #d4e0e5;
  --bs-table-striped-bg: #eef4f6;
}
.navbar { box-shadow: 0 1px 3px rgba(16, 42, 51, 0.06); }
a:not(.btn):not(.nav-link) { color: #0e7490; }
a:not(.btn):not(.nav-link):hover { color: #0c5e74; }
",
);
