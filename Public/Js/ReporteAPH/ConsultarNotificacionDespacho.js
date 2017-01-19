


(function($) {

  var server;
  var user;
  var extra = {};
  var keys = {
    consultarMedicos: getRandomKey(),
    consultarParamedicos: getRandomKey()
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
    console.log(data);
    // Dividir la información
    var Emisor = data.emisor;
    var Receptor = data.receptor;
    var Mensaje = data.mensaje;

    // Validar si la información recibida es para este cliente:
    if (Mensaje.type === "MENSAJE" && 'tipo' in Mensaje.data && Mensaje.data.tipo === "NUEVO_DESPACHO") {
      ConsultarNotificacionContarDespacho( Mensaje.data.idDespacho,true);
      ConsultarNotificacionDescripcionDespacho(Mensaje.data.idDespacho,'false');
    }

  }

  var onClose = function() {

  }

  var onError = function() {
    NotificarError();
  }

  $(document).ready(function() {
    var valor = $("#flotante-notify").attr("contador");
    if (valor <= 0) {
      $("#flotante-notify").removeClass("notify-nueva");
    }else{
      $("#flotante-notify").addClass("notify-nueva");
    }
    var confirmacion = localStorage.getItem("ReporteAPH-Confirmacion") || "false";
    var idDespacho = localStorage.getItem("ReporteAPH-idDespachoNotificate") || "0";

    ConsultarNotificacionContarDespacho(idDespacho,false);
    ConsultarNotificacionDescripcionDespacho(idDespacho,confirmacion);

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
  function ConsultarNotificacionContarDespacho(idDespacho,esSocket){
    if (idDespacho>0) {
      $.ajax({
        type:'POST',
        dataType:'json',
        url:url + 'ReporteAPH/ctrlIndex/RecibirNumeroNotificacion/0',
        data:{'idDespacho':idDespacho,'request':'ajax'}
      }).done(function(lista){
         nuevaNotificacion(lista.Numero,true);
        var valor = $("#flotante-notify").attr("contador");

        if (esSocket == false) {
          if (Number(lista.Numero) <= 0) {
             $("#flotante-notify").removeClass("flotante-notify");
          }
        }else {
          $("#flotante-notify").addClass("flotante-notify");
          $("#flotante-notify").attr("contador",lista.Numero);
        }

      }).error(function(err){
        Notificate({
          tipo: 'error',
          titulo: 'Error de Notificación',
          descripcion: 'Error al intentar consultar la cantidad de notificaciones.',
          duracion: 6
        });
      });
    }

  }

  function ConsultarNotificacionDescripcionDespacho(idDespacho,confirmacion){
    localStorage.setItem('ReporteAPH-Confirmacion',confirmacion);
    localStorage.setItem('ReporteAPH-idDespachoNotificate', idDespacho);
    if (idDespacho > 0) {
      $.ajax({
        type:'POST',
        dataType:'json',
        url:url + 'ReporteAPH/ctrlIndex/RecibirDescripcionNotificacion/0',
        data:{'idDespacho':idDespacho,'request':'ajax'}
      }).done(function(lista){
        $.each(lista, function(e,d){
          $('#ContenedorNotifyAPH').append(
            '<a>'+
            '<div class="notificacion-f n-llamada" onclick="AceptarNotificacion('+idDespacho+','+d.idReporteInicial+','+confirmacion+')" >'+
            '<div class="icon-llamada">'+
            '<span class="fa fa-exclamation" style="padding: 0.7em 0.7em !important"></span>'+
            '</div>'+
            '<div class="contenido-notifiN">'+
            '<h5>EMERGENCIA! <span id="spanFecha">'+d.fechaHoraAproximadaEmergencia+'</span></h5>'+
            '<p id="pinformacionInicial">'+
            ''+d.informacionInicial+''+
            '</p>'+
            '<p id="pubicacion"><b>Dirección:</b> '+d.ubicacionIncidente+'</p>'+
            '<p id="pdescripciontipoEvento"><b>Tipos de evento:</b>'+d.descripciontipoevento+'</p>'+
            '</div>'+
            '</div>'+
            '</a>');
          });
        }).error(function(err){
          Notificate({
            tipo: 'error',
            titulo: 'Error de Notificación',
            descripcion: 'Error al intentar consultar la descripción de las emergencias.',
            duracion: 6
          });
        });
    }

    }

     this.AceptarNotificacion=function(idDespacho,idReporteInicial,confirmacion){
      $.ajax({
        type:'POST',
        dataType:'json',
        url: url +'ReporteAPH/ctrlLayoutReporteAPH/ConsultarGeolocalizacion',
        data: {'idDespacho':idDespacho,'confirmacion':confirmacion}
      }).done(function(lgn){
        if (confirmacion != "true") {
          localStorage.clear();
          if (confirmacion != "falses") {
              localStorage.setItem('ReporteAPH-idDespachoNotificate', idDespacho);
          }

          var longitudEmergencia = lgn[0].longitudEmergencia;
          var latitudEmergencia = lgn[0].latitudEmergencia;
          var latitudAmbulancia = lgn[0].latitudAmbulancia;
          var longitudAmbulancia = lgn[0].longitudAmbulancia;
          var Ubicacion = {'longitudEmergencia':longitudEmergencia,'latitudEmergencia':latitudEmergencia,'longitudAmbulancia':longitudAmbulancia,'latitudAmbulancia':latitudAmbulancia};
          var ReporteInicial = {'ubicacion':Ubicacion,'idReporteInicial':idReporteInicial,'IDESTipoEvento':'','PersonalQueAtiende':'','informacion':'','Triage':'','idDespacho':idDespacho,'idAsignacionPersonal':'','Cuidados':[]};
          localStorage.setItem('ReporteAPH-ReporteInicial', JSON.stringify(ReporteInicial));

          location.href =url + 'ReporteAPH/ctrlReporteInicialAPH';
        }

      }).error(function(msm){
        console.log(msm);
      });
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
