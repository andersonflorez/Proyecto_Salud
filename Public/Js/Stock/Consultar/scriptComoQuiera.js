$(document).ready(function(){
  var frm = '#frmFiltroBusqueda';
  // Configuración Basica para el paginador
  var options = {
      parent: 'paginadorDinamico',
      url: 'Stock/ctrlConsultarAtencionTratamiento/consultarAtenciones/'+idPaciente,
      configuration: {
          tableName: '..', // Es recomendable hacer esto desde el controlador
          limit: 4
      }
  };

  var generarPaginador = function(resultado) {
      resultado = resultado || 'No se encuentran atencione.';
      paginator.view.generateButtons(options)
          .then(function(data) {
          if (data.datos !== null) {
              consultarAtenciones(data); // Primera vez
              $(frm + ' #limiteTodos').val(data.cantidadRegistros);
          }else {
              noResultado(resultado);
          }
          $('#' + options.parent).on('click', 'li.btn_paginador', function() {
              Paginate(options, $(this), function(data) {
                  if (data.datos !== null) {
                      consultarAtenciones(data); // Segunda vez
                      $(frm + ' #limiteTodos').val(data.cantidadRegistros);
                  }else {
                      noResultado(resultado);
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
  $(frm + ' .orderBy').change(function () {
      filter();
  });

  $('.reset_search').click(function (event) {
      let config = JSON.parse(JSON.stringify($('#frmFiltroBusqueda').serializeArray()));
      options.configuration.limit = Number(config[0].value);
      options.configuration.page = 1;
      options.configuration.nameColumnFilter = '';
      options.configuration.filter =  '';
      options.configuration.filterDateTimeStart = '';
      options.configuration.filterDateTimeEnd = '';
      options.configuration.orderBy = '';

      $('#txtinputBusqueda').val('');
      $('#fechaInicio').val('');
      $('#fechaFin').val('');

      generarPaginador('No se encontraron resultados que coincidan con el filtro solicitado.');
  });


  var filter = function () {
      let config = JSON.parse(JSON.stringify($('#frmFiltroBusqueda').serializeArray()));

      options.configuration.limit = Number(config[0].value);
      options.configuration.page = 1;
      options.configuration.nameColumnFilter = Number(config[1].value);
      options.configuration.filter = $('#txtinputBusqueda').val() || '';
      options.configuration.filterDateTimeStart = config[2].value;
      options.configuration.filterDateTimeEnd = config[3].value;
      options.configuration.orderBy = config[4].value;

      generarPaginador('No se encontraron resultados que coincidan con el filtro solicitado.');
  };

  var noResultado = function(resultado){
      $("#containerAtenciones").html("");
      Notificate({
          tipo: 'info',
          titulo: 'Consulta de Atenciones',
          descripcion: resultado
      });
  };

});


/*function consultarAtenciones(data){
    $("#containerAtenciones").html('');
    if(data !=null || data !=0){
        $.each(data.datos,function(e,s){
          console.log(s);
                //$("#cont").append('<ul class="list_panel relative_element n_justify_start block"><li class="list_item n_dont_grow"><div class="list_item_header n_flex n_nowrap"><div class="item_icon n_flex n_align_center"><span class=""></span>'+s.idHistoriaClinica+'</div><div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden"><h5 class="text_bold suspensive">Prestamos por atención</h5></div></div><div class="list_item_content suspensive_4"><p class="suspensive"><span class="text_bold"> Médico : </span>'+s.primerNombre+' '+s.primerApellido+'</p></div><div class="list_item_content suspensive_4"><p class="suspensive"><span class="text_bold">Télefono Paciente : </span>'+s.telefonoFijo1+'</p> </div> <div class="list_item_content suspensive_4"><p class="suspensive"><span class="text_bold">Dirección Paciente : </span>'+s.direccion+'</p></div><div class="list_item_footer n_flex n_justify_between horizontal_padding"><div class="footer_element"><span><i class="fa fa-calendar"></i>&nbsp&nbsp'+s.fechaAtencion+'</span></div><div class="footer_element n_flex">');

        });
    }
}*/

function consultarAtenciones(data){
  console.log(data);
  let html="";
    $("#containerAtenciones").html('');
    if(data !=null || data !=0){
      var cont=1;
        $.each(data.datos,function(e,s){
          html+='<ul class="list_panel relative_element n_justify_start block"><li class="list_item n_dont_grow"><div class="list_item_header n_flex n_nowrap"><div class="item_icon n_flex n_align_center"><span class=""></span>'+cont+'</div><div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden"><h5 class="text_bold suspensive">Prestamos por Atención</h5></div></div><div class="list_item_content suspensive_4"><p class="suspensive"><span class="text_bold"> Paciente : </span>'+s.primerNombre+' '+s.segundoNombre+'</p></div><div class="list_item_content suspensive_4"><p class="suspensive"><span class="text_bold"> Número de documento : </span>'+s.numeroDocumento+'</p></div><div class="list_item_content suspensive_4"><p class="suspensive"><span class="text_bold">Télefono Paciente : </span>'+s.telefonoFijo+'</p> </div> <div class="list_item_content suspensive_4"><p class="suspensive"><span class="text_bold">Dirección Paciente : </span>'+s.direccion+'</p></div><div class="list_item_footer n_flex n_justify_between horizontal_padding"><div class="footer_element"><span><i class="fa fa-calendar"></i>&nbsp&nbsp'+s.fechaHoraAsignacion+'</span></div><div class="footer_element n_flex">'+
                                           '<div class="tooltip separate_right"><button class="btn btn-cancelar" onclick="generarReporte('+"'"+btoa(s.idHistoriaClinica)+"'"+')"><i class="fa fa-download"></i></button><span class="tooltiptext">Descargar</span></div><div class="footer_element n_flex"><div class="tooltip separate_right"><button class="btn btn-consultar"onclick="mostrarAtencion('+"'"+btoa(s.idHistoriaClinica)+"'"+',this)"><i class="fa fa-eye "></i></button><span class="tooltiptext" style="width:80px">Ver</span></div></div></div></li></ul>';

              console.log(s);


       cont++;

        });
          $("#cont").html(html);
    }
}
