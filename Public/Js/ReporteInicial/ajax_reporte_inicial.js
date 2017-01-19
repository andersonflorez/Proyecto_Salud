$('#cancel-report').click(function() {
  CancelarReporte($(this).attr('ref'));
});

$('#add-new').click(function() {
  AgregarNovedadReporte($(this).attr('ref'));
});

function InactivateListItem() {
  let parent = $('#contenedor-reportes li.list_item');
  parent.each(function(i, item) {
    let active = $(item).find('h5.report_title');
    if (active.hasClass('active')) {
      active.removeClass('active');
    }
  });
}

// Función para consultar un reporte y listar su información completa:
function ConsultarReporte(reporte, idReporte) {

  if (!$(reporte).hasClass('active')) {
    InactivateListItem();
    $(reporte).addClass('active');

    let urlAjax = 'ReporteInicial/CtrlConsultarReporte/ConsultarReporteInicial';
    let datapack = {
      ajax: true,
      idReporteInicial: idReporte
    };

    DoPostAjax({url: urlAjax, data: datapack}, function(err, data) {
      if (err) {
        Notificate({
          tipo: 'error',
          titulo: 'Error inesperado',
          descripcion: 'Error inesperado al momento de consultar el reporte, compruebe su conexión a internet o recargue la página e intentelo nuevamente, si sigue teniendo problemas contacte con un técnico'
        });
      } else if (data) {
        data = JSON.parse(data);
        ConsultarChat(Number(data.idChat))
        .then(printChatInformation)
        .then(showRightPanel)
        .then(function() {
          JSONtoHTMLReport(data);
        });
      } else {
        Notificate({
          tipo: 'error',
          titulo: 'Error inesperado',
          descripcion: 'Error inesperado al momento de consultar el reporte, compruebe su conexión a internet o recargue la página e intentelo nuevamente, si sigue teniendo problemas contacte con un técnico'
        });
      }
    });

  }
}

// Función para cancelar un reporte:
function CancelarReporte(idReporte) {
  swal({
    title: 'Cancelar reporte',
    text: '¿Está seguro que desea cancelar el reporte en proceso?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Si, continuar!',
    cancelButtonText: 'No, salir',
    closeOnConfirm: false
  },
  function() {
    swal({
      title: 'Descripción',
      text: '¿Por qué se cancelará el reporte?',
      type: 'input',
      showCancelButton: true,
      closeOnConfirm: false,
      confirmButtonText: 'Cancelar reporte',
      cancelButtonText: 'Salir',
      animation: 'slide-from-top',
      inputPlaceholder: 'Argumento'
    },
    function(inputValue) {
      if (inputValue === false) return false;
      if (inputValue === '') {
        swal.showInputError('Por favor ingrese una descripción!');
        return false;
      }
      var urlAjax = 'ReporteInicial/CtrlConsultarReporte/CancelarReporte';
      var data = {
        ajax: true,
        idReporte: idReporte,
        descripcion: inputValue
      };
      DoPostAjax({url: urlAjax, data: data}, function(err, data) {
        if (err) {
          swal('Ha ocurrido un error!', 'Ha ocurrido un error inesperado al momento de cancelar el reporte, compruebe su conexión a internet o recargue la página e intentelo nuevamente, si sigue teniendo problemas contacte con un técnico', 'error');
        } else if (data) {
          swal('Reporte cancelado!', 'El reporte ha sido cancelado satisfactoriamente', 'success');

          $('#cancel-report').css({'display': 'none'}).attr('ref', '');
          $('#add-new').css({'display': 'none'}).attr('ref', '');
          $('#estado-reporte').text('Cancelado');

          data = JSON.parse(data);
          let novedades;
          if (data) {
            let retorno = obtenerNovedadesHtml(data);
            novedades = retorno.htmlNovedades;
          }

          $('#lista-novedades').html(novedades);
          updateReportsView(gatherOptions());

        } else {
          swal('Ha ocurrido un error!', 'Ha ocurrido un error inesperado al momento de cancelar el reporte, compruebe su conexión a internet o recargue la página e intentelo nuevamente, si sigue teniendo problemas contacte con un técnico', 'error');
        }
      });
    });
  });
}

// Función para agregar una novedad al reporte:
function AgregarNovedadReporte(idReporte) {
  swal({
    title: 'Novedad reporte',
    text: 'Ingrese una descripción de la novedad del reporte:',
    type: 'input',
    showCancelButton: true,
    closeOnConfirm: false,
    confirmButtonText: 'Agregar novedad',
    cancelButtonText: 'Cancelar',
    animation: 'slide-from-top',
    inputPlaceholder: 'Descripción'
  },
  function(inputValue) {
    if (inputValue === false) return false;
    if (inputValue === '') {
      swal.showInputError('Por favor ingrese una descripción!');
      return false;
    }
    let urlAjax = 'ReporteInicial/CtrlConsultarReporte/AgregarNovedadReporte';
    let data = {
      ajax: true,
      idReporte: idReporte,
      descripcion: inputValue
    };
    DoPostAjax({url: urlAjax, data: data}, function(err, data) {
      if (err) {
        swal('Ha ocurrido un error!', 'Ha ocurrido un error inesperado al momento de agregar la novedad del reporte, compruebe su conexión a internet o recargue la página e intentelo nuevamente, si sigue teniendo problemas contacte con un técnico', 'error');
      } else if (data) {

        swal('Novedad registrada!', 'La novedad del reporte ha sido agregada satisfactoriamente', 'success');

        data = JSON.parse(data);
        let novedades;
        if (data) {
          let retorno = obtenerNovedadesHtml(data);
          novedades = retorno.htmlNovedades;
        }
        $('#lista-novedades').html(novedades);

      } else {
        swal('Ha ocurrido un error!', 'Ha ocurrido un error inesperado al momento de agregar la novedad del reporte, compruebe su conexión a internet o recargue la página e intentelo nuevamente, si sigue teniendo problemas contacte con un técnico', 'error');
      }
    });
  });
}

function ConsultarChat(idChat) {

  let dir = url + 'ReporteInicial/ctrlConsultarReporte/ConsultarChatReporteInicial';

  return $.ajax({
    url: dir,
    type: 'POST',
    data: {
      ajax: true,
      idChat: idChat
    }
  });

}
