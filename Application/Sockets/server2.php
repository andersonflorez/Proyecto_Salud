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

			// TIPO CONEXIÓN: PARA AGREGAR LOS USUARIOS QUE SE CONECTAN AL ARREGLO DE PERSONAS ONLINE
			case 'CONEXION':

			$id = $emisor->idUsuario;

			$usuario_logueado = array_filter($clients, function($client) use($id) {
				return $client->idUsuario == $id;
			});

			if (!count($usuario_logueado) > 0) {

				$firstClientID = array($clientID);

				$client = new Client();
				$client->__SET('Nombre', $emisor->Nombre);
				$client->__SET('tipoUsuario', $emisor->tipoUsuario);
				$client->__SET('idUsuario', $emisor->idUsuario);
				$client->__SET('Usuario', $emisor->Usuario);
				$client->__SET('SocketID', $firstClientID);
				$client->__SET('direccionIp', $emisor->direccionIp);

				if (strtoupper($emisor->tipoUsuario) == 'RECEPTOR_INICIAL') {
					$client->__SET('numeroNotificaciones', 0);
				}

				$clients[intval($client->__GET('idUsuario'))] = $client;

				$newClient = array('usuario' => array(
					'Nombre' => $client->__GET('Nombre'),
					'tipoUsuario' => $client->__GET('tipoUsuario'),
					'idUsuario' => $client->__GET('idUsuario'),
					'Usuario' => $client->__GET('Usuario'),
					'SocketID' => $client->__GET('SocketID'),
					'direccionIp', $client->__GET('direccionIp')
				));

				$nuevaConexion = array(
					'emisor' => array('tipoUsuario' => 'SERVIDOR'),
					'mensaje' => array('type' => 'NUEVA_CONEXION', 'data' => $newClient),
					'receptor' => array()
				);

				foreach ($clients as $userID => $user) {
					if ($userID !== intval($client->__GET('idUsuario'))) {
						foreach ($user->__GET('SocketID') as $curSocket) {
							$Server->wsSend($curSocket, json_encode($nuevaConexion));
						}
					}
				}

				$Server->log($emisor->Nombre.' SE HA CONECTADO. TIPO DE USUARIO: '.$emisor->tipoUsuario);

			} else {

				$client = $clients[intval($emisor->idUsuario)];
				$clientIDs = $client->__GET('SocketID');
				array_push($clientIDs, $clientID);
				$client->__SET('SocketID', $clientIDs);

				$principalIP = array('direccionIp' => $client->__GET('direccionIp'));

				$nuevaInstancia = array(
					'emisor' => array('tipoUsuario' => 'SERVIDOR'),
					'mensaje' => array('type' => 'NUEVA_INSTANCIA', 'data' => $principalIP),
					'receptor' => array()
				);

				$Server->wsSend($clientID, json_encode($nuevaInstancia));

				$Server->log($emisor->Nombre.' SE HA CONECTADO DESDE OTRA INSTANCIA DE NAVEGADOR');
			}

			break;

			// TIPO NOTIFICACION: PARA IDENTIFICAR LOS SOCKET_ID DE LOS CLIENTES ENVIADOS
			case 'NOTIFICACION':

			if (strtoupper($emisor->tipoUsuario) === 'USUARIO' && strtoupper($receptor->tipoUsuario) === 'RECEPTOR_INICIAL') {

				$receptoresIniciales = array_filter($clients, function($client) {
					return strtoupper($client->tipoUsuario) === 'RECEPTOR_INICIAL';
				});

				$selected = array();
				$min = 0;
				$i = 0;

				foreach ($receptoresIniciales as $receptorInicial) {

					$counter = intval($receptorInicial->__GET('numeroNotificaciones'));

					if ($i === 0) {

						$min = $counter;
						array_push($selected, $receptorInicial);

					} else if ($counter < $min) {

						$selected = array($receptorInicial);
						$min = $counter;

					} else if ($counter === $min) {
						array_push($selected, $receptorInicial);
					}

					$i++;

				}

				$length = count($selected);
				$usuario = null;
				$receptorInicial = array();

				if ($length > 0) {

					if ($length === 1) {
						$usuario = $selected[0];
					} else {

						$random = array_rand($selected, 1);
						$usuario = $selected[$random];

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

				$client = $clients[intval($emisor->idUsuario)];
				$clientIDs = $client->__GET('SocketID');

				foreach ($clientIDs as $curClientID) {
					$Server->wsSend($curClientID, json_encode($respuesta_notificacion));
				}

			} else {

				$usuarios = array();
				$infoReceptor = $receptor->infoReceptor;

				if (isset($infoReceptor->idReceptores)) {

					$idReceptores = $infoReceptor->idReceptores;

					// OBTENER LOS SOCKET_ID DE LOS USUARIOS ESPECIFICADOS EN EL ARRAY
					foreach ($idReceptores as $idReceptor) {
						if (isset($clients[intval($idReceptor)])) {
							$client = $clients[intval($idReceptor)];

							$usuario = array(
								'nombre' => $client->__GET('Nombre'),
								'tipoUsuario' => $client->__GET('tipoUsuario'),
								'idUsuario' => $client->__GET('idUsuario'),
								'usuario' => $client->__GET('Usuario'),
								'socketId' => $client->__GET('SocketID')
							);

							array_push($usuarios, $usuario);
						}
					}

				} else if (isset($infoReceptor->tipoUsuario)) {

					$receptores = array_filter($clients, function($client) use($infoReceptor) {
						return strtoupper($client->__GET('tipoUsuario')) === strtoupper($infoReceptor->tipoUsuario);
					});

					// OBTENER LOS SOCKET_ID DE LOS USUARIOS CON EL TIPO DE USUARIO ESPECIFICADO
					foreach ($receptores as $user) {
						$usuario = array(
							'nombre' => $user->__GET('Nombre'),
							'tipoUsuario' => $user->__GET('tipoUsuario'),
							'idUsuario' => $user->__GET('idUsuario'),
							'usuario' => $user->__GET('Usuario'),
							'socketId' => $user->__GET('SocketID')
						);

						array_push($usuarios, $usuario);
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

				$client = $clients[intval($emisor->idUsuario)];
				$clientIDs = $client->__GET('SocketID');

				foreach ($clientIDs as $curClientID) {
					$Server->wsSend($curClientID, json_encode($respuesta_notificacion));
				}

			}

			break;

			// TIPO USUARIOS_CONECTADOS: PARA SABER QUIENES ESTAN CONECTADOS:
			case 'USUARIOS_CONECTADOS':

			$usuariosConectados = array();

			foreach ($clients as $client) {

				array_push($usuariosConectados, array(
					'Nombre' => $client->__GET('Nombre'),
					'tipoUsuario' => $client->__GET('tipoUsuario'),
					'idUsuario' => $client->__GET('idUsuario'),
					'Usuario' => $client->__GET('Usuario'),
					'SocketID' => $client->__GET('SocketID')
					)
				);

			}

			$respuesta_notificacion = array(
				'emisor' => array('tipoUsuario' => 'SERVIDOR'),
				'mensaje' => array('type' => 'RESPUESTA_USUARIOS_CONECTADOS', 'data' => array('usuarios' => $usuariosConectados)),
				'receptor' => null
			);

			$client = $clients[intval($emisor->idUsuario)];
			$clientIDs = $client->__GET('SocketID');

			foreach ($clientIDs as $curClientID) {
				$Server->wsSend($curClientID, json_encode($respuesta_notificacion));
			}

			break;

			// TIPO MENSAJE: PARA ENVIAR UN MENSAJE DE UN CLIENTE A OTRO:
			case 'MENSAJE':

			if (isset($receptor->infoReceptor->idSockets)) {
				$idSockets = $receptor->infoReceptor->idSockets;

				foreach ($idSockets as $idSocket) {
					$Server->wsSend($idSocket, json_encode($informacion));
				}

			} else if (isset($receptor->infoReceptor->idReceptores)) {

				$idReceptores = $receptor->infoReceptor->idReceptores;

				foreach ($idReceptores as $idUsuario) {
					$id = intval($idUsuario);
					if (isset($clients[$id])) {

						$clientIDs = $clients[$id]->__GET('SocketID');

						foreach ($clientIDs as $curClientID) {
							$Server->wsSend($curClientID, json_encode($informacion));
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
	$pos = false;
	$leave = false;

	foreach ($clients as $userID => $client) {

		foreach ($client->__GET('SocketID') as $index => $id) {
			if (intval($clientID) === intval($id)) {

				$clientIDs = $client->__GET('SocketID');
				unset($clientIDs[$index]);
				$client->__SET('SocketID', $clientIDs);
				$leave = true;
				if (count($clientIDs) === 0) $pos = intval($userID);

			}
		}

		if ($leave) break;

	}

	if ($pos) {

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
			foreach ($user->__GET('SocketID') as $curSocket) {
				$Server->wsSend($curSocket, json_encode($desconexion));
			}
		}

		$Server->log($desconectado['Nombre'] . " CON ROL '" .$desconectado['tipoUsuario']. "' SE HA DESCONECTADO");
		unset($clients[$pos]);

	} else {
		$Server->log("SE HA DESCONECTADO UNA INSTANCIA DE CLIENTE");
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
