<?php

/**
* Modelo MdlIndex:
* Se encarga de la página inicial en donde se pueden consultar
* los reportes y las notificaciones de emergencia.
*/
class MdlIndex implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $idAsignacionPersonal;
  private $idReporteAPH;

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
  * Consultar determinado reporteAPH.
  */
  function ConsultarReporteAPH(){
    $sql = "CALL spConsultarReporteAPH(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $this->idReporteAPH);
    $query->execute();
    if ($query->rowCount() > 0) {
      return array('reporte' => $query->fetch());
    }else{
      return array('reporte' => null);
    }
  }


  /**
  * Consultar el personal de un determinado reporteAPH, utilizando como
  * filtro el idAsignacionPersonal.
  */
  function ConsultarPersonalReporteAPH(){
    $sql = "CALL spPersonalReporteAPH(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $this->idAsignacionPersonal);
    $query->execute();
    if ($query->rowCount() > 0) {
      return $query->fetchAll();
    }else{
      return null;
    }
  }


  /**
  * Consultar los Tratamientos de un determinado reporteAPH.
  */
  function ConsultarTratamientosAPH(){
    $sql = "CALL spConsultarTratamientosAPH(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $this->idReporteAPH);
    $query->execute();
    if ($query->rowCount() > 0) {
      return array('tratamientos' => $query->fetchAll());
    }else{
      return array('tratamientos' => null);
    }
  }


  /**
  * Consultar las Desfibrilaciones un determinado reporteAPH
  */
  function ConsultarDesfibrilacionAPH(){
    $sql = "CALL spConsultarDesfibrilacionAPH(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $this->idReporteAPH);
    $query->execute();
    if ($query->rowCount() > 0) {
      return array('desfibrilaciones' => $query->fetchAll());
    }else{
      return array('desfibrilaciones' => null);
    }
  }


  /**
  * Consultar los Antecedentes de un determinado reporteAPH.
  */
  function ConsultarAntecedentesAPH(){
    $sql = "CALL spConsultarAntecedentesAPH(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $this->idReporteAPH);
    $query->execute();
    if ($query->rowCount() > 0) {
      return array('antecedentes' => $query->fetchAll());
    }else{
      return array('antecedentes' => null);
    }
  }


  /**
  * Consultar los Motivos Consulta de un determinado reporteAPH.
  */
  function ConsultarMotivoConsultaAPH(){
    $sql = "CALL spConsultarMotivoConsultaAPH(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $this->idReporteAPH);
    $query->execute();
    if ($query->rowCount() > 0) {
      return array('motivosConsulta' => $query->fetchAll());
    }else{
      return array('motivosConsulta' => null);
    }
  }


  /**
  * Consultar los Testigos de un determinado reporteAPH.
  */
  function ConsultarTestigoAPH(){
    $sql = "CALL spConsultarTestigoAPH(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $this->idReporteAPH);
    $query->execute();
    if ($query->rowCount() > 0) {
      return array('testigos' => $query->fetchAll());
    }else{
      return array('testigos' => null);
    }
  }


  /**
  * Consultar los Medicamentos de un determinado reporteAPH.
  */
  function ConsultarMedicamentosAPH(){
    $sql = "CALL spConsultarMedicamentosAPH(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $this->idReporteAPH);
    $query->execute();
    if ($query->rowCount() > 0) {
      return array('medicamentos' => $query->fetchAll());
    }else{
      return array('medicamentos' => null);
    }
  }


  /**
  * Consultar las vías de comunicación(Control médico)
  */
  function ConsultarViaComunicacionAPH(){
    $sql = "CALL spConsultarViaComunicacionAPH(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $this->idReporteAPH);
    $query->execute();
    if ($query->rowCount() > 0) {
      return array('viasComunicacion' => $query->fetchAll());
    }else{
      return array('viasComunicacion' => null);
    }
  }

  /**
  * Cambiar disponibilidad de la ambulancia
  */
  function CambiarDisponibilidad(){
    $sql = "CALL spConsultarIdAmbulancia(?)";
    $query = $this->_CONEXION->prepare($sql);
    $idUsuario = Sesion::getValue('ID_USUARIO');
    $query->bindParam(1, $idUsuario, PDO::PARAM_INT);
    $query->execute();
    $idAmbulancia = (int) $query->fetch()->idAmbulancia;

    $sql = "SELECT fnCambiarDisponibilidad(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $idAmbulancia);
    $query->execute();
    if ($query->rowCount() > 0) {
      return (int) $query->fetchColumn();
    }else {
      echo "Error al ejecutar la función fnCambiarDisponibilidad en la DB";
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


} // Fin clase
?>
