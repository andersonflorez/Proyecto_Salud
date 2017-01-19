<?php

/**
* NOMBRE DE LA CLASE: ctrlTipoOrigenAtencion
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Controlador de la tabla maestra tbl_tipoorigenAtencion
* del módulo historia Clinica
*/
class ctrlTipoOrigenAtencion extends Controller implements iController {

  private $objTipoOrigenAtencion;

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
    $this->objTipoOrigenAtencion = $this->loadModel('HistoriaClinicaDMC', 'mdlOrigenAtencion');
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

  // Función para registrar un tipo de origenAtencion:
  public function Registrar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objTipoOrigenAtencion->SetDescripcionTipoOrigenAtencion($valores[0]);
    echo $this->objTipoOrigenAtencion->RegistrarTipoOrigenAtencion();
  }

  // Función para modificar un tipo de origenAtencion:
  public function Modificar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objTipoOrigenAtencion->SetIdTipoOrigenAtencion($valores[0]);
    $this->objTipoOrigenAtencion->SetDescripcionTipoOrigenAtencion($valores[1]);
    echo $this->objTipoOrigenAtencion->ModificarTipoOrigenAtencion();
  }

  // Función para cambiar el estado de un tipo de origenAtencion:
  public function CambiarEstado()
  {
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo'? 'Inactivo' : 'Activo';
    $this->objTipoOrigenAtencion->SetIdTipoOrigenAtencion($id);
    $this->objTipoOrigenAtencion->SetEstadoTipoOrigenAtencion($estado);
    echo $this->objTipoOrigenAtencion->CambiarEstadoTipoOrigenAtencion();
  }
}

?>
