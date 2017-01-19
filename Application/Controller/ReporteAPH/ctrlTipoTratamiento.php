<?php
class CtrlTipoTratamiento extends Controller implements iController {
  private $objTipoTratamiento;

  /**
  * Método constructor()
  */
  public function __construct() {
    $this->objTipoTratamiento = $this->loadModel('ReporteAPH', 'mdlTipoTratamiento');
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
    $this->objTipoTratamiento->SetDescripcionTipoTratamiento($valores[0]);
    $this->objTipoTratamiento->SetCategoriaTratamiento($valores[1]);
    $this->objTipoTratamiento->SetCategoriaItemTratamiento($valores[2]);
    echo $this->objTipoTratamiento->RegistrarTipoTratamiento();
  }

  public function Modificar() {
    $valores = json_decode($_POST['Valores']);
    $this->objTipoTratamiento->SetIdTipoTratamiento($valores[0]);
    $this->objTipoTratamiento->SetDescripcionTipoTratamiento($valores[1]);
    $this->objTipoTratamiento->SetCategoriaTratamiento($valores[2]);
    $this->objTipoTratamiento->SetCategoriaItemTratamiento($valores[3]);
    echo $this->objTipoTratamiento->ModificarTipoTratamiento();
  }

  public function CambiarEstado() {
    $id     = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo' ? 'Inactivo' : 'Activo';
    $this->objTipoTratamiento->SetIdTipoTratamiento($id);
    $this->objTipoTratamiento->SetEstadoTipoTratamiento($estado);
    echo $this->objTipoTratamiento->CambiarEstadoTipoTratamiento();
  }


} // Fin clase
?>
