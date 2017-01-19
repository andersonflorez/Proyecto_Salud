$(document).ready(function () {
  var con1 = 0;
  var con2 = 0;

  $('.btn-menu-movil').click(function () {
    if (con1 == 0) {
      $('.menu-maestras').css({
        left: '0%',
        transition: '1s all'
      });
      if (con2 == 0) {
        $('.girar').css({
          transform: 'rotate(360deg)',
          transition: '1s all'
        });
        con2 = 1;
      } else {


        $('.girar').css({
          transform: 'rotate(0)',
          transition: '1s all'
        });
        con2 = 0;
      }
    }


  });


  $('.cerrar-menu-configuracion').click(function () {
    $('.menu-maestras').css({
      left: '-50%',
      transition: '1s all'
    });
  });

});


