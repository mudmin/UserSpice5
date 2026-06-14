<?php
/**
 * Preset: Comic Book
 * Category: Wild
 * Description: Pop-art — flat bold primaries, thick ink borders, hard offset shadows, halftone dots.
 * Tags: light, expressive, pop-art, bold, playful
 * Mode: light
 * Author: UserSpice Customizer Theme
 */
return array (
  'primary' => '#1854c4',
  'primary-hover' => '#1342a0',
  'primary-text-emphasis' => '#0c2c6b',
  'primary-bg-subtle' => '#d3e0f5',
  'primary-border-subtle' => '#141414',

  'secondary' => '#6b3fa0',
  'secondary-hover' => '#563283',
  'secondary-text-emphasis' => '#3a2257',
  'secondary-bg-subtle' => '#e2d8ef',
  'secondary-border-subtle' => '#141414',

  'success' => '#2fa84f',
  'success-hover' => '#258840',
  'success-text-emphasis' => '#185729',
  'success-bg-subtle' => '#d5efdc',
  'success-border-subtle' => '#141414',

  'info' => '#18b5d8',
  'info-hover' => '#1494b0',
  'info-text-emphasis' => '#0c5e70',
  'info-bg-subtle' => '#d2eef5',
  'info-border-subtle' => '#141414',

  'warning' => '#ffce00',
  'warning-hover' => '#d6ad00',
  'warning-text-emphasis' => '#6b5700',
  'warning-bg-subtle' => '#fff3c4',
  'warning-border-subtle' => '#141414',

  'danger' => '#e42029',
  'danger-hover' => '#c01622',
  'danger-text-emphasis' => '#730d13',
  'danger-bg-subtle' => '#fad4d6',
  'danger-border-subtle' => '#141414',

  'light' => '#fff7da',
  'light-hover' => '#f0e6bf',
  'light-text-emphasis' => '#4a4632',
  'light-bg-subtle' => '#fffdf2',
  'light-border-subtle' => '#141414',

  'dark' => '#141414',
  'dark-hover' => '#2e2e2e',
  'dark-text-emphasis' => '#000000',
  'dark-bg-subtle' => '#c2c2c2',
  'dark-border-subtle' => '#141414',

  'body-color' => '#141414',
  'body-bg' => '#fdf3d0',
  'border-color' => '#141414',
  'form-control-bg' => '#ffffff',

  'secondary-color' => '#44423a',
  'tertiary-color' => '#6b6859',
  'emphasis-color' => '#000000',
  'secondary-bg' => '#f3e6b8',
  'tertiary-bg' => '#fbf2cf',

  'us-menu-custom-bg' => '#ffce00',
  'us-menu-custom-text' => '#141414',
  'us-menu-custom-hover-bg' => '#141414',
  'us-menu-custom-hover-text' => '#ffce00',
  'us-menu-custom-active-bg' => '#e8202a',
  'us-menu-custom-active-text' => '#ffffff',
  'us-menu-custom-divider' => '#141414',
  'us-menu-custom-submenu-border' => '#141414',

  'headings-color' => 'var(--bs-dark)',

  'custom_css' => "
/* === COMIC BOOK === pop-art, ink borders, halftone */
body {
  background-color: #fdf3d0;
  background-image: radial-gradient(rgba(20, 20, 20, 0.13) 1.4px, transparent 1.5px);
  background-size: 14px 14px;
}
h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.01em;
  -webkit-text-stroke: 0.6px #141414;
}
.card {
  background-color: #ffffff;
  border: 3px solid #141414;
  border-radius: 0;
  box-shadow: 6px 6px 0 #141414;
}
.card-header {
  background-color: #ffce00;
  border-bottom: 3px solid #141414;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.04em;
  color: #141414;
}
.btn {
  border: 2.5px solid #141414 !important;
  border-radius: 0;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.03em;
  box-shadow: 3px 3px 0 #141414;
  transition: transform 0.05s ease, box-shadow 0.05s ease;
}
.btn:hover { transform: translate(1px, 1px); box-shadow: 2px 2px 0 #141414; }
.btn:active { transform: translate(3px, 3px); box-shadow: 0 0 0 #141414; }
.form-control, .form-select, textarea.form-control {
  border: 2.5px solid #141414 !important;
  border-radius: 0 !important;
}
.form-control:focus, .form-select:focus, textarea.form-control:focus {
  box-shadow: 3px 3px 0 #1854c4 !important;
}
.alert {
  border: 3px solid #141414;
  border-radius: 0;
  box-shadow: 4px 4px 0 #141414;
  font-weight: 600;
}
.badge {
  border: 2px solid #141414;
  border-radius: 0;
}
.modal-content {
  border: 3px solid #141414;
  border-radius: 0;
  box-shadow: 8px 8px 0 #141414;
}
.table {
  --bs-table-border-color: #141414;
}
.table > :not(caption) > * > * { border-width: 2px; }
a:not(.btn):not(.nav-link) {
  color: #1854c4;
  font-weight: 700;
  text-decoration: underline;
  text-decoration-thickness: 2px;
}
a:not(.btn):not(.nav-link):hover { color: #e8202a; }
",
);
