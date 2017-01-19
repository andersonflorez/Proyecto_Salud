<?php

/**
* NOMBRE DE LA CLASE: CtrlAmbulancia
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Controlador de la tabla maestra tbl_Ambulancia
* del módulo Despachador
*/
class ctrlAmbulancia extends Controller implements iController {

  private $objAmbulancia;

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
    $this->objAmbulancia = $this->loadModel('Despachador', 'mdlAmbulancia');
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

  // Función para registrar una ambulancia:
  public function Registrar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objAmbulancia->SetTipoAmbulancia($valores[0]);
    $this->objAmbulancia->SetPlacaAmbulancia($valores[1]);
    echo $this->objAmbulancia->RegistrarAmbulancia();
  }

  // Función para modificar una ambulancia:
  public function Modificar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objAmbulancia->SetIdAmbulancia($valores[0]);
    $this->objAmbulancia->SetTipoAmbulancia($valores[1]);
    $this->objAmbulancia->SetPlacaAmbulancia($valores[2]);
    echo $this->objAmbulancia->ModificarAmbulancia();
  }

  // Función para cambiar el estado de una ambulancia:
  public function CambiarEstado()
  {
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo'? 'Inactivo' : 'Activo';
    $this->objAmbulancia->SetIdAmbulancia($id);
    $this->objAmbulancia->SetEstadoAmbulancia($estado);
    echo $this->objAmbulancia->CambiarEstadoAmbulancia();
  }
}

?>
