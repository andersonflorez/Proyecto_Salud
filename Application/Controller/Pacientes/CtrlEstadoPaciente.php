<?php

/**
* NOMBRE DE LA CLASE: ctrlEnteExterno
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Controlador de la tabla maestra tbl_enteexterno
* del módulo reporte inicial
*/
class CtrlEstadoPaciente extends Controller implements iController {

  private $objEstadoPaciente;

  /**
  * Método constructor()
  * Inicializa el uso de variables de sesión y
  * valida si hay una sesión abierta, sino la hay
  * redirecciona hacia el login de la aplicación:
  */
  public function __construct() {
    $this->objEstadoPaciente = $this->loadModel('Pacientes', 'MdlEstadoPaciente');

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
    $this->objEstadoPaciente->SetDescripcionEstadoPaciente($valores[0]);
    echo $this->objEstadoPaciente->RegistrarEstadoPaciente();
  }

  // Función para modificar un tipo de evento:
  public function Modificar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objEstadoPaciente->SetIdEstadoPaciente($valores[0]);
    $this->objEstadoPaciente->SetDescripcionEstadoPaciente($valores[1]);
    echo $this->objEstadoPaciente->ModificarEstadoPaciente();
  }

  // Función para cambiar el estado de un tipo de evento:
  public function CambiarEstado()
  {
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo'? 'Inactivo' : 'Activo';
    $this->objEstadoPaciente->SetIdEstadoPaciente($id);
    $this->objEstadoPaciente->SetIdEstadoPaciente($estado);
    echo $this->objEstadoPaciente->CambiarEstadoTipoDocumento();
  }
}

?>
