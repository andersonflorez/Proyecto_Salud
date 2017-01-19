<?php

/**
 * Modelo LocalizacionLesiones:
 * Este modelo se encarga de registrar y consultar
 * los diagnosticos generados con el cuerpo
 * Los regstros de esta tabla no se puede modficar ni eliminar
 */
class MdlLocalizacionLesion implements iModel {
  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO


  # Atributos de la clase:
  private $posX;
  private $PosY;
  private $idReporteAPH;
  private $idPuntoLesion;
  private $especificacionLesion;
  private $idCIE10;


  # Constructor:
  private function __construct($_CON){
    try {
      $this->_CONEXION = $_CON;
    } catch (PDOException $e) {
      exit('Error al intentar conectar con la Base de Datos :' + $e);
    }
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


  /**
  * Listar los registros de cie10
  */
  function ListadoCIE10(){
    $sql="CALL spListarCIE10Cuerpo()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
 	      return null;
    }
  }

  /**
  * Registrar un punto del cuerpo humano, recibe estos parametros:
  * @param  $posX; es la posición en el eje X del punto
  * @param  $posY; es la posición en el eje Y del punto
  * @param  $idReporteAPH; id de un registro de la tabla de ReporteAPH
  */
  function RegistrarPuntoLesion() {
    $sql = "SELECT `fnRegistrarPuntolesion`(?,?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $this->posX, PDO::PARAM_STR);
    $query->bindParam(2, $this->PosY, PDO::PARAM_STR);
    $query->bindParam(3, $this->idReporteAPH, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
      return $query->fetchColumn();
    }
  }


  /**
  * Registrar una lesión asociada a un punto, recibe estos parametros:
  * @param  $idPuntoLesion; id de un registro de la tabla de tbl_puntolesion
  * @param  $especificacionLesion; texto de especificación de la lesion
  * @param  $idCIE10; id de un registro de la tabla de tbl_cie10
  */
  function RegistrarLesion() {
    $sql = "CALL `spRegistrarLesion`(?,?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $this->idPuntoLesion, PDO::PARAM_STR);
    $query->bindParam(2, $this->especificacionLesion, PDO::PARAM_STR);
    $query->bindParam(3, $this->idCIE10, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
      return true;
    }else {
      return false;
    }
  }


  /**
  * Listar todos los puntos
  * @param $idReporteAPH; id de un registro de la tabla tbl_reporteaph
  */
  function ListarPuntoLesion(){
    $sql="CALL spFiltrarPuntosLesiones(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $this->idReporteAPH, PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return null;
    }
  }


  /**
  * Consultar lesiones de un punto
  * @param $idPuntoLesion; id de un registro de la tabla tbl_puntolesion
  */
  function ConsultarLesiones(){
    $sql="CALL spJoinLesionesCie10(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $this->idPuntoLesion, PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return null;
    }
  }


  # Métodos Setter & Getter:
  public function __SET($var, $valor) {
    if (property_exists(__CLASS__, $var)) {
      $this->$var = $valor;
    } else {
      echo "No existe el atributo $var.";
    }
  }
  public function __GET($var) {
    if (property_exists(__CLASS__, $var)) {
      return $this->$var;
    }
    return NULL;
  }


}
