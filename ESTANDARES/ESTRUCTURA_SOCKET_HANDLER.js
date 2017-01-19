/*
* La estructura de este archivo ha sido realizada con el fin de
* controlar la conexion con el servidor websocket.
*
* NOTA: La función Server.connect() ha sido llamada dentro de
* la función Conectar() por cuestiones de modularización y orden.
* Si usted necesita establecer la conexión con el servidor websocket
* en un momento determinado (en vez de hacerlo cuando la página
* termine de cargar) simplemente debe hacer uso de esta función, en
* caso contrario, llámela al final del callback de $(document).ready().
*
* También es sumamente importante hacer uso de la función Desconectar()
* cuando el socket no esté siendo usado para no saturar el servidor con
* instancias de cliente.
* Usar la conexión socket sólo en aquellas páginas en las que sea
* realmente requerido hacerlo.
*
* * * * * * * * * * * * * * * IMPORTANTE! * * * * * * * * * * * * * * *
* A continuación realice una copia del siguiente script y úselo en un
* archivo js aparte.
*
* Para poder hacer uso del script es necesario que primero incluya en
* el controlador de su página el archivo 'fancywebsocket.js' que se
* encuentra en el directorio 'Public/Js/Lib', luego incluya el archivo
* que ha creado en base a este script.
*
*/

var Server;
var Usuario;
var config = {
  host: '127.0.0.1',
  port: '12345'
};
var urlSocket = 'ws://' + config.host + ':' + config.port;

// Función para capturar la sesión del cliente actual:
function ConsultarSesion(callback) {
  var URL_AJAX = url + 'Usuarios/ctrlSesion';
  $.ajax({
    url: URL_AJAX,
    type: 'POST',
    data: {ajax: true}
  }).done(function(data) {
    callback(null, JSON.parse(data));
  }).error(function(err) {
    callback(err);
  });
}

// Función para establecer conexión con el servidor:
function Conectar() {
  // Consultar la información de este usuario:
  if (!Usuario) {
    ConsultarSesion(function(err, data) {
      // Si ocurre algún error al consultar la sesión del usuario:
      if (err) {
        // Reemplazar este código y mostrar un mensaje de error agradable a la vista del usuario
        // Revise la consola del navegador para revisar la información del error:
        alert('Error al consultar la información de la sesión del usuario, revise la consola del navegador para ver los detalles del error, este mensaje proviene de la función Conectar() de su archivo Socket');
        console.error(err);
      } else {
        Usuario = data;
        Server.connect();
      }
    });
  } else {
    Server.connect();
  }
}

// Función para finalizar conexión con el servidor:
function Desconectar() {
  Server.disconnect();
}

// Función para enviar información al servidor:
function Enviar(receptor, mensaje) {
  data = {
    emisor: {
      idUsuario: Usuario.ID_USUARIO,
      Nombre: Usuario.NOMBRE,
      Usuario: Usuario.USUARIO,
      tipoUsuario: Usuario.TIPO_USUARIO
    },
    receptor: receptor,
    mensaje: mensaje
  };
  Server.send(data);
}

$(document).ready(function() {

  // Instanciar la clase auxiliar de websockets del lado del cliente:
  Server = new FancyWebSocket(urlSocket);

  // Asignar funciones de control a los eventos del socket:

  // Si ocurre algun error al intentar conectarse al servidor ('err' contiene la información):
  Server.bind('error', function() {
    // ...
  });

  // Cuando el cliente se conecte al servidor:
  Server.bind('open', function() {
    // Notificar nueva conexión al conectarse:
    NotificateNewConnection();
  });

  // Cuando se cierre la conexión con el servidor:
  Server.bind('close', function() {
    // ...
  });

  // Cuando el servidor envíe información al cliente ('data' contiene la información):
  Server.bind('message', function(data) {
    // Recibir la información proveniente del servidor y convertirla a JSON:
    data = JSON.parse(data);

    // Dividir la información
    var Emisor = data.emisor;
    var Receptor = data.receptor;
    var Mensaje = data.mensaje;

    // Validar si la información recibida es para este cliente:
    if (Receptor.tipoUsuario === Usuario.TIPO_USUARIO) {
      // Su código...
    }

  });

});

// Función para armar el cuerpo del mensaje estandarizado:
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

// Función para notificar nueva conexión al servidor:
function NotificateNewConnection() {
  var Data = FormarCuerpoMensaje('SERVIDOR', 'CONEXION');
  // Enviar la información al servidor:
  Enviar(Data.Receptor, Data.Mensaje);
}

// FUNCIONALIDAD PROPIA:
