$(document).ready(function() {
  localStorage.clear();
  // Smooth Scrolling
  $('a[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 700);
        return false;
      }
    }
  });


  $('.learnVideo').click(function () {
    var url = $(this).attr('video');
    $('#iframeVideo').attr('src', url);
    $('.verVideo').css({"top":"0"});
  });

  $('#cerrarVideo').click(function () {
    $('.verVideo').css({"top":"-2000px"});
  });

});
