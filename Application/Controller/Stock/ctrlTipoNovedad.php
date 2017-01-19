<?php

/**
* NOMBRE DE LA CLASE: ctrlTipoNovedad
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Controlador de la tabla maestra tbl_tipoNovedad
* del módulo Stock
*/
class ctrlTipoNovedad extends Controller implements iController {

  private $objTipoNovedad;

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
    $this->objTipoNovedad = $this->loadModel('Stock', 'mdlTipoNovedad');
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

  // Función para registrar un tipo de Novedad:
  public function Registrar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objTipoNovedad->SetDescripcionTipoNovedad($valores[0]);
    echo $this->objTipoNovedad->RegistrarTipoNovedad();
  }

  // Función para modificar un tipo de Novedad:
  public function Modificar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objTipoNovedad->SetIdTipoNovedad($valores[0]);
    $this->objTipoNovedad->SetDescripcionTipoNovedad($valores[1]);
    echo $this->objTipoNovedad->ModificarTipoNovedad();
  }

  // Función para cambiar el estado de un tipo de Novedad:
  public function CambiarEstado()
  {
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo'? 'Inactivo' : 'Activo';
    $this->objTipoNovedad->SetIdTipoNovedad($id);
    $this->objTipoNovedad->SetEstadoTabla($estado);
    echo $this->objTipoNovedad->CambiarEstadoTiponovedad();
  }
}

?>
