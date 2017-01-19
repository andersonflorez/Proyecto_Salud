$(document).ready(function(){
  $(".select").select2({
  });
  listarComboTipoDocumento();
  listarComboTipoAfiliacion();
  listarComboEstadoP();

  $("#txtDocumento").blur(function(){
    ConsultaPacienteD();
  });
  $("#btnLimpiarCampos").click(function(){
    LimpiarCampos();
  });
  $("#txtFechanacimiento").datepicker({
    language: 'es',
    maxDate: new Date()
  });

  $("#txtFechanacimiento").blur(function (){
    $.ajax({
      type:'POST',
      dataType: 'JSON',
      url:url+'Pacientes/CtrlRegistroPaciente/FechaServidor'
    }).done(function(data){
      var valorFecha = $("#txtFechanacimiento").val();
      var fecha = new Date(valorFecha);
      var fechaActual = new Date(data);
      if (fecha.getYear() > fechaActual.getYear()) {
        Notificate({
          tipo: 'warning',
          titulo: 'Cuidado con la fecha',
          descripcion: 'No debe seleccionar una fecha menor a la fecha actual.',
          duracion: 4
        });
        $("#txtFechanacimiento").val("").focus();
      }else if (fecha.getYear() == fechaActual.getYear() && fecha.getMonth() > fechaActual.getMonth()) {
        Notificate({
          tipo: 'warning',
          titulo: 'Cuidado con la fecha',
          descripcion: 'No debe seleccionar una fecha menor a la fecha actual.',
          duracion: 4
        });
        $("#txtFechanacimiento").val("").focus();
      }else if(fecha.getYear() == fechaActual.getYear() && fecha.getMonth() == fechaActual.getMonth() && fecha.getDate() >  fechaActual.getDate()){
        Notificate({
          tipo: 'warning',
          titulo: 'Cuidado con la fecha',
          descripcion: 'No debe seleccionar una fecha menor a la fecha actual.',
          duracion: 4
        });
        $("#txtFechanacimiento").val("").focus();
      }
    });
  });
});

//funcion para traer el estado del paciente, desde la bd
function listarComboEstadoP(){
  $.ajax({
    type:'POST',
    dataType:'JSON',
    url:url+'Pacientes/CtrlRegistroPaciente/ListarComboEstadoP',
    data:{"":""}
  }).done(function(e){
    $.each(e,function(i,v){
      $('#SlcEstado').append('<option value="'+v.idEstadoPaciente+'">'+v.estadoTabla+'</option>');
    })
  }).fail(function(){
    console.log("");
  })
}

//funcion pa cargar lops datos desde base de datos
function listarComboTipoDocumento(){
  $.ajax({
    type:'POST',
    dataType: 'JSON',
    url:url+'Pacientes/CtrlRegistroPaciente/ListarComboTipoDocumento',
    data:{"":""}
  }).done(function(e){
    $.each(e,function(i,v){
      $('#SlcTipoDocumento').append('<option value="'+v.idTipoDocumento+'">'+v.descripcionTdocumento+'</option>');
    })
  }).fail(function(){
    console.log("");
  })
}
//funcion pa cargar lops datos desde base de datos
function listarComboTipoAfiliacion(){
  $.ajax({
    type:'POST',
    dataType: 'JSON',
    url:url+'Pacientes/CtrlRegistroPaciente/ListarComboTipoAfiliacion',
    data:{"":""}
  }).done(function(x){
    $.each(x,function(z,y){
      $('#SlcTipoAfiliacion').append('<option value="'+y.idTipoAfiliacion+'">'+y.descripcionAfiliacion+'</option>');
    })
  }).fail(function(){
    console.log("");
  })

}

function LimpiarCampos(){
  $("#txtid").val("");
  $("#txtDocumento").val("");
  $("#txtFechanacimiento").val("");
  $("#SlcTipoSangre").val("");
  $("#txtPrimerNombre").val("");
  $("#txtSegundoNombre").val("");
  $("#txtPrimerNombre").val("");
  $("#txtPrimerApellido").val("");
  $("#txtSegundoApellido").val("");
  $("#SlcGenero").val("");
  $("#SlcEstadoCivil").val("");
  $("#TxtCiudadR").val("");
  $("#txtBarrioR").val("");
  $("#txtDireccion").val("");
  $("#txtExt").val("");
  $("#txtTelefonoFijo").val("");
  $("#txtTelefonoCelular").val("");
  $("#txtCorreo").val("");
  $("#txtEmpresa").val("");
  $("#txtOcupacion").val("");
  $("#txtProfesion").val("");
  $("#SlcTipoDocumento").val("");
  $("#SlcTipoAfiliacion").val("");
  $("#txtUrl").val("");
  $("#txtfile").val("");
  $("#txtidEstado").val("");
  $('#btnResgistrarPaciente').show();
  $('#btnLimpiarCampos').hide();
  $('#btnCancelarP').show();
  EditarDatosPaciente();
}
//valida que el usuario- con consulta
function ConsultaPacienteD(){
  var numero=$("#txtDocumento").val();
  $.ajax({
    type:'POST',
    dataType : 'JSON',
    url:url+'Pacientes/CtrlRegistroPaciente/ConsultarPacienteD',
    data : {'txtDocumento' :numero},
  }).done(function(data){

    if (data=='1') {
    }else{
      Notificate({
        tipo: 'warning',
        titulo: 'Notificación de error',
        descripcion: 'El Paciente se encuentra registrado en el sistema.',
        duracion: 6

      });
      $.each (data, function(indice, valor){
        desactivarCampos();
        var  idPaciente = valor.idPaciente;
        $("#txtid").val(idPaciente).attr("disabled", true);
        var documento = valor.numeroDocumento;
        $("#txtDocumento").val(documento).attr("disabled", true);
        var fechaNacimiento = valor.fechaNacimiento;
        $("#txtFechanacimiento").val(fechaNacimiento).attr("disabled", true);
        var tipoSangre = valor.tipoSangre;
        $("#SlcTipoSangre").val(tipoSangre).attr("disabled", true);
        var PrimerNombre = valor.primerNombre;
        $("#txtPrimerNombre").val(PrimerNombre).attr("disabled", true);
        var SegundoNombre = valor.segundoNombre;
        $("#txtSegundoNombre").val(SegundoNombre).attr("disabled", true);
        var primerApellido = valor.primerApellido;
        $("#txtPrimerApellido").val(primerApellido).attr("disabled", true);
        var segundoApellido = valor.segundoApellido;
        $("#txtSegundoApellido").val(segundoApellido).attr("disabled", true);
        var Genero = valor.genero;
        $("#SlcGenero").val(Genero).attr("disabled", true);
        var estadoCivil = valor.estadoCivil;
        $("#SlcEstadoCivil").val(estadoCivil).attr("disabled", true);
        var ciudadResidencia = valor.	ciudadResidencia;
        $("#TxtCiudadR").val(	ciudadResidencia).attr("disabled", true);
        var barrioResidencia = valor.barrioResidencia;
        $("#txtBarrioR").val(barrioResidencia).attr("disabled", true);
        var direccion = valor.direccion;
        $("#txtDireccion").val(direccion).attr("disabled", true);
        var telefonoFijo  = valor.telefonoFijo;
        var InfoTelefono =  telefonoFijo.split("-");
        $("#txtTelefonoFijo").val(InfoTelefono[0]).attr("disabled", true);
        $("#txtExt").val(InfoTelefono[1]).attr("readonly", true);
        var telefonoMovil = valor.telefonoMovil;
        $("#txtTelefonoCelular").val(telefonoMovil).attr("disabled", true);
        var correoElectronico = valor.correoElectronico;
        $("#txtCorreo").val(correoElectronico).attr("disabled", true);
        var empresa = valor.empresa;
        $("#txtEmpresa").val(empresa).attr("disabled", true);
        var ocupacion = valor.ocupacion;
        $("#txtOcupacion").val(ocupacion).attr("disabled", true);
        var	profesion = valor.	profesion;
        $("#txtProfesion").val(profesion).attr("disabled", true);
        var fechaAfiliacionRegistro = valor.fechaAfiliacionRegistro;
        $("#txtFechaAfili").val(fechaAfiliacionRegistro).attr("disabled", true);
        var idtipoDocumento = valor.idtipoDocumento;
        $("#SlcTipoDocumento").val(idtipoDocumento).attr("disabled", true);
        var idtipoAfiliacion = valor.idtipoAfiliacion;
        $("#SlcTipoAfiliacion").val(idtipoAfiliacion).attr("disabled", true);
        var edadPaciente = valor.edadPaciente;
        $("#txtEdad").val(edadPaciente).attr("disabled", true);
        var url = valor.url;
        //$("#txtUrl").val(url).attr("readonly", true);
        var idEstadoPaciente = valor.url;
        $("#txtidEstado").val(idEstadoPaciente).attr("disabled", true);
        $('#btnResgistrarPaciente').hide();
        $('#btnLimpiarCampos').show();
        $('#btnCancelarP').hide();
      });
    }
  }).fail(function(err){
    console.log("error");
  })
}

ValidateForm('FormularioPaciente', function(formdata) {
  //  let a=  document.getElementById("txtUrl").value;
  //  alert(a);
  console.log(new FormData($('#FormularioPaciente')[0]));
  $.ajax({
    type:'POST',
    dataType: 'json',
    url: url + "Pacientes/CtrlRegistroPaciente/RegistrarPaciente",
    data: new FormData($('#FormularioPaciente')[0]),
    contentType: false,
    processData: false
  }).done(function(a){
    LimpiarCampos();
    Notificate({
      tipo: 'success',
      titulo: '',
      descripcion: 'Registrado Exitoso.'
    });

  }).fail(function(a){
    console.log(a, 'error ajax registrar paciente');
  })

});


/*para que los campos aparescan pa editar*/
EditarDatosPaciente = function () {
  $('input[disabled').css({
    color:'#000',
    background:'#fff'
  })
  $('input[type="text"]').prop( "disabled", false );
  $('input[type="email"]').prop( "disabled", false );
  $('input[type="date"]').prop( "disabled", false );
  $('input[type="datetime"]').prop( "disabled", false );
  $('input[type="time"]').prop( "disabled", false );
  $('input[type="file"]').prop( "disabled", false );
  $('#SlcEstado').removeAttr("disabled");
  $('#SlcTipoSangre').removeAttr("disabled");
  $('#SlcGenero').removeAttr("disabled");
  $('#SlcEstadoCivil').removeAttr("disabled");
  $('#SlcTipoDocumento').removeAttr("disabled");
  $('#SlcTipoAfiliacion').removeAttr("disabled");
  $('#btnGuardarDatos').show();
  $('#btnCancelar').show();
  $('#btnActualizarPaciente').hide();
}


function desactivarCampos(){

  $('input[type="text"]').prop( "disabled", true );
  $('input[type="email"]').prop( "disabled", true );
  $('input[type="date"]').prop( "disabled", true );
  $('input[type="datetime"]').prop( "disabled", true );
  $('input[type="time"]').prop( "disabled", true );
  $('input[type="file"]').prop( "disabled", true );
  cambiar();
}

function cambiar() {
  $('input[disabled], selec').css({
    color:'#666',
    background:'#fff'
  })
  $(".frmInput").hover(function(){
    $(this).css("border", "1px solid rgba(34, 43, 47, 0.13)");
  }, function(){

  });
}
/*
|-----------------------------------------------|
|Función agregar extensión a los teléfonos
|_______________________________________________|
*/
let bandera=false;
$("#Ext").click(function(dato){
  var info=dato.target.parentNode;
  var selectedInput=$(info).children("div.aggInput");
  var input=$(info).children("div.aggInput").children("input").attr("id");
  var spansel=$(info).children("span.aggExt");
  //agrega el input tamaño
  $(selectedInput).toggle(200);
  $(selectedInput).css({'display': 'flex'});
  if (bandera==false) {
    $(spansel).removeClass("fa-plus");
    $(spansel).addClass("fa-times");
    $(".fa-times").css({"color":"rgba(229,74,101,0.9)"});
    bandera=true;
  }else{
    $("#"+input).val("");
    $(spansel).removeClass("fa-times");
    $(spansel).addClass("fa-plus");
    $(".fa-plus").css({"color":"#2ecc71"});
    bandera=false;
  }
});

$('input.quantity_maximun_input ').keypress(function(del) {
  if (del.charCode != 127) {
    /*cantidad máxima de caracteres que quieres que se digiten*/
    if ($(this).val().length>=5) {
      del.preventDefault();
    }
  }
});
