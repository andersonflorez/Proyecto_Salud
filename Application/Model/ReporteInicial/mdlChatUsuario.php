<?php

/**
* Modelo chat usuario:
* Este modelo se encarga de gestionar
* operaciones correspondientes
* a la vista del usuario externo
*/
class mdlChatUsuario implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $idChat;
  private $idMensaje;
  private $tipo;
  private $idUsuarioExterno;
  private $idReceptorInicial;
  private $ejecutador;
  private $lista;

  # Constructor:
  private function __construct($_CON) {
    $this->_CONEXION = $_CON;
  }

  /*
  * Función getInstance():
  * Devuelve la única instancia de esta clase.
  * Recibe la conexión PDO como parámetro.
  */
  public static function getInstance($_CONEXION) {

    if (!self::$_INSTANCIA instanceof self) {
      self::$_INSTANCIA = new self($_CONEXION);
    }

    return self::$_INSTANCIA;

  }

  # Métodos y funciones de la clase:

  /*
  * Función RegistrarChat:
  * N° parámetros procedimiento: 2
  * Parámetros: idReceptorInicial, idUsuarioExterno
  * Descripción: Permite registrar un chat de reporte inicial
  * Retorno: El id del último chat registrado, el cual se usa para
  * registrar mensajes y asociarlos a ese chat.
  */
  public function RegistrarChat() {

    $this->lista = null;

    try {

      $this->ejecutador = $this->_CONEXION->prepare("CALL spRegistrarChat(?, ?)");
      $this->ejecutador->bindParam(1, $this->idReceptorInicial);
      $this->ejecutador->bindParam(2, $this->idUsuarioExterno);
      $this->ejecutador->execute();

      if ($this->ejecutador->rowCount() > 0) {
        $this->lista = $this->ejecutador->fetch(PDO::FETCH_NUM);
      }

    } catch (Exception $e) {
      die("Ha ocurrido un error al intentar consultar el reporte: $e");
    }

    return $this->lista;

  }

  /*
  * Función RegistrarMensaje:
  * N° parámetros procedimiento: 2
  * Parámetros: idReceptorInicial, idUsuarioExterno
  * Descripción: Permite registrar un chat de reporte inicial
  * Retorno: El id del último chat registrado, el cual se usa para
  * registrar mensajes y asociarlos a ese chat.
  */
  public function RegistrarMensaje() {

    $res = false;

    try {

      $this->ejecutador = $this->_CONEXION->prepare("CALL spRegistrarMensaje(?, ?, ?)");
      $this->ejecutador->bindParam(1, $this->idChat);
      $this->ejecutador->bindParam(2, $this->mensaje);
      $this->ejecutador->bindParam(3, $this->tipo);
      $this->ejecutador->execute();

      $res = $this->ejecutador->rowCount() > 0;

    } catch (Exception $e) {
      die("Ha ocurrido un error al intentar consultar el reporte: $e");
    }

    return $res;

  }

  /*
  * Función ConsultarMensajesChat:
  * N° parámetros procedimiento: 1
  * Parámetro: idChat
  * Descripción: Permite consultar los mensajes de un chat en específico:
  * Retorno: Matriz con todos los mensajes registrados en el chat
  */
  public function ConsultarMensajesChat() {

    $this->lista = null;

    try {

      $this->ejecutador = $this->_CONEXION->prepare("CALL spConsultarMensajesChat(?)");
      $this->ejecutador->bindParam(1, $this->idChat);
      $this->ejecutador->execute();

      if ($this->ejecutador->rowCount() > 0) {
        $this->lista = $this->ejecutador->fetchAll();
      }

    } catch (Exception $e) {
      die("Ha ocurrido un error al intentar consultar el reporte: $e");
    }

    return $this->lista;

  }

  /*
  * Función ConsultarNotificacionesChat:
  * N° parámetros procedimiento: 1
  * Parámetro: idReceptorInicial
  * Descripción: Permite consultar las notificaciones de reportes
  * de un receptor inicial
  * Retorno: Matriz con la información de los chats que no se han
  * atendido
  */
  public function ConsultarNotificacionesChat() {

    $this->lista = null;

    try {

      $this->ejecutador = $this->_CONEXION->prepare("CALL spConsultarNotificacionesChat(?)");
      $this->ejecutador->bindParam(1, $this->idReceptorInicial);
      $this->ejecutador->execute();

      if ($this->ejecutador->rowCount() > 0) {
        $this->lista = $this->ejecutador->fetchAll();
      }

    } catch (Exception $e) {
      die("Ha ocurrido un error al intentar consultar el reporte: $e");
    }

    return $this->lista;

  }

  /*
  * Función ConsultarMensajeNotificacion:
  * N° parámetros procedimiento: 1
  * Parámetro: idChat
  * Descripción: Permite consultar el primer mensaje enviado
  * por un usuario externo al  enviar una notificación
  * Retorno: Array con la información del primer mensaje de una notificación de chat
  */
  public function ConsultarMensajeNotificacion() {

    $this->lista = null;

    try {

      $this->ejecutador = $this->_CONEXION->prepare("CALL spConsultarMensajeNotificacion(?)");
      $this->ejecutador->bindParam(1, $this->idChat);
      $this->ejecutador->execute();

      if ($this->ejecutador->rowCount() > 0) {
        $this->lista = $this->ejecutador->fetch();
      }

    } catch (Exception $e) {
      die("Ha ocurrido un error al intentar consultar el reporte: $e");
    }

    return $this->lista;

  }

  /*
  * Función ConsultarChatReporte:
  * N° parámetros procedimiento: 1
  * Parámetro: idChat
  * Descripción: Permite consultar el chat asociado a un reporte inicial:
  * Retorno: Array con la información del chat del reporte consultado,
  * el array trae consigo el id del chat con el cual se pueden consultar sus mensajes
  */
  public function ConsultarChat() {

    $this->lista = null;

    try {

      $this->ejecutador = $this->_CONEXION->prepare("CALL spConsultarChat(?)");
      $this->ejecutador->bindParam(1, $this->idChat);
      $this->ejecutador->execute();

      if ($this->ejecutador->rowCount() > 0) {
        $this->lista = $this->ejecutador->fetch();
      }

    } catch (Exception $e) {
      die("Ha ocurrido un error al intentar consultar el reporte: $e");
    }

    return $this->lista;

  }

  /*
  * Función ConsultarChatsUsuario:
  * N° parámetros procedimiento: 1
  * Parámetro: idUsuarioExterno
  * Descripción: Permite consultar el historial de chats de un usuario externo:
  * Retorno: Matriz con la información de los chats que ha tenido un usuario externo.
  * La matriz contiene uno o varios chats (finalizados), los cuales traen consigo
  * su correspondiente id para consultar sus mensajes.
  */
  public function ConsultarChatsUsuario() {

    $this->lista = null;

    try {

      $this->ejecutador = $this->_CONEXION->prepare("CALL spConsultarChatsUsuario(?)");
      $this->ejecutador->bindParam(1, $this->idUsuarioExterno);
      $this->ejecutador->execute();

      if ($this->ejecutador->rowCount() > 0) {
        $this->lista = $this->ejecutador->fetchAll();
      }

    } catch (Exception $e) {
      die("Ha ocurrido un error al intentar consultar el reporte: $e");
    }

    return $this->lista;

  }

  # Las 2 siguientes funciones se usan para evitar que un chat finalice 'bruscamente'.

  /*
  * Función ValidarChatActivoUsuario:
  * N° parámetros procedimiento: 2
  * Parámetros: idUsuario, bool (por defecto es 0 para consultar por usuario externo)
  * Descripción: Permite validar si un usuario externo tiene un chat activo
  * Retorno: Array con la información del chat que se encuentra activo,
  * esto es muy importante ya que permite recuperar una conversación si el usuario
  * se desconecta inesperadamente. Tiene 30 segundos para volver a conectarse, sino,
  * se dará por finalizado el chat y el receptor inicial deberá decidir entre registrar
  * el reporte o cancelarlo.
  */
  public function ValidarChatActivoUsuario() {

    $this->lista = null;

    try {

      $bool = 2;
      $this->ejecutador = $this->_CONEXION->prepare("CALL spValidarChatActivo(?, ?)");
      $this->ejecutador->bindParam(1, $this->idUsuarioExterno);
      $this->ejecutador->bindParam(2, $bool);
      $this->ejecutador->execute();

      if ($this->ejecutador->rowCount() > 0) {
        $this->lista = $this->ejecutador->fetch();
      }

    } catch (Exception $e) {
      die("Ha ocurrido un error al intentar consultar el reporte: $e");
    }

    return $this->lista;

  }

  /*
  * Función ValidarChatActivoReceptor:
  * N° parámetros procedimiento: 2
  * Parámetros: idUsuario, bool (equivale a 1 para consultar por receptor inicial)
  * Descripción: Permite validar si un receptor inicial tiene un chat activo
  * Retorno: Array con la información del chat activo. Es similar a la función anterior
  * con la diferencia de que el receptor puede tener varios chats activos, es decir,
  * un chat abierto y otras notificaciones de chat entrantes, por lo tanto se requiere
  * de validaciones adicionales.
  */
  public function ValidarChatActivoReceptor() {

    $this->lista = null;

    try {

      $bool = 1;
      $this->ejecutador = $this->_CONEXION->prepare("CALL spValidarChatActivo(?, ?)");
      $this->ejecutador->bindParam(1, $this->idReceptorInicial);
      $this->ejecutador->bindParam(2, $bool);
      $this->ejecutador->execute();

      if ($this->ejecutador->rowCount() > 0) {
        $this->lista = $this->ejecutador->fetch();
      }

    } catch (Exception $e) {
      die("Ha ocurrido un error al intentar consultar el reporte: $e");
    }

    return $this->lista;

  }

  /*
  * Función ConsultarReceptorInicial:
  * N° parámetros procedimiento: 1
  * Parámetros: idReceptorInicial
  * Descripción: Permite consultar la información de un receptor inicial
  * Retorno: Array con la información básica del receptor inicial
  */
  public function ConsultarReceptorInicial() {

    $this->lista = null;

    try {

      $this->ejecutador = $this->_CONEXION->prepare("CALL spConsultarReceptorInicial(?)");
      $this->ejecutador->bindParam(1, $this->idReceptorInicial);
      $this->ejecutador->execute();

      if ($this->ejecutador->rowCount() > 0) {
        $this->lista = $this->ejecutador->fetch();
      }

    } catch (Exception $e) {
      die("Ha ocurrido un error al intentar consultar el reporte: $e");
    }

    return $this->lista;

  }

  /*
  * Función ConsultarUsuarioExterno:
  * N° parámetros procedimiento: 1
  * Parámetros: idUsuarioExterno
  * Descripción: Permite consultar la información de un usuario externo
  * Retorno: Array con la información básica del usuario externo
  */
  public function ConsultarUsuarioExterno() {

    $this->lista = null;

    try {

      $this->ejecutador = $this->_CONEXION->prepare("CALL spConsultarUsuarioExterno(?)");
      $this->ejecutador->bindParam(1, $this->idUsuarioExterno);
      $this->ejecutador->execute();

      if ($this->ejecutador->rowCount() > 0) {
        $this->lista = $this->ejecutador->fetch();
      }

    } catch (Exception $e) {
      die("Ha ocurrido un error al intentar consultar el reporte: $e");
    }

    return $this->lista;

  }

  /*
  * Función RegistrarVistoChat:
  * N° parámetros procedimiento: 1
  * Parámetros: idChat
  * Descripción: Permite cambiar el estado de un chat a 'visto', indicando que el
  * receptor inicial ha atendido la notificación de emergencia
  * Retorno: 'true' si se cambia el estado del chat sin complicaciones,
  * 'false' de lo contrario
  */
  public function RegistrarVistoChat() {

    $res = false;

    try {

      $this->ejecutador = $this->_CONEXION->prepare("CALL spRegistrarVistoChat(?)");
      $this->ejecutador->bindParam(1, $this->idChat);
      $this->ejecutador->execute();
      $res = $this->ejecutador->rowCount() > 0;

    } catch (Exception $e) {
      die("Ha ocurrido un error al intentar consultar el reporte: $e");
    }

    return $res;

  }

  /*
  * Función FinalizarChat:
  * N° parámetros procedimiento: 1
  * Parámetros: idUsuarioExterno
  * Descripción: Permite finalizar un chat de reporte inicial
  * Retorno: 'true' si se finaliza el chat sin complicaciones,
  * 'false' de lo contrario
  */
  public function FinalizarChat() {

    $res = false;

    try {

      $finalizado = 0;
      $this->ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoChat(?)");
      $this->ejecutador->bindParam(1, $this->idUsuarioExterno);
      $this->ejecutador->execute();
      $res = $this->ejecutador->rowCount() > 0;

    } catch (Exception $e) {
      die("Ha ocurrido un error al intentar consultar el reporte: $e");
    }

    return $res;

  }

  # Métodos Getter & Setter:
  public function __GET($var) {
    return $this->$var;
  }

  public function __SET($var, $val) {
    $this->$var = $val;
  }

}


?>
