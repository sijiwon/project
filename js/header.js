var lnb = $("#header_wrap").offset().top;
$(window).scroll(function() {
  	var window = $(this).scrollTop();

    if(lnb <= window) {
      $("#header_wrap").addClass("fixed");
    } else {
      $("#header_wrap").removeClass("fixed");
    }
})