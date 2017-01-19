<?php

class MdlConsultarOrdenes implements iModel{

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

    function consultarIndex(){
        $sql="CALL spConsultarHistoriaClinic()";
        $conn=$this->_CONEXION;
        $query=$conn->prepare($sql);
        if($query->execute()){
            return $query->fetchAll();
        }else{
            return null;
        }
    }

    function consultarPersona($id){
      $sql="CALL spConsultarPersonaAtencion(?)";
      $conn= $this->_CONEXION;
      $query = $conn->prepare($sql);
      $query->bindParam(1,$id);

      if ($query->execute()) {
        return $query->fetch();
      }else{
        return null;
      }
    }

    function consultarPaciente($id){
      $sql="CALL spConsultarPacienteAtencion(?)";
      $conn= $this->_CONEXION;
      $query = $conn->prepare($sql);
      $query->bindParam(1,$id);

      if ($query->execute()) {
        return $query->fetch();
      }else{
        return null;
      }
    }

   function consultarFechaAtencion($id)
    {
      $sql = "CALL spConsultarFechaAtencion(?)";
      $conn = $this->_CONEXION;
      $query= $conn->prepare($sql);
      $query->bindParam(1,$id);
      if ($query->execute()) {
        return $query->fetch();
      }else{
        return null;
      }
    }

    //Funcion para consultar Formula Medica.
    function consultarFormulaMedica($idAtencion){
        $sql="select idFormulaMedica,recomendaciones from tbl_formulamedica
        where idHistoriaClinica = :idAtencion";
        $conn=$this->_CONEXION;
        $query=$conn->prepare($sql);
        $query->bindParam(":idAtencion",$idAtencion,PDO::PARAM_STR);
        $query->execute();
        if($query==true){
            return $query->fetch();
        }else{
            return null;
        }
    }

    //Funcion para detalle formula medicamento
    function consultarDetalleFormula($idFormula){
        $sql="select rec.nombre as nombreMedicamento,formuMedi.cantidadMedicamento,formuMedi.dosificacion,formuMedi.descripcion
        from tbl_recurso rec
        inner join tbl_formulamedicamedicamentodmc as formuMedi
        on rec.idRecurso = formuMedi.idMedicamento
        where formuMedi.idFormulaMedica = :idFormula";
        $conn=$this->_CONEXION;
        $query=$conn->prepare($sql);
        $query->bindParam(":idFormula",$idFormula,PDO::PARAM_STR);
        $query->execute();
        if($query==true){
            return $query->fetchAll();
        }else{
            return null;
        }
    }

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
        $query->execute();
        if($query==true){
            return $query->fetch();
        }else{
            return null;
        }
    }
    //Funcion para consultar los equipos

    function consultarDetalleTratamiento($idTratamiento){
        $sql="select recur.nombre from tbl_recurso as recur inner join tbl_detalletratamientodmcrecurso as detalleTratamiento on recur.idRecurso = detalleTratamiento.idRecurso
        where detalleTratamiento.idTratamiento=:idTratamiento";
        $conn=$this->_CONEXION;
        $query=$conn->prepare($sql);
        $query->bindParam(":idTratamiento",$idTratamiento,PDO::PARAM_STR);
        $query->execute();
        if($query==true){
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
        $query->execute();
        if($query==true){
            return $query->fetchAll();
        }else{
            return null;
        }
    }
    //Funcion de examenes Especializados
    function consultarExamenEspecializado($idAtencion){
        $sql="select tipoExamen.descripcion as nombreTipoExamen,observaciones,examenEspecial.descripcion from tbl_tipoexamenespecializado as tipoExamen inner join tbl_examenespecializado as examenEspecial
        on tipoExamen.idTipoexamenespecializado = examenEspecial.idTipoexamenespecializado
        where idHistoriaClinica = :idAtencion";
        $conn=$this->_CONEXION;
        $query=$conn->prepare($sql);
        $query->bindParam(":idAtencion",$idAtencion,PDO::PARAM_STR);
        $query->execute();
        if($query==true){
            return $query->fetch();
        }else{
            return null;
        }
    }
    //Funcion de interconsulta
    function consultarInterconsulta($idAtencion){
        $sql="select descripcionInterconsulta,especialidad,fechaLimite
        from tbl_interconsulta
        where idHistoriaClinica= :idAtencion";
        $conn=$this->_CONEXION;
        $query=$conn->prepare($sql);
        $query->bindParam(":idAtencion",$idAtencion,PDO::PARAM_STR);
        $query->execute();
        if($query==true){
            return $query->fetch();
        }else{
            return null;
        }
    }
    //Funcion para orden de incapacidad
    function consultarIncapacidad($idAtencion){
        $sql="select cantidadDias,prorroga,descripcionMotivo,cie.codigoCIE10,cie.descripcionCIE10
                from tbl_incapacidad as incapacidad
                inner join tbl_cie10 as cie
                on incapacidad.idCIE10 = cie.idCIE10
                where idHistoriaClinica = :idAtencion";
        $conn=$this->_CONEXION;
        $query=$conn->prepare($sql);
        $query->bindParam(":idAtencion",$idAtencion,PDO::PARAM_STR);
        $query->execute();
        if($query==true){
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
        $query->execute();
        if($query==true){
            return $query->fetch();
        }else{
            return null;
        }

    }

    function consultarEmailPaciente($idPaciente){
        $sql = "CALL spConsultarEmailPaciente(?)";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1,$idPaciente,PDO::PARAM_STR);
		if ($query->execute()) {
			return $query->fetch()->correoElectronico;
		} else {
			return null;
		}
    }

}





?>
