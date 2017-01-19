

<?php

/**
* Modelo nombre_modelo:
* Escribe aqui una descripcion de lo que hace
* este modelo. Copia esta estructura básica y
* utilízala en todos los modelos que necesites
* crear. Todos los modelos deben tener esta
* estructura.
*/
class MdlDespacho implements iModel {



private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;  // Variable de conexión PDO
  private $_idReporteIni;
  private $_idAmbu;
  private $_fechaHd;
  private $_estadoDespa;
  private $_longiE;
  private $_latiEm;
  private $_idPersona;
  private $_estadoTabla;
  private $_esatdoReporte;
  private $_idNovedad;
  private $_idReporteInicial;
  private $_idAmbulancia;
  private $_estadoDespacho;
  private $_Longitud;
  private $_LatitudEmergencia;
  private $_estado;
  # Atributos de la clase:

  # Atributos de la clase:
  // ...

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

  // ...

  # Métodos Setter & Getter Mágico:

  function __GET($atributo){
    return $this->$atributo;
  }
  function __SET($atributo,$valor){
    $this->$atributo = $valor;
  }

  function InsertarDespacho(){
    try {
      $idReporteIni = $this->__GET("_idReporteIni");
    $idAmbu = $this->__GET("_idAmbu");
    $fechaHd = $this->__GET("_fechaHd");
    $estadoDespa = $this->__GET("_estadoDespa");
    $longiE = $this->__GET("_longiE");
    $latiEm = $this->__GET("_latiEm");
    $idPersona = $this->__GET("_idPersona");
      $sql = "CALL spRegistrarDespacho(?,?,?,?,?,?,?)";
      $query = $this->_CONEXION->prepare($sql);
      $query->bindParam(1,$idReporteIni,PDO::PARAM_INT);
      $query->bindParam(2,$idAmbu,PDO::PARAM_INT);
      $query->bindParam(3,$fechaHd,PDO::PARAM_STR);
      $query->bindParam(4,$estadoDespa,PDO::PARAM_STR);
      $query->bindParam(5,$longiE,PDO::PARAM_STR);
      $query->bindParam(6,$latiEm,PDO::PARAM_STR);
      $query->bindParam(7,$idPersona,PDO::PARAM_INT);
      if ($query->execute() && $query->rowCount() > 0) {
        return $query->fetch();
      } else {
        return null;
      }
    } catch (Exception $e) {
      return null;
    }


  }

  function ListadoReporteI(){
    $sql="CALL spListarReporteinicial()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return 'Algo salio mal';
    }
  }

  function ListarMarcadoresAmulancias(){
    $sql="CALL spConsultarAsignacionAmbulancia()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return 'Algo salio mal';
    }
  }

  function ActualizarEstadoAmbulancia(){
       $idAmbulancia = $this->__GET("_idAmbu");
    $estadoTabla = $this->__GET("_estadoTabla");
    $sql = "CALL spCambiarEstadoAmbulancia(?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idAmbulancia);
    $query->bindParam(2,$estadoTabla);
    if ($query->execute()) {
      return true;
    }else{
      return false;
    }
  }

  public function ListarNovedadReporte(){
    $sql = "CALL spListarNovedadReporte()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return false;
    }
  }

 public function ActualizarEstadoNovedad(){
    $idNovedad = $this->__GET("_idNovedad");
    $sql = "CALL spActualizarEstadoNovedadReporte(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $idNovedad);
    if ($query->execute()) {
      return true;
    }else{
      return false;
    }
  }

  public function ActualizarEstadoReporteInicial(){
     $idReporteInicial = $this->__GET("_idReporteIni");
     $estadoTabla = $this->__GET("_esatdoReporte");
    $sql = "CALL spCambiarEstadoReporteinicial(?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idReporteInicial);
    $query->bindParam(2,$estadoTabla);
    if ($query->execute()) {
      return true;
    }else{
      return false;
    }
  }

}


?>
