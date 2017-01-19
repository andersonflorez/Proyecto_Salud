<?php
/**
* Class tipoEvento
*/
class CtrlTipoEvento extends Controller implements iController {
	private $scripts;
	private $styles;
	private $vistasMenu;
	private $notificaciones = true;
	private $menuEmergencia = true;
	private $objTipoEvento = null;
	private $_mdlLayout = null;

	/**
	* Método constructor()
	* Inicializa el uso de variables de sesión y
	* valida si hay una sesión abierta, sino la hay
	* redirecciona hacia el login de la aplicación:
	*/
	public function __construct() {
		Sesion::init();
		if (!Sesion::exist()) {
			header("Location: " . URL);
			exit();
		}

		// Si la var de sesion esModoConsulta no existe redirecciona al index
		if (is_null(Sesion::getValue("esModoConsulta"))) {
			header("Location: " . URL . "ReporteAPH/CtrlIndex");
		}
			$vistas = Sesion::getValue('VISTAS_BARRA_PROGRESO');
      $vistaActual = Sesion::setValue('VISTA_ACTUAL','ctrlTipoEvento');
		if (	$vistas['ctrlTipoEvento'] == true) {
			$this->objTipoEvento = $this->loadModel('ReporteAPH', 'mdlTipoEvento');
			$this->_mdlLayout = $this->loadModel('ReporteAPH', 'mdlLayoutReporteAPH');
		}else {
			header("Location: " . URL . "ReporteAPH/CtrlInformacionGeneral");
		}


	}

	/**
	* METODO: Index
	* Este metodo se ejecuta cuando solicito la URL :
	* http://nombreDeTuProyecto/ReporteAPH/CtrlTipoEvento
	* NOTA: Esta es la página por defecto cuando no se encuentra la URL.
	*/
	public function Index() {
		// RENDERIZA EL MENÚ DE NAVEGACIÓN
		$this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

		// CARGAR CSS
		$this->styles = array(
			"ReporteAPH/Consultar_HC.css",
			"ReporteAPH/antecedentes.css",
			"ReporteAPH/EstiloTipoEvento.css",
			"ReporteAPH/estilo.css",
			"Todos/validacion.css",
			"ReporteAPH/jquery.datetimepicker.css",
			"ReporteAPH/jquery.timepicker.css",
			'ReporteAPH/sweetalert.css'
		);

		// CARGAR JAVASCRIPTS
		$this->scripts = array(
			'Lib/fancywebsocket.js',
			'ReporteAPH/MigasPan.js',
			"ReporteAPH/generalScript.js",
			"Lib/jquery.validate.js",
			"Validaciones/Functions_Validation.js",
			"ReporteAPH/tipoEvento.js",
			"Todos/modal.js",
			"Lib/messages_es.min.js",
			'Lib/angular.min.js',
			'Lib/ngStorage.min.js',
			'ReporteAPH/AngularJs/mdlReporteAPH.js',
			'ReporteAPH/sweetalert-dev.js',
			'ReporteAPH/informacionAmbulancia.js',
			'ReporteAPH/AngularJs/Checklist-model.js',
			'ReporteAPH/AngularJs/Controller/layoutReporteAPH.js',
			"Validaciones/Standard_Validations.js",
			'ReporteAPH/AngularJs/Controller/TipoEvento.js',
			'ReporteAPH/ConsultarNotificacionDespacho.js'
		);

		$this->_mdlLayout->__SET("_idPersona", Sesion::getValue("ID_PERSONA"));
    $idDespacho = $this->_mdlLayout->TraerIDDespacho();
    $numero = $this->RecibirNumeroNotificacion($idDespacho->idDespacho);
    $datos  = $this->RecibirDescripcionNotificacion($idDespacho->idDespacho);
		//$listadoTipoDocumento = $this->objTipoEvento->ListadoTipoDocumento();

		// CARGA LAS VISTAS
		require APP . 'View/_layout/header.php';
		require APP . 'View/ReporteAPH/tipoEvento.php';
		require APP . "View/ReporteAPH/layoutReporteAPH.php";
		require APP . 'View/_layout/footer.php';

	}

	/*
	*METODO BarraProgreso:  se encarga de dar permiso para acceder a
	*la vista.
	*/
	public function BarraProgreso()
	{
		$vistaRedireccionar = $_POST['vistaRedireccionar'];
		$vistas = Sesion::getValue('VISTAS_BARRA_PROGRESO');
		$vistas['ctrlTipoEvento'] = true;
		Sesion::SetValue('VISTAS_BARRA_PROGRESO',$vistas);
		echo json_encode($vistas);
	}

	/**
	* ----------------------------------------------------- *
	*                   CRUD: TipoEvento                    *
	* ----------------------------------------------------- *
	*/
	public function FechaServidorCitas()
	{
	  date_default_timezone_set("America/Bogota");
	  $FechasServidor = date("Y-m-d");
	  echo json_encode($FechasServidor);
	}


	public function RegistrarAcompanante() {
		$lugarExpedicionDocumentoAcomp = $_POST['txtLugarExpedicion'];
		$parentescoAcomp               = $_POST['txtParentescoAcomp'];
		$identificacionAcomp           = $_POST['txtIdentificacionAcomp'];
		$nombreAcomp                   = $_POST['txtNombreAcomp'];
		$telefonoAcomp                 = $_POST['txtTelefonoAcomp'];
		$apellidoAcomp                 = $_POST['txtApellidoAcomp'];
		$acompanante                   = array(
			$lugarExpedicionDocumentoAcomp,
			$parentescoAcomp,
			$identificacionAcomp,
			$nombreAcomp,
			$telefonoAcomp,
			$apellidoAcomp
		);
		  $this->objTipoEvento->__SET("datosAcompanante",$acompanante);
		$registrarAcompanante          = $this->objTipoEvento->insertarAcompanante();
		if ($registrarAcompanante == true) {
			echo json_encode("Si");
		} else {
			echo json_encode("No");
		}

	}


	public function ConsultarIdUltimoPaciente() {
		$consultarId = $this->objTipoEvento->ListadoUltimoPaciente();
		echo $consultarId->ultimo;
	}

	public function ConsultarUltimoAcompanante() {
		$consultarA = $this->objTipoEvento->UltimoAcompanante();
		echo $consultarA->ultimoA;
	}


	public function ListarTipoDocumento() {
		$listadoTipoDocumento = $this->objTipoEvento->ListadoTipoDocumento();
		echo json_encode($listadoTipoDocumento);
	}


	public function RegistrarPaciente() {
		$numeroDocumento         = $_POST['txtIdentificacionPaciente'];
		$fechaNacimiento         = $_POST['txtFechaNacimiento'];
		$tipoSangre              = null;
		$primerNombrePaciente    = $_POST['txtPrimerNombrePaciente'];
		$segundoNombrePaciente   = $_POST['txtSegundoNombrePaciente'];
		$primerApellidoPaciente  = $_POST['txtPrimerApellidoPaciente'];
		$segundoApellidoPaciente = $_POST['txtSegundoApellidoPaciente'];
		$genero                  = $_POST['opGenero'];
		$estadoCivil             = $_POST['txtEstadoCivil'];
		$municipioPaciente       = $_POST['txtMunicipioPaciente'];
		$barrio                  = null;
		$direccion               = $_POST['txtDireccionPaciente'];
		$telefonoFijoPaciente    = null;
		$telefonoMovilPaciente   = $_POST['txtTelefonoMovilPaciente'];
		$correoPaciente          = null;
		$empresa                 = null;
		$ocupacionPaciente       = $_POST['txtOcupacionPaciente'];
		$profesionPaciente       = null;
		$fechaAfilioRegistro     = null;
		$idTipoDocumento         = $_POST['opTipoDocumento12'];
		$idTipoAfiliacion        = null;
		if ($fechaNacimiento == "") {
			$edad = 0;
		}else{
			$fechaNac                = time() - strtotime($fechaNacimiento);
			$edad                    = floor((($fechaNac / 3600) / 24) / 360);
		}

		$url                     = null;
		$idEstadoPaciente        = null;

		//Capturo los campos dentro de un array  para llevarlos al modelo.
		$miArray                 = array(
			$numeroDocumento,
			$fechaNacimiento,
			$tipoSangre,
			$primerNombrePaciente,
			$segundoNombrePaciente,
			$primerApellidoPaciente,
			$segundoApellidoPaciente,
			$genero,
			$estadoCivil,
			$municipioPaciente,
			$barrio,
			$direccion,
			$telefonoFijoPaciente,
			$telefonoMovilPaciente,
			$correoPaciente,
			$empresa,
			$ocupacionPaciente,
			$profesionPaciente,
			$fechaAfilioRegistro,
			$idTipoDocumento,
			$idTipoAfiliacion,
			$edad,
			$url,
			$idEstadoPaciente
		);
		//Asigno al objeto del modelo la funcion insertarReporte y le paso el array.
		$this->objTipoEvento->__SET("datosPaciente",$miArray);
		$regPaciente = $this->objTipoEvento->insertarPaciente();
		if ($regPaciente == true) {
			echo '1';
		} else {
			echo '2';
		}

	}


	public function ConsultarPaciente() {
		$numero = $_POST['txtIdentificacionPaciente'];
		$this->objTipoEvento->__SET("codigo", $numero);
		$consultarRep = $this->objTipoEvento->consultarPaciente();
		if ($consultarRep == null) {
			echo '1';
		} else {
			echo json_encode($consultarRep);
		}
	}


	// Consulta el numero de documento segun el ultimo id para guardarlo en localStorage
	public function ConsultarAcompanante() {
		$identificacion = $_POST['txtIdentificacionAcomp'];
		$this->objTipoEvento->__SET("datoAcomp", $identificacion);
		$consultarAcompananteD = $this->objTipoEvento->consultarAcompanante();
		if ($consultarAcompananteD == null) {
			echo 1;
		} else {
			echo json_encode($consultarAcompananteD);
		}
	}


	public function ActualizarPaciente() {
		$idPaciente              = $_POST['txtIdPaciente'];
		$numeroDocumento         = $_POST['txtIdentificacionPaciente'];
		$fechaNacimiento         = $_POST['txtFechaNacimiento'];
		$tipoSangre              = null;
		$primerNombrePaciente    = $_POST['txtPrimerNombrePaciente'];
		$segundoNombrePaciente   = $_POST['txtSegundoNombrePaciente'];
		$primerApellidoPaciente  = $_POST['txtPrimerApellidoPaciente'];
		$segundoApellidoPaciente = $_POST['txtSegundoApellidoPaciente'];
		$genero                  = $_POST['opGenero'];
		$estadoCivil             = $_POST['txtEstadoCivil'];
		$municipioPaciente       = $_POST['txtMunicipioPaciente'];
		$barrio                  = null;
		$direccion               = $_POST['txtDireccionPaciente'];
		$telefonoFijoPaciente    = null;
		$telefonoMovilPaciente   = $_POST['txtTelefonoMovilPaciente'];
		$correoPaciente          = null;
		$empresa                 = null;
		$ocupacionPaciente       = $_POST['txtOcupacionPaciente'];
		$profesionPaciente       = null;
		$fechaAfilioRegistro     = null;
		$idTipoDocumento         = $_POST['opTipoDocumento12'];
		$idTipoAfiliacion        = null;
		$url                     = null;
		$idEstado                = null;

		$fechaNac                = time() - strtotime($fechaNacimiento);
		$edad                    = floor((($fechaNac / 3600) / 24) / 360);





		$datosPaciente           = array(
			$idPaciente,
			$numeroDocumento,
			$primerNombrePaciente,
			$segundoNombrePaciente,
			$primerApellidoPaciente,
			$segundoApellidoPaciente,
			$estadoCivil,
			$municipioPaciente,
			$barrio,
			$direccion,
			$telefonoFijoPaciente,
			$telefonoMovilPaciente,
			$correoPaciente,
			$empresa,
			$ocupacionPaciente,
			$profesionPaciente,
			$idTipoDocumento,
			$idTipoAfiliacion,
			$url
		);
		$this->objTipoEvento->__SET("datosActPaciente",$datosPaciente);
		$actualizarPaciente  = $this->objTipoEvento->actualizarPaciente();
		if ($actualizarPaciente == true) {
			echo 1;
		} else {
			echo 2;
		}


	}


	function ModificarAcompanante() {
		$idAcom              = $_POST['txtIdA'];
		$parentescoAcomp     = $_POST['txtParentescoAcomp'];
		$identificacionAcomp = $_POST['txtIdentificacionAcomp'];
		$lugarExpedicionAcom = $_POST['txtLugarExpedicion'];
		$nombreAcomp         = $_POST['txtNombreAcomp'];
		$telefonoAcomp       = $_POST['txtTelefonoAcomp'];
		$apellidoAcomp       = $_POST['txtApellidoAcomp'];
		$datosAcompanante    = array(
			$idAcom,
			$lugarExpedicionAcom,
			$parentescoAcomp,
			$identificacionAcomp,
			$nombreAcomp,
			$telefonoAcomp,
			$apellidoAcomp
		);
		$this->objTipoEvento->__SET("datosActAcompanante",$datosAcompanante);
		$actAcomp = $this->objTipoEvento->actualizarAcompanante();

		if ($actAcomp == true) {
			echo 1;
		} else {
			echo 2;
		}
	}


	function ConsultarTriage() {
		$triage = $this->objTipoEvento->ListarTriage();
		if ($triage != null) {
			echo json_encode($triage);
		} else {
			return null;
		}
	}


	function ListarTipoEvento() {
		$listaTipoEvento = $this->objTipoEvento->ListarTipoEvento();
		if ($listaTipoEvento != null) {
			echo json_encode($listaTipoEvento, JSON_UNESCAPED_UNICODE);
		} else {
			echo json_encode(null);
		}
	}


	function EliminarTipoEvento() {
		$objetoReporteInicial = json_decode(file_get_contents("php://input"));
		if (!isset($objetoReporteInicial)) {
			echo "Datos nulos";
		} else {
			$idReporteInicial = $objetoReporteInicial->idReporteInicial;
			$this->objTipoEvento->__SET('idReporteInicial', $idReporteInicial);
			$respuesta = $this->objTipoEvento->EliminarTipoEvento();
			if ($respuesta == true) {
				echo json_encode(true);
			} else {
				echo json_encode(false);
			}
		}

	}


	function RegistrarTipoEventoReporteInicial() {
		$objetoTipoEvento = json_decode(file_get_contents("php://input"));
		if (!isset($objetoTipoEvento)) {
			echo "Datos Nulos";
		} else {
			$idReporteInicial = $objetoTipoEvento->idReporteInicial;
			$idTipoEvento     = $objetoTipoEvento->idTipoEvento;
			$this->objTipoEvento->__SET('idTipoEvento', $idTipoEvento);
			$this->objTipoEvento->__SET('idReporteInicial', $idReporteInicial);
			$registro = $this->objTipoEvento->RegistrarTipoEventoReporteInicial();
			if ($registro == true) {
				echo json_encode(true);
			} else {
				echo json_encode(false);
			}
		}
	}

	public function RecibirNumeroNotificacion($id) {
	    if ($id != 0) {
	        $idDespacho = $id;
	    }else{
	      $idDespacho = $_POST["idDespacho"];
	    }
	    $request  = $_POST["request"];
	    $this->_mdlLayout->__SET("_idDespacho", $idDespacho);
	    $numero = $this->_mdlLayout->ContarNotificacionesDespacho();
	    if ($request == "ajax") {
	      echo json_encode($numero);
	    } else {
	      return $numero;
	    }

	  }

	public function RecibirDescripcionNotificacion($id) {
	    if ($id != 0) {
	        $idDespacho = $id;
	    }else{
	      $idDespacho = $_POST["idDespacho"];
	    }
	    $request  = $_POST["request"];
	    $this->_mdlLayout->__SET("_idDespacho", $idDespacho);
	    $datos = $this->_mdlLayout->DescripcionNotificacionesDespacho();
	    if ($request == "ajax") {
	      echo json_encode($datos);
	    } else {
	      return $datos;
	    }

	  }


} // Fin clase

?>
