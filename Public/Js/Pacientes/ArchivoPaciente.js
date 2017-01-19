$(document).ready(function(){
  $(".select").select2({
  });
  listarComboTipoDocumento();
  listarComboTipoAfiliacion();
  consultarModificar();
  listarComboEstadoP();
  paci();
  $("#txtFechanacimiento").datepicker({
    language: 'es',
    maxDate: new Date()
  });
     $("#txtFechaAfili").datepicker({
       language: 'es',
       maxDate: new Date()
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
      $('#SlcEstado').append('<option value="'+v.idEstadoPaciente+'">'+v.descripcionEstadoPaciente+'</option>');
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

/*para que los campos aparescan pa editar*/
EditarDatosPaciente = function () {
  $('input[disabled').css({
    color:'#000',
    background:'#fff'
  })
  $('input[type="text"]').prop( "disabled", false );
  $('input[type="email"]').prop( "disabled", false );
  $('input[type="date"]').prop( "disabled" );
  $('input[type="datetime"]').prop( "disabled", false );
  $('input[type="time"]').prop( "disabled", false );
  $('input[type="file"]').prop( "disabled", false );
  $('#SlcEstado').attr("disabled");
  $('#SlcTipoSangre').attr("disabled");
  $('#SlcGenero').attr("disabled");
  $('#SlcEstadoCivil').removeAttr("disabled");
  $('#SlcTipoDocumento').removeAttr("disabled");
  $('#SlcTipoAfiliacion').removeAttr("disabled");
  $('#btnGuardarDatos').show();
  $('#btnCancelar').show();
  $('#btnActualizarPaciente').hide();
  $('#btnestado').hide();

}


/*Actualizacion datos*/


ValidateForm('FormularioConsultaPaciente', function(formdata) {
  $.ajax({
    type: 'POST',
    url: url + "Pacientes/CtrlConsultaPaciente/ActualizarDatosPaciente",
    data: new FormData($("#FormularioConsultaPaciente")[0]),
    contentType: false,
    processData: false
  }).done(function () {
    Notificate({
      tipo: 'success',
      titulo: '',
      descripcion: 'Datos Modificados'
    });
  }).fail(function () {
  })
});

//Función de modo consulta
function consultarModificar(){
  $('#btnActualizarPaciente').click(function(){
    EditarDatosPaciente();
  });

  $('#btnGuardarDatos').click(function(){
    var form=$("#FormularioConsultaPaciente");
    var valor=form.valid();
    if (valor==true) {
    }else{
      Notificate({
        tipo: 'error',
        titulo: 'Error',
        descripcion: 'Verifica que toda información esté correcta.'
      });
    }
  });
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



function paci(){
  let idpac=localStorage.getItem("idP");
  $.ajax({
    type:'POST',
    dataType : 'JSON',
    url:url+'Pacientes/CtrlConsultaPaciente/ConsultarPaciente',
    data:{data:idpac}
  }).done(function(data){
    desactivarCampos();
    $("#txtid").val(idpac).attr("readonly", true);
    var doc=data.numeroDocumento;
    $("#txtDocumento").val(doc).attr("readonly", false);
    var fechaNacimiento =data.fechaNacimiento;
    $("#txtFechanacimiento").val(fechaNacimiento).attr("readonly", true);
    var tipoSangre = data.tipoSangre;
    $("#SlcTipoSangre").val(tipoSangre).attr("readonly", true);
    var PrimerNombre = data.primerNombre;
    $("#txtPrimerNombre").val(PrimerNombre).attr("readonly", false);
    var SegundoNombre = data.segundoNombre;
    $("#txtSegundoNombre").val(SegundoNombre).attr("readonly", false);
    var primerApellido = data.primerApellido;
    $("#txtPrimerApellido").val(primerApellido).attr("readonly", false);
    var segundoApellido = data.segundoApellido;
    $("#txtSegundoApellido").val(segundoApellido).attr("readonly", false);
    var Genero = data.genero;
    $("#SlcGenero").val(Genero).attr("disabled", true);
    var estadoCivil = data.estadoCivil;
    $("#SlcEstadoCivil").val(estadoCivil).attr("readonly", false);
    var ciudadResidencia = data.	ciudadResidencia;
    $("#TxtCiudadR").val(ciudadResidencia).attr("readonly", false);
    var barrioResidencia = data.barrioResidencia;
    $("#txtBarrioR").val(barrioResidencia).attr("readonly", false);
    var direccion = data.direccion;
    $("#txtDireccion").val(direccion).attr("readonly", false);
    var telefonoFijo  = data.telefonoFijo;
    var InfoTelefono =  telefonoFijo.split("-");
    $("#txtTelefonoFijo").val(InfoTelefono[0]).attr("readonly", false);
    $("#txtExt2").val(InfoTelefono[1]).attr("readonly", false);
    var telefonoMovil = data.telefonoMovil;
    $("#txtTelefonoCelular").val(telefonoMovil).attr("readonly", false);
    var correoElectronico = data.correoElectronico;
    $("#txtCorreo").val(correoElectronico).attr("readonly", false);
    var empresa = data.empresa;
    $("#txtEmpresa").val(empresa).attr("readonly", false);
    var ocupacion = data.ocupacion;
    $("#txtOcupacion").val(ocupacion).attr("readonly", false);
    var	profesion = data.	profesion;
    $("#txtProfesion").val(profesion).attr("readonly", false);
    var fechaAfiliacionRegistro = data.fechaAfiliacionRegistro;
    $("#txtFechaAfili").val(fechaAfiliacionRegistro).attr("readonly", true);
    var idtipoDocumento = data.idtipoDocumento;
    $("#SlcTipoDocumento").val(idtipoDocumento).attr("readonly", false);
    var idtipoAfiliacion = data.idtipoAfiliacion;
    $("#SlcTipoAfiliacion").val(idtipoAfiliacion).attr("readonly", true);
    var edadPaciente = data.edadPaciente;
    $("#txtEdad").val(edadPaciente).attr("readonly", true);
    var idEstadoPaciente = data.idEstadoPaciente;
    $("#SlcEstado").val(idEstadoPaciente).attr("disabled", true);
    // var img = document.getElementById("imagenPaciente");
    // img.src = "../"+data.url;
    var url2 = data.url;
    //console.log("../.."+ data.url.substring(7,data.url.length) +"");
    // $('.imgPaciente').css("background-image", "url('../.."+ data.url.substring(7,data.url.length) +"')");
    $('.imgPaciente').css("background-image", "url('"+ url + data.url +"')");
    //$("#txtUrl").val(url);
    $("#txtVieja").val(url2);
    //console.log(edadPaciente);

  }).fail(function(err){
    console.log(error);
  });
}

/*
|-----------------------------------------------|
|Función agregar extensión a los teléfonos
|_______________________________________________|
*/
let bandera=false;
$("#Ext2").click(function(dato){
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
