<?php
/**
 * Preset: Gruvbox
 * Category: Clean
 * Description: Warm retro dev palette — cream text on warm charcoal, by Pavel Pertsev.
 * Tags: dark, developer, palette, retro, warm
 * Mode: dark
 * WCAG: marginal - faithful community palette; some button labels fall just under AA
 * Author: UserSpice Customizer Theme
 */
return array (
  'primary' => '#83a598',
  'primary-hover' => '#95b3a8',
  'primary-text-emphasis' => '#c5d5cf',
  'primary-bg-subtle' => '#2d3a37',
  'primary-border-subtle' => '#83a598',

  'secondary' => '#928374',
  'secondary-hover' => '#a39686',
  'secondary-text-emphasis' => '#c8bfb3',
  'secondary-bg-subtle' => '#3a3633',
  'secondary-border-subtle' => '#928374',

  'success' => '#b8bb26',
  'success-hover' => '#c5c84a',
  'success-text-emphasis' => '#dde08f',
  'success-bg-subtle' => '#34370d',
  'success-border-subtle' => '#b8bb26',

  'info' => '#8ec07c',
  'info-hover' => '#a0cc91',
  'info-text-emphasis' => '#c8e0bf',
  'info-bg-subtle' => '#2c3a27',
  'info-border-subtle' => '#8ec07c',

  'warning' => '#fabd2f',
  'warning-hover' => '#fbc954',
  'warning-text-emphasis' => '#fde0a0',
  'warning-bg-subtle' => '#3d300a',
  'warning-border-subtle' => '#fabd2f',

  'danger' => '#fb4934',
  'danger-hover' => '#fc6553',
  'danger-text-emphasis' => '#fda99e',
  'danger-bg-subtle' => '#3d130d',
  'danger-border-subtle' => '#fb4934',

  'light' => '#3c3836',
  'light-hover' => '#504945',
  'light-text-emphasis' => '#ebdbb2',
  'light-bg-subtle' => '#32302f',
  'light-border-subtle' => '#504945',

  'dark' => '#1d2021',
  'dark-hover' => '#282828',
  'dark-text-emphasis' => '#0f1011',
  'dark-bg-subtle' => '#1d2021',
  'dark-border-subtle' => '#1d2021',

  'body-color' => '#ebdbb2',
  'body-bg' => '#282828',
  'border-color' => '#504945',
  'form-control-bg' => '#32302f',

  'secondary-color' => '#a89984',
  'tertiary-color' => '#7c6f64',
  'emphasis-color' => '#fbf1c7',
  'secondary-bg' => '#3c3836',
  'tertiary-bg' => '#32302f',

  'us-menu-custom-bg' => '#1d2021',
  'us-menu-custom-text' => '#d5c4a1',
  'us-menu-custom-hover-bg' => '#3c3836',
  'us-menu-custom-hover-text' => '#fabd2f',
  'us-menu-custom-active-bg' => '#fe8019',
  'us-menu-custom-active-text' => '#1d2021',
  'us-menu-custom-divider' => '#504945',
  'us-menu-custom-submenu-border' => '#504945',

  'headings-color' => 'inherit',

  'custom_css' => "
/* === GRUVBOX === warm retro dev palette */
:root { color-scheme: dark; }
.card {
  background-color: #32302f;
  border: 1px solid #504945;
}
.card-header {
  background-color: #3c3836;
  border-bottom: 1px solid #504945;
  color: #ebdbb2;
  font-weight: 600;
}
.form-control, .form-select, textarea.form-control {
  color: #ebdbb2 !important;
  border: 1px solid #504945 !important;
}
.form-control:focus, .form-select:focus {
  background-color: #32302f !important;
  color: #ebdbb2 !important;
  border-color: #83a598 !important;
  box-shadow: 0 0 0 0.2rem rgba(131, 165, 152, 0.25) !important;
}
/* native <select> dropdown list inherits these */
.form-select option, .form-control option { background-color: #32302f; color: #ebdbb2; }
.table {
  --bs-table-color: #ebdbb2;
  --bs-table-bg: transparent;
  --bs-table-border-color: #504945;
  --bs-table-striped-bg: rgba(235, 219, 178, 0.04);
  --bs-table-hover-bg: rgba(131, 165, 152, 0.10);
}
.modal-content {
  background-color: #32302f;
  border: 1px solid #504945;
  color: #ebdbb2;
}
code, pre, kbd {
  background-color: #1d2021;
  color: #fabd2f;
}
a:not(.btn):not(.nav-link) { color: #83a598; }
a:not(.btn):not(.nav-link):hover { color: #8ec07c; }
",
);
