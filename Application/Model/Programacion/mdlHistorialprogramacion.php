<?php
class mdlHistorialprogramacion implements iModel {

  private static $_INSTANCIA; 
  private $_CONEXION;         
  private function __construct($_CON) {
    $this->_CONEXION = $_CON;
  }
  public static function getInstance($_CONEXION) {
    if (!self::$_INSTANCIA instanceof self) {
      self::$_INSTANCIA = new self($_CONEXION);
    }
    return self::$_INSTANCIA;
  }
 public function consultaragenda(){
  $idPersona =  Sesion::getValue('ID_PERSONA');
 $sql="CALL spConsultarcitasprogramadas (?)";
$query = $this->_CONEXION->prepare($sql);
$query->bindParam(1, $idPersona);
if ($query->execute()) {
  return $query->fetchALL();
}else{
  return null;
}
}
 public function consul(){
$idPersona = Sesion::getValue('ID_PERSONA');
$sql="CALL spConsultarTurnoActivo(?)";
$query = $this->_CONEXION->prepare($sql);
$query->bindParam(1, $idPersona);
if ($query->execute()){
  return $query->fetchALL();
}else{
  return null;
}
}


}
?>
