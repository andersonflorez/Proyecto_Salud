<?php

/**
* NOMBRE DE LA CLASE: ctrlEnteExterno
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Controlador de la tabla maestra tbl_enteexterno
* del módulo reporte inicial
*/
class CtrlTipoDocumento extends Controller implements iController {

  private $objTipoDocumento;

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
    $this->objTipoDocumento = $this->loadModel('Pacientes', 'MdlTipoDocumento');
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
    $this->objTipoDocumento->SetDescripcionTipoDocumento($valores[0]);
    echo $this->objTipoDocumento->RegistrarTipoDocumento();
  }

  // Función para modificar un tipo de evento:
  public function Modificar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objTipoDocumento->SetIdTipoDocumento($valores[0]);
    $this->objTipoDocumento->SetDescripcionTipoDocumento($valores[1]);
    echo $this->objTipoDocumento->ModificarTipoDocumento();
  }

  // Función para cambiar el estado de un tipo de evento:
  public function CambiarEstado()
  {
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo'? 'Inactivo' : 'Activo';
    $this->objTipoDocumento->SetIdTipoDocumento($id);
    $this->objTipoDocumento->SetEstadoTipoDocumento($estado);
    echo $this->objTipoDocumento->CambiarEstadoTipoDocumento();
  }
}

?>
