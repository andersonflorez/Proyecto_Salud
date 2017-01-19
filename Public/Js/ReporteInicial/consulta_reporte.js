/*
* SCRIPT DE LA VISTA CONSULTAR REPORTES:
* Controla las funciones dinámicas de
* la página.
*/
(function() {
  // CONFIGURACIÓN DINÁMICA DE FILTROS:
  var filtros = {
    nameColumnDateTime: '',
    filterDateTimeStart: '',
    filterDateTimeEnd: '',
    nameColumnFilter: '',
    filter: ''
  };

  $('#hide-right-panel').click(hideRightPanel);

  // CONTROLADOR DE PAGINACIÓN DE REPORTES INICIALES:
  paginator.view.generateButtons(gatherOptions())
  .then(function(data) {
    if (!data.datos) {
      thereAreNotReports();
    } else {
      // MOSTRAR LOS PRIMEROS REPORTES AL CARGAR LA PÁGINA:
      listReports(data.datos);
    }
  });

  // EVENTO PARA PAGINAR LOS REPORTES
  $('#ul_paginador').on('click', 'li.btn_paginador', function() {
    let options = gatherOptions(filtros);
    Paginate(options, $(this), function(data) {
      // MOSTRAR LOS REPORTES AL DAR CLICK EN UN BOTÓN DE PAGINACIÓN:
      listReports(data.datos);
    });
  });

  let infoReporte = $('.informacion_reporte');
  let infoChat = $('.informacion_chat');
  let btnChat = $('#show-chat');
  let btnInfo = $('#show-info');

  $('.tab').click(function() {
    let tab = $(this);
    if (!tab.hasClass('active')) {
      let targetTab = $('.tab.active');
      target = tab.attr('target');

      let visible = target === 'section_chat' ? $('#section_users') : $('#section_chat');
      target = $('#' + target);

      fade(visible, 0, 100, function() {
        targetTab.removeClass('active');
        visible.addClass('hide');
        fade(target, 1, 50, function() {
          tab.addClass('active');
          target.removeClass('hide');
        });
      });
    }
  });

  $('.details').click(function() {
    let target = $('#' + $(this).attr('target'));

    if (target.css('max-height') === '0px') {
      target.css({'max-height': '500px'});
    } else {
      target.css({'max-height': '0px'});
    }
  });

  $('#show-chat').click(function() {

    fade(btnChat, 0, 200, function() {
      btnChat.addClass('hide');
      fade(btnInfo, 1, 100, function() {
        btnInfo.removeClass('hide');
      });
    });

    fade(infoReporte, 0, 200, function() {
      infoReporte.addClass('hide');
      fade(infoChat, 1, 100, function() {
        infoChat.removeClass('hide');
      });
    });

  });

  $('#show-info').click(function() {

    fade(btnInfo, 0, 200, function() {
      btnInfo.addClass('hide');
      fade(btnChat, 1, 100, function() {
        btnChat.removeClass('hide');
      });
    });

    fade(infoChat, 0, 200, function() {
      infoChat.addClass('hide');
      fade(infoReporte, 1, 100, function() {
        infoReporte.removeClass('hide');
      });
    });

  });

  // EVENTO PARA CONSULTAR UN REPORTE INICIAL:
  $('#contenedor-reportes').on('click', 'h5.report_title', function() {
    ConsultarReporte($(this), $(this).attr('target'));
  });

  // FUNCIÓN PARA LIMPIAR TODOS LOS FILTROS Y RESTABLECER LA CONFIGURACIÓN DEL PAGINADOR INICIAL:
  function setDefaultConfiguration() {
    cleanFilters();
    $('.filter_select').each(function(i, elem) {
      $(elem).val($(this).children().first().val());
    });
    $('#radDescendente').prop('checked', true);
    let options = gatherOptions(filtros);
    options.configuration.page = 1;
    paginator.view.generateButtons(options)
    .then(function(data) {
      listReports(data.datos);
    });
  }

  // FUNCIÓN PARA LIMPIAR LOS FILTROS DE BÚSQUEDA:
  function cleanFilters() {
    $('#txtBusqueda').val('');
    for (var property in filtros) {
      filtros[property] = '';
    }
  }

  // FUNCIÓN PARA MOSTRAR UN BOTÓN QUE PERMITA LIMPIAR LOS FILTROS Y RESTABLECER LA PAGINACIÓN:
  function showBtnToClean() {
    let btn = '<div id="divToClean" class="n_flex n_justify_center clean_filters"><h5 id="btnToClean" class="text_bold">Limpiar búsqueda y volver</h5></div>';
    if (!$('#divToClean').length) {
      $('#abc').prepend(btn);
      $('#contenedor-reportes').css('padding-bottom', '60px');
    }
  }

  // FUNCIÓN PARA OCULTAR EL BOTÓN DE LIMPIEZA:
  function hideBtnToClean() {
    $('#btnToClean').fadeOut('fast', function() {
      $('#contenedor-reportes').css('padding-bottom', '1em');
      $('#divToClean').remove();
    });
  }

  // FUNCIÓN PARA PAGINAR CON LA BARRA DE BÚSQUEDA:
  function FilterReports() {
    let filtro = $('#txtBusqueda').val();
    let busqueda;
    if (filtro.indexOf(',')) {
      busqueda = filtro.split(',');
      busqueda = busqueda.map(function(str) {
        return str.trim();
      }).filter(function(elem) {
        return elem != false;
      }).toString();
    } else {
      busqueda = filtro;
    }
    if (busqueda) {
      filtros.nameColumnFilter = $('#nameColumnFilter').val();
      filtros.filter = busqueda;
      let options = gatherOptions(filtros);
      options.configuration.page = 1;
      paginator.view.generateButtons(options)
      .then(function(data) {
        if (!data.datos) {
          // SI NO SE ENCONTRARON RESULTADOS:
          let message = 'Ningún reporte coincide con los filtros de búsqueda especificados';
          thereAreNotReports(message);
        } else {
          // SINO, LISTAR RESULTADOS:
          listReports(data.datos);
        }
        showBtnToClean();
      });
    }
  }

  // ACCIONES DE CONTROL DE FILTROS DE BÚSQUEDA AL CARGAR LA PÁGINA:
  $(document).ready(function() {

    // PAGINAR AL FILTRAR REPORTES PRESIONANDO 'ENTER':
    $('#txtBusqueda').keypress(function(e) {
      if (e.keyCode == 13) {
        FilterReports();
      }
    });

    // PAGINAR AL FILTRAR REPORTES PRESIONANDO CLICK EN EL BOTÓN BUSCAR:
    $('#btn-barra-filtro').click(function() {
      FilterReports();
    });

    // PAGINAR AL BUSCAR POR FECHAS:
    ValidateForm('filtro-fechas', function(formdata) {
      filtros.nameColumnDateTime = '?';
      filtros.filterDateTimeStart = formdata.initialDate;
      filtros.filterDateTimeEnd = formdata.finalDate;
      let options = gatherOptions(filtros);
      options.configuration.page = 1;
      LimpiarCampos('filtro-fechas');
      paginator.view.generateButtons(options)
      .then(function(data) {
        if (!data.datos) {
          // SI NO SE ENCONTRARON RESULTADOS:
          let message = 'Ningún reporte coincide con los filtros de búsqueda especificados';
          thereAreNotReports(message);
        } else {
          // SINO, LISTAR RESULTADOS:
          listReports(data.datos);
        }
        showBtnToClean();
      });
    });

    // PAGINAR AL CAMBIAR EL NOMBRE DEL CAMPO DE ORDENAMIENTO:
    $('#nameColumnOrderBy').change(function() {
      updateReportsView(gatherOptions(filtros));
    });

    // PAGINAR AL CAMBIAR EL TIPO DE ORDENAMIENTO (ASC, DESC):
    $('.orderBy').click(function() {
      updateReportsView(gatherOptions(filtros));
    });

    // PAGINAR AL CAMBIAR EL LÍMITE DE REGISTROS A MOSTRAR:
    $('#limit').change(function() {
      let options = gatherOptions(filtros);
      options.configuration.page = 1;
      paginator.view.generateButtons(options)
      .then(function(data) {
        listReports(data.datos);
      });
    });

    // OCULTAR BOTÓN PARA LIMPIAR FILTROS:
    $('#abc').on('click', '#btnToClean', function() {
      // RESTABLECER CONFIGURACIÓN INICIAL DEL PAGINADOR:
      setDefaultConfiguration();
      hideBtnToClean();
    });

    connect();

  });

  /**
  * Funcionalidad websocket del lado del cliente:
  */

  var controller = Controller.getInstance();
  var connected = false;

  var onOpen = function() {

    let data = controller.getMessageFormat('SERVIDOR', 'CONEXION');
    controller.send(data);
    connected = true;
    $(document).trigger('connected');

  }

  var onMessage = function(data) {

    data = JSON.parse(data);
    let emisor = data.emisor;
    let receptor = data.receptor;
    let mensaje = data.mensaje;

    if (mensaje.type === 'MENSAJE' && receptor && receptor.infoReceptor.tipoUsuario === controller.user.TIPO_USUARIO) {

      let message = JSON.parse(mensaje.data);

      if (message.tipo === controller.keys.registroReporte) {

        updateReportsView(gatherOptions(filtros));

        Notificate({
          tipo: 'info',
          titulo: 'Nuevo reporte de emergencia',
          descripcion: 'El reporte ' + agregarCeros(message.idReporte.toString(), 4) + ' ha sido registrado',
          duracion: 8
        });

      } else if (message.tipo === controller.keys.registroNovedad) {

        updateReportsView(gatherOptions(filtros));

        Notificate({
          tipo: 'info',
          titulo: 'Se ha registrado una novedad',
          descripcion: 'Se ha registrado una novedad al reporte ' + agregarCeros(message.idReporte.toString(), 4),
          duracion: 8
        });

      }

    } else if (mensaje.type === 'RESPUESTA_NOTIFICACION' && receptor && receptor.tipoUsuario === 'RECEPTOR_INICIAL') {

    }

  }

  var onClose = function() {
    if (connected) {

      connected = false;

      swal({
        title: 'Conexión perdida',
        text: "Se ha perdido la conexión con el servidor, revise su conexión a internet, si este no es el caso, puede que el servidor no se encuentre en funcionamiento",
        type: "error",
        confirmButtonText: 'Reintentar conexión',
        closeOnConfirm: false,
        showLoaderOnConfirm: true
      }, function() {

        setTimeout(connect, 2000);

        $(document).bind('connected', function() {
          swal({
            title: 'Conexión establecida',
            type: 'success',
            confirmButtonText: 'Aceptar'
          });
        });

      });
    }
  }

  var onError = function() {

    connected = false;

    swal({
      title: "Error de conexión",
      text: "Ha ocurrido un error al momento de conectarse al servidor, puede que el servidor no se encuentre en funcionamiento o su conexión a internet está fallando",
      type: "error",
      confirmButtonText: 'Reintentar conexión',
      cancelButtonText: 'Salir',
      showCancelButton: true,
      closeOnConfirm: false,
      showLoaderOnConfirm: true
    }, function() {

      setTimeout(connect, 2000);

      $(document).bind('connected', function() {
        swal({
          title: 'Conexión establecida',
          type: 'success',
          confirmButtonText: 'Aceptar'
        });
      });

    });

  }

  function connect() {
    getWebSocketUrl()
    .then(function(strUrlSocket) {

      let jsonUrlSocket = JSON.parse(strUrlSocket);
      let urlSocket = 'ws://' + jsonUrlSocket.socketIP + ':' + jsonUrlSocket.socketPort;

      controller.server = new FancyWebSocket(urlSocket);
      controller.server.bind('open', onOpen);
      controller.server.bind('message', onMessage);
      controller.server.bind('close', onClose);
      controller.server.bind('error', onError);
      return;

    })
    .then(controller.getSession)
    .then(function(session) {

      controller.user = JSON.parse(session);
      controller.server.connect();

    });
  }

})(this);
