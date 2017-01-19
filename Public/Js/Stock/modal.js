/*$(document).ready(function(){
  $('.md-abrir').click(function(){
    $('.md-fondo').css({
      visibility:'visible',
      transform: 'scale(1)',
      opacity: '1',
      transition: 'all 0s cubic-bezier(0.25, 0.5, 0.5, 0.9)',
    });

    $('.md-modal').css({
      visibility:'visible',
      transform: 'translateY(10%)',
      transition: 'all 1s cubic-bezier(0.25, 0.5, 0.5, 0.9)',
      opacity: '1s'
    });
  });

  $('.cerrar').click(function(){
    $('.md-fondo').css({
      visibility:'hidden',
      transform: 'scale(1)',
      opacity: '1',
      transition: 'all 0.6s cubic-bezier(0.25, 0.5, 0.5, 0.9)',
    });

    $('.md-modal').css({
      visibility:'hidden',
      transform: 'translateY(-150%)',
      transition: 'all 1s cubic-bezier(0.25, 0.5, 0.5, 0.9)',
      opacity: '1s'
    });
  });
});*/

/*============== Modal 2.0  ================*/

  function AbrirModal (nombreModal) {
    var hijoModal=$('#'+nombreModal).children('div');

    $('#'+nombreModal).css({
      visibility:'visible',
      transform: 'scale(1)',
      opacity: '1',
      transition: 'all 0s cubic-bezier(0.25, 0.5, 0.5, 0.9)',
    });

    $(hijoModal).css({
      visibility:'visible',
      transform: 'translateY(10%)',
      transition: 'all 1s cubic-bezier(0.25, 0.5, 0.5, 0.9)',
      opacity: '1s'
    });
}

function cerrarModal  (nombreModal) {
  var hijoModal=$('#'+nombreModal).children('div');

  $('#'+nombreModal).css({
    visibility:'hidden',
    transform: 'scale(1)',
    opacity: '1',
    transition: 'all 0.6s cubic-bezier(0.25, 0.5, 0.5, 0.9)',
  });

  $(hijoModal).css({
    visibility:'hidden',
    transform: 'translateY(-150%)',
    transition: 'all 1s cubic-bezier(0.25, 0.5, 0.5, 0.9)',
    opacity: '1s'
  });
}
