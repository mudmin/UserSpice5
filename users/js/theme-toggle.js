/*
 * UserSpice core — light / dark colour-mode toggle.
 *
 * Wires every element carrying the class "us-theme-toggle" (the UltraMenu
 * snippet item from users/includes/menu_hooks/theme_toggle.php, plus any
 * template-provided fallback button). Flips data-bs-theme on <html>,
 * persists the choice to localStorage, and follows prefers-color-scheme
 * until the visitor makes an explicit choice.
 *
 * CSP-safe: external file, no inline handlers. Loaded with a nonce'd
 * <script> tag by whichever toggle rendered.
 *
 * The pre-paint script in the template header normally sets data-bs-theme
 * before first paint; this file re-applies the same value (harmless) and
 * adds the interactive behaviour.
 */
(function () {
  'use strict';

  var STORAGE_KEY = 'usColorMode';
  // Pre-core key used by the standalone customizer toggle. Read once so an
  // existing visitor keeps their choice after the core toggle takes over.
  var LEGACY_KEY = 'customizerColorMode';
  var root = document.documentElement;

  function readSaved() {
    try {
      var v = localStorage.getItem(STORAGE_KEY);
      if (v !== 'dark' && v !== 'light') {
        var legacy = localStorage.getItem(LEGACY_KEY);
        if (legacy === 'dark' || legacy === 'light') {
          try { localStorage.setItem(STORAGE_KEY, legacy); } catch (e) { /* ignore */ }
          v = legacy;
        }
      }
      return (v === 'dark' || v === 'light') ? v : null;
    } catch (e) {
      return null;
    }
  }

  function prefersDark() {
    return !!(window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches);
  }

  function currentMode() {
    return root.getAttribute('data-bs-theme') === 'dark' ? 'dark' : 'light';
  }

  // Reflect the active mode on every toggle (icon + ARIA + tooltip).
  function syncButtons(mode) {
    var btns = document.querySelectorAll('.us-theme-toggle');
    for (var i = 0; i < btns.length; i++) {
      var btn = btns[i];
      var icon = btn.querySelector('i');
      if (icon) {
        icon.className = (mode === 'dark') ? 'fas fa-sun' : 'fas fa-moon';
      }
      btn.setAttribute('aria-pressed', mode === 'dark' ? 'true' : 'false');
      btn.title = (mode === 'dark') ? 'Switch to light mode' : 'Switch to dark mode';
    }
  }

  function applyMode(mode) {
    root.setAttribute('data-bs-theme', mode);
    syncButtons(mode);
  }

  // Resolve and apply immediately. The template's pre-paint script normally
  // did this already; re-applying is harmless and covers templates without it.
  var saved = readSaved();
  applyMode(saved || (prefersDark() ? 'dark' : 'light'));

  document.addEventListener('DOMContentLoaded', function () {
    syncButtons(currentMode());
    var btns = document.querySelectorAll('.us-theme-toggle');
    for (var i = 0; i < btns.length; i++) {
      btns[i].addEventListener('click', function () {
        var next = currentMode() === 'dark' ? 'light' : 'dark';
        applyMode(next);
        try {
          localStorage.setItem(STORAGE_KEY, next);
        } catch (e) {
          /* storage unavailable — the choice just won't persist */
        }
      });
    }
  });

  // Until the visitor makes an explicit choice, follow live OS changes.
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
