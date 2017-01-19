<?php

/**
* Clase: Sesion
* Controlador del manejo de sesiones de la aplicación
*/
class Sesion {

  # Método para activar y permitir el uso de sesiones:
  public static function init() {
    session_start();
  }

  # Método para definir una variable de sesión:
  public static function setValue($_NAME, $_VALUE) {
    $_SESSION[$_NAME] = $_VALUE;
  }

  # Función para obtener el valor de una variable de sesión:
  public static function getValue($_NAME) {
    return $_SESSION[$_NAME];
  }

  # Método para borrar una variable de sesión:
  public static function unsetValue($_NAME) {
    unset($_SESSION[$_NAME]);
  }

  # Función para saber si hay una sesión activa:
  public static function exist() {
    return count($_SESSION) > 0 && isset($_SESSION['ID_USUARIO']) && isset($_SESSION['TIPO_USUARIO']);
  }

  # Función para destruir una sesión:
  public static function destroy() {
    session_unset();
    session_destroy();
  }

  # Función para validar que exista una variable de sesión:
  public static function varExist($var) {
    return isset($_SESSION[$var]);
  }

}

?>
