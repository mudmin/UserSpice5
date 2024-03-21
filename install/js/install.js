$( document ).ready(function() {
    var tz = $("#timezone").val();
    if(tz != null){
        console.log("not");
        $("#sub").show();
        $("#nosub").hide();
    }
});
$( '#timezone' ).select2( {
    theme: 'bootstrap-5'
} );
$("#timezone").change(function () {
    var tz = this.value;
    if(tz != ""){
        $("#sub").show();
        $("#nosub").hide();
    }else{
        $("#sub").hide();
        $("#nosub").show();
    }
});