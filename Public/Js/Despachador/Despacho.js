let idUsuariosRegistro = {};
let idUsuariosSockets = [];
let objetoEnviarInfoDespacho = {'idReceptores':'','idDespacho':''};
var map = L.map('map', {
  center: [6.2555037,-75.5775585],
  zoom: 14
});
var mbUrl = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
  attribution: '© OpenStreetMap contributors'
}).addTo(map);
var point = L.point(200,300);
var myIconAmbu = L.icon({
  iconUrl: '../Img/ReporteAPH/images/marker-icon23.png',
  iconSize:     [40, 90],
  shadowSize:   [50, 64],
  iconAnchor:   [20, 90],
  shadowAnchor: [4, 62],
  popupAnchor:  [-3, -76]
});
$(document).ready(function(){
  $("#btnRegistrarDespachoNovedad").hide();
  ValidateForm("frmDespacho",function (FormData){
    RegistrarDespacho(FormData);
  });
  ValidarMarcadorAmbulancia();
  ListarNovedad();
  paginadorReportesActivos();
});
$("#btnRegistrarDespachoNovedad").click(function(){
  RegistrarDespachoNovedadReporte();
});
var contadorMarcadores = 0;
var pDespacho = $('#panelRegistroDespacho');
var pReportes = $('#panelReportes');
$('.tab-button').click(function(e) {
  let typeTab = $(this).attr('tab').toUpperCase();
  switch (typeTab) {
  case 'REGISTRO':
  VisiblePanel(pDespacho);
  $('.cont_paginador').fadeOut('fast');
  break;
  case 'REPORTES':
  VisiblePanel(pReportes);
  $('.cont_paginador').fadeIn('fast');
  break;
}
  let tab = $(this);
  if (!tab.hasClass('active-tab')) {
    tab.fadeOut('fast', function() {
      $('.tab-button.active-tab').removeClass('active-tab');
      tab.addClass('active-tab');
    });
    tab.fadeIn('fast');
  }
});

function VisiblePanel(panel) {
  if(!panel.hasClass('active-panel')) {
    $('.col-panel.active-panel').fadeOut('fast',function() {
      $(this).removeClass('active-panel');
      panel.removeClass('hidden');
      panel.addClass('active-panel');
    });
  }
}

function RegistrarDespacho(FormData){
if (ValidarMarcadorAmbulancia() != 0) {
  ListarNovedad();
  var cantidad = $("#btnRegistrarDespacho").attr("numeroLesionados");
  if (cantidad>0) {
    $.ajax({
      url: url + "Despachador/ctrlDespacho/RegistrarDespacho",
      type:'POST',
      dataType:'JSON',
      data:FormData
    }).done(function(res){
      Ejemplo();
      for (var i = 0; i < idUsuariosRegistro.length; i++) {
        if (idUsuariosRegistro[i].idAmbulancia === FormData.txtidAmbulancia) {
          idUsuariosSockets.push(idUsuariosRegistro[i].idUsuario);
        }
      }
      var parseo = (res);
      if (typeof parseo === "object") {
        objetoEnviarInfoDespacho.idReceptores =idUsuariosSockets;
        objetoEnviarInfoDespacho.idDespacho = parseo.idDespacho;
        consultarPersonalReporteAph(objetoEnviarInfoDespacho);
        Notificate({
          tipo: 'success',
          titulo: 'Notificación de éxito',
          descripcion: 'Despacho con éxito.'
        });
        ListarNovedad();
        ValidarMarcadorAmbulancia();
        cantidad--;
        if(cantidad == 0){
          $("#txtInformacion").val("");
          $("#Ambulancia").val("");
          $("#Longitud").val("");
          $("#Latitud").val("");
          $("#idPersona").val("");
          $("#lesionados").val("");
          setTimeout(function(){
          Notificate({
            tipo: 'warning',
            titulo: 'Notificación de advertencia',
            descripcion: 'No puede realizar mas despachos,el numero de afectados han sido suplidos.'
          });
        } , 2500);
          $("#btnRegistrarDespacho").attr("disabled","disabled");
          ValidarMarcadorAmbulancia();
        }
        $("#btnRegistrarDespacho").attr("numeroLesionados",cantidad);
        ValidarMarcadorAmbulancia();
      } else {
        Notificate({
          tipo: 'error',
          titulo: 'Notificación de error',
          descripcion: 'Despacho no realizado.'
        })
        ValidarMarcadorAmbulancia();
      }
    }).fail(function(){
      Notificate({
        tipo: 'error',
        titulo: 'Notificación de error',
        descripcion: 'Despacho no realizado.'
      });
      ListarNovedad();
      ValidarMarcadorAmbulancia();
    })
  }else{
    Notificate({
      tipo: 'info',
      titulo: 'Notificación de información',
      descripcion: 'Esta es una prueba de notificación de información.'
    })
    ValidarMarcadorAmbulancia();
    ListarNovedad();
  }
}
}
function Ejemplo(){
paginadorReportesActivos();
  map.eachLayer(function (layer) {
    if(layer._latlng != undefined){
        map.removeLayer(layer);
    }
  });
  ValidarMarcadorAmbulancia();
}
//RegistrarDespachoNovedad
function RegistrarDespachoNovedadReporte(){
  if (ValidarMarcadorAmbulancia() != 0) {
  var idReporte = $("#idReporte").val();
  var idAmbulancia = $("#idAmbulancia").val();
  var estadoDespacho = $("#estadoE").val();
  var longitud = $("#Longitud").val();
  var latitud = $("#Latitud").val();
  var idPersona = $("#Persona").val();
  var idNovedad = $("#Novedad").val();
  var cantidad = $("#btnRegistrarDespachoNovedad").attr("numeroLesionados");
  if (cantidad>0) {
    $.ajax({
      url: url + "Despachador/ctrlDespacho/RegistrarDespachoNovedad",
      type:'POST',
      data:{'txtReporteInicial':idReporte,'txtIdAmbulancia':idAmbulancia,'txtEstadoDespacho':estadoDespacho,'txtLongitud':longitud,'txtLatitud':latitud,'txtIdPersona':idPersona,'txtNovedad':idNovedad}
    }).done(function(res){
      if (Number(res) === 1 ) {
        Notificate({
          tipo: 'success',
          titulo: 'Notificación de éxito',
          descripcion: 'Despacho con éxito.'
        });
        ValidarMarcadorAmbulancia();
        ListarNovedad();
        cantidad--;
        if(cantidad == 0){
          $("#txtInformacion").val("");
          $("#Ambulancia").val("");
          $("#Longitud").val("");
          $("#Latitud").val("");
          $("#idPersona").val("");
          $("#lesionados").val("");
          setTimeout(function(){
          Notificate({
            tipo: 'warning',
            titulo: 'Notificación de advertencia',
            descripcion: 'No puede realizar mas despachos,el numero de afectados han sido suplidos.'
          });
        }, 2500);
          $("#btnRegistrarDespachoNovedad").attr("disabled","disabled");
        }
        $("#btnRegistrarDespachoNovedad").attr("numeroLesionados",cantidad);
      }else{
        Notificate({
          tipo: 'error',
          titulo: 'Notificación de error',
          descripcion: 'Despacho no realizado.'
        })
      }
    }).fail(function(){
      Notificate({
        tipo: 'error',
        titulo: 'Notificación de error',
        descripcion: 'Despacho no realizado.'
      });
      ValidarMarcadorAmbulancia();
    })
    ValidarMarcadorAmbulancia();
    ListarNovedad();
    return false;
  }else{
    Notificate({
      tipo: 'info',
      titulo: 'Notificación de información',
      descripcion: 'Esta es una prueba de notificación de información.'
    })
    ValidarMarcadorAmbulancia();
    ListarNovedad();
  }
}
}
//Listar marcadores de las ambulancias
function ListarMarcadorAmbulancia() {
  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: url + "Despachador/ctrlDespacho/ListadoMarcadores",
    data: {"": ""}
  }).done(function (e) {
    if (e.length !=0){
    idUsuariosRegistro = e;
    console.log(idUsuariosRegistro);
    var flags = [], output = [], l = e.length, i;
    for( i=0; i<l; i++) {
      if( flags[e[i].idAmbulancia]) continue;
      flags[e[i].idAmbulancia] = true;
      output.push(e[i]);
    }
    for (var t = 0; t <= output.length; t++) {
      var medico = "";
      $.each(e, function (i, v) {
        if(output[t].idAmbulancia == v.idAmbulancia){
          medico+=" Nombre: "+v.primerNombre+" "+v.primerApellido+" Especialidad: "+v.descripcionRol+"<br>";
        }
      })
      L.marker([output[t].latitud, output[t].longitud], {icon:myIconAmbu}).bindPopup("Tipo Ambulancia: "+output[t].tipoAmbulancia+" <br>"+medico).addTo(map).on('click', onClick, JSON.stringify({tipoAmbulancia:output[t].tipoAmbulancia,id:output[t].idAmbulancia}) );
    }
  }
}).fail(function () {
})
}
//Funcion Para listar ambulancias en el mapa
function ValidarMarcadorAmbulancia() {
  var contadorInicial=0;
  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: url + "Despachador/ctrlDespacho/ListadoMarcadores",
    async:false
  }).done(function (e) {
    if (e.length == 0) {
      swal({
        title: "No hay ambulancias Disponibles.",
        text: "Desea emitir los reportes a otras entidades?",
        type: "info",
        showCancelButton: true,
        confirmButtonClass: "btn-succes",
        confirmButtonText: "Si",
        closeOnConfirm: true
      });
      ListarMarcadorAmbulancia();
      paginadorReportesActivos();
      contadorInicial = 0;
      map.eachLayer(function (layer) {
        if(layer._latlng != undefined){
          if (cont > 0) {
            map.removeLayer(layer);
          }
          cont++;
        }
      });
    }else{
      ListarMarcadorAmbulancia();
      paginadorReportesActivos();
      contadorInicial = e.length;
    }
}).fail(function () {
})
return contadorInicial;
}
function onClick(e) {
  var marcador = JSON.parse(this);
  $("#Ambulancia").val(marcador.tipoAmbulancia);
  $("#idAmbulancia").val(marcador.id);
}
//Función para listar reportes de reporte
function ListarReporte(data) {
  $("#panelRegistroDespacho").hide();
  let htmlReporte = "";
  if (data == null || data == undefined) {
    $('#contenedor-reportes').empty();
  }else{
    $.each(data, function (l, s) {
      htmlReporte+=
      '<li class="list_item n_dont_grow " style="width: 80% !important">' +
        '<div class="list_item_header n_flex n_nowrap">' +
          '<div class="item_icon n_flex n_align_center">' +
            '<span class="fa fa-flag-o"></span>' +
          '</div>' +
          '<div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden">' +
            '<h5 class="text_bold suspensive"> Reporte: ' + s.idReporteInicial + '</h5>' +
          '</div>' +
        '</div>' +
        '<div class="list_item_content suspensive_2">' +
          '<p class="paragraph">' +
            '<span class="text_bold">Información: </span>' + s.informacionInicial +
          '</p>' +
        '</div>' +
        '<div class="list_item_footer n_flex n_justify_between horizontal_padding">' +
          '<div class="footer_element">' +
            '<p><span class="text_bold">Fecha: </span>' + s.fechaHoraEnvioReporteInicial + '</p>' +
          '</div>' +
          '<div class="footer_element n_flex n_align_center">' +
          '<div class="tooltip">'+
            '<span class="btn btn-consultar btn_view-report tab-button" tab="REGISTRO" onclick="cargarInfo('+"'"+s.idReporteInicial+"'"+','+"'"+s.informacionInicial+"'"+','+"'"+s.ubicacionIncidente+"'"+','+"'"+s.numeroLesionados+"'"+')" ><i class="fa fa-eye"></i></span>'+
            '<span class="tooltiptext">Reporte</span>'+
          '</div>' +
        '</div>' +
      '</div>' +
      '</li>' +
      '</ul></div>'

    })
    $('#contenedor-reportes').html(htmlReporte);
  }
}
//Listar novedad
function ListarNovedad(){
  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: url + "Despachador/ctrlDespacho/ListarNovedades",
    data: {"": ""}
  }).done(function (i) {
    var contador = 0;
    var activadorNotificacion;
    $.each(i, function (n, v) {
      contador++;
      $('#novedad').append('<span onClick="cargarNovedad('+"'"+v.idReporteInicial+"'"+','+"'"+v.descripcionNovedad+"'"+','+"'"+v.ubicacionIncidente+"'"+','+"'"+v.numeroLesionadosNovedad+"'"+','+"'"+v.idNovedad+"'"+')">'+
        '<div class="notificacion-f n-llamada">'+
        '<div class="icon-llamada">'+
        '<span class="fa fa-exclamation"></span>'+
        '</div>'+
        '<div class="contenido-notifiN">'+
        '<h5>EMERGENCIA! <span>'+v.idReporteInicial+'</span></h5>'+
        '<p>'+
        '<b>Descripcion de la Novedad:</b>'+v.descripcionNovedad+''+
        '</p>'+
        '<p><b>Dirección:</b>'+v.ubicacionIncidente+'</p>'+
        '</div>'+
        '</div>'+
        '</span>'
        );
    })
    if (contador == 0) {
      activadorNotificacion = false;
      nuevaNotificacion(contador,activadorNotificacion);
    }else{
      activadorNotificacion = true;
      nuevaNotificacion(contador,activadorNotificacion);
    }
  }).fail(function () {
  })
}
//Cargar novedad
function cargarNovedad(idReporteInicial,descripcionNovedad,direccionEmergencia,numeroLesionadosNovedad,idNovedad){
  VisiblePanel(pDespacho);
  if (!$('#tabDespacho').hasClass('active-tab')) {
    $('#tabReportes').fadeOut('fast', function() {
      $('#tabReportes').removeClass('active-tab');
      $('#tabDespacho').addClass('active-tab');
      $('.cont_paginador').fadeOut('fast');
    });
    $('#tabReportes').fadeIn('fast');
  }
  $("#btnRegistrarDespacho").hide();
  $("#btnRegistrarDespachoNovedad").show();
  CerrarMenuNotificaciones();
  $("#txtInformacion").val(descripcionNovedad);
  $("#idReporte").val(idReporteInicial);
  $("#txtLL").val(direccionEmergencia);
  $("#lesionados").val(numeroLesionadosNovedad);
  $("#Novedad").val(idNovedad);
  $("#btnRegistrarDespachoNovedad").attr("numeroLesionados",numeroLesionadosNovedad);
  var geocoder;
  geocoder = new google.maps.Geocoder();
  address = document.getElementById('txtLL').value
  if (geocoder) {
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        var cont = 0;
        map.eachLayer(function (layer) {
          if(layer._latlng != undefined){
            if (cont > 0) {
              map.removeLayer(layer);
            }
            cont++;
          }
        });
        L.marker([results[0].geometry.location.lat(),results[0].geometry.location.lng()]).addTo(map);
        $("#Longitud").val(results[0].geometry.location.lng());
        $("#Latitud").val(results[0].geometry.location.lat());
      } else {
      }
    });
  }
}
function CerrarMenuNotificaciones() {
  return new Promise(function(done) {
    $('.menu-notificaciones-flotantes').animate({
      right: '-1000px',
    }, 400, done);
  });
}
// CERRAR MENU DE NOTIFICACIONES AL DAR CLICK FUERA DE ÉL
$('html').click(function() {
  if ($('.menu-notificaciones-flotantes').css('right') === '0px') {
    CerrarMenuNotificaciones();
  }
});
function cargarInfo (idReporteInicial,informacionInicial,direccionEmergencia,numeroLesionados){
  VisiblePanel(pDespacho);
  if (!$('#tabDespacho').hasClass('active-tab')) {
    $('#tabReportes').fadeOut('fast', function() {
      $('#tabReportes').removeClass('active-tab');
      $('#tabDespacho').addClass('active-tab');
      $('.cont_paginador').fadeOut('fast');
    });
    $('#tabReportes').fadeIn('fast');
  }
  $("#txtInformacion").val(informacionInicial);
  $("#idReporte").val(idReporteInicial);
  $("#txtLL").val(direccionEmergencia);
  $("#lesionados").val(numeroLesionados);
  $("#btnRegistrarDespacho").attr("numeroLesionados",numeroLesionados);
  var geocoder;
  geocoder = new google.maps.Geocoder();
  address = document.getElementById('txtLL').value
  if (geocoder) {
    geocoder.geocode({'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        var cont = 0;
        map.eachLayer(function (layer) {
          if(layer._latlng != undefined){
            if (cont > 0) {
              map.removeLayer(layer);
            }
            cont++;
          }
        });
        L.marker([results[0].geometry.location.lat(),results[0].geometry.location.lng()]).addTo(map);
        $("#Longitud").val(results[0].geometry.location.lng());
        $("#Latitud").val(results[0].geometry.location.lat());
      } else {
      }
    });
  }
}
function paginadorReportesActivos(){
  var optionsReportes = {
    parent: 'paginadorReportes',
    url: 'Despachador/CtrlDespacho/ListarReportes',
    configuration: {
        tableName: 'viewlistarreportesactivos', // Es recomendable hacer esto desde el controlador
        limit: 3
      }
    };
    //funcion que genera los botones del segundo paginador
    paginator.view.generateButtons(optionsReportes)
    .then(function (data) {
      ListarReporte(data.datos);
      $('#' + optionsReportes.parent).on('click', 'li.btn_paginador', function () {
        Paginate(optionsReportes, $(this), function(data) {
          ListarReporte(data.datos);

        });
      });
    });
}
  $("#formularioDespacho").click(function(){
    $("#contenedor-reportes").hide();
    $("#paginadorReportes").hide();
    $("#panelRegistroDespacho").fadeOut();
    $("#panelRegistroDespacho").show();
  });
  $("#reportesPaginador").click(function(){
    $("#panelRegistroDespacho").hide();
    $("#paginadorReportes").hide();
    $("#contenedor-reportes").fadeIn();
    $("#contenedor-reportes").show();
  });
  L.Icon.Default.imagePath = '../Img/ReporteAPH/images';
