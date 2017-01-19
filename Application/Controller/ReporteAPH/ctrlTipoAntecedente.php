<?php
class CtrlTipoAntecedente extends Controller implements iController {
  private $objTipoAntecedente;

  /**
  * Método constructor()
  */
  public function __construct() {
    $this->objTipoAntecedente = $this->loadModel('ReporteAPH', 'mdlTipoAntecedente');
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
    $this->objTipoAntecedente->SetDescripcionTipoAntecedente($valores[0]);
    echo $this->objTipoAntecedente->RegistrarTipoAntecedente();
  }


  public function Modificar() {
    $valores = json_decode($_POST['Valores']);
    $this->objTipoAntecedente->SetIdTipoAntecedente($valores[0]);
    $this->objTipoAntecedente->SetDescripcionTipoAntecedente($valores[1]);
    echo $this->objTipoAntecedente->ModificarTipoAntecedente();
  }


  public function CambiarEstado() {
    $id     = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo' ? 'Inactivo' : 'Activo';
    $this->objTipoAntecedente->SetIdTipoAntecedente($id);
    $this->objTipoAntecedente->SetEstadoTipoAntecedente($estado);
    echo $this->objTipoAntecedente->CambiarEstadoTipoAntecedente();
  }


  public function ListarTipoAntecedente() {
    $ListaTipoAntecedente = $this->objTipoAntecedente->ListarTipoAntecedente();
    if ($ListaTipoAntecedente) {
      echo json_encode($ListaTipoAntecedente, JSON_UNESCAPED_UNICODE);
    } else {
      echo json_encode(null);
    }
  }

} // Fin clase
?>
