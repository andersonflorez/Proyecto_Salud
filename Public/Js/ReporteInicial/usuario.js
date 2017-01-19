var li = $('.nav_option');

var form = $('.panel_form');
var list = $('.panel_list_chat');
var chat = $('.panel_chat');

var HistorialChat;
var initialDate;
var finalDate;
var actualDate;
var words;

$('.open').click(function() {
  var data = $(this).parent().parent().find('p').text();
  $(this).parent().parent().find('input').val(data);
});

// SUBMENU EN TABLET Y SMARTPHONE
$('.view_nav').click(function() {
  var type = $(this).attr('type').toUpperCase();
  switch (type) {
    case 'USER':
    VisiblePanel(form);
    break;
    case 'LIST':
    VisiblePanel(list);
    break;
    case 'CHAT':
    VisiblePanel(chat);
    break;
  }
});

function VisiblePanel(PanelType) {
  if (!PanelType.hasClass('active_panel')) {
    $('.panel_col.active_panel').fadeOut('fast', function() {
      $('.panel_form').addClass('view_panel');
      if (PanelType.hasClass('panel_list_chat')) {
        form.removeClass('view_panel');
      }
      $('.panel_col.active_panel').removeClass('active_panel');
      PanelType.addClass('active_panel');
      PanelType.fadeIn('fast');
    });
  }
}

$('.close_history_chat').click(function(){
  $('#section_chat').fadeOut('fast', function() {
    $('#clean_section').css('display', 'flex');
    if ($('.panel_list_chat').hasClass('panel_list_chat')) {
      form.removeClass('view_panel');
    }
    $('.panel_col.active_panel').removeClass('active_panel');
    $('.panel_list_chat').addClass('active_panel');
    $('.panel_list_chat').fadeIn('fast');
  });
});

(function() {

  $(document).ready(function() {
    $('div#panel_content_history').on('click', '.display', function() {
      let idChat = Number($(this).attr('id'));
      if (!validarChatActivo()) {
        ImprimirChat(idChat);
      }else{
        Notificate({
          tipo: 'info',
          titulo: 'No permitido',
          descripcion: 'No es posible consultar un chat mientras reporta una emergecia'
        });
      }
    });
  });

  $('#clear').click(function(){
    ImprimirHistorial(HistorialChat);
    $('#clear_search').addClass('global_hide');
    $('#txtBusqueda').val("");
  });

  $('#btn-barra-filtro').click(function(){
    console.log(1);
    let parametros =  $('#txtBusqueda').val().split(",");

    if ($('#txtBusqueda').val() != "") {
      parametros.forEach(function(ele, ind, arr){
        arr[ind] = ele.trim();
      });
      words = parametros;
      FilterParam(words);
    }else{
      Notificate({
        tipo: 'info',
        titulo: 'Faltan parametros',
        descripcion: 'Debe especificar algún valor para realizar la busqueda'
      });
    }
  });

  function FilterParam(words) {
    var Chat = HistorialChat.filter(function(CurrentChat){
      let Valid = CurrentChat.chat.some(function(pMensaje){
        let bit = false;
        for (var i = 0; i < words.length; i++) {
          if (pMensaje.mensaje.indexOf(words[i]) != -1) {
            bit = true;
          }
        }
        return bit;
      });
      return Valid;
    });

    if (Chat != 0) {
      $('#clear_search').removeClass('global_hide');
      ImprimirHistorial(Chat);
    }else{
      $('#clear_search').removeClass('global_hide');
      $('#panel_content_history').fadeOut('fast', function() {
        $('#panel_content_history').addClass('global_hide');
        $('#panel_no_reports').removeClass('global_hide');
        $('#panel_no_reports').css('display', 'flex');
      });
    }
  }

  consultarHistorialChat()
  .then(function(data) {
    data = JSON.parse(data);
    if (data === 0) {
      $('#panel_content_history').addClass('global_hide');
      $('#panel_content_history_clean').removeClass('global_hide');
    } else {
      HistorialChat = data;
      ImprimirHistorial(HistorialChat);
    }
  });

  // Imprimir los mensajes de un chat en específico:
  function ImprimirChat(idChat) {
    let Chat = BuscarChat(idChat);
    let controller = Controller.getInstance();
    let mensajesHtml = controller.parseChatMessages(Chat[0].chat, 1, {nombre: Chat[0].nombreUsuario},  {nombre: Chat[0].nombreReceptor});
    $('#clean_section').fadeOut('fast', function() {
      $('#clean_section').addClass('global_hide');
      $('#section_chat').removeClass('global_hide');
      $('.chat-message').addClass('global_hide');
      $('.inline').addClass('global_hide');
      $('#dateChat').removeClass('global_hide');
      $('#dateChat').text(obtenerFecha(Chat[0].fechaHoraInicioChat));
      $('#section_chat').css('display', 'flex');
      $('#img_receptor').attr('src', url + Chat[0].urlFotoReceptor);
      $('#nombre_receptor').text(Chat[0].nombreReceptor);
    });
    $('#chat_history').html(mensajesHtml);
  }

  // Funcion para buscar un chat:
  function BuscarChat(idChat) {
    let chat = HistorialChat.filter(function(Chat) {
      return Number(Chat.idChat) === Number(idChat);
    });
    return chat;
  }

})();

function consultarHistorialChat(){
  return $.ajax({
    url: url + 'ReporteInicial/CtrlChatUsuario/ConsultarChatsReporteInicial',
    type: 'POST',
    data: {
      ajax: true
    }
  });
}

// Generar los minichats:
function ImprimirHistorial(HistorialChat) {
  let html = '';
  HistorialChat.forEach(function(Chat) {
    let ultimoMensaje = ObtenerUltimoMensaje(Chat);
    let fechaInicioChat = obtenerFecha(Chat.fechaHoraInicioChat);
    $('#panel_content_history_clean').addClass('global_hide');
    html += '<a href="#" id='+Chat.idChat+' class="display"><div class="cont_inform n_flex n_nowrap n_grow_up horizontal_padding n_align_center"><div class="n_flex user_img n_align_center"><img src="'+url+''+Chat.urlFotoReceptor+'" alt="" draggable="false" class="history_user_img"></div><div class="content_list_chat n_flex data n_in_columns n_grow_up n_justify_center"><div class="user_data n_flex n_nowrap n_justify_between"><span class="n_flex name_user">'+Chat.nombreReceptor+'</span><span class="n_flex chat_time">'+fechaInicioChat+'</span></div><div class="msg_data suspensive_2"><p class="last_msg paragraph">'+ultimoMensaje+'</p></div></div></div></a>';
  });

  $('div#panel_content_history').fadeOut('fast', function() {
    $('div#panel_content_history').html(html);
  });

  $('div#panel_content_history').fadeIn('fast');

  $('#panel_no_reports').fadeOut('fast', function() {
    $('#panel_content_history').removeClass('global_hide');
    $('#panel_content_history').css('display', 'flex');
    $('#panel_no_reports').addClass('global_hide');
  });
}

function ObtenerUltimoMensaje(Chat) {
  let pos = Chat.chat.length - 1;
  let ultimoMensaje;

  if (pos != -1) {
    ultimoMensaje = Chat.chat[pos].mensaje;
  } else {
    ultimoMensaje = 'No se ha intercambiado ningún mensaje durante este chat';
  }

  return ultimoMensaje;
}
