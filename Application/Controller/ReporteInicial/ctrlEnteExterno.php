<?php

/**
* NOMBRE DE LA CLASE: ctrlEnteExterno
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Controlador de la tabla maestra tbl_enteexterno
* del módulo reporte inicial
*/
class ctrlEnteExterno extends Controller implements iController {

  private $objEnteExterno;

  /**
  * Método constructor()
  * Obtiene la única instancia del módelo
  */
  public function __construct() {
    $this->objEnteExterno = $this->loadModel('ReporteInicial', 'mdlEnteExterno');
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
  public function Registrar() {
    $valores = json_decode($_POST['Valores']);
    $this->objEnteExterno->__SET('descripcionEnteExterno', $valores[0]);
    echo $this->objEnteExterno->RegistrarEnteExterno();
  }

  // Función para modificar un tipo de evento:
  public function Modificar() {
    $valores = json_decode($_POST['Valores']);
    $this->objEnteExterno->__SET('idEnteExterno', $valores[0]);
    $this->objEnteExterno->__SET('descripcionEnteExterno', $valores[1]);
    echo $this->objEnteExterno->ModificarEnteExterno();
  }

  // Función para cambiar el estado de un tipo de evento:
  public function CambiarEstado() {
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo'? 'Inactivo' : 'Activo';
    $this->objEnteExterno->__SET('idEnteExterno', $id);
    $this->objEnteExterno->__SET('estadoEnteExterno', $estado);
    echo $this->objEnteExterno->CambiarEstadoEnteExterno();
  }
}

?>
