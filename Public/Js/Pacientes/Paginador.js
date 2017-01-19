/**
* Se encarga de la consulta de los pacientes, a traves del paginador y los filtros disponoibles.
*/

(function () {

  'use strict';

  var frm = '#formMenuFiltro';
  // Configuración Basica para el paginador
  var options = {
    parent: 'paginadorPacientes',
    url: 'Pacientes/CtrlPacienteInicial/ConsultarPaciente',
    configuration: {
      tableName: '?',
      limit: 6
    }
  };


  var generarPaginador = function(msmNoResult) {
    msmNoResult = msmNoResult || 'No Se Encuentran Pacientes.';
    paginator.view.generateButtons(options)
    .then(function(data) {
      if (data.datos !== null) {
        createView(data.datos); // Primera vez
        $(frm + ' .valueTodosLimit').val(data.cantidadRegistros);
      }else {
        noResult(msmNoResult);
      }
      $('#' + options.parent).on('click', 'li.btn_paginador', function() {
        Paginate(options, $(this), function(data) {
          if (data.datos !== null) {
            createView(data.datos); // Segunda vez
            $(frm + ' .valueTodosLimit').val(data.cantidadRegistros);
          }else {
            noResult(msmNoResult);
          }
        });
      });
    });
  };

  generarPaginador();

  // Click en el icono de buscar:
  $('#btnBuscar').click(function () {
    filter();
  });

  // Evento enter en el campo de busqueda:
  $('#txtinputBusqueda').keyup(function(e){
    if(e.keyCode == 13) {
      filter();
    }
  });

  // Input filtrar por:
  $(frm + ' .filterBy').change(function () {
    filter();
  });

  // Input filtrar por:
  $(frm + ' .limit').change(function () {
    filter();
  });

  // Input buscar por:
  $(frm + ' .nameColumnFilter').change(function () {
    // if ($('#txtinputBusqueda').val()) {
    filter();
    // }
  });

  // Input ordenar por:
  $(frm + ' .nameColumnOrderBy').change(function () {
    filter();
  });

  // Input ordenar por:
  $(frm + ' .orderBy').change(function () {
    filter();
  });

  // Validar fechas filtro:
  ValidateForm('formMenuFiltro', function(date) {
    options.configuration.filterDateTimeStart = date.initialDate;
    options.configuration.filterDateTimeEnd = date.finalDate;
    filter();
  });

  $('.reset_search').click(function (event) {
    options.configuration.filterDateTimeStart = '';
    options.configuration.filterDateTimeEnd = '';
    $('#txtinputBusqueda').val('');
    filter();
    event.stopPropagation();
  });


  var filter = function () {
    let config = JSON.parse(JSON.stringify($('#formMenuFiltro').serializeArray()));

    options.configuration.limit = Number(config[0].value);
    options.configuration.page = 1;
    options.configuration.nameColumnFilter = Number(config[1].value);
    options.configuration.filter = $('#txtinputBusqueda').val() || '';
    options.configuration.nameColumnOrderBy = Number(config[4].value);
    options.configuration.orderBy = config[5].value;

    // console.log("options", options);

    generarPaginador('No se encontraron resultados que coincidan con el filtro solicitado.');

  };

  var createView = function (data) {
    $('#ListarPaciente').html('');
    $.each(data, function (index) {
      crateStructure(this);

    });
  };



  var crateStructure = function (data) {
    var color = "";
    var icono = "";
    if (data.idEstadoPaciente == 1) {
      color = "activo";
      icono = "fa fa-unlock";
    }else if (data.idEstadoPaciente == 2) {
      color = "inactivo-btn";
      icono = "fa fa-lock";
    }else {
      color = "mora";
      icono = "fa fa-lock";
    }

    let estadoDescripcion;
    if (data.idEstadoPaciente==1) {
      estadoDescripcion="Activo";
    }else if (data.idEstadoPaciente==2) {
      estadoDescripcion="Inactivo";
    }else {
      estadoDescripcion="Mora";
    }

    var html = '<div class=" list List-item n_flex n_flex_col100">'+
    '<ul class="list_panel relative_element n_flex n_justify_start block n_flex_col100">'+
    '<li class="list_item n_dont_grow n_flex_col95">'+
    '<div class="list_item_header n_flex n_nowrap ">'+
    '<div class="item_icon n_flex n_align_center">'+
    '<span class="fa fa-user"></span>'+
    '</div>'+
    '<div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden ">'+
    '<h5 class="text_bold suspensive ">'+
    '<label>'+ data.NombreCompleto +'</label>'+

    '</h5>'+
    '</div>'+
    '</div>'+

    '<div class="list_item_content n_justify_center">'+
    '<p class="paragraph">'+
    '<span class="text_bold">'+
    '<div class="n_flex  n_justify_center sm_justify_start md_justify_center">'+
    //'  <img class="imagenes1 imgPaciente separacion" id="imagenPaciente" src="'+ url +''+ data.url +'""></div>'+
    '<img  class=" imgPaciente "  id="imagenPaciente" src="'+ url +''+ data.url +'" ><br>'+
    '<div class="rayita md_justify_start n_flex n_in_columns">'+
    '<label>T.Documento: '+ data.descripcionTdocumento +'</label> '+
    '<label>Numero: '+ data.numeroDocumento +'</label> '+
    '<label>Ciudad: '+ data.ciudadResidencia +'</label> '+
    '<label>Telefono: '+ data.telefonoFijo +'</label>'+
    '<label hidden>ID: '+ data.idPaciente +'</label>'+
    '<label  hidden >Estado: '+ data.idEstadoPaciente +'</label>'+
    '</div></p>'+
    '</div>'+
    '<div class="list_item_footer n_flex n_justify_between horizontal_padding">'+
    '<div class="footer_element">'+
    '<span><i class="fa fa-calendar"></i>'+
    '<label> '+ data.fechaNacimiento +'</label> '+
    '</span>'+
    '</div>'+
    '<div class="footer_element n_flex">'+
    '<div class="tooltip separate_right">'+
    '<span class="button btn-cambiar-estado '+icono + ' ' + color+'" nonsense="'+data.idPaciente+'" data-id="'+data.idEstadoPaciente+'"></span>'+
    '<span class="tooltiptext estPaciente" id="'+data.idPaciente+data.idEstadoPaciente+'">'+estadoDescripcion+'</span>'+
    '</div>'+

    '<div class="tooltip separate_right">'+
    '<span class="button" id="ojito"><i class="fa fa-eye" onclick="ConsultaPaciente('+ data.idPaciente +')"></i></span>'+
    '<span class="tooltiptext">Consultar</span>'+
    '</div>'+
    '</div>'+

    '</div>'+
    '</li>'+

    '</ul>';

    $("<div class='n_flex n_flex_col100  md_flex_col50 lg_flex_col30'>").append(html).hide().appendTo('#ListarPaciente').fadeIn('slow');
  }


  var noResult = function (msm) {
    $('#ListarPaciente').html('');
    let structure = '\
    <div class="n_flex n_justify_center whole_wrapper" ng-if="!reportesAPH">\
    <div class="n_flex_col50 md_flex_col30 lg_flex_col25 block">\
    <img class="whole_wrapper img_no_data" src="'+ url +'Public/Img/Pacientes/no-results.png" alt="No hay reportes disponibles." />\
    </div>\
    <div class="n_flex n_flex_col100 n_justify_center">\
    <h3 style="text-align:center; opacity:.6;">'+ msm +'</h3>\
    </div>\
    </div>';

    $('#ListarPaciente').hide().append(structure).fadeIn('slow');
  }

  $('#ListarPaciente').on('click', '.btn-cambiar-estado', function() {
    let idPaciente = $(this).attr('nonsense');
    let estado = $(this).attr('data-id');
    CambiarEstadoDatosPaciente(idPaciente, estado, $(this));
  });


})(this);

function ConsultaPaciente($idPaciente){
  var id =$idPaciente;
  localStorage.setItem("idP",id);
  location.href=""+url+"Pacientes/CtrlConsultaPaciente";
}

function CambiarEstadoDatosPaciente(idD, idEstado, boton){

  if (idEstado != 3){
    $.ajax({
      type: 'POST',
      url: url + "Pacientes/CtrlPacienteInicial/CambiarEstado",
      data:{'id':idD, 'idEstado':idEstado}
    }).done(function (d) {
      //console.log(d);
      var estado = Number(d);
      var tool = $(".estPaciente").attr("id");
      if (estado === 1) {
        $(".estPaciente").text("Activo");
        $("#"+tool).html();
        boton.removeClass( 'fa-lock' )
        .removeClass( 'inactivo-btn' )
        .addClass( 'fa-unlock' )
        .addClass( 'activo' )
        .attr("data-id",estado);
      }else if (estado === 2) {
        $(".estPaciente").text("Inactivo");
        boton.removeClass( 'fa-unlock' )
        .removeClass( 'activo' )
        .addClass( 'fa-lock' )
        .addClass( 'inactivo-btn')
        .attr("data-id",estado);
      }

    }).fail(function () {

    });
  }else{
    Notificate({
      tipo: 'warning',
      titulo: '',
      descripcion: 'No se le puede cambiar el estado a un paciente en estado de mora.',
      duracion : 5
    });
  }

  }
