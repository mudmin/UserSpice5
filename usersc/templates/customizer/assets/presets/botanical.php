<?php
/**
 * Preset: Botanical
 * Category: Themed
 * Description: Forest green, soft gold, cream. Refined nature, year-round.
 * Tags: light, thematic, nature, refined, green
 * Mode: light
 * Author: UserSpice Customizer Theme
 */
return array (
  'primary' => '#4a7c3a',
  'primary-hover' => '#3a6429',
  'primary-text-emphasis' => '#1e3318',
  'primary-bg-subtle' => '#dde7d4',
  'primary-border-subtle' => '#a5c098',

  'secondary' => '#c9a44c',
  'secondary-hover' => '#a88838',
  'secondary-text-emphasis' => '#5a481c',
  'secondary-bg-subtle' => '#f3ead0',
  'secondary-border-subtle' => '#e0c789',

  'success' => '#79995e',
  'success-hover' => '#557039',
  'success-text-emphasis' => '#2c3e1c',
  'success-bg-subtle' => '#e3edd5',
  'success-border-subtle' => '#b3c79a',

  'info' => '#75a373',
  'info-hover' => '#5e8b5b',
  'info-text-emphasis' => '#2e4a2e',
  'info-bg-subtle' => '#e5efe2',
  'info-border-subtle' => '#b8d0b5',

  'warning' => '#d4a017',
  'warning-hover' => '#b88813',
  'warning-text-emphasis' => '#5e470a',
  'warning-bg-subtle' => '#f8ecc4',
  'warning-border-subtle' => '#e6c971',

  'danger' => '#a04444',
  'danger-hover' => '#823636',
  'danger-text-emphasis' => '#4a1f1f',
  'danger-bg-subtle' => '#eed5d5',
  'danger-border-subtle' => '#d09f9f',

  'light' => '#eef0e6',
  'light-hover' => '#dfe2d4',
  'light-text-emphasis' => '#2d3e2d',
  'light-bg-subtle' => '#f9f7f1',
  'light-border-subtle' => '#d4cdb8',

  'dark' => '#1f2a1f',
  'dark-hover' => '#152015',
  'dark-text-emphasis' => '#0a140a',
  'dark-bg-subtle' => '#8a988a',
  'dark-border-subtle' => '#3a4a3a',

  'body-color' => '#2d3e2d',
  'body-bg' => '#f9f7f1',
  'border-color' => '#d4cdb8',
  'form-control-bg' => '#ffffff',

  'us-menu-custom-bg' => '#1f2a1f',
  'us-menu-custom-text' => '#eef0e6',
  'us-menu-custom-hover-bg' => '#4a7c3a',
  'us-menu-custom-hover-text' => '#ffffff',
  'us-menu-custom-active-bg' => '#c9a44c',
  'us-menu-custom-active-text' => '#1f2a1f',
  'us-menu-custom-divider' => '#3a4a3a',
  'us-menu-custom-submenu-border' => '#4a7c3a',

  'font-sans-serif' => '\"Iowan Old Style\", \"Palatino Linotype\", Palatino, Georgia, serif',
  'headings-color' => 'var(--bs-dark)',

  'custom_css' => "
/* === BOTANICAL === refined nature, gold accents */
body {
  font-family: 'Iowan Old Style', 'Palatino Linotype', Palatino, Georgia, serif;
  line-height: 1.65;
}
h1, h2, h3, .h1, .h2, .h3 {
  font-family: 'Iowan Old Style', 'Palatino Linotype', Palatino, Georgia, serif;
  font-weight: 600;
}
h1::after, .h1::after {
  content: '';
  display: block;
  width: 60px;
  height: 2px;
  background-color: #c9a44c;
  margin-top: 0.5rem;
}
.card {
  background-color: #ffffff;
  border: 1px solid #d4cdb8;
  border-radius: 4px;
  box-shadow: 0 2px 4px rgba(45, 62, 45, 0.06);
}
.card-header {
  background-color: #f9f7f1;
  border-bottom: 1px solid #c9a44c;
  color: #1f2a1f;
  font-weight: 600;
  letter-spacing: 0.04em;
}
.btn {
  border-radius: 3px;
  font-weight: 500;
  letter-spacing: 0.03em;
}
.btn-primary { border-bottom: 2px solid #1e3318; }
.btn-secondary { border-bottom: 2px solid #5a481c; }
.form-control, .form-select {
  border: 1px solid #d4cdb8 !important;
  border-radius: 3px;
}
.form-control:focus, .form-select:focus {
  border-color: #4a7c3a !important;
  box-shadow: 0 0 0 0.18rem rgba(74, 124, 58, 0.18) !important;
}
.table {
  --bs-table-border-color: #d4cdb8;
  --bs-table-striped-bg: #f9f7f1;
}
hr { border-color: #c9a44c; border-width: 1px 0 0 0; opacity: 0.5; }
.alert { border-radius: 4px; border-left: 4px solid; }
",
);
