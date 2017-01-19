<?php

class MdlConsultarAtencionTratamiento implements iModel{

    private static $_INSTANCIA;
    private $_CONEXION;


    public function __construct($_CON){
        $this->_CONEXION=$_CON;
    }

    public static function getInstance($_CONEXION){
        if(!self::$_INSTANCIA instanceof self){
            self::$_INSTANCIA = new self($_CONEXION);
        }

        return self::$_INSTANCIA;

    }



    // Funcion para la consultar las atenciones relaizadas
    function ConsultarAtencionTratamiento($cod){
        $sql="CALL spConsultaBasicadelTratamiento(?)";
        $conn=$this->_CONEXION;
        $query=$conn->prepare($sql);
        $query->bindParam(1,$cod );
        if($query->execute()){
            return $query->fetchAll();
        }else{
            return null;
        }
    }
    // Funcion para consultar las atenciones realizadas a un pacieente
    function consultarAtencionIdPaciente($codi){

        $sql="CALL spConsultarIdPacienteDmc(?)";
        $conn=$this->_CONEXION;
        $query=$conn->prepare($sql);
        $query->bindParam(1,$codi,PDO::PARAM_STR);
        $query->execute();
        if($query==true){
            return $query->fetch();
        }else{
            return null;
        }
    }


    // Esta funcion esta en todas las consultas, y me sirve para consultar el id de la historia clinica
    // en la que me encuentro.
    function consultarIdHistoriaClinica($idAtencion){

        $sql="CALL spConsultarIdHistoriaClinicaDmc(?)";
        $conn=$this->_CONEXION;
        $query=$conn->prepare($sql);
        $query->bindParam(1,$idAtencion,PDO::PARAM_STR);
        $query->execute();
        if($query==true){
            return $query->fetch();
        }else{
            return null;
        }
    }
    //Funcion para consultar la informacion personal de un paciente y actualizada en la atencion
    function consultarInformacionPersonal($idAtencion) {
        $sql = "CALL spConsultarPaciente(?)";
        $conn = $this->_CONEXION;
        $query = $conn->prepare($sql);
        $query->bindParam(1,$idAtencion,PDO::PARAM_STR);
        $query->execute();
        if ($query==true) {
            return $query->fetch();
        } else {
            return null;
        }

    }

    // Funcion para listar el tipo de documento que tiene el paciente.
    function listaTipoDocumento() {
        $sql = "CALL spListarTipodocumento()";
        $conn = $this->_CONEXION;
        $query = $conn->prepare($sql);
        $query->execute();
        if ($query==true) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }
    //Funcion para la consulta de la medicacion que se hizo en la atencion
    //descontando los medicamnetos de la tabala recuros.
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



    // Funcion para consultar el procedimiento realizado.
    function consultarProcedimiento($idAtencion){
        $sql="select nombreCUP,codigoCup,descripcionProcedimiento,idHistoriaClinica,idProcedimiento
              from tbl_cup as cup
              inner join tbl_procedimiento as pro
              on cup.idCUP=pro.idCUP
              where idHistoriaClinica=:idAtencion";
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

    // Funcion para consultar el paciente  que se realizo en la atencion
    function consultarIdPaciente($idAtencion){

        $sql="select  idPaciente
              from tbl_historiaclinica
              where idPaciente=:cod";
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

    // Funcion para consultar el origen  de la atencion por la cual  le hiceron en la atencion
    function consultarOrigenAtencion($idAtencion){
        $sql="CALL spConsultarAtencionOrigenDmc(?)";
        $conn=$this->_CONEXION;
        $query=$conn->prepare($sql);
        $query->bindParam(1,$idAtencion,PDO::PARAM_STR);
        $query->execute();

        if($query==true){
            return $query->fetchAll();
        }
        return null;
    }


    function consultarAntecedentes($idAtencion){

        $sql="CALL spConsultarAntecedentesDmc(?)";
        $conn=$this->_CONEXION;
        $query=$conn->prepare($sql);
        $query->bindParam(1,$idAtencion,PDO::PARAM_STR);
        $query->execute();
        if($query==true){
            return $query->fetchAll();
        }else{
            return null;
        }
    }

    // Funcion para consultar el procedimiento realizadoo a un paciente,
    //agregandole la nota del procedieminto realizado pero por la enfermera.


}




?>
