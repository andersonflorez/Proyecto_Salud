<?php

class ctrlModificarAsignacion extends Controller implements iController {

  private $styles;
  private $scripts;
  private $mdlModificarAsignacion = null;
  private $vistasMenu;
  public function __construct() {
    // Descomentar lo siguiente cuando el login de usuarios se encuentre listo (y eliminar este comentario):


    Sesion::init();

    if (!Sesion::exist()) {

      header("Location: " . URL);
      exit();

    } else if (Sesion::getValue('TIPO_USUARIO') === 'ADMINISTRADOR') {

      $this->mdlModificarAsignacion = $this->loadModel('Despachador','mdlModificarAsignacion');
      $this->objPagination = $this->loadModel('Otros', 'mdlPagination');

    } else {

      header('Location: ' . URL . 'Error/Error');
      exit();

    }
  }

  /**
  * Método Index() obligatorio
  * Renedriza la página principal de este controlador (ej: 'View/Home/index.php')
  */
  public function Index() {
    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));
    $this->styles = array(
      "Despachador/style.css",
      "Despachador/radio.css",
      "Despachador/leaflet.css",
      "Todos/validacion.css"
    );

    // Cargar JAVASCRIPTS de 'ReporteAPH/index.php':
    $this->scripts = array(
      "Despachador/leaflet.js",
      "Todos/Paginador.js",
      "Despachador/ModificarAsignacion.js"
      //"Despachador/GeolocalizacionAsignacion.js",


    );


    require APP . 'View/_layout/header.php'; // Carga la barra de navegación y los CSS
    require APP . 'View/Despachador/viewModificarAsignacion.php'; // Carga nuestra vista
    require APP . 'View/_layout/footer.php'; // Carga los Javascripts


  }

  public function ListarAsignaciones() {
    //error_reporting(0);
    $configPaginador = $_POST;
    $res = $this->objPagination->Paginate($configPaginador);
    echo json_encode($res);
  }

  public function ConsultarAsignaciones(){
    //var_dump($_POST);
    $idAmbulancia = $_POST['TxtIdAmbulancia'];
    $this->mdlModificarAsignacion->__SET("_idAmbulancia",$idAmbulancia);
    $respuesta = $this->mdlModificarAsignacion->ConsultarPersonal();
    if ($respuesta) {
      echo json_encode($respuesta);
    }else{
    echo json_encode(1);
  }
  }

  public function ListarCombosP(){
    $respuestaCombo = $this->mdlModificarAsignacion->ListarCombosPersona ();
    echo json_encode($respuestaCombo);
  }

  public function modificarAsignaciones(){
   var_dump($_POST);
    $idAsignacion = $_POST['TxtIdAsignacion'];
    $ambulancia = $_POST['TxtAmbulancia'];
    $longitud = $_POST['TxtLongitud'];
    $latitud = $_POST['TxtLatitud'];
    $personaU = $_POST['personaU'];
    $personaD = $_POST['personaD'];
    $personaT = $_POST['personaT'];
    $detalleU = $_POST['detalleU'];
    $detalleD = $_POST['detalleD'];
    $detalleT = $_POST['detalleT'];
    date_default_timezone_set('America/Bogota');
    $fechaModificacion = date("Y-m-d H:i:s");

    $this->mdlModificarAsignacion->__SET("_idAmbulancia",$ambulancia);
    $tAmbulancia = $this->mdlModificarAsignacion->ConsultarTipoAmbulancia();
    $tipoAmbulancia = $tAmbulancia->tipoAmbulancia;
    if ($tipoAmbulancia == 'TAM') {
      $this->mdlModificarAsignacion->__SET("_idPersona",$personaU);
      $respuestaU = $this->mdlModificarAsignacion->ConsultarEspecialidadPersona();
      //var_dump($respuestaU);
      $especialidadU = $respuestaU->descripcionRol;

      $this->mdlModificarAsignacion->__SET("_idPersona",$personaD);
      $respuestaD = $this->mdlModificarAsignacion->ConsultarEspecialidadPersona();
      $especialidadD = $respuestaD->descripcionRol;
      $this->mdlModificarAsignacion->__SET("_idPersona",$personaT);
      $respuestaT = $this->mdlModificarAsignacion->ConsultarEspecialidadPersona();
      $especialidadT = $respuestaT->descripcionRol;
      if ($especialidadU == 'Medico' || $especialidadU == 'medico' || $especialidadU == 'Medico General' || $especialidadU == 'medico general') {
        $this->mdlModificarAsignacion->__SET("_idAsignacion",$idAsignacion);
        $this->mdlModificarAsignacion->__SET("_idAmbulancia",$ambulancia);
        $this->mdlModificarAsignacion->__SET("_fechaHoraAsignacion",$fechaModificacion);
        $this->mdlModificarAsignacion->__SET("_longitud",$longitud);
        $this->mdlModificarAsignacion->__SET("_latitud",$latitud);
        $modificarAsignacion = $this->mdlModificarAsignacion->ModificarAsignacion();
        $this->mdlModificarAsignacion->__SET("_idPersona",$personaU);
        $ModifcarEstadoDetalle = $this->mdlModificarAsignacion->ActualizarEstadoDetalleAsignacion();
        $this->mdlModificarAsignacion->__SET("_idPersona",$personaU);
        $this->mdlModificarAsignacion->__SET("_idDetalle",$detalleU);
        $this->mdlModificarAsignacion->__SET("_idAmbulancia",$ambulancia);
        $modificacionUno = $this->mdlModificarAsignacion->ModificarDetalleAsignacion();
        $this->mdlModificarAsignacion->__SET("_idPersona",$personaD);
        $ModifcarEstadoDetalle = $this->mdlModificarAsignacion->ActualizarEstadoDetalleAsignacion();
        $this->mdlModificarAsignacion->__SET("_idPersona",$personaD);
        $this->mdlModificarAsignacion->__SET("_idDetalle",$detalleD);
        $this->mdlModificarAsignacion->__SET("_idAmbulancia",$ambulancia);
        $modificacionDos = $this->mdlModificarAsignacion->ModificarDetalleAsignacion();
        $this->mdlModificarAsignacion->__SET("_idPersona",$personaT);
        $ModifcarEstadoDetalle = $this->mdlModificarAsignacion->ActualizarEstadoDetalleAsignacion();
        $this->mdlModificarAsignacion->__SET("_idPersona",$personaT);
        $this->mdlModificarAsignacion->__SET("_idDetalle",$detalleT);
        $this->mdlModificarAsignacion->__SET("_idAmbulancia",$ambulancia);
        $modificacionTres = $this->mdlModificarAsignacion->ModificarDetalleAsignacion();
        echo json_encode("modifique");
      }
      else if ($especialidadD == 'Medico' || $especialidadD == 'medico' || $especialidadD == 'Medico General' || $especialidadD == 'medico general') {
        $this->mdlModificarAsignacion->__SET("_idPersona",$personaU);
        $this->mdlModificarAsignacion->__SET("_idDetalle",$detalleU);
        $this->mdlModificarAsignacion->__SET("_idAmbulancia",$ambulancia);
        $modificacionUno = $this->mdlModificarAsignacion->ModificarDetalleAsignacion();
        $this->mdlModificarAsignacion->__SET("_idPersona",$personaD);
        $ModifcarEstadoDetalle = $this->mdlModificarAsignacion->ActualizarEstadoDetalleAsignacion();
        $this->mdlModificarAsignacion->__SET("_idPersona",$personaD);
        $this->mdlModificarAsignacion->__SET("_idDetalle",$detalleD);
        $this->mdlModificarAsignacion->__SET("_idAmbulancia",$ambulancia);
        $modificacionDos = $this->mdlModificarAsignacion->ModificarDetalleAsignacion();
        $this->mdlModificarAsignacion->__SET("_idPersona",$personaT);
        $ModifcarEstadoDetalle = $this->mdlModificarAsignacion->ActualizarEstadoDetalleAsignacion();
        $this->mdlModificarAsignacion->__SET("_idPersona",$personaT);
        $this->mdlModificarAsignacion->__SET("_idDetalle",$detalleT);
        $this->mdlModificarAsignacion->__SET("_idAmbulancia",$ambulancia);
        $modificacionTres = $this->mdlModificarAsignacion->ModificarDetalleAsignacion();
        echo json_encode("modifique");
      }
      else if ($especialidadT == 'Medico' || $especialidadT == 'medico' || $especialidadT == 'Medico General' || $especialidadT == 'medico general') {
        $this->mdlModificarAsignacion->__SET("_idPersona",$personaU);
        $this->mdlModificarAsignacion->__SET("_idDetalle",$detalleT);
        $this->mdlModificarAsignacion->__SET("_idAmbulancia",$ambulancia);
        $modificacionUno = $this->mdlModificarAsignacion->ModificarDetalleAsignacion();
        $this->mdlModificarAsignacion->__SET("_idPersona",$personaD);
        $ModifcarEstadoDetalle = $this->mdlModificarAsignacion->ActualizarEstadoDetalleAsignacion();
        $this->mdlModificarAsignacion->__SET("_idPersona",$personaD);
        $this->mdlModificarAsignacion->__SET("_idDetalle",$detalleT);
        $this->mdlModificarAsignacion->__SET("_idAmbulancia",$ambulancia);
        $modificacionDos = $this->mdlModificarAsignacion->ModificarDetalleAsignacion();
        $this->mdlModificarAsignacion->__SET("_idPersona",$personaT);
        $ModifcarEstadoDetalle = $this->mdlModificarAsignacion->ActualizarEstadoDetalleAsignacion();
        $this->mdlModificarAsignacion->__SET("_idPersona",$personaT);
        $this->mdlModificarAsignacion->__SET("_idDetalle",$detalleT);
        $this->mdlModificarAsignacion->__SET("_idAmbulancia",$ambulancia);
        $modificacionTres = $this->mdlModificarAsignacion->ModificarDetalleAsignacion();
        echo json_encode("modifique");
      }else{
        echo json_encode($especialidadU);
        echo json_encode($especialidadD);
        echo json_encode($especialidadT);
        echo "TAM";
      }
    }else{
      $this->mdlModificarAsignacion->__SET("_idPersona",$personaU);
      $respuestaU = $this->mdlModificarAsignacion->ConsultarEspecialidadPersona();
      $especialidadU = $respuestaU->descripcionRol;
      $this->mdlModificarAsignacion->__SET("_idPersona",$personaD);
      $respuestaD = $this->mdlModificarAsignacion->ConsultarEspecialidadPersona();
      $especialidadD = $respuestaD->descripcionRol;
      $this->mdlModificarAsignacion->__SET("_idPersona",$personaT);
      $respuestaT = $this->mdlModificarAsignacion->ConsultarEspecialidadPersona();
      $especialidadT = $respuestaT->descripcionRol;
      if ($especialidadU == 'Paramedico' && $especialidadD == 'Paramedico' && $especialidadT == 'Paramedico' || $especialidadU == 'paramedico' && $especialidadD == 'paramedico' && $especialidadT == 'paramedico') {
        $this->mdlModificarAsignacion->__SET("_idPersona",$personaU);
        $this->mdlModificarAsignacion->__SET("_idDetalle",$detalleT);
        $this->mdlModificarAsignacion->__SET("_idAmbulancia",$ambulancia);
        $modificacionUno = $this->mdlModificarAsignacion->ModificarDetalleAsignacion();
        $this->mdlModificarAsignacion->__SET("_idPersona",$personaD);
        $this->mdlModificarAsignacion->__SET("_idDetalle",$detalleT);
        $this->mdlModificarAsignacion->__SET("_idAmbulancia",$ambulancia);
        $modificacionDos = $this->mdlModificarAsignacion->ModificarDetalleAsignacion();
        $this->mdlModificarAsignacion->__SET("_idPersona",$personaT);
        $this->mdlModificarAsignacion->__SET("_idDetalle",$detalleT);
        $this->mdlModificarAsignacion->__SET("_idAmbulancia",$ambulancia);
        $modificacionTres = $this->mdlModificarAsignacion->ModificarDetalleAsignacion();
        echo json_encode("modifique");
      }else{
        echo "TAB";
      }


    }

  }
}

?>
