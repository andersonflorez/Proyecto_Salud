<?php

class MdlConsultarAtencion implements iModel{

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
    function consultarAtencion($cod){
        $sql="CALL spConsultarAtencionDmc(?)";
        $conn=$this->_CONEXION;
        $query=$conn->prepare($sql);
        $query->bindParam(1,$cod,PDO::PARAM_STR);
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
    // Funcion para consultar los Diagnosticos de un paciente.
    function consultarDiagnostico($idAtencion){
        $sql="CALL spConsultarDiagnosticoDmc(?)";
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

    // Funcion para la consulta de un examen Fisico realizado en una atencion
    function consultarExamenFisico($idAtencion){
        $sql="CALL spConsultarExamenesfisicoDmc(?)";
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
        $sql="CALL spConsultarMedicacionDmc(?)";
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



    // Funcion para consultar el procedimiento realizado.
    function consultarProcedimiento($idAtencion){
        $sql="CALL spConsultarProcedimientoDmc(?)";
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

    // Funcion para consultar el paciente  que se realizo en la atencion
    function consultarIdPaciente($idAtencion){

        $sql="CALL spConsultarPacienteIdDmc(?)";
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
    // Funcion para consultar signos Vitales que se hiceron en la atencion
    function consultarHoraSignosVitales($idAtencion){
        $sql="CALL spConsultarHoraSignosVitales(?)";
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
    // Funcion para consultar signos Vitales los resultados que le dieron en la atencion
    function consultarResultadoSignosVitales($idAtencion){
        $sql="CALL spConsultarResultadosSignosVitales(?)";
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
    function registarNotasEnfermeria($descripcion,$idProcedimiento,$idPersona){
        $sql="CALL spRegistrarNotaenfermeria(?,?,?)";
        $conn= $this->_CONEXION;
        $query=$conn->prepare($sql);
        $query->bindParam(1,$descripcion,PDO::PARAM_STR);
        $query->bindParam(2,$idPersona,PDO::PARAM_STR);
        $query->bindParam(3,$idProcedimiento,PDO::PARAM_STR);
        $query->execute();
    }
    // Funcion para consultar el procedimiento realizadoo a un paciente, 
    //agregandole la nota del procedieminto realizado pero por la enfermera.
    function consultarProcedimientoNotas($idProcedimiento){
        $sql="CALL spConsultarProcedimientosNotas(?)";
        $conn=$this->_CONEXION;
        $query=$conn->prepare($sql);
        $query->bindParam(1,$idProcedimiento,PDO::PARAM_STR);
        $query->execute();
        if($query==true){
            return $query->fetchAll();
        }else{
            return null;
        }
    }







}




?>