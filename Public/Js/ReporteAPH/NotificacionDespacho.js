$(document).ready(function(){
  var idDespacho = JSON.parse(localStorage.getItem("ReporteAPH-idDespachoNotificate")) || "";
  ConsultarNotificacionContarDespacho(idDespacho);
  ConsultarNotificacionDescripcionDespacho(idDespacho);

  // function ConsultarNotificacionContarDespacho(){
  //   $.ajax({
  //     type:'POST',
  //     dataType:'json',
  //     url:url + 'ReporteAPH/ctrlIndex/RecibirNumeroNotificacion/2',
  //     data:{'idDespacho':idDespacho}
  //   }).done(function(lista){
  //     nuevaNotificacion(lista.Numero,true);
  //     var valor = $("#flotante-notify").attr("contador");
  //     if (valor == 0) {
  //       $("#flotante-notify").removeClass("flotante-notify")
  //     }
  //   }).error(function(err){
  //     alert("no finish");
  //   })
  // }
  // function ConsultarNotificacionDescripcionDespacho(){
  //   $.ajax({
  //     type:'POST',
  //     dataType:'json',
  //     url:url + 'ReporteAPH/ctrlIndex/RecibirDescripcionNotificacion/2',
  //     data:{'idDespacho':idDespacho}
  //   }).done(function(lista){
  //     $.each(lista, function(e,d){
  //       $('#ContenedorNotifyAPH').append(
  //         '<a href="#">'+
  //         '<div class="notificacion-f n-llamada">'+
  //         '<div class="icon-llamada">'+
  //         '<span class="fa fa-exclamation" style="padding: 0.7em 0.7em !important"></span>'+
  //         '</div>'+
  //         '<div class="contenido-notifiN">'+
  //         '<h5>EMERGENCIA! <span id="spanFecha">'+d.fechaHoraAproximadaEmergencia+'</span></h5>'+
  //         '<p id="pinformacionInicial">'+
  //         ''+d.informacionInicial+''+
  //         '</p>'+
  //         '<p id="pubicacion"><b>Dirección:</b> '+d.ubicacionIncidente+'</p>'+
  //         '<p id="pdescripciontipoEvento"><b>Tipos de evento:</b>'+d.descripciontipoevento+'</p>'+
  //         '</div>'+
  //         '</div>'+
  //         '</a>');
  //       })
  //     }).error(function(err){
  //       alert("no finish");
  //     })
  //   }
})
