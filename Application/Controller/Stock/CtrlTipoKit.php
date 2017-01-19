<?php

/**
* NOMBRE DE LA CLASE: ctrlTipoKit
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Controlador de la tabla maestra tbl_tipokit
* del módulo Stock
*/
class ctrlTipoKit extends Controller implements iController {

  private $objTipoKit;

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
    $this->objTipoKit = $this->loadModel('Stock', 'mdlTipoKit');
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
    $this->objTipoKit->SetdescripcionTipoKit($valores[0]);
    echo $this->objTipoKit->RegistrarTipoKit();
  }
  // Función para modificar un tipo de Novedad:
  public function Modificar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objTipoKit->SetIdTipoKit($valores[0]);
    $this->objTipoKit->SetDescripcionTipoKit($valores[1]);
    echo $this->objTipoKit->ModificarTipoKit();
  }

  // Función para cambiar el estado de un tipo de Novedad:
  public function CambiarEstado()
  {
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo'? 'Inactivo' : 'Activo';
    $this->objTipoKit->SetIdTipoKit($id);
    $this->objTipoKit->SetEstadoTabla($estado);
    echo $this->objTipoKit->CambiarestadoTabla();
  }
}

?>
