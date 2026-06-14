<?php
/**
 * Preset: Terminal Phosphor
 * Category: Wild
 * Description: Green-on-black CRT. Monospace body, faint scanlines, blinking-cursor focus.
 * Tags: dark, expressive, retro, terminal, monospace, hacker
 * Mode: dark
 * Author: UserSpice Customizer Theme
 */
return array (
  'primary' => '#00ff66',
  'primary-hover' => '#33ff85',
  'primary-text-emphasis' => '#99ffc4',
  'primary-bg-subtle' => '#002211',
  'primary-border-subtle' => '#00ff66',
  'secondary' => '#00cc52',
  'secondary-hover' => '#1edb6b',
  'secondary-text-emphasis' => '#80e0a0',
  'secondary-bg-subtle' => '#001a0d',
  'secondary-border-subtle' => '#00cc52',
  'success' => '#66ff99',
  'success-hover' => '#85ffb0',
  'success-text-emphasis' => '#b8ffcc',
  'success-bg-subtle' => '#002b14',
  'success-border-subtle' => '#66ff99',
  'info' => '#00b3ff',
  'info-hover' => '#33c4ff',
  'info-text-emphasis' => '#99e0ff',
  'info-bg-subtle' => '#001b2b',
  'info-border-subtle' => '#00b3ff',
  'warning' => '#ffff00',
  'warning-hover' => '#ffff66',
  'warning-text-emphasis' => '#ffff99',
  'warning-bg-subtle' => '#2b2b00',
  'warning-border-subtle' => '#ffff00',
  'danger' => '#ff3300',
  'danger-hover' => '#ff5c33',
  'danger-text-emphasis' => '#ffa380',
  'danger-bg-subtle' => '#2b0a00',
  'danger-border-subtle' => '#ff3300',
  'light' => '#003300',
  'light-hover' => '#004400',
  'light-text-emphasis' => '#66ff99',
  'light-bg-subtle' => '#001a00',
  'light-border-subtle' => '#005500',
  'dark' => '#000000',
  'dark-hover' => '#000d00',
  'dark-text-emphasis' => '#000000',
  'dark-bg-subtle' => '#000a00',
  'dark-border-subtle' => '#000000',
  'body-color' => '#00ff66',
  'body-bg' => '#001a00',
  'border-color' => '#00cc52',
  'form-control-bg' => '#000a00',
  'secondary-color' => '#33cc6e',
  'tertiary-color' => '#1f9a4d',
  'emphasis-color' => '#ccffcc',
  'secondary-bg' => '#002a0d',
  'tertiary-bg' => '#001f08',
  'us-menu-custom-bg' => '#000000',
  'us-menu-custom-text' => '#00ff66',
  'us-menu-custom-hover-bg' => '#003300',
  'us-menu-custom-hover-text' => '#66ff99',
  'us-menu-custom-active-bg' => '#00ff66',
  'us-menu-custom-active-text' => '#000000',
  'us-menu-custom-divider' => '#005500',
  'us-menu-custom-submenu-border' => '#00ff66',
  'font-sans-serif' => '\\"Courier New\\", Courier, \\"DejaVu Sans Mono\\", monospace',
  'headings-color' => 'var(--bs-primary)',
  'custom_css' => '/* === TERMINAL PHOSPHOR === CRT, scanlines, glow */
:root { color-scheme: dark; }
body {
  font-family: \'Courier New\', Courier, monospace;
  background:
    repeating-linear-gradient(0deg, rgba(0, 255, 102, 0.04) 0px, rgba(0, 255, 102, 0.04) 1px, transparent 1px, transparent 3px),
    radial-gradient(ellipse at center, #001a00 0%, #000a00 100%) fixed;
  text-shadow: 0 0 2px rgba(0, 255, 102, 0.6);
  min-height: 100vh;
}
h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
  font-family: \'Courier New\', Courier, monospace;
  text-shadow: 0 0 6px #00ff66, 0 0 14px rgba(0, 255, 102, 0.4);
  letter-spacing: 0.04em;
  text-transform: uppercase;
}
.card {
  background-color: rgba(0, 10, 0, 0.85);
  border: 1px solid #00ff66;
  box-shadow: 0 0 12px rgba(0, 255, 102, 0.25), inset 0 0 30px rgba(0, 255, 102, 0.04);
  color: #00ff66;
}
.card-header {
  background-color: #002211;
  border-bottom: 1px dashed #00ff66;
  color: #66ff99;
  font-weight: 700;
  text-transform: uppercase;
}
.card-header::before { content: \'> \'; color: #00ff66; }
.btn {
  border-radius: 0;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  border-width: 1px !important;
}
.form-control, .form-select, textarea.form-control {
  color: #00ff66 !important;
  border: 1px solid #00ff66 !important;
  font-family: \'Courier New\', Courier, monospace;
  border-radius: 0;
  caret-color: #00ff66;
}
.form-control:focus, .form-select:focus {
  background-color: #000a00 !important;
  color: #00ff66 !important;
  border-color: #66ff99 !important;
  box-shadow: 0 0 0 0.15rem rgba(0, 255, 102, 0.35), inset 0 0 12px rgba(0, 255, 102, 0.15) !important;
  animation: phosphor-blink 1s steps(2) infinite;
}
/* native <select> dropdown list inherits these */
.form-select option, .form-control option { background-color: #000a00; color: #00ff66; }
@keyframes phosphor-blink {
  50% { box-shadow: 0 0 0 0.15rem rgba(0, 255, 102, 0.18), inset 0 0 12px rgba(0, 255, 102, 0.08) !important; }
}
.table {
  --bs-table-color: #00ff66;
  --bs-table-bg: transparent;
  --bs-table-border-color: #005500;
  --bs-table-striped-bg: rgba(0, 255, 102, 0.04);
  --bs-table-hover-bg: rgba(0, 255, 102, 0.10);
  font-family: \'Courier New\', Courier, monospace;
}
.modal-content {
  background-color: #000a00;
  border: 1px solid #00ff66;
  color: #00ff66;
  box-shadow: 0 0 24px rgba(0, 255, 102, 0.4);
}
code, pre, kbd { background: #002211; color: #66ff99; border: 1px solid #005500; }
a:not(.btn):not(.nav-link) { color: #66ff99; text-decoration: underline; }
a:not(.btn):not(.nav-link):hover { color: #99ffc4; text-shadow: 0 0 6px #00ff66; }',
);
