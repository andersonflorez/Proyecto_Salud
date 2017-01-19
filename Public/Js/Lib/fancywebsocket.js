// Clase FancyWebSocket: Auxiliar del lado del cliente
var FancyWebSocket = function(url) {

  var callbacks = {};
  var conn;

  this.bind = function(eventName, callback) {
    callbacks[eventName] = callback;
  };

  this.send = function(data) {
    this.conn.send(JSON.stringify(data));
  };

  this.connect = function() {

    // Intentar realizar la conexión con el socket del servidor:
    if (typeof(MozWebSocket) == 'function') {
      this.conn = new MozWebSocket(url);
    }	else {
      this.conn = new WebSocket(url);
    }

    // Evento 'onerror' controlado por callbacks['error']
    this.conn.onerror = function() {
      dispatch('error', null);
    };

    // Evento 'onmessage' controlado por callbacks['message']
    this.conn.onmessage = function(evt) {
      dispatch('message', evt.data);
    };

    // Evento 'onclose' controlado por callbacks['close']
    this.conn.onclose = function() {
      dispatch('close', null);
    };

    // Evento 'onopen' controlado por callbacks['open']
    this.conn.onopen = function() {
      dispatch('open', null);
    };
  };

  this.disconnect = function() {
    this.conn.close();
  };

  var dispatch = function(eventName, data) {
    callbacks[eventName](data);
  };

};

function getWebSocketUrl() {
  return $.ajax({
    url: url + 'Socket/ctrlSocket/getWebSocketUrl',
    type: 'POST',
    data: {
      wsajax: true
    }
  });
}
