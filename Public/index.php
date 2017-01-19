<?php

/*
* Index principal:
* Inicializa la aplicación
*/

// Nota: DIRECTORY_SEPARATOR agrega un slash ('/') al final de las siguientes rutas:
define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);     // ROOT: Ruta completa del directorio actual
define('APP', ROOT . 'Application' . DIRECTORY_SEPARATOR);  // APP: Ruta completa del directorio 'Application'

require APP . 'Config/socket.php';     // Cargar configuración websocket
require APP . 'Config/config.php';        // Cargar configuración general
require APP . 'Config/sesion.php';        // Cargar controlador de sesiones
require APP . 'Config/iController.php';   // Cargar interfaz de controladores
require APP . 'Config/iModel.php';        // Cargar interfaz de modelos
require APP . 'Core/application.php';     // Cargar controlador de rutas
require APP . 'Core/controller.php';      // Cargar controlador del modelo de datos
require APP . 'Lib/swiftmailer/lib/swift_required.php';      //Carga swiftmailer
require APP . 'Config/encrypt.php';      //Carga encriptación

# Dar inicio a la aplicación:
$app = new Application();

?>
