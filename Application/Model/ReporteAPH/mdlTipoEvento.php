<?php
class MdlTipoEvento implements iModel{
  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;// Variable de conexión PDO
  private $idReporteInicial;
  private $idTipoEvento;
  private $datosPaciente;
  private $datosActPaciente;
  private $datosAcompanante;
  private $datosActAcompanante;
  private $codigo;
  private $datoAcomp;


  # Constructor:
  private function __construct($_CON){
    try {
      $this->_CONEXION = $_CON;
    } catch (PDOException $e) {
      exit('Error al intentar conectar con la Base de Datos :' + $e);
    }
  }

  function __GET($atributo){
    return $this->$atributo;
  }
  function __SET($atributo,$valor){
    $this->$atributo = $valor;
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

  //Métodos y funciones de la clase

  function insertarPaciente(){
   $arrayPaciente = $this->__GET("datosPaciente");
   $sql = "CALL spRegistrarPaciente(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $query = $this->_CONEXION->prepare($sql);
    for ($i=0; $i < count($arrayPaciente); $i++) {
      $query->bindParam($i+1,$arrayPaciente[$i]);
    }
    if ($query->execute()) {
      return true;
    }else{
      return false;
    }

  }

  function insertarAcompanante(){
    $arrayAcompanante = $this->__GET("datosAcompanante");
    $sql = "CALL spRegistrarAcompanante(?,?,?,?,?,?)";
    $query = $this->_CONEXION->prepare($sql);
    for ($i=0; $i < count($arrayAcompanante); $i++){
      $query->bindParam($i+1, $arrayAcompanante[$i]);
    }
    if ($query->execute()) {
      return true;
    }else{
      return false;
    }
  }

  //Llama el tipo de documento que hay insertadas en la tabla tipodocumento
  function ListadoTipoDocumento(){
    $sql="CALL spListarTipodocumento()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return null;
    }
  }

  //Procedimiento creado para llamar el ultimo id de un paciente
  function ListadoUltimoPaciente(){
    $sql="CALL spUltimoPaciente()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetch();
    }else{
      return null;
    }
  }

  //Cuando se registra el acompañante tree es id
  function UltimoAcompanante(){
    $sql = "CALL spUltimoAcompanante()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetch();
    }else{
      return null;
    }
  }

  function consultarPaciente(){
    $consultaPac = $this->__GET("codigo");
    $sql = "CALL spConsultarPacienteDocumento(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$consultaPac);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return null;
    }

  }


  function consultarAcompanante(){
    $consultaAcomp = $this->__GET("datoAcomp");
    $sql = "CALL spConsultarAcompanante(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $consultaAcomp);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return null;
    }
  }



  function actualizarPaciente(){
    $arrayModificacionP = $this->__GET("datosActPaciente");
    $sql = "CALL spModificarPaciente(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $query = $this->_CONEXION->prepare($sql);

    for ($i=0; $i < count($arrayModificacionP); $i++) {
      $query->bindParam($i+1,$arrayModificacionP[$i]);
    }
    if ($query->execute()) {
      return true;
    }else{
      return false;
    }

  }

  function actualizarAcompanante(){
    $modificacionAcompanante = $this->__GET("datosActAcompanante");
    $sql = "CALL spModificarAcompanante(?,?,?,?,?,?,?)";
    $query = $this->_CONEXION->prepare($sql);
    for ($i=0; $i < count($modificacionAcompanante); $i++){
      $query->bindParam($i+1, $modificacionAcompanante[$i]);
    }
    if ($query->execute()){
      return true;
    }else{
      return false;
    }
  }
  function ListarTriage(){
    try {
      $sql = "CALL `spListarTriage`()";
      $query = $this->_CONEXION->prepare($sql);
      if ($query->execute()) {
       return $query->fetchAll();
     }else{
       return null;
     }
    } catch (Exception $e) {
      return null;
    }

  }
  function ListarTipoEvento(){
    try {
        $sql = "CALL spListarTipoevento()";
        $query = $this->_CONEXION->prepare($sql);
        if ($query->execute()) {
            return $query->fetchAll();
        }else{
          return null;
        }
    } catch (Exception $e) {
          return null;
    }

  }
  function EliminarTipoEvento(){
    try {
      $idReporteInicial = $this->__GET("idReporteInicial");
        $sql = "CALl spEliminarTipoEventoConfirmacion(?)";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1,$idReporteInicial);
        if ($query->execute()) {
            return true;
        }else{
          return false;
        }
    } catch (Exception $e) {
          return false;
    }

  }
  function RegistrarTipoEventoReporteInicial(){
    try {
      $idReporteInicial = $this->__GET("idReporteInicial");
      $idTipoEvento = $this->__GET("idTipoEvento");
        $sql = "CALL spRegistrarTipoEvento_reporteinicialAPH(?,?)";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1,$idTipoEvento);
        $query->bindParam(2,$idReporteInicial);
        if ($query->execute()) {
            return true;
        }else{
            return false;
        }
    } catch (Exception $e) {
            return false;
    }

  }






}



?>
