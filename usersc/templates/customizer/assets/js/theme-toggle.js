/*
 * UserSpice Customizer — light/dark toggle.
 *
 * Loaded site-wide by the customizer template (footer.php) only when a dark
 * preset has been paired in the customizer's Light/Dark Mode panel. The
 * generated stylesheet carries both colour modes (":root" + "[data-bs-theme=
 * 'dark']"); this script just flips the data-bs-theme attribute and remembers
 * the visitor's choice.
 *
 * No inline handlers — CSP-safe. The pre-paint attribute set (to avoid a
 * flash of the wrong theme) happens in the template's header.php; this file
 * handles the button wiring and persistence.
 */
(function () {
  'use strict';

  var STORAGE_KEY = 'customizerColorMode';
  var root = document.documentElement;

  function currentMode() {
    return root.getAttribute('data-bs-theme') === 'dark' ? 'dark' : 'light';
  }

  function readSaved() {
    try {
      var v = localStorage.getItem(STORAGE_KEY);
      return (v === 'dark' || v === 'light') ? v : null;
    } catch (e) {
      return null;
    }
  }

  function prefersDark() {
    return !!(window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches);
  }

  function applyMode(mode) {
    root.setAttribute('data-bs-theme', mode);
    syncButton(mode);
  }

  // Reflect the active mode on the toggle button (icon + ARIA state).
  function syncButton(mode) {
    var btn = document.getElementById('customizerThemeToggle');
    if (!btn) {
      return;
    }
    var icon = btn.querySelector('i');
    if (icon) {
      icon.className = (mode === 'dark') ? 'fas fa-sun' : 'fas fa-moon';
    }
    btn.setAttribute('aria-pressed', mode === 'dark' ? 'true' : 'false');
    btn.title = (mode === 'dark') ? 'Switch to light mode' : 'Switch to dark mode';
  }

  // Resolve and apply the initial mode immediately (header.php normally did
  // this pre-paint already; re-applying is harmless and covers the case where
  // the pre-paint script is absent).
  var saved = readSaved();
  applyMode(saved || (prefersDark() ? 'dark' : 'light'));

  document.addEventListener('DOMContentLoaded', function () {
    var btn = document.getElementById('customizerThemeToggle');
    if (!btn) {
      return;
    }
    syncButton(currentMode());
    btn.addEventListener('click', function () {
      var next = currentMode() === 'dark' ? 'light' : 'dark';
      applyMode(next);
      try {
        localStorage.setItem(STORAGE_KEY, next);
      } catch (e) {
        /* storage unavailable — the choice just won't persist */
      }
    });
  });

  // If the visitor has never made an explicit choice, follow live OS changes.
  if (window.matchMedia) {
    var mq = window.matchMedia('(prefers-color-scheme: dark)');
    var onChange = function (e) {
      if (readSaved() === null) {
        applyMode(e.matches ? 'dark' : 'light');
      }
    };
    if (mq.addEventListener) {
      mq.addEventListener('change', onChange);
    } else if (mq.addListener) {
      mq.addListener(onChange);
    }
  }
})();
