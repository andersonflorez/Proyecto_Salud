<?php

class mdlTratamientoPDF implements iModel{

  private static $_INSTANCIA;
  private $_CONEXION;

  private function __construct($_CON){
    $this->_CONEXION=$_CON;
  }

  public static function getInstance($_CONEXION){
    if(!self::$_INSTANCIA instanceof self){
      self::$_INSTANCIA = new self($_CONEXION);
    }
    return self::$_INSTANCIA;

  }

  function consultarHc($id){
    $sql="SELECT P.primerNombre, P.edadPaciente, P.genero, P.numeroDocumento, P.direccion, P.ocupacion, P.barrioResidencia, p.telefonoFijo,HC.fechaAtencion, p.ciudadResidencia,P.edadPaciente, KIT.fechaHoraAsignacion, DET.cantidadAsignada,RE.descripcion,RE.nombre,TP.descripcionTdocumento, KIT.estadoTablaAsignacionKit,
    hc.enfermedadActual
    FROM tbl_historiaclinica HC
    INNER JOIN tbl_tipoorigenatencion T
    ON HC.idTipoorigenatencion = T.idTipoOrigenAtencion
    INNER JOIN tbl_paciente P
    ON P.idPaciente = HC.idPaciente
    INNER JOIN tbl_cita_programacion CP
    ON HC.idCitaprogramacion = CP.idCitaprogramacion
    INNER JOIN tbl_turnoprogramacion TU
    ON TU.idTurnoProgramacion = CP.idTurnoProgramacion
    INNER JOIN tbl_persona PE
    ON PE.idPersona = TU.idPersona
   	INNER JOIN tbl_asignacionkit KIT
    ON KIT.idPaciente =  P.idPaciente
    INNER JOIN tbl_detallekit DET
    ON DET.idAsignacion = KIT.idAsignacion
    INNER JOIN tbl_recurso RE
    ON DET.idRecurso = RE.idRecurso
    INNER JOIN tbl_tipodocumento TP
    ON P.idtipoDocumento = TP.idTipoDocumento
    where HC.idHistoriaClinica = $id";
    $conn=$this->_CONEXION;
    $query=$conn->prepare($sql);

    if($query->execute()){
      return $query->fetch();
    }else{
      return null;
    }
  }

  /*  function consultarPC(){
  $sql="SELECT  PA.idPaciente,PA.primerNombre, PA.primerApellido, PA.segundoApellido,
  PA.numeroDocumento,
  tbr.nombre, tbr.cantidadRecurso,tbt.descripcionTratamiento,tbt.fechaTratamiento
  FROM tbl_cita C
  INNER JOIN tbl_paciente PA ON PA.idPaciente = C.idPaciente
  INNER JOIN tbl_cita_programacion CP ON C.idCita = CP.idcita
  INNER JOIN tbl_turnoprogramacion TP ON CP.idTurnoProgramacion = TP.idTurnoProgramacion
  INNER JOIN tbl_persona PE ON PE.idPersona = TP.idPersona
  INNER JOIN tbl_programacion P ON P.idProgramacion = TP.idProgramacion
  INNER JOIN tbl_turno T ON T.idTurno = TP.idTurno
  INNER JOIN tbl_Cup cu ON	CU.idCup = C.idCUP
  INNER JOIN tbl_zona z ON z.idZona = C.idZona
  INNER JOIN tbl_historiaclinica tbh ON PA.idPaciente = tbh.idPaciente
  INNER JOIN tbl_tratamientodmc tbt ON tbh.idHistoriaClinica = tbt.idHistoriaClinica
  INNER JOIN tbl_detalletratamientodmcrecurso tbd ON tbt.idTratamiento = tbd.idDetalleTratamientodmcRecurso
  INNER JOIN tbl_recurso tbr ON tbd.idRecurso = tbr.idrecurso
  INNER JOIN tbl_categoriarecurso tbcg ON tbr.idCategoriaRecurso = tbcg.idCategoriaRecurso";
  $conn=$this->_CONEXION;
  $query=$conn->prepare($sql);

  if($query->execute()){
  return $query->fetch();
}else{
return null;
}
}
*/







function cunsultarAtencedentes($id){
  $sql ="SELECT * FROM tbl_antecedentedmc a
  INNER JOIN tbl_tipoantecedente ta
  ON ta.idTipoAntecedente = a.idTipoAntecedente
  WHERE idHistoriaClinica=?";
  $conn = $this->_CONEXION;
  $query = $conn->prepare($sql);
  $query->bindParam(1,$id);
  if($query->execute()){
    return $query->fetchAll();
  }else{
    return null;
  }
}



//Funcion para detalle formula medicamento


//Función para consultar el tratamiento
function consultarTratamiento($idAtencion){
  $sql="select idTratamiento,descripcionTratamiento,fechaTratamiento,dosisTratamiento,tipoTrata.Descripcion as tipoTratamiento
  from tbl_tratamientodmc as tratamiento
  inner join tbl_tipotratamiento as tipoTrata
  on tratamiento.idTipoTratamiento= tipoTrata.idTipoTratamiento
  inner join tbl_historiaClinica as hClinica
  on tratamiento.idHistoriaClinica = hClinica.idHistoriaClinica
  where tratamiento.idHistoriaClinica=:idAtencion";
  $conn=$this->_CONEXION;
  $query=$conn->prepare($sql);
  $query->bindParam(":idAtencion",$idAtencion,PDO::PARAM_STR);

  if($query->execute()){
    return $query->fetch();
  }else{
    return null;
  }
}
//Funcion para consultar los equipos

function consultarDetalleTratamiento(){
  $sql="select recur.nombre, recur.cantidadRecurso, recur.descripcion
from tbl_recurso as recur
inner join tbl_detalletratamientodmcrecurso as detalleTratamiento
on recur.idRecurso = detalleTratamiento.idRecurso";
  $conn=$this->_CONEXION;
  $query=$conn->prepare($sql);
  //$query->bindParam(":idTratamiento",$idTratamiento,PDO::PARAM_STR);

  if($query->execute()){
    return $query->fetchAll();
  }else{
    return null;
  }
}

function consultarEquipoBiomedicoTratamiento($idTratamiento){
  $sql="select descripcion as equipoBiomedico from tbl_equipobiomedico where idTratamiento= :idTratamiento";
  $conn=$this->_CONEXION;
  $query=$conn->prepare($sql);
  $query->bindParam(":idTratamiento",$idTratamiento,PDO::PARAM_STR);
  if($query->execute()){
    return $query->fetchAll();
  }else{
    return null;
  }
}
//Funcion de examenes Especializados
function consultarExamenEspecializado($idAtencion){
  $sql="select tipoExamen.descripcion as nombreTipoExamen,observaciones,examenEspecial.descripcion from tbl_tipoexamenespecializado as tipoExamen inner join tbl_examenespecializado as examenEspecial
  on tipoExamen.idTipoexamenespecializado = examenEspecial.idTipoexamenespecializado
  where idHistoriaClinica = idHistoriaClinica";
  $conn=$this->_CONEXION;
  $query=$conn->prepare($sql);
  $query->bindParam(":idAtencion",$idAtencion,PDO::PARAM_STR);
  if($query->execute()){
    return $query->fetch();
  }else{
    return null;
  }
}
//Funcion de interconsulta
function consultarInterconsulta($idAtencion){
  $sql="select descripcionInterconsulta,especialidad,fechaLimite
  from tbl_interconsulta
  where idHistoriaClinica= idHistoriaClinica";
  $conn=$this->_CONEXION;
  $query=$conn->prepare($sql);
  $query->bindParam(":idAtencion",$idAtencion,PDO::PARAM_STR);
  if($query->execute()){
    return $query->fetch();
  }else{
    return null;
  }
}


//Funcion pra otro (ordenes Medicas){
function consultarOtro($idAtencion){
  $sql="select descripcion as descripcionOtro
  from tbl_otrodmc
  where idHistoriaClinica = :idAtencion";
  $conn=$this->_CONEXION;
  $query=$conn->prepare($sql);
  $query->bindParam(":idAtencion",$idAtencion,PDO::PARAM_STR);
  if($query->execute()){
    return $query->fetch();
  }else{
    return null;
  }
}

function consultarMedicacion($idAtencion){
    $sql="SELECT
    tbr.nombre, tbr.cantidadRecurso,tbt.descripcionTratamiento,tbt.fechaTratamiento,tbl_asignacionkit.fechaHoraAsignacion,tbl_asignacionkit.estadoTablaAsignacionKit,
    tbl_detallekit.cantidadAsignada
    FROM tbl_cita C
    INNER JOIN tbl_paciente PA ON PA.idPaciente = C.idPaciente
    INNER JOIN tbl_cita_programacion CP ON C.idCita = CP.idcita
    INNER JOIN tbl_turnoprogramacion TP ON CP.idTurnoProgramacion = TP.idTurnoProgramacion
    INNER JOIN tbl_persona PE ON PE.idPersona = TP.idPersona
    INNER JOIN tbl_programacion P ON P.idProgramacion = TP.idProgramacion
    INNER JOIN tbl_turno T ON T.idTurno = TP.idTurno
    INNER JOIN tbl_Cup cu ON	CU.idCup = C.idCUP
    INNER JOIN tbl_zona z ON z.idZona = C.idZona
    INNER JOIN tbl_historiaclinica tbh ON PA.idPaciente = tbh.idPaciente
    INNER JOIN tbl_tratamientodmc tbt ON tbh.idHistoriaClinica = tbt.idHistoriaClinica
    INNER JOIN tbl_detalletratamientodmcrecurso tbd ON tbt.idTratamiento = tbd.idDetalleTratamientodmcRecurso
    INNER JOIN tbl_recurso tbr ON tbd.idRecurso = tbr.idrecurso
    INNER JOIN tbl_categoriarecurso tbcg ON tbr.idCategoriaRecurso = tbcg.idCategoriaRecurso
    INNER JOIN tbl_tratamientodmc on tbh.idHistoriaClinica = tbl_tratamientodmc.idHistoriaClinica
         INNER JOIN tbl_detalletratamientodmcrecurso dett on tbl_tratamientodmc.idTratamiento = dett.idTratamiento
         INNER JOIN tbl_asignacionkit on PA.idPaciente= tbl_asignacionkit.idPaciente
         INNER JOIN tbl_detallekit on tbl_asignacionkit.idAsignacion = tbl_detallekit.idAsignacion

          where tbh.idHistoriaClinica=:idAtencion";
    $conn=$this->_CONEXION;
    $query=$conn->prepare($sql);
    $query->bindParam(":idAtencion",$idAtencion,PDO::PARAM_STR);
    $query->execute();

    if($query==true){
        return $query->fetchAll();
    }else{
        return null;
    }
}


}



?>
