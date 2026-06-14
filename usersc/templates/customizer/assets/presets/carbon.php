<?php
/**
 * Preset: Carbon
 * Category: Clean
 * Description: True dark monochrome with a single electric-blue accent.
 * Tags: dark, professional, minimal, monochrome
 * Mode: dark
 * Author: UserSpice Customizer Theme
 */
return array (
  'primary' => '#00b4ff',
  'primary-hover' => '#33c4ff',
  'primary-text-emphasis' => '#99e0ff',
  'primary-bg-subtle' => '#0a1f2b',
  'primary-border-subtle' => '#00b4ff',

  'secondary' => '#6a6a6a',
  'secondary-hover' => '#808080',
  'secondary-text-emphasis' => '#bdbdbd',
  'secondary-bg-subtle' => '#1f1f1f',
  'secondary-border-subtle' => '#3a3a3a',

  'success' => '#00d97e',
  'success-hover' => '#1edf8e',
  'success-text-emphasis' => '#7be8b8',
  'success-bg-subtle' => '#06241a',
  'success-border-subtle' => '#00d97e',

  'info' => '#4ab8ff',
  'info-hover' => '#6dc4ff',
  'info-text-emphasis' => '#b6e0ff',
  'info-bg-subtle' => '#0c1f2d',
  'info-border-subtle' => '#4ab8ff',

  'warning' => '#f4b400',
  'warning-hover' => '#f7c233',
  'warning-text-emphasis' => '#ffdf80',
  'warning-bg-subtle' => '#2b2106',
  'warning-border-subtle' => '#f4b400',

  'danger' => '#e84545',
  'danger-hover' => '#ec6262',
  'danger-text-emphasis' => '#f7b1b1',
  'danger-bg-subtle' => '#2b0e0e',
  'danger-border-subtle' => '#e84545',

  'light' => '#1a1a1a',
  'light-hover' => '#252525',
  'light-text-emphasis' => '#e6e6e6',
  'light-bg-subtle' => '#141414',
  'light-border-subtle' => '#2a2a2a',

  'dark' => '#050505',
  'dark-hover' => '#0d0d0d',
  'dark-text-emphasis' => '#020202',
  'dark-bg-subtle' => '#0a0a0a',
  'dark-border-subtle' => '#050505',

  'body-color' => '#e6e6e6',
  'body-bg' => '#0a0a0a',
  'border-color' => '#2a2a2a',
  'form-control-bg' => '#141414',

  'secondary-color' => '#999999',
  'tertiary-color' => '#6e6e6e',
  'emphasis-color' => '#ffffff',
  'secondary-bg' => '#1a1a1a',
  'tertiary-bg' => '#141414',

  'us-menu-custom-bg' => '#050505',
  'us-menu-custom-text' => '#cccccc',
  'us-menu-custom-hover-bg' => '#1a1a1a',
  'us-menu-custom-hover-text' => '#00b4ff',
  'us-menu-custom-active-bg' => '#00b4ff',
  'us-menu-custom-active-text' => '#0a0a0a',
  'us-menu-custom-divider' => '#2a2a2a',
  'us-menu-custom-submenu-border' => '#2a2a2a',

  'headings-color' => 'inherit',

  'custom_css' => "
/* === CARBON === restrained dark, one accent */
:root { color-scheme: dark; }
.card {
  background-color: #141414;
  border: 1px solid #2a2a2a;
}
.card-header {
  background-color: #1a1a1a;
  border-bottom: 1px solid #2a2a2a;
  color: #e6e6e6;
}
.form-control, .form-select, textarea.form-control {
  color: #e6e6e6 !important;
  border: 1px solid #2a2a2a !important;
}
.form-control:focus, .form-select:focus {
  background-color: #141414 !important;
  color: #e6e6e6 !important;
  border-color: #00b4ff !important;
  box-shadow: 0 0 0 0.2rem rgba(0, 180, 255, 0.18) !important;
}
/* native <select> dropdown list inherits these */
.form-select option, .form-control option { background-color: #141414; color: #e6e6e6; }
.table {
  --bs-table-color: #e6e6e6;
  --bs-table-bg: transparent;
  --bs-table-border-color: #2a2a2a;
  --bs-table-striped-bg: rgba(255, 255, 255, 0.025);
  --bs-table-hover-bg: rgba(0, 180, 255, 0.08);
}
.modal-content {
  background-color: #141414;
  border: 1px solid #2a2a2a;
  color: #e6e6e6;
}
a:not(.btn):not(.nav-link) { color: #00b4ff; }
a:not(.btn):not(.nav-link):hover { color: #33c4ff; }
",
);
