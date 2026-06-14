<?php
/**
 * Preset: Slate Pro Dark
 * Category: Clean
 * Description: Clean modern B2B SaaS, dark mode — slate-900 neutrals with one indigo accent.
 * Tags: dark, professional, corporate, modern, neutral
 * Mode: dark
 * Author: UserSpice Customizer Theme
 */
return array (
  'primary' => '#4f46e5',
  'primary-hover' => '#4338ca',
  'primary-text-emphasis' => '#a5b4fc',
  'primary-bg-subtle' => '#1e1b4b',
  'primary-border-subtle' => '#3730a3',

  'secondary' => '#64748b',
  'secondary-hover' => '#475569',
  'secondary-text-emphasis' => '#cbd5e1',
  'secondary-bg-subtle' => '#1e293b',
  'secondary-border-subtle' => '#475569',

  'success' => '#059669',
  'success-hover' => '#047857',
  'success-text-emphasis' => '#6ee7b7',
  'success-bg-subtle' => '#022c22',
  'success-border-subtle' => '#047857',

  'info' => '#0b89c9',
  'info-hover' => '#0369a1',
  'info-text-emphasis' => '#7dd3fc',
  'info-bg-subtle' => '#082f49',
  'info-border-subtle' => '#0369a1',

  'warning' => '#d97706',
  'warning-hover' => '#b45309',
  'warning-text-emphasis' => '#fcd34d',
  'warning-bg-subtle' => '#451a03',
  'warning-border-subtle' => '#b45309',

  'danger' => '#dc2626',
  'danger-hover' => '#b91c1c',
  'danger-text-emphasis' => '#fca5a5',
  'danger-bg-subtle' => '#450a0a',
  'danger-border-subtle' => '#b91c1c',

  'light' => '#f1f5f9',
  'light-hover' => '#e2e8f0',
  'light-text-emphasis' => '#f8fafc',
  'light-bg-subtle' => '#334155',
  'light-border-subtle' => '#475569',

  'dark' => '#0f172a',
  'dark-hover' => '#1e293b',
  'dark-text-emphasis' => '#cbd5e1',
  'dark-bg-subtle' => '#020617',
  'dark-border-subtle' => '#334155',

  'body-color' => '#cbd5e1',
  'body-bg' => '#0f172a',
  'border-color' => '#334155',
  'form-control-bg' => '#1e293b',

  'secondary-color' => '#94a3b8',
  'tertiary-color' => '#64748b',
  'emphasis-color' => '#f8fafc',
  'secondary-bg' => '#1e293b',
  'tertiary-bg' => '#172033',

  'us-menu-custom-bg' => '#0b1120',
  'us-menu-custom-text' => '#cbd5e1',
  'us-menu-custom-hover-bg' => '#1e293b',
  'us-menu-custom-hover-text' => '#ffffff',
  'us-menu-custom-active-bg' => '#4f46e5',
  'us-menu-custom-active-text' => '#ffffff',
  'us-menu-custom-divider' => '#1e293b',
  'us-menu-custom-submenu-border' => '#1e293b',

  'headings-color' => '#f1f5f9',

  'custom_css' => "
/* === SLATE PRO DARK === restrained B2B baseline, dark */
:root { color-scheme: dark; }
.form-select option, .form-control option { background-color: #1e293b; color: #cbd5e1; }

.card { background-color: #1e293b; border: 1px solid #334155; color: #cbd5e1; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.3), 0 1px 3px 0 rgba(0,0,0,0.4); }
.card-header, .card-footer { background-color: #172033; border-color: #334155; color: #f1f5f9; font-weight: 600; }

.btn-primary { font-weight: 500; }

.form-control, .form-select, textarea.form-control {
  background-color: #1e293b !important;
  border-color: #334155 !important;
  color: #cbd5e1 !important;
}
.form-control:focus, .form-select:focus {
  border-color: #4f46e5 !important;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.25) !important;
}
.form-control::placeholder { color: #64748b; }

.dropdown-menu { background-color: #1e293b; border-color: #334155; color: #cbd5e1; }
.dropdown-item { color: #cbd5e1; }
.dropdown-item:hover, .dropdown-item:focus { background-color: #334155; color: #f1f5f9; }
.dropdown-divider { border-color: #334155; }

.modal-content { background-color: #1e293b; border: 1px solid #334155; color: #cbd5e1; }
.modal-header, .modal-footer { border-color: #334155; }

.list-group { background-color: transparent; }
.list-group-item { background-color: #1e293b; border-color: #334155; color: #cbd5e1; }
.list-group-item.active { background-color: #4f46e5; border-color: #4f46e5; color: #f8fafc; }

.popover { background-color: #1e293b; border-color: #334155; }
.popover-header { background-color: #172033; border-bottom-color: #334155; color: #f1f5f9; }
.popover-body { color: #cbd5e1; }

.toast { background-color: #1e293b; border-color: #334155; color: #cbd5e1; }
.toast-header { background-color: #172033; border-bottom-color: #334155; color: #f1f5f9; }

.table {
  --bs-table-color: #cbd5e1;
  --bs-table-bg: transparent;
  --bs-table-border-color: #334155;
  --bs-table-striped-bg: #172033;
  --bs-table-hover-bg: #334155;
}

.navbar { box-shadow: 0 1px 3px rgba(0,0,0,0.4); }
a:not(.btn):not(.nav-link) { color: #818cf8; }
a:not(.btn):not(.nav-link):hover { color: #a5b4fc; }
",
);
