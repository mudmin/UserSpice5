<?php
/**
 * Preset: Harbor Dark
 * Category: Clean
 * Description: Calm cool-blue professional, dark mode — teal accent on a deep navy-teal ground. Harbor at night.
 * Tags: dark, professional, corporate, blue, calm
 * Mode: dark
 * Author: UserSpice Customizer Theme
 */
return array (
  'primary' => '#0e7490',
  'primary-hover' => '#0c5e74',
  'primary-text-emphasis' => '#7dd3e8',
  'primary-bg-subtle' => '#052831',
  'primary-border-subtle' => '#0c5e74',

  'secondary' => '#5a7682',
  'secondary-hover' => '#495f6a',
  'secondary-text-emphasis' => '#b2c4cb',
  'secondary-bg-subtle' => '#1a2c33',
  'secondary-border-subtle' => '#495f6a',

  'success' => '#0f766e',
  'success-hover' => '#0c5e58',
  'success-text-emphasis' => '#5eead4',
  'success-bg-subtle' => '#042f2c',
  'success-border-subtle' => '#0c5e58',

  'info' => '#027bba',
  'info-hover' => '#026da3',
  'info-text-emphasis' => '#7cc4ec',
  'info-bg-subtle' => '#04293b',
  'info-border-subtle' => '#026da3',

  'warning' => '#b45309',
  'warning-hover' => '#934307',
  'warning-text-emphasis' => '#f5c073',
  'warning-bg-subtle' => '#2e1804',
  'warning-border-subtle' => '#934307',

  'danger' => '#be123c',
  'danger-hover' => '#9c0f31',
  'danger-text-emphasis' => '#f0809b',
  'danger-bg-subtle' => '#350611',
  'danger-border-subtle' => '#9c0f31',

  'light' => '#eef4f6',
  'light-hover' => '#dde8eb',
  'light-text-emphasis' => '#eef4f6',
  'light-bg-subtle' => '#1f3c46',
  'light-border-subtle' => '#2f5560',

  'dark' => '#102a33',
  'dark-hover' => '#1c3c47',
  'dark-text-emphasis' => '#cfdde2',
  'dark-bg-subtle' => '#0a1c22',
  'dark-border-subtle' => '#1f3c46',

  'body-color' => '#cddde2',
  'body-bg' => '#0d2027',
  'border-color' => '#1f3c46',
  'form-control-bg' => '#102a33',

  'secondary-color' => '#8fa8b0',
  'tertiary-color' => '#5f7d86',
  'emphasis-color' => '#eef6f9',
  'secondary-bg' => '#102a33',
  'tertiary-bg' => '#0f262d',

  'us-menu-custom-bg' => '#0a1c22',
  'us-menu-custom-text' => '#cfdde2',
  'us-menu-custom-hover-bg' => '#1c3c47',
  'us-menu-custom-hover-text' => '#ffffff',
  'us-menu-custom-active-bg' => '#0e7490',
  'us-menu-custom-active-text' => '#ffffff',
  'us-menu-custom-divider' => '#1c3c47',
  'us-menu-custom-submenu-border' => '#1c3c47',

  'headings-color' => '#eef6f9',

  'custom_css' => "
/* === HARBOR DARK === cool-blue professional, dark */
:root { color-scheme: dark; }
.form-select option, .form-control option { background-color: #102a33; color: #cddde2; }

.card { background-color: #102a33; border: 1px solid #1f3c46; color: #cddde2; box-shadow: 0 1px 2px rgba(0,0,0,0.35), 0 1px 3px rgba(0,0,0,0.45); }
.card-header, .card-footer { background-color: #0f262d; border-color: #1f3c46; color: #eef6f9; font-weight: 600; }

.btn-primary { font-weight: 500; }

.form-control, .form-select, textarea.form-control {
  background-color: #102a33 !important;
  border-color: #1f3c46 !important;
  color: #cddde2 !important;
}
.form-control:focus, .form-select:focus {
  border-color: #0e7490 !important;
  box-shadow: 0 0 0 3px rgba(14, 116, 144, 0.3) !important;
}
.form-control::placeholder { color: #8fa8b0; }

.dropdown-menu { background-color: #102a33; border-color: #1f3c46; color: #cddde2; }
.dropdown-item { color: #cddde2; }
.dropdown-item:hover, .dropdown-item:focus { background-color: #1f3c46; color: #eef6f9; }
.dropdown-divider { border-color: #1f3c46; }

.modal-content { background-color: #102a33; border: 1px solid #1f3c46; color: #cddde2; }
.modal-header, .modal-footer { border-color: #1f3c46; }

.list-group { background-color: transparent; }
.list-group-item { background-color: #102a33; border-color: #1f3c46; color: #cddde2; }
.list-group-item.active { background-color: #0e7490; border-color: #0e7490; color: #ffffff; }

.popover { background-color: #102a33; border-color: #1f3c46; }
.popover-header { background-color: #0f262d; border-bottom-color: #1f3c46; color: #eef6f9; }
.popover-body { color: #cddde2; }

.toast { background-color: #102a33; border-color: #1f3c46; color: #cddde2; }
.toast-header { background-color: #0f262d; border-bottom-color: #1f3c46; color: #eef6f9; }

.table {
  --bs-table-color: #cddde2;
  --bs-table-bg: transparent;
  --bs-table-border-color: #1f3c46;
  --bs-table-striped-bg: #0f262d;
  --bs-table-hover-bg: #1f3c46;
}

.navbar { box-shadow: 0 1px 3px rgba(0,0,0,0.45); }
a:not(.btn):not(.nav-link) { color: #4fc0dc; }
a:not(.btn):not(.nav-link):hover { color: #7dd3e8; }
",
);
