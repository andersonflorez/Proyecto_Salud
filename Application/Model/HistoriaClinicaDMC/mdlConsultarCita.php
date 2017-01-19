<?php

/**
 * Modelo Para desarrolar las instrucciones del CRUD de Las maestras de Historia Clinica de Domiciliaria
 */
class   mdlConsultarCita implements iModel {

    private static $_INSTANCIA; // Instancia única de esta clase
    private $_CONEXION;         // Variable de conexión PDO
    private $_id;
    private $_fecha;
    private $_descripcion;
    private $_idCita;
    private function __construct($_CON) {
        $this->_CONEXION = $_CON;
    }
    /*
     * Función getInstance():
     * Devuelve la única instancia de esta clase.
     * Recibe la conexión PDO como parámetro.
     */
     public function __SET($atributo, $valor){
         $this->$atributo = $valor;
     }

     public function __GET($atributo){
         return $this->$atributo;
     }

    public static function getInstance($_CONEXION) {
        if (!self::$_INSTANCIA instanceof self) {
            self::$_INSTANCIA = new self($_CONEXION);
        }
        return self::$_INSTANCIA;
    }

    function consultarCitas() {
        $id = $this->__GET("_id");
        $sql = "SELECT * from viewconsultarcitamedico
        WHERE idPersona=?
        ORDER BY horaInicial ASC";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1,$id);
        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }

   function cancelarCita(){
     $fecha = $this->__GET("_fecha");
     $descripcion = $this->__GET("_descripcion");
     $idCita= $this->__GET("_idCita");

     try {
       $sql = "CALL spRegistrarHistorialmora(?,?,?)";
       $query = $this->_CONEXION->prepare($sql);
       $query->bindParam(1,$fecha);
       $query->bindParam(2,$descripcion);
       $query->bindParam(3,$idCita);
       if ($query->execute()) {
         return "0";
         }else {
         return "1";
        }
     } catch (Exception $e) {
        return "1";
     }
   }


   function cambiarEstado(){
       $id = $this->__GET("_idCita");
     $sql = "CALL spCambiarEstadoCitaCancelar(?)";
     $query = $this->_CONEXION->prepare($sql);
     $query->bindParam(1,$id);
     if ($query->execute()) {
       return "0";
       }else {
       return "1";
      }
   }

   function cambiarEstadoProceso(){
       $id = $this->__GET("_id");
     $sql = "CALL spCambiarEstadoCitaProceso(?)";
     $query = $this->_CONEXION->prepare($sql);
     $query->bindParam(1,$id);
     if ($query->execute()) {
       return "0";
       }else {
       return "1";
      }
   }

   function consultarCitaPersona(){
       $id = $this->__GET("_id");
     $sql = "SELECT PA.idPaciente, PA.primerNombre, PA.primerApellido,ifnull(PA.segundoNombre,'') as 'segundoNombre',
     PA.segundoApellido,PA.numeroDocumento,C.horaInicial,C.horaFinal,C.direccionCita, CU.nombreCUP,CU.codigoCUP,CP.idCitaProgramacion,PA.barrioResidencia,z.descripcionZona,C.telefonoFijo1,C.telefonoFijo2,
     TD.descripcionTdocumento
     FROM tbl_cita C
     INNER JOIN tbl_paciente PA ON PA.idPaciente = C.idPaciente
     INNER JOIN tbl_tipodocumento TD ON TD.idTipoDocumento = PA.idtipoDocumento
     INNER JOIN tbl_cita_programacion CP ON C.idCita = CP.idcita
     INNER JOIN tbl_turnoprogramacion TP ON CP.idTurnoProgramacion = TP.idTurnoProgramacion
     INNER JOIN tbl_persona PE ON PE.idPersona = TP.idPersona
     INNER JOIN tbl_programacion P ON P.idProgramacion = TP.idProgramacion
     INNER JOIN tbl_turno T ON T.idTurno = TP.idTurno
     INNER JOIN tbl_cup CU ON	CU.idCup = C.idCUP
     INNER JOIN tbl_zona z ON z.idZona = C.idZona
     WHERE C.idCita=?";
     $query = $this->_CONEXION->prepare($sql);
     $query->bindParam(1,$id);
     if ($query->execute()) {
         return $query->fetchAll();
     } else {
         return null;
     }
   }

    function consultarHoraCita($cod){
        $sql="select horaInicial from tbl_cita
        where idCita=:cod";
        $conn=$this->_CONEXION;
        $query=$conn->prepare($sql);
        $query->bindParam(":cod",$cod,PDO::PARAM_STR);
        $query->execute();
        if($query==true){
            return $query->fetch();
        }else{
            return null;
        }
    }

}
?>
