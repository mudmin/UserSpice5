<?php
/**
 * Preset: Paperwhite
 * Category: Clean
 * Description: Editorial minimalism. Off-white paper, serif headings, generous whitespace.
 * Tags: light, editorial, serif, minimal, restful
 * Mode: light
 * Author: UserSpice Customizer Theme
 */
return array (
  'primary' => '#1a1a1a',
  'primary-hover' => '#000000',
  'primary-text-emphasis' => '#0a0a0a',
  'primary-bg-subtle' => '#ececec',
  'primary-border-subtle' => '#1a1a1a',

  'secondary' => '#5a5a5a',
  'secondary-hover' => '#3d3d3d',
  'secondary-text-emphasis' => '#2a2a2a',
  'secondary-bg-subtle' => '#f0f0ed',
  'secondary-border-subtle' => '#bcbcbc',

  'success' => '#2d5f3f',
  'success-hover' => '#234d33',
  'success-text-emphasis' => '#163322',
  'success-bg-subtle' => '#e8eee9',
  'success-border-subtle' => '#a8c4b1',

  'info' => '#2c5777',
  'info-hover' => '#214459',
  'info-text-emphasis' => '#16303f',
  'info-bg-subtle' => '#e8eef2',
  'info-border-subtle' => '#a3b8c6',

  'warning' => '#8b6914',
  'warning-hover' => '#705310',
  'warning-text-emphasis' => '#4d3a0b',
  'warning-bg-subtle' => '#f3eedf',
  'warning-border-subtle' => '#c9b884',

  'danger' => '#8b2c2c',
  'danger-hover' => '#702222',
  'danger-text-emphasis' => '#4d1717',
  'danger-bg-subtle' => '#f1e2e2',
  'danger-border-subtle' => '#c89090',

  'light' => '#f0f0ed',
  'light-hover' => '#e2e2dc',
  'light-text-emphasis' => '#3a3a36',
  'light-bg-subtle' => '#f7f7f3',
  'light-border-subtle' => '#d6d6cf',

  'dark' => '#1a1a1a',
  'dark-hover' => '#0a0a0a',
  'dark-text-emphasis' => '#050505',
  'dark-bg-subtle' => '#d4d4d0',
  'dark-border-subtle' => '#8a8a85',

  'body-color' => '#1a1a1a',
  'body-bg' => '#fafaf7',
  'border-color' => '#d4d4d0',
  'form-control-bg' => '#ffffff',

  'us-menu-custom-bg' => '#1a1a1a',
  'us-menu-custom-text' => '#fafaf7',
  'us-menu-custom-hover-bg' => '#2a2a2a',
  'us-menu-custom-hover-text' => '#ffffff',
  'us-menu-custom-active-bg' => '#fafaf7',
  'us-menu-custom-active-text' => '#1a1a1a',
  'us-menu-custom-divider' => '#3a3a3a',
  'us-menu-custom-submenu-border' => '#2a2a2a',

  'font-sans-serif' => 'Georgia, \"Times New Roman\", Times, serif',
  'headings-color' => 'inherit',

  'custom_css' => "
/* === PAPERWHITE === editorial, serif, restful */
body {
  font-family: Georgia, 'Times New Roman', Times, serif;
  line-height: 1.7;
}
h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
  font-family: Georgia, 'Times New Roman', Times, serif;
  font-weight: 600;
  letter-spacing: -0.01em;
}
.card {
  border: 1px solid #d4d4d0;
  border-radius: 0;
  background-color: #fafaf7;
  box-shadow: none;
}
.card-header {
  background-color: transparent;
  border-bottom: 1px solid #d4d4d0;
  font-weight: 600;
  letter-spacing: 0.02em;
}
.btn {
  border-radius: 0;
  font-weight: 500;
  letter-spacing: 0.02em;
}
.form-control, .form-select {
  border-radius: 0;
  border: 1px solid #d4d4d0 !important;
}
.form-control:focus, .form-select:focus {
  border-color: #1a1a1a !important;
  box-shadow: none !important;
}
.table { --bs-table-border-color: #d4d4d0; }
.alert { border-radius: 0; border-width: 1px; }
hr { border-color: #d4d4d0; }
a:not(.btn):not(.nav-link) {
  color: #1a1a1a;
  text-decoration: underline;
  text-underline-offset: 0.25em;
}
a:not(.btn):not(.nav-link):hover { color: #5a5a5a; }
",
);
