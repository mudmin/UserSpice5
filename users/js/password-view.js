/*
 * Show/hide control for the #password and #confirm fields.
 *
 * Wires every .password_view_control, which must be a <button> so keyboard and
 * touch users can reach it. Hovering still peeks at the password (the original
 * mouse behavior); a click, Enter or Space toggles it on until toggled off.
 * aria-pressed and the eye / eye-slash icon show which state it is in, and the
 * fields go back to type="password" before the form submits so browsers and
 * password managers never see a password submitted as plain text.
 */
document.addEventListener('DOMContentLoaded', function () {
  var controls = document.querySelectorAll('.password_view_control');
  if (!controls.length) {
    return;
  }
  var fields = ['password', 'confirm']
    .map(function (id) { return document.getElementById(id); })
    .filter(Boolean);
  var shown = false;

  function render(peek) {
    var visible = shown || peek;
    fields.forEach(function (f) { f.type = visible ? 'text' : 'password'; });
    controls.forEach(function (c) {
      c.setAttribute('aria-pressed', shown ? 'true' : 'false');
      var icon = c.querySelector('.fa-eye, .fa-eye-slash');
      if (icon) {
        icon.classList.toggle('fa-eye', !shown);
        icon.classList.toggle('fa-eye-slash', shown);
      }
    });
  }

  controls.forEach(function (c) {
    c.setAttribute('aria-pressed', 'false');
    c.addEventListener('mouseenter', function () { render(true); });
    c.addEventListener('mouseleave', function () { render(false); });
    c.addEventListener('click', function (e) {
      e.preventDefault();
      shown = !shown;
      render(false);
    });
  });

  fields.forEach(function (f) {
    if (f.form) {
      f.form.addEventListener('submit', function () {
        shown = false;
        render(false);
      });
    }
  });
});
