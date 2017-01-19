// Boton submenu
var mNav = $('.movil-nav');
var button = $('.movil-button');

// Paneles
var pRegistro = $('.col-registro');
var pChat = $('.col-chat');
var pProceso = $('.col-proceso');
var pDescanso = $('#panel_descanso');

// Boton mas informacion (Usuario)
var buttonInf = $('.button-user-inf');

var novedad = $('#txtNovedad');
var formNovedad = $('#formNovedad');

function CerrarMenuNotificaciones() {
  return new Promise(function(done) {
    $('.menu-notificaciones-flotantes').animate({
      right: '-1000px',
    }, 400, done);
  });
}

function IniciarAnimacionCarga(idChat) {
  let html = '<div id="loading" class="n_flex"><span class="load" aria-hidden="true"></span></div>';
  $('#panel_descanso > .panel').html(html);
  return idChat;
}

function FinalizarAnimacionCarga() {
  $('#loading').fadeOut('fast', function() {
    $('#loading').remove();
    MostrarPaneles();
  });
}

function MostrarPaneles() {
  $('#panel_descanso').removeClass('active-panel');
  $('#panel_descanso').fadeOut('fast', function() {
    $('#panel_descanso').removeClass('active-panel');
    $(this).removeClass('break-p');
    pRegistro.fadeIn('fast', function() {
      $(this).addClass('active-panel');
      pProceso.removeClass('active-panel');
      $(this).removeClass('hidden_panel');
      $(this).addClass('visible_panel');
      pChat.removeClass('hidden_panel');
      visibleForm();
      $('.movil-nav').removeClass('hidden_nav');
    });
  });
}

function visibleForm() {
  if (Number(localStorage['visibleForm']) == 1) {
    HabilitarNovedad();
    Notificate({
      titulo: 'Reporte registrado!',
      descripcion: 'El reporte ya se ha registrado, aun asi puede añadir novedades',
      tipo: 'info',
      duracion: 6
    });
  } else {
    HabilitarFormulario();
  }
}

function OcultarPaneles() {
  $('.visible_panel').fadeOut('fast', function() {
    $(this).removeClass('hidden_panel');
    $(this).addClass('hidden_panel');
    pChat.addClass('hidden_panel');
    MostrarPanelDescanso();
    $('#panel_descanso').fadeIn('fast',function(){
      pProceso.removeClass('active-panel');
      pChat.removeClass('active-panel');
      $(this).addClass('active-panel');
      $(this).addClass('break-p');
    });
  });
  $('.button-break').removeClass('hidden');
}

function MostrarPanelDescanso() {
  $('.movil-nav').addClass('hidden_nav');
  let html = '<div id="without_notifications" class="n_flex n_in_columns n_justify_center n_align_center"><img src="'+url+'Public/Img/ReporteInicial/notification.png" class="vertical_padding" draggable="false"/><h4>Seleccione una notificación</h4><p>Inicie un chat para registrar un reporte inicial de emergencia.</p></div>';
  $('#panel_descanso > .panel').html(html);
}

function MostrarPanelSinNotificaciones() {
  let html = '<li class="no_notifications n_flex n_grow_up n_justify_center n_align_center n_in_columns"><img src="'+url+'/Public/Img/ReporteInicial/NoNotify.png" class="img_noReports" draggable="false"/><h6 class="text_bold">No hay ninguna notificación hasta el momento</h6></li>';
  $('#cont-notificaciones-f').html(html);
}

$(document).ready(function() {

  if (pDescanso.css('display') == 'flex') {
    pProceso.removeClass('active-panel');
    $('.movil-nav').addClass('hidden_nav');
    pDescanso.addClass('active-panel');
    pDescanso.addClass('break-p');
  }

  var min_query = window.matchMedia("(min-width: 767px)");

  min_query.addListener(function() {
    if ((min_query.matches == true) && (pProceso.hasClass('active-panel'))) {
      pProceso.removeClass('active-panel');
      pChat.removeClass('active-panel');
      pRegistro.addClass('active-panel');
    } else if ($('.button-break').css('display') == 'block') {
      pRegistro.removeClass('active-panel');
      pDescanso.addClass('active-panel');
    }
  });


  // EVENTO PARA PAGINAR LOS REPORTES
  $('#ul_paginador').on('click', 'li.btn_paginador', function() {
    var options = {
      url: 'ReporteInicial/CtrlRegistrarReporteInicial/PaginarReportes',
      parent: 'ul_paginador',
      configuration: {
        tableName: '?',
        limit: 2,
        ajax: true
      }
    }
    Paginate(options, $(this), function(data) {
      if (!data.datos) {
        NoReports();
      } else {
        $('.reports').removeClass('.panel-reports');
        listReports(data.datos);
      }
    });
  });

  $('.order-button').click(function(){
    let typeO = $(this);
    if (!typeO.hasClass('active-order')) {
      typeO.fadeOut('fast', function() {
        $('.order-button.active-order').removeClass('active-order');
        typeO.addClass('active-order');
      });
      typeO.fadeIn('fast');
    }
    let configuration = {
      tableName: '?',
      limit: 2,
      nameColumnOrderBy: '?',
      page: 1,
      orderBy: $(this).attr('order'),
      ajax: true
    }
    let urlPaginator = 'ReporteInicial/CtrlRegistrarReporteInicial/PaginarReportes';
    paginator.model.queryDataBase(urlPaginator, configuration)
    .then(function(data){
      listReports(data.datos);
    })
  });

  // CERRAR MENU DE NOTIFICACIONES AL DAR CLICK FUERA DE ÉL
  $('html').click(function() {
    if ($('.menu-notificaciones-flotantes').css('right') === '0px') {
      CerrarMenuNotificaciones();
    }
  });

  // EVITAR QUE EL MENU DE NOTIFICACIONES CIERRE CUANDO LE DEN CLICK:
  $('.menu-notificaciones-flotantes').click(function(e) {
    e.stopPropagation();
  });

  // CONSULTAR REPORTES EN PROCESO
  consultaReportes();

  // SUBMENU EN TABLET Y SMARTPHONE
  $(button).click(function() {
    var type = $(this).attr('type').toUpperCase();
    switch (type) {
      case 'REGISTRO':
      VisiblePanel(pRegistro);
      break;
      case 'CHAT':
      VisiblePanel(pChat);
      break;
      case 'PROCESO':
      VisiblePanel(pProceso);
      break;
      case 'DESCANSO':
      VisiblePanel(pDescanso);
      break;
    }
  });

  function VisiblePanel(PanelType) {
    if (!PanelType.hasClass('active-panel')) {
      $('.col-panel.active-panel').fadeOut('fast',function() {
        $('.col-panel.active-panel').removeClass('active-panel');
        PanelType.addClass('active-panel');
        PanelType.fadeIn('fast');
      });
    }
  }


  // Mostrar informacion personal (Chat)
  $(buttonInf).click(function() {
    var pInf = $('.panel-inf-user');
    if (!$(pInf).is(':hidden')) {
      $(pInf).fadeOut('fast',function() {
        $('.panel-chat').removeClass('remove-panel');
        $(pInf).hide();
      });
    }else {
      $(pInf).fadeIn('fast',function() {
        $(pInf).show();
      });
      $('.panel-chat').addClass('remove-panel');
    }
  });

});

function DeshabilitarFormulario() {
  $('.txtDatosReporte').each(function() {
    $(this).css('width','100%');
    $(this).attr('disabled','disabled');
    $(this).addClass('inactive-input');
  });
  $('.selectpicker').attr('disabled','disabled');
  $('.btn-default').css('background','#f9f9f9');
  $('.btn-default').css('cursor','no-drop');
  $('.contDescripcion').fadeOut('fast',function() {
    $('.nl-hapx').addClass('hidden');
    $('.contDescripcion').addClass('hidden');
    $('#gButtonReporte').addClass('hidden');
  });
}

function HabilitarFormulario() {
  $('.txtDatosReporte').each(function() {
    $(this).removeAttr('disabled');
    $(this).removeClass('inactive-input');
  });
  $('.selectpicker').removeAttr('disabled');
  $('.btn-default').css('background','#fff');
  $('.btn-default').css('cursor','pointer');
  if(!($('#formNovedad').hasClass('hidden'))) {
    $('#formNovedad').fadeOut('fast',function(){
      $(this).addClass('hidden');
      novedad.attr('disabled','disabled');
    })
  }
  $('.contDescripcion').fadeIn('fast',function() {
    $('.nl-hapx').removeClass('hidden');
    $(this).removeClass('hidden');
    $('#gButtonReporte').removeClass('hidden');
    $('#gButtonNovedad').addClass('hidden');
  });
  $('.button-break').addClass('hidden');
}

function printAddress() {
  let nomenc = document.getElementById('txtSelectNomenclatura').value;
  let numDir = document.getElementById('txtNumeroDir').value;
  let numC = document.getElementById('txtNum-Ciudad').value;

  $('#txtDireccion').val( nomenc + ' ' + numDir + ' ' + numC);
}

// FORMATO PARA HORA APROXIMADA
$('#txtHoraAproximada').timepicker({ 'timeFormat': 'H:i:s' });
$('#setTimeButton').on('click', function (){
  $('#setTimeExample').timepicker('setTime', new Date());
});


$('#btnRegistrarReporte').click(function() {
  $('#formReporteInicial').submit();
});

function RegistrarReporte(formdata) {
  var url_ajax = url + 'ReporteInicial/CtrlRegistrarReporteInicial/RegistrarReporte';
  return $.ajax({
    url: url_ajax,
    type: 'POST',
    data: formdata
  });
}

function fail(err) {
  Notificate({
    titulo: 'Ha ocurrido un error',
    descripcion: 'Error inesperado al enviar la información, por favor intentelo nuevamente',
    tipo: 'error',
    duracion: 4
  });
}
/* FIN REGISTRAR REPORTE INICIAL */

/* REGISTAR */
$('#btnRegistrarNovedad').click(function() {
  $('#formNovedad').submit();
});


function RegistrarNovedad(dataNovedad) {
  let url_ajax = url + 'ReporteInicial/CtrlRegistrarReporteInicial/RegistrarNovedad';

  return $.ajax({
    url: url_ajax,
    type: 'POST',
    data: dataNovedad
  });
}


// CONTROLADOR DE PAGINACIÓN DE REPORTES INICIALES:
function consultaReportes() {
  var options = {
    url: 'ReporteInicial/CtrlRegistrarReporteInicial/PaginarReportes',
    parent: 'ul_paginador',
    configuration: {
      tableName: '?',
      ajax: true,
      limit: 2
    }
  }
  paginator.view.generateButtons(options)
  .then(function(data) {
    if (!data.datos) {
      NoReports();
    } else {
      // MOSTRAR LOS PRIMEROS REPORTES AL CARGAR LA PÁGINA:
      $('#contenedor-reportes').removeClass('n_align_center');
      $('#contenedor-reportes').addClass('n_align_start');
      $('.reports').removeClass('.panel-reports');
      listReports(data.datos);
    }
  });

  function NoReports() {
    $('#contenedor-reportes').removeClass('n_align_start');
    $('#contenedor-reportes').addClass('n_align_center');
    $('.reports').addClass('panel-reports');
    $('#ul_paginador').html("<h6>No hay reportes para mostrar</h6>");
  }

  function PrintMessage(html) {
    $('#contenedor-reportes').fadeOut('fast', function(){
      $('#contenedor-reportes').html(html);
      $('#contenedor-reportes').fadeIn('fast', done);
    });
  }
}

/* HABILITAR FORMULARIO NOVEDADES */
function HabilitarNovedad() {
  if((formNovedad.css('display') == 'none') && (novedad.attr('disabled'))) {
    DeshabilitarFormulario();
    formNovedad.removeClass('hidden');
    formNovedad.css('display','flex');
    novedad.removeAttr('disabled');
    $('#gButtonNovedad').removeClass('hidden');
    $('.button-break').addClass('hidden');
    localStorage.setItem('visibleForm',Number(1));
  }
}
