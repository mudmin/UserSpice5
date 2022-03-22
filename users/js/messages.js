function usMessage(msg,cls="",timeout=10,div="msgUserSpiceMessage") {
  timeout = timeout * 1000;
  if(cls == ""){
    cls="success";
  }
  $('#'+div+'s').removeClass();
  $('#'+div).text("");
  $('#'+div+'s').show();
  $('#'+div+'s').addClass("sufee-alert alert with-close alert-"+cls+" alert-dismissible fade show usmsg");
  $('#'+div).html(msg);
  $('#'+div+'s').delay(timeout).fadeOut('slow');
}
