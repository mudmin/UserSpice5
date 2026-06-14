/**
 * UserSpice CSP-friendly admin event handlers.
 *
 * Replaces inline onclick/onsubmit="return confirm(...)" attributes so the
 * admin interface can run under a Content-Security-Policy without
 * 'unsafe-inline' in script-src. Inline attribute handlers cannot be
 * authorized by a nonce or a hash, so they must be bound from JavaScript.
 *
 * Usage:
 *   - On a <form>:  data-us-confirm="message"  gates submission (covers the
 *     Enter key, not just button clicks).
 *   - On a link or button:  data-us-confirm="message"  gates the click. Use
 *     this form when a single form has more than one submit button.
 */
(function () {
  'use strict';

  // Read the confirm message, turning a literal "\n" into a real line break so
  // multi-line prompts can be written plainly in an HTML attribute.
  function confirmMessage(el) {
    return (el.getAttribute('data-us-confirm') || '').replace(/\\n/g, '\n');
  }

  // Forms: gate submission. Capture phase so we run before the submit proceeds.
  document.addEventListener('submit', function (e) {
    var form = e.target.closest && e.target.closest('form[data-us-confirm]');
    if (form && !window.confirm(confirmMessage(form))) {
      e.preventDefault();
    }
  }, true);

  // Links and standalone buttons: gate the click/navigation.
  document.addEventListener('click', function (e) {
    var el = e.target.closest && e.target.closest('[data-us-confirm]');
    if (!el || el.tagName === 'FORM') {
      return; // forms are handled by the submit listener above
    }
    if (!window.confirm(confirmMessage(el))) {
      e.preventDefault();
    }
  }, true);
})();
