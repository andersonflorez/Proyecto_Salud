/**
* Namespace: Controller
* Controlador del chat de reporte inicial
*/

function getPetitionKey() {
  return Math.floor(Math.random() * 1000000);
}

var Controller = {

  // Instancia:
  instance: null,

  // Función getInstance() (Singleton):
  getInstance: function() {
    if (!this.instance) {

      // Operaciones del controlador:
      this.instance = {

        server: null,
        user: null,
        current: { usuario: {} },
        finalizeChatKey: '12071b81bb60f781f9eb9672c5553bf0',

        keys: {
          usuarioExterno: getPetitionKey(),
          despachadorRegistroReporte: getPetitionKey(),
          despachadorRegistroNovedad: getPetitionKey(),
          receptorRegistroReporte: getPetitionKey(),
          receptorRegistroNovedad: getPetitionKey(),
          registroReporte: 'afeed4c20ab3a362543c45aa6d728879',
          registroNovedad: 'cf463942e86208058a847f0512d197fc'
        },

        getSession: function() {
          return $.ajax({
            url: url + 'Usuarios/ctrlSesion',
            type: 'POST',
            data: {ajax: true}
          });
        },

        getMessageFormat: function(role, messageType, message, extra) {
          return {
            receptor: {
              tipoUsuario: role,
              infoReceptor: extra
            },
            mensaje: {
              type: messageType,
              data: message
            }
          };
        },

        send: function(options) {
          let data = {
            emisor: {
              idUsuario: this.user.ID_USUARIO,
              Nombre: this.user.NOMBRE,
              Usuario: this.user.USUARIO,
              tipoUsuario: this.user.TIPO_USUARIO,
              direccionIp: this.user.DIRECCION_IP
            },
            receptor: options.receptor,
            mensaje: options.mensaje
          };
          this.server.send(data);
        },

        validarChatActivo: function(ctrlurl) {
          return $.ajax({
            url: url + ctrlurl,
            type: 'POST',
            data: {ajax: true}
          });
        },

        // Funcion para enviar un mensaje de chat:
        sendChatMessage: function(ctrlurl) {

          let mensaje = $('#txtChat').val().trim();

          if (mensaje) {

            imprimirMensajeChat(this.user.NOMBRE, mensaje, true);
            $('#txtChat').val('');

            RegistrarMensaje(ctrlurl, this.current.idChat, mensaje)
            .then(function(data) {

              if (Number(data) !== 0) {

                let message;
                let extra = {
                  idReceptores: [this.current.usuario.idUsuario]
                };

                if (Number(data) === 1) {
                  message = this.getMessageFormat('USUARIO', 'MENSAJE', mensaje, extra);
                } else if (Number(data) === 2) {
                  message = this.getMessageFormat('RECEPTOR_INICIAL', 'MENSAJE', mensaje, extra);
                }

                this.send(message);

              } else {
                NotificarError();
              }

            }.bind(this));

          }

        },

        // Validacion de control de spam:
        handleSpamOnKeyPress: function(e, ctrlurl) {

          let str = $('#txtChat').val();

          if (e.keyCode === 13) {
            if (isValidWord(str)) {
              this.sendChatMessage(ctrlurl);
            } else if (countNotifications() <= 3) {
              Notificate({
                tipo: 'warning',
                titulo: 'Palabras demasiado largas',
                descripcion: 'El mensaje contiene palabras demasiado largas. No supere los 24 caracteres por palabra'
              });
            }
          } else if (!isValidLength(str)) {
            e.preventDefault();
            if (countNotifications() <= 3) {
              Notificate({
                tipo: 'warning',
                titulo: 'Máxima longitud de caracteres',
                descripcion: 'Solo se permiten 200 caracteres por mensaje'
              });
            }
          }

          if (e.keyCode === 32) {
            if (!isValidWord(str)) {
              e.preventDefault();
              if (countNotifications() <= 3) {
                Notificate({
                  tipo: 'warning',
                  titulo: 'Palabra demasiado larga',
                  descripcion: 'Por control de spam, una palabra no puede sobrepasar los 24 caracteres.'
                });
              }
            }
          }

        },

        // Función para controlar el spam al dar click en el boton enviar;
        handleSpamOnClick: function(ctrlurl) {
          let str = $('#txtChat').val().trim();
          if (isValidWord(str)) {
            this.sendChatMessage(ctrlurl);
          } else if (countNotifications() <= 3) {
            Notificate({
              tipo: 'warning',
              titulo: 'Palabras demasiado largas',
              descripcion: 'El mensaje contiene palabras demasiado largas. No supere los 24 caracteres por palabra'
            });
          }
        },

        // Obtener fecha y hora actual:
        getCurrentTime: function(datetime) {
          let date;
          let curdate;

          if (datetime) {
            date = new Date(datetime);
          } else {
            date = new Date();
          }

          curdate = {
            day: date.getDate(),
            month: date.getMonth() + 1,
            year: date.getFullYear(),
            hour: date.getHours(),
            minutes: date.getMinutes()
          };

          function zeroFill(str, length) {
            return String(str).length < length ? zeroFill('0' + String(str), length) : str;
          }

          function get12FormatHour(hour, minutes) {
            let fHour = {
              hour: zeroFill(hour > 12 ? (hour - 12) : hour, 2),
              format: hour > 12 ? 'PM' : 'AM'
            };
            let fMinutes = zeroFill(minutes, 2);
            return fHour.hour + ':' + fMinutes + ' ' + fHour.format;
          }

          function getFullDate(day, month, year) {
            return zeroFill(day, 2) + '/' + zeroFill(month, 2) + '/' + year;
          }

          return get12FormatHour(curdate.hour, curdate.minutes) + ' - ' + getFullDate(curdate.day, curdate.month, curdate.year);
        },

        printChatNotifications: function(data) {
          let html = '';
          let notifications = data.filter(function(elem) {
            return elem.detalles;
          });
          let cantidad = notifications.length;

          notifications.forEach(function(notification) {
            html += '<li nonsense=' + notification.idChat + ' class="chat_notification n_flex n_nowrap vertical_padding horizontal_padding"><div class="chat_icon n_flex n_align_center right_padding"><span class="fa fa-comments-o"></span></div><div class="notification n_flex n_align_center"><ul class="list"><li class="item n_flex"><h6><span class="text_bold">Usuario: </span>' + notification.detalles.nombre + '</h6></li><li class="item n_flex"><h6><span class="text_bold">Fecha y hora: </span>' + this.getCurrentTime(notification.detalles.fechaHora) + '</h6></li><li class="item n_flex suspensive_2"><h6 class="paragraph"><span class="text_bold">Mensaje: </span>' + notification.detalles.mensaje + '</h6></li></ul></div></li>';
          }.bind(this));
          nuevaNotificacion(cantidad);
          $('#cont-notificaciones-f').html(html);
        },

        // Convertir mensaje de texto saliente en formato HTML para imprimir en el historial:
        parseToMyHtmlMessage: function(msg, datetime) {
          let finalMessage = '<li class="clearfix"><div class="message-data align-right n_flex n_justify_end"><span class="message-data-time">' + this.getCurrentTime(datetime) + '</span> &nbsp; &nbsp;<span class="message-data-name n_flex n_justify_center n_align_center"> ' + msg.user + ' <i class="fa fa-circle\ me"></i></span></div><div class="message my-message float-right">' + msg.message + '</div></li>';

          return finalMessage;
        },

        // Convertir mensaje de texto entrante en formato HTML para imprimir en el historial:
        parseToYourHtmlMessage: function(msg, datetime) {
          let finalMessage = '<li class="clearfix"><div class="message-data n_flex n_nowrap"><span class="message-data-name n_flex n_justify_center n_align_center"><i class="fa fa-circle online"></i>' + msg.user + '</span><span class="message-data-time">' + this.getCurrentTime(datetime) + '</span></div><div class="message other-message float-left">' + msg.message + '</div></li>';

          return finalMessage;
        },

        logMessage: function(node, message, done) {
          $(node).append(message);
          let height = node.scrollHeight;

          $(node)
          .parent()
          .parent()
          .animate({
            scrollTop: height
          }, 200, 'swing', function() {
            if (done) done();
          });
        },

        parseChatMessages: function(messages, type, receptor, usuario) {
          let html = '';
          let last;

          if (messages) {
            messages.forEach(function(message, i) {
              let msg = {};
              msg.type = Number(message.tipo),
              msg.message = message.mensaje,
              msg.user = Number(message.tipo) === 1 ? receptor.nombre : usuario.nombre;
              msg.datetime = message.fechaHora;

              if (Number(message.tipo) === type) {
                html += this.parseToMyHtmlMessage(msg, msg.datetime);
              } else {
                html += this.parseToYourHtmlMessage(msg, msg.datetime);
              }

            }.bind(this));
          }

          return html;
        }

      };
    }
    return this.instance;
  }
};

// FUNCIÓN PARA IMPRIMIR UN MENSAJE ENTRANTE:
function imprimirMensajeChat(nombre, mensaje, propio) {
  let controller = Controller.getInstance();
  let node = document.getElementById('chat_history');
  let mensajeHtml;
  if (propio) {
    mensajeHtml = controller.parseToMyHtmlMessage({user: nombre, message: mensaje});
  } else {
    mensajeHtml = controller.parseToYourHtmlMessage({user: nombre, message: mensaje});
  }
  controller.logMessage(node, mensajeHtml);
}

// FUNCIÓN PARA REGISTRAR UN MENSAJE DE CHAT:
function RegistrarMensaje(ctrlurl, idChat, mensaje) {
  let data = {
    ajax: true,
    idChat: idChat,
    mensaje: mensaje
  };
  return $.ajax({
    url: url + ctrlurl,
    type: 'POST',
    data: data
  });
}

// FUNCIÓN PARA NOTIFICAR ERROR:
function NotificarError() {
  Notificate({
    tipo: 'error',
    titulo: 'Error de conexión',
    descripcion: 'Error al intentar conectarse al servidor, compruebe su conexión a internet y recargue la página',
    duracion: 6
  });
}

function isValidLength(str) {
  return str.length <= 200;
}

function isValidWord(str) {
  let words = str.split(' ').filter(function(word) {
    return word.trim();
  });

  return words.every(function(word) {
    return word.length <= 24;
  });
}

function countNotifications() {
  return $('#notify_container').children().length;
}

$('.button-call').click(function() {
  swal({
    title: '',
    text: 'Esta funcionalidad aun se encuentra en fase de desarrollo',
    confirmButtonText: 'Aceptar'
  });
});
