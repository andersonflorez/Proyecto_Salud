$(document).ready(function(){
  ListarTipoDocumento();
  ConsultarPaciente();
  consultarAcompananteDoc();
  $('#btnGuardarDatos').hide(); //Botón que guarda los cambios cuando se modifica. se esconde al inicio del recargo de la página.
  $('#btnLimpiar').click(function(){ //Botón para limpiar los campos cuando datos ene stos.
    LimpiarCampos();
  });
  // Preguntar al servidor en que modo de trabajo estamos(ModoConsulta - ModoRegistro)
  whichWorkMode.then(function (esModoConsulta) {
    if (esModoConsulta) soloConsulta();
    else registrar();
  }, function (err) {
    alert('No se pudó obtener el modo de trabajo.');
  });



  var myDatepicker = $('#fechaNacimi').datepicker().data('datepicker');

  $("#fechaNacimi").datepicker({
    language: 'es',
    maxDate: new Date()
    // position:"bottom left",
    // onSelect:function(formattedDate){
    //   myDatepicker.hide();
    // }
  });


});

$("#fechaNacimi").blur(function (){
       $.ajax({
         type:'POST',
         dataType: 'JSON',
         url:url+'ReporteAPH/ctrlTipoEvento/FechaServidorCitas'
       }).done(function(data){
         var valorFecha = $("#fechaNacimi").val();
         var fecha = new Date(valorFecha);
         var fechaActual = new Date(data);
         if (fecha.getYear() > fechaActual.getYear()) {
           Notificate({
             tipo: 'warning',
             titulo: 'Cuidado con la fecha',
             descripcion: 'No debe seleccionar una fecha menor a la fecha actual.',
             duracion: 4
           });
           $("#fechaNacimi").val("").focus();
         }else if (fecha.getYear() == fechaActual.getYear() && fecha.getMonth() > fechaActual.getMonth()) {
           Notificate({
             tipo: 'warning',
             titulo: 'Advertencia.',
             descripcion: 'No debe seleccionar una fecha mayor a la fecha actual.',
             duracion: 4
           });
           $("#fechaNacimi").val("").focus();
         }else if(fecha.getYear() == fechaActual.getYear() && fecha.getMonth() == fechaActual.getMonth() && fecha.getDate() >  fechaActual.getDate()){
           Notificate({
             tipo: 'warning',
             titulo: 'Advertencia.',
             descripcion: 'No debe seleccionar una fecha mayor a la fecha actual.',
             duracion: 4
           });
           $("#fechaNacimi").val("").focus();
         }
       });
     });



$('#btnRegistrarPaciente').click(function(){
  var registrarP = $(this).attr("submit-form");
  $('#'+registrarP).submit();
});


$('#btnAgregarAcompanante').click(function(){
  var registrarA = $(this).attr("submit-form");
  $('#'+registrarA).submit();
});

$('#btnGuardarDatos').click(function(){
  $(this).attr("guardar","guardar");
  var modi = $(this).attr("submit-form");
  $('#'+modi).submit();
})

$('#btnModificarAcompanante').click(function(){
  $(this).attr("guardarA", "guardarA");
  var modificarAcomp = $(this).attr("submit-form");
  $('#'+modificarAcomp).submit();
})

//Cerrar botones que no se necesitan al momento de registrar un paciente
function registrar(){
  $('#btnLimpiar').hide();
  $('#btnLimpiarAC').hide();
  $('#btnActualizarAcompanante').hide();
  $('#btnAgregarAcompanante').show();
  $('#btnActualizarPaciente').hide();
  $('#btnModificarAcompanante').hide();
  $("#txtNumeroDocumento").blur(function(){
    if(!$("#btnGuardarDatos").is(":visible")){
      ConsultarPaciente();
    }
  });
  $('#ideAcompanante').blur(function(){
    if (!$('#btnModificarAcompanante').is(":visible")) {
      consultarAcompananteDoc();
    }
  });
  $('#ocultarEdad').hide();
}



function LimpiarCampos(){
  $('#txtNumeroDocumento').val("").removeAttr("disabled");
  $('#primerNombrePa').val("").removeAttr("disabled");
  $('#segundoNombrePa').val("").removeAttr("disabled");
  $('#primerApellidoPa').val("").removeAttr("disabled");
  $('#segundoApellidoPa').val("").removeAttr("disabled");
   document.getElementById('opTipoDocumento').value = 0;
   document.getElementById('opTipoDocumento').style.background = '#FFFFFF';
  $('#opTipoDocumento').removeAttr("disabled");
  $('#generoPac').removeAttr("disabled");
  document.getElementById('generoPac').style.background = '#FFFFFF';
  document.getElementById('generoPac').value = 0;
  $('#fechaNacimi').val("").removeAttr("disabled");
  $('#municipioPacien').val("").removeAttr("disabled");
  $('#teleMovilPaciente').val("").removeAttr("disabled");
  $('#direccionPaciente').val("").removeAttr("disabled");
  document.getElementById('estadoCivilPaciente').style.background = '#FFFFFF';
  document.getElementById('estadoCivilPaciente').value = 0;
  $('#estadoCivilPaciente').removeAttr("disabled");
  $('#ocupacionPacie').val("").removeAttr("disabled");
  $('#btnRegistrarPaciente').show();
  $('#btnLimpiar').hide();
  $('#btnActualizarPaciente').hide();
  $('#ocultarEdad').hide();

  var objPaciente = {
    idPaciente:  '',
    documento: '',
    idAcompanante : $('#idAcompanante').val(),
    documentoAcompanante: $('#ideAcompanante').val()
  };

  localStorage.setItem('ReporteAPH-Paciente', JSON.stringify(objPaciente));
}

function LimpiarAcompanante(){
  $('#ideAcompanante').val("").removeAttr("disabled");
  $('#lugarExpedicion').val("").removeAttr("disabled");
  $('#nombreA').val("").removeAttr("disabled");
  $('#apellido').val("").removeAttr("disabled");
  $('#parentesco').val("").removeAttr("disabled");
  $('#telefono').val("").removeAttr("disabled");
  $('#btnLimpiarAC').hide();
  $('#btnActualizarAcompanante').hide();
  $('#btnAgregarAcompanante').show();
  var objPaciente = {
    idPaciente:  $('#txtIdPaciente').val(),
    documento: $('#txtNumeroDocumento').val(),
    idAcompanante : '',
    documentoAcompanante: ''
  };

  localStorage.setItem('ReporteAPH-Paciente', JSON.stringify(objPaciente));
}

$('#btnLimpiarAC').click(function(){
  LimpiarAcompanante();
})



function soloConsulta(){
  var paciente = JSON.parse( localStorage.getItem('ReporteAPH-Paciente') );
  ConsultarPaciente(paciente.documento);
  consultarAcompananteDoc(paciente.documentoAcompanante);
if ($('#txtIdPaciente').val() !== "" || $('#txtIdPaciente').val() !== null) {
    setTimeout(function(){
      $('#btnLimpiar').hide();
    }, 500)

  }


  if ($('#ideAcompanante').val() !== "" || $('#ideAcompanante').val()  !== null) {
    setTimeout(function(){
      $('#btnLimpiarAC').hide();
      $('#btnAgregarAcompanante').hide();
    }, 500)

  }

  if ($('#ideAcompanante').val() == "" || $('#ideAcompanante').val() != null) {
    setTimeout(function(){
      InhabilitarCamposAcompanante();
      $('#btnLimpiarAC').hide();
      $('#btnAgregarAcompanante').hide();
      $('#btnActualizarAcompanante').hide();
      $('#btnModificarAcompanante').hide();
    }, 500)

  }
}

//Llama al controlador que hace la consulta para traer informacion de la tabla tipo documento
var ListarTipoDocumento = function(){
  $.ajax({
    type: 'POST',
    dataType: 'json',
    url: url + "ReporteAPH/ctrlTipoEvento/ListarTipoDocumento"
  }).done(function(a){
    $.each(a, function(b,c){
      $('#opTipoDocumento').append("<option value='"+c.idTipoDocumento+"'>"+c.descripcionTdocumento+"</option>");
    });
  }).fail(function(){
    console.log("No se pudo");
  });
};

var ConsultarUltimoId = function(){
  var id = 0;
  $.ajax({
    url : url + "ReporteAPH/ctrlTipoEvento/ConsultarIdUltimoPaciente",
    async:false
  }).done(function (data){
    id = data
  }).fail(function(){
    console.log("No se pudo");
  });
  return id;
};


var consultarUltimoAcompanante = function(){
  var idA = 0;
  $.ajax({
    url : url + "ReporteAPH/ctrlTipoEvento/ConsultarUltimoAcompanante",
    async:false
  }).done(function(data){
    idA = data
  }).fail(function(){
    console.log("No");
  });
  return idA;
};
//
ValidateForm('formAcompanante', function(formdata){
  let datos=$("#btnModificarAcompanante").attr("guardarA");
  if (datos=="guardarA") {
    ActualizarAcompanante();
  }else{
    $.ajax({
      type : 'POST',
      dataTypen : 'JSON',
      url : url + "ReporteAPH/ctrlTipoEvento/RegistrarAcompanante",
      data : new FormData (document.getElementById("formAcompanante")),
      contentType : false,
      processData : false,
    }).done(function(){
      Notificate({
        tipo: 'success',
        titulo: 'Registro Exitoso',
        descripcion: 'Se ha registrado exitosamente.'
      });
      $('#btnAgregarAcompanante').hide();
      var objPaciente = {
        idPaciente:  $('#txtIdPaciente').val(),
        documento: $('#txtNumeroDocumento').val(),
        idAcompanante : consultarUltimoAcompanante(),
        documentoAcompanante: $('#ideAcompanante').val()
      };
      localStorage.setItem('ReporteAPH-Paciente', JSON.stringify(objPaciente));
      var codigoAcompañante = $('#idAcompanante').val(consultarUltimoAcompanante());
    }).fail(function(){
      Notificate({
        tipo: 'error',
        titulo: 'Error',
        descripcion: 'No se pudo registrar.'
      });
    })
  }
});

ValidateForm('formPaciente', function(formdata){
  let dato=$("#btnGuardarDatos").attr("guardar");
  if (dato=="guardar") {
    ModificarPaciente();
  }else{
    $.ajax({
      type : 'POST',
      dataTypen: 'json',
      url : url + "ReporteAPH/ctrlTipoEvento/RegistrarPaciente",
      data : new FormData (document.getElementById("formPaciente")),
      contentType: false,
      processData: false
    }).done(function(res){
      var respuesta = String(res.toLowerCase().trim());
      if(respuesta === "1"){
        Notificate({
          tipo: 'success',
          titulo: 'Registro Exitoso',
          descripcion: 'El paciente se registró exitosamente.'
        });
        $('#btnRegistrarPaciente').hide();
        var objPaciente = {
          idPaciente:  ConsultarUltimoId(),
          documento: $('#txtNumeroDocumento').val(),
          idAcompanante : $('#idAcompanante').val(),
          documentoAcompanante: $('#ideAcompanante').val()
        };

        localStorage.setItem('ReporteAPH-Paciente', JSON.stringify(objPaciente));

        var codigoPaciente = $('#txtIdPaciente').val(ConsultarUltimoId);

      }else if(respuesta === "2"){
        Notificate({
          tipo: 'error',
          titulo: 'Error',
          descripcion: 'No se pudo registrar.'
        });
      }
    }).fail(function(){
      Notificate({
        tipo: 'error',
        titulo: 'Error',
        descripcion: 'Ocurrió un error inesperado.'
      });
    });
  }
});


var ConsultarPaciente = function(){
  var numero = 0;
  if($("#txtNumeroDocumento").val() != ""){
    numero = $("#txtNumeroDocumento").val();
  }else{
    if(localStorage.getItem("ReporteAPH-Paciente") != null){
      var datos = JSON.parse(localStorage.getItem("ReporteAPH-Paciente"));
      numero = datos.documento;
    }
  }
  $.ajax({
    type: 'POST',
    dataType:'JSON',
    url: url + "ReporteAPH/ctrlTipoEvento/ConsultarPaciente",
    data : {'txtIdentificacionPaciente':numero},
  }).done(function(data){
    if (data != "1") {
      $('#ocultarEdad').show();
      $('#btnLimpiar').show();
      $('#btnRegistrarPaciente').hide();
      $('#btnActualizarPaciente').show();
      $('#btnActualizarPaciente').click(function(){
        Editar();
        $('#btnGuardarDatos').show();
      });
      colorCampos();
      $.each(data,function(indice, valor) {
        setTimeout(function(){
          var tipoDocuPa = valor.idtipoDocumento;
          $('#opTipoDocumento').val(tipoDocuPa).attr("disabled","disabled");
        }, 1000)
        var documento = valor.numeroDocumento;
        $('#txtNumeroDocumento').val(documento).attr("disabled",true);
        idPaciente = valor.idPaciente;
        $('#txtIdPaciente').val(idPaciente);
        var objPaciente = {
          idPaciente:  valor.idPaciente,
          documento: $('#txtNumeroDocumento').val(),
          idAcompanante: $('#idAcompanante').val(),
          documentoAcompanante: $('#ideAcompanante').val()
        };

        localStorage.setItem('ReporteAPH-Paciente', JSON.stringify(objPaciente));
        var FechaNac = valor.fechaNacimiento;
        $('#fechaNacimi').val(FechaNac).attr("disabled",true);
        var primerNombreP = valor.primerNombre;
        $('#primerNombrePa').val(primerNombreP).attr("disabled",true);
        var segundoNombreP = valor.segundoNombre;
        $('#segundoNombrePa').val(segundoNombreP).attr("disabled",true);
        var primerApellidoP = valor.primerApellido;
        $('#primerApellidoPa').val(primerApellidoP).attr("disabled",true);
        var segundoApellidoP = valor.segundoApellido;
        $('#segundoApellidoPa').val(segundoApellidoP).attr("disabled",true);
        var generoPa = valor.genero;
        $('#generoPac').val(generoPa).attr("disabled","disabled");
        var edadPa = valor.edadPaciente;
        $('#edadP').val(edadPa).attr("readonly",true);
        var municipioPa = valor.ciudadResidencia;
        $('#municipioPacien').val(municipioPa).attr("disabled",true);
        var direccionPaciente = valor.direccion;
        $('#direccionPaciente').val(direccionPaciente).attr("disabled", true);
        var telefMovil = valor.telefonoMovil;
        $('#teleMovilPaciente').val(telefMovil).attr("disabled",true);
        var estadoCivilPa = valor.estadoCivil;
        $('#estadoCivilPaciente').val(estadoCivilPa).attr("disabled","disabled");
        var ocupacionPa = valor.ocupacion;
        $('#ocupacionPacie').val(ocupacionPa).attr("disabled",true);

      });
    }

  });

};



var consultarAcompananteDoc = function (){
  var numeroD = 0;
  if($("#ideAcompanante").val() != ""){
    numeroD = $("#ideAcompanante").val();
  }else{
    if(localStorage.getItem("ReporteAPH-Paciente") != null){
      var dato = JSON.parse(localStorage.getItem("ReporteAPH-Paciente"));
      if(dato.idAcompanante != null ){
        numeroD = dato.documentoAcompanante;
      }
    }
  }
  $.ajax({
    type: 'POST',
    dataType:'JSON',
    url: url + "ReporteAPH/ctrlTipoEvento/ConsultarAcompanante",
    data : {'txtIdentificacionAcomp':numeroD},
  }).done(function(data){
    if (data != "1") {
      $('#btnActualizarAcompanante').show();
      $('#btnLimpiarAC').show();
      $('#btnAgregarAcompanante').hide();
      $('#btnActualizarAcompanante').click(function(){
        EditarAcompanante();
      })
      $.each(data,function(indice, valor) {
        var id = valor.idAcompanante;
        $('#idAcompanante').val(id);
        var objPaciente = {
          idPaciente : $('#txtIdPaciente').val(),
          documento: $('#txtNumeroDocumento').val(),
          idAcompanante : valor.idAcompanante,
          documentoAcompanante: valor.identificacionA
        };

        localStorage.setItem('ReporteAPH-Paciente', JSON.stringify(objPaciente));
        var Identificacion = valor.identificacionA;
        $('#ideAcompanante').val(Identificacion).attr("disabled",true);
        document.getElementById('ideAcompanante').style.width='100%';
        var lugarExpedicionA = valor.lugarExpedicionDocumentoA;
        $('#lugarExpedicion').val(lugarExpedicionA).attr("disabled", true);
        document.getElementById('lugarExpedicion').style.width='100%';
        var nombres = valor.nombreA;
        $('#nombreA').val(nombres).attr("disabled", true);
        document.getElementById('nombreA').style.width='100%';
        var apellidos = valor.apellidoA;
        $('#apellido').val(apellidos).attr("disabled", true);
        document.getElementById('apellido').style.width='100%';
        var parentesco = valor.parentescoA;
        $('#parentesco').val(parentesco).attr("disabled", true);
        document.getElementById('parentesco').style.width='100%';
        var telefono = valor.telefonoA;
        $('#telefono').val(telefono).attr("disabled", true);
        document.getElementById('telefono').style.width='100%';
      });
    }
  }).fail(function(err){
    console.log("Error");
  })
};


var Editar = function () {
  $('#btnRegistrarPaciente').hide();
  $('#ocultarEdad').hide();
  $('#txtNumeroDocumento').removeAttr("disabled");
  $('#fechaNacimi').removeAttr("disabled");
  $('#primerNombrePa').removeAttr("disabled");
  $('#segundoNombrePa').removeAttr("disabled");
  $('#primerApellidoPa').removeAttr("disabled");
  $('#segundoApellidoPa').removeAttr("disabled");
  $('#generoPac').removeAttr("disabled");
  document.getElementById('generoPac').style.background='#FFFFFF';
  $('#municipioPacien').removeAttr("disabled");
  $('#direccionPaciente').removeAttr("disabled");
  $('#teleMovilPaciente').removeAttr("disabled");
  $('#estadoCivilPaciente').removeAttr("disabled");
  document.getElementById('estadoCivilPaciente').style.background='#FFFFFF';
  $('#opTipoDocumento').removeAttr("disabled");
  document.getElementById('opTipoDocumento').style.background='#FFFFFF';
  $('#ocupacionPacie').removeAttr("disabled");
  $('#btnLimpiar').hide();
  $('#btnActualizarPaciente').hide();
};

var EditarAcompanante = function(){
  $('#ideAcompanante').removeAttr("disabled");
  $('#lugarExpedicion').removeAttr("disabled");
  $('#nombreA').removeAttr("disabled");
  $('#apellido').removeAttr("disabled");
  $('#parentesco').removeAttr("disabled");
  $('#telefono').removeAttr("disabled");
  $('#btnModificarAcompanante').show();
  $('#btnActualizarAcompanante').hide();
  $('#btnLimpiarAC').hide();
}


function ModificarPaciente(){
  $.ajax({
    type: 'POST',
    url: url + "ReporteAPH/ctrlTipoEvento/ActualizarPaciente",
    data: $("#formPaciente").serialize()
  }).done(function(data){
    if (data == 1) {
      Notificate({
        tipo: 'success',
        titulo: 'Modificación Exitosa',
        descripcion: 'El paciente se modificó correctamente.'
      });
      var objPaciente = {
        idPaciente:  $('#txtIdPaciente').val(),
        documento:   $('#txtNumeroDocumento').val(),
        idAcompanante : $('#idAcompanante').val(),
        documentoAcompanante: $('#ideAcompanante').val()
      };

      localStorage.setItem('ReporteAPH-Paciente', JSON.stringify(objPaciente));
      $('#btnGuardarDatos').show();
    }else{
      Notificate({
        tipo: 'error',
        titulo: 'Error',
        descripcion: 'No se pudo modificar.'
      });
    }
  }).fail(function(data){
    console.log('No');
  });
}

var ActualizarAcompanante = function(){
  $.ajax({
    type: 'POST',
    url: url + "ReporteAPH/ctrlTipoEvento/ModificarAcompanante",
    data: $("#formAcompanante").serialize()
  }).done(function(data){
    console.log("acompañante", data);
    if (data == '1') {
      Notificate({
        tipo: 'success',
        titulo: 'Modificación Exitosa',
        descripcion: 'El acompañante se modificó correctamente.'
      });
      $('#btnModificarAcompanante').show();
    }
  }).fail(function(){
    console.log("Error");
  })
};

var InhabilitarCamposAcompanante = function(){
  $('#ideAcompanante').attr("disabled", true);
  document.getElementById('ideAcompanante').style.width='100%';
  $('#lugarExpedicion').attr("disabled", true);
  document.getElementById('lugarExpedicion').style.width='100%';
  $('#nombreA').attr("disabled", true);
  document.getElementById('nombreA').style.width='100%';
  $('#apellido').attr("disabled", true);
  document.getElementById('apellido').style.width='100%';
  $('#parentesco').attr("disabled", true);
  document.getElementById('parentesco').style.width='100%';
  $('#telefono').attr("disabled", true);
  document.getElementById('telefono').style.width='100%';
};


function colorCampos(){
  document.getElementById('edadP').style.background='#F9F9F9';
  document.getElementById('opTipoDocumento').style.background='#F9F9F9';
  document.getElementById('opTipoDocumento').style.width='100%';
  document.getElementById('edadP').style.width='100%';
  document.getElementById('generoPac').style.background='#F9F9F9';
  document.getElementById('generoPac').style.width='100%';
  document.getElementById('estadoCivilPaciente').style.background='#F9F9F9';
  document.getElementById('estadoCivilPaciente').style.width='100%';
  document.getElementById('primerNombrePa').style.width='100%';
  document.getElementById('txtNumeroDocumento').style.width='100%';
  document.getElementById('segundoNombrePa').style.width='100%';
  document.getElementById('primerApellidoPa').style.width='100%';
  document.getElementById('segundoApellidoPa').style.width='100%';
  document.getElementById('fechaNacimi').style.width='100%';
  document.getElementById('municipioPacien').style.width='100%';
  document.getElementById('direccionPaciente').style.width='100%';
  document.getElementById('teleMovilPaciente').style.width='100%';
  document.getElementById('ocupacionPacie').style.width='100%';
}
