<?php
  /**
  * CLASE: Client
  * TIPO: Modelo (Especial para WebSockets)
  * DESCRIPCION:
  * Este modelo define los atributos necesarios
  * para cada cliente que se conecta al servidor
  * websocket.
  */
  class Client {
    private $Nombre;
    private $tipoUsuario;
    private $idUsuario;
    private $Usuario;
    private $SocketID;
    private $numeroNotificaciones;
    private $direccionIp;

    public function __GET($atributo)
    {
      return $this->$atributo;
    }

    public function __SET($atributo, $valor)
    {
      $this->$atributo = $valor;
    }
  }

?>
