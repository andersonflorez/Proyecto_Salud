<?php

/**
* Class nombre_del_controlador:
* Escribe aqui la descripción de lo que hace este controlador
* Copia este formato de controlador para todos los controladores
* que necesites crear ya que todos deben tener esta estructura.
*/
class CtrlCitas extends Controller implements iController {
  private $scripts;
  private $styles;
  private $MdlCitas=null;
  private $vistasMenu;

  /**
  * Método constructor()
  * Inicializa el uso de variables de sesión y
  * valida si hay una sesión abierta, sino la hay
  * redirecciona hacia el login de la aplicación:
  */
  public function __construct() {

    // Primero se debe habilitar el uso de sesiones:
    Sesion::init();

    // Luego preguntar si el usuario esta logueado:
    if (!Sesion::exist()) {

      // Sino, sera enviado hacia el login:
      header("Location: " . URL);
      exit();

    // En caso de que el usuario este logueado, preguntar por su rol,
    // Aqui hay que validar los roles que tienen permiso a esta vista (deben ir en mayusculas):
    // ADMINISTRADOR, RECEPTOR_INICIAL, USUARIO, ENFERMERA_JEFE, AUXILIAR_DE_ENFERMERIA, MEDICO,
    // CONTROL_MEDICO, DESPACHADOR
    } else if (Sesion::getValue('TIPO_USUARIO') === 'ADMINISTRADOR' || Sesion::getValue('TIPO_USUARIO') === 'MEDICO') {

      // Es recomendable cargar los modelos en este apartado:
        $this->MdlCitas=$this->loadModel('Citas','mdlCitas');

    } else {

      // En caso de que no cumpla ninguna de estas condiciones entonces sera redireccionado a la pagina de error:
      header("Location: " . URL . 'Error/Error');
      exit();

    }

  }
  /**
  * Método Index() obligatorio
  * Carga la página principal de este controlador:
  */

  public function Index() {
    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));
    $this->scripts = array(
      "Citas/CitaCancelacion.js",
      "Citas/DtaTable.js",
      "Todos/modal.js",
      "Citas/JsRegistroCita.js",
      "Citas/scriptCitas.js",
      "Todos/sweetalert.js",
      "Todos/Paginador.js",
      "Citas/es.js"
    );

    $this->styles = array(
      "Citas/DtaTable.css",
      "Citas/calendarioCita.css",
      "Citas/calendarioCita.css.map",
      "Citas/Citasestilos.css",
      "Citas/Bolita.css",
      "Todos/sweetalert.css"
    );

    require APP . 'View/_layout/header.php';
    require APP . 'View/Citas/ViewCitas.php';
    require APP . 'View/_layout/footer.php';
  }
  public function ListarTipoDocumento(){
    $lista=$this->MdlCitas->ListarTipoDocumento();
    echo json_encode($lista);
  }
  public function ListarTipoZona(){
    $lista=$this->MdlCitas->ListarTipoZona();
    echo json_encode($lista);
  }
  public function ConsultaZona(){
    $idTipoZona=$_POST['idTipo'];
    $this->MdlCitas->__SET("_idTipoZona",$idTipoZona);
    $lista=$this->MdlCitas->ConsultarZona();
    if ($lista) {
      echo json_encode($lista);
    }else {
      echo json_encode(null);
    }
  }
  public function listarCup(){
    $lista=$this->MdlCitas->listarCup();
    if ($lista) {
      echo json_encode($lista);
    }else {
      echo json_encode(null);
    }
  }
  public function ConfirmacionDatos(){
    date_default_timezone_set("America/Bogota");
    $Documento = $_POST['txtDocumento1'];
    $Nacimiento = $_POST['txtFechaNacimiento1'];
    //$dia = substr($Nacimiento, 0, 2);
    //$mes   = substr($Nacimiento, 3, 2);
    //$ano = substr($Nacimiento, -4);
    //$FechaNac=($dia."-".$mes."-".$ano);
    $fecha=date("Y-m-d",strtotime($Nacimiento));
    $idTipoDocumento  = $_POST['SltTipoDocumento1'];
    $this->MdlCitas->__SET("_Documento",$Documento);
    $this->MdlCitas->__SET("_FechaNacimiento",$fecha);
    $this->MdlCitas->__SET("_idTipoDocumento",$idTipoDocumento);
    $ConsultarInformacion=$this->MdlCitas->ConfirmacionDatos();
  
    if ($ConsultarInformacion) {
      echo json_encode($ConsultarInformacion);
    }else{
      echo json_encode(null);
    }
  }
  public function ConsultHorario(){
    date_default_timezone_set("America/Bogota");
    $mes = Sesion::getValue("mm");
    $ano= Sesion::getValue("aa");
    $dias= $_POST['Dato'];
    $fecha=$ano."-".$mes."-".$dias;
    $this->MdlCitas->__SET("_fechaProgramacion",$fecha);
    $Horario=$this->MdlCitas->ConsultarHorarioDisp();
    $diaSemana= jddayofweek ( cal_to_jd(CAL_GREGORIAN, date("$mes"),date("$dias"), date("$ano")) , 1 );
    switch ($diaSemana) {
      case 'Monday':
      $DaySemana='Lunes';
      break;
      case 'Tuesday':
      $DaySemana='Martes';
      break;
      case 'Wednesday':
      $DaySemana='Miércoles';
      break;
      case 'Thursday':
      $DaySemana='Jueves';
      break;
      case 'Friday':
      $DaySemana='Viernes';
      break;
      case 'Saturday':
      $DaySemana='Sábado';
      break;
      case 'Sunday':
      $DaySemana='Domingo';
      break;
    }
    //for ($i=0; $i <=$Horario.length ; $i++) {
    //}
    $Vble = array();
    foreach ($Horario as $key) {
      $resta=($key->horaFinalTurno-$key->horaInicioTurno);
      $Vble2 = array();
      array_push($Vble2,date("H:i",strtotime($key->horaInicioTurno)));
      for ($i=0; $i < $resta; $i++) {
        $suma = date("H:i",strtotime($Vble2[$i])+60*60);
        array_push($Vble2,$suma);
      }
      array_push($Vble,$Vble2);
    }
    $result=  array(
      'horario'=>$Vble,
      'dias'=>$DaySemana
    );
    if ($Horario) {
      echo json_encode($result);
    }else{
      echo json_encode(null);
    }
  }
  public function RegistrarCita(){
    date_default_timezone_set("America/Bogota");
    $Direccion = base64_decode($_POST['txtDireccionCita']);
    $mes = Sesion::getValue("mm");
    $ano= Sesion::getValue("aa");
    $dias= base64_decode($_POST['diaCita']);
    $fechaCita=$ano."-".$mes."-".$dias;
    $TelUno = base64_decode($_POST['txtTelefonoUno']);
    $TelDos = base64_decode($_POST['txtTelefonoDos']);
    $idPaciente = base64_decode($_POST['nametxtEncrypt']);
    $HoraInicial = base64_decode($_POST['hour']);
    $HoraFinal = date("H:i",strtotime($HoraInicial)+30*60);
    $Barrio = base64_decode($_POST['SltBarrio']);
    $TipoCita = base64_decode($_POST['SltTipoCita']);

    $this->MdlCitas->__SET("_DireccionCita",$Direccion);
    $this->MdlCitas->__SET("_FechaCita",$fechaCita);
    $this->MdlCitas->__SET("_HoraInicialCita",$HoraInicial);
    $this->MdlCitas->__SET("_HoraFinalCita",$HoraFinal);
    $this->MdlCitas->__SET("_TelFijo1Cita",$TelUno);
    $this->MdlCitas->__SET("_TelFijo2Cita",$TelDos);
    $this->MdlCitas->__SET("_idPaciente",$idPaciente);
    $this->MdlCitas->__SET("_cupCita",$TipoCita);
    $this->MdlCitas->__SET("_zonaCita",$Barrio);

    $list=$this->MdlCitas->RegistrarCita();
    if ($list) {
      echo json_encode(true);
    }else{
      echo json_encode(null);
    }
  }

  public function registroDetail(){
    $idCita=$this->MdlCitas->ConsultaIdCita();
    $idCitaInt2=$idCita->idUltimo;
    if (isset($_POST['Medicos'])) {
      foreach ($_POST['Medicos'] as $key1) {
        $this->MdlCitas->__SET("_idCita",$idCitaInt2);
        $this->MdlCitas->__SET("_idTurnoProgramacion",$key1);

        $datos=$this->MdlCitas->registroDetalle();
      }
    }else{
      echo json_encode(['No se registraron médicos']);
    }
    if(isset($_POST['EnfermeroJefe'])){
      foreach ($_POST['EnfermeroJefe'] as $key2) {
        $this->MdlCitas->__SET("_idCita",$idCitaInt2);
        $this->MdlCitas->__SET("_idTurnoProgramacion",$key2);

        $datos=$this->MdlCitas->registroDetalle();
      }
    }else{
      echo json_encode(['No se registraron enfermeros jefe']);
    }
    if (isset($_POST['AuxEnfermeria'])){
      foreach ($_POST['AuxEnfermeria'] as $key3) {
        $this->MdlCitas->__SET("_idCita",$idCitaInt2);
        $this->MdlCitas->__SET("_idTurnoProgramacion",$key3);

        $datos=$this->MdlCitas->registroDetalle();
      }
    }else{
      echo json_encode(['No se registraron auxiliares en enfermeria']);
    }
  }
  public function ConsultarMedicos(){
    $mes = Sesion::getValue("mm");
    $ano = Sesion::getValue("aa");
    $Dia_Cita=base64_decode($_POST['Cita_Dia']);
    $Fecha_Cita= $ano."-".$mes."-".$Dia_Cita;
    $Hora_Cita=base64_decode( $_POST['Cita_Hour'] );

    $this->MdlCitas->__SET("_FechaCita",$Fecha_Cita);
    $this->MdlCitas->__SET("_HoraInicialCita",$Hora_Cita);

    $datos=$this->MdlCitas->ConsultarMedicos();
    if ($datos) {
      echo json_encode($datos);
    }else {
      echo json_encode(null);
    }
  }
  public function ConsultarMedicosEspecial(){
    $Especialidad=$_POST['especial'];
    $mes = Sesion::getValue("mm");
    $ano = Sesion::getValue("aa");
    $Dia_Cita=base64_decode($_POST['day']);
    $Fecha_Cita= $ano."-".$mes."-".$Dia_Cita;
    $Hora_Cita=base64_decode($_POST['hora']);

    $this->MdlCitas->__SET("_descripcionEspecialidad",$Especialidad);
    $this->MdlCitas->__SET("_FechaCita",$Fecha_Cita);
    $this->MdlCitas->__SET("_HoraInicialCita",$Hora_Cita);

    $datos=$this->MdlCitas->ConsultarMedicosEspecial();
    if ($datos) {
      echo json_encode($datos);
    }else {
      echo json_encode(null);
    }
  }

  public function ConsultaNombresMedicos(){
    $Nombres=$_POST['Nombres'];
    $mes = Sesion::getValue("mm");
    $ano = Sesion::getValue("aa");
    $Dia_Cita=base64_decode($_POST['day']);
    $Fecha_Cita= $ano."-".$mes."-".$Dia_Cita;
    $Hora_Cita=base64_decode($_POST['hora']);

    $this->MdlCitas->__SET("_nombresMedico",$Nombres);
    $this->MdlCitas->__SET("_FechaCita",$Fecha_Cita);
    $this->MdlCitas->__SET("_HoraInicialCita",$Hora_Cita);

    $datos=$this->MdlCitas->ConsultaNombresMedicos();
    if ($datos) {
      echo json_encode($datos);
    }else {
      echo json_encode(null);
    }
  }

  public function ConsultaEnfermerosJefe(){
    $mes = Sesion::getValue("mm");
    $ano = Sesion::getValue("aa");
    $Dia_Cita=base64_decode($_POST['Cita_Dia']);
    $Fecha_Cita= $ano."-".$mes."-".$Dia_Cita;
    $Hora_Cita=base64_decode($_POST['Cita_Hour']);

    $this->MdlCitas->__SET("_FechaCita",$Fecha_Cita);
    $this->MdlCitas->__SET("_HoraInicialCita",$Hora_Cita);

    $datos=$this->MdlCitas->ConsultaEnfermerosJefe();
    if ($datos) {
      echo json_encode($datos);
    }else {
      echo json_encode(null);
    }
  }
  public function sugerenciaEnfermerosJefe()
  {
    $idTurnoP=$_POST['MED'];

    $this->MdlCitas->__SET("_idTurnoProgramacion",$idTurnoP[0]);

    $resp=$this->MdlCitas->IDpersona();

    $idPersona=$resp->idPersona;
    $mes = Sesion::getValue("mm");
    $ano = Sesion::getValue("aa");
    $Dia_Cita=base64_decode($_POST['Cita_Dia']);
    $Fecha_Cita= $ano."-".$mes."-".$Dia_Cita;
    $Hora=base64_decode($_POST['Cita_Hour']);

    $this->MdlCitas->__SET("_idPersona",$idPersona);
    $this->MdlCitas->__SET("_FechaCita",$Fecha_Cita);
    $this->MdlCitas->__SET("_HoraInicialCita",$Hora);

    $datos=$this->MdlCitas->sugerenciaEnfermerosJefe();

    if ($datos) {
      echo json_encode($datos);
    }else {
      echo json_encode(null);
    }
  }
  public function ConsultaNombresEnfJefe(){
    $Nombres=$_POST['Nombres'];
    $mes = Sesion::getValue("mm");
    $ano = Sesion::getValue("aa");
    $Dia_Cita=base64_decode($_POST['day']);
    $Fecha_Cita= $ano."-".$mes."-".$Dia_Cita;
    $Hora_Cita=base64_decode($_POST['hora']);

    $this->MdlCitas->__SET("_nombresEnfermeraJefe",$Nombres);
    $this->MdlCitas->__SET("_FechaCita",$Fecha_Cita);
    $this->MdlCitas->__SET("_HoraInicialCita",$Hora_Cita);

    $datos=$this->MdlCitas->ConsultaNombresEnfJefe();
    if ($datos) {
      echo json_encode($datos);
    }else {
      echo json_encode(null);
    }
  }
  public function ConsultarAuxEnfermeria(){
    $mes = Sesion::getValue("mm");
    $ano = Sesion::getValue("aa");
    $Dia_Cita=base64_decode($_POST['Cita_Dia']);
    $Fecha_Cita= $ano."-".$mes."-".$Dia_Cita;
    $Hora_Cita=base64_decode($_POST['Cita_Hour']);

    $this->MdlCitas->__SET("_FechaCita",$Fecha_Cita);
    $this->MdlCitas->__SET("_HoraInicialCita",$Hora_Cita);

    $datos=$this->MdlCitas->ConsultarAuxEnfermeria();
    if ($datos) {
      echo json_encode($datos);
    }else {
      echo json_encode(null);
    }
  }
  public function sugerenciasAuxiliarEnfermeria()
  {
    $idTurnoP=$_POST['MED'];
    $this->MdlCitas->__SET("_idTurnoProgramacion",$idTurnoP[0]);

    $resp=$this->MdlCitas->IDpersona();
    $idPersona=$resp->idPersona;
    $mes = Sesion::getValue("mm");
    $ano = Sesion::getValue("aa");
    $Dia_Cita=base64_decode($_POST['Cita_Dia']);
    $Fecha_Cita= $ano."-".$mes."-".$Dia_Cita;
    $Hora=base64_decode($_POST['Cita_Hour']);

    $this->MdlCitas->__SET("_idPersona",$idPersona);
    $this->MdlCitas->__SET("_FechaCita",$Fecha_Cita);
    $this->MdlCitas->__SET("_HoraInicialCita",$Hora);


    $datos=$this->MdlCitas->sugerenciasAuxiliarEnfermeria();

    if ($datos) {
      echo json_encode($datos);
    }else {
      echo json_encode(null);
    }
  }
  public function ConsultaNombresAuxEnf(){
    $Nombres=$_POST['Nombres'];
    $mes = Sesion::getValue("mm");
    $ano = Sesion::getValue("aa");
    $Dia_Cita=base64_decode($_POST['Cita_Dia']);
    $Fecha_Cita= $ano."-".$mes."-".$Dia_Cita;
    $Hora_Cita=base64_decode($_POST['Cita_Hour']);

    $this->MdlCitas->__SET("_nombresAuxEnfermeriaM",$Nombres);
    $this->MdlCitas->__SET("_FechaCita",$Fecha_Cita);
    $this->MdlCitas->__SET("_HoraInicialCita",$Hora_Cita);

    $datos=$this->MdlCitas->ConsultaNombresAuxEnf();
    if ($datos) {
      echo json_encode($datos);
    }else {
      echo json_encode(null);
    }
  }

  public function ConsultarCitasDelMes(){
    date_default_timezone_set("America/Bogota");
    $month = date('m');
    $year = date('Y');
    /** Actual month last day **/
    $day = date("d", mktime(0,0,0, $month+1, 0, $year));
    $ultimoDia= date('Y-m-d', mktime(0,0,0, $month, $day, $year));
    /** Actual month first day **/
    $primerDia= date('Y-m-d', mktime(0,0,0, $month, 1, $year));
    $idPaciente =base64_decode($_POST['idPac']);

    $this->MdlCitas->__SET("_idPaciente",$idPaciente);
    $this->MdlCitas->__SET("_primerDiaM",$primerDia);
    $this->MdlCitas->__SET("_ultimoDiaM",$ultimoDia);

    $cantCitasMes=$this->MdlCitas->ConsultarCitasMes();
    if ($cantCitasMes) {
      echo json_encode($cantCitasMes);
    }else{
      echo json_encode(null);
    }
  }
  public function ConsultarCitasDelDia(){
    date_default_timezone_set("America/Bogota");
    $idPaciente =base64_decode($_POST['idPac']);
    $fechaActual=date("Y-m-d");
    $this->MdlCitas->__SET("_idPaciente",$idPaciente);
    $this->MdlCitas->__SET("_fechaActual",$fechaActual);

    $cantCitasDia=$this->MdlCitas->ConsultarCitasDia();
    if ($cantCitasDia) {
      echo json_encode($cantCitasDia);
    }else{
      echo json_encode(null);
    }
  }
  public function dateActual()
  {
    date_default_timezone_set("America/Bogota");
    $dayA=date("j");
    $hours=date("G");
    $info = array(
      'day' => $dayA,
      'horaA'=>$hours
    );
    echo json_encode($info);
  }
  public function ConsultaMesYear(){
    date_default_timezone_set("America/Bogota");
    //Fecha seleccionada en el calendario
    $dayC=$_POST["Dato"];
    $monthC = Sesion::getValue("mm");
    $yearC = Sesion::getValue("aa");
    //fecha actual del servidor
    $dayA=date("j");
    $MesA=date("m");
    $yearA=date("Y");
    //Respuesta a retornar
    $Respuesta;
    if($yearC<$yearA){
      $Respuesta = false;
    }else if($yearC==$yearA && $monthC<$MesA){
      $Respuesta = false;
    }else if($yearC==$yearA && $monthC==$MesA && $dayC<$dayA){
      $Respuesta = false;
    }else if($yearC==$yearA && $monthC==$MesA && $dayC>=$dayA){
      $Respuesta = true;
    }else if ($yearC==$yearA && $monthC>$MesA) {
      $Respuesta=true;
    }
    $datos = array(
      'year' => $yearC,
      'respuesta'=>$Respuesta
    );
    echo json_encode($datos);
  }
  public function ConsultarCitasAsignadas(){
    $idPaciente =base64_decode($_POST['idPac']);
    $this->MdlCitas->__SET("_idPaciente",$idPaciente);
    $CitasAsignadas=$this->MdlCitas->ConsultarCitasAsignadas();
    if (intval($CitasAsignadas->Citas_Asignadas) > 0 || $CitasAsignadas->idEstadoPaciente=="3") {
      $respuestaMulta = $this->MdlCitas->consultarDiasMora();
      date_default_timezone_set("America/Bogota");
      if($respuestaMulta != false){
        $FechaMora= getDate();
        $mes=0;
        switch ($FechaMora['mon']) {
          case '1':
          $mes = "01";
          break;
          case '2':
          $mes = "02";
          break;
          case '3':
          $mes = "03";
          break;
          case '4':
          $mes = "04";
          break;
          case '5':
          $mes = "05";
          break;
          case '6':
          $mes = "06";
          break;
          case '7':
          $mes = "07";
          break;
          case '8':
          $mes = "08";
          break;
          case '9':
          $mes = "09";
          break;
          case '10':
          $mes = "10";
          break;
          case '11':
          $mes = "11";
          break;
          case '12':
          $mes = "12";
          break;
          default:
          break;
        }
        $Fecha1=strtotime("+".$respuestaMulta->diasMulta." day",strtotime($respuestaMulta->fechaHistorial));
        $Fecha2=strtotime($FechaMora['year']."-".$mes."-".$FechaMora['mday']);

        $resta = $Fecha1 - $Fecha2;
        $time = date("d",$resta);
      echo json_encode(array(json_encode($CitasAsignadas),$time));
    }
    else{
      echo json_encode(array(json_encode($CitasAsignadas),null));
    }
    }else{
      echo json_encode(array(json_encode(array("Citas_Asignadas"=>null))));

    }

}

  public function ConfigCup()
  {
    $Cup =$_POST['idCup'];
    $this->MdlCitas->__SET("_idCup",$Cup);
    $Config=$this->MdlCitas->ConfigCup();
    if ($Config) {
      echo json_encode($Config);
    }else{
      echo json_encode(null);
    }
  }
  public function validarF($dia,$mes){
    $fes = false;
    $fecha = $dia."-".$mes;
    switch ($fecha) {
      case '1-1':
      case '1-5':
      case '8-12':
      case '25-12':
      $fes = true;
      break;
    }
    return $fes;
  }

  public function cl(){
    date_default_timezone_set("America/Bogota");
    if(Sesion::getValue("bandera") == NULL){
      Sesion::setValue("mm",date('m'));
      Sesion::setValue("aa", date('Y'));
      Sesion::setValue("bandera",1);
    }

    if($_POST["boton"] == 2){

      Sesion::setValue("mm",Sesion::getValue("mm")+1);

      if(Sesion::getValue("mm") == 13){
        Sesion::setValue("aa", Sesion::getValue("aa")+1);
        Sesion::setValue("mm",1);
      }else{
        Sesion::setValue("aa", Sesion::getValue("aa"));
      }

    }else if($_POST["boton"] == 1){

      Sesion::setValue("mm", Sesion::getValue("mm")-1);

      if(Sesion::getValue("mm") == 0){
        Sesion::setValue("aa", Sesion::getValue("aa")-1);
        Sesion::setValue("mm",12);
      }else{
        Sesion::setValue("aa", Sesion::getValue("aa"));
      }

    }else{
      Sesion::setValue("mm", date('m'));
      Sesion::setValue("aa", date('Y'));
    }

    $bisiesto = Sesion::getValue("aa");

    if(($bisiesto%4 ==0) && ($bisiesto%100 != 0 || $bisiesto%400 == 0)){
      $df=29;
    }else
    {
      $df=28;
    }
    switch (Sesion::getValue("mm")) {
      case '1': $can_dias = 31;
      $nombre = 'Enero';
      break ;
      case '2': $can_dias = $df;
      $nombre = 'Febrero';
      break;
      case '3': $can_dias = 31;
      $nombre = 'Marzo';
      break;
      case '4': $can_dias = 30;
      $nombre = 'Abril';
      break;
      case '5': $can_dias = 31;
      $nombre = 'Mayo';
      break;
      case '6': $can_dias = 30;
      $nombre = 'Junio';
      break;
      case '7': $can_dias = 31;
      $nombre = 'Julio';
      break;
      case '8': $can_dias = 31;
      $nombre = 'Agosto';
      break;
      case '9': $can_dias = 30;
      $nombre = 'Septiembre';
      break;
      case '10': $can_dias = 31;
      $nombre = 'Octubre';
      break;
      case '11': $can_dias = 30;
      $nombre = 'Noviembre';
      break;
      case '12': $can_dias = 31;
      $nombre = 'Diciembre';
      break;
    }
    $timeta = mktime(0,0,0,Sesion::getValue("mm"),1,Sesion::getValue("aa"));
    // echo Sesion::getValue("mm");
    $saltar = date("w", $timeta);
    $can_dias += $saltar;
    $filas = ceil($can_dias/7);
    $can_celdas = $filas * 7;
    $diferencia = $can_celdas - $can_dias;
    /*if(isset($_POST['derecha'])){
    $p=$p+1;
  }*/
  $i = 1;
  $id = 0;
  $calendar = "";
  $mesMostrar=intval(Sesion::getValue("mm"));
  for ($i; $i <= $can_dias ; $i++) {
    if ($i <=$saltar) {
      $calendar .= '<div class="calendario-dias"></div>';
    }else{
      $nueva = $i - $saltar;
      $res = $this->validarF($nueva,Sesion::getValue("mm"));
      if ($res == true) {
        $css = 'class="calendario-dias contenedor" ';
      }else {
        $css ='class="contenedor calendario-dias Dato'.$mesMostrar.$nueva.'"onclick="Calendario(this.id)"';
      }
      $calendar .= "<div $css datoCalendario='$nueva' id='CAL$nueva'><span class='diasT'>$nueva</span><div class='SelT$nueva controlT'></div></div>";
    }
  }
  for ($i=1; $i <= $diferencia ; $i++) {
    $calendar .= '<div class="calendario-dias" >'.$i.'</div>';
  }
  $Vble2 = array();
  array_push($Vble2,$calendar);
  array_push($Vble2,$nombre);
  array_push($Vble2,Sesion::getValue("aa"));
  echo json_encode($Vble2);
}
public function ConsultarProgramacionDias()
{
  $mes=date("m");
  $dia=date("j");
  $mesCalen=intval(Sesion::getValue("mm"));
  $programacion=$this->MdlCitas->ConsultarProgramacionDias();
  $informacion= array('DiasDisponibles' => $programacion,
    'diaActual' => $dia,
    'mesActual'=>$mes,
    'mesCalen'=>$mesCalen
  );
  echo json_encode($informacion);
}

public function ConsultarCitasP(){
  $idPaciente = base64_decode($_POST['txtidPaciente']);
  $this->MdlCitas->__SET("_idCita",$idPaciente);

  $respuestaA = $this->MdlCitas->ConsultarCitasPersonal();
  echo json_encode($respuestaA);
}

public function CambiarEstadoC(){
  $idCita = $_POST['txtidCita'];
  $estadoTablaCita = $_POST['EstadoCita'];
  $HoraInicial = $_POST['HoraInicial'];
  $FechaCita = $_POST['FechaCita'];
  date_default_timezone_set("America/Bogota");
  $HoraCancelacion = getDate();
  $hora1 = strtotime($FechaCita." ".$HoraInicial);
  $hora2 = strtotime("+2 hour",strtotime($HoraCancelacion['year']."-".$HoraCancelacion['mon']."-".$HoraCancelacion['mday']." ".$HoraCancelacion['hours'].":".$HoraCancelacion['minutes'].":".$HoraCancelacion['seconds']));
  $resta= $hora1 - $hora2;
  $fechaC=getDate()["year"]."/".getDate()["mon"]."/".getDate()["mday"];
  $this->MdlCitas->__SET("_FechaCita",$fechaC);
  $this->MdlCitas->__SET("_idCita",$idCita);
  $this->MdlCitas->__SET("_idPaciente",base64_decode($_POST["idPaciente"]));

  if($resta > 0){
    $this->MdlCitas->cancelarCita($idCita);
    echo "1";
  }else{
    $this->MdlCitas->CambiarEstadoMora();
    $this->MdlCitas->cancelarCita();
    $this->MdlCitas->cancelarCitaRegistrarMora();
    echo "0";
  }
}


public function AsignarMoraPaciente(){
  $this->MdlCitas->__SET("_Documento",$_POST['documento']);

  $respuestaMulta = $this->MdlCitas->AsignarMoraPaciente();
  date_default_timezone_set("America/Bogota");
  if($respuestaMulta != false){
    $FechaMora= getDate();

    $mes=0;
    switch ($FechaMora['mon']) {
      case '1':
      $mes = "01";
      break;
      case '2':
      $mes = "02";
      break;
      case '3':
      $mes = "03";
      break;
      case '4':
      $mes = "04";
      break;
      case '5':
      $mes = "05";
      break;
      case '6':
      $mes = "06";
      break;
      case '7':
      $mes = "07";
      break;
      case '8':
      $mes = "08";
      break;
      case '9':
      $mes = "09";
      break;
      case '10':
      $mes = "10";
      break;
      case '11':
      $mes = "11";
      break;
      case '12':
      $mes = "12";
      break;
      default:
      break;
    }
    $Fecha1=strtotime("+".$respuestaMulta->diasMulta." day",strtotime($respuestaMulta->fechaHistorial));
    $Fecha2=strtotime($FechaMora['year']."-".$mes."-".$FechaMora['mday']);

    $resta = $Fecha1 - $Fecha2;
    if ($resta < 0) {
      echo "1";
    }else{
      echo "0";
    }
  }
  else{

    echo "1";

  }
}

public function ModificarDatosPaciente(){
  $idpaciente = base64_decode($_POST['txtidpaciente']);
  $primerNombre  = $_POST['txtPrimerNombre'];
  $segundoNombre = $_POST['txtSegundoNombre'];
  $primerApellido = $_POST['txtPrimerApellido'];
  $segundoApellido = $_POST['txtSegundoApellido'];
  $ciudadResidencia = $_POST['txtCiudadResidencia'];
  $barrioResidencia = $_POST['txtBarrioResidencia'];
  $direccion = $_POST['txtDireccion'];
  $telefonoFijo = $_POST['txtTelefono'];
  $extencion = $_POST['txtExtTelefonoCita3'];
  $telefonoMovil = $_POST['txtTelefonoCelular'];
  $correoElectronico = $_POST['txtCorreo'];
  $idtipoDocumento = $_POST['tipodocumento'];
  if ($telefonoFijo!="") {
    $telefonoFijo=$telefonoFijo."-".$extencion;
  }

  $datosPaciente = array($idpaciente ,$primerNombre, $segundoNombre, $primerApellido, $segundoApellido,
  $ciudadResidencia, $barrioResidencia, $direccion, $telefonoFijo,$telefonoMovil, $correoElectronico, $idtipoDocumento);

  $this->MdlCitas->__SET("_DatosPaciente",$datosPaciente);

  $actualizarPaciente = $this->MdlCitas->modificarDatosPaciente();
  if ($actualizarPaciente==true) {

    echo json_encode(['Exito']);
  }else{
    echo json_encode(['Mal']);
  }
}

public function CambiarEstadoMora(){
  $idPaciente = base64_decode($_POST['id']);
  $this->MdlCitas->__SET("_idPaciente",$idPaciente);

  echo $this->objPaciente->CambiarEstadoMora();
}


function consultarDescripcionCup(){
  $this->MdlCitas->__SET("_filtros",$_POST["q"]);
  $query = $this->MdlCitas->consultarDescripcionProcedimiento();
  $cantidad = $this->MdlCitas->contarDescripcionProcedimiento();
  $datos = array(
    "items"=>$query,
    "total"=>$cantidad
  );
  echo json_encode($datos);
}

function consultarDescripcionIdCup(){
  $this->MdlCitas->__SET("_idCup",$_POST["id"]);
  $query = $this->MdlCitas->consultarDescripcionIdProcedimiento();
  echo $query->nombreCup;
}

function consultarCodigoCup(){
  $this->MdlCitas->__SET("_filtros",$_POST["q"]);
  $query = $this->MdlCitas->consultarCodigoProcedimiento();
  $cantidad = $this->MdlCitas->contarCodigoProcedimiento();
  $datos = array(
    "items"=>$query,
    "total"=>$cantidad->cont
  );
  echo json_encode($datos);
}

function consultarCodigoIdCup(){
  $this->MdlCitas->__SET("_idCup",$_POST["id"]);
  $query = $this->MdlCitas->consultarCodigoIdProcedimiento();
  echo $query->codigoCup;
}


function enviarReporte(){
  $idCita =($_POST["idCita"]);
  // $idPaciente=base64_decode($_POST["idP"]);
  $this->MdlCitas->__SET("_idCita",$idCita);
  // $this->MdlCitas->__SET("_idPaciente",$idPaciente);
  $correoElectronico=$_POST['correoElectronico'];
  $consultarInforme = $this->MdlCitas->consultarInforme();
  $medicos="";
  for($i=0;$i<count($consultarInforme);$i++){
    $Especialidad= $consultarInforme[$i]->descripcionRol;
    $medicos .= "<div style='width:100%;font-family:Arial, Helvetica, sans-serif;font-size:14px;
    color:#777;
    text-align:lef;
    line-height: 142%;'>".$consultarInforme[$i]->descripcionRol.": <span style='color:#1f95d0;font-weight:bold;width:125px;font-family:Arial,Helvetica,sans-serif;font-size:14px;text-align:left;line-height:142%'>".$consultarInforme[$i]->NombrePersona."</span></div><br/>";
  }
  $transport = Swift_SmtpTransport::newInstance()
  ->setHost('smtp.gmail.com')
  ->setPort('465')
  ->setEncryption("ssl")
  ->setUsername('central.automatizada.despacho@gmail.com')
  ->setPassword('administracioncad');

  $mailer = Swift_Mailer::newInstance($transport);
  $message = Swift_Message::newInstance()
  //asunto
  ->setSubject('Notificacion de Cita Cancelada')
  //remitente
  ->setFrom(array('central.automatizada.despacho@gmail.com' => 'Administración CAD'))
  //Destinatarios
  ->setTo(array($correoElectronico => "Usuario"))

  ->setBody("<div style='height:auto;box-shadow:0px 0px 2px 0px rgba(0,0,0,0.4);padding:10px;'>
  <div >

  <span style='width: 100%;display: flex;border-bottom:solid 1px rgba(0,0,0,0.5);padding:10px;font-family:Arial, Helvetica, sans-serif;font-size:27px;
  color:#666;
  text-align:center;
  line-height: 142%;'>
  <b>  La Cita fue cancelada correctamente </b>
  </span>
  <span style='width:100%;display:flex;;font-family:Arial, Helvetica, sans-serif;font-size:20px;
  color:#666;
  text-align:center;
  line-height: 255%;'>
  <b>Información de la cita: </b>
  </span>
  <div  style='display:flex;flex-direction:column;'>
  <div style='flex-direction:row;display:flex;width:100%;'>
  <p style='font-weight:bold;width:125px;font-family:Arial, Helvetica, sans-serif;font-size:14px;
  color:#777;
  text-align:left;
  line-height: 142%;'>Fecha de la cita:
  </p>
  <p style='width:150px;font-family:Arial, Helvetica, sans-serif;font-size:15px;
  color:#1F95D0;
  text-align:left;
  font-weight:bold;
  line-height: 120%;'>
  ".$_POST["FechaCita"]."
  </p>
  </div>


  </div>

  <div style='display:flex;width:100%;padding-bottom: 20px;'>


  <b style='width:400px;font-family:Arial, Helvetica, sans-serif;font-size:14px;
  color:#777;
  text-align:left;
  line-height: 142%;'>Hora de la cita:
  <b style='font-family:Arial, Helvetica, sans-serif;font-size:15px;
  color:#1F95D0;
  text-align:center;
  font-weight:bold;
  line-height: 120%;'>
  ".$_POST["HoraInicial"]."
  </b>
  </b>
  </div>

  <div style='display:flex;width:100%;padding-bottom: 20px;'>


  <b style='width:400px;font-family:Arial, Helvetica, sans-serif;font-size:14px;
  color:#777;
  text-align:left;
  line-height: 142%;'>Nombre del paciente:
  <b style='font-family:Arial, Helvetica, sans-serif;font-size:15px;
  color:#1F95D0;
  text-align:center;
  font-weight:bold;
  line-height: 120%;'>
  "
  .$_POST["NombreCompleto"]  ."
  </b>
  </b>
  </div>

  <div style='display:flex;width:100%;border-bottom:solid 1px rgba(0,0,0,0.5);padding-bottom: 20px;'>

  </div>

  <div style='width:100%;padding-top: 30px;'>
  <b style='width:100%;font-family:Arial, Helvetica, sans-serif;font-size:20px;
  color:#666;
  text-align:lef;
  line-height: 142%;'>Nombres del personal asistencial:
  </p>
  <p>".$medicos."
  </p>
  <b style='width:100%;font-family:Arial, Helvetica, sans-serif;font-size:20px;
  color:#666;
  text-align:lef;
  line-height: 142%;'>Nombre del servicio:
  </p>
  <p style='width:100%;font-family:Arial, Helvetica, sans-serif;font-size:19px;
  color:#1F95D0;
  text-align:center;
  font-weight:bold;
  line-height: 120%;'>
  ".$_POST["nombreCUP"]."
  </p>
  </div>

  <div style='width:100%;display:flex'>
  <p style='width:100%;font-family:Arial, Helvetica, sans-serif;font-size:11px;
  color:#666;
  text-align:lef;
  line-height: 142%;'>'Nota: Este mensaje ha sido generado automaticamente. Por favor no lo responda. ':
  </p>
  <div>
  <img style='width: 130px;' src='https://imageshack.com/i/plpeIP96p'>
  </div>
  </div>
  </div>
  </div>", 'text/html');

  $headers = 'From: central.automatizada.despacho@gmail.com' . " " . "\r\n" .'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  // Send the message

  $mailer->send($message,$headers);
  echo "1";
}

function ReporteRegistroCita(){
  date_default_timezone_set("America/Bogota");
  $nombreCompleto = $_POST['nombreCompleto'];
  $barrioCita = base64_decode($_POST['barrioCita']);
  $telefono =base64_decode( $_POST['telefono']);
  $nombresenfermerosJefe = $_POST['nombresenfermerosJefe'];
  $hora = base64_decode($_POST['hora']);
  $directCita = base64_decode($_POST['directCita']);
  $nombresmedicos = $_POST['nombresmedicos'];
  $nombresauxEnfermeria = $_POST['nombresauxEnfermeria'];
  $correoElectronico = base64_decode($_POST['correoE']);

  $diaCita=base64_decode($_POST['diaCita']);
  $mes = Sesion::getValue("mm");
  $ano= Sesion::getValue("aa");
  $fechaCita=$ano."-".$mes."-".$diaCita;

  $MesText=date("F", strtotime($fechaCita));
  $diaSemana=date("l", strtotime($fechaCita));
  switch ($diaSemana) {
    case 'Monday':
    $DaySemana='Lunes';
    break;
    case 'Tuesday':
    $DaySemana='Martes';
    break;
    case 'Wednesday':
    $DaySemana='Miércoles';
    break;
    case 'Thursday':
    $DaySemana='Jueves';
    break;
    case 'Friday':
    $DaySemana='Viernes';
    break;
    case 'Saturday':
    $DaySemana='Sábado';
    break;
    case 'Sunday':
    $DaySemana='Domingo';
    break;
  }

  switch ($MesText) {
    case 'January':
    $mesTexto='Enero';
    break;
    case 'February':
    $mesTexto='Febrero';
    break;
    case 'March':
    $mesTexto='Marzo';
    break;
    case 'April':
    $mesTexto='Abril';
    break;
    case 'May':
    $mesTexto='Mayo';
    break;
    case 'June':
    $mesTexto='Junio';
    break;
    case 'July':
    $mesTexto='Julio';
    break;
    case 'August':
    $mesTexto='Agosto';
    break;
    case 'September':
    $mesTexto='Septiembre';
    break;
    case 'October':
    $mesTexto='Octubre';
    break;
    case 'November':
    $mesTexto='Noviembre';
    break;
    case 'December':
    $mesTexto='Diciembre';
    break;
  }
  $fechaCompleta=$DaySemana." ".$diaCita." de ".$mesTexto." del ".$ano;

  $descripcionServicio=$_POST['descripcionServicio'];
  $medicos="";
  $enfermeros="";
  $auxiliares="";

  for($i=0;$i<count($nombresmedicos);$i++){
    $medicos= $nombresmedicos[$i];
  }
  if ($nombresenfermerosJefe=="" || $nombresenfermerosJefe=="Ninguno") {
  $enfermeros="Ninguno";
}else {
  for($i=0;$i<count($nombresenfermerosJefe);$i++){
    $enfermeros= $nombresenfermerosJefe[$i];
  }
}
if ($nombresauxEnfermeria=="" || $nombresauxEnfermeria=="Ninguno") {
  $auxiliares="Ninguno";
}else {
  for($i=0;$i<count($nombresauxEnfermeria);$i++){
      $auxiliares= $nombresauxEnfermeria[$i];
  }
  }
  $transport = Swift_SmtpTransport::newInstance()
  ->setHost('smtp.gmail.com')
  ->setPort('465')
  ->setEncryption("ssl")
  ->setUsername('central.automatizada.despacho@gmail.com')
  ->setPassword('administracioncad');

  $mailer = Swift_Mailer::newInstance($transport);
  $message = Swift_Message::newInstance()
  //asunto
  ->setSubject('Notificacion de Cita Registrada')
  //remitente
  ->setFrom(array('central.automatizada.despacho@gmail.com' => 'Administración CAD'))
  //Destinatarios
  ->setTo(array($correoElectronico => "Usuario"))

  ->setBody("<div style='height:auto;box-shadow:0px 0px 2px 0px rgba(0,0,0,0.4);padding:10px;'>
  <div >

  <span style='width: 100%;display: flex;border-bottom:solid 1px rgba(0,0,0,0.5);padding:10px;font-family:Arial, Helvetica, sans-serif;font-size:27px;
  color:#666;
  text-align:center;
  line-height: 142%;'>
  <b>  La Cita ha cido programada correctamente </b>
  </span>
  <span style='width:100%;display:flex;;font-family:Arial, Helvetica, sans-serif;font-size:20px;
  color:#666;
  text-align:center;
  line-height: 255%;'>
  <b>Información de la cita: </b>
  </span>
  <div  style='display:flex;flex-direction:column;'>
  <div style='flex-direction:row;display:flex;width:100%;'>
  <p style='font-weight:bold;width:125px;font-family:Arial, Helvetica, sans-serif;font-size:14px;
  color:#777;
  text-align:left;
  line-height: 142%;'>Fecha de la cita:
  </p>
  <p style='width:150px;font-family:Arial, Helvetica, sans-serif;font-size:15px;
  color:#1F95D0;
  text-align:left;
  font-weight:bold;
  line-height: 120%;'>
  ".$fechaCompleta."
  </p>
  </div>


  </div>

  <div style='display:flex;width:100%;padding-bottom: 20px;'>


  <b style='width:400px;font-family:Arial, Helvetica, sans-serif;font-size:14px;
  color:#777;
  text-align:left;
  line-height: 142%;'>Hora de la cita:
  <b style='font-family:Arial, Helvetica, sans-serif;font-size:15px;
  color:#1F95D0;
  text-align:center;
  font-weight:bold;
  line-height: 120%;'>
  ".$hora."
  </b>
  </b>
  </div>

  <div style='display:flex;width:100%;padding-bottom: 20px;'>


  <b style='width:400px;font-family:Arial, Helvetica, sans-serif;font-size:14px;
  color:#777;
  text-align:left;
  line-height: 142%;'>Nombre del paciente:
  <b style='font-family:Arial, Helvetica, sans-serif;font-size:15px;
  color:#1F95D0;
  text-align:center;
  font-weight:bold;
  line-height: 120%;'>
  "
  .$nombreCompleto."
  </b>
  </b>
  </div>

  <div style='display:flex;width:100%;padding-bottom: 20px;'>


  <b style='width:400px;font-family:Arial, Helvetica, sans-serif;font-size:14px;
  color:#777;
  text-align:left;
  line-height: 142%;'>Barrio:
  <b style='font-family:Arial, Helvetica, sans-serif;font-size:15px;
  color:#1F95D0;
  text-align:center;
  font-weight:bold;
  line-height: 120%;'>
  "
  .$barrioCita."
  </b>
  </b>
  </div>

  <div style='display:flex;width:100%;padding-bottom: 20px;'>


  <b style='width:400px;font-family:Arial, Helvetica, sans-serif;font-size:14px;
  color:#777;
  text-align:left;
  line-height: 142%;'>Dirección:
  <b style='font-family:Arial, Helvetica, sans-serif;font-size:15px;
  color:#1F95D0;
  text-align:center;
  font-weight:bold;
  line-height: 120%;'>
  "
  .$directCita."
  </b>
  </b>
  </div>

  <div style='display:flex;width:100%;border-bottom:solid 1px rgba(0,0,0,0.5);padding-bottom: 20px;'>


  <b style='width:400px;font-family:Arial, Helvetica, sans-serif;font-size:14px;
  color:#777;
  text-align:left;
  line-height: 142%;'>telefono:
  <b style='font-family:Arial, Helvetica, sans-serif;font-size:15px;
  color:#1F95D0;
  text-align:center;
  font-weight:bold;
  line-height: 120%;'>
  "
  .$telefono."
  </div>

  <div style='width:100%;padding-top: 30px;'>
  <b style='width:100%;font-family:Arial, Helvetica, sans-serif;font-size:20px;
  color:#666;
  text-align:lef;
  line-height: 142%;'>Nombres del personal asistencial:
  </p>
  <p style='color:#1F95D0; font-size:14px;'>
  <b style='width:400px;font-family:Arial, Helvetica, sans-serif;font-size:14px;
  color:#777;
  text-align:left;
  line-height: 142%;'>Médicos:</b>
  ".$medicos."
  </p>
  <p style='color:#1F95D0; font-size:14px; '>
  <b style='width:400px;font-family:Arial, Helvetica, sans-serif;font-size:14px;
  color:#777;
  text-align:left;
  line-height: 142%;'>Enfermeros jefe:</b>
  ".$enfermeros."
  </p>
  <p style='color:#1F95D0; font-size:14px;'>
  <b style='width:400px;font-family:Arial, Helvetica, sans-serif;font-size:14px;
  color:#777;
  text-align:left;
  line-height: 142%;'>Auxiliares en enfermería:</b>
  ".$auxiliares."
  </p>

  <p style='width:100%;font-family:Arial, Helvetica, sans-serif;font-size:20px;
  color:#666;
  text-align:lef;
  line-height: 142%;'>Nombre del servicio:
  </p>
  <p style='width:100%;font-family:Arial, Helvetica, sans-serif;font-size:19px;
  color:#1F95D0;
  text-align:center;
  font-weight:bold;
  line-height: 120%;'>
  ".$descripcionServicio."
  </p>
  </div>

  <div style='width:100%;display:flex'>
  <p style='width:100%;font-family:Arial, Helvetica, sans-serif;font-size:11px;
  color:#666;
  text-align:lef;
  line-height: 142%;'>'Nota: Este mensaje ha sido generado automaticamente. Por favor no lo responda. ':
  </p>
  <div>
  <img style='width: 130px;' src='https://imageshack.com/i/plpeIP96p'>
  </div>
  </div>
  </div>
  </div>", 'text/html');
  $headers = 'From: central.automatizada.despacho@gmail.com' . " " . "\r\n" .'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  // Send the message

  $mailer->send($message,$headers);
  echo "1";
}
public function FechaServidorCitas()
{
  date_default_timezone_set("America/Bogota");
  $FechasServidor = date("Y-m-d");
  echo json_encode($FechasServidor);
}


}




?>
