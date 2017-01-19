
// CONTEXTO MENÚ:

var Modulo = $("li.modulo");
var MenuDesplegableMaestras = $("ul.ul-contenedor-submodulos");
var ContenedorMaestrasDelModulo = "ul.submenu-modulo";
var Fuera = $('html');
var MenuDesplegableLleno = false;

$(document).ready(function() {

  // Evento click sobre un módulo:
  Modulo.click(function(e) {
    e.stopPropagation();
    var ModuloActual = $(this);
    var NombreModuloActual = ModuloActual.attr('modulo');
    var MaestrasDelModulo = $(ModuloActual.children(ContenedorMaestrasDelModulo)).html();

    // Capturar las maestras del módulo actual y mostrarlas:
    if (!MenuDesplegableLleno) {
      // Evitar que el contenedor se cierre cuando se presione click sobre él:
      MenuDesplegableMaestras.click(function(e) {e.stopPropagation()})
      .attr('modulo', NombreModuloActual)    // Identificar el nombre del módulo que ha sido presionado
      .append(MaestrasDelModulo);            // Agregar las maestras del módulo que ha sido presionado
      MenuDesplegableLleno = true;
      AbrirMenuDesplegable();
    }
  });

  // Cerrar el submenú al presionar click fuera de él:
  Fuera.click(function() {
    CerrarMenuDesplegable();
  });

});

// Función para cerrar el menu desplegable:
function CerrarMenuDesplegable() {
  MenuDesplegableMaestras.animate({
    'left': '-340px'
  }, 300, function() {
    // Limpiar contenido del submenú:
    MenuDesplegableMaestras.html('');
    MenuDesplegableLleno = false;
  });
}

// Función para mostrar el menu desplegable
function AbrirMenuDesplegable() {
  MenuDesplegableMaestras.animate({
    'left': '0px'
  }, 300, function() {
    HabilitarContextoDataTable();
  });
}




// CONTEXTO DATATABLE

var ColumnasBD;
var ColumnasTabla;
var TablaBD;
var PrimaryKeyBD;
var URL_AJAX;
var URL_REGISTRAR;
var URL_MODIFICAR;
var URL_CAMBIAR_ESTADO;
var ContenedorFormatoTabla = $('.formato-tabla');
var ContenedorTabla = $('#contenedor-tabla-maestra');

// Eventos:
function HabilitarContextoDataTable() {
  var EnlaceTablaMaestra = $('ul.ul-contenedor-submodulos li.tabla-maestra');
  var PrimerClick = true;

  // Botones de formulario:
  var BtnFormRegistro = $('#btn-form-registro');
  var BtnCancelarFormulario = $('.sa-button-container .cancel');
  var BtnEnviarFormulario = $('.sa-button-container .confirm');

  // Al presionar click en un enlace a tabla maestra:
  EnlaceTablaMaestra.click(function() {
    var EnlaceActual = $(this);
    // Cerrar la ventana de inicio la primera vez:
    if (PrimerClick) CerrarVentanaIncio();

    // Armar URL del controlador de la tabla:
    //ColumnasBD = ObtenerColumnasbd(EnlaceActual);
    ColumnasTabla = ObtenerColumnasTabla(EnlaceActual);
    TablaBD = ObtenerTablaBD(EnlaceActual);
    //PrimaryKeyBD = ObtenerPrimaryKeyBD(EnlaceActual);
    Controlador = ObtenerNombreControlador(EnlaceActual);
    Modulo = ObtenerNombreModulo();

    URL_AJAX = url + 'Maestras/ctrlMaestras/ConsultarTabla/'+TablaBD;
    URL_REGISTRAR = url + Modulo + '/' + Controlador + '/Registrar/';
    URL_MODIFICAR = url + Modulo + '/' + Controlador + '/Modificar/';
    URL_CAMBIAR_ESTADO = url + Modulo + '/' + Controlador + '/' + '/CambiarEstado/';
    $('#nombre-modulo').text(Modulo);
    $('#nombre-tabla').text($(this).children('span').text());

    // Preparar DataTable por cada maestra que se consulta:
    ContenedorTabla.children().remove();
    var HeadTable ="";
    var FootTable ="";

    //Header de la tabla
    for(var i = 0; i < ColumnasTabla.length; i++){
      HeadTable += '<th>'+ColumnasTabla[i]+'</th>';
    }
    HeadTable += '<th>Estado</th><th>Editar</th><th><i class="fa fa-lock"></i>/<i class="fa fa-unlock"></i></th>';

    //Footer de la tabla
    for(var i = 0; i < ColumnasTabla.length; i++){
      FootTable += '<th>'+ColumnasTabla[i]+'</th>';
    }
    FootTable += '<th>Estado</th>';

    //Se añade el head y foot a la tabla
    $("#headTable").html(HeadTable);
    $("#footTable").html(FootTable);

    ContenedorTabla.html(ContenedorFormatoTabla.html());

    // Realizar la consulta de la tabla vía ajax:
    ConsultaDataTable(URL_AJAX, function() {
      MostrarTablaMaestra();
      CerrarMenuDesplegable();
    });
  });

  // Abrir formulario de nuevo registro:
  BtnFormRegistro.click(function() {
    MostrarFormulario('Nuevo Registro', URL_REGISTRAR);
  });

  BtnCancelarFormulario.click(function() {
    CancelarEnvioFormulario();
  });
}

function CerrarVentanaIncio() {
  $('.informacion-inicial').css({'display':'none'});
  PrimerClick = false;
}

function ReiniciarDatatable() {
  ContenedorTabla.children().remove();
  ContenedorTabla.html(ContenedorFormatoTabla.html());
}
