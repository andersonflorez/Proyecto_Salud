var cedula;
var cedulaTemporal;
var datos;
var reporte;

function ListarSolicitudesA() {
  var consultaPaciente = JSON.parse(localStorage.getItem("ReporteAPH-Paciente"));
  if (consultaPaciente != null) {
    cedulaTemporal = consultaPaciente['documento'];
    var modoConsulta = JSON.parse(localStorage.getItem("ReporteAPH-idReporteAPH"));
    if (modoConsulta != null) {
      reporte = modoConsulta;
    } else {
      reporte = 0;
    }
  } else {};


  $.ajax({
    type: 'POST',
    dataType: 'json',
    url: url + "ReporteAPH/ctrlTratamientoA/ListadoAutorizacion",
    data: {
      "idReporte": reporte,
      "cedulaPaciente": cedulaTemporal
    }
  }).done(function(e) {
    $.each(e, function(l, s) {
      if (s.estadoEvaluacion == 'Por Evaluar') {
        var id = s.idTipoTratamiento;
        var fecha = s.fechaEnvio;
        var cedula = s.cedulaPaciente;
        if (s.Descripcion == "Dextrosa") {
          $('.checkTratamiento1'+id).removeAttr('ng-click');
          $('.checkTratamiento1' + id).attr('onclick', 'cancelarAutorizacion_vistaDextrosa("' + id + '","' + fecha + '", "' + cedula + '")');
        }else{
          $('.checkTratamiento1'+id).removeAttr('ng-click');
          $('.checkTratamiento1' + id).attr('onclick', 'cancelarAutorizacion_vista1("' + id + '","' + fecha + '", "' + cedula + '")');
        }
        $('#id_lbl_' + id).attr('style', 'height: 28px !important');
        $('#id_lbl_' + id).empty();
        $('#id_lbl_' + id).append("<div id='id_div_" + id + "'><i class='fa fa-question-circle'></i><div>");
        $('#id_lbl_' + id).removeAttr('ng-click');
        $('#id_lbl_' + id).attr('onclick', 'cancelarAutorizacion_vista("' + id + '","' + fecha + '", "' + cedula + '")');
    } else if (s.estadoEvaluacion == 'Aprobada') {
        if (s.Descripcion == "Dextrosa") {
          $('.checkTratamiento1'+id).removeAttr('onclick');
          $('.checkTratamiento1'+id).attr('ng-click','GuardarTratamiento();abrirModalAutorizacionDextrosa('+s.idTipoTratamiento+','+s.Descripcion+')');
        }else{
          $('.checkTratamiento1'+id).removeAttr('onclick');
          $('.checkTratamiento1'+id).attr('ng-click','GuardarTratamiento();abrirModalAutorizacion1('+s.idTipoTratamiento+','+s.Descripcion+')');
        }
        var id = s.idTipoTratamiento;
        $('#id_lbl_' + id).empty();
        $('#id_lbl_' + id).removeAttr('onclick');
        $('#id_div_' + id).remove();
        $('#id_lbl_' + id).attr('style', 'background:#2ecc71 !important;border: solid 1px #2ecc71 !important;color: #fff !important;height: 28px;');
        $('#id_lbl_' + id).append("<div id='id_div_" + id + "'><i class='fa fa-check-circle'></i></i><div>");
      } else if (s.estadoEvaluacion == 'Cancelado') {
        var id = s.idTipoTratamiento;
        if (s.Descripcion == "Dextrosa") {
          $('.checkTratamiento1'+id).removeAttr('onclick');
          $('.checkTratamiento1'+id).attr('ng-click','GuardarTratamiento();abrirModalAutorizacion1('+s.idTipoTratamiento+','+s.Descripcion+')');
        }else{
          $('.checkTratamiento1'+id).removeAttr('onclick');
          $('.checkTratamiento1'+id).attr('ng-click','abrirModalAutorizacionDextrosa('+s.idTipoTratamiento+','+s.Descripcion+');');
        }
        $('#id_lbl_' + id).empty();
        $('#id_lbl_' + id).removeAttr('onclick');
        $('#id_lbl_' + id).attr('onclick', 'abrirModalAutorizacion(' + id + ')');
        $('#id_div_' + id).remove();
        $('#id_lbl_' + id).attr('style', 'background:#515554 !important;border: solid 1px #515554 !important;color: #fff !important;height: 28px;');
        $('#id_lbl_' + id).append("<div id='id_div_" + id + "'><i class='fa fa-ban'></i></i><div>");
        // if (s.Descripcion == "Dextrosa") {
        //     $('.checkTratamiento1'+id).removeAttr('onclick');
        //     $('.checkTratamiento1'+id).attr('ng-click','GuardarTratamiento();abrirModalAutorizacionDextrosa('+s.idTipoTratamiento+','+s.Descripcion+')');
        // }else{
        //     $('.checkTratamiento1'+id).removeAttr('onclick');
        //     $('.checkTratamiento1'+id).attr('ng-click','GuardarTratamiento();abrirModalAutorizacion1('+s.idTipoTratamiento+','+s.Descripcion+')');
        // }
        // var id = s.idTipoTratamiento;
        // $('#id_lbl_' + id).empty();
        // $('#id_lbl_' + id).removeAttr('onclick');
        // //$('#id_lbl_' + id).attr('onclick', 'abrirModalAutorizacion(' + id + ')');
        // $('#id_div_' + id).remove();
        // $('#id_lbl_' + id).attr('style', 'background:#515554 !important;border: solid 1px #515554 !important;color: #fff !important;height: 28px;');
        // $('#id_lbl_' + id).append("<div id='id_div_" + id + "'><i class='fa fa-ban'></i></i><div>");
      } else if (s.estadoEvaluacion == 'Rechazada') {

                        if (s.Descripcion == "Dextrosa") {
                          $('.checkTratamiento1'+id).removeAttr('onclick');
                          $('.checkTratamiento1'+id).attr('ng-click','GuardarTratamiento();abrirModalAutorizacionDextrosa('+s.idTipoTratamiento+','+s.Descripcion+')');
                        }else{
                          $('.checkTratamiento1'+id).removeAttr('onclick');
                          $('.checkTratamiento1'+id).attr('ng-click','GuardarTratamiento();abrirModalAutorizacion1('+s.idTipoTratamiento+','+s.Descripcion+')');
                        }
        var id = s.idTipoTratamiento;
        $('#id_lbl_' + id).empty();
        $('#id_lbl_' + id).removeAttr('onclick');
        //$('#id_lbl_' + id).attr('onclick', 'abrirModalAutorizacion(' + id + ')');
        $('#id_div_' + id).remove();
        $('#id_lbl_' + id).attr('style', 'background:rgba(229,74,101,0.9) !important;border: solid 1px rgba(229,74,101,0.9) !important;color: #fff !important;height: 28px;');
        $('#id_lbl_' + id).append("<div id='id_div_" + id + "'><i class='fa fa-times-circle'></i></i><div>");
      }
    });
    e.reverse();
    $('#listarTratamientoA').children().remove();
    $.each(e, function(l, s) {
      var descripcion_respuesta = (s.observacionRespuestaAutorizacion == null) ? 'Aún no hay respuesta.' : s.observacionRespuestaAutorizacion;
      $('#listarTratamientoA').append("<tr><td>" + s.Descripcion + "</td><td>" + s.descripcionAutorizacion + "</td><td>" + descripcion_respuesta + "</td><td>" + s.estadoEvaluacion + "</td></tr>");
    });
  }).fail(function() {

  });
}
function cancelarAutorizacion_vista(idTipoTratamiento, FechaEnvio, cedulaR){
  $("#cuadro_autorizacion").remove();
  $("body").append('<div class="" id="cuadro_autorizacion2"></div>');
  console.log("cancelar",$("#temporalAuto").length);
  var nombre_autorizacion = $('#id_check_' + idTipoTratamiento + '').val();
  $("#cuadro_autorizacion2").append('<div class="md_solicitarAyuda cancelarAutorizacion" id="abrirConfirmacion"><input type="text" id="txt_cedula_001" value="' + cedulaR + '" style="display:none"/><input type="text" id="txt_fecha_001" value="' + FechaEnvio + '" style="display:none"/><input type="text" id="lbl_tratamiento_' + idTipoTratamiento + '" style="display:none" value="' + nombre_autorizacion + '"></label><div class="head_md_confirmar"><h5 style="color: #fff">CANCELAR AUTORIZACION</h5></div><span style="float: right;float: rigth;margin-right: 10px;margin-top: -35px;color:#fff;cursor:pointer;" onclick="tratamiento.cerrarSolicitudAutorizacion1()">X</span><div class="contenido_md_confirmacion"><div class="contenido no-pad"><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente">Cancelar Autorizacion Para:  <b style="margin-left:5px"> ' + nombre_autorizacion + '</b></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><div class="cont-antecedente"><button type="button" name="" class="btn btn-cancelar" style="width: 100%;" onclick="tratamiento.cancelar_autorizacion(' + idTipoTratamiento + ')" >Cancelar Solicitud</button></div></div></div></div></div></div>');
  $("#cuadro_autorizacion1").remove();
}
function cancelarAutorizacion_vista1(idTipoTratamiento, FechaEnvio, cedulaR) {
  $("#cuadro_autorizacion2").remove();
  var registro = JSON.parse(localStorage.getItem("ReporteAPH-tratamientoAvanzado"));
  registro = registro["idTipoTratamiento"];
  var estado = 0;
    for (var i = 0; i < registro.length; i++) {
            if (registro[i] == idTipoTratamiento) {
              estado++;
            }
    };
    if (!estado == 0) {
    $("#cuadro_autorizacion").remove();
      $("body").append('<div class="" id="cuadro_autorizacion2"></div>');
      $(".temporalAuto").remove();
      var nombre_autorizacion = $('#id_check_' + idTipoTratamiento + '').val();
      $("#cuadro_autorizacion2").append('<div class="md_solicitarAyuda" id="abrirConfirmacion"><input type="text" id="txt_cedula_001" value="' + cedulaR + '" style="display:none"/><input type="text" id="txt_fecha_001" value="' + FechaEnvio + '" style="display:none"/><input type="text" id="lbl_tratamiento_' + idTipoTratamiento + '" style="display:none" value="' + nombre_autorizacion + '"></label><div class="head_md_confirmar"><h5 style="color: #fff">CANCELAR AUTORIZACION</h5></div><span style="float: right;float: rigth;margin-right: 10px;margin-top: -35px;color:#fff;cursor:pointer;" onclick="tratamiento.cerrarSolicitudAutorizacion1()">X</span><div class="contenido_md_confirmacion"><div class="contenido no-pad"><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente">Cancelar Autorizacion Para:  <b style="margin-left:5px"> ' + nombre_autorizacion + '</b></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><div class="cont-antecedente"><button type="button" name="" class="btn btn-cancelar" style="width: 100%;" onclick="tratamiento.cancelar_autorizacion(' + idTipoTratamiento + ')" >Cancelar Solicitud Autorización</button></div></div></div></div></div></div>');
      $("#cuadro_autorizacion1").remove();
      }else{

      }
      $("#cuadro_autorizacion1").remove();
  }

  function cancelarAutorizacion_vistaDextrosa(idTipoTratamiento, FechaEnvio, cedulaR) {
    $("#cuadro_autorizacion2").remove();
    var registro = JSON.parse(localStorage.getItem("ReporteAPH-tratamientoAvanzadoDextrosa"));
    registro = registro["idTipoTratamiento"];
    var estado = 0;
      for (var i = 0; i < registro.length; i++) {
              if (registro[i] == idTipoTratamiento) {
                estado++;
              }
      };
      if (!estado == 0) {
      $("#cuadro_autorizacion").remove();
        $("body").append('<div class="" id="cuadro_autorizacion2"></div>');
        $(".temporalAuto").remove();
        var nombre_autorizacion = $('#id_check_' + idTipoTratamiento + '').val();
        $("#cuadro_autorizacion2").append('<div class="md_solicitarAyuda" id="abrirConfirmacion"><input type="text" id="txt_cedula_001" value="' + cedulaR + '" style="display:none"/><input type="text" id="txt_fecha_001" value="' + FechaEnvio + '" style="display:none"/><input type="text" id="lbl_tratamiento_' + idTipoTratamiento + '" style="display:none" value="' + nombre_autorizacion + '"></label><div class="head_md_confirmar"><h5 style="color: #fff">CANCELAR AUTORIZACION</h5></div><span style="float: right;float: rigth;margin-right: 10px;margin-top: -35px;color:#fff;cursor:pointer;" onclick="tratamiento.cerrarSolicitudAutorizacion1()">X</span><div class="contenido_md_confirmacion"><div class="contenido no-pad"><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente">Cancelar Autorizacion Para:  <b style="margin-left:5px"> ' + nombre_autorizacion + '</b></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><div class="cont-antecedente"><button type="button" name="" class="btn btn-cancelar" style="width: 100%;" onclick="tratamiento.cancelar_autorizacion(' + idTipoTratamiento + ')" >Cancelar Solicitud Autorización</button></div></div></div></div></div></div>');
        $("#cuadro_autorizacion1").remove();
        }else{

        }
        $("#cuadro_autorizacion1").remove();
    }

function registrarAutorizacionMedicalizada(idT) {
  var registro = localStorage.getItem("ReporteAPH-Paciente");
  cedula = "";
  if (registro != null) {
    var cedulaPaci = JSON.parse(registro);
    cedula = cedulaPaci['documento'];
  } else {
    cedula == "NN";
  }
  var usuario = $("#usuarioMedico").val();
  var pass = $("#claveMedico").val();
  var descripcion = $("#txtDescripcion").val();
  var datos = "usuario=" + usuario + "&pass=" + pass + "&descripcion=" + descripcion + "&id=" + idT + "&cedula=" + cedula;
  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: url + 'ReporteAPH/ctrlTratamientoA/registrarAutorizacionMedicalizada',
    data: datos
  }).done(function(data) {
    ListarSolicitudesA();
  }).fail(function() {
    Notificate({
      tipo: 'Error',
      titulo: 'Error de autenticacione:',
      descripcion: 'Recuerde que debe ser un médico quien se autentique para registrar la autorización',
      duracion: 10
    });
  });
  $("#abrirConfirmacion").remove();
}

function crearNotificacion() {
  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: url + 'ReporteAPH/ctrlTratamientoB/ListarRespuestaNotificacion'
  }).done(function(data) {
    if (data[0]['estadoEvaluacion'] == 'Aprobada') {
      Notificate({
        tipo: 'success',
        titulo: 'Respuesta de Solicitud:',
        descripcion: '<b>Estado:</b> ' + data[0].estadoEvaluacion + '<br><b>Descripcion:</b> ' + data[0].observacionRespuestaAutorizacion + '',
        duracion: 10
      });
    } else if (data[0]['estadoEvaluacion'] == 'Rechazada') {
      Notificate({
        tipo: 'Error',
        titulo: 'Respuesta de Solicitud:',
        descripcion: '<b>Estado:</b> ' + data[0].estadoEvaluacion + '<br><b>Descripcion:</b> ' + data[0].observacionRespuestaAutorizacion + '',
        duracion: 10
      });
    }
    ListarSolicitudesA();
  }).fail(function() {
    Notificate({
      tipo: 'Error',
      titulo: 'Error de consulta:',
      descripcion: 'No se puedo realizar la consulta de las solicitudes de autorización',
      duracion: 10
    });
  })
};

$(document).ready(function() {

  ListarSolicitudesA();

  var horaMinima = localStorage.getItem("ReporteAPH-HoraConfirmacion");
  if (horaMinima) {
    var res = horaMinima.substr(1,5);
    $('#time1').timepicker({
      timeFormat: 'H:i',
      step: 1,
      minTime: res
    });
    $('#time2').timepicker({
      timeFormat: 'H:i',
      step: 1,
      minTime: res
    });
    $('#time3').timepicker({
      timeFormat: 'H:i',
      step: 1,
      minTime: res
    });
  }
  tratamiento.init();

});

var tratamiento = {

  init: function() {},
  cerrarSolicitudAutorizacion: function() {
    $("#cuadro_autorizacion1").remove();
  },

  cerrarSolicitudAutorizacion1: function() {
    $("#cuadro_autorizacion2").remove();
  },

  solicitar_autorizacion: function(idReporteAph, idTipoTratamiento, cedula) {
    var nombre_temporal = $('#lbl_tratamiento_' + idTipoTratamiento).val();
    var registro = localStorage.getItem("ReporteAPH-Paciente");
    var cedulaPaci = "";
    if (registro != null) {
      cedulaPaci = JSON.parse(registro);
      cedulaPaci = cedulaPaci['documento'];
    } else {
      cedulaPaci == "NN";
    }
    $('#id_div_' + idTipoTratamiento).remove();
    $('#id_lbl_' + idTipoTratamiento).attr('disabled', 'disabled');
    $('#id_lbl_' + idTipoTratamiento).removeAttr('style');
    $('#id_lbl_' + idTipoTratamiento).attr('style', 'background:#18b9e3;border: solid 1px #18b9e3');
    $('#id_check_' + idTipoTratamiento).attr('disabled', 'disabled');
    var id_reporteAph = idReporteAph;
    var id_tipotratamiento = idTipoTratamiento;
    var descripcion_autorizacion = $("#txtArea" + id_tipotratamiento).val();
    var cedula_paciente = cedula;
    var variable = "idReporte=" + id_reporteAph + "&idTipoTratamiento=" + id_tipotratamiento + "&descripcion=" + descripcion_autorizacion + "&cedula=" + cedulaPaci;
    $.ajax({
      type: 'POST',
      dataType: 'html',
      url: url + "ReporteAPH/ctrlTratamientoA/RegistrarAutorizacion",
      data: variable
    }).done(function(array) {
      ListarSolicitudesA();
      ConsultarMedicos();
      Notificate({
        tipo: 'success',
        titulo: 'Solicitud!',
        descripcion: "Se ha enviado una solicitud",
        duracion: 4
      });
    }).fail(function() {
      Notificate({
        tipo: 'error',
        titulo: 'Error!',
        descripcion: "Error al registrar un solicitud de autorización",
        duracion: 4
      });
    });
    $("#cuadro_autorizacion1").remove();
  },

  cancelar_autorizacion: function(idTipoTratamiento) {

    $('#id_lbl_' + idTipoTratamiento).attr('disabled', 'disabled');
    var cedula = $("#txt_cedula_001").val();
    var FechaEnvio = $("#txt_fecha_001").val();
    var FormData1 = "cedula=" + cedula + "&FechaEnvio=" + FechaEnvio;


    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: url + "ReporteAPH/ctrlTratamientoA/ActualizarEstadoTratamientoAvanzado",
      data: FormData1
    }).done(function(d) {
      ListarSolicitudesA();
      Notificate({
        tipo: 'info',
        titulo: 'Solicitud',
        descripcion: 'Se ha cancelado la solicitud de autorizacion',
        duracion: 4
      });
    }).fail(function(f) {
      Notificate({
        tipo: 'error',
        titulo: 'Error',
        descripcion: 'Error al cancelar la solicitud',
        duracion: 4
      });
    })

    $("#abrirConfirmacion").remove();
  },

  // cancelarAutorizacion_vista: function(idTipoTratamiento, FechaEnvio, cedulaR){
  //   $(".md_solicitarAyuda").remove();
  //   var nombre_autorizacion = $('#id_check_' + idTipoTratamiento + '').val();
  //   $("#cuadro_autorizacion").append('<div class="md_solicitarAyuda cancelarAutorizacion" id="abrirConfirmacion"><input type="text" id="txt_cedula_001" value="' + cedulaR + '" style="display:none"/><input type="text" id="txt_fecha_001" value="' + FechaEnvio + '" style="display:none"/><input type="text" id="lbl_tratamiento_' + idTipoTratamiento + '" style="display:none" value="' + nombre_autorizacion + '"></label><div class="head_md_confirmar"><h5 style="color: #fff">CANCELAR AUTORIZACION</h5></div><span style="float: right;float: rigth;margin-right: 10px;margin-top: -35px;color:#fff;cursor:pointer;" onclick="tratamiento.cerrarSolicitudAutorizacion()">X</span><div class="contenido_md_confirmacion"><div class="contenido no-pad"><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente">Cancelar Autorizacion Para:  <b style="margin-left:5px"> ' + nombre_autorizacion + '</b></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><div class="cont-antecedente"><button type="button" name="" class="btn btn-cancelar" style="width: 100%;" onclick="tratamiento.cancelar_autorizacion(' + idTipoTratamiento + ')" >Cancelar Solicitud</button></div></div></div></div></div></div>');
  // }
}
