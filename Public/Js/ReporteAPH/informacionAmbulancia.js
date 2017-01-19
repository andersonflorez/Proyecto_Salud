
$( document ).ready(function() {

$('.abrir-menu-ambulancias').click(function(){
  $('div.contenedor-ambulancia').css({
    transition:'all 0.3s',
    right: '0'
  });
});
$('.cerrar-menu-ambulancia').click(function(){
  $('div.contenedor-ambulancia').css({
    transition:'all 0.3s',
    right: '-1000px'
  });
});

listarAmbulancias();


});



function desplegarInformacion(id){

  $('#info' + id + ' > .cuerpo-ambulancia').slideToggle(200,function(){

    if ( $('#' + id + ' > .cuerpo-ambulancia').is(":visible")){
      $('#' + id + ' span').removeClass('fa-plus-circle');
      $('#' + id + ' span').addClass('fa-minus-circle');
    }else{
      $('#' + id + ' span').removeClass('fa-minus-circle');
      $('#' + id + ' span').addClass('fa-plus-circle');
    }

  });

}


function listarAmbulancias(){

  var consulta = localStorage.getItem("ReporteAPH-ReporteInicial");

    if (consulta != null) {
        consulta = JSON.parse(consulta);
        var idReporteInicial = (consulta.idReporteInicial);
        var idAmbulancia = (consulta.idAmbulancia);
    }else {
      var idReporteInicial = 0;
    }


    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: url+"ReporteAPH/ctrlLayoutReporteAPH/ListadoAmbulancias",
      data: {"idReporteInicial": idReporteInicial}
    }).done(function (e) {
      var classColor = '';
      $.each(e, function (l, s) {

        if (idAmbulancia == s.idAmbulancia) {
              $(".contenedor-cuerpo").append("<div class='informacion-ambulancia' id='info"+s.idAmbulancia+"'><div class='head-ambulancia' onclick=\"desplegarInformacion("+s.idAmbulancia+")\"><div class='titulo-ambulancia'><span class='fa fa-plus-circle'></span><h5'>Ambulancia #"+s.idAmbulancia +"</h5></div><p class='estado-ambulancia"+s.idAmbulancia+" ponerEstado"+s.idAmbulancia+"'><span class='mi-ambulancia fa fa-thumb-tack'></span></p></div><div class='cuerpo-ambulancia'><ul><li><span class='fa fa-ambulance'></span>Tipo de ambulancia:<p>"+s.tipoAmbulancia+"</p></li><li><span class='fa fa-cab'></span>placa:<p>"+s.placaAmbulancia+"</p></li><li><span class='fa fa-file'></span> Estado de la ambulancia: <p class='ponerEstado"+s.idAmbulancia+"'>"+s.estadoTabla+"</p></li><li><span class='fa fa-calendar'></span> Fecha de despacho: <p>"+s.fechaHoraDespacho+"</p></li><li><span class='fa fa-file'></span>Estado Reporte I: <p>"+s.estadoDespacho+"</p></li></ul></div></div>");
        }else {
              $(".contenedor-cuerpo").append("<div class='informacion-ambulancia' id='info"+s.idAmbulancia+"'><div class='head-ambulancia' onclick=\"desplegarInformacion("+s.idAmbulancia+")\"><div class='titulo-ambulancia'><span class='fa fa-plus-circle'></span><h5'>Ambulancia #"+s.idAmbulancia +"</h5></div><p class='estado-ambulancia"+s.idAmbulancia+" ponerEstado"+s.idAmbulancia+"'>"+s.estadoTabla+"</p></div><div class='cuerpo-ambulancia'><ul><li><span class='fa fa-ambulance'></span>Tipo de ambulancia:<p>"+s.tipoAmbulancia+"</p></li><li><span class='fa fa-cab'></span>placa:<p>"+s.placaAmbulancia+"</p></li><li><span class='fa fa-file'></span> Estado de la ambulancia: <p class='ponerEstado"+s.idAmbulancia+"'>"+s.estadoTabla+"</p></li><li><span class='fa fa-calendar'></span> Fecha de despacho: <p>"+s.fechaHoraDespacho+"</p></li><li><span class='fa fa-file'></span>Estado Reporte I: <p>"+s.estadoDespacho+"</p></li></ul></div></div>");
        }



        })
    }).fail(function (e) {
      return false;
    })
}

var actualizar = {
  init:function(){
    $('#BtnActualizar').click(function(){
actualizar.Update();
    })
  },
   Update:function(){
  $.ajax({
      type: 'POST',
      dataType: 'html',
      url: url+"ReporteAPH/ctrlLayoutReporteAPH/actualizarEstadoNuevo",
      data: new FormData(document.getElementById("formulario")),
      contentType:false,
      processData:false
    }).done(function (e) {
send(e);
    }).fail(function () {
        console.log("error");
    })
}
}
