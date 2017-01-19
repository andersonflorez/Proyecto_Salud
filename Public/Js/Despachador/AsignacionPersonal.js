$(document).ready(function(){
  localStorage.removeItem("Mapa");
  localStorage.removeItem("Ambulancia");
})
  //botones para controlar el wizard
  $("#AntAsignacion").hide();
  $("#SigAsignacion").hide();
  $("#GuardarAsignacion").hide();
  $("#personalAmbulancia").hide();

  var cont = 0;
  var contenido = $("#ambulanciasUbicacion");
  //function que identifica en que section esta del wizard, en el momento de dar click a la fecha derecha
  $("#SigAsignacion").click(function() {

    if (contenido.attr("id") == "ambulanciasUbicacion") {
      $(contenido).fadeOut(function() {
        if (contenido.attr("id") == "ambulanciasUbicacion") {
          $("#SigAsignacion").hide();
          $("#GuardarAsignacion").show();
          $("#AntAsignacion").show();
          contenido = $("#personalAmbulancia");
          $(contenido).fadeIn();
          cont++;
          swal({
            title: "Información.",
            text: "La primer persona seleccionada será el lider de la ambulancia.",
            type: "info",
            showCancelButton: false,
            confirmButtonClass: "btn-info",
            confirmButtonText: "ok",
            closeOnConfirm: true
          });
          //$("#SigAsignacion").fadeIn();
        }

      });
    }
    if (contenido.attr("id") == "personalAmbulancia") {


    }


  });
  //boton que ejecuta la acción de registrar junto con las validaciones por tipo de ambulancia
  $("#GuardarAsignacion").click(function(){
    localStorage.removeItem("Mapa");
    localStorage.removeItem("Ambulancia");
    var persona = [];
    //llenado del array persona capturando el id y la especialidad de la misma
    for (var i = 0; i < $(".chbIdPersona").length; i++) {
      if ($(".chbIdPersona").eq(i).is(":checked")) {
        persona.push({id: $(".chbIdPersona").eq(i).val(), especialidad: $(".personaEspecialidad").eq(i).html()});

      }
    }
    //variable que contiene el id de la ambulancia
    var ambu = $('input:radio[name=TxtAmbulancia]:checked').val();
    //variable que contiene el id del tipo de ambulancia
    var input = "t"+ambu;
    //variables a la que se le asigna el tipo de ambulancia para hacer las validaciones
    var tipoAmbulancia = $("#t"+ambu).val();
    //variable para contar los médicos en cada ambulancia, seún su tipo.
    var contadorMedico = 0;

    //validar el tipo de ambulancia si es TAM
    if (tipoAmbulancia == "TAM" || tipoAmbulancia == "Tam" || tipoAmbulancia == "tam") {

      //se recorre el array persona para extraer su especialidad
      for (var p = 0; p < persona.length; p++) {
        //se pregunta si la especialidad de la persona seleccionada es medico
        if (persona[p].especialidad == "medico" || persona[p].especialidad == "MEDICO" || persona[p].especialidad == "Medico" || persona[p].especialidad == "Medico General" || persona[p].especialidad == "Medico general" || persona[p].especialidad == "MEDICO GENERAL"
          || persona[p].especialidad == "médico" || persona[p].especialidad == "MÉDICO" || persona[p].especialidad == "Médico" || persona[p].especialidad == "Médico General" || persona[p].especialidad == "Médico general" || persona[p].especialidad == "MÉDICO GENERAL") {
          //se le asigna un valor al contador de medicos
        contadorMedico ++;
      }
    }
      //se pregunta si la cantidad de personas seleccionadas, son mas o menos de tres
      if (p < 3 || p > 3) {
        //alerta de información acerca de la cantidad de personas que se deben seleccionar
        Notificate({
          tipo: 'info',
          titulo: 'Notificación de éxito',
          descripcion: ' Debes seleccionar tres personas.'
        });
        //condicion que valida la cantidad de personas y la cantidad de medicos que fueron seleccionados
      }else if(contadorMedico == 0){
        //en caso de que el contador de medico sea igual a cero, se imprimer una notificación
        Notificate({
          tipo: 'info',
          titulo: 'Notificación de advertencia',
          descripcion: 'Debe seleccionar al menos un medico.'
        });
      }
      //condición que valida que la cantidad de medicos sea mayor o igual a uno.
      else if (contadorMedico >= 1) {
        //variables que contienen el id de la persona seleccionada
        var personaU = persona[0]["id"];
        var personaD = persona[1]["id"];
        var personaT = persona[2]["id"];
        var latitud = $("#TxtLatitud").val();
        var longitud = $("#TxtLongitud").val();
        if (latitud == "" && longitud == "") {
          Notificate({
            tipo: 'error',
            titulo: 'Notificación de error',
            descripcion: 'Debe asignar una posición a la ambulancia.'
          });
        }else{

        //función ajax para ejecutar el registrar
        $.ajax({
          type: 'POST',
          url: url + "Despachador/ctrlAsignacionPersonal/registrarAsignacion",
          data: {
            'TxtAmbulancia': ambu,
            'TxtLongitud': longitud,
            'TxtLatitud': latitud,
            'personaU': personaU,
            'personaD': personaD,
            'personaT': personaT
          }
        }).done(function(data) {
          Notificate({
            tipo: 'success',
            titulo: 'Notificación de éxito',
            descripcion: 'Asignación de personal registrada correctamente.'
          });
        
        setTimeout('document.location.reload()',1000);
}).fail(function() {
  Notificate({
    tipo: 'error',
    titulo: 'Notificación de error',
    descripcion: 'Ha ocurrido un error al intentar registrar.'
  });
})
}
}
}
    //condición que valida si el tipo de ambulancia es TAB
    if(tipoAmbulancia == "TAB" || tipoAmbulancia == "tab" || tipoAmbulancia == "Tab"){
      //variable para contar la cantidad de paramedicos dentro de la ambulancia
      var contadorParamedico=0;
      //se recorre el array persona para extraer la especialidad de cada uno
      for (var p = 0; p < persona.length; p++) {
        //valida que la persona tenga la especialidad de paramedico
        if (persona[p].especialidad == "paramedico" || persona[p].especialidad == "Paramedico" || persona[p].especialidad == "PARAMEDICO"
          || persona[p].especialidad == "paramédico" || persona[p].especialidad == "Paramédico" || persona[p].especialidad == "PARAMÉDICO") {
          //asignamos un valor al contador de paramedicos
        contadorParamedico ++;
      }
    }

      //condición que valida que la cantidad de personas no sea diferente de 3
      if (p < 3 || p > 3) {
        Notificate({
          tipo: 'info',
          titulo: 'Notificación de éxito',
          descripcion: ' Debes seleccionar tres personas.'
        });
        //condicion que valida el valor del contador paramedicos
      }else if(contadorParamedico <3){
        //notificación en caso de que el contador sea menor a tres
        Notificate({
          tipo: 'info',
          titulo: 'Notificación de advertencia',
          descripcion: 'La ambulancia tipo TAB debe contener 3 paramedicos.'
        });
      }
      //condicion que valida la cantidad de paramedicos
      else if (contadorParamedico == 3) {
        //variables que contienen el id de cada persona seleccionada
        var personaU = persona[0]["id"];
        var personaD = persona[1]["id"];
        var personaT = persona[2]["id"];
        var latitud = $("#TxtLatitud").val();
        var longitud = $("#TxtLongitud").val();
        if (latitud == "" && longitud == "") {
          Notificate({
            tipo: 'error',
            titulo: 'Notificación de error',
            descripcion: 'Debe asignar una posición a la ambulancia.'
          });
        }else{

        //función para ejecutar el registrar de la asignación
        $.ajax({
          type: 'POST',
          url: url + "Despachador/ctrlAsignacionPersonal/registrarAsignacion",
          data: {
            'TxtAmbulancia': ambu,
            'TxtLongitud': longitud,
            'TxtLatitud': latitud,
            'personaU': personaU,
            'personaD': personaD,
            'personaT': personaT
          }
        }).done(function(data) {
          Notificate({
            tipo: 'success',
            titulo: 'Notificación de éxito',
            descripcion: 'Asignación de personal registrada correctamente.'
          });

        setTimeout('document.location.reload()',1000);
}).fail(function() {
  Notificate({
    tipo: 'error',
    titulo: 'Notificación de error',
    descripcion: 'Ha ocurrido un error al intentar registrar.'
  });
})
}
}
}
});
  //función que controla la flecha izquierda del wizard
  $("#AntAsignacion").click(function() {
    $(contenido).fadeOut(function() {
      if (contenido.attr("id") == "personalAmbulancia") {
        contenido = $("#ambulanciasUbicacion");
        $(contenido).fadeIn();
        $("#GuardarAsignacion").hide();
        $("#SigAsignacion").show();
        $("#AntAsignacion").hide();
      }
    });
  });

  registrarDetalleAsignacion = function() {
    var formAsig = new FormData(document.getElementById("FrmPersona"));
    alert(formAsig);
  }

  //función para listar las ambulancias dentro del paginador
  function listarAmbulancias(data) {
    let html = '';
    $.each(data, function(l, s) {
      html += '<li class="list_item n_dont_grow">' +
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
      '<div class="footer_element n_flex">' +
      '<div class="radio cont-rdo">' +
      '<input type="radio" id="a' + s.idAmbulancia + '" name="TxtAmbulancia" value="' + s.idAmbulancia + '" onClick="validarDatosCompletos('+"'"+s.idAmbulancia +"'"+',true,false)">' +
      '<label for="a' + s.idAmbulancia + '" class="rdo-redondo">' +
      '</label>' +
      '</div>' +
      '</div>' +
      '</div>' +
      '</li>';

    });

    $('#Ambulancias').html(html);

  }
  //función para listar las personas junto con su especialidad
  function ListarPersonas(data) {
    if (data != null) {
      $('.informacion').hide();
      let html2 = "";
      $.each(data, function(j, p) {
        html2 += '<li class="list_item n_dont_grow" >' +
        '<div class="list_item_header n_flex n_nowrap">' +
        '<div class="item_icon n_flex n_align_center">' +
        '<span class="fa fa-user"></span>' +
        '</div>' +
        '<div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden">' +
        '<h5 class="text_bold suspensive"><label class="personaEspecialidad">' + p.descripcionRol + '</label></h5>' +
        '</div>' +
        '</div>' +

        '<div class="list_item_content suspensive_3">' +
        '<p class="paragraph">' +
        '<span class="text_bold">Nombre: </span>' +
        p.primerNombre + ' ' + p.primerApellido + '' +
        '</p>' +
        '</div>' +

        '<div class="list_item_footer n_flex n_justify_between horizontal_padding">' +
        '<div class="footer_element">' +

        '</div>' +
        '<div class="footer_element n_flex">' +
        '<div class="cont-checkbox">' +
        '<div class="checkbox">' +
        '<input id="p' + p.idPersona + '" value="' + p.idPersona + '" type="checkbox" name="TxtPersona" class="chbIdPersona">' +
        '<label for="p' + p.idPersona + '"><span class="fa fa-check"></span></label>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</li>'

      })
      $('#PersonaAmbulancia').html(html2);
    }else{
      $("#GuardarAsignacion").hide();
      $('.informacion').show();

    }


  }
  function validarDatosCompletos(idAmbulancia,check,mapa){

    if (idAmbulancia != 0) {
      localStorage.setItem("Ambulancia",idAmbulancia);
    }
      var idambulanciaLocal = localStorage.getItem("Ambulancia") || "0";
      var booleanMapa = localStorage.getItem("Mapa") || "false";

    if (idambulanciaLocal != 0 && booleanMapa === "true") {
        $("#SigAsignacion").show();
    }else{
      $("#SigAsignacion").hide();
    }
  }
  //variable que contiene el valor de la barra de busqueda del paginador
  var filtroNombre = $('#txtinputBusqueda').val();
  //configuracion del paginador
  var options = {
    parent: 'paginadorPersonal',
    url: 'Despachador/ctrlAsignacionPersonal/ListarPersonal',
    configuration: {
      tableName: 'viewPersonalAmbulancia', // Es recomendable hacer esto desde el controlador
      limit: 9,
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
  //funcion que genera los botones del paginador
  paginator.view.generateButtons(options)
  .then(function (data) {
    ListarPersonas(data.datos);

    $('#' + options.parent).on('click', 'li.btn_paginador', function () {
      Paginate(options, $(this), function(data) {
        ListarPersonas(data.datos);

      });
    });
  });




  //configuracion del segundo paginador
  var options2 = {
    parent: 'paginadorDinamico',
    url: 'Despachador/ctrlAsignacionPersonal/ListarAmbulancias',
    configuration: {
      tableName: 'viewambulanciasdisponibles', // Es recomendable hacer esto desde el controlador
      limit: 3
    }
  };
  //funcion que genera los botones del segundo paginador
  paginator.view.generateButtons(options2)
  .then(function (data) {
    listarAmbulancias(data.datos);

    $('#' + options2.parent).on('click', 'li.btn_paginador', function () {
      Paginate(options2, $(this), function(data) {
        listarAmbulancias(data.datos);

      });
    });
  });
  //funcion para filtrar las personas
  function FiltrarPersona() {
    let filtro = $('#txtinputBusqueda').val();
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
          let message = 'Ningúna persona coincide con los filtros de búsqueda especificados';
        } else {
          // SINO, LISTAR RESULTADOS:
          ListarPersonas(data.datos);
        }
        showBtnToClean();
      });
    }
  }
  //muestra el boton de limpiar busqueda
  function showBtnToClean() {
    let btn = '<div id="divToClean" class="n_flex n_justify_center clean_filters" style="cursor: pointer; width: 100% !important; position: absolute; bottom: 0; background: #eee; font-size: 25px; font-weight: bold; left: 0;"><h5 id="btnToClean" class="text_bold">Limpiar búsqueda y volver</h5></div>';
    if (!$('#divToClean').length) {
      $('#PersonaAmbulancia').prepend(btn);
      $('#PersonaAmbulancia').css('padding-bottom', '60px');
    }
  }
  //oculta el boton de limpiar busqueda
  function hideBtnToClean() {
    $('#btnToClean').fadeOut('fast', function() {
      $('#contenedor-boton').css('padding-bottom', '1em');
      $('#divToClean').remove();

      $('#txtinputBusqueda').val("");

      var options = {
        parent: 'paginadorPersonal',
        url: 'Despachador/ctrlAsignacionPersonal/ListarPersonal',
        configuration: {
          tableName: 'viewPersonalAmbulancia', // Es recomendable hacer esto desde el controlador
          limit: 9,
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
      paginator.view.generateButtons(options)
      .then(function (data) {
        ListarPersonas(data.datos);

        $('#' + options.parent).on('click', 'li.btn_paginador', function () {
          Paginate(options, $(this), function(data) {
            ListarPersonas(data.datos);

          });
        });
      });
    });


  }


  //filtra cuando se preciona enter en la barra de busqueda
  $('#txtinputBusqueda').keypress(function(e) {
    if (e.keyCode == 13) {

      FiltrarPersona();
    }
  });

  // PAGINAR AL FILTRAR REPORTES PRESIONANDO CLICK EN EL BOTÓN BUSCAR:
  $('#btnFiltrar').click(function() {

    FiltrarPersona();
  });

  $('#PersonaAmbulancia').on('click', '#btnToClean', function() {

    // RESTABLECER CONFIGURACIÓN INICIAL DEL PAGINADOR:
    paginator.view.generateButtons(options)
    .then(function (data) {
      ListarPersonas(data.datos);

      $('#' + options.parent).on('click', 'li.btn_paginador', function () {
        Paginate(options, $(this), function(data) {
          ListarPersonas(data.datos);

        });
      });
    });

    hideBtnToClean();
  });
