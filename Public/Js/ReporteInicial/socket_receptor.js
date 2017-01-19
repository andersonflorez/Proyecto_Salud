(function($) {

  var connected = false;
  var ctrl = 'ReporteInicial/ctrlRegistrarReporteInicial/';
  var methods = {
    validarChatActivoReceptor: 'ValidarChatActivoReceptor',
    registrarMensaje: 'RegistrarMensaje',
    consultarChatNotificacion: 'ConsultarChatNotificacion',
    consultarNotificacionesChat: 'ConsultarNotificacionesChat'
  }

  var controller = Controller.getInstance();

  var onOpen = function() {

    $(document).trigger('connected');

    connected = true;

    let data = controller.getMessageFormat('SERVIDOR', 'CONEXION');
    controller.send(data);

    let ajaxurl = ctrl + methods.validarChatActivoReceptor;

    controller.validarChatActivo(ajaxurl)
    .then(function(data) {

      data = JSON.parse(data);

      if (typeof data === 'number') {
        return;
      } else {

        return new Promise(function(done) {
          controller.current.idChat = data.idChat;
          done(data);
        })
        .then(IniciarAnimacionCarga)
        .then(CargarDatosUsuario)
        .then(CargarDatosChat)
        .then(SolicitarSocketId)
        .then(FinalizarAnimacionCarga);

      }

    })
    .then(ConsultarNotificacionesChat)
    .then(function(data) {

      data = JSON.parse(data);

      if (Number(data) === 0) {
        MostrarPanelSinNotificaciones();
        nuevaNotificacion(0);
      } else {
        controller.printChatNotifications(data);
      }

    });
  }

  var onMessage = function(data) {
    // Recibir la información proveniente del servidor y convertirla a JSON:
    data = JSON.parse(data);

    // Dividir la información
    let Emisor = data.emisor;
    let Receptor = data.receptor;
    let Mensaje = data.mensaje;

    // Validar si la información recibida es para este cliente:
    if (Emisor.tipoUsuario === 'SERVIDOR' && Mensaje.type === 'RESPUESTA_NOTIFICACION') {

      let idPeticion = Mensaje.data.idPeticion;

      if (idPeticion === controller.keys.usuarioExterno) {

        if (Mensaje.data.usuarios.length > 0) {

          controller.current.usuario = Mensaje.data.usuarios[0];

        } else {

          Notificate({
            tipo: 'info',
            titulo: 'Usuario desconectado',
            descripcion: 'El usuario ' + controller.current.usuario.nombre + ' se ha desconectado',
            duracion: 10
          });

        }

      } else if (idPeticion === controller.keys.despachadorRegistroReporte) {

        let users = Mensaje.data.usuarios;
        let role = 'DESPACHADOR';
        let messageKey = controller.keys.registroReporte;
        EnviarNotificacion(users, role, messageKey);

      } else if (idPeticion === controller.keys.receptorRegistroReporte) {

        let users = Mensaje.data.usuarios;
        let role = 'RECEPTOR_INICIAL';
        let messageKey = controller.keys.registroReporte;
        EnviarNotificacion(users, role, messageKey);

      } else if (idPeticion === controller.keys.despachadorRegistroNovedad) {

        let users = Mensaje.data.usuarios;
        let role = 'DESPACHADOR';
        let messageKey = controller.keys.registroNovedad;
        EnviarNotificacion(users, role, messageKey);

      } else if (idPeticion === controller.keys.receptorRegistroNovedad) {

        let users = Mensaje.data.usuarios;
        let role = 'RECEPTOR_INICIAL';
        let messageKey = controller.keys.registroNovedad;
        EnviarNotificacion(users, role, messageKey);

      }

    } else if (Mensaje.type === 'MENSAJE' && Receptor.tipoUsuario === controller.user.TIPO_USUARIO) {

      if (Emisor.tipoUsuario === 'USUARIO') {
        if (Number(controller.current.usuario.idUsuario) === Number(Emisor.idUsuario)) {
          imprimirMensajeChat(Emisor.Nombre, Mensaje.data, false);
        }

        ConsultarNotificacionesChat()
        .then(function(data) {

          data = JSON.parse(data);

          if (Number(data) === 0) {
            MostrarPanelSinNotificaciones();
            nuevaNotificacion(0);
          } else {
            controller.printChatNotifications(data);
          }

        });
      } else if (Emisor.tipoUsuario === 'RECEPTOR_INICIAL') {
        console.log(Mensaje);
      }

    } else if (Emisor.tipoUsuario === 'SERVIDOR' && Mensaje.type === 'DESCONEXION') {

      if (controller.current.usuario && Mensaje.data.usuario.idUsuario) {
        if (Mensaje.data.usuario.idUsuario === controller.current.usuario.idUsuario) {

          let disconnecting = setTimeout(function() {
            swal({
              title: 'Usuario desconectado',
              text: 'Se ha perdido la conexión con ' + controller.current.usuario.nombre + ' debido a que se ha desconectado durante más de 30 segundos. El chat ha sido finalizado, sin embargo puede continuar con el registro del reporte o cancelarlo si así lo considera',
              type: 'warning',
              confirmButtonText: 'Aceptar'
            });
          }, 30000);

          $(document).bind('reconnection', function() {
            clearTimeout(disconnecting);
          });
        }
      }

    } else if (Emisor.tipoUsuario === 'SERVIDOR' && Mensaje.type === 'NUEVA_CONEXION') {

      if (controller.current.usuario && Mensaje.data.usuario.idUsuario) {
        if (Number(Mensaje.data.usuario.idUsuario) === Number(controller.current.usuario.idUsuario)) {
          $(document).trigger('reconnection');
        }
      }

    } else if (Emisor.tipoUsuario === 'SERVIDOR' && Mensaje.type === 'NUEVA_INSTANCIA') {

      if (controller.user.DIRECCION_IP !== Mensaje.data.direccionIp) {
        swal({
          title: 'Advertencia',
          text: 'Esta cuenta ya se encuentra activa en otro dispositivo. Si no es usted quien la ha iniciado puede restablecer su contraseña para evitar accesos no autorizados'
        }, function() {
          $('#flotante-notify').removeAttr('id');
          OcultarPaneles();
          window.location.href = url + '/Home/ctrlPrincipal';
        });
      } else {
        // if (!localStorage.connected) {
        //   localStorage.connected = true;
        // } else {
        //   swal({
        //     title: 'Advertencia',
        //     text: 'Esta cuenta ya se encuentra activa en otra ventana del navegador'
        //   }, function() {
        //     $('#flotante-notify').removeAttr('id');
        //     OcultarPaneles();
        //     window.location.href = url + '/Home/ctrlPrincipal';
        //   });
        // }
      }

    }
  }

  var onClose = function() {
    if (connected) {
      connected = false;
      swal({
        title: 'Conexión perdida',
        text: "Se ha perdido la conexión con el servidor, revise su conexión a internet, si este no es el caso, puede que el servidor no se encuentre en funcionamiento",
        type: "error",
        confirmButtonText: 'Reintentar conexión',
        closeOnConfirm: false,
        showLoaderOnConfirm: true
      }, function() {
        setTimeout(connect, 2000);
        $(document).bind('connected', function() {
          swal({
            title: 'Conexión establecida',
            text: 'La conexión con el servidor se ha restablecido correctamente',
            type: 'success',
            confirmButtonText: 'Aceptar'
          });
        });
      });
    }
  }

  var onError = function() {
    connected = false;
    swal({
      title: "Error de conexión",
      text: "Ha ocurrido un error al momento de conectarse al servidor, puede que el servidor no se encuentre en funcionamiento o su conexión a internet está fallando",
      type: "error",
      confirmButtonText: 'Reintentar conexión',
      cancelButtonText: 'Salir',
      showCancelButton: true,
      closeOnConfirm: false,
      showLoaderOnConfirm: true
    }, function() {
      setTimeout(connect, 2000);
      $(document).bind('connected', function() {
        swal({
          title: 'Conexión establecida',
          text: 'La conexión con el servidor se ha restablecido correctamente',
          type: 'success',
          confirmButtonText: 'Aceptar'
        });
      });
    });
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
        controller.user.TIPO_USUARIO = "RECEPTOR_INICIAL";
      }
      console.log(controller.user);
      controller.server.connect();

    });
  }

  $(document).ready(function() {

    connect();

    let ctrlurl = ctrl + methods.registrarMensaje;

    $('#txtChat').keypress(function(e) {
      controller.handleSpamOnKeyPress(e, ctrlurl);
    });

    $('#btnSendMessage').click(function() {
      controller.handleSpamOnClick(ctrlurl);
    });

    $('ul#cont-notificaciones-f').on('click', 'li.chat_notification', function() {

      let newChat = $(this);

      CerrarMenuNotificaciones()
      .then(function() {
        let idChat = Number(newChat.attr('nonsense'));
        controller.current.idChat = idChat;
        newChat.remove();
        return idChat;
      })
      .then(IniciarAnimacionCarga)
      .then(ConsultarChatNotificacion)
      .then(CargarDatosUsuario)
      .then(CargarDatosChat)
      .then(SolicitarSocketId)
      .then(FinalizarAnimacionCarga)
      .then(ConsultarNotificacionesChat)
      .then(function(data) {

        data = JSON.parse(data);

        if (Number(data) === 0) {
          MostrarPanelSinNotificaciones();
          nuevaNotificacion(0);
        } else {
          controller.printChatNotifications(data);
        }

      });

    });

    ValidateForm('formReporteInicial', function(formdata) {
      if ( formdata.slcEnteExterno === null || formdata.slcTipoEvento === null ) {
        Notificate({
          titulo: 'Campos vacios',
          descripcion: 'Algunos campos obligatorios se encuentran vacios',
          tipo: 'error',
          duracion: 5
        });
      } else {
        formdata.ajax = true;
        formdata.idChat = controller.current.idChat;
        var peticion = RegistrarReporte(formdata);
        peticion.then(doneRegistroReporte, fail);
      }
    });

    // REGISTRAR NOVEDADES A REPORTE INICIAL
    ValidateForm('formNovedad',function(formdata) {
      formdata.idReporte = Number(localStorage['idReporte']);
      formdata.ajax = true;
      var datosNovedad = RegistrarNovedad(formdata);
      datosNovedad.then(doneNovedad, failNovedad);
    });

    // CANCELAR REPORTE INICIAL
    $('#btnCancelarReporte').click(function() {
      CancelarReporte();
    });

    function CancelarReporte() {
      swal({
        title: 'Cancelar reporte',
        text: '¿Por qué se cancelará el reporte?',
        type: 'input',
        showCancelButton: true,
        closeOnConfirm: false,
        confirmButtonText: 'Cancelar reporte',
        cancelButtonText: 'Salir',
        animation: 'slide-from-top',
        inputPlaceholder: 'Descripción (No mayor a 200 caracteres)'
      },
      function(inputValue) {

        if (inputValue === false) {
          return false;
        } else if (inputValue === '') {
          swal.showInputError('Por favor ingrese una descripción!');
          return false;
        } else {
          inputValue = inputValue.trim();
          if (inputValue.length > 200) {
            swal.showInputError('La descripción no puede superar los 200 caracteres');
            return false;
          } else {
            let words = inputValue.split(' ');
            words = words.filter(function(word) {
              return word.trim();
            });

            let valid = words.every(function(word) {
              return word.length <= 24;
            });

            if (valid) {
              var url = "ReporteInicial/ctrlRegistrarReporteInicial/CancelarReporte";
              var data = {
                ajax: true,
                descripcion: inputValue,
                idChat: controller.current.idChat
              }
              DoPostAjax({url: url, data: data}, function(err, data) {
                if (err) {
                  swal('Ha ocurrido un error!', 'Ha ocurrido un error inesperado al momento de cancelar el reporte, compruebe su conexión a internet o recargue la página e intentelo nuevamente, si sigue teniendo problemas contacte con un técnico', 'error');
                } else if (data) {
                  swal('Reporte cancelado!', 'El reporte ha sido cancelado satisfactoriamente', 'success');
                  CambiarEstadoReporte();
                } else {
                  swal('Ha ocurrido un error!', 'Ha ocurrido un error inesperado al momento de cancelar el reporte, compruebe su conexión a internet o recargue la página e intentelo nuevamente, si sigue teniendo problemas contacte con un técnico', 'error');
                }
              });
            } else {
              swal.showInputError('La descripción contiene palabras muy largas');
              if (countNotifications() <= 3) {
                Notificate({
                  tipo: 'warning',
                  titulo: 'Palabras demasiado largas',
                  descripcion: 'Por favor ingrese palabras que no superen los 24 caracteres',
                  duracion: 6
                });
              }
              return false;
            }
          }
        }
      });
    }

    $('#btnFinalizarReporte').click(function(){
      FinalizarReporte();
    });

    // Finalizar reporte
    function FinalizarReporte() {
      swal({
        title: "Finalizar reporte",
        text: "¿Esta seguro de finalizar el registro de este reporte?",
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "Salir",
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, finalizar ahora",
        closeOnConfirm: false
      }, function(rspButton) {
        if(rspButton == true) {
          CambiarEstadoReporte();
        }
      });
    }

    // CAMBIAR ESTADO DEL REPORTE REPORTE (Finalizarlo)
    function CambiarEstadoReporte() {
      let url_ajax = url + 'ReporteInicial/CtrlRegistrarReporteInicial/FinalizarReporte';
      return $.ajax({
        url: url_ajax,
        type: 'POST',
        data: {
          ajax: true,
          idUsuarioE: controller.current.usuario.idUsuario,
          confirm: true
        }
      }).done(function(rsp) {
        if(Number(rsp) == 1){
          swal("Finalizado", "El reporte ha sido finalizado satisfactoriamente.", "success");
          NotificarCierreChat();
          OcultarPaneles();
          localStorage.visibleForm = Number(0);
          localStorage.idReporte = null;
        }
      }).fail(function() {
        swal('Ha ocurrido un error!', 'Ha ocurrido un error inesperado al momento de finalizar el reporte, compruebe su conexión a internet o recargue la página e intentelo nuevamente, si sigue teniendo problemas contacte con un técnico', 'error');
      });
    }

  });

  // FUNCIONES DE VALIDACIÓN:

  function doneRegistroReporte(data) {
    if (data) {
      // Alert registro correcto
      Notificate({
        titulo: 'Reporte registrado!',
        descripcion: 'Reporte enviado correctamente',
        tipo: 'success',
        duracion: 4
      });

      // Obtener idReporte Inicial
      data = JSON.parse(data);
      localStorage.idReporte = Number(data.idReporte);

      let key = {
        despachador: controller.keys.despachadorRegistroReporte,
        receptor: controller.keys.receptorRegistroReporte
      }

      identificarDestinatarios(key);

      // Habilitar formulario novedades
      LimpiarCampos('formReporteInicial');
      HabilitarNovedad();
      consultaReportes();
      $('.reports').removeClass('panel-reports');
    }
  }

  function doneNovedad(rsp) {
    if(Number(rsp) === 1) {

      let key = {
        despachador: controller.keys.despachadorRegistroNovedad,
        receptor: controller.keys.receptorRegistroNovedad
      }

      identificarDestinatarios(key);

      Notificate({
        titulo: 'Novedad registrada',
        descripcion: 'La novedad se ha registrado correctamente al reporte',
        tipo: 'success',
        duracion: 4
      });
      LimpiarCampos('formNovedad');
    }
  }

  function failNovedad() {
    Notificate({
      titulo: 'Ha ocurrido un error',
      descripcion: 'Error inesperado al registrar la novedad',
      tipo: 'error',
      duracion: 5
    });
  }

  function ConsultarChatNotificacion(idChat) {
    return $.ajax({
      url: url + ctrl + methods.consultarChatNotificacion,
      type: 'POST',
      data: {
        ajax: true,
        idChat: idChat
      }
    });
  }

  function CargarDatosUsuario(data) {

    if (typeof data != 'object') {
      data = JSON.parse(data);
    }

    let usuario = data.usuarioExterno;
    controller.current.usuario.idUsuario = Number(usuario.idUsuario);
    controller.current.usuario.nombre = usuario.nombre;
    let value;

    $('#img_usuario').attr('src', url + usuario.urlFoto);
    $('#nombre_usuario').text(usuario.nombre);

    $('#informacion_usuario .url_foto').attr('src', url + usuario.urlFoto);

    for (var prop in usuario) {
      if (usuario.hasOwnProperty(prop)) {
        value = usuario[prop] ? usuario[prop].trim() : 'Indefinido';
        $('#informacion_usuario .' + prop.toLowerCase()).text(value);
      }
    }

    return data;
  }

  function CargarDatosChat(chat) {
    let receptor = {nombre: controller.user.NOMBRE};
    let html = controller.parseChatMessages(chat.mensajes, 1, receptor, chat.usuarioExterno);
    $('#chat_history').html(html);
    return chat;
  }

  function SolicitarSocketId() {
    let obj = {
      idReceptores: [controller.current.usuario.idUsuario],
      idPeticion: controller.keys.usuarioExterno
    };

    let data = controller.getMessageFormat('SERVIDOR', 'NOTIFICACION', null, obj);
    controller.send(data);
    return;
  }

  function ConsultarNotificacionesChat() {
    return $.ajax({
      url: url + ctrl + methods.consultarNotificacionesChat,
      type: 'POST',
      data: {
        ajax: true,
        idReceptor: controller.user.ID_USUARIO
      }
    });
  }

  function NotificarCierreChat() {
    let receptor = {
      idReceptores: [controller.current.usuario.idUsuario]
    };
    message = controller.getMessageFormat('USUARIO', 'MENSAJE', controller.finalizeChatKey, receptor);
    controller.send(message);
    controller.current = { usuario: {} };
  }

  function NotificarCambiosReporte(data) {

    let destinatario = data.destinatario;
    let mensaje = data.mensaje;

    mensaje = JSON.stringify(mensaje);

    message = controller.getMessageFormat(data.tipoUsuario, 'MENSAJE', mensaje, destinatario);
    controller.send(message);
  }

  function EnviarNotificacion(users, role, messageKey) {
    if (users.length > 0) {

      idDestinatarios = users.map(function(user) {
        return user.idUsuario;
      });

      let properties = {
        destinatario: {
          idReceptores: idDestinatarios,
          tipoUsuario: role
        },
        mensaje: {
          tipo: messageKey,
          idReporte: Number(localStorage.idReporte)
        }
      }

      NotificarCambiosReporte(properties);
    }
  }

  function identificarDestinatarios(key) {

    // Solicitar los id de los usuarios que se encuentren conectados con rol despachador
    let extra = {
      tipoUsuario: 'DESPACHADOR',
      idPeticion: key.despachador
    };

    let data = controller.getMessageFormat('SERVIDOR', 'NOTIFICACION', null, extra);
    controller.send(data);

    // Solicitar los id de los usuarios que se encuentren conectados con rol de receptor inicial
    extra = {
      tipoUsuario: 'RECEPTOR_INICIAL',
      idPeticion: key.receptor
    };

    data = controller.getMessageFormat('SERVIDOR', 'NOTIFICACION', null, extra);
    controller.send(data);

  };

})(jQuery, this);
