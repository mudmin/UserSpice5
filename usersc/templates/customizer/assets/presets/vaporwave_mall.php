<?php
/**
 * Preset: Vaporwave Mall
 * Category: Wild
 * Description: Soft pastels — peach, teal, lavender. Palm-tree-on-VHS energy.
 * Tags: light, expressive, retro, pastel, dreamy
 * Mode: light
 * Author: UserSpice Customizer Theme
 */
return array (
  'primary' => '#ff6b9d',
  'primary-hover' => '#f25590',
  'primary-text-emphasis' => '#7a2950',
  'primary-bg-subtle' => '#ffdbe7',
  'primary-border-subtle' => '#ffb0cb',

  'secondary' => '#4dd0e1',
  'secondary-hover' => '#3bb6c6',
  'secondary-text-emphasis' => '#1e5560',
  'secondary-bg-subtle' => '#d8f3f7',
  'secondary-border-subtle' => '#a3e1ea',

  'success' => '#aed581',
  'success-hover' => '#98c267',
  'success-text-emphasis' => '#4a6029',
  'success-bg-subtle' => '#e8f3d8',
  'success-border-subtle' => '#cce4ab',

  'info' => '#b39ddb',
  'info-hover' => '#9c84c4',
  'info-text-emphasis' => '#43325f',
  'info-bg-subtle' => '#ebe2f4',
  'info-border-subtle' => '#cebde6',

  'warning' => '#ffd54f',
  'warning-hover' => '#f0c33b',
  'warning-text-emphasis' => '#6e5a14',
  'warning-bg-subtle' => '#fff3cf',
  'warning-border-subtle' => '#fee49a',

  'danger' => '#ff8a80',
  'danger-hover' => '#f47670',
  'danger-text-emphasis' => '#7a2620',
  'danger-bg-subtle' => '#ffdfdd',
  'danger-border-subtle' => '#ffb6b0',

  'light' => '#fce4ec',
  'light-hover' => '#f3d2db',
  'light-text-emphasis' => '#4a3c5e',
  'light-bg-subtle' => '#fef0f4',
  'light-border-subtle' => '#f0c8d3',

  'dark' => '#311b3b',
  'dark-hover' => '#231429',
  'dark-text-emphasis' => '#180e1e',
  'dark-bg-subtle' => '#a892ad',
  'dark-border-subtle' => '#5a3a64',

  'body-color' => '#4a3c5e',
  'body-bg' => '#fef0f4',
  'border-color' => '#f0c8d3',
  'form-control-bg' => '#ffffff',

  'us-menu-custom-bg' => '#311b3b',
  'us-menu-custom-text' => '#fce4ec',
  'us-menu-custom-hover-bg' => '#ff6b9d',
  'us-menu-custom-hover-text' => '#ffffff',
  'us-menu-custom-active-bg' => '#4dd0e1',
  'us-menu-custom-active-text' => '#311b3b',
  'us-menu-custom-divider' => 'rgba(255, 107, 157, 0.3)',
  'us-menu-custom-submenu-border' => '#4dd0e1',

  'headings-color' => 'var(--bs-primary)',

  'custom_css' => "
/* === VAPORWAVE MALL === pastel dream, no neon */
body {
  background:
    radial-gradient(ellipse at top, #fce4ec 0%, transparent 50%),
    radial-gradient(ellipse at bottom right, #d8f3f7 0%, transparent 50%),
    radial-gradient(ellipse at bottom left, #ebe2f4 0%, transparent 50%),
    #fef0f4 fixed;
  min-height: 100vh;
}
h1, h2, h3, .h1, .h2, .h3 {
  font-weight: 300;
  letter-spacing: 0.06em;
  text-transform: uppercase;
}
.card {
  background-color: rgba(255, 255, 255, 0.7);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(255, 107, 157, 0.2);
  border-radius: 18px;
  box-shadow: 0 4px 18px rgba(255, 107, 157, 0.12);
}
.card-header {
  background: linear-gradient(120deg, #ff6b9d, #b39ddb, #4dd0e1) !important;
  color: #ffffff !important;
  font-weight: 600;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  border-radius: 18px 18px 0 0 !important;
}
.btn {
  border-radius: 30px;
  font-weight: 500;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  padding: 0.5rem 1.5rem;
}
.form-control, .form-select {
  border-radius: 14px;
  border: 1px solid #f0c8d3 !important;
  background-color: rgba(255, 255, 255, 0.85);
}
.form-control:focus, .form-select:focus {
  border-color: #ff6b9d !important;
  box-shadow: 0 0 0 0.2rem rgba(255, 107, 157, 0.2) !important;
}
.modal-content { border-radius: 22px; border: none; }
.badge { border-radius: 14px; }
.alert { border-radius: 16px; border: none; }
",
);
