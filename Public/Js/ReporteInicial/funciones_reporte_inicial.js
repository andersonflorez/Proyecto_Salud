var rightPanel = $('.right_panel');
var infoPanel = $('#info_section');
var emptyPanel = $('#clean_section');
var chatController = Controller.getInstance();

function printChatInformation(chat) {
  console.log(chat);

  chat = JSON.parse(chat);

  let html = chatController.parseChatMessages(chat.mensajes, 1, chat.receptorInicial, chat.usuarioExterno);
  $('#chat_history').html(html);

  $('#informacion_receptor .img_receptor').attr('src', url + chat.receptorInicial.urlFoto);
  $('#informacion_usuario .img_usuario').attr('src', url + chat.receptorInicial.urlFoto);

  for (var propiedad in chat.receptorInicial) {
    let node = $('#informacion_receptor span.' + propiedad);
    if (node.length > 0) {
      let descripcion = chat.receptorInicial[propiedad] ? chat.receptorInicial[propiedad] : 'No especificado';
      node.text(descripcion);
    }
  }

  for (var propiedad in chat.usuarioExterno) {
    let node = $('#informacion_usuario span.' + propiedad);
    if (node.length > 0) {
      node.text(chat.usuarioExterno[propiedad]);
    }
  }

  return;
}

function fade(fadeNode, opacity, duration, callback) {
  fadeNode.animate({
    'opacity': opacity
  }, duration, callback);
}

// Función para transformar reportes en HTML e imprimirlos en la vista:
function listReports(reports, done) {
  if (reports) {
    let reportsInHTMLFormat = getReportsInHTML(reports);
    printReports(reportsInHTMLFormat);
  }
}

// Función para ilustrar que no hay reportes
function thereAreNotReports(message) {
  let msg = message ? message : 'Hasta el momento no se ha registrado ningún reporte';
  let html = '<div style="padding:0% 20%;" class="n_flex n_in_columns n_align_center"><img width="120px" class="vertical_padding" src="'+url+'Public/Img/ReporteInicial/NoReports.png" draggable="false"><h4 style="color:#1F95D0;text-align:center;">' + msg + '</h4></div>';
  printReports(html);
  $('#ul_paginador').html('No se encontraron reportes');
}

// FUNCIÓN TOMAR LOS VALORES DE CONFIGURACIÓN DE TODOS LOS FILTROS:
function collect() {
  let page = Number($('#ul_paginador').find('li.btn_paginador.active').text());
  let config = {
    page: page > 0 ? page : 1,
    orderBy: Number($('.orderBy:checked').val()),
    limit: Number($('#limit').val()),
    nameColumnOrderBy: Number($('#nameColumnOrderBy').val())
  };
  return config;
}

// EVENTO PARA GENERAR PDF DE UN REPORTE INICIAL:
$('#contenedor-reportes').on('click', 'span.btn_generate_pdf', function() {
  generatePDF($(this).attr('target'));
});

// FUNCIÓN PARA GENERAR PDF:
function generatePDF(id) {
  var urlGenerarPdf = url + 'ReporteInicial/CtrlFpdf/GenerarPdf/' + id;
  var a = document.createElement('a');
  a.target = '_blank';
  a.href = urlGenerarPdf;
  a.click();
}

// Función para generar la configuración del paginador:
function gatherOptions(searchConfig) {
  let more = collect();
  let options = {
    parent: 'ul_paginador',
    url: 'ReporteInicial/ctrlConsultarReporte/PaginarReportes',
    configuration: {
      ajax: true,
      tableName: '?'
    }
  };

  for (let property in more) {
    if (more[property]) {
      options.configuration[property] = more[property];
    }
  }

  if (searchConfig) {
    for (let property in searchConfig) {
      if (searchConfig[property]) {
        options.configuration[property] = searchConfig[property];
      }
    }
  }
  return options;
}

// Función para consultar datos con el pagindor
function updateReportsView(options) {
  paginator.model.queryDataBase(options.url, options.configuration)
  .then(function(data) {
    listReports(data.datos);
  });
}

// Función para transformar los reportes JSON en HTML:
function fromJSONToHTML(reporte) {
  let estado = '';

  for (var propiedad in reporte) {
    if (!reporte[propiedad]) {
      reporte[propiedad] = 'No especificado';
    }
  }

  switch (reporte.estadoTablaReporteInicial) {
    case 'activo':
      estado = '<span class="fa fa-spinner tooltip relative_element"><span class="report_state_tooltip tooltiptext">En proceso</span></span>';
    break;
    case 'finalizado':
      estado = '<span class="fa fa-flag tooltip relative_element"><span class="report_state_tooltip tooltiptext">Finalizado</span></span>';
    break;
    case 'cancelado':
      estado = '<span class="fa fa-ban tooltip relative_element"><span class="report_state_tooltip tooltiptext">Cancelado</span></span>';
    break;
  }

  let report = '<li class="list_item n_grow_up"><div class="list_item_header n_flex n_nowrap"><div class="item_icon n_flex n_align_center relative_element">' + estado + '</div><div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden"><h5 target="' + reporte.idReporteInicial + '" class="suspensive report_title"><span class="text_bold">Reporte: </span>' + agregarCeros(reporte.idReporteInicial, 4) + '</h5></div></div><div class="list_item_content suspensive_2"><p class="paragraph"><span class="text_bold">Descripción: </span>' + reporte.informacionInicial + '</p></div><div class="list_item_content"><p class="suspensive"><span class="text_bold">Dirección: </span>' + reporte.ubicacionIncidente + '</p></div><div class="list_item_footer n_flex n_justify_between horizontal_padding n_align_center"><div class="footer_element n_flex n_align_center"><span><i class="fa fa-calendar"></i> ' + obtenerFecha(reporte.fechaHoraEnvioReporteInicial) + '</span></div><div class="footer_element n_flex n_align_center pdf-button"><div class="tooltip"><span class="btn btn-consultar btn_generate_pdf" target="' + reporte.idReporteInicial + '"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span><span class="tooltiptext">PDF</span></div></div></div></li>';
  return report;
}

function getReportsInHTML(reportes) {
  html = '';
  for (var i = 0; i < reportes.length; i++) {
    html += fromJSONToHTML(reportes[i]);
  }
  return html;
}

function printReports(html) {
  return new Promise(function(done, reject) {
    $('#contenedor-reportes').fadeOut('fast', function() {
      $('#contenedor-reportes').html(html);
      $('#contenedor-reportes').fadeIn('fast', done);
    });
  });
}

// Función para transformar un reporte JSON en HTML:
function JSONtoHTMLReport(reporte) {

  for (var propiedad in reporte) {
    if (!reporte[propiedad]) {
      reporte[propiedad] = 'No especificado';
    }
  }

  if (reporte.estadoReporteInicial == 'activo') {
    $('#cancel-report').attr('ref', reporte.idReporteInicial).css({'display': 'block'});
    $('#add-new').attr('ref', reporte.idReporteInicial).css({'display': 'block'});
    reporte.estadoReporteInicial = 'en proceso';
  } else {
    $('#cancel-report').attr('ref', 0).css({'display': 'none'});
    $('#add-new').attr('ref', 0).css({'display': 'none'});
  }

  $('#btn-consultar').attr("value", reporte.idChat);
  $('#codigo-reporte').text(reporte.idReporteVista);
  $('#descripcion-reporte').text(reporte.informacionInicial);
  $('#direccion-reporte').text(reporte.ubicacionIncidente);
  $('#punto-referencia-reporte').text(reporte.puntoReferencia);
  $('#numero-lesionados-reporte').text(reporte.numeroLesionados);
  $('#fecha-hora-emergencia').text(reporte.fechaEmergencia);
  $('#fecha-hora-envio-reporte').text(reporte.fechaEnvioReporte);
  $('#estado-reporte').text(reporte.estadoReporteInicial.capitalize());
  $('#show-chat').attr('nonsense', reporte.idChat);

  var tiposEvento, cantidadtiposEvento, entesExternos, cantidadentesExternos, novedades, cantidadnovedades;

  if (reporte.tiposEvento) {
    tiposEvento = obtenerListaSimple(reporte.tiposEvento, 'Tipos de evento');
  } else {
    tiposEvento = 'No hay ningún tipo de evento asociado a este reporte';
    cantidadtiposEvento = 'Cantidad: 0';
  }

  if (reporte.entesExternos) {
    entesExternos = obtenerListaSimple(reporte.entesExternos, 'Ayudas solicitadas');
  } else {
    entesExternos = 'No hay ningún ente externo asociado a este reporte';
  }

  if (reporte.novedades) {
    var retorno = obtenerNovedadesHtml(reporte.novedades);
    novedades = retorno.htmlNovedades;
  } else {
    novedades = 'No hay ninguna novedad asociada a este reporte';
  }

  $('#lista-novedades').html(novedades);
  $('#lista-tipoevento').html(tiposEvento);
  $('#lista-exteexterno').html(entesExternos);
}

function obtenerNovedadesHtml(novedades) {
  let titulo;
  let retorno = {
    htmlNovedades: ''
  };
  novedades.forEach(function(novedad) {
    let titulo = 'Novedad';
    let background = '';
    let color = '';
    if (novedad.Descripcion.toLowerCase().indexOf('el reporte ha sido cancelado') != -1) {
      titulo = 'Reporte cancelado';
      background = 'style="background-color:rgb(221, 107, 85);border-radius: 5px 5px 0px 0px;"';
      color = 'style="color:#fff"';
    }
    retorno.htmlNovedades += '<li class="list_item n_dont_grow"><div class="list_item_header n_flex n_nowrap" style="background: #fafafa;"><div ' + background + ' class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden"><h5 class="suspensive" style="color: #555;"><span class="text_bold" ' + color + '>' + titulo + '</span></h5></div></div><div class="list_item_content suspensive_4"><p class="paragraph"><span class="text_bold">Descripción:</span> ' + novedad.Descripcion + '</p></div><div class="list_item_content suspensive_4"><p class="paragraph"><span class="text_bold">Fecha:</span> ' + obtenerFecha(novedad.Fecha) + '</p></div><div class="list_item_content suspensive_4"><p class="paragraph"><span class="text_bold">Hora:</span> ' + obtenerHora(novedad.Fecha) + '</p></div></li>';
  });
  return retorno;
}

// Función para validar formato fecha (DD/MM/AAAA):
function validarFormatoFecha(fecha) {
  var dtCh = '/';
  var minYear = 1900;
  var maxYear = 2100;
  function isInteger(s) {
    var i;
    for (i = 0; i < s.length; i++) {
      var c = s.charAt(i);
      if (((c < '0') || (c > '9'))) return false;
    }
    return true;
  }
  function stripCharsInBag(s, bag) {
    var i;
    var returnString = '';
    for (i = 0; i < s.length; i++) {
      var c = s.charAt(i);
      if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
  }
  function daysInFebruary(year) {
    return (((year % 4 == 0) && ((!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28);
  }
  function DaysArray(n) {
    for (var i = 1; i <= n; i++) {
      this[i] = 31;
      if (i == 4 || i == 6 || i == 9 || i == 11) {this[i] = 30;}
      if (i == 2) {this[i] = 29;}
    }
    return this;
  }
  function isDate(dtStr) {
    var daysInMonth = DaysArray(12);
    var pos1 = dtStr.indexOf(dtCh);
    var pos2 = dtStr.indexOf(dtCh,pos1 + 1);
    var strDay = dtStr.substring(0,pos1);
    var strMonth = dtStr.substring(pos1 + 1,pos2);
    var strYear = dtStr.substring(pos2 + 1);
    strYr = strYear;
    if (strDay.charAt(0) == '0' && strDay.length > 1) strDay = strDay.substring(1);
    if (strMonth.charAt(0) == '0' && strMonth.length > 1) strMonth = strMonth.substring(1);
    for (var i = 1; i <= 3; i++) {
      if (strYr.charAt(0) == '0' && strYr.length > 1) strYr = strYr.substring(1);
    }
    month = parseInt(strMonth);
    day = parseInt(strDay);
    year = parseInt(strYr);
    if (pos1 == -1 || pos2 == -1) {
      return false;
    }
    if (strMonth.length < 1 || month < 1 || month > 12) {
      return false;
    }
    if (strDay.length < 1 || day < 1 || day > 31 || (month == 2 && day > daysInFebruary(year)) || day > daysInMonth[month]) {
      return false;
    }
    if (strYear.length != 4 || year == 0 || year < minYear || year > maxYear) {
      return false;
    }
    if (dtStr.indexOf(dtCh,pos2 + 1) != -1 || isInteger(stripCharsInBag(dtStr, dtCh)) == false) {
      return false;
    }
    return true;
  }
  if (isDate(fecha)) {
    return true;
  }else {
    return false;
  }
}

// Función para sacar una fecha a partir de un datetime:
function obtenerFecha(datetime) {
  var date = new Date(datetime);
  var dia = agregarCeros(date.getDate().toString(), 2);
  var mes = agregarCeros((date.getMonth() + 1).toString(), 2);
  var año = date.getFullYear();
  return dia + '/' + mes + '/' + año;
}

// Función para sacarle la hora a un datetime:
function obtenerHora(datetime) {
  var date = new Date(datetime);
  var hora = agregarCeros(date.getHours().toString(), 2);
  var minutos = agregarCeros((date.getMinutes() + 1).toString(), 2);
  var segundos = agregarCeros(date.getSeconds().toString(), 2);
  return hora + ':' + minutos + ':' + segundos;
}

// Función para agregar ceros a la izquierda del id del reporte:
function agregarCeros(value, cantidad) {
  return value.length < cantidad ? agregarCeros('0' + value, cantidad) : value;
}

// Función capitalize
String.prototype.capitalize = function() {
  return this.toLowerCase().replace(/(^|\s)([a-z])/g, function(m, p1, p2) {
    return p1 + p2.toUpperCase();
  });
};

function obtenerListaSimple(array, titulo) {
  let lista;
  lista = '<li class="list_item n_dont_grow"><div class="list_item_header n_flex n_nowrap" style="background: #fafafa;"><div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden"><h5 class="suspensive" style="color: #555;"><span class="text_bold">' + titulo + '</span></h5></div></div>';

  array.forEach(function(elem) {
    lista += '<div class="list_item_content suspensive_4"><p class="paragraph"><span class="text_bold">Descripción: </span>' + elem + '</p></div>';
  });

  lista += '</li>';
  return lista;
}

// Función para mostrar el panel derecho:
function showRightPanel() {
  if (rightPanel.css('position') != 'absolute') {
    if (emptyPanel.css('display') == 'none' && emptyPanel.css('opacity') == '0') {
      // Si hay un reporte diferente abierto, cerrarlo y abrir el nuevo reporte:
      hide(infoPanel, 200, function() {
        show(infoPanel, 300);
        return;
      });
    } else {
      // Sino, solo se abre el reporte:
      hide(emptyPanel, 300, function() {
        show(infoPanel, 300);
        return;
      });
    }
  } else {
    rightPanel.css({'right': '0px'});
    return;
  }
}

function hideRightPanel() {
  InactivateListItem();
  if (rightPanel.css('position') != 'absolute') {
    // Cerrar el panel
    hide(infoPanel, 200, function() {
      show(emptyPanel, 300);
    });
  } else {
    rightPanel.css({'right': '-100%'});
  }
}

function show(node, duration, callback) {
  node.css({
    'display': 'flex'
  }).animate({
    'opacity': 1
  }, duration, function() {
    if (callback) {
      callback();
    }
  });
}

function hide(node, duration, callback) {
  node.animate({
    'opacity': 0
  }, duration, function() {
    node.css({'display': 'none'});
    if (callback) {
      callback();
    }
  });
}

// Función para remover validación de campo:
function removeValidation(input) {
  if (input.parent().hasClass('invalid')) {
    input.parent().removeClass('invalid');
    input.attr('placeholder', 'Búsqueda general');
  }
}

// Función para obtener lo que el usuario necesita buscar:
function getSearchingValue() {
  var valor = $('#txtBusqueda').val().trim();
  if (!valor) {
    $('#txtBusqueda').val('');
    $('#txtBusqueda').parent().addClass('invalid');
    $('#txtBusqueda').attr('placeholder', 'Ingrese algo a buscar');
    return false;
  } else {
    return valor;
  }
}
