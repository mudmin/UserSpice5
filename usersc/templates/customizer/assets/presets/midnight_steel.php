<?php
/**
 * Preset: Midnight Steel
 * Category: Clean
 * Description: Dark navy-grey with sharp blue. Corporate dashboard energy.
 * Tags: dark, professional, corporate, dashboard, navy
 * Mode: dark
 * Author: UserSpice Customizer Theme
 */
return array (
  'primary' => '#3b82f6',
  'primary-hover' => '#2563eb',
  'primary-text-emphasis' => '#93c5fd',
  'primary-bg-subtle' => '#0f1f3a',
  'primary-border-subtle' => '#3b82f6',

  'secondary' => '#475569',
  'secondary-hover' => '#334155',
  'secondary-text-emphasis' => '#94a3b8',
  'secondary-bg-subtle' => '#1e293b',
  'secondary-border-subtle' => '#475569',

  'success' => '#10b981',
  'success-hover' => '#059669',
  'success-text-emphasis' => '#6ee7b7',
  'success-bg-subtle' => '#0a2e23',
  'success-border-subtle' => '#10b981',

  'info' => '#06b6d4',
  'info-hover' => '#0891b2',
  'info-text-emphasis' => '#67e8f9',
  'info-bg-subtle' => '#072e36',
  'info-border-subtle' => '#06b6d4',

  'warning' => '#f59e0b',
  'warning-hover' => '#d97706',
  'warning-text-emphasis' => '#fcd34d',
  'warning-bg-subtle' => '#3a2a07',
  'warning-border-subtle' => '#f59e0b',

  'danger' => '#ef4444',
  'danger-hover' => '#dc2626',
  'danger-text-emphasis' => '#fca5a5',
  'danger-bg-subtle' => '#3a1010',
  'danger-border-subtle' => '#ef4444',

  'light' => '#1e293b',
  'light-hover' => '#334155',
  'light-text-emphasis' => '#e2e8f0',
  'light-bg-subtle' => '#0f1419',
  'light-border-subtle' => '#334155',

  'dark' => '#020617',
  'dark-hover' => '#0c1426',
  'dark-text-emphasis' => '#000510',
  'dark-bg-subtle' => '#0f1419',
  'dark-border-subtle' => '#020617',

  'body-color' => '#d4d4d4',
  'body-bg' => '#0f1419',
  'border-color' => '#334155',
  'form-control-bg' => '#1e293b',

  'secondary-color' => '#94a3b8',
  'tertiary-color' => '#64748b',
  'emphasis-color' => '#ffffff',
  'secondary-bg' => '#1e293b',
  'tertiary-bg' => '#161c27',

  'us-menu-custom-bg' => '#020617',
  'us-menu-custom-text' => '#cbd5e1',
  'us-menu-custom-hover-bg' => '#1e293b',
  'us-menu-custom-hover-text' => '#ffffff',
  'us-menu-custom-active-bg' => '#3b82f6',
  'us-menu-custom-active-text' => '#ffffff',
  'us-menu-custom-divider' => '#1e293b',
  'us-menu-custom-submenu-border' => '#334155',

  'headings-color' => 'inherit',

  'custom_css' => "
/* === MIDNIGHT STEEL === corporate dark */
:root { color-scheme: dark; }
.card {
  background-color: #1e293b;
  border: 1px solid #334155;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
}
.card-header {
  background-color: #0f1419;
  border-bottom: 1px solid #334155;
  color: #e2e8f0;
  font-weight: 600;
}
.form-control, .form-select, textarea.form-control {
  color: #e2e8f0 !important;
  border: 1px solid #334155 !important;
}
.form-control:focus, .form-select:focus {
  background-color: #1e293b !important;
  color: #e2e8f0 !important;
  border-color: #3b82f6 !important;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2) !important;
}
/* native <select> dropdown list inherits these */
.form-select option, .form-control option { background-color: #1e293b; color: #e2e8f0; }
.table {
  --bs-table-color: #d4d4d4;
  --bs-table-bg: transparent;
  --bs-table-border-color: #334155;
  --bs-table-striped-bg: rgba(59, 130, 246, 0.04);
  --bs-table-hover-bg: rgba(59, 130, 246, 0.08);
}
.modal-content {
  background-color: #1e293b;
  border: 1px solid #334155;
  color: #d4d4d4;
}
a:not(.btn):not(.nav-link) { color: #60a5fa; }
a:not(.btn):not(.nav-link):hover { color: #93c5fd; }
",
);
