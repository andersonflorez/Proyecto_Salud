(function($) {

  var server;
  var user;
  var extra = {};
  var keys = {
    consultarMedicos: getRandomKey(),
    consultarParamedico: getRandomKey()
  }

  function getRandomKey() {
    return Math.floor(Math.random() * 1000000);
  }

  var getSession = function() {
    return $.ajax({
      url: url + 'Usuarios/ctrlSesion',
      type: 'POST',
      data: {ajax: true}
    });
  };

  var onOpen = function() {

    let data = getMessageFormat('SERVIDOR', 'CONEXION');
    send(data);

  }

  var onMessage = function(data) {
    // Recibir la información proveniente del servidor y convertirla a JSON:
    data = JSON.parse(data);
    // Dividir la información
    var Emisor = data.emisor;
    var Receptor = data.receptor;
    var Mensaje = data.mensaje;
    // Validar si la información recibida es para este cliente:
    if (Emisor.tipoUsuario === "SERVIDOR" && Mensaje.type === "RESPUESTA_NOTIFICACION") {
      console.log("R",Mensaje);
      if (Number(Mensaje.data.idPeticion) === Number(keys.consultarMedicos)) {

        let infoExtra = {
          idReceptores: Mensaje.data.usuarios.map(function(medico) {
            return medico.idUsuario;
          })
        }

        console.log(infoExtra);

        //enviamos la notificacion al medico que identifico

        EnviarAutorizacion(infoExtra);
      } else if (Number(Mensaje.data.idPeticion) === Number(keys.consultarParamedico)) {

        let infoExtra = {
          idReceptores: Mensaje.data.usuarios.map(function(medico) {
            return medico.idUsuario;
          })
        }
        EnviarRespuestaAutorizacion(infoExtra);

      }

    } else if (Mensaje.type === "MENSAJE") {
      if (Mensaje.data === "RESPUESTA_AUTORIZACION") {
        crearNotificacion();
      } else if (Mensaje.data === "AUTORIZACION") {
        extra.idReceptores = [Emisor.idUsuario];
        crearNotificacion(Emisor.idUsuario);
      }

    }
  }

  var onClose = function() {

  }

  var onError = function() {
    NotificarError();
  }

  $(document).ready(function() {
    getWebSocketUrl()
    .then(function(strUrlSocket) {

      let jsonUrlSocket = JSON.parse(strUrlSocket);
      let urlSocket = 'ws://' + jsonUrlSocket.socketIP + ':' + jsonUrlSocket.socketPort;

      server = new FancyWebSocket(urlSocket);
      server.bind('open', onOpen);
      server.bind('message', onMessage);
      server.bind('close', onClose);
      server.bind('error', onError);
      return;

    })
    .then(getSession)
    .then(function(session) {
      user = JSON.parse(session);
      server.connect();
    });

  });

  function send(options) {
    let data = {
      emisor: {
        idUsuario: user.ID_USUARIO,
        Nombre: user.NOMBRE,
        Usuario: user.USUARIO,
        tipoUsuario: user.TIPO_USUARIO
      },
      receptor: options.receptor,
      mensaje: options.mensaje
    };
    server.send(data);
  }

  function getMessageFormat(role, messageType, message, extra) {
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
  }

  // FUNCIONALIDAD PROPIA:
  this.ConsultarMedicos = function() {
    extra.tipoUsuario = 'CONTROL_MEDICO';
    extra.idPeticion = keys.consultarMedicos;
    let data = getMessageFormat("SERVIDOR", "NOTIFICACION", null, extra);
    send(data);
  }

  function EnviarAutorizacion(extra) {
    let data = getMessageFormat("MEDICO", "MENSAJE", "AUTORIZACION", extra);
    send(data);
  }

  // FUNCIONALIDAD PROPIA:
  this.ConsultarParamedico = function() {
    extra.idPeticion = keys.consultarParamedico;
    let data = getMessageFormat("SERVIDOR", "NOTIFICACION", null, extra);
    send(data);
  }

  function EnviarRespuestaAutorizacion(extra){
    let data = getMessageFormat("PARAMEDICO", "MENSAJE", "RESPUESTA_AUTORIZACION", extra);
    send(data);
  }

  function NotificarError() {
    Notificate({
      tipo: 'error',
      titulo: 'Error de conexión',
      descripcion: 'Error al intentar conectarse al servidor, compruebe su conexión a internet y recargue la página',
      duracion: 6
    });
  }

})(jQuery, this);
