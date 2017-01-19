<?php

/**
* NOMBRE DE LA CLASE: ctrlTipoEvento
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Controlador de la tabla maestra tbl_tipoevento
* del módulo reporte inicial
*/
class ctrlTipoEvento extends Controller implements iController {

  private $objTipoEvento;

  /**
  * Método constructor()
  * Obtiene la única instancia del módelo
  */
  public function __construct() {
    $this->objTipoEvento = $this->loadModel('ReporteInicial', 'mdlTipoEvento');
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
    $this->objTipoEvento->__SET('descripcionTipoEvento', $valores[0]);
    echo $this->objTipoEvento->RegistrarTipoEvento();
  }

  // Función para modificar un tipo de evento:
  public function Modificar() {
    $valores = json_decode($_POST['Valores']);
    $this->objTipoEvento->__SET('idTipoEvento', $valores[0]);
    $this->objTipoEvento->__SET('descripcionTipoEvento', $valores[1]);
    echo $this->objTipoEvento->ModificarTipoEvento();
  }

  // Función para cambiar el estado de un tipo de evento:
  public function CambiarEstado() {
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo'? 'Inactivo' : 'Activo';
    $this->objTipoEvento->__SET('idTipoEvento', $id);
    $this->objTipoEvento->__SET('estadoTipoEvento', $estado);
    echo $this->objTipoEvento->CambiarEstadoTipoEvento();
  }
}

?>
