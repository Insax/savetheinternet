$("#country-sel").change(function(){
    var selVal = $(this).val();
    $(".mep-item").css("display", "none");
    $("." + selVal.toLowerCase().replace(/\s/g, "")).css("display", "block");
});
