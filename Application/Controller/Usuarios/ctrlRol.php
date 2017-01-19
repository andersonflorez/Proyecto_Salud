<?php

class ctrlRol extends Controller implements iController {

  private $objRol;

  /**
  * Método constructor()
  * Inicializa el uso de variables de sesión y
  * valida si hay una sesión abierta, sino la hay
  * redirecciona hacia el login de la aplicación:
  */

  public function __construct() {

    // Sesion::init();
    // if (!Sesion::exist()) {
    // header("Location: ".URL);
    // exit();
    // } else {
    $this->objRol = $this->loadModel('Usuarios', 'mdlRol');
    // }

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
    $this->objRol->SetDescripcionRol($valores[0]);
    echo $this->objRol->RegistrarRol();

  }

  // Función para modificar un tipo de evento:
  public function Modificar() {

    $valores = json_decode($_POST['Valores']);
    $this->objRol->SetIdRol($valores[0]);
    $this->objRol->SetDescripcionRol($valores[1]);
    echo $this->objRol->ModificarRol();
    
  }

  // Función para cambiar el estado de un tipo de evento:
  public function CambiarEstado() {

    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo'? 'Inactivo' : 'Activo';
    $this->objRol->SetIdRol($id);
    $this->objRol->SetEstadoRol($estado);
    echo $this->objRol->CambiarEstadoRol();

  }

}

?>
