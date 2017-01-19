<?php

/**
* Modelo nombre_modelo:
* Escribe aqui una descripcion de lo que hace
* este modelo. Copia esta estructura básica y
* utilízala en todos los modelos que necesites
* crear. Todos los modelos deben tener esta
* estructura.
*/
class MdlCitas implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO
  # Atributos de la clase:
  private $_filtros;
  // Tabla tipo zona
  private $_idTipoZona;
  // Variables de paciente
  private $_Documento;
  private $_FechaNacimiento;
  private $_idTipoDocumento;
  // Variables de programacion
  private $_idTurnoProgramacion;
  private $_fechaProgramacion;
  // Variable de cita
  private $_idCita;
  private $_DireccionCita;
  private $_FechaCita;
  private $_HoraInicialCita;
  private $_HoraFinalCita;
  private $_TelFijo1Cita;
  private $_TelFijo2Cita;
  private $_idPaciente;
  private $_cupCita;
  private $_zonaCita;
  private $_fechaActual;
  private $_estadoCita;
  private $_descripcionCup;
  private $_DatosPaciente;
  private $_idPersona;
  // Variable de persona
  private $_descripcionEspecialidad;
  private $_nombresMedico;
  private $_nombresEnfermeraJefe;
  private $_nombresAuxEnfermeriaM;
  //Cups
  private $_idCup;
  private $_idTipoCup;
  private $_CUP;
  private $_idConfig;
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

  public function ListarTipoDocumento(){
    $sql="CALL spListarTipodocumento()";
    $query=$this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return 'no está ejecutando el listar documento';
    }
  }
  public function ListarTipoZona(){
    $sql="CALL spListarTipozona()";
    $query=$this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return 'no está ejecutando el listar documento';
    }
  }

  public function ConsultarZona(){
    $idTipoZ=$this->__GET("_idTipoZona");
    $sql="CALL spConsultarZona(?)";
    $query=$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idTipoZ);
    if ($query->execute()) {
      return $query->fetchAll();
    }
    return 'no ejecutó la consulta de barrio';
  }
  public function listarCup(){
    $sql="CALL spListarCup()";
    $query=$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idTurnoP);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return false;
    }
  }
  public function ConfirmacionDatos(){
    $Documento=$this->__GET("_Documento");
    $Nacimiento=$this->__GET("_FechaNacimiento");
    $idTipoDocumento=$this->__GET("_idTipoDocumento");
    $sql="CALL spConfirmacionDatos(?,?,?)";
    $query=$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$Documento);
    $query->bindParam(2,$Nacimiento);
    $query->bindParam(3,$idTipoDocumento);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return 'no ejecutó la sentencia';
    }
  }
  public function ConsultarHorarioDisp(){
    $FechaCita=$this->__GET("_fechaProgramacion");
    $sql="CALL spConsultarHorario(?)";
    $query=$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$FechaCita,PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return false;
    }
  }

  public function RegistrarCita(){
    $Direccion=$this->__GET("_DireccionCita");
    $FechaCita=$this->__GET("_FechaCita");
    $HoraInicial=$this->__GET("_HoraInicialCita");
    $fecha_actual=date("Y/m/d");
    $HoraFinal=$this->__GET("_HoraFinalCita");
    $TelFijo1=$this->__GET("_TelFijo1Cita");
    $TelFijo2=$this->__GET("_TelFijo2Cita");
    $idPaciente=$this->__GET("_idPaciente");
    $cup=$this->__GET("_cupCita");
    $Zona=$this->__GET("_zonaCita");

    $sql="CALL spRegistrarCita(?,?,?,?,?,?,?,?,?,?,?)";
    $query=$this->_CONEXION->prepare($sql);
    $estado = "Iniciada";
    $query->bindParam(1,$estado);
    $query->bindParam(2,$Direccion);
    $query->bindParam(3,$FechaCita);
    $query->bindParam(4,$HoraInicial);
    $query->bindParam(5,$HoraFinal);
    $query->bindParam(6,$TelFijo1);
    $query->bindParam(7,$TelFijo2);
    $query->bindParam(8,$idPaciente);
    $query->bindParam(9,$cup);
    $query->bindParam(10,$Zona);
    $query->bindParam(11,$fecha_actual);

    if ($query->execute()) {
      return true;
    }else {
      return false;
    }
  }
  public function ConsultaIdCita(){
    $sql="CALL spConsultaIdCita()";
    $query=$this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetch();
    }else{
      return 'no ejecutó la sentencia';
    }
  }

  public function registroDetalle(){
    $idCita=$this->__GET("_idCita");
    $idProgram=$this->__GET("_idTurnoProgramacion");
    $sql="CALL spRegistrarDetalleCita(?,?)";
    $query=$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idCita,PDO::PARAM_INT);
    $query->bindParam(2,$idProgram);
    if ($query->execute()) {
      return true;
    }else{
      return false;
    }
  }
  public function ConsultarMedicos(){
    $fecha=$this->__GET("_FechaCita");
    $hora=$this->__GET("_HoraInicialCita");
    $profe=0;
    $sql="CALL spConsultaMedicos(?,?,?)";
    $query=$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$profe);
    $query->bindParam(2,$fecha);
    $query->bindParam(3,$hora);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return false;
    }
  }
  public function ConsultarMedicosEspecial(){
    $Especialidad=$this->__GET("_descripcionEspecialidad");
    $fecha=$this->__GET("_FechaCita");
    $hora=$this->__GET("_HoraInicialCita");
    $profe=0;
    $sql="CALL spConsultaMedicosEspecial(?,?,?,?)";
    $query=$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$profe);
    $query->bindParam(2,$fecha);
    $query->bindParam(3,$hora);
    $query->bindParam(4,$Especialidad);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return false;
    }
  }
  public function ConsultaNombresMedicos(){
    $Nombre=$this->__GET("_nombresMedico");
    $fecha=$this->__GET("_FechaCita");
    $hora=$this->__GET("_HoraInicialCita");
    $profe=0;
    $sql="CALL spConsultaNombresMedic(?,?,?,?)";
    $query=$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$profe);
    $query->bindParam(2,$fecha);
    $query->bindParam(3,$hora);
    $query->bindParam(4,$Nombre);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return false;
    }
  }
  public function ConsultaEnfermerosJefe(){
    $fecha=$this->__GET("_FechaCita");
    $hora=$this->__GET("_HoraInicialCita");
    $profe=0;
    $sql="CALL spConsultaEnfermerosJefe(?,?,?)";
    $query=$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$profe);
    $query->bindParam(2,$fecha);
    $query->bindParam(3,$hora);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return false;
    }
  }

  public function ConsultaNombresEnfJefe(){
    $Nombre=$this->__GET("_nombresEnfermeraJefe");
    $fecha=$this->__GET("_FechaCita");
    $hora=$this->__GET("_HoraInicialCita");
    $profe=0;
    $sql="CALL spConsultaNombresEnfermerosJefe(?,?,?,?)";
    $query=$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$profe);
    $query->bindParam(2,$fecha);
    $query->bindParam(3,$hora);
    $query->bindParam(4,$Nombre);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return false;
    }
  }
  public function ConsultarAuxEnfermeria(){
    $fecha=$this->__GET("_FechaCita");
    $hora=$this->__GET("_HoraInicialCita");
    $profe=0;
    $sql="CALL spConsultaAuxEnfermeria(?,?,?)";
    $query=$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$profe);
    $query->bindParam(2,$fecha);
    $query->bindParam(3,$hora);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return false;
    }
  }
  public function ConsultaNombresAuxEnf(){
    $Nombre=$this->__GET("_nombresAuxEnfermeriaM");
    $fecha=$this->__GET("_FechaCita");
    $hora=$this->__GET("_HoraInicialCita");
    $profe=0;
    $sql="CALL spConsultaNombresAuxEnfermeria(?,?,?,?)";
    $query=$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$profe);
    $query->bindParam(2,$fecha);
    $query->bindParam(3,$hora);
    $query->bindParam(4,$Nombre);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return false;
    }
  }
  public function ConsultarCitasMes(){
    $idPaciente=$this->__GET("_idPaciente");
    $PrimerDiaMes=$this->__GET("_primerDiaM");
    $UltimoDiaMes=$this->__GET("_ultimoDiaM");
    $diaActual=date("Y-m-d");

    $sql="CALL spConsultaCitasMes(?,?,?,?)";
    $query=$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idPaciente);
    $query->bindParam(2,$PrimerDiaMes);
    $query->bindParam(3,$UltimoDiaMes);
    $query->bindParam(4,$diaActual);
    if ($query->execute()) {
      return $query->fetch();
    }else{
      return false;
    }
  }
  public function ConsultarCitasDia(){
    $idPaciente=$this->__GET("_idPaciente");
    $fechaActual=$this->__GET("_fechaActual");

    $sql="CALL spConsultaCitasDia(?,?)";
    $query=$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idPaciente);
    $query->bindParam(2,$fechaActual);
    if ($query->execute()) {
      return $query->fetch();
    }else{
      return false;
    }
  }
  public function ConsultarCitasAsignadas(){
    $idPaciente=$this->__GET("_idPaciente");

    $sql="CALL spCitasAsignadas(?)";
    $query=$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idPaciente);
    if ($query->execute()) {
      return $query->fetch();
    }else{
      return false;
    }
  }

  public function RemoveMoraPaciente()
  {
    $sql="CALL spFinalizacionMulta()";
    $query=$this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return true;
    }else{
      return false;
    }
  }
  public function sugerenciaEnfermerosJefe()
  {
    $fecha=$this->__GET("_FechaCita");
    $hora=$this->__GET("_HoraInicialCita");
    $idPersona=$this->__GET("_idPersona");
    $profe=0;

    $sql="CALL spSugerenciaEnfermerosJefe(?,?,?,?)";
    $query=$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$profe);
    $query->bindParam(2,$fecha);
    $query->bindParam(3,$hora);
    $query->bindParam(4,$idPersona);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return false;
    }
  }
  public function sugerenciasAuxiliarEnfermeria()
  {
    $idPersona=$this->__GET("_idPersona");
    $fecha=$this->__GET("_FechaCita");
    $hora=$this->__GET("_HoraInicialCita");
    $profe=0;

    $sql="CALL spSugerenciaAuxiliarEnfermeria(?,?,?,?)";
    $query=$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$profe);
    $query->bindParam(2,$fecha);
    $query->bindParam(3,$hora);
    $query->bindParam(4,$idPersona);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return false;
    }
  }
  public function IDpersona()
  {
    $idTurnoP=$this->__GET("_idTurnoProgramacion");

    $sql="CALL spIdPersona(?)";
    $query=$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idTurnoP);

    if ($query->execute()) {
      return $query->fetch();
    }else{
      return false;
    }
  }
public function ConsultarProgramacionDias()
{
  $sql = "CALL spConsultarProgramacionCitaCalen()";
  $query = $this->_CONEXION->prepare($sql);
  if ($query->execute()) {
    return $query->fetchAll();
  }else {
    return null;
  }
}
  function __GET($atributo){
    return $this->$atributo;
  }
  function __SET($atributo,$valor){
    $this->$atributo = $valor;
  }

  public function ConsultarCitasPersonal(){
    $idCita=$this->__GET("_idCita");
    $sql = "CALL spConsultarCitaInner(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idCita);
    if ($query->execute()) {
      return $query->fetchAll();
    }else {
      return false;
    }
  }

  public function cancelarCitaRegistrarMora(){
    $idCita=$this->__GET("_idCita");
    $fecha=$this->__GET("_FechaCita");
    $descripcion="Paciente cancelo la cita";

    $sql = "CALL spCancelarCitaRegistrarMora(?,?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$fecha);
    $query->bindParam(2,$descripcion);
    $query->bindParam(3,$idCita);
    $query->execute();
  }

  public function cancelarCita(){
    $idCita=$this->__GET("_idCita");
    $sql = "CALL spCancelarCita(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idCita);
    $query->execute();
  }


  public function AsignarMoraPaciente(){
    $Documento=$this->__GET("_Documento");

    $sql = " CALL spAsignarMora(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$Documento);
    if ($query->execute()) {
      return $query->fetch();
    }else {
      return false;
    }
  }

  function consultarDiasMora(){
    $idPaciente=$this->__GET("_idPaciente");
    
    $sql = "CALL spConsultarDiasMora(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idPaciente);
    if ($query->execute()) {
      return $query->fetch();
    }else {
      return false;
    }
  }

  function modificarDatosPaciente(){
    $datosP=$this->__GET("_DatosPaciente");

    $sql = "CALL spModificarPacienteCita(?,?,?,?,?,?,?,?,?,?,?,?)";
    $query = $this->_CONEXION->prepare($sql);
    for ($i=0; $i < count($datosP); $i++) {
      $query->bindParam($i+1,$datosP[$i]);
      var_dump($datosP[$i]);
    }
    if ($query->execute()) {
      return true;
    }else{
      return false;
    }
  }

  public function listarComboTipoCup(){
    $sql = "CALL spListarTipocup()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetchAll();
    }else {
      return false;
    }
  }

  function InsertarDatosCup(){
    $nombreCUP=$this->__GET("_CUP");
    $idConfiguracion=$this->__GET("_idConfig");
    $idTipoCup=$this->__GET("_idTipoCup");

    $sql="CALL spRegistrarCup3(?,?,?)";
    $query=$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$nombreCUP);
    $query->bindParam(2,$idConfiguracion);
    $query->bindParam(3,$idTipoCup);

    if ($query->execute()) {
      return true;
    }else {
      return false;
    }
  }

  public function CambiarEstadoMora(){
    $idpaciente=$this->__GET("_idPaciente");

    $sql = "CALL spEstadoPaciCIta(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $idpaciente);
    if ($query->execute()) {
      return true;
    }else {
      return false;
    }
  }

  function consultarDescripcionProcedimiento() {
    $filtro=$this->__GET("_filtros");

    $sql = "CALL spConsultarDescripcionCUPcita(?)";
    $query =$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$filtro);
    $query->execute();
    return $query->fetchAll();

  }

  function consultarDescripcionIdProcedimiento() {
    $id=$this->__GET("_idCup");
    $sql = "CALL spConsultarDescripcionIdCUPcita(?)";
    $query =$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$id);
    $query->execute();
    return $query->fetch();

  }

  function consultarCodigoIdProcedimiento() {
    $id=$this->__GET("_idCup");
    $sql = "CALL spConsultarCodigoIdCUPCita(?)";
    $query =$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$id);
    $query->execute();
    return $query->fetch();

  }

  function contarDescripcionProcedimiento() {
    $filtro=$this->__GET("_filtros");
    $sql = "CALL spContarDescripcionCUPcita(?)";
    $query =$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$filtro);
    $query->execute();
    return $query->fetch();
  }

  function consultarCodigoProcedimiento() {
    $filtro=$this->__GET("_filtros");
    $sql = "CALL spConsultarCodigoCUPcita(?)";
    $query =$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$filtro);
    $query->execute();
    return $query->fetchAll();
  }


  function contarCodigoProcedimiento() {
    $filtro=$this->__GET("_filtros");
    $sql = "CALL spContarCodigoCUPcita(?)";
    $query =$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$filtro);
    $query->execute();
    return $query->fetch();
  }

  function ConfigCup()
  {
    $idCup=$this->__GET("_idCup");

    $sql="CALL spConfiguracionAsignada(?)";
    $query=$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idCup);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return false;
    }

  }
  function consultarInforme(){
    $idCita=$this->__GET("_idCita");

    $sql = "CALL SpConsultarInformeCita(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $idCita);
    if ($query->execute()) {
      return $query->fetchAll();
    }else {
      return null;
    }
  }

}

?>
