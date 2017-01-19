<?php
class CtrlTipoAseguramiento extends Controller implements iController {
  private $objTipoAseguramiento;


  /**
  * Método constructor()
  */
  public function __construct() {
    $this->objTipoAseguramiento = $this->loadModel('ReporteAPH', 'mdlTipoAseguramiento');
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
    $this->objTipoAseguramiento->SetDescripcionTipoAseguramiento($valores[0]);
    echo $this->objTipoAseguramiento->RegistrarTipoAseguramiento();
  }


  public function Modificar() {
    $valores = json_decode($_POST['Valores']);
    $this->objTipoAseguramiento->SetIdTipoAseguramiento($valores[0]);
    $this->objTipoAseguramiento->SetDescripcionTipoAseguramiento($valores[1]);
    echo $this->objTipoAseguramiento->ModificarTipoAseguramiento();
  }


  public function CambiarEstado() {
    $id     = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo' ? 'Inactivo' : 'Activo';
    $this->objTipoAseguramiento->SetIdTipoAseguramiento($id);
    $this->objTipoAseguramiento->SetEstadoTipoAseguramiento($estado);
    echo $this->objTipoAseguramiento->CambiarEstadoTipoAseguramiento();
  }


  function registrarTipoAseguramientoHC() {
    $objTipo = json_decode(file_get_contents("php://input"));
    if (!isset($objTipo)) {
      echo json_encode("null");
    } else {
      $descripcionTA = $objTipo->descripcion;
      $this->objTipoAseguramiento->__SET("DescripcionTipoAseguramiento", $descripcionTA);
      $ultimoTA = $this->objTipoAseguramiento->registrarTipoAseguramientoHC();
      if ($ultimoTA != null) {
        echo json_encode($ultimoTA);
      } else {
        echo json_encode(0);
      }
    }
  }


} // Fin clase
?>
