<?php

/**
* NOMBRE DE LA CLASE: ctrlEnteExterno
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Controlador de la tabla maestra tbl_enteexterno
* del módulo reporte inicial
*/
class CtrlConfiguracionCita extends Controller implements iController {

  private $objConfiguracion;

  /**
  * Método constructor()
  * Inicializa el uso de variables de sesión y
  * valida si hay una sesión abierta, sino la hay
  * redirecciona hacia el login de la aplicación:
  */
  public function __construct() {
    //Sesion::init();
    //if (!Sesion::exist()) {
    //header("Location: " . URL . "Usuarios/Usuario");
    //exit();
    //} else {
    $this->objConfiguracion = $this->loadModel('Citas', 'MdlConfiguracionCita');
    //}
  }

  /**
  * Método Index()
  * Renderiza la página de error debido a que este archivo solo puede
  * ser accedido mediante ajax
  */
  public function Index() {
    header('Location: ' . URL . 'Error/Error');
  }

  // Función para registrar un tipo de evento:
  public function Registrar()
  {
    date_default_timezone_set("America/Bogota");
    $fechaActual=date("Y-m-d");
    $valores = json_decode($_POST['Valores']);
    $this->objConfiguracion->SetcantidadCitasDia($valores[0]);
    $this->objConfiguracion->SetcantidadCitasMes($valores[1]);
    $this->objConfiguracion->SetdescripcionConfiguracion($valores[2]);
    $this->objConfiguracion->SetfechaConfiguracion($fechaActual);
    echo $this->objConfiguracion->RegistrarConfiguracion();
  }

  // Función para modificar un tipo de evento:
  public function Modificar()
  {
    date_default_timezone_set("America/Bogota");
    $fechaActual=date("Y-m-d");
    $valores = json_decode($_POST['Valores']);
    $this->objConfiguracion->SetcantidadCitasDia($valores[0]);
    $this->objConfiguracion->SetcantidadCitasMes($valores[1]);
    $this->objConfiguracion->SetdescripcionConfiguracion($valores[2]);
    $this->objConfiguracion->SetfechaConfiguracion($valores[3]);
    $this->objConfiguracion->SetidConfiguracion($fechaActual);
    echo $this->objConfiguracion->ModificarConfiguracion();
  }

  // Función para cambiar el estado de un tipo de evento:
  public function CambiarEstado()
  {
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo'? 'Inactivo' : 'Activo';
    $this->objConfiguracion->SetidConfiguracion($id);
    $this->objConfiguracion->SetEstadoConfiguracion($estado);
    echo $this->objConfiguracion->CambiarEstadoConfiguracion();
  }
}

?>
