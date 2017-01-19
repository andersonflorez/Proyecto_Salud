<?php

/**
* NOMBRE DE LA CLASE: ctrlEnteExterno
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Controlador de la tabla maestra tbl_enteexterno
* del módulo reporte inicial
*/
class CtrlTipoZona extends Controller implements iController {

  private $objdescripcionTipozona;

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
    $this->objdescripcionTipozona = $this->loadModel('Citas', 'MdlTipoZona');
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
    $valores = json_decode($_POST['Valores']);
    $this->objdescripcionTipozona->SetdescripcionTipozona($valores[0]);
    echo $this->objdescripcionTipozona->RegistrarTipozona();
  }

  // Función para modificar un tipo de evento:
  public function Modificar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objdescripcionTipozona->SetidTipoZona($valores[0]);
    $this->objdescripcionTipozona->SetdescripcionTipozona($valores[1]);
    echo $this->objdescripcionTipozona->ModificarTipozona();
  }

  // Función para cambiar el estado de un tipo de evento:
  public function CambiarEstado()
  {
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo'? 'Inactivo' : 'Activo';
    $this->objdescripcionTipozona->SetidTipoZona($id);
    $this->objdescripcionTipozona->SetEstadoTipozona($estado);
    echo $this->objdescripcionTipozona->CambiarEstadoTipozona();
  }
}

?>
