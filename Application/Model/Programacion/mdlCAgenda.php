<?php

/**
 * Modelo nombre_modelo:
 * Escribe aqui una descripcion de lo que hace
 * este modelo. Copia esta estructura básica y
 * utilízala en todos los modelos que necesites
 * crear. Todos los modelos deben tener esta
 * estructura.
 */
class mdlCAgenda implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  // ...

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

  // ...

  # Métodos Setter & Getter:
  // ...



function consultaragenda(){
  $idPersona = 1;
/*$sql="SELECT P.idPersona, Es.idEspecialidad , ES.idPersonaEspecialidad ,P.primerNombre, E.descripcionEspecialidad ,P.primerNombre,P.primerApellido,Es.idEspecialidad,T.horaInicioTurno,T.horaFinalTurno,PR.Fecha_inicial,PR.Fecha_final
FROM tbl_persona P
inner join tbl_personaEspecialidad Es on p.idPersona = Es.idPersona
 inner join tbl_especialidad E on Es.idEspecialidad = E.idEspecialidad
 inner join tbl_turnoprogramacion TP on P.idPersona = TP.idPersona
 inner JOIN tbl_turno T on TP.idTurno = T.idTurno
 inner join tbl_programacion PR on TP.idProgramacion = PR.idProgramacion
 where P.idPersona = 1";*/
 $sql="CALL spConsultarcitasprogramadas (?)";
$query = $this->_CONEXION->prepare($sql);
$query->bindParam(1, $idPersona);
if ($query->execute()) {
  return $query->fetchALL();
}else{
  return null;
}
}
function consul(){
$sql="SELECT P.idPersona,T.idTurno,tp.idTurnoProgramacion, Es.idEspecialidad , ES.idPersonaEspecialidad ,P.primerNombre, E.descripcionEspecialidad ,P.primerNombre,P.primerApellido,Es.idEspecialidad,max(T.horaInicioTurno) as 'Horainicial',max(T.horaFinalTurno) as 'Horafinal',max(PR.Fecha_inicial) as 'Fechainicial',max(PR.Fecha_final) as 'Fechafinal',TP.estadoTablaProgramacion FROM tbl_persona P inner join tbl_personaEspecialidad Es on p.idPersona = Es.idPersona inner join tbl_especialidad E on Es.idEspecialidad = E.idEspecialidad inner join tbl_turnoprogramacion TP on P.idPersona = TP.idPersona inner JOIN tbl_turno T on TP.idTurno = T.idTurno inner join tbl_programacion PR on TP.idProgramacion = PR.idProgramacion where P.idPersona = 1 and TP.estadoTablaProgramacion = 'habilitado' LIMIT 1 ;";
$query = $this->_CONEXION->prepare($sql);
if ($query->execute()) {
  return $query->fetchALL();
}else{
  return null;
}
}


}
?>
