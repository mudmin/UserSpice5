<?php
/**
 * Preset: Autumn Harvest
 * Category: Themed
 * Description: Orange, mustard, burnt umber, cream. Warm and crunchy.
 * Tags: light, thematic, seasonal, autumn, warm
 * Mode: light
 * Author: UserSpice Customizer Theme
 */
return array (
  'primary' => '#d97706',
  'primary-hover' => '#b45309',
  'primary-text-emphasis' => '#5e2e02',
  'primary-bg-subtle' => '#fbeed4',
  'primary-border-subtle' => '#f0c98a',

  'secondary' => '#92400e',
  'secondary-hover' => '#7a3409',
  'secondary-text-emphasis' => '#3d1a04',
  'secondary-bg-subtle' => '#f0e1d0',
  'secondary-border-subtle' => '#c79370',

  'success' => '#65a30d',
  'success-hover' => '#4d7c0f',
  'success-text-emphasis' => '#2a4604',
  'success-bg-subtle' => '#e8f3d0',
  'success-border-subtle' => '#b8d680',

  'info' => '#b45309',
  'info-hover' => '#92400e',
  'info-text-emphasis' => '#4a2304',
  'info-bg-subtle' => '#f5e2c8',
  'info-border-subtle' => '#deb78a',

  'warning' => '#ca8a04',
  'warning-hover' => '#a16207',
  'warning-text-emphasis' => '#4d3002',
  'warning-bg-subtle' => '#fbeec0',
  'warning-border-subtle' => '#e6c763',

  'danger' => '#b91c1c',
  'danger-hover' => '#991b1b',
  'danger-text-emphasis' => '#5e0808',
  'danger-bg-subtle' => '#f6d3d3',
  'danger-border-subtle' => '#e09090',

  'light' => '#fef3c7',
  'light-hover' => '#f8e9b5',
  'light-text-emphasis' => '#3a2818',
  'light-bg-subtle' => '#fdf6ec',
  'light-border-subtle' => '#f0deaa',

  'dark' => '#1c1917',
  'dark-hover' => '#292524',
  'dark-text-emphasis' => '#0a0a0a',
  'dark-bg-subtle' => '#a8a29e',
  'dark-border-subtle' => '#57534e',

  'body-color' => '#3a2818',
  'body-bg' => '#fdf6ec',
  'border-color' => '#e6d4b8',
  'form-control-bg' => '#fffaf0',

  'us-menu-custom-bg' => '#3a2818',
  'us-menu-custom-text' => '#fbeed4',
  'us-menu-custom-hover-bg' => '#d97706',
  'us-menu-custom-hover-text' => '#ffffff',
  'us-menu-custom-active-bg' => '#92400e',
  'us-menu-custom-active-text' => '#fdf6ec',
  'us-menu-custom-divider' => '#5c4226',
  'us-menu-custom-submenu-border' => '#92400e',

  'headings-color' => 'var(--bs-secondary)',

  'custom_css' => "
/* === AUTUMN HARVEST === warm, crunchy, gold-edged */
.card {
  background-color: #fffaf0;
  border: 1px solid #e6d4b8;
  border-top: 3px solid #d97706;
  border-radius: 6px;
  box-shadow: 0 2px 6px rgba(92, 66, 38, 0.08);
}
.card-header {
  background-color: #fbeed4;
  border-bottom: 1px solid #e6d4b8;
  color: #92400e;
  font-weight: 600;
  letter-spacing: 0.02em;
}
.btn {
  border-radius: 6px;
  font-weight: 600;
  letter-spacing: 0.02em;
}
.form-control, .form-select {
  border: 1px solid #e6d4b8 !important;
  border-radius: 6px;
}
.form-control:focus, .form-select:focus {
  border-color: #d97706 !important;
  box-shadow: 0 0 0 0.18rem rgba(217, 119, 6, 0.2) !important;
}
.table {
  --bs-table-color: #3a2818;
  --bs-table-border-color: #e6d4b8;
  --bs-table-striped-bg: #fbeed4;
  --bs-table-hover-bg: rgba(217, 119, 6, 0.08);
}
.alert { border-left: 4px solid; border-radius: 4px; }
.badge { border-radius: 4px; }
hr { border-color: #e6d4b8; }
",
);
