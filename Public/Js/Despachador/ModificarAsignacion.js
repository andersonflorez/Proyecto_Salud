$(document).ready(function(){
  ListarCombos1();
  ListarCombos2();
  ListarCombos3();

  $("#btnModificarAsignacionPersonal").click(function(){
    modificarPersonal();
  });
});
$("#slcPersona1").select2({
  placeholder:"Seleccione Una Persona"
});
$("#slcpersona2").select2({
  placeholder:"Seleccione Una Persona"
});
$("#slcPersona3").select2({
  placeholder:"Seleccione Una Persona"
});
//funcion para listar el combo de persona 1
function ListarCombos1(){
  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: url + "Despachador/ctrlModificarAsignacion/ListarCombosP",
    data:{"":""}
  }).done(function(data) {
    $.each(data,function(i, v){
      $("#slcPersona1").append('<option value="'+v.idPersona+'">'+v.primerNombre+' '+v.primerApellido+' '+v.descripcionRol+'</option>');
    });
  }).fail(function() {
    Notificate({
      tipo: 'error',
      titulo: 'Notificación de error',
      descripcion: 'Ha ocurrido un error al intentar listar los combos.'
    });
  })
}
//funcion para listar el combo de persona 2
function ListarCombos2(){
  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: url + "Despachador/ctrlModificarAsignacion/ListarCombosP",
    data:{"":""}
  }).done(function(data) {
    $.each(data,function(i, v){
      $("#slcpersona2").append('<option value="'+v.idPersona+'">'+v.primerNombre+' '+v.primerApellido+' '+v.descripcionRol+'</option>');
    })
  }).fail(function() {
    Notificate({
      tipo: 'error',
      titulo: 'Notificación de error',
      descripcion: 'Ha ocurrido un error al intentar listar los combos.'
    });
  })
}
//funcion para listar combo persona 3
function ListarCombos3(){
  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: url + "Despachador/ctrlModificarAsignacion/ListarCombosP",
    data:{"":""}
  }).done(function(data) {
    $.each(data,function(i, v){
      $("#slcPersona3").append('<option value="'+v.idPersona+'">'+v.primerNombre+' '+v.primerApellido+' '+v.descripcionRol+'</option>');
    });
  }).fail(function() {
    Notificate({
      tipo: 'error',
      titulo: 'Notificación de error',
      descripcion: 'Ha ocurrido un error al intentar listar los combos.'
    });
  })
}



var cities = new L.LayerGroup();

//L.marker([6.2554629, -75.5745953]).bindPopup('Sena.').addTo(cities);


var map = L.map('map', {
  center: [6.2555037,-75.5775585],
  zoom: 13
});
var mbUrl = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
  attribution: '© OpenStreetMap contributors'
}).addTo(map);
var point = L.point(200,300);
//funcion para consultar el personal de una ambulancia

function consultarPersonal(idAmbulancia){

  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: url + "Despachador/ctrlModificarAsignacion/ConsultarAsignaciones",
    data: {
      'TxtIdAmbulancia': idAmbulancia
    }
  }).done(function(data) {

    if (data == "1") {
      alert();
    }else{

    map.eachLayer(function (layer) {

      if(layer._latlng != undefined){
        map.removeLayer(layer);
        sessionStorage.clickcount = 0;
        $('#TxtLatitud').val("");
        $('#TxtLongitud').val("");
      }
    });
    if ($.isEmptyObject(data)) {
      Notificate({
        tipo: 'info',
        titulo: 'información',
        descripcion: 'La ambulancia seleccionada no cuenta con una asignación.'
      });
    }else{
      map.eachLayer(function (layer) {

        if(layer._latlng != undefined){
          map.removeLayer(layer);
          sessionStorage.clickcount = 0;
          $('#TxtLatitud').val("");
          $('#TxtLongitud').val("");
        }
      });
      $("#idDetalle1").val(data[0].idDetalleAsignacion);
      $("#idDetalle2").val(data[1].idDetalleAsignacion);
      $("#idDetalle3").val(data[2].idDetalleAsignacion);
      $("#idAsignacion").val(data[0].idAsignacionPersonal);

      $("#latitud").val(data[0].latitud);
      $("#longitud").val(data[0].longitud);

      $("#codigoAmbulancia").html(data[0].idAmbulancia);
      $("#select2-slcPersona1-container").html(data[0].Nombre_Completo+" <span id='s1' >"+ data[0].descripcionRol+"</span>");
      $("#select2-slcPersona1-container").attr("title",data[0].Nombre_Completo+" "+ data[0].descripcionRol);
      $("#slcPersona1").val(data[0].idPersona).trigger("change");

      $("#select2-slcpersona2-container").html(data[1].Nombre_Completo+" <span id='s2'>"+ data[1].descripcionRol+"</span>");
      $("#select2-slcpersona2-container").attr("title",data[1].Nombre_Completo +" <span id=''>"+ data[1].descripcionRol+"</span>");
      $("#slcpersona2").val(data[1].idPersona).trigger("change");

      $("#select2-slcPersona3-container").html(data[2].Nombre_Completo+" <span id='s3'>"+ data[2].descripcionRol+"</span>");
      $("#select2-slcPersona3-container").attr("title",data[2].Nombre_Completo+" <span id=''>"+ data[2].descripcionRol+"</span>");
      $("#slcPersona3").val(data[2].idPersona).trigger("change");
      sessionStorage.clickcount = 0;

      var marker = null;
      marker = L.marker([data[0].latitud, data[0].longitud]).bindPopup('Ambulancia '+data[0].idAmbulancia).addTo(map);
      sessionStorage.clickcount = 1;

    }
  }
  }).fail(function() {
    Notificate({
      tipo: 'error',
      titulo: 'Notificación de error',
      descripcion: 'Ha ocurrido un error al intentar listar los combos.'
    });
  });
  map.on('click', function(e) {
    if (sessionStorage.clickcount) {

      if (sessionStorage.clickcount == 0) {

        marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;
        $('#latitud').val(lat);
        $('#longitud').val(lng);
        sessionStorage.clickcount = 1;
      }else{
        Notificate({
          tipo: 'info',
          titulo: 'información',
          descripcion: 'Para asignar nueva posición reinicie los marcadores.'
        });

      }

    }
  });
  $("#txtDireccion").click(function(){
    sessionStorage.clickcount = 0;
    setTimeout(function(){
      sessionStorage.clickcount = 0;
      map.eachLayer(function (layer) {

        if(layer._latlng != undefined){
          map.removeLayer(layer);
          sessionStorage.clickcount = 0;

        }
      });

    },10)

  });
  $('#txtDireccion').keypress(function(e) {
    if (e.keyCode == 13) {

      initialize();
    }
  });

  var geocoder;

  function initialize() {
    geocoder = new google.maps.Geocoder();
    address = document.getElementById('txtDireccion').value

    if (geocoder) {
      if (sessionStorage.clickcount == 0) {
        geocoder.geocode( { 'address': address}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            marker = L.marker([results[0].geometry.location.lat(), results[0].geometry.location.lng()]).addTo(map);
            sessionStorage.clickcount = 1;


          }else{
            Notificate({
              tipo: 'info',
              titulo: 'información',
              descripcion: 'Para asignar nueva posición reinicie los marcadores.'
            });
          } });
        }

      }
    }
  }





  function reseteo(){
    map.eachLayer(function (layer) {

      if(layer._latlng != undefined){
        map.removeLayer(layer);
        sessionStorage.clickcount = 0;
        $('#latitud').val("");
        $('#longitud').val("");
        $('#txtDireccion').val("");
      }
    });
  }


  function modificarPersonal(){
    //var especialidad =
    //función para ejecutar el registrar de la asignación
    var latitud = $("#latitud").val();
    var longitud = $("#longitud").val();
    var ambulancia = $("#codigoAmbulancia").html();
    var idAsignacionP = $("#idAsignacion").val();
    var personaU = $("#slcPersona1").val();
    var personaD = $("#slcpersona2").val();
    var personaT = $("#slcPersona3").val();
    var detalleU = $("#idDetalle1").val();
    var detalleD = $("#idDetalle2").val();
    var detalleT = $("#idDetalle3").val();

    $.ajax({
      type: 'POST',
      dataType: 'Text',
      url: url + "Despachador/ctrlModificarAsignacion/modificarAsignaciones",
      data: {
        'TxtIdAsignacion': idAsignacionP,
        'TxtAmbulancia': ambulancia,
        'TxtLongitud': longitud,
        'TxtLatitud': latitud,
        'personaU': personaU,
        'personaD': personaD,
        'personaT': personaT,
        'detalleU': detalleU,
        'detalleD': detalleD,
        'detalleT': detalleT
      }
    }).done(function(respuesta)
    {

      if (respuesta == "TAM") {
        Notificate({
          tipo: 'info',
          titulo: 'Modificación del Personal.',
          descripcion: 'Debe seleccionar por lo menos un medico para la ambulancia tipo TAM.'
        });
      }else if(respuesta == "TAB"){
        Notificate({
          tipo: 'info',
          titulo: 'Modificación del Personal.',
          descripcion: 'Debe seleccionar tres paramedicos para la ambulancia tipo TAB.'
        });
      }else{
      Notificate({
        tipo: 'success',
        titulo: 'Modificación del Personal.',
        descripcion: 'Asignación de personal modificada correctamente.'
      });
      setTimeout('document.location.reload()',2000);
    }
    }).fail(function() {
      Notificate({
        tipo: 'error',
        titulo: 'Modificación del Personal.',
        descripcion: 'Ha ocurrido un error al intentar modificar la asignación.'
      });
    })
  }
  (function () {

    //funcion para listar las asignaciones
    function listarAmbulancias(data) {
      let html = '';
      if (data == null) {

      }else{
        $.each(data, function(l, s) {
          html += '<li class="list_item n_dont_grow" style="width:320px !important;">' +
          '<div class="list_item_header n_flex n_nowrap">' +
          '<div class="item_icon n_flex n_align_center">' +
          '<span class="fa fa-ambulance"></span>' +
          '</div>' +
          '<div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden">' +
          '<h5 class="text_bold suspensive"><input type="hidden" id="t'+s.idAmbulancia+'" value="'+ s.tipoAmbulancia +'">' + s.tipoAmbulancia + '</h5>' +
          '</div>' +
          '</div>' +

          '<div class="list_item_content suspensive_3">' +
          '<p class="paragraph">' +
          '<span class="text_bold">Placa: </span>' + s.placaAmbulancia +
          '</p>' +
          '</div>' +

          '<div class="list_item_footer n_flex n_justify_between horizontal_padding">' +
          '<div class="footer_element">' +
          '<p>Ambulancia: ' + s.idAmbulancia + '</p>' +
          '</div>' +
          '<div class="footer_element n_flex content tooltip">' +
          '<span class="button "><i class="fa fa-pencil" onclick="consultarPersonal('+"'"+s.idAmbulancia+"'"+')"></i></span>'+
          '<span class="tooltiptext">Ver Asignación</span>'+
          '</div>' +
          '</div>' +
          '</li>';
        });

        $('#Asignaciones').html(html);
      }
    }

    //configuracion del paginador
    //configuracion del segundo paginador
    var filtroNombre = $('#txtBusqueda').val();
    filtroNombre = filtroNombre.toUpperCase();

    var options = {
      parent: 'paginadorAsignacion',
      url: 'Despachador/ctrlAsignacionPersonal/ListarAmbulancias',
      configuration: {
        tableName: 'viewambulanciaspersonal', // Es recomendable hacer esto desde el controlador
        limit: 4,
        // Datos opcionales
        nameColumnDateTime: '',
        filterDateTimeStart: '',
        filterDateTimeEnd: '',
        nameColumnFilter: filtroNombre,
        filter: '',
        nameColumnOrderBy: '',
        orderBy: ''
      }
    };
    //funcion que genera los botones del segundo paginador
    paginator.view.generateButtons(options)
    .then(function (data) {
      listarAmbulancias(data.datos);

      $('#' + options.parent).on('click', 'li.btn_paginador', function () {
        Paginate(options, $(this), function(data) {
          listarAmbulancias(data.datos);

        });
      });
    });


    //funcion para filtrar las personas
    function FiltrarAmbulancia() {
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
        let config = options;
        config.configuration.nameColumnFilter = $('#txtColumnaBusqueda').val();
        config.configuration.filter = busqueda;

        config.configuration.page = 1;

        paginator.view.generateButtons(config)
        .then(function(data) {
          if (!data.datos) {
            // SI NO SE ENCONTRARON RESULTADOS:
            //let message = 'Ningún reporte coincide con los filtros de búsqueda especificados';
            noResult('No coincide ninguna ambulancia con los filtros de busqueda.');
          } else {
            // SINO, LISTAR RESULTADOS:
            listarAmbulancias(data.datos);
          }
          showBtnToClean();
        });
      }
    }
    //muestra el boton de limpiar busqueda
    function showBtnToClean() {
      let btn = '<div id="divToClean" class="n_flex n_justify_center clean_filters" style="cursor:pointer; width: 100% !important; position: absolute; bottom: 0; background: #eee; font-size: 25px; font-weight: bold; left: 0;"><h5 id="btnToClean" class="text_bold">Limpiar búsqueda y volver</h5></div>';
      if (!$('#divToClean').length) {
        $('#Asignaciones').prepend(btn);
        $('#Asignaciones').css('padding-bottom', '60px');
      }
    }
    //oculta el boton de limpiar busqueda
    function hideBtnToClean() {
      $('#btnToClean').fadeOut('fast', function() {
        $('#contenedor-boton').css('padding-bottom', '1em');
        $('#divToClean').remove();

        $('#txtBusqueda').val("");
        var options = {
          parent: 'paginadorAsignacion',
          url: 'Despachador/ctrlAsignacionPersonal/ListarAmbulancias',
          configuration: {
            tableName: 'viewambulanciaspersonal', // Es recomendable hacer esto desde el controlador
            limit: 4,
            // Datos opcionales
            nameColumnDateTime: '',
            filterDateTimeStart: '',
            filterDateTimeEnd: '',
            nameColumnFilter: filtroNombre,
            filter: '',
            nameColumnOrderBy: '',
            orderBy: ''
          }
        };
        //funcion que genera los botones del segundo paginador
        paginator.view.generateButtons(options)
        .then(function (data) {
          if (data !== null) {
            listarAmbulancias(data.datos);

            $('#' + options.parent).on('click', 'li.btn_paginador', function () {
              Paginate(options, $(this), function(data) {
                listarAmbulancias(data.datos);

              });
            });
          }else{
            noResult('No se encontraron resultados.');
          }

        });
      });


    }


    //filtra cuando se preciona enter en la barra de busqueda
    $('#txtBusqueda').keypress(function(e) {
      if (e.keyCode == 13) {

        FiltrarAmbulancia();
      }
    });

    // PAGINAR AL FILTRAR REPORTES PRESIONANDO CLICK EN EL BOTÓN BUSCAR:
    $('#btnFiltrar').click(function() {

      FiltrarAmbulancia();
    });

    $('#Asignaciones').on('click', '#btnToClean', function() {

      // RESTABLECER CONFIGURACIÓN INICIAL DEL PAGINADOR:
      paginator.view.generateButtons(options)
      .then(function (data) {
        listarAmbulancias(data.datos);

        $('#' + options.parent).on('click', 'li.btn_paginador', function () {
          Paginate(options, $(this), function(data) {
            Listar(data.datos);

          });
        });
      });

      hideBtnToClean();
    });

    var noResult = function (msm) {
      $('#Asignaciones').html('');
      var structure = '\
      <div class="n_flex n_justify_center whole_wrapper">\
      <div class="n_flex_col50 md_flex_col30 lg_flex_col25 block">\
      <img class="whole_wrapper img_no_data" src="'+ url +'Public/Img/Todos/no-results.png" alt="No se encontraron datos." />\
      </div>\
      <div class="n_flex n_flex_col100 n_justify_center">\
      <h3 style="text-align:center; opacity:.6;">'+ msm +'</h3>\
      </div>\
      </div>';

      $('#Asignaciones').hide().append(structure).fadeIn('slow');
    };

    L.Icon.Default.imagePath = '../Img/ReporteAPH/images';
  })(this);
