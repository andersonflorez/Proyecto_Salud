(function($) {
  var server;
  var user;
  var infoReceptor = {};

  var getSession = function() {
    return $.ajax({
      url: url + 'Usuarios/ctrlSesion',
      type: 'POST',
      data: {ajax: true}
    });
  };

  var onOpen = function() {

    let data = FormarCuerpoMensaje('SERVIDOR', 'CONEXION');
    Enviar(data.Receptor, data.Mensaje);

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
      let infoReceptorTratamiento = {idSockets: Mensaje.data.idSockets};
      //enviamos la notificacion al medico que identifico
      EnviarNotificacionTratamientos(infoReceptorTratamiento);
    } else if (Mensaje.type === "MENSAJE" && Mensaje.data === "AUTORIZACION") {
      infoReceptor.idReceptores = [Emisor.idUsuario];
      crearNotificacion(Emisor.idUsuario);
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

  function Enviar(receptor, mensaje) {
    let data = {
      emisor: {
        idUsuario: user.ID_USUARIO,
        Nombre: user.NOMBRE,
        Usuario: user.USUARIO,
        tipoUsuario: user.TIPO_USUARIO
      },
      receptor: receptor,
      mensaje: mensaje
    };
    server.send(data);
  }

  function FormarCuerpoMensaje(tpUsuario, tpMensaje, Mensaje, infoReceptor) {
    var Data = {
      Receptor: {
        tipoUsuario: tpUsuario,
        infoReceptor: infoReceptor ? infoReceptor : null // Información adicional (opcional) para identificar el receptor
      },
      Mensaje: {
        type: tpMensaje,
        data: Mensaje ? Mensaje : null
      }
    };
    return Data;
  }

  function NotificarError() {
    Notificate({
      tipo: 'error',
      titulo: 'Error de conexión',
      descripcion: 'Error al intentar conectarse al servidor, compruebe su conexión a internet y recargue la página',
      duracion: 6
    });
  }

  // FUNCIONALIDAD PROPIA:
  this.ConsultarParamedicoControlMedico = function() {
    let data = FormarCuerpoMensaje("SERVIDOR", "NOTIFICACION", null, infoReceptor);
    Enviar(data.Receptor, data.Mensaje);
  }

  function EnviarNotificacionTratamientos(infoReceptorTratamiento){
    let data = FormarCuerpoMensaje("PARAMEDICO", "MENSAJE", "RESPUESTA_AUTORIZACION", infoReceptorTratamiento);
    Enviar(data.Receptor, data.Mensaje);
  }

})(jQuery, this);
