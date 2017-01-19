/**
* Este archivo es para funcionalidad js GENERAL de ReporteAPH.
* NOTA: Por favor no coloques código que que no sirva o no se
* utlice en todas las vistas de ReporteAPH
*/

(function (global) {

  // FUNCIONALIDAD MENU EMERGENCIA
  var Confirmarllegada = false;
  $("#btn_llegada").click(function () {
    if(Confirmarllegada === false){
      $(".md_comfirmar").attr("id","abrirConfirmacion");
      $("#acp_llegada").click(function () {
        $(".md_comfirmar").removeAttr("id","abrirConfirmacion");
        horaLlegada("12:33 pm");
        Confirmarllegada = true;
      });
    }
  });


  $(".btn_cancelar_md").click(function () {
    $(".md_comfirmar").removeAttr("id","abrirConfirmacion");
  });


  $('#AgregarA').click(function(){
    $('#FilaOcu').toggle();
    $(this).toggle();
    $('#RegistrarAcom').toggle();
  });

  // FUNCIONALIDAD MENU EMERGENCIA
  var solcitarAyuda = false;
  $("#btn_ayuda").click(function () {
    if(solcitarAyuda === false){
      $(".md_solicitarAyuda").attr("id","abrirConfirmacion");
    }
  });


  $(".cerrarSolicitudAyuda").click(function () {
    $(".md_solicitarAyuda").removeAttr("id","abrirConfirmacion");
  });

  // MEDICAMENTOS PANCHANA
  $(".cont_medicamento").click(function(){
    $(".contenedor-datos").css({"display":"block"});
  });

  $(".cerrar_medicamento").click(function(){
    $(".contenedor-datos").css({"display":"none"});
  });



  // COLOCA LA HORA DE LLEGADA
  this.horaLlegada = function (hora) {
    var btnLlegada=document.getElementById('text_hora_llegada');
    $("#cont_btn_llegada").addClass("cont_btn_llegada ");
    if (btnLlegada !== null) {
      btnLlegada.setAttribute('hora_llegada',hora);
    }
  };


  /**
  * Promesa que informa en que modo de trabajo esta la aplicación( ModoConsulta - ModoRegistro )
  */
  this.whichWorkMode = new Promise(function (resolve, reject) {
    DoPostAjax({
      url: 'ReporteAPH/CtrlLayoutReporteAPH/WhichWorkMode',
      data: {"request":"ajax"}
    }, function(err, data) {
      if (err) {
        reject(err); // Si ocurre algún error
      } else {
        // Si todo sale bien:
        if (data == -1) {
          resolve(data);
        }else {
          var convert = Boolean(Number(data));
          resolve(convert);
        }
      }
    });
  });

  /**
  * Coloca en disabled todos los inputs de una vista
  */
  this.allInputsDisabled = function () {
    $("body .bloquear").prop("disabled", true).css({
      "background":"rgb(249, 249, 249)",
      "cursor":"no-drop"
    });
    $("body .bloquear").parent('.frmInput').css({
      "background":"rgb(249, 249, 249)",
      "cursor":"no-drop"
    });
  };

  this.allInputsEnabled = function () {
    $("body .bloquear").removeAttr("disabled").css({
      "cursor":"initial"
    });
    $("body .bloquear").parent('.frmInput').css({
      "cursor":"initial"
    });
  };

  Array.prototype.chunk = function(pieces) {
    pieces = pieces || 2;
    var len = this.length;
    var mid = (len/pieces);
    var chunks = [];
    var start = 0;
    for(var i=0;i<pieces;i++) {
      var last = start+mid;
      if (!len%pieces >= i) {
        last = last-1;
      }
      chunks.push(this.slice(start,last+1) || []);
      start = last+1;
    }
    return chunks;
  };

  // Desactivar inputs
  whichWorkMode.then(function (esModoConsulta) {
    if (esModoConsulta != -1 && esModoConsulta) {
      allInputsDisabled();
    }else if (esModoConsulta != -1 && !esModoConsulta) {
      allInputsEnabled();
    }
  }, function (err) {
    Notificate({
      titulo: 'Ha ocurrido un error',
      descripcion: 'No se pudó obtener el modo de trabajo.',
      tipo: 'error',
      duracion: 8
    });
  });


})(this);
