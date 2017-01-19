(function($) {

  var server;
  var user;
  var connected;
  var extra = {};
  var constant = {};
  var keys = {
    consultarUsuarios: getRandomKey(),
    consultarMedicos: getRandomKey(),
    consultarParamedicos: getRandomKey()
  };

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
    connected = true;
    $(document).trigger('connected');

  }

  var onMessage = function(data) {
    // Recibir la información proveniente del servidor y convertirla a JSON:
    data = JSON.parse(data);
    // Dividir la información
    var Emisor = data.emisor;
    var Receptor = data.receptor;
    var Mensaje = data.mensaje;

    if (Mensaje.type === 'MENSAJE') {

      let decode = JSON.parse(Mensaje.data);

      if (decode.idReporte) {
        if (decode.tipo && decode.tipo === 'afeed4c20ab3a362543c45aa6d728879') {
          // Notificación de registro de reporte inicial:

          Notificate({
            tipo: 'info',
            titulo: 'Nuevo reporte de emergencia',
            descripcion: 'El reporte ' + decode.idReporte + ' ha sido registrado',
            duracion: 8
          });

          paginadorReportesActivos();
        } else if (decode.tipo && decode.tipo === 'cf463942e86208058a847f0512d197fc') {
          // Notificacion de registro de novedad:

          Notificate({
            tipo: 'info',
            titulo: 'Se ha registrado una novedad',
            descripcion: 'Se ha registrado una novedad al reporte ' + decode.idReporte,
            duracion: 8
          });

          ListarNovedad();
          paginadorReportesActivos();

        }
      }

    } else if (Emisor.tipoUsuario === 'SERVIDOR' && Mensaje.type === 'RESPUESTA_NOTIFICACION') {

      if (Number(Mensaje.data.idPeticion) === Number(keys.consultarUsuarios)) {

        let usuarios = Mensaje.data.usuarios.map(function(usuario) {
          return usuario.idUsuario;
        });

        extra.idReceptores = usuarios;
        enviarDespacho(extra);

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
          type: 'success',
          confirmButtonText: 'Aceptar'
        });
      });

    });
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
      user.TIPO_USUARIO = 'DESPACHADOR';
      server.connect();
    });

  });

  function send(options) {
    let data = {
      emisor: {
        idUsuario: user.ID_USUARIO,
        Nombre: user.NOMBRE,
        Usuario: user.USUARIO,
        tipoUsuario: user.TIPO_USUARIO,
        direccionIp: user.DIRECCION_IP
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

  // LA SIGUIENTE FUNCIÓN PERMITE ENVIAR UNA NOTIFICACIÓN A LOS DESPACHADORES DE AMBULANCIA, NOTIFICANDO QUE SE HA REGISTRADO UN REPORTE
  this.consultarPersonalReporteAph = function(objetoDespacho) {
    constant.idDespacho = objetoDespacho.idDespacho;
    extra.idPeticion = keys.consultarUsuarios;
    extra.idReceptores = objetoDespacho.idReceptores; // ARRAY PARAMETRO
    let data = getMessageFormat('SERVIDOR', 'NOTIFICACION', null, extra);

    send(data);
  }

  function enviarDespacho(extra) {

    let mensaje = {};
    mensaje.tipo = 'NUEVO_DESPACHO';
    mensaje.idDespacho = constant.idDespacho;
    JSON.stringify(mensaje);

    let data = getMessageFormat(null, 'MENSAJE', mensaje, extra);
    console.log('abc', data);
    send(data);
  }

})(jQuery, this);
