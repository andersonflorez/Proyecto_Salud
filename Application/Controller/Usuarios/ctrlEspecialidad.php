<?php

class ctrlEspecialidad extends Controller implements iController {

  private $objEspecialidad;

  /**
  * Método constructor()
  * Inicializa el uso de variables de sesión y
  * valida si hay una sesión abierta, sino la hay
  * redirecciona hacia el login de la aplicación:
  */
  public function __construct() {

    //Sesion::init();
    //if (!Sesion::exist()) {
    // header("Location: ".URL);
    //exit();
    //} else {
    $this->objEspecialidad = $this->loadModel('Usuarios', 'mdlEspecialidad');
    //}

  }

  /**
  * Método Index()
  * Renderiza la página de error debido a que este archivo solo puede
  * ser accedido mediante ajax
  */

  public function Index() {
    header('Location: ' . URL . 'Maestras/ctrlMaestras');
  }

  // Función para registrar un tipo de evento:
  public function Registrar() {

    $valores = json_decode($_POST['Valores']);
    $this->objEspecialidad->SetDescripcionEspecialidad($valores[0]);
    echo $this->objEspecialidad->RegistrarEspecialidad();

  }

  // Función para modificar un tipo de evento:
  public function Modificar() {

    $valores = json_decode($_POST['Valores']);
    $this->objEspecialidad->SetIdEspecialidad($valores[0]);
    $this->objEspecialidad->SetDescripcionEspecialidad($valores[1]);
    echo $this->objEspecialidad->ModificarEspecialidad();

  }

  // Función para cambiar el estado de un tipo de evento:
  public function CambiarEstado() {

    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo'? 'Inactivo' : 'Activo';
    $this->objEspecialidad->SetIdEspecialidad($id);
    $this->objEspecialidad->SetEstadoEspecialidad($estado);
    echo $this->objEspecialidad->CambiarEstadoEspecialidad();

  }
  
}

?>
