function usMessage(msg,cls="",timeout=10,div="msgUserSpiceMessage") {
  timeout = timeout * 1000;
  if(cls == ""){
    cls="success";
  }
  $('#'+div+'s').removeClass();
  $('#'+div).text("");
  $('#'+div+'s').show();
  $('#'+div+'s').addClass("sufee-alert alert with-close alert-"+cls+" alert-dismissible fade show usmsg");
  // Same allowlist sanitizer as the toast bar (system_messages_footer.php).
  // Without it, fall back to plain text rather than raw HTML.
  if (typeof window.usSanitizeMessage === 'function') {
    $('#'+div).html(window.usSanitizeMessage(msg));
  } else {
    $('#'+div).text(String(msg == null ? '' : msg));
  }
  $('#'+div+'s').delay(timeout).fadeOut('slow');
}
