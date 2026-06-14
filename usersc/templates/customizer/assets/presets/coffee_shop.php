<?php
/**
 * Preset: Coffee Shop
 * Category: Themed
 * Description: Terracotta, warm brown, sage, cream. Cozy commerce.
 * Tags: light, thematic, warm, cozy, commerce
 * Mode: light
 * Author: UserSpice Customizer Theme
 */
return array (
  'primary' => '#8d6e63',
  'primary-hover' => '#6f5749',
  'primary-text-emphasis' => '#3e2723',
  'primary-bg-subtle' => '#eee2dc',
  'primary-border-subtle' => '#c9b5ac',

  'secondary' => '#d34215',
  'secondary-hover' => '#b3340f',
  'secondary-text-emphasis' => '#5e1c07',
  'secondary-bg-subtle' => '#fadcd2',
  'secondary-border-subtle' => '#ed9a82',

  'success' => '#689f38',
  'success-hover' => '#558b2f',
  'success-text-emphasis' => '#2f4d18',
  'success-bg-subtle' => '#e3eed4',
  'success-border-subtle' => '#a8c98a',

  'info' => '#7986cb',
  'info-hover' => '#5c6bbc',
  'info-text-emphasis' => '#2d3559',
  'info-bg-subtle' => '#e1e4f3',
  'info-border-subtle' => '#a8b1de',

  'warning' => '#ffa726',
  'warning-hover' => '#f59100',
  'warning-text-emphasis' => '#6e4309',
  'warning-bg-subtle' => '#ffeacd',
  'warning-border-subtle' => '#ffc97f',

  'danger' => '#c62828',
  'danger-hover' => '#a02121',
  'danger-text-emphasis' => '#5a1212',
  'danger-bg-subtle' => '#f5d2d2',
  'danger-border-subtle' => '#e08c8c',

  'light' => '#efe5d4',
  'light-hover' => '#dfd1ba',
  'light-text-emphasis' => '#3e2723',
  'light-bg-subtle' => '#f5ede0',
  'light-border-subtle' => '#d4c4a8',

  'dark' => '#2e1a14',
  'dark-hover' => '#21120e',
  'dark-text-emphasis' => '#160a07',
  'dark-bg-subtle' => '#a08c84',
  'dark-border-subtle' => '#5e3c30',

  'body-color' => '#3e2723',
  'body-bg' => '#f5ede0',
  'border-color' => '#d4c4a8',
  'form-control-bg' => '#fdf9f0',

  'us-menu-custom-bg' => '#2e1a14',
  'us-menu-custom-text' => '#efe5d4',
  'us-menu-custom-hover-bg' => '#8d6e63',
  'us-menu-custom-hover-text' => '#ffffff',
  'us-menu-custom-active-bg' => '#d84315',
  'us-menu-custom-active-text' => '#ffffff',
  'us-menu-custom-divider' => '#5e3c30',
  'us-menu-custom-submenu-border' => '#8d6e63',

  'font-sans-serif' => 'Georgia, \"Times New Roman\", Times, serif',
  'headings-color' => 'var(--bs-dark)',

  'custom_css' => "
/* === COFFEE SHOP === cozy, serif-touched, terracotta */
body { font-family: Georgia, 'Times New Roman', Times, serif; }
h1, h2, h3, .h1, .h2, .h3 {
  font-family: Georgia, 'Times New Roman', Times, serif;
  font-style: italic;
  font-weight: 600;
}
.card {
  background-color: #fdf9f0;
  border: 1px solid #d4c4a8;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(62, 39, 35, 0.07);
}
.card-header {
  background-color: #efe5d4;
  border-bottom: 1px solid #d4c4a8;
  color: #3e2723;
  font-weight: 600;
  font-style: italic;
}
.btn {
  font-family: Georgia, serif;
  border-radius: 4px;
  font-weight: 600;
}
.btn-primary {
  background-color: #8d6e63;
  border-color: #8d6e63;
}
.form-control, .form-select {
  border: 1px solid #d4c4a8 !important;
  background-color: #fdf9f0 !important;
}
.form-control:focus, .form-select:focus {
  border-color: #8d6e63 !important;
  box-shadow: 0 0 0 0.18rem rgba(141, 110, 99, 0.2) !important;
}
.table {
  --bs-table-border-color: #d4c4a8;
  --bs-table-striped-bg: #efe5d4;
}
.alert { border-radius: 6px; }
",
);
