/*
* Este script ha sido creado con el fin de
* dar a conocer la implementación a nivel de
* Javascript de algunas funcionalidades nuevas
* del estándar del proyecto.
*/
(function(global) {

  // Después de terminar de cargar el DOM...
  $(document).ready(function() {

    // Validar formulario de ejemplo
    ValidateForm('frmEjemplo', ResponseHandler);

    // Validar formulario de la modal
    ValidateForm('frmEjemploModal', ResponseHandler);

    // Desplegar notificaciones al presionar click en los botones:
    $('button.ejemplo_notificacion').click(function() {
      let type = $(this).attr('target');
      let config = {};
      let title = 'Notificación de ';
      let message = 'Esta es una prueba de notificación de ';
      switch (type) {

        case 'success':
          config = {
          tipo: type,
          titulo: title + 'éxito',
          descripcion: message + 'éxito'
        };
        break;

        case 'info':
          config = {
          tipo: type,
          titulo: title + 'información',
          descripcion: message + 'información'
        };
        break;

        case 'warning':
          config = {
          tipo: type,
          titulo: title + 'advertencia',
          descripcion: message + 'advertencia'
        };
        break;

        case 'error':
          config = {
          tipo: type,
          titulo: title + 'error',
          descripcion: message + 'error'
        };
        break;

      }

      Notificate(config);
    });
  });

  function ResponseHandler(formdata) {
    console.log(formdata);

    let descripcion = 'Revisa la consola del navegador para ver los datos que has enviado';

    Notificate({
      titulo: 'Formulario enviado!',
      descripcion: descripcion,
      tipo: 'success',
      duracion: 4
    });

    // Ejemplo de petición ajax:
    DoPostAjax({
      url: 'ejemplos/ctrlEjemplos/PruebaAjax',
      data: formdata
    }, function(err, data) {
      if (err) {
        // Si ocurre algún error:
        Notificate({
          titulo: 'Ha ocurrido un error',
          descripcion: 'Error inesperado al enviar la información, por favor intentelo nuevamente',
          tipo: 'error',
          duracion: 4
        });
      } else {
        console.log(data);
        // Si todo sale bien:
        Notificate({
          titulo: 'Información recibida',
          descripcion: data,
          tipo: 'info',
          duracion: 4
        });
      }
    });
  }

  // Funcionalidad para los botones de paginación:
  var options = {
    parent: 'paginadorDinamico',
    url: 'EJEMPLOS/CtrlEjemplos/PruebaPaginador',
    configuration: {
      tableName: 'tbl_paciente',
      limit: 10,
    }
  };

  paginator.view.generateButtons(options)
  .then(function(data) {
    console.log('primero: ' , data);
    $('#' + options.parent).on('click', 'li.btn_paginador', function() {
      Paginate(options, $(this), function(data) {
        console.log(data);
      });
    });
  });

})(this);