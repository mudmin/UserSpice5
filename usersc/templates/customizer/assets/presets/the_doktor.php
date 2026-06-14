<?php
/**
 * Preset: The Doktor
 * Category: Wild
 * Description: Dark-cherry cola — deep maroon, caramel and cream. 23 flavors, bottled.
 * Tags: dark, expressive, soda, cherry, caramel, fun
 * Mode: dark
 * Author: UserSpice Customizer Theme
 */
return array (
  'primary' => '#c5102b',
  'primary-hover' => '#e0233f',
  'primary-text-emphasis' => '#f7b9c0',
  'primary-bg-subtle' => '#3d0a10',
  'primary-border-subtle' => '#c5102b',

  'secondary' => '#c8842e',
  'secondary-hover' => '#dd9a44',
  'secondary-text-emphasis' => '#f0d2a0',
  'secondary-bg-subtle' => '#3a2a12',
  'secondary-border-subtle' => '#c8842e',

  'success' => '#4f8f3a',
  'success-hover' => '#62a84c',
  'success-text-emphasis' => '#c4e6b3',
  'success-bg-subtle' => '#1d3312',
  'success-border-subtle' => '#4f8f3a',

  'info' => '#8a4a9c',
  'info-hover' => '#a05fb2',
  'info-text-emphasis' => '#e0c2ea',
  'info-bg-subtle' => '#2e1535',
  'info-border-subtle' => '#8a4a9c',

  'warning' => '#e8a317',
  'warning-hover' => '#ffb733',
  'warning-text-emphasis' => '#ffe2a3',
  'warning-bg-subtle' => '#3d2e05',
  'warning-border-subtle' => '#e8a317',

  'danger' => '#e63950',
  'danger-hover' => '#ff5468',
  'danger-text-emphasis' => '#ffc0c8',
  'danger-bg-subtle' => '#3d0d14',
  'danger-border-subtle' => '#e63950',

  'light' => '#f4e6ce',
  'light-hover' => '#e4d4b8',
  'light-text-emphasis' => '#4a3a22',
  'light-bg-subtle' => '#3a2a12',
  'light-border-subtle' => '#f4e6ce',

  'dark' => '#1e0408',
  'dark-hover' => '#341017',
  'dark-text-emphasis' => '#120205',
  'dark-bg-subtle' => '#240609',
  'dark-border-subtle' => '#1e0408',

  'body-color' => '#f4e6ce',
  'body-bg' => '#3a0a12',
  'border-color' => '#7a2230',
  'form-control-bg' => '#4a1018',

  'secondary-color' => '#c7a98b',
  'tertiary-color' => '#9a7e63',
  'emphasis-color' => '#fff6e6',
  'secondary-bg' => '#4a1018',
  'tertiary-bg' => '#420d14',

  'us-menu-custom-bg' => '#1e0408',
  'us-menu-custom-text' => '#f4e6ce',
  'us-menu-custom-hover-bg' => '#c5102b',
  'us-menu-custom-hover-text' => '#fff6e6',
  'us-menu-custom-active-bg' => '#c8842e',
  'us-menu-custom-active-text' => '#1e0408',
  'us-menu-custom-divider' => 'rgba(200, 132, 46, 0.4)',
  'us-menu-custom-submenu-border' => '#c5102b',

  'headings-color' => '#f4e6ce',

  'custom_css' => "
/* === THE DOKTOR === 23 flavors of dark-cherry cola, bottled. */
body {
  background:
    radial-gradient(circle at 18% 12%, rgba(197, 16, 43, 0.55) 0%, rgba(197, 16, 43, 0) 38%),
    radial-gradient(circle at 85% 80%, rgba(200, 132, 46, 0.40) 0%, rgba(200, 132, 46, 0) 42%),
    linear-gradient(180deg, #4a0d16 0%, #3a0a12 55%, #240609 100%) fixed;
  min-height: 100vh;
}
/* fizzing soda bubbles drifting up behind everything */
body::before {
  content: '';
  position: fixed;
  inset: 0;
  pointer-events: none;
  z-index: 0;
  background-image:
    radial-gradient(circle, rgba(244, 230, 206, 0.55) 2px, transparent 3px),
    radial-gradient(circle, rgba(244, 230, 206, 0.32) 3px, transparent 4px),
    radial-gradient(circle, rgba(232, 163, 23, 0.45) 2px, transparent 3px);
  background-size: 150px 150px, 230px 230px, 310px 310px;
  background-position: 0 0, 70px 90px, 140px 40px;
  animation: doktor-fizz 16s linear infinite;
  opacity: 0.5;
}
@keyframes doktor-fizz {
  from { background-position: 0 0, 70px 90px, 140px 40px; }
  to   { background-position: 0 -600px, 70px -680px, 140px -780px; }
}
.container, main, .navbar, .card, .modal, footer { position: relative; z-index: 1; }
h1, h2, h3, .h1, .h2, .h3 {
  font-style: italic;
  letter-spacing: 0.01em;
  text-shadow: 0 1px 0 rgba(0, 0, 0, 0.6), 0 0 18px rgba(232, 163, 23, 0.35);
}
/* Light surfaces (the homepage hero, any .bg-light panel) sit on cream —
   give them dark cola ink so headings and copy stay readable. */
.bg-light {
  color: #3a0a12;
}
.bg-light h1, .bg-light h2, .bg-light h3, .bg-light h4, .bg-light h5, .bg-light h6,
.bg-light .h1, .bg-light .h2, .bg-light .h3, .bg-light .h4, .bg-light .h5, .bg-light .h6 {
  color: #8b1a2b;
  text-shadow: none;
}
.bg-light .text-muted {
  color: #7a5a3c !important;
}
.bg-light a:not(.btn) {
  color: #a8121f;
}
.bg-light a:not(.btn):hover {
  color: #c5102b;
}
/* cards built like a glossy soda can */
.card {
  background:
    linear-gradient(160deg, rgba(255, 255, 255, 0.10) 0%, rgba(255, 255, 255, 0) 22%),
    linear-gradient(180deg, #5a1019 0%, #3a0a12 100%) !important;
  border: 1px solid #c8842e;
  border-radius: 0.9rem;
  box-shadow:
    inset 0 1px 0 rgba(255, 255, 255, 0.18),
    inset 0 0 30px rgba(0, 0, 0, 0.45),
    0 6px 22px rgba(0, 0, 0, 0.55);
  color: #f4e6ce;
}
.card-header {
  background: linear-gradient(90deg, #c5102b 0%, #8b1a2b 55%, #c8842e 100%) !important;
  color: #fff6e6 !important;
  font-style: italic;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.09em;
  border-bottom: 2px solid #c8842e;
  text-shadow: 0 1px 2px rgba(0, 0, 0, 0.6);
}
/* glossy bottle-cap buttons */
.btn-primary, .btn-secondary, .btn-success, .btn-info, .btn-warning, .btn-danger {
  border: none;
  border-radius: 50rem;
  font-weight: 700;
  letter-spacing: 0.04em;
  background-image: linear-gradient(180deg, rgba(255, 255, 255, 0.32) 0%, rgba(255, 255, 255, 0) 48%);
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.5), 0 3px 8px rgba(0, 0, 0, 0.5);
  transition: transform 0.12s ease, filter 0.12s ease, box-shadow 0.12s ease;
}
.btn-primary:hover, .btn-secondary:hover, .btn-success:hover,
.btn-info:hover, .btn-warning:hover, .btn-danger:hover {
  filter: brightness(1.12) saturate(1.15);
  transform: translateY(-2px);
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.6), 0 6px 16px rgba(0, 0, 0, 0.6);
}
.btn-primary:active, .btn-secondary:active, .btn-success:active,
.btn-info:active, .btn-warning:active, .btn-danger:active { transform: translateY(0); }
.navbar, ul.us_menu.custom {
  border-bottom: 3px solid #c8842e !important;
  box-shadow: 0 4px 22px rgba(0, 0, 0, 0.6);
  background-image: linear-gradient(180deg, rgba(255, 255, 255, 0.06), rgba(0, 0, 0, 0.25)) !important;
}
.form-control, .form-select, textarea.form-control {
  background-color: #4a1018 !important;
  color: #f4e6ce !important;
  border: 1px solid #c8842e !important;
}
.form-control:focus, .form-select:focus, textarea.form-control:focus {
  border-color: #c5102b !important;
  box-shadow: 0 0 0 0.2rem rgba(197, 16, 43, 0.4) !important;
  background-color: #4a1018 !important;
  color: #fff6e6 !important;
}
/* native <select> dropdown list inherits these */
.form-select option, .form-control option { background-color: #4a1018; color: #f4e6ce; }
.table {
  --bs-table-color: #f4e6ce;
  --bs-table-bg: transparent;
  --bs-table-border-color: rgba(200, 132, 46, 0.35);
  --bs-table-striped-bg: rgba(197, 16, 43, 0.12);
  --bs-table-striped-color: #f4e6ce;
  --bs-table-hover-bg: rgba(232, 163, 23, 0.14);
  --bs-table-hover-color: #fff6e6;
}
a:not(.btn):not(.nav-link) {
  color: #e8a317;
  text-decoration: none;
}
a:not(.btn):not(.nav-link):hover {
  color: #ffce5a;
  text-shadow: 0 0 8px rgba(232, 163, 23, 0.6);
}
.modal-content {
  background: linear-gradient(180deg, #5a1019, #2a070c);
  border: 2px solid #c8842e;
  box-shadow: 0 0 36px rgba(197, 16, 43, 0.5);
  color: #f4e6ce;
}
/* Toast notifications — a later inline <style> paints .us-toast white, so
   beat it on specificity (.toast.us-toast) plus !important. */
.toast.us-toast, .toast {
  background-color: #4a1018 !important;
  color: #f4e6ce !important;
  border: 1px solid #c8842e !important;
  box-shadow: 0 6px 24px rgba(0, 0, 0, 0.6);
}
.toast.us-toast .toast-body, .toast .toast-body { color: #f4e6ce !important; }
.toast .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }
.alert { border-left: 5px solid currentColor; }
.badge { letter-spacing: 0.04em; }
hr { border-color: #c8842e; opacity: 0.5; }
",
);
