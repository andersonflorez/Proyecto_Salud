(function($) {

  var connected = false;
  var ctrl = 'ReporteInicial/ctrlChatUsuario/';
  var methods = {
    validarChatActivo: 'ValidarChatActivo',
    consultarReceptorInicial: 'ConsultarReceptorInicial',
    registrarChat: 'RegistrarChat',
    registrarMensaje: 'RegistrarMensaje'
  }

  var controller = Controller.getInstance();
  var keys = {
    first: getPetitionKey(),
    active: getPetitionKey()
  }

  var onOpen = function() {

    $(document).trigger('connected');

    connected = true;

    let data = controller.getMessageFormat('SERVIDOR', 'CONEXION');
    controller.send(data);

    let ajaxurl = ctrl + methods.validarChatActivo;

    controller.validarChatActivo(ajaxurl)
    .then(function(data) {
      data = JSON.parse(data);
      controller.current.idChat = data.idChat;
      if (typeof data === 'number') {
        activarBotonNotificaciones();
      } else {
        $('#clean_section').addClass('global_hide');
        loadChatAnimation()
        .then(function() {
          return ListarChatActivo(data);
        })
        .then(identificarReceptorInicial);
      }
    });
  }

  var onMessage = function(data) {
    // Recibir la información proveniente del servidor y convertirla a JSON:
    data = JSON.parse(data);

    // Dividir la información
    var Emisor = data.emisor;
    var Receptor = data.receptor;
    var Mensaje = data.mensaje;

    // Validar si la información recibida es para este cliente:
    if (Receptor && Receptor.tipoUsuario === controller.user.TIPO_USUARIO && Emisor.tipoUsuario === 'RECEPTOR_INICIAL' && Mensaje.type === 'MENSAJE') {

      if (Mensaje.data === controller.finalizeChatKey) {

        swal({
          title: 'Chat finalizado',
          text: 'El chat ha sido finalizado, puede consultar los mensajes de esta sesión en el historial de chats',
          type: 'info',
          confirmButtonText: 'Aceptar'
        }, function() {
          controller.current = {
            usuario: {}
          };
          $('#section_chat').fadeOut('fast', function() {
            $('#clean_section').removeClass('global_hide');
            $('#clean_section').css('display', 'flex');
            activarBotonNotificaciones();
            consultarHistorialChat()
            .then(function(data) {
              data = JSON.parse(data);
              HistorialChat = data;
              ImprimirHistorial(HistorialChat);
            });
          });
        });

      } else {
        imprimirMensajeChat(Emisor.Nombre, Mensaje.data, false);
      }

    } else if (Emisor.tipoUsuario === 'SERVIDOR' && Mensaje.type === 'RESPUESTA_NOTIFICACION') {

      if (Number(Mensaje.data.idPeticion) === Number(keys.active)) {

        if (Mensaje.data.usuarios) {

          controller.current.usuario = Mensaje.data.usuarios[0];
          stopLoadAnimation();

        } else {

          Notificate({
            titulo: 'Usuario desconectado',
            tipo: 'info',
            descripcion: 'El usuario que ha atendido su emergencia se ha desconectado'
          });

        }

      } else if (Number(Mensaje.data.idPeticion) === Number(keys.first)) {
        if (Number(Mensaje.data.usuario.idUsuario) !== 0) {

          controller.current.usuario = Mensaje.data.usuario;

          ConsultarReceptorInicial(controller.current.usuario.idUsuario)
          .then(CargarDatosReceptor)
          .then(RegistrarChat)
          .then(stopLoadAnimation);
          $('#section_chat').css('display', 'flex !important');

        } else {

          Notificate({
            tipo: 'info',
            titulo: 'No hay personal conectado',
            descripcion: 'En el momento no hay personal para responder su solicitud'
          });

          stopLoadAnimation(null, function() {

            $('#section_chat').addClass('global_hide');
            $('#clean_section').removeClass('global_hide');
            $('#clean_section').css('display', 'flex');
            $('.close_history_chat').css('display', 'flex');

          });

        }
      }
    } else if (Mensaje.type === 'NUEVA_CONEXION' && Emisor.tipoUsuario === 'SERVIDOR') {
      console.log(Mensaje);
    }
  }

  var onClose = function() {
    if (connected) {
      connected = false;

      $('#emergency_container').addClass('global_hide');
      $('#connection_error').removeClass('global_hide');
      $('#section_chat').addClass('global_hide');
      $('#clean_section').removeClass('global_hide');

      swal({
        title: "Error de conexión",
        text: "Se ha perdido la conexión con el servidor, revise su conexión a internet, si este no es el caso, puede que el servidor no se encuentre en funcionamiento",
        type: "error",
        confirmButtonText: 'Reintentar conexión',
        closeOnConfirm: false,
        showLoaderOnConfirm: true
      }, function() {

        setTimeout(connect, 2000);

        $(document).bind('connected', function() {

          $('#connection_error').addClass('global_hide');
          $('#emergency_container').removeClass('global_hide');

          swal({
            title: 'Conexión establecida',
            type: 'success',
            confirmButtonText: 'Aceptar'
          });
        });
      });
    }
  }

  var onError = function() {
    connected = false;
    retryConnection();
  }

  function connect() {
    getWebSocketUrl()
    .then(function(strUrlSocket) {

      let jsonUrlSocket = JSON.parse(strUrlSocket);
      let urlSocket = 'ws://' + jsonUrlSocket.socketIP + ':' + jsonUrlSocket.socketPort;

      controller.server = new FancyWebSocket(urlSocket);
      controller.server.bind('open', onOpen);
      controller.server.bind('message', onMessage);
      controller.server.bind('close', onClose);
      controller.server.bind('error', onError);
      return;

    })
    .then(controller.getSession)
    .then(function(session) {

      controller.user = JSON.parse(session);
      if (controller.user.TIPO_USUARIO === "ADMINISTRADOR") {
        controller.user.TIPO_USUARIO === "USUARIO";
      }
      controller.server.connect();

    });
  }

  $(document).ready(function() {

    connect();

    $('#connection_error').click(function() {
      retryConnection();
    });

    let ctrlurl = ctrl + methods.registrarMensaje;

    // ENVIAR UN MENSAJE DE CHAT:
    $('#txtChat').keypress(function(e) {
      controller.handleSpamOnKeyPress(e, ctrlurl);
    });

    $('#btnSendMessage').click(function() {
      controller.handleSpamOnClick(ctrlurl);
    });

    // EVENTO CLICK EN EL BOTÓN PARA REPORTAR UNA EMERGENCIA:
    $('.emergency_container').on('click', '.emergency', function() {

      swal({
        title: "Advertencia",
        text: "Señor usuario, por favor tenga en cuenta que el uso inadecuado del sistema de información puede recurrir en sanciones",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Continuar',
        cancelButtonText: 'Cancelar'
      }, function() {
        $('#clean_section').fadeOut('fast', function() {
          loadChatAnimation()
          .then(asignarReceptor)
          .then(stopLoadAnimation);
        });
      });

    });

  });

  // FUNCIÓN PARA CONSULTAR LA INFORMACIÓN DEL RECEPTOR INICIAL:
  function ConsultarReceptorInicial(idReceptor) {
    return $.ajax({
      url: url + ctrl + methods.consultarReceptorInicial,
      type: 'POST',
      data: {ajax: true, idReceptorInicial: idReceptor}
    });
  }

  // FUNCIÓN PARA CARGAR LOS DATOS DEL RECEPTOR:
  function CargarDatosReceptor(receptor) {
    receptor = JSON.parse(receptor);
    $('#img_receptor').attr('src', url + receptor.urlFoto);
    $('#nombre_receptor').text(receptor.nombre);
    return receptor.idUsuario;
  }

  // FUNCIÓN PARA REGISTRAR CHAT:
  function RegistrarChat(idReceptor) {
    let data = {
      ajax: true,
      idReceptorInicial: idReceptor,
      idUsuarioExterno: controller.user.ID_USUARIO
    };
    return $.ajax({
      url: url + ctrl + methods.registrarChat,
      type: 'POST',
      data: data
    });
  }

  // INICIAR LA ANIMACIÓN DE CARGA
  function loadChatAnimation() {
    return new Promise(function(done) {
      $('#chat_history').html('');
      $('#clean_section').addClass('global_hide');
      $('#section_load').removeClass('section_load');
      $('#section_load').addClass('n_flex');
      done();
    });
  }

  // FUNCIÓN PARA DETENER LA ANIMACIÓN DE CARGA:
  function stopLoadAnimation(idChat, callback) {
    if (idChat) {
      controller.current.idChat = idChat;
    }
    $('#section_load').fadeOut('fast', function() {
      $('#section_chat').removeClass('global_hide');
      $('#section_chat').removeAttr('style');
      $('.chat-message').removeClass('global_hide');
      $('.inline').removeClass('global_hide');
      $('#dateChat').addClass('global_hide');
      $('.close_history_chat').addClass('global_hide');
      $('.close_history_chat').css('style', '');


      if (callback && typeof callback === 'function') {
        callback();
      }
    });
  }

  function identificarReceptorInicial(receptor) {

    let data = controller.getMessageFormat('SERVIDOR', 'NOTIFICACION', null, receptor);
    controller.send(data);

  }

  function activarBotonNotificaciones() {

    $('#emergency').removeClass('emergency_disabled')
    .addClass('emergency');

  }

  function ListarChatActivo(data) {

    let receptor = data.receptorInicial;
    let usuario = data.usuarioExterno;
    controller.current.usuario.idUsuario = receptor.idUsuario;
    let node = document.getElementById('chat_history');
    let html = controller.parseChatMessages(data.mensajes, 2, receptor, usuario);
    controller.logMessage(node, html, function() {
      setTimeout(function() {
        height = node.scrollHeight;
        $(node).parent().parent().scrollTop(height);
      }, 50);
    });

    $('#img_receptor').attr('src', url + receptor.urlFoto);
    $('#nombre_receptor').text(receptor.nombre);

    return {
      idPeticion: keys.active,
      idReceptores: [Number(receptor.idUsuario)]
    };

  }

  // FUNCIÓN PARA IDENTIFICAR EL RECEPTOR QUE ATENDERÁ LA EMERGENCIA REPORTADA:
  this.asignarReceptor = function() {
    let opt = { idPeticion: keys.first };
    let data = controller.getMessageFormat('RECEPTOR_INICIAL', 'NOTIFICACION', null, opt);
    controller.send(data);
  };

  // VALIDAR CHAT ACTIVO:
  this.validarChatActivo = function() {
    return 'idChat' in controller.current && controller.current.idChat && Number(controller.current.idChat) > 0;
  };

  function retryConnection() {

    $('#emergency_container').addClass('global_hide');
    $('#connection_error').removeClass('global_hide');

    swal({
      title: "Error de conexión",
      text: "Ha ocurrido un error al momento de conectarse al servidor, puede que el servidor no se encuentre en funcionamiento o su conexión a internet está fallando",
      type: "error",
      confirmButtonText: 'Reintentar conexión',
      showCancelButton: true,
      cancelButtonText: 'Salir',
      closeOnConfirm: false,
      showLoaderOnConfirm: true
    }, function() {
      setTimeout(connect, 2000);
      $(document).bind('connected', function() {
        $('#emergency_container').removeClass('global_hide');
        $('#connection_error').addClass('global_hide');
        swal({
          title: 'Conexión establecida',
          type: 'success',
          confirmButtonText: 'Aceptar'
        });
      });
    });
  }

})(jQuery,this);
