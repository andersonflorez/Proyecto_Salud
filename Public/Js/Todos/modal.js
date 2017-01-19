/**
*   Modales V3.0
*/

$(".btn-modal").click(function () {
  let target = $(this).attr("target");
  AbrirModal(target);
});

$(".btn-cerrar-modal").click(function () {
  CerrarModal($(this).parents().find('.modal-ventana'));
});

function AbrirModal(idModal) {
  $('#'+idModal).css({
    transition: '0s',
    transform: 'scale(1) '
  });
  $('#'+idModal+' .modal').css({
    transition: '0.5s',
    transform: 'scale(1) ',
    opacity: '1'
  });
}

function CerrarModal(modal) {

  modal.find('.modal').css({
    transition: '0.5s',
    transform: 'scale(0) ',
    opacity: '0'
  });

  setTimeout(
    function(){
      modal.css({
        transition: '0',
        transform: 'scale(0) '
      });
    }, 400);
  }


  $('.modal-ventana').click(function() {
    if(!$(this).hasClass('dont_close')) {
      CerrarModal($(this));
    }
  });
  $('.modal').click(function(e){
    e.stopPropagation();
  });
