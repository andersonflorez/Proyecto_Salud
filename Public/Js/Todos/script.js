/***********************************************************************
** 	   ESTE ARCHIVO CONTIENE FUNCIONES GLOBALES USADAS POR TODOS 	    **
***********************************************************************/

// Controla que menú se muestra de la nav
var menus = [
  false, // Menu perfil de usuario
  false // Menu emergencia ReporteAPH
],

// Controla si se ve o no la barra de filtro del menú de notificaciones
MostrarFiltrarN = false;

$(document).ready(function() {

  $('.frmCont .input_file .btn_group input[type=file]').change(function() {
    let fileInput = $(this);
    fileInput.parent().parent().children('input[type=text]').val(fileInput.val());
  });

  // Efecto focus validaciones jquery validate
  focusInputsValidaciones();

  // Efecto de la barra de filtro del menú de notificaciones
  $('#txtFiltrarNotificacionesE').hide(200);
  $('#MostrarFiltrarN').click(function() {
    $('#txtFiltrarNotificacionesE').slideToggle(50, function() {
      if (MostrarFiltrarN === true) {
        $('.menu-notificaciones-flotantes').css({
          'padding-top': '3em'
        });
        MostrarFiltrarN = false;
      }else {
        $('.menu-notificaciones-flotantes').css({
          'padding-top': '7em'
        });
        MostrarFiltrarN = true;
      }
    });
  });

  // Despliega el menu de notificaciones
  $('#contenedor-notificaciones').click(function() {
    $('body').css({'overflow-y': 'hidden'});
    $('.menu-notificaciones-flotantes').animate({
      right: '0px'
    },400);
  });

  // Ocultar Menu Notificaciones
  $('#MostrarMenuN').click(function() {
    $('body').css({'overflow-y': 'auto'});
    $('.menu-notificaciones-flotantes').animate({
      right: '-1000px',
    },400);
  });

  // Despliega o cierra menu perfil de usuario de la nav
  $('#perfil-usuario').click(function() {
    if (menus[0]) {
      menus[0] = false;
    }else {
      CerrarMenu(0);
    }

    AnimacionMenu('#menu_perfil_user');
  });

  /**
  * Despliega o cierra menu de emergencias de ReporteAPH
  * Esta función esta aqui porque el botón se enecuentra en la nav,
  * Y por tanto es preferible hacerlo aqui que repetir código en la rama.
  */
  $('#menu-emerg').click(function() {

    if (menus[1]) {
      menus[1] = false;
    } else {
      CerrarMenu(1);
    }

    AnimacionMenu('#menu_emergencia');
  });

  /**
  * Necesario para la barra filtro del paginador
  */
  $('.toggle').click(function() {
    var elemento = $(this).siblings().attr('id');
    Desplegar(elemento);
  });

  $('.btn-barra-menu').click(function() {
    AbrirMenu();
  });

}); // Fin $(document).ready ----------------------------->

// FUNCIONES Y MÉTODOS

// Asigna la cantidad de notificaciones de la campana
function nuevaNotificacion(cantidad) {
  if (cantidad > 0) {
    $('#flotante-notify').addClass('notify-nueva');
    $("#flotante-notify").attr('contador', cantidad);
  }else {
    $('#flotante-notify').removeClass('notify-nueva');
  }
}

// Oculta o mustra los menus
function AnimacionMenu(nombreMenu) {
  if (nombreMenu) {
    $(nombreMenu).animate({
      height: 'toggle',
      opacity: 'toggle'
    }, 'fast');
  }else {
    alert('Debe enviar un nombre de clase o id como parametro.');
  }
}

/*
* Cierra todos los menus que esten abiertos y definidos en el arreglo menu,
* excepto el que se le indique como parametro
*/
function CerrarMenu(salvar) {
  var NombreMenus = [
    'menu_perfil_user',
    'menu_emergencia'
  ];
  for (var i = 0; i < NombreMenus.length; i++) {
    $('#' + NombreMenus[i]).hide('fast');
    menus[i] = false;
  }

  if (salvar !== null) {
    menus[salvar] = true;
  }
}

/**
* Efecto de focus para div de validaciones de jquery validate
*/
function focusInputsValidaciones() {

  var buscar = '.frmInput > input, .frmInput > select, .frmInput > textarea',
  border = {
    azul: {'border': '1px #4EC3F4 solid'},
    gris: {'border': '1px rgba(0,0,0,0.15) solid'}
  };

  // Recorrer todos los input, select, textarea que necesiten ser validados
  $(buscar).each(function() {

    // Efecto focus  -------------------------->
    $(this).focus(function() {
      $('.frmInput').eq($(buscar).index(this)).css(border.azul);
    }); // Fin focus

    $(this).blur(function() {
      $('.frmInput').eq($(buscar).index(this)).css(border.gris);
    }); // Fin blur
    // Fin  efecto focus  -------------------------->

    // Efecto hover -------------------------->
    $(this).mouseover(function() {
      $('.frmInput').eq($(buscar).index(this)).css(border.azul);

      $(this).mouseout(function() {
        // Evitar que cuando el elemento este en focus y haga efecto hover se quite el border azul
        if (!$(buscar).eq($(buscar).index(this)).is(':focus')) {
          $('.frmInput').eq($(buscar).index(this)).css(border.gris);
        }
      }); // Fin mouseout

    }); // Fin mouseover
    // Fin Efecto hover -------------------------->

  }); // Fin each
}

// Función estándar para validar formularios:
this.ValidateForm = function(idForm, callback) {
  jQuery.validator.setDefaults({
    debug: true,
    success: 'valid'
  });

  $('#' + idForm).validate({
    onfocusout: function(element) {
      $(element).valid();
    },

    focusCleanup: function(element) {
      $(element).parent().removeClass('frm_contenedorMalo');
    },

    onkeyup: false,

    highlight: function(element, errorClass) {
        console.log(element);
      $(element).siblings('input').removeClass('errorClass');
      $(element).parent().addClass('frm_contenedorMalo');
    },

    success: function(element) {
      $(element).parent().removeClass('frm_contenedorMalo');
    },

    submitHandler: function() {
      let collection = $('#' + idForm).children().find('.input_data');
      let data = {};
      collection.each(function(i, input) {
        data[$(input).attr('name')] = $(input).val();
      });
      callback(data);
    }

  });
};

function LimpiarCampos(idForm) {
  let collection = $('#' + idForm).children().find('.input_data');
  collection.each(function(i, input) {
    if ($(input).is('select')) {
      if ($(input).hasClass('selectpicker')) {
        $(this).selectpicker('deselectAll');
      }
      $(input).val($(input).children().first().val());
    } else {
      $(input).val('');
    }
  });
}

// Necesario para la barra de filtro del paginador
function Desplegar(elemento) {
  $('#' + elemento).slideToggle(200);
}

function AbrirMenu() {
  $('.menu-filtro').slideToggle(150);
}

// OCULTAR FILTROS DE BÚSQUEDA:
$('html').click(function() {
  if ($('.menu-filtro').is(':visible')) {
    AbrirMenu();
  }
});

$('.menu-filtro, .btn-barra-menu').click(function(e) {
  e.stopPropagation();
});

$('.toggle').click(function() {
  let toggle = $($(this).siblings()[0]).attr('id');
  $('.contenedor').each(function(i, elem) {
    let id = $(elem).attr('id');
    if ($(elem).is(':visible') && id !== toggle) {
      Desplegar(id);
    }
  });
});

// Función estándar para realizar peticiones ajax:
this.DoPostAjax = function(config, callback) {
  $.ajax({
    url: url + config.url,
    type: 'POST',
    data: config.data
  }).done(function(data) {
    callback(null, data);
  }).fail(function(err) {
    callback(err);
  });
};

// Se encarga del paginador
this.Paginate = function (options, btn, callback) {
  paginator.view.paginate(btn)
  .then(function (page) {
    options.configuration.page = page;
    let config = paginator.model.getConfiguration(options.configuration);
    paginator.model.queryDataBase(options.url, config)
    .then(callback);
  });
};
