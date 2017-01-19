$(document).ready(function () {
  ProgresoHistoriaClinica();
});

$(window).resize(function() {
  ProgresoHistoriaClinica();
});

var validarBarraProgreso = function (vista) {
  $.ajax({
    type:'POST',
    dataType:'JSON',
    url:url+'ReporteAPH/'+vista+'/BarraProgreso',
    data: {"vistaRedireccionar":vista}
  }).done(function(data){
    window.location = url + "ReporteAPH/"+vista;
  }).fail(function (data) {
    window.location = url + "ReporteAPH/"+vista;
  })


}

var ProgresoHistoriaClinica = function () {
  
  var widthBarraprogreso = $('.barra-progreso').width(),
  cantidadVistas = $( "#progressbar" ).attr( 'ancho' );
  progreso  = "0",
  valor = widthBarraprogreso / 8;

  progreso = ( widthBarraprogreso * cantidadVistas ) / 8 ;
  progreso = progreso - valor;
  $('#progressbar').css({
    width:progreso + 'px'
  })

}
