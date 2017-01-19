$(document).ready(function () {

  listarComboTipoDocumento();
  listarComboRol();
  listarComboEspecialidad();

  $("#txtNumeroDocumento").blur(function () {
    ConsultaPersonaD();
  });
  $("#txtCorreo").blur(function () {
    ConsultaPersonaCorreo();
  });
  $("#txtUsuario").blur(function () {
    ConsultaPersonaUsuario();
  });

  $("#txtFechaNacimiento").datepicker({
         language: 'es',
         maxDate: new Date(),
         position:"bottom left",
          onSelect:function(formattedDate){
             myDatepicker.hide();
          }
        });

  $("#txtFechaNacimientoo").datepicker({
         language: 'es',
          maxDate: new Date(),
         position:"bottom left",
          onSelect:function(formattedDate){
             myDatepicker.hide();
          }
        });

  ValidateForm('FormPersona', function() {

    $.ajax({
      type: 'POST',
      url: url + "Usuarios/ctrlRegistrarPersona/RegistrarPersona",
      contentType: false,
      processData: false,
      data: new FormData($("#FormPersona")[0])
    }).done(function (data) {
      if (Number(data) === 1) {
         LimpiarCampos();
        var descripcion = 'Se ha registrado exitosamente';
        Notificate({
          titulo: '¡Registro exitoso!',
          descripcion: descripcion,
          tipo: 'success',
          duracion: 4
        });
      } else {
        Notificate({
          tipo: 'error',
          titulo: '¡Error!',
          descripcion: 'Verifica que toda la información esté correcta',
          duracion: 4
        });
      }
    }).fail(function (a) {
      Notificate({
        tipo: 'error',
        titulo: '¡Error!',
        descripcion: 'Verifica que toda la información esté correcta',
        duracion: 4
      });
    })
  });

  ValidateForm('FormPersonaExterna', function() {

    $.ajax({
      type: 'POST',
      url: url + "Usuarios/ctrlRegistrarPersonaExterna/RegistrarPersonaExterna",
      contentType: false,
      processData: false,
      data: new FormData($("#FormPersonaExterna")[0])
    }).done(function (data) {
      if (Number(data) === 1) {
        LimpiarCampos();
        var descripcion = 'Se ha registrado exitosamente';
        Notificate({
          titulo: '¡Registro exitoso!',
          descripcion: descripcion,
          tipo: 'success',
          duracion: 4
        });
      } else {
        Notificate({
          tipo: 'error',
          titulo: '¡Error!',
          descripcion: 'Las contraseñas no coinciden',
          duracion: 4
        });
      }
    }).fail(function (a) {
      Notificate({
        tipo: 'error',
        titulo: '¡Error!',
        descripcion: 'Verifica que toda la información esté correcta',
        duracion: 4
      });
    })
  });

});

$("#slcTipoDocumento").select2({
  placeholder: "Seleccione una opción"
});
$("#slcRol").select2({
  placeholder: "Seleccione una opción"
});
$("#slcEspecialidad").select2({
  placeholder: "Seleccione una opción"
});

function listarComboTipoDocumento() {
  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: url + 'Usuarios/ctrlRegistrarPersona/ListarComboTipoDocumento',
    data: {
      "": ""
    }
  }).done(function (e) {

    $.each(e, function (i, v) {

      $('#slcTipoDocumento').append('<option value="' + v.idTipoDocumento + '">' + v.descripcionTdocumento + '</option>');
    })
  }).fail(function () {

  })
}

function listarComboTipoDocumento() {
  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: url + 'Usuarios/ctrlRegistrarPersonaExterna/ListarComboTipoDocumento',
    data: {
      "": ""
    }
  }).done(function (e) {
    $.each(e, function (i, v) {
      $('#slcTipoDocumento').append('<option value="' + v.idTipoDocumento + '">' + v.descripcionTdocumento + '</option>');
    })
  }).fail(function () {

  })
}

function listarComboRol() {
  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: url + 'Usuarios/ctrlRegistrarPersona/ListarComboRol',
    data: {
      "": ""
    }
  }).done(function (e) {
    $.each(e, function (i, v) {
      $('#slcRol').append('<option value="' + v.idRol + '">' + v.descripcionRol + '</option>');
    })
  }).fail(function () {

  })
}

function listarComboEspecialidad() {
  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: url + 'Usuarios/ctrlRegistrarPersona/ListarComboEspecialidad',
    data: {
      "": ""
    }
  }).done(function (e) {
    $.each(e, function (i, v) {
      $('#slcEspecialidad').append('<option value="' + v.idEspecialidad + '">' + v.descripcionEspecialidad + '</option>');
    })
  }).fail(function () {

  })
}

//función para que se habiliten las especialidades cuando este seleccionado el rol médico
$("#slcRol").change(function () {
  if ($("#slcRol").val() != "3") {
    $("#slcEspecialidad").attr("disabled", "disabled");
  } else {
    $("#slcEspecialidad").removeAttr("disabled");
  }
});

$("#slcRol").change(function () {
  if ($("#slcRol").val() != "3") {
    $("#txtFirma").attr("disabled", "disabled");
  } else {
    $("#txtFirma").removeAttr("disabled");
  }
});


function ConsultaPersonaCorreo() {
  var correo = $("#txtCorreo").val();
  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: url + 'Usuarios/ctrlRegistrarPersona/ConsultarPersonaCorreo',
    data: {
      'txtCorreo': correo
    },
  }).done(function (data) {

    if (data == '1') {
//      console.log("Bien, no hay persona registrada con ese correo");
      $('#btnRegistrarPersona').attr("disabled", false);
    } else {
      Notificate({
        tipo: 'info',
        titulo: 'Noticia',
        descripcion: 'Ya se encuentra registrada una persona con ese correo',
        duracion: 4
      });

      $.each(data, function (indice, valor) {
        $('#btnRegistrarPersona').attr("disabled", true);

      });
    }
  }).fail(function (err) {

  })
}

function ConsultaPersonaCorreo() {
  var correo = $("#txtCorreo").val();
  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: url + 'Usuarios/ctrlRegistrarPersonaExterna/ConsultarPersonaCorreo',
    data: {
      'txtCorreo': correo
    },
  }).done(function (data) {

    if (data == '1') {
//      console.log("Bien, no hay persona registrada con ese correo");
      $('#btnRegistrarPersona').attr("disabled", false);
    } else {
      Notificate({
        tipo: 'info',
        titulo: 'Noticia',
        descripcion: 'Ya se encuentra registrada una persona con ese correo',
        duracion: 4
      });

      $.each(data, function (indice, valor) {
        $('#btnRegistrarPersona').attr("disabled", true);

      });
    }
  }).fail(function (err) {

  })
}

function ConsultaPersonaD() {
  var numero = $("#txtNumeroDocumento").val();
  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: url + 'Usuarios/ctrlRegistrarPersona/ConsultarPersonaD',
    data: {
      'txtNumeroDocumento': numero
    },
  }).done(function (data) {

    if (data == '1') {
//      console.log("Bien, no hay persona registrada con ese número de documento");
      $('#btnRegistrarPersona').attr("disabled", false);
    } else {
      Notificate({
        tipo: 'info',
        titulo: 'Noticia',
        descripcion: 'Ya se encuentra registrada una persona con ese número de documento',
        duracion: 4

      });

      $.each(data, function (indice, valor) {
        $('#btnRegistrarPersona').attr("disabled", true);

      });
    }
  }).fail(function (err) {

  })
}

function ConsultaPersonaD() {
  var numero = $("#txtNumeroDocumento").val();
  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: url + 'Usuarios/ctrlRegistrarPersonaExterna/ConsultarPersonaD',
    data: {
      'txtNumeroDocumento': numero
    },
  }).done(function (data) {

    if (data == '1') {
//      console.log("Bien, no hay persona registrada con ese número de documento");

      $('#btnRegistrarPersona').attr("disabled", false);
    } else {

      Notificate({
        tipo: 'info',
        titulo: 'Noticia',
        descripcion: 'Ya se encuentra registrada una persona con ese número de documento',
        duracion: 4

      });

      $.each(data, function (indice, valor) {
        $('#btnRegistrarPersona').attr("disabled", true);
      });
    }
  }).fail(function (err) {

  })
}


function ConsultaPersonaUsuario() {
  var usuario = $("#txtUsuario").val();
  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: url + 'Usuarios/ctrlRegistrarPersonaExterna/ConsultarPersonaUsuario',
    data: {
      'txtUsuario': usuario
    },
  }).done(function (data) {

    if (data == '1') {
//      console.log("Bien, no hay persona registrada con ese usuario");

      $('#btnRegistrarPersona').attr("disabled", false);
    } else {

      Notificate({
        tipo: 'info',
        titulo: 'Noticia',
        descripcion: 'Ya se encuentra registrada una persona con ese usuario',
        duracion: 4

      });

      $.each(data, function (indice, valor) {
        $('#btnRegistrarPersona').attr("disabled", true);
      });
    }
  }).fail(function (err) {

  })
}


function LimpiarCampos() {

  $("#txtNumeroDocumento").val("");
  $("#txtFechaNacimiento").val("");
  $("#txtFechaNacimientoo").val("");
  $("#slcGrupoSanguineo").val("0");
  $("#txtPrimerNombre").val("");
  $("#txtSegundoNombre").val("");
  $("#txtPrimerApellido").val("");
  $("#txtSegundoApellido").val("");
  $("#slcSexo").val("0");
  $("#slcDependencia").val("0");
  $("#txtDepartamento").val("");
  $("#txtCiudad").val("");
  $("#txtPais").val("");
  $("#txtDireccion").val("");
  $("#txtTelefono").val("");
  $("#txtCorreo").val("");
  $("#txtLugarNacimiento").val("");
  $("#txtLugarExpedicionDocumento").val("");
  $("#slcEspecialidad").val('0').trigger('change');
  $("#slcTipoDocumento").val('0').trigger('change');
  $("#slcRol").val('0').trigger('change');
  $("#limpiar_foto").val("");
  $("#limpiar_hoja").val("");
  $("#limpiar_firma").val("");
  $("#txtUsuario").val("");
  $("#txtClave1").val("");
  $("#txtClave2").val("");
}

$("#txtFechaNacimiento").datepicker({
        language: 'es',
        maxDate: new Date()
       });

       $("#txtFechaNacimiento").blur(function (){
     $.ajax({
       type:'POST',
       dataType: 'JSON',
       url:url+'Usuarios/ctrlRegistrarPersona/FechaServidor'
     }).done(function(data){
       var valorFecha = $("#txtFechaNacimiento").val();
       var fecha = new Date(valorFecha);
       var fechaActual = new Date(data);
       var lfechaActual=fechaActual.getYear()-18;
       if (fecha.getYear() > lfechaActual) {
         Notificate({
           tipo: 'warning',
           titulo: 'Cuidado con la fecha',
           descripcion: 'No puede registrar una persona menor de edad.',
           duracion: 4
         });
         $("#txtFechaNacimiento").val("").focus();
       }else if (fecha.getYear() == lfechaActual && fecha.getMonth() > fechaActual.getMonth()) {
         Notificate({
           tipo: 'warning',
           titulo: 'Cuidado con la fecha',
           descripcion: 'No puede registrar una persona menor de edad.',
           duracion: 4
         });
         $("#txtFechaNacimiento").val("").focus();
       }else if(fecha.getYear() == lfechaActual && fecha.getMonth() == fechaActual.getMonth() && fecha.getDate() >  fechaActual.getDate()){
         Notificate({
           tipo: 'warning',
           titulo: 'Cuidado con la fecha',
           descripcion: 'No puede registrar una persona menor de edad.',
           duracion: 4
         });
         $("#txtFechaNacimiento").val("").focus();
       }
     });
   });

 $("#txtFechaNacimientoo").datepicker({
        language: 'es',
         maxDate: new Date()
         });

         $("#txtFechaNacimientoo").blur(function (){
       $.ajax({
         type:'POST',
         dataType: 'JSON',
         url:url+'Usuarios/ctrlRegistrarPersonaExterna/FechaServidorE'
       }).done(function(data){
         var valorFecha = $("#txtFechaNacimientoo").val();
         var fecha = new Date(valorFecha);
         var fechaActual = new Date(data);
         var lfechaActual=fechaActual.getYear()-18;
         if (fecha.getYear() > lfechaActual) {
           Notificate({
             tipo: 'warning',
             titulo: 'Cuidado con la fecha',
             descripcion: 'No puede registrar una persona menor de edad.',
             duracion: 4
           });
           $("#txtFechaNacimientoo").val("").focus();
         }else if (fecha.getYear() == lfechaActual && fecha.getMonth() > fechaActual.getMonth()) {
           Notificate({
             tipo: 'warning',
             titulo: 'Cuidado con la fecha',
             descripcion: 'No puede registrar una persona menor de edad.',
             duracion: 4
           });
           $("#txtFechaNacimientoo").val("").focus();
         }else if(fecha.getYear() == lfechaActual && fecha.getMonth() == fechaActual.getMonth() && fecha.getDate() >  fechaActual.getDate()){
           Notificate({
             tipo: 'warning',
             titulo: 'Cuidado con la fecha',
             descripcion: 'No puede registrar una persona menor de edad.',
             duracion: 4
           });
           $("#txtFechaNacimientoo").val("").focus();
         }
       });
     });
