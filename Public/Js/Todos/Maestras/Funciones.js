// FUNCIONES Y PROCEDIMIENTOS:

// Función para realizar una consulta ajax a un controlador en específico:
function ConsultaDataTable(URL_AJAX, Callback) {
  // Capturar id de la tabla:
  Tabla = '#contenedor-tabla-maestra table';

  // Configuración de las funciones de modificar e inhabilitar:
  config = {
    "functionUpdate": ModificarFila,
    "functionDisable": CambiarEstado
  };

  // DataTable y consulta ajax:
  $(Tabla).DataTable({
    "iDisplayLength": 5,
    "ordering": false,
    "processing": true,
    "serverSide": true,
    "ajax": URL_AJAX,
    "language": opcion
  });

  // Convertir 'th' en input:
  $(Tabla + ' tfoot th').each(function () {
    var title = $(this).text();
    $(this).html('<input type="text" class="form-control" placeholder="Filtro" />');
  });

  // Filtrar por campo en tiempo real:
  $(Tabla).DataTable().columns().every(function () {
    var that = this;

    $('input', this.footer()).on('keyup change', function() {
      if (that.search() !== this.value) {
        that.search(this.value).draw();
      }
    });
  });

  // Ejecutar callback:
  Callback();
}

// Mostrar tabla maestra:
function MostrarTablaMaestra() {
  $('.contenido-maestra').css({'display':'flex'});
}

// Función que se encarga de modificar un registro:
function ModificarFila(data) {
  MostrarFormulario('Modificar Registro', URL_MODIFICAR, data);
}

// Función que se encarga de cambiar el estado de un registro:
function CambiarEstado(id, estado, idbtn) {
  $.ajax({
    url: URL_CAMBIAR_ESTADO,
    type: 'POST',
    data: {'id':id, 'estado':estado}
  }).done(function(data) {
    var Estado;
    var btn = $('#'+idbtn);
    var row = btn.parent().parent();
    var colEstado = row.find('td:nth-last-child(3)');
    if (data == "1") {
      if (estado == 'Activo') {
        Estado = 'Inactivo';
        btn.removeClass();
        btn.addClass('btn btn-habilitar');
        btn.children('span').removeClass();
        btn.children('span').addClass('fa fa-unlock');
        colEstado.text(Estado);
      } else {
        Estado = 'Activo';
        btn.removeClass();
        btn.addClass('btn btn-eliminar');
        btn.children('span').removeClass();
        btn.children('span').addClass('fa fa-lock');
        colEstado.text(Estado);
      }

      btn.attr("onclick","cambiarEstado('"+id+"','"+Estado+"', '"+idbtn+"')");
    } else {
      console.log('Ha ocurrido un error al intentar realizar la operación');
    }

  }).fail(function(err) {
    console.log(err);
  });
}

// Función para abrir el formulario SweetAlert:
function MostrarFormulario(Titulo, URL, Datos) {
  var SweetAlert = $('.sweet-alert');
  var Overlay = $('.sweet-overlay');

  // Limpiar zona de inputs:
  var FieldSet = SweetAlert.children('fieldset');
  FieldSet.html('');

  // Agregar inputs según número de columnas:
  var html;
  if (Datos) {
    FieldSet.append("<input columnaDB='PrimaryKey' class='input-maestra' type='hidden' value='"+Datos[0]+"'>");
    for($i=1; $i < ColumnasTabla.length; $i++){
        html = "<label>"+ColumnasTabla[$i]+"</label><input class='input-maestra' value='"+Datos[$i]+"' type='text' tabindex='3' placeholder='"+ColumnasTabla[$i]+"'>";
        FieldSet.append(html);
    }
  } else {
    for($i=0; $i < ColumnasTabla.length; $i++){
      if(ColumnasTabla[$i].toLowerCase().indexOf('id') != 0){
        html = "<label>"+ColumnasTabla[$i]+"</label><input class='input-maestra' type='text' tabindex='3' placeholder='"+ColumnasTabla[$i]+"'>";
        FieldSet.append(html);
      }
    }
  }


  FieldSet.children('.input-maestra').keyup(function(e) {
    ValidarCampoTeclaEnter(e);
  });

  // Nombrar el formulario:
  SweetAlert.children('h2').text(Titulo);

  if (Titulo == "Modificar Registro") {
    $("#btn-confirmar").text('Modificar');
  } else {
    $("#btn-confirmar").text('Registrar');
  }

  // Poner URL de confirmación de formulario:
  $('#btn-confirmar').attr('url', URL);

  // Mostrar el formulario:
  Overlay.css({
    "opacity": "1.21",
    "display": "block"
  });

  SweetAlert.css({
    "display": "block"
  });

}

// Cancelar formulario de registro/modificación:
function CancelarEnvioFormulario() {
  MostrarMensajeValidacion(false);
  $('.sweet-overlay').css({
    "display": "none"
  });
  $('.sweet-alert').fadeOut(200);
}

// Función para validar los campos del formulario:
function ValidarCamposVacios() {
  Error = false;
  $('.input-maestra').each(function() {
    if (!$(this).val()) Error = true;
  });
  return Error;
}

// Validar campos del input al presionar ENTER:
function ValidarCampoTeclaEnter(e){
  var keycode = (e.keyCode ? e.keyCode : e.which);
  MostrarMensajeValidacion(false);
  if(keycode == '13'){
    ConfirmarEnvioFormulario();
  }
};

// Mostrar/Ocultar error de campos vacíos:
function MostrarMensajeValidacion(bool, icon, mensaje, color, callback) {
  var ContenedorMsjValidacion = $('.sa-error-container');
  if (bool) {
    if (color) ContenedorMsjValidacion.children('div').css({"background-color": color});
    ContenedorMsjValidacion.children('div').children('i').addClass('fa fa-' + icon);
    ContenedorMsjValidacion.children('p').text(mensaje);
    ContenedorMsjValidacion.addClass('show');
  } else {
    if (ContenedorMsjValidacion.hasClass('show')) {
      ContenedorMsjValidacion.removeClass('show');
      ContenedorMsjValidacion.children('div').css({"background-color": ''});
      ContenedorMsjValidacion.children('div').children('i').removeClass();
      ContenedorMsjValidacion.children('p').text('');
    }
  }
  if (callback) callback();
}

// Función para confirmar el envío de un formulario hacia un controlador:
function ConfirmarEnvioFormulario() {
  if (!ValidarCamposVacios()) {
    var URL_FORMULARIO = $('.sa-button-container .confirm').attr('url');
    var Valores = RecolectarValores();
    $.ajax({
      type: 'POST',
      url: URL_FORMULARIO,
      data:{Valores:JSON.stringify(Valores)}
    }).done(function(data){
      if (data == "1") {
        MostrarMensajeValidacion(true, 'check', 'Operación realizada satisfactoriamente!', '#09C517', function() {
          console.log($("#btn-confirmar").text());
          if ($("#btn-confirmar").text() == "Modificar") {
            CancelarEnvioFormulario();
          }
        });
        LimpiarCampos();
      } else {
        MostrarMensajeValidacion(true, 'exclamation', 'Ha ocurrido un error en la operación', '#B70000');
      }

      ReiniciarDatatable();

      ConsultaDataTable(URL_AJAX, function() {
        MostrarTablaMaestra();
        CerrarMenuDesplegable();
      });

    }).fail(function(){
      MostrarMensajeValidacion(true, 'exclamation', 'Ha ocurrido un error en la operación', '#B70000');
    });
  } else {
    MostrarMensajeValidacion(true, 'exclamation', 'Debe completar los campos');
  }
}

// Validar campos de formulario:
function RecolectarValores() {
  var Datos = [];
  var Clave, Valor;
  $('.input-maestra').each(function() {
    Valor = $(this).val();
    Datos.push(Valor);
  });
  return Datos;
}

// Función para limpiar los campos del formulario:
function LimpiarCampos() {
  $('.input-maestra').each(function() {
    Valor = $(this).val('');
  });
}

// Función para identificar el módulo al que pertenece un controlador:
function ObtenerNombreModulo() {
  return $('ul.ul-contenedor-submodulos').attr('modulo');
}

// Funciones para obtener valores:
function ObtenerNombreControlador(Maestra) {
  return $(Maestra).attr('controlador');
}

function ObtenerColumnasbd(Maestra) {
  return $(Maestra).attr('columnasBD').split("-");
}

function ObtenerColumnasTabla(Maestra) {
  return $(Maestra).attr('columnasTabla').split("-");
}

function ObtenerTablaBD(Maestra) {
  return $(Maestra).attr('tablaBD');
}

function ObtenerPrimaryKeyBD(Maestra) {
  return $(Maestra).attr('primaryKeyBD');
}
