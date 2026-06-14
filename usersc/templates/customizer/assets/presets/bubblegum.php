<?php
/**
 * Preset: Bubblegum
 * Category: Wild
 * Description: Playful and sweet. Hot pink, mint, cream. Chunky, bouncy, candy-shop.
 * Tags: light, expressive, playful, candy, bouncy
 * Mode: light
 * Author: UserSpice Customizer Theme
 */
return array (
  'primary' => '#ff5290',
  'primary-hover' => '#e63d7a',
  'primary-text-emphasis' => '#7a1c40',
  'primary-bg-subtle' => '#ffdfe9',
  'primary-border-subtle' => '#ffa3c0',

  'secondary' => '#4dd0a8',
  'secondary-hover' => '#3bb892',
  'secondary-text-emphasis' => '#1f5946',
  'secondary-bg-subtle' => '#d8f3e8',
  'secondary-border-subtle' => '#a3e1c8',

  'success' => '#66e090',
  'success-hover' => '#52c97a',
  'success-text-emphasis' => '#1f5e36',
  'success-bg-subtle' => '#dcf5e3',
  'success-border-subtle' => '#a8e6ba',

  'info' => '#a8dadc',
  'info-hover' => '#8fc8ca',
  'info-text-emphasis' => '#2a5e60',
  'info-bg-subtle' => '#e8f5f6',
  'info-border-subtle' => '#c8e6e7',

  'warning' => '#ffc857',
  'warning-hover' => '#f0b73e',
  'warning-text-emphasis' => '#6e521a',
  'warning-bg-subtle' => '#fff1d6',
  'warning-border-subtle' => '#fed99a',

  'danger' => '#d93642',
  'danger-hover' => '#c92935',
  'danger-text-emphasis' => '#6e1620',
  'danger-bg-subtle' => '#fad9dc',
  'danger-border-subtle' => '#f0a3a9',

  'light' => '#ffe4ec',
  'light-hover' => '#f7d2dc',
  'light-text-emphasis' => '#4a1a35',
  'light-bg-subtle' => '#fff0f5',
  'light-border-subtle' => '#fac8d6',

  'dark' => '#4a1a35',
  'dark-hover' => '#3a142a',
  'dark-text-emphasis' => '#2a0e1f',
  'dark-bg-subtle' => '#b08aa3',
  'dark-border-subtle' => '#7a3a5e',

  'body-color' => '#4a1a35',
  'body-bg' => '#fff0f5',
  'border-color' => '#fac8d6',
  'form-control-bg' => '#ffffff',

  'us-menu-custom-bg' => '#4a1a35',
  'us-menu-custom-text' => '#ffe4ec',
  'us-menu-custom-hover-bg' => '#ff4d8d',
  'us-menu-custom-hover-text' => '#ffffff',
  'us-menu-custom-active-bg' => '#4dd0a8',
  'us-menu-custom-active-text' => '#ffffff',
  'us-menu-custom-divider' => 'rgba(255, 77, 141, 0.3)',
  'us-menu-custom-submenu-border' => '#ff4d8d',

  'headings-color' => 'var(--bs-primary)',

  'custom_css' => "
/* === BUBBLEGUM === playful, chunky, bouncy */
h1, h2, h3, .h1, .h2, .h3 {
  font-weight: 800;
  letter-spacing: -0.02em;
}
.card {
  border: 3px solid #ff4d8d;
  border-radius: 20px;
  background-color: #ffffff;
  box-shadow: 0 6px 0 0 #ff4d8d;
  transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 0 0 #ff4d8d;
}
.card-header {
  background: linear-gradient(135deg, #ff4d8d, #ff85b0);
  color: #ffffff !important;
  font-weight: 800;
  letter-spacing: 0.04em;
  border-bottom: none;
  border-radius: 17px 17px 0 0 !important;
}
.btn {
  border-radius: 50px;
  font-weight: 700;
  letter-spacing: 0.04em;
  padding: 0.55rem 1.4rem;
  border-width: 3px !important;
  box-shadow: 0 4px 0 0 rgba(0,0,0,0.15);
  transition: transform 0.1s ease, box-shadow 0.1s ease;
}
.btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 0 0 rgba(0,0,0,0.2);
}
.btn:active {
  transform: translateY(2px);
  box-shadow: 0 1px 0 0 rgba(0,0,0,0.15);
}
.form-control, .form-select {
  border-radius: 14px;
  border: 2px solid #fac8d6 !important;
  padding: 0.6rem 1rem;
}
.form-control:focus, .form-select:focus {
  border-color: #ff4d8d !important;
  box-shadow: 0 0 0 4px rgba(255, 77, 141, 0.2) !important;
}
.badge {
  border-radius: 50px;
  padding: 0.45em 0.85em;
  font-weight: 700;
}
.alert {
  border-radius: 18px;
  border: 3px solid;
  font-weight: 500;
}
.modal-content {
  border-radius: 24px;
  border: 4px solid #ff4d8d;
  box-shadow: 0 10px 0 0 rgba(255, 77, 141, 0.3);
}
",
);
