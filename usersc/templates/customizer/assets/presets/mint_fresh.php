<?php
/**
 * Preset: Mint Fresh
 * Category: Clean
 * Description: Friendly SaaS — mint primary, coral accents, rounded everything.
 * Tags: light, friendly, saas, rounded, cheerful
 * Mode: light
 * Author: UserSpice Customizer Theme
 */
return array (
  'primary' => '#00b894',
  'primary-hover' => '#009b7a',
  'primary-text-emphasis' => '#005544',
  'primary-bg-subtle' => '#d6f5ec',
  'primary-border-subtle' => '#7fdcc4',

  'secondary' => '#ff7675',
  'secondary-hover' => '#e95e5d',
  'secondary-text-emphasis' => '#8a2828',
  'secondary-bg-subtle' => '#ffe4e4',
  'secondary-border-subtle' => '#ffb4b3',

  'success' => '#55efc4',
  'success-hover' => '#36d4a8',
  'success-text-emphasis' => '#1d5e4f',
  'success-bg-subtle' => '#e1faf2',
  'success-border-subtle' => '#a9f1d8',

  'info' => '#74b9ff',
  'info-hover' => '#5a9ee0',
  'info-text-emphasis' => '#2b4c70',
  'info-bg-subtle' => '#e3f0ff',
  'info-border-subtle' => '#b8d6f7',

  'warning' => '#fdcb6e',
  'warning-hover' => '#e9b658',
  'warning-text-emphasis' => '#7a5a14',
  'warning-bg-subtle' => '#fff4dd',
  'warning-border-subtle' => '#fbdda7',

  'danger' => '#d63031',
  'danger-hover' => '#b62424',
  'danger-text-emphasis' => '#6b1414',
  'danger-bg-subtle' => '#fadbdb',
  'danger-border-subtle' => '#ed9999',

  'light' => '#e8f6f0',
  'light-hover' => '#d3ebe1',
  'light-text-emphasis' => '#1f3933',
  'light-bg-subtle' => '#f4fbf7',
  'light-border-subtle' => '#cee5da',

  'dark' => '#1a3933',
  'dark-hover' => '#0f2b25',
  'dark-text-emphasis' => '#0a1f1a',
  'dark-bg-subtle' => '#a8c2bb',
  'dark-border-subtle' => '#5e7a73',

  'body-color' => '#1f3933',
  'body-bg' => '#f4fbf7',
  'border-color' => '#cee5da',
  'form-control-bg' => '#ffffff',

  'us-menu-custom-bg' => '#1a3933',
  'us-menu-custom-text' => '#e8f6f0',
  'us-menu-custom-hover-bg' => '#00b894',
  'us-menu-custom-hover-text' => '#ffffff',
  'us-menu-custom-active-bg' => '#00b894',
  'us-menu-custom-active-text' => '#ffffff',
  'us-menu-custom-divider' => '#2a5048',
  'us-menu-custom-submenu-border' => '#00b894',

  'headings-color' => 'var(--bs-dark)',

  'custom_css' => "
/* === MINT FRESH === friendly, rounded, soft */
.card {
  border: 1px solid #cee5da;
  border-radius: 14px;
  box-shadow: 0 2px 8px rgba(0, 184, 148, 0.08);
  background-color: #ffffff;
}
.card-header {
  background-color: #d6f5ec;
  border-bottom: 1px solid #b3e4d3;
  border-radius: 14px 14px 0 0 !important;
  font-weight: 600;
  color: #1a3933;
}
.btn {
  border-radius: 10px;
  font-weight: 600;
  transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
.form-control, .form-select {
  border-radius: 10px;
  border: 1px solid #cee5da !important;
}
.form-control:focus, .form-select:focus {
  border-color: #00b894 !important;
  box-shadow: 0 0 0 0.2rem rgba(0, 184, 148, 0.2) !important;
}
.alert { border-radius: 12px; border: none; }
.badge { border-radius: 8px; padding: 0.4em 0.7em; }
.modal-content { border-radius: 16px; border: none; box-shadow: 0 12px 32px rgba(0,0,0,0.15); }
",
);
