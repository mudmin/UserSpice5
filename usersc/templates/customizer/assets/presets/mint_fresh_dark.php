<?php
/**
 * Preset: Mint Fresh Dark
 * Category: Clean
 * Description: Friendly SaaS, dark mode — mint primary, coral accents, rounded everything, on charcoal-teal.
 * Tags: dark, friendly, saas, rounded, cheerful
 * Mode: dark
 * Author: UserSpice Customizer Theme
 */
return array (
  'primary' => '#00b894',
  'primary-hover' => '#009b7a',
  'primary-text-emphasis' => '#55efc4',
  'primary-bg-subtle' => '#04241d',
  'primary-border-subtle' => '#007a61',

  'secondary' => '#ff7675',
  'secondary-hover' => '#e95e5d',
  'secondary-text-emphasis' => '#ffb4b3',
  'secondary-bg-subtle' => '#331615',
  'secondary-border-subtle' => '#b35251',

  'success' => '#55efc4',
  'success-hover' => '#36d4a8',
  'success-text-emphasis' => '#8df3d8',
  'success-bg-subtle' => '#07291f',
  'success-border-subtle' => '#1d8f6f',

  'info' => '#74b9ff',
  'info-hover' => '#5a9ee0',
  'info-text-emphasis' => '#aed4ff',
  'info-bg-subtle' => '#0e2438',
  'info-border-subtle' => '#3a6da3',

  'warning' => '#fdcb6e',
  'warning-hover' => '#e9b658',
  'warning-text-emphasis' => '#ffe1a6',
  'warning-bg-subtle' => '#2e2207',
  'warning-border-subtle' => '#a3823a',

  'danger' => '#d63031',
  'danger-hover' => '#b62424',
  'danger-text-emphasis' => '#f08a8a',
  'danger-bg-subtle' => '#2e0c0c',
  'danger-border-subtle' => '#9c2424',

  'light' => '#e8f6f0',
  'light-hover' => '#d3ebe1',
  'light-text-emphasis' => '#e8f6f0',
  'light-bg-subtle' => '#2a4a42',
  'light-border-subtle' => '#3a5e54',

  'dark' => '#1a3933',
  'dark-hover' => '#0f2b25',
  'dark-text-emphasis' => '#d6efe7',
  'dark-bg-subtle' => '#0c1f1a',
  'dark-border-subtle' => '#2a4a42',

  'body-color' => '#e3efea',
  'body-bg' => '#14241f',
  'border-color' => '#2a4a42',
  'form-control-bg' => '#1a3029',

  'secondary-color' => '#9bb5ad',
  'tertiary-color' => '#6a857c',
  'emphasis-color' => '#f4fbf8',
  'secondary-bg' => '#1a3029',
  'tertiary-bg' => '#15251f',

  'us-menu-custom-bg' => '#0d1f1a',
  'us-menu-custom-text' => '#e3efea',
  'us-menu-custom-hover-bg' => '#00b894',
  'us-menu-custom-hover-text' => '#ffffff',
  'us-menu-custom-active-bg' => '#00b894',
  'us-menu-custom-active-text' => '#ffffff',
  'us-menu-custom-divider' => '#2a4a42',
  'us-menu-custom-submenu-border' => '#00b894',

  'headings-color' => '#f4fbf8',

  'custom_css' => "
/* === MINT FRESH DARK === friendly, rounded, soft — dark */
:root { color-scheme: dark; }
.form-select option, .form-control option { background-color: #1a3029; color: #e3efea; }

.card { background-color: #1a3029; border: 1px solid #2a4a42; color: #e3efea; border-radius: 14px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3); }
.card-header, .card-footer { background-color: #14241f; border-color: #2a4a42; color: #55efc4; font-weight: 600; }
.card-header { border-radius: 14px 14px 0 0 !important; }
.card-footer { border-radius: 0 0 14px 14px !important; }

.btn {
  border-radius: 10px;
  font-weight: 600;
  transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.4); }

.form-control, .form-select, textarea.form-control {
  border-radius: 10px;
  background-color: #1a3029 !important;
  border: 1px solid #2a4a42 !important;
  color: #e3efea !important;
}
.form-control:focus, .form-select:focus {
  border-color: #00b894 !important;
  box-shadow: 0 0 0 0.2rem rgba(0, 184, 148, 0.3) !important;
}
.form-control::placeholder { color: #9bb5ad; }

.dropdown-menu { background-color: #1a3029; border-color: #2a4a42; color: #e3efea; border-radius: 12px; }
.dropdown-item { color: #e3efea; }
.dropdown-item:hover, .dropdown-item:focus { background-color: #2a4a42; color: #55efc4; }
.dropdown-divider { border-color: #2a4a42; }

.modal-content { background-color: #1a3029; border: 1px solid #2a4a42; color: #e3efea; border-radius: 16px; box-shadow: 0 12px 32px rgba(0,0,0,0.5); }
.modal-header, .modal-footer { border-color: #2a4a42; }

.list-group { background-color: transparent; }
.list-group-item { background-color: #1a3029; border-color: #2a4a42; color: #e3efea; }
.list-group-item.active { background-color: #00b894; border-color: #00b894; color: #ffffff; }

.popover { background-color: #1a3029; border-color: #2a4a42; border-radius: 12px; }
.popover-header { background-color: #14241f; border-bottom-color: #2a4a42; color: #55efc4; }
.popover-body { color: #e3efea; }

.toast { background-color: #1a3029; border-color: #2a4a42; color: #e3efea; border-radius: 12px; }
.toast-header { background-color: #14241f; border-bottom-color: #2a4a42; color: #55efc4; }

.table {
  --bs-table-color: #e3efea;
  --bs-table-bg: transparent;
  --bs-table-border-color: #2a4a42;
  --bs-table-striped-bg: #14241f;
  --bs-table-hover-bg: #2a4a42;
}

.alert { border-radius: 12px; border: none; }
.badge { border-radius: 8px; padding: 0.4em 0.7em; }

a:not(.btn):not(.nav-link) { color: #00d6ac; }
a:not(.btn):not(.nav-link):hover { color: #55efc4; }
",
);
