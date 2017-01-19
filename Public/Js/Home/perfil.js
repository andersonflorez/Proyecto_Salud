$(document).ready(function(){

  $("#txtNumeroDocumento").blur(function () {
    ConsultaPersonaD();
  });
  $("#txtCorreo").blur(function () {
    ConsultaPersonaCorreo();
  });

ValidateForm('FormModificarPerfil', function() {

  $.ajax({
    type: 'POST',
    url: url + "Home/ctrlModificarPerfil/ActualizarPerfil",
    contentType: false,
    processData: false,
    data: new FormData($("#FormModificarPerfil")[0])
  }).done(function (data) {

    if (Number(data) === 1) {
      var descripcion = 'Se ha modificado exitosamente';
      Notificate({
        titulo: '¡Modificación exitosa!',
        descripcion: descripcion,
        tipo: 'success',
        duracion: 4
      });

    } else {
      Notificate({
        tipo: 'info',
        titulo: 'Noticia',
        descripcion: 'No se han hecho cambios nuevos',
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

      function ConsultaPersonaCorreo() {
        var correo = $("#txtCorreo").val();
        $.ajax({
          type: 'POST',
          dataType: 'JSON',
          url: url + 'Home/ctrlModificarPerfil/ConsultarPersonaCorreo',
          data: {
            'txtCorreo': correo
          },
        }).done(function (data) {

          if (data == '1') {

            $('#btnModificarPerfil').attr("disabled", false);
          } else {
            Notificate({
              tipo: 'info',
              titulo: 'Noticia',
              descripcion: 'Ese correo ya está siendo usado',
              duracion: 4
            });

            $.each(data, function (indice, valor) {
              $('#btnModificarPerfil').attr("disabled", true);

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
          url: url + 'Home/ctrlModificarPerfil/ConsultarPersonaD',
          data: {
            'txtNumeroDocumento': numero
          },
        }).done(function (data) {

          if (data == '1') {

            $('#btnModificarPerfil').attr("disabled", false);
          } else {
            Notificate({
              tipo: 'info',
              titulo: 'Noticia',
              descripcion: 'Ese número de documento ya está siendo usado',
              duracion: 4
            });

            $.each(data, function (indice, valor) {
              $('#btnModificarPerfil').attr("disabled", true);
            });
          }
        }).fail(function (err) {

        })
      }

      $("#txtFechaNacimiento").datepicker({
              language: 'es',
              maxDate: new Date()
             });

             $("#txtFechaNacimiento").blur(function (){
           $.ajax({
             type:'POST',
             dataType: 'JSON',
             url:url+'Home/ctrlModificarPerfil/FechaServidor'
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
