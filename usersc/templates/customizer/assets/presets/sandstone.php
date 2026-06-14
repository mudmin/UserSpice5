<?php
/**
 * Preset: Sandstone
 * Category: Clean
 * Description: Warm light neutral — taupe and cream with a muted terracotta accent.
 * Tags: light, professional, warm, neutral, earthy
 * Mode: light
 * Author: UserSpice Customizer Theme
 */
return array (
  'primary' => '#a8633c',
  'primary-hover' => '#8d5230',
  'primary-text-emphasis' => '#5c3621',
  'primary-bg-subtle' => '#f0e0d3',
  'primary-border-subtle' => '#d9b196',

  'secondary' => '#82735e',
  'secondary-hover' => '#6f6250',
  'secondary-text-emphasis' => '#463e32',
  'secondary-bg-subtle' => '#ebe5db',
  'secondary-border-subtle' => '#cbc0ac',

  'success' => '#6d7b3e',
  'success-hover' => '#5a6633',
  'success-text-emphasis' => '#3a4221',
  'success-bg-subtle' => '#e7ead5',
  'success-border-subtle' => '#c2c897',

  'info' => '#5c7988',
  'info-hover' => '#4d6671',
  'info-text-emphasis' => '#313f47',
  'info-bg-subtle' => '#e0e8eb',
  'info-border-subtle' => '#b3c5cc',

  'warning' => '#c08a2e',
  'warning-hover' => '#a07325',
  'warning-text-emphasis' => '#5e4416',
  'warning-bg-subtle' => '#f5e8cd',
  'warning-border-subtle' => '#e3c587',

  'danger' => '#a8412f',
  'danger-hover' => '#8a3527',
  'danger-text-emphasis' => '#561f17',
  'danger-bg-subtle' => '#f1d7d1',
  'danger-border-subtle' => '#d69e93',

  'light' => '#f0e9dd',
  'light-hover' => '#e2d8c5',
  'light-text-emphasis' => '#4a4336',
  'light-bg-subtle' => '#faf6f0',
  'light-border-subtle' => '#e2d8c5',

  'dark' => '#2e2920',
  'dark-hover' => '#423b2e',
  'dark-text-emphasis' => '#16130d',
  'dark-bg-subtle' => '#c4bcaa',
  'dark-border-subtle' => '#6e6452',

  'body-color' => '#3a3128',
  'body-bg' => '#faf6f0',
  'border-color' => '#e0d6c4',
  'form-control-bg' => '#ffffff',

  'secondary-color' => '#71634d',
  'tertiary-color' => '#ab9d86',
  'emphasis-color' => '#221c14',
  'secondary-bg' => '#efe8db',
  'tertiary-bg' => '#f6f1e7',

  'us-menu-custom-bg' => '#2e2920',
  'us-menu-custom-text' => '#ddd3c0',
  'us-menu-custom-hover-bg' => '#423b2e',
  'us-menu-custom-hover-text' => '#ffffff',
  'us-menu-custom-active-bg' => '#a8633c',
  'us-menu-custom-active-text' => '#ffffff',
  'us-menu-custom-divider' => '#423b2e',
  'us-menu-custom-submenu-border' => '#423b2e',

  'headings-color' => 'var(--bs-dark)',

  'custom_css' => "
/* === SANDSTONE === warm light neutral */
.card {
  background-color: #ffffff;
  border: 1px solid #e0d6c4;
  box-shadow: 0 1px 3px rgba(58, 49, 40, 0.06);
}
.card-header {
  background-color: #f0e9dd;
  border-bottom: 1px solid #e0d6c4;
  font-weight: 600;
  color: #3a3128;
}
.btn-primary { font-weight: 500; }
.form-control:focus, .form-select:focus {
  border-color: #a8633c !important;
  box-shadow: 0 0 0 3px rgba(168, 99, 60, 0.15) !important;
}
.table {
  --bs-table-border-color: #e0d6c4;
  --bs-table-striped-bg: #f5f0e6;
}
hr { border-color: #e0d6c4; }
a:not(.btn):not(.nav-link) { color: #a8633c; }
a:not(.btn):not(.nav-link):hover { color: #8d5230; }
",
);
