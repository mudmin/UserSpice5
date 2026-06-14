<?php
/**
 * Preset: Synthwave
 * Category: Wild
 * Description: Neon pink and cyan on deep purple — Miami Vice in 2087.
 * Tags: dark, expressive, retro, neon, 80s
 * Mode: dark
 * Author: UserSpice Customizer Theme
 */
return array (
  'primary' => '#ff2e9a',
  'primary-hover' => '#ff5cb0',
  'primary-text-emphasis' => '#ffb3dc',
  'primary-bg-subtle' => '#3a0a26',
  'primary-border-subtle' => '#ff2e9a',

  'secondary' => '#00f0ff',
  'secondary-hover' => '#5cf6ff',
  'secondary-text-emphasis' => '#b3f9ff',
  'secondary-bg-subtle' => '#0a3a3f',
  'secondary-border-subtle' => '#00f0ff',

  'success' => '#39ff14',
  'success-hover' => '#5cff42',
  'success-text-emphasis' => '#c4ffb3',
  'success-bg-subtle' => '#0d3a05',
  'success-border-subtle' => '#39ff14',

  'info' => '#00d9ff',
  'info-hover' => '#5ce4ff',
  'info-text-emphasis' => '#b3f1ff',
  'info-bg-subtle' => '#08323d',
  'info-border-subtle' => '#00d9ff',

  'warning' => '#ffd700',
  'warning-hover' => '#ffe246',
  'warning-text-emphasis' => '#fff1a3',
  'warning-bg-subtle' => '#3d3200',
  'warning-border-subtle' => '#ffd700',

  'danger' => '#ff3864',
  'danger-hover' => '#ff638a',
  'danger-text-emphasis' => '#ffb8c8',
  'danger-bg-subtle' => '#3d0d1a',
  'danger-border-subtle' => '#ff3864',

  'light' => '#f5d4ff',
  'light-hover' => '#e1b8f0',
  'light-text-emphasis' => '#3d2a4d',
  'light-bg-subtle' => '#2d1b4e',
  'light-border-subtle' => '#f5d4ff',

  'dark' => '#0d001a',
  'dark-hover' => '#1f0a33',
  'dark-text-emphasis' => '#080011',
  'dark-bg-subtle' => '#1a0a33',
  'dark-border-subtle' => '#0d001a',

  'body-color' => '#f5d4ff',
  'body-bg' => '#1a0033',
  'border-color' => '#ff2e9a',
  'form-control-bg' => '#2d1b4e',

  'secondary-color' => '#c79bd6',
  'tertiary-color' => '#8f6aa0',
  'emphasis-color' => '#ffffff',
  'secondary-bg' => '#2d1b4e',
  'tertiary-bg' => '#241141',

  'us-menu-custom-bg' => '#0d001a',
  'us-menu-custom-text' => '#00f0ff',
  'us-menu-custom-hover-bg' => '#ff2e9a',
  'us-menu-custom-hover-text' => '#0d001a',
  'us-menu-custom-active-bg' => '#ff2e9a',
  'us-menu-custom-active-text' => '#0d001a',
  'us-menu-custom-divider' => 'rgba(255, 46, 154, 0.4)',
  'us-menu-custom-submenu-border' => '#00f0ff',

  'headings-color' => 'var(--bs-primary)',

  'custom_css' => "
/* === SYNTHWAVE === Miami Vice in 2087 */
:root { color-scheme: dark; }
body {
  background:
    linear-gradient(180deg, rgba(26, 0, 51, 0) 0%, rgba(26, 0, 51, 0.85) 50%, #1a0033 100%),
    linear-gradient(180deg, #ff2e9a 0%, #ff6f00 40%, #1a0033 70%) fixed;
  min-height: 100vh;
}
h1, h2, h3, .h1, .h2, .h3 {
  text-shadow: 0 0 4px rgba(255, 46, 154, 0.9), 0 0 12px rgba(255, 46, 154, 0.6), 0 0 24px rgba(0, 240, 255, 0.3);
  letter-spacing: 0.02em;
}
.card {
  background-color: rgba(13, 0, 26, 0.75) !important;
  backdrop-filter: blur(6px);
  border: 1px solid #ff2e9a;
  box-shadow: 0 0 18px rgba(255, 46, 154, 0.35), inset 0 0 24px rgba(0, 240, 255, 0.05);
  color: #f5d4ff;
}
.card-header {
  background: linear-gradient(90deg, #ff2e9a, #00f0ff) !important;
  color: #0d001a !important;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.08em;
}
.navbar, ul.us_menu.custom {
  border-bottom: 2px solid #ff2e9a !important;
  box-shadow: 0 4px 24px rgba(255, 46, 154, 0.5);
}
.btn-primary, .btn-secondary, .btn-success, .btn-info, .btn-warning, .btn-danger {
  border: none;
  box-shadow: 0 0 10px currentColor;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  font-weight: 600;
}
.btn-primary:hover, .btn-secondary:hover, .btn-success:hover,
.btn-info:hover, .btn-warning:hover, .btn-danger:hover {
  box-shadow: 0 0 18px currentColor, 0 0 32px currentColor;
  transform: translateY(-1px);
}
.form-control, .form-select, textarea.form-control {
  color: #00f0ff !important;
  border: 1px solid #ff2e9a !important;
  box-shadow: inset 0 0 6px rgba(0, 240, 255, 0.15);
}
.form-control:focus, .form-select:focus, textarea.form-control:focus {
  background-color: #2d1b4e !important;
  border-color: #00f0ff !important;
  box-shadow: 0 0 0 0.2rem rgba(0, 240, 255, 0.35), inset 0 0 8px rgba(255, 46, 154, 0.25) !important;
  color: #00f0ff !important;
}
/* native <select> dropdown list inherits these */
.form-select option, .form-control option { background-color: #2d1b4e; color: #00f0ff; }
.table {
  --bs-table-color: #f5d4ff;
  --bs-table-bg: transparent;
  --bs-table-border-color: rgba(255, 46, 154, 0.35);
  --bs-table-striped-bg: rgba(255, 46, 154, 0.08);
  --bs-table-hover-bg: rgba(0, 240, 255, 0.10);
}
a:not(.btn):not(.nav-link) {
  color: #00f0ff;
  text-decoration: none;
  transition: text-shadow 0.2s ease;
}
a:not(.btn):not(.nav-link):hover {
  color: #5cf6ff;
  text-shadow: 0 0 8px #00f0ff;
}
.modal-content {
  background-color: #0d001a;
  border: 1px solid #00f0ff;
  box-shadow: 0 0 30px rgba(0, 240, 255, 0.4);
}
",
);
