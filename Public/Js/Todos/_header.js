// Preloader de la pagina
$(window).load(function() {
	$("#img_preloader").fadeOut();
	$("#preloader").delay(1000).fadeOut("slow");
});

$(document).ready(function() {

  var mobileMenu = $('.mobile_menu');

  $('.mobile_menu .items .view').click(function() {
    let ancla = $(this).children('a');
    let unorderedList = $(this).children('ul');

    if (ancla.hasClass('active')) {
      ancla.removeClass('active');
      unorderedList.css({
        'max-height': '0px',
        'transition': '.1s max-height ease'
      });
    } else {
      let active = $('.mobile_menu .items').find('.active');

      if (active.length) {
        active.parent().children('ul').css({
          'max-height': '0px',
          'transition': '.1s max-height ease'
        });
        active.removeClass('active');
      }

      ancla.addClass('active');
      unorderedList.css({
        'max-height': '500px',
        'transition': '.5s max-height linear'
      });
    }
  });

  var toggleMobileMenu = function() {
    let val = mobileMenu.css('left') === '0px' ? '-100%' : '0px';
    mobileMenu.css({
      'left': val
    });
  };

  $('.toggle_mobile_menu').click(function() {
    toggleMobileMenu();
  });

  $('html').click(function() {
    if (mobileMenu.css('left') === '0px') {
      toggleMobileMenu();
    }

    if ($('#menu_perfil_user').css('display') === 'block') {
      $('#menu_perfil_user').animate({
        height: 'toggle',
        opacity: 'toggle'
      }, 'fast');
    }
  });

  $('#menu_perfil_user, #perfil-usuario, .mobile_menu').click(function(e) {
    e.stopPropagation();
  });

});
