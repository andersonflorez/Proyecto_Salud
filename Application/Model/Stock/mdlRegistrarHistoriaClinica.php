<?php

/**
 * Modelo Para desarrolar las instrucciones del CRUD de Las maestras de Historia Clinica de Domiciliaria
 */
class   mdlRegistrarHistoriaClinica implements iModel {

    private static $_INSTANCIA; // Instancia única de esta clase
    private $_CONEXION;         // Variable de conexión PDO

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

    function listarTipoExamenFisico(){
        $sql = "CALL spListarTipoexamenespecializado()";
        $query = $this->_CONEXION->prepare($sql);
        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    function listarEspecialidad() {
        $sql = "CALL spListarEspecialidad()";
        $query = $this->_CONEXION->prepare($sql);
        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    function listarMedicamento() {
        $sql = "CALL spListarMedicamentoDmc()";
        $query = $this->_CONEXION->prepare($sql);
        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }
    function listarCie10(){
        $sql = "CALL spListarCie10()";
        $query =$this->_CONEXION->prepare($sql);
        if ($query->execute()) {
            return $query->fetchAll();
        }else {
            return null;
        }

    }
    function listarTratamiento(){
        $sql = "CALL spListarTipotratamiento()";
        $query =$this->_CONEXION->prepare($sql);
        if ($query->execute()) {
            return $query->fetchAll();
        }else {
            return null;
        }

    }
    function listarEquipo(){
        $sql = "select idRecurso, nombre from tbl_recurso where idCategoriaRecurso = 2";
        $query =$this->_CONEXION->prepare($sql);
        if ($query->execute()) {
            return $query->fetchAll();
        }else {
            return null;
        }

    }

    function listarMedicacion($idPersona){
        $sql = " select dk.idDetalleKit,r.nombre,cantidadFinal as cantidadTotal
        from tbl_detallekit dk
        inner join tbl_recurso r
        on dk.idRecurso=r.idRecurso
        inner join tbl_asignacionkit ak
        on dk.idAsignacion = ak.idAsignacion
        where ak.idPersona = :idPersona";
        $query =$this->_CONEXION->prepare($sql);
        $query->bindParam(":idPersona",$idPersona);
        if ($query->execute()) {
            return $query->fetchAll();
        }else {
            return null;
        }

    }


    function consultarInformacionPersonal($codigo) {
        $sql = "CALL spConsultarPaciente(?)";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1,$codigo,PDO::PARAM_STR);
        if ($query->execute()) {
            return $query->fetch();
        } else {
            return null;
        }
    }

    function listarTipoDocumento() {
        $sql = "CALL spListarTipodocumento()";
        $query = $this->_CONEXION->prepare($sql);
        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    function listarOrigenAtencion() {
        $sql = "CALL spListarTipoorigenatencion()";
        $query = $this->_CONEXION->prepare($sql);
        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    function listarTipoAntecedentes() {
        $sql = "CALL spListarTipoantecedente()";
        $query = $this->_CONEXION->prepare($sql);
        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    function ListarExamenFisico() {
        $sql = "CALL spListarTipoexamenfisico()";
        $query = $this->_CONEXION->prepare($sql);
        if ($query->execute()) {
            return $query->fetchAll();
        }else{
            return null;
        }
    }

    function comboDiagnostico() {
        $sql = "CALL spListarCie10()";
        $conn=$this->_CONEXION;
        $query=$conn->prepare($sql);
        $query->execute();
        return $query->fetchAll();

    }

    function consultarDescripcionProcedimiento($filtro) {
        $sql = "select idCup as id, nombreCup from tbl_cup where nombreCup LIKE '%".$filtro."%'";
        //"CALL spconsultarDescripcionProcedimiento";
        $query =$this->_CONEXION->prepare($sql);
        $query->execute();
        return $query->fetchAll();

    }

    function consultarDescripcionIdProcedimiento($id) {
        $sql = "select nombreCup from tbl_cup where idCup = ".$id."";
        //"CALL spConsultarDescripcionIdProcedimiento()";
        $query =$this->_CONEXION->prepare($sql);
        $query->execute();
        return $query->fetch();

    }

    function consultarCodigoIdProcedimiento($id) {
        $sql = "select codigoCup from tbl_cup where idCup = ".$id."";
        //"CALL spConsultarCodigoIdProcedimiento()";
        $query =$this->_CONEXION->prepare($sql);
        $query->execute();
        return $query->fetch();

    }

    function contarDescripcionProcedimiento($filtro) {
        $sql = "select count(idCup) as cont from tbl_cup where nombreCup LIKE '%".$filtro."%'";
        //"CALL spContarDescripcionProcedimiento";
        $query =$this->_CONEXION->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    function consultarCodigoProcedimiento($filtro) {
        $sql = "select idCup as id, codigoCup from tbl_cup where codigoCup LIKE '%".$filtro."%'";
        //"CALL spConsultarCodigoProcedimientos";
        $query =$this->_CONEXION->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }


    function contarCodigoProcedimiento($filtro) {
        $sql = "select count(idCup) as cont from tbl_cup where codigoCup LIKE '%".$filtro."%'";
        $query =$this->_CONEXION->prepare($sql);
        //"CALL spContarCodigoProcedimiento";
        $query->execute();
        return $query->fetch();
    }








    function consultarDescripcionIdDiagnostico($id) {
        $sql = "select descripcionCIE10 from tbl_cie10 where idCIE10 = ".$id."";
        //"CALL spConsultarDescripcionIdDiagnostico";
        $query =$this->_CONEXION->prepare($sql);
        $query->execute();
        return $query->fetch();

    }

    function consultarCodigoIdDiagnostico($id) {
        $sql = "select codigoCIE10 from tbl_cie10 where idCIE10 = ".$id."";
        //" CALL spConsultarCodigoIdDiagnostico";
        $query =$this->_CONEXION->prepare($sql);
        $query->execute();
        return $query->fetch();

    }

    function consultarDescripcionDiagnostico($filtro) {
        $sql = "select idCIE10 as id, descripcionCIE10 from tbl_cie10 where descripcionCIE10 LIKE '%".$filtro."%'";
        //"CALL spConsultarDescripcionDiagnostico  ";
        $query =$this->_CONEXION->prepare($sql);
        $query->execute();
        return $query->fetchAll();

    }


    function contarDescripcionDiagnostico($filtro) {
        $sql = "select count(idCIE10) as cont from tbl_cie10 where descripcionCIE10 LIKE '%".$filtro."%'";
        //"CALL spContarDiagnostico";
        $query =$this->_CONEXION->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    function consultarCodigoDiagnostico($filtro) {
        $sql = "select idCIE10 as id, codigoCIE10 from tbl_cie10 where codigoCIE10 LIKE '%".$filtro."%'";
        //"CALL spConsultarCodigoDiagnostico";
        $query =$this->_CONEXION->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }


    function contarCodigoDiagnostico($filtro) {
        $sql = "select count(idCIE10) as cont from tbl_cie10 where codigoCIE10 LIKE '%".$filtro."%'";
        //"CALL spContarCodigoDiagnostico ";
        $query =$this->_CONEXION->prepare($sql);
        $query->execute();
        return $query->fetch();
    }


    function actualizarInformacionPersonal($idPaciente,$estadoCivil,$ciudadResidencia,$barrioResidencia,$direccion,$correoElectronico,$telefonoFijo,$telefonoMovil,$empresa,$ocupacion){
        $sql = "UPDATE tbl_paciente set estadoCivil='".$estadoCivil."',ciudadResidencia='".$ciudadResidencia."',barrioResidencia='".$barrioResidencia."',direccion='".$direccion."',correoElectronico='".$correoElectronico."',telefonoFijo='".$telefonoFijo."',telefonoMovil='".$telefonoMovil."',empresa='".$empresa."',ocupacion='".$ocupacion."' where idPaciente='".$idPaciente."'";
        //"CALLspActualizarInformacionPersonal ";
        $query =$this->_CONEXION->prepare($sql);
        if ($query->execute()) {
            return true;
        }else {
            return null;
        }
    }

    function registrarTipoOrigenAtencion($descripcion){
        $sql = "insert into tbl_tipoorigenatencion(descripcionOrigenAtencion,estadoTabla) values(:descripcion,'Inactivo')";
        //"CALL spRegistrarTipoOrigenAtencion";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(":descripcion",$descripcion,PDO::PARAM_STR);
        $query->execute();
        $sql = "select max(idTipoOrigenAtencion) as id from tbl_tipoorigenatencion";
        $query = $this->_CONEXION->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    function registrarHistoriaClinica($fechaAtencion,$motivoAtencion,$enfermedadActual,$placaVehiculo,$idTipoOrigenAtencion,$idCitaProgramacion,$idPaciente,$evolucion){
        $sql = "insert into tbl_historiaclinica(fechaAtencion,motivoAtencion,enfermedadActual,placaVehiculo,idTipoorigenAtencion,idCitaprogramacion,idPaciente,evolucion) values(:fechaAtencion,:motivoAtencion,:enfermedadActual,:placaVehiculo,:idTipoOrigenAtencion,:idCitaProgramacion,:idPaciente,:evolucion);";
        //"CALL spRegistrarHistoriaClinicaDmc";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(":fechaAtencion",$fechaAtencion,PDO::PARAM_STR);
        $query->bindParam(":motivoAtencion",$motivoAtencion,PDO::PARAM_STR);
        $query->bindParam(":enfermedadActual",$enfermedadActual,PDO::PARAM_STR);
        $query->bindParam(":placaVehiculo",$placaVehiculo,PDO::PARAM_STR);
        $query->bindParam(":idTipoOrigenAtencion",$idTipoOrigenAtencion,PDO::PARAM_STR);
        $query->bindParam(":idCitaProgramacion",$idCitaProgramacion,PDO::PARAM_STR);
        $query->bindParam(":idPaciente",$idPaciente,PDO::PARAM_STR);
        $query->bindParam(":evolucion",$evolucion,PDO::PARAM_STR);
        $query->execute();

        $sql = "select max(idHistoriaClinica) as id from tbl_historiaclinica";
        $query = $this->_CONEXION->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    function registrarAntecedente($descripcion,$idTipoAntecedente,$idHistoriaClinica){
        $sql = "insert into tbl_antecedentedmc(descripcionAntecedente,idTipoAntecedente,idHistoriaClinica) values(:descripcion,:idTipoAntecedente,:idHistoriaClinica);";
        // "CALL spRegistrarAntecedentesDmc ";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(":descripcion",$descripcion,PDO::PARAM_STR);
        $query->bindParam(":idTipoAntecedente",$idTipoAntecedente,PDO::PARAM_STR);
        $query->bindParam(":idHistoriaClinica",$idHistoriaClinica,PDO::PARAM_STR);
        $query->execute();
    }

    function registrarExamenFisico($descripcion,$idTipoExamenFisico,$estado,$idHistoriaClinica){
        $sql = "insert into tbl_examenfisicodmc(descripcionExamen,idtipoExamenFisico,estadoTablaExamen,idHistoriaClinica) values(:descripcion,:idTipoExamenFisico,:estado,:idHistoriaClinica);";
          // "CALL spRegistrarExamenFisico";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(":descripcion",$descripcion,PDO::PARAM_STR);
        $query->bindParam(":idTipoExamenFisico",$idTipoExamenFisico,PDO::PARAM_STR);
        $query->bindParam(":estado",$estado,PDO::PARAM_STR);
        $query->bindParam(":idHistoriaClinica",$idHistoriaClinica,PDO::PARAM_STR);
        $query->execute();
    }

    function registrarDiagnostico($descripcion,$idCIE10,$idHistoriaClinica){
        $sql = "insert into tbl_diagnostico(descripcionDiagnostico,idCIE10,idHistoriaClinica) values(:descripcion,:idCIE10,:idHistoriaClinica);";
          // "CALL spRegistrarDiagnostico";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(":descripcion",$descripcion,PDO::PARAM_STR);
        $query->bindParam(":idCIE10",$idCIE10,PDO::PARAM_STR);
        $query->bindParam(":idHistoriaClinica",$idHistoriaClinica,PDO::PARAM_STR);
        $query->execute();
    }

    function registrarProcedimiento($descripcion,$idCUP,$idHistoriaClinica){
        $sql = "insert into tbl_procedimiento(descripcionProcedimiento,idCUP,idHistoriaClinica) values(:descripcion,:idCUP,:idHistoriaClinica);";
       //"CALL spRegistrarProcedimiento";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(":descripcion",$descripcion,PDO::PARAM_STR);
        $query->bindParam(":idCUP",$idCUP,PDO::PARAM_STR);
        $query->bindParam(":idHistoriaClinica",$idHistoriaClinica,PDO::PARAM_STR);
        $query->execute();
    }

    function registrarSignosVitales($resultado,$hora,$idValoracion,$idHistoriaClinica){
        $sql = "insert into tbl_signosvitales(resultado,hora,idValoracion,idHistoriaClinica) values(:resultado,:hora,:idValoracion,:idHistoriaClinica);";
        //"CALL spRegistrarSignosVitales";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(":resultado",$resultado,PDO::PARAM_STR);
        $query->bindParam(":hora",$hora,PDO::PARAM_STR);
        $query->bindParam(":idValoracion",$idValoracion,PDO::PARAM_STR);
        $query->bindParam(":idHistoriaClinica",$idHistoriaClinica,PDO::PARAM_STR);
        $query->execute();
    }


    //update tbl_detallekit dt1,(select cantidadFinal-3 as nuevaCantidad from tbl_detallekit where idDetallekit = 1)as dt2 set dt1.cantidadFinal = dt2.nuevaCantidad where idDetallekit = 1
    function registrarMedicacion($dosis,$hora,$viaAdministracion,$cantidadUnidades,$idDetalleKit,$idHistoriaClinica){
        $sql = "insert into tbl_medicamento(dosis,hora,viaAdministracion,cantidadUnidades,idDetalleKit,idHistoriaClinica) values(:dosis,:hora,:viaAdministracion,:cantidadUnidades,:idDetalleKit,:idHistoriaClinica);";
       // "CALL spRegistrarMedicacionDmc";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(":dosis",$dosis,PDO::PARAM_STR);
        $query->bindParam(":hora",$hora,PDO::PARAM_STR);
        $query->bindParam(":viaAdministracion",$viaAdministracion,PDO::PARAM_STR);
        $query->bindParam(":cantidadUnidades",$cantidadUnidades,PDO::PARAM_STR);
        $query->bindParam(":idDetalleKit",$idDetalleKit,PDO::PARAM_STR);
        $query->bindParam(":idHistoriaClinica",$idHistoriaClinica,PDO::PARAM_STR);
        $query->execute();
        $sql = "update tbl_detallekit dt1,(select cantidadFinal-:cantidadUnidades as nuevaCantidad from tbl_detallekit where idDetallekit = :idDetalleKit)as dt2 set dt1.cantidadFinal = dt2.nuevaCantidad where idDetallekit = :idDetalleKit;";
       //"CALL spActualizarMedicacionDmc";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(":cantidadUnidades",$cantidadUnidades,PDO::PARAM_INT);
        $query->bindParam(":idDetalleKit",$idDetalleKit,PDO::PARAM_STR);
        $query->execute();
    }


    function registrarTipoTratamiento($descripcion){
        $sql = "insert into tbl_tipotratamiento(Descripcion,categoriaItemTratamiento,estadoTabla) values(:descripcion,'Básico','Inactivo')";
        //"CALL spRegistrarTTratamiento";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(":descripcion",$descripcion,PDO::PARAM_STR);
        $query->execute();
        $sql = "select max(idTipoTratamiento) as id from tbl_tipotratamiento";
        $query = $this->_CONEXION->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    function registrarTratamiento($descripcion,$fecha,$dosis,$idHistoriaClinica,$idTipoTratamiento){
        $sql = "insert into tbl_tratamientodmc(descripcionTratamiento,fechaTratamiento,dosisTratamiento,idHistoriaClinica,idTipoTratamiento) values(:descripcion,:fecha,:dosis,:idHistoriaClinica,:idTipoTratamiento)";
       //"CALL spRegistrarTratamiento";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(":descripcion",$descripcion,PDO::PARAM_STR);
        $query->bindParam(":fecha",$fecha,PDO::PARAM_STR);
        $query->bindParam(":dosis",$dosis,PDO::PARAM_STR);
        $query->bindParam(":idHistoriaClinica",$idHistoriaClinica,PDO::PARAM_STR);
        $query->bindParam(":idTipoTratamiento",$idTipoTratamiento,PDO::PARAM_STR);
        $query->execute();
        $sql = "select max(idTratamiento) as id from tbl_tratamientodmc";
        $query = $this->_CONEXION->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    function registrarDetalleTratamientoEquipoBiomedico($idTratamiento,$descripcion){
        $sql = "insert into tbl_equipobiomedico(descripcion,idTratamiento) values(:descripcion,:idTratamiento);";
        //"CALL spRegistrarDetalleTratamientoEquipoBiomedico";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(":descripcion",$descripcion);
        $query->bindParam(":idTratamiento",$idTratamiento);
        $query->execute();
    }

    function registrarDetalleTratamientoRecurso($idTratamiento,$idRecurso){
        $sql = "insert into tbl_detalletratamientodmcrecurso(idTratamiento,idRecurso) values(:idTratamiento,:idRecurso);";
        //"CALL spRegistrarDetalleTratamientoRecurso";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(":idTratamiento",$idTratamiento);
        $query->bindParam(":idRecurso",$idRecurso);
        $query->execute();
    }

    function registrarFormulaMedica($recomendacion,$idHistoriaClinica){
        $sql = "insert into tbl_formulamedica(recomendaciones,idHistoriaClinica) values(:recomendacion,:idHistoriaClinica)";
        //"CALL spRegistrarFormulaMedica";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(":recomendacion",$recomendacion,PDO::PARAM_STR);
        $query->bindParam(":idHistoriaClinica",$idHistoriaClinica,PDO::PARAM_STR);
        $query->execute();
        $sql = "select max(idFormulaMedica) as id from tbl_formulamedica";
        $query = $this->_CONEXION->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    function registrarFormulaMedicaMedicamentos($dosificacion,$descripcion,$cantidadMedicamento,$idMedicamento,$idFormulaMedica){
        $sql = "insert into tbl_formulamedicamedicamentodmc(dosificacion,descripcion,cantidadMedicamento,idMedicamento,idFormulaMedica) values(:dosificacion,:descripcion,:cantidadMedicamento,:idMedicamento,:idFormulaMedica);";
        //"CALL spRegistrarFormulaMedicamento";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(":dosificacion",$dosificacion,PDO::PARAM_STR);
        $query->bindParam(":descripcion",$descripcion,PDO::PARAM_STR);
        $query->bindParam(":cantidadMedicamento",$cantidadMedicamento,PDO::PARAM_STR);
        $query->bindParam(":idMedicamento",$idMedicamento,PDO::PARAM_STR);
        $query->bindParam(":idFormulaMedica",$idFormulaMedica,PDO::PARAM_STR);
        $query->execute();
    }

    function registrarTipoExamenEspecializado($descripcion){
        $sql = "insert into tbl_tipoexamenespecializado(descripcion,estadoTabla) values(:descripcion,'Inactivo')";
        //"CALL spRegistrarTExamenesEspecializados";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(":descripcion",$descripcion,PDO::PARAM_STR);
        $query->execute();
        $sql = "select max(idTipoExamenEspecializado) as id from tbl_tipoexamenespecializado";
        $query = $this->_CONEXION->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    function registrarExamenEspecializado($historiaClinica, $observacion, $idTipoExamenEspecializado,$descripcion){
        $sql = "insert into tbl_examenespecializado(idHistoriaClinica,observaciones,idTipoExamenEspecializado,descripcion) values(:historiaClinica,:observacion,:idTipoExamenEspecializado,:descripcion);";
       //"CALL spRegistrarExameneEspecializado";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(":historiaClinica",$historiaClinica,PDO::PARAM_STR);
        $query->bindParam(":observacion",$observacion,PDO::PARAM_STR);
        $query->bindParam(":idTipoExamenEspecializado",$idTipoExamenEspecializado,PDO::PARAM_STR);
        $query->bindParam(":descripcion",$descripcion,PDO::PARAM_STR);
        $query->execute();
    }
    function registrarInterconsulta($descripcion,$especialidad,$idHistoriaClinica,$fechaLimite){
        $sql = "insert into tbl_interconsulta(descripcionInterconsulta,especialidad,idHistoriaClinica,fechaLimite) values(:descripcionInterconsulta,:especialidad,:idHistoriaClinica,:fechaLimite)";
        //"CALL spRegistrarInterconsulta ";
        $query =$this->_CONEXION->prepare($sql);
        $query->bindParam(":descripcionInterconsulta",$descripcion,PDO::PARAM_STR);
        $query->bindParam(":especialidad",$especialidad,PDO::PARAM_STR);
        $query->bindParam(":idHistoriaClinica",$idHistoriaClinica,PDO::PARAM_STR);
        $query->bindParam(":fechaLimite",$fechaLimite,PDO::PARAM_STR);
        $query->execute();
    }

    function registrarIncapacidad($numeroDias,$descripcion,$idCie10,$prorroga,$idHistoriaClinica){
        $sql = "insert into tbl_incapacidad(cantidadDias,prorroga,descripcionMotivo,idCIE10,idHistoriaClinica) values(:cantidadDias,:prorroga,:descripcionMotivo,:idCIE10,:idHistoriaClinica)";
        //"CALL spRegistrarIncapacidad(?,?,?,?,?)";
        $query =$this->_CONEXION->prepare($sql);
        $query->bindParam(":cantidadDias",$numeroDias,PDO::PARAM_STR);
        $query->bindParam(":prorroga",$prorroga,PDO::PARAM_STR);
        $query->bindParam(":descripcionMotivo",$descripcion,PDO::PARAM_STR);
        $query->bindParam(":idCIE10",$idCie10,PDO::PARAM_STR);
        $query->bindParam(":idHistoriaClinica",$idHistoriaClinica,PDO::PARAM_STR);
        $query->execute();
    }

    function registrarOtro($descripcion,$idHistoriaClinica){
        $sql = "insert into tbl_otrodmc(descripcion,idHistoriaClinica) values(:descripcion,:idHistoriaClinica)";
        //"CALL spRegistrarOtroDmc(?,?)";
        $query =$this->_CONEXION->prepare($sql);
        $query->bindParam(":descripcion",$descripcion,PDO::PARAM_STR);
        $query->bindParam(":idHistoriaClinica",$idHistoriaClinica,PDO::PARAM_STR);
        $query->execute();
    }

    function cambiarEstadoCita($idCita){
        $sql = "update tbl_cita set estadoTablaCita='Terminada' where idCita=:idCita";
        //"CALL spCambiarEstadoCita(?)";
        $query =$this->_CONEXION->prepare($sql);
        $query->bindParam(":idCita",$idCita,PDO::PARAM_STR);
        $query->execute();
    }

}
?>
