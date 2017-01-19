<?php
// Prevenir que el servidor se caiga por 'timed out'
// https://www.youtube.com/watch?v=yUjIAnuX0Rw
set_time_limit(0);

// Incluir el script del servidor websocket (El servidor se inicializa al final de este script)
require_once 'PHPWebSocket.php';
require_once 'client.php';
require_once dirname(__DIR__) . '/Config/socket.php';

// wsOnMessage manipula la información proveniente de los clientes:
function wsOnMessage($clientID, $message, $messageLength, $binary) {

  global $Server, $clients;

  // Validar si la información es válida:
  if ($messageLength == 0) {

    $Server->wsClose($clientID);
    return;

  } else {

    // Capturar la información proveniente de un cliente:
    $informacion = json_decode($message);
    $emisor = $informacion->emisor;
    $receptor = $informacion->receptor;
    $mensaje = $informacion->mensaje;

    // VALIDAR TIPO DE MENSAJE
    switch ($mensaje->type) {

      // TIPO CONEXIÓN: PARA AGREGAR A LOS USUARIOS QUE SE CONECTAN AL ARREGLO DE PERSONAS ONLINE
      case 'CONEXION':

      $id = $emisor->idUsuario;

      $usuario_logueado = array_filter($clients, function($client) use($id) {
        return $client->idUsuario == $id;
      });

      if (!count($usuario_logueado) > 0) {

        $client = new Client();
        $client->__SET('Nombre', $emisor->Nombre);
        $client->__SET('tipoUsuario', $emisor->tipoUsuario);
        $client->__SET('idUsuario', $emisor->idUsuario);
        $client->__SET('Usuario', $emisor->Usuario);
        $client->__SET('SocketID', $clientID);

        if ($emisor->tipoUsuario == 'RECEPTOR_INICIAL') {
          $client->__SET('numeroNotificaciones', 0);
        }

        array_push($clients, $client);

        $newClient = array(
          'usuario' => array(
            'Nombre' => $client->__GET('Nombre'),
            'tipoUsuario' => $client->__GET('tipoUsuario'),
            'idUsuario' => $client->__GET('idUsuario'),
            'Usuario' => $client->__GET('Usuario'),
            'SocketID' => $client->__GET('SocketID')
            )
          );

          $nuevaConexion = array(
            'emisor' => array('tipoUsuario' => 'SERVIDOR'),
            'mensaje' => array('type' => 'NUEVA_CONEXION', 'data' => $newClient),
            'receptor' => array()
          );

          foreach ($clients as $user) {

            if ($user->__GET('idUsuario') != $client->__GET('idUsuario')) {
              $Server->wsSend($user->__GET('SocketID'), json_encode($nuevaConexion));
            }

          }

          $Server->log($emisor->Nombre.' SE HA CONECTADO. TIPO DE USUARIO: '.$emisor->tipoUsuario);

        } else {
          $Server->log($emisor->Nombre.' SE HA CONECTADO DESDE OTRA INSTANCIA DE NAVEGADOR');
        }

        break;

        // TIPO NOTIFICACION: PARA IDENTIFICAR LOS SOCKET_ID DE LOS CLIENTES ENVIADOS
        case 'NOTIFICACION':

        if ($emisor->tipoUsuario == 'USUARIO' || $emisor->tipoUsuario == 'ADMINISTRADOR' && $receptor->tipoUsuario == 'RECEPTOR_INICIAL') {

          $receptor_notif = array();
          $min = null;

          for ($i=0; $i < count($clients); $i++) {

            if (strtoupper($clients[$i]->__GET('tipoUsuario')) == "RECEPTOR_INICIAL") {

              $numero_notificaciones = $clients[$i]->__GET('numeroNotificaciones');

              if ($i == 0) {

                $min = $numero_notificaciones;
                array_push($receptor_notif, $clients[$i]);

              } else if ($numero_notificaciones < $min) {

                unset($receptor_notif);
                $receptor_notif = array();
                array_push($receptor_notif, $clients[$i]);
                $min = $numero_notificaciones;

              } else if ($numero_notificaciones == $min) {
                array_push($receptor_notif, $clients[$i]);
              }

            }

          }

          $tamaño = count($receptor_notif);
          $usuario = null;
          $receptorInicial = array();

          if ($tamaño !== 0) {

            if ($tamaño == 1) {
              $usuario = $receptor_notif[0];
            } else {

              $random = array_rand($receptor_notif, 1);
              $usuario = $receptor_notif[$random];

            }

            $receptorInicial = array(
              'nombre' => $usuario->__GET('Nombre'),
              'tipoUsuario' => $usuario->__GET('tipoUsuario'),
              'idUsuario' => $usuario->__GET('idUsuario'),
              'usuario' => $usuario->__GET('Usuario'),
              'socketId' => $usuario->__GET('SocketID')
            );

          } else {
            $receptorInicial['idUsuario'] = 0;
          }

          $respuesta_notificacion = array(
            'emisor' => array('tipoUsuario' => 'SERVIDOR'),
            'mensaje' => array('type' => 'RESPUESTA_NOTIFICACION', 'data' => array(
              'idPeticion' => $receptor->infoReceptor->idPeticion,
              'usuario' => $receptorInicial
            )),
            'receptor' => null
          );

          $Server->wsSend($clientID, json_encode($respuesta_notificacion));

        } else {

          $usuarios = array();
          $infoReceptor = $receptor->infoReceptor;

          if (isset($infoReceptor->idReceptores)) {

            $idReceptores = $infoReceptor->idReceptores;

            // OBTENER LOS SOCKET_ID DE LOS USUARIOS ESPECIFICADOS EN EL ARRAY
            for ($j=0; $j < count($idReceptores); $j++) {
              for ($i=0; $i < count($clients); $i++) {
                if ($clients[$i]->__GET('idUsuario') == $idReceptores[$j]) {

                  $usuario = array(
                    'nombre' => $clients[$i]->__GET('Nombre'),
                    'tipoUsuario' => $clients[$i]->__GET('tipoUsuario'),
                    'idUsuario' => $clients[$i]->__GET('idUsuario'),
                    'usuario' => $clients[$i]->__GET('Usuario'),
                    'socketId' => $clients[$i]->__GET('SocketID')
                  );

                  array_push($usuarios, $usuario);
                  break;
                }
              }
            }

          } else if (isset($infoReceptor->tipoUsuario)) {

            // OBTENER LOS SOCKET_ID DE LOS USUARIOS CON EL TIPO DE USUARIO ESPECIFICADO
            for ($i=0; $i < count($clients); $i++) {
              if ($clients[$i]->__GET('tipoUsuario') == $infoReceptor->tipoUsuario) {

                $usuario = array(
                  'nombre' => $clients[$i]->__GET('Nombre'),
                  'tipoUsuario' => $clients[$i]->__GET('tipoUsuario'),
                  'idUsuario' => $clients[$i]->__GET('idUsuario'),
                  'usuario' => $clients[$i]->__GET('Usuario'),
                  'socketId' => $clients[$i]->__GET('SocketID')
                );

                array_push($usuarios, $usuario);

              }
            }

          }

          $respuesta_notificacion = array(
            'emisor' => array('tipoUsuario' => 'SERVIDOR'),
            'mensaje' => array('type' => 'RESPUESTA_NOTIFICACION', 'data' => array(
              'usuarios' => $usuarios,
              'idPeticion' => $infoReceptor->idPeticion
            )),
            'receptor' => null
          );

          $Server->wsSend($clientID, json_encode($respuesta_notificacion));

        }

        break;

        // TIPO USUARIOS_CONECTADOS: PARA SABER QUIENES ESTAN CONECTADOS:
        case 'USUARIOS_CONECTADOS':

        $usuariosConectados = array();

        for ($i=0; $i < count($clients); $i++) {

          array_push($usuariosConectados, array(
            'Nombre' => $clients[$i]->__GET('Nombre'),
            'tipoUsuario' => $clients[$i]->__GET('tipoUsuario'),
            'idUsuario' => $clients[$i]->__GET('idUsuario'),
            'Usuario' => $clients[$i]->__GET('Usuario'),
            'SocketID' => $clients[$i]->__GET('SocketID')
            )
          );

        }

        $respuesta_notificacion = array(
          'emisor' => array('tipoUsuario' => 'SERVIDOR'),
          'mensaje' => array('type' => 'RESPUESTA_USUARIOS_CONECTADOS', 'data' => array('usuarios' => $usuariosConectados)),
          'receptor' => null
        );

        $Server->wsSend($clientID, json_encode($respuesta_notificacion));

        break;

        // TIPO MENSAJE: PARA ENVIAR UN MENSAJE DE UN CLIENTE A OTRO:
        case 'MENSAJE':

        if (isset($receptor->infoReceptor->idSockets)) {

          $idSockets = $receptor->infoReceptor->idSockets;

          foreach ($idSockets as $idSocket) {
            foreach ($clients as $user) {

              $userSocketID = $user->__GET('SocketID');

              if ($userSocketID === $idSocket) {
                $Server->wsSend($userSocketID, json_encode($informacion));
              }

            }
          }

        }

        break;

      }

    }

  }

  // wsOnOpen manipula la conexión de un cliente:
  function wsOnOpen($clientID) {
    global $Server, $clients;
  }

  // wsOnClose manipula la desconexión de un cliente:
  function wsOnClose($clientID, $status) {

    global $Server, $clients;
    $pos = null;

    for ($i=0; $i < count($clients); $i++) {

      if ($clients[$i]->__GET('SocketID') == $clientID) {
        $pos = $i;
      }

    }

    if (isset($pos)) {

      $desconectado = array(
        'Nombre' => $clients[$pos]->__GET('Nombre'),
        'tipoUsuario' => $clients[$pos]->__GET('tipoUsuario'),
        'idUsuario' => $clients[$pos]->__GET('idUsuario'),
        'Usuario' => $clients[$pos]->__GET('Usuario'),
        'SocketID' => $clients[$pos]->__GET('SocketID')
      );

      $desconexion = array(
        'emisor' => array('tipoUsuario' => 'SERVIDOR'),
        'mensaje' => array('type' => 'DESCONEXION', 'data' => array('usuario' => $desconectado)),
        'receptor' => null
      );

      foreach ($clients as $user) {

        if ($user->__GET('SocketID') != $clientID) {
          $Server->wsSend($user->__GET('SocketID'), json_encode($desconexion));
        }

      }

      $Server->log($clients[$pos]->__GET('Nombre'). " CON ROL '" .$clients[$pos]->__GET('tipoUsuario'). "' SE HA DESCONECTADO");
      array_splice($clients, $pos, 1);

    } else {
      $Server->log("SE HA DESCONECTADO UN CLIENTE");
    }

  }

  // Inicializar el servidor y asignar controladores de eventos:
  $clients = array();
  $Server = new PHPWebSocket();
  $Server->bind('message', 'wsOnMessage');
  $Server->bind('open', 'wsOnOpen');
  $Server->bind('close', 'wsOnClose');
  $Server->wsStartServer(SOCKET_IP, SOCKET_PORT);

  ?>
