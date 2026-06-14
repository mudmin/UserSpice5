<?php
/**
 * Preset: Slate Pro
 * Category: Clean
 * Description: Clean modern B2B SaaS — slate neutrals with one indigo accent.
 * Tags: light, professional, corporate, modern, neutral
 * Mode: light
 * Author: UserSpice Customizer Theme
 */
return array (
  'primary' => '#4f46e5',
  'primary-hover' => '#4338ca',
  'primary-text-emphasis' => '#312e81',
  'primary-bg-subtle' => '#eef2ff',
  'primary-border-subtle' => '#c7d2fe',

  'secondary' => '#64748b',
  'secondary-hover' => '#475569',
  'secondary-text-emphasis' => '#334155',
  'secondary-bg-subtle' => '#f1f5f9',
  'secondary-border-subtle' => '#cbd5e1',

  'success' => '#059669',
  'success-hover' => '#047857',
  'success-text-emphasis' => '#064e3b',
  'success-bg-subtle' => '#ecfdf5',
  'success-border-subtle' => '#a7f3d0',

  'info' => '#0b89c9',
  'info-hover' => '#0369a1',
  'info-text-emphasis' => '#075985',
  'info-bg-subtle' => '#e0f2fe',
  'info-border-subtle' => '#bae6fd',

  'warning' => '#d97706',
  'warning-hover' => '#b45309',
  'warning-text-emphasis' => '#78350f',
  'warning-bg-subtle' => '#fef3c7',
  'warning-border-subtle' => '#fde68a',

  'danger' => '#dc2626',
  'danger-hover' => '#b91c1c',
  'danger-text-emphasis' => '#7f1d1d',
  'danger-bg-subtle' => '#fee2e2',
  'danger-border-subtle' => '#fecaca',

  'light' => '#f1f5f9',
  'light-hover' => '#e2e8f0',
  'light-text-emphasis' => '#334155',
  'light-bg-subtle' => '#f8fafc',
  'light-border-subtle' => '#e2e8f0',

  'dark' => '#0f172a',
  'dark-hover' => '#1e293b',
  'dark-text-emphasis' => '#020617',
  'dark-bg-subtle' => '#cbd5e1',
  'dark-border-subtle' => '#94a3b8',

  'body-color' => '#1f2937',
  'body-bg' => '#f7f8fa',
  'border-color' => '#e2e8f0',
  'form-control-bg' => '#ffffff',

  'us-menu-custom-bg' => '#0f172a',
  'us-menu-custom-text' => '#e2e8f0',
  'us-menu-custom-hover-bg' => '#1e293b',
  'us-menu-custom-hover-text' => '#ffffff',
  'us-menu-custom-active-bg' => '#4f46e5',
  'us-menu-custom-active-text' => '#ffffff',
  'us-menu-custom-divider' => '#1e293b',
  'us-menu-custom-submenu-border' => '#1e293b',

  'headings-color' => 'var(--bs-dark)',

  'custom_css' => "
/* === SLATE PRO === restrained B2B baseline */
.card {
  border: 1px solid #e2e8f0;
  box-shadow: 0 1px 2px 0 rgba(15, 23, 42, 0.04), 0 1px 3px 0 rgba(15, 23, 42, 0.06);
  background-color: #ffffff;
}
.card-header {
  background-color: #f8fafc;
  border-bottom: 1px solid #e2e8f0;
  font-weight: 600;
}
.btn-primary { font-weight: 500; }
.form-control:focus, .form-select:focus {
  border-color: #4f46e5 !important;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15) !important;
}
.table {
  --bs-table-border-color: #e2e8f0;
  --bs-table-striped-bg: #f8fafc;
}
.navbar { box-shadow: 0 1px 3px rgba(15, 23, 42, 0.05); }
",
);
