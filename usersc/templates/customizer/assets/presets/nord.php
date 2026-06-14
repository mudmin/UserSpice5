<?php
/**
 * Preset: Nord
 * Category: Clean
 * Description: Arctic, north-bluish color palette by Arctic Ice Studio. Calm and balanced.
 * Tags: dark, developer, palette, arctic, balanced
 * Mode: dark
 * WCAG: marginal - faithful community palette; some button labels fall just under AA
 * Author: UserSpice Customizer Theme
 */
return array (
  'primary' => '#88c0d0',
  'primary-hover' => '#a3d0dc',
  'primary-text-emphasis' => '#c8e0e8',
  'primary-bg-subtle' => '#2a3a44',
  'primary-border-subtle' => '#88c0d0',

  'secondary' => '#81a1c1',
  'secondary-hover' => '#95b1cd',
  'secondary-text-emphasis' => '#c1d1dd',
  'secondary-bg-subtle' => '#2c3a47',
  'secondary-border-subtle' => '#81a1c1',

  'success' => '#a3be8c',
  'success-hover' => '#b3caa0',
  'success-text-emphasis' => '#d3deca',
  'success-bg-subtle' => '#2e3a2e',
  'success-border-subtle' => '#a3be8c',

  'info' => '#8fbcbb',
  'info-hover' => '#a3c8c7',
  'info-text-emphasis' => '#cae0df',
  'info-bg-subtle' => '#2c3a3a',
  'info-border-subtle' => '#8fbcbb',

  'warning' => '#ebcb8b',
  'warning-hover' => '#efd5a3',
  'warning-text-emphasis' => '#f5e5c5',
  'warning-bg-subtle' => '#3a3326',
  'warning-border-subtle' => '#ebcb8b',

  'danger' => '#bf616a',
  'danger-hover' => '#cb7882',
  'danger-text-emphasis' => '#dfaab0',
  'danger-bg-subtle' => '#3a2329',
  'danger-border-subtle' => '#bf616a',

  'light' => '#d8dee9',
  'light-hover' => '#c0c8d6',
  'light-text-emphasis' => '#2e3440',
  'light-bg-subtle' => '#eceff4',
  'light-border-subtle' => '#d8dee9',

  'dark' => '#2e3440',
  'dark-hover' => '#3b4252',
  'dark-text-emphasis' => '#191c25',
  'dark-bg-subtle' => '#3b4252',
  'dark-border-subtle' => '#4c566a',

  'body-color' => '#eceff4',
  'body-bg' => '#2e3440',
  'border-color' => '#4c566a',
  'form-control-bg' => '#3b4252',

  'secondary-color' => '#abb4c4',
  'tertiary-color' => '#7b8494',
  'emphasis-color' => '#ffffff',
  'secondary-bg' => '#3b4252',
  'tertiary-bg' => '#353b48',

  'us-menu-custom-bg' => '#2e3440',
  'us-menu-custom-text' => '#d8dee9',
  'us-menu-custom-hover-bg' => '#434c5e',
  'us-menu-custom-hover-text' => '#eceff4',
  'us-menu-custom-active-bg' => '#88c0d0',
  'us-menu-custom-active-text' => '#2e3440',
  'us-menu-custom-divider' => '#434c5e',
  'us-menu-custom-submenu-border' => '#4c566a',

  'headings-color' => 'var(--bs-light)',

  'custom_css' => "
/* === NORD === Arctic Ice Studio palette */
:root { color-scheme: dark; }
.card {
  background-color: #3b4252;
  border: 1px solid #434c5e;
}
.card-header {
  background-color: #434c5e;
  border-bottom: 1px solid #4c566a;
  color: #eceff4;
  font-weight: 600;
}
.form-control, .form-select, textarea.form-control {
  color: #eceff4 !important;
  border: 1px solid #4c566a !important;
}
.form-control:focus, .form-select:focus {
  background-color: #3b4252 !important;
  color: #eceff4 !important;
  border-color: #88c0d0 !important;
  box-shadow: 0 0 0 0.2rem rgba(136, 192, 208, 0.25) !important;
}
/* native <select> dropdown list inherits these */
.form-select option, .form-control option { background-color: #3b4252; color: #eceff4; }
.table {
  --bs-table-color: #eceff4;
  --bs-table-bg: transparent;
  --bs-table-border-color: #4c566a;
  --bs-table-striped-bg: rgba(216, 222, 233, 0.04);
  --bs-table-hover-bg: rgba(136, 192, 208, 0.12);
}
.modal-content {
  background-color: #3b4252;
  border: 1px solid #4c566a;
  color: #eceff4;
}
code, pre, kbd {
  background-color: #434c5e;
  color: #88c0d0;
}
a:not(.btn):not(.nav-link) { color: #88c0d0; }
a:not(.btn):not(.nav-link):hover { color: #a3d0dc; }
",
);
