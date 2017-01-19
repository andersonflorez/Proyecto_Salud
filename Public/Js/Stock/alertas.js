var alertaActiva=false;
var ocultar;
var tiempo= document.querySelector(".cont-alertas").getAttribute("data-tiempo");

$(document).ready(function () {
  $('.cerrar-alerta').click(function () {
    cerrarAlerta();
  });
});

function alerta(tipo,titulo,msm) {
  cerrarAlerta();
  $( ".cont-alertas" ).animate({
    bottom:20
  }, 100, function() {
    if(tipo==='exito'){
      if(titulo==null){
        $('.title-alerta').text('Éxito');
      }else {
        $('.title-alerta').text(titulo);
      }
      $('.alerta').addClass('exito');
    }

    else if(tipo==='error') {
      if(titulo==null){
        $('.title-alerta').text('Error !!');
      }else {
        $('.title-alerta').text(titulo);
      }
      $('.alerta').addClass('error');
    }

    else if(tipo==='adcia') {
      if(titulo==null){
        $('.title-alerta').text('! Advertencia !');
      }else {
        $('.title-alerta').text(titulo);
      }
      $('.alerta').addClass('adcia');
    }

    else if(tipo==='info') {
      if(titulo==null){
        $('.title-alerta').text('Información');
      }else {
        $('.title-alerta').text(titulo);
      }
      $('.alerta').addClass('info');
    }

    $('.contenido-alerta').text(msm);
      ocultar= window.setTimeout(cerrarAlerta, tiempo);
  });

}

function cerrarAlerta() {
  $( '.cont-alertas' ).css({'bottom':'-200px'});

  if ($(".alerta").hasClass("exito")) {
    $('.alerta').removeClass('exito');
  }
  else if ($(".alerta").hasClass("info")) {
    $('.alerta').removeClass('info');
  }
  else if ($(".alerta").hasClass("error")) {
    $('.alerta').removeClass('error');
  }
  else if ($(".alerta").hasClass("adcia")) {
    $('.alerta').removeClass('adcia');
  }
  clearTimeout(ocultar);
}
