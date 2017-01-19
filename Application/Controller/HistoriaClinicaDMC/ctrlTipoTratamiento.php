<?php


class ctrlTipoTratamiento extends Controller implements iController {

  private $objTipoTratamiento;

  
  public function __construct() {
    //Sesion::init();
    //if (!Sesion::exist()) {
    //header("Location: " . URL . "Usuarios/Usuario");
    //exit();
    //} else {
    $this->objTipoTratamiento = $this->loadModel('HistoriaClinicaDMC', 'mdlTipoTratamiento');
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


  public function Registrar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objTipoTratamiento->SetDescripcionTipoTratamiento($valores[0]);
    $this->objTipoTratamiento->SetCategoriaTratamiento($valores[1]);
    echo $this->objTipoTratamiento->RegistrarTipoTratamiento();
  }


  public function Modificar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objTipoTratamiento->SetIdTipoTratamiento($valores[0]);
    $this->objTipoTratamiento->SetDescripcionTipoTratamiento($valores[1]);
    $this->objTipoTratamiento->SetCategoriaTratamiento($valores[2]);
    echo $this->objTipoTratamiento->ModificarTipoTratamiento();
  }

 
  public function CambiarEstado()
  {
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo'? 'Inactivo' : 'Activo';
    $this->objTipoTratamiento->SetIdTipoTratamiento($id);
    $this->objTipoTratamiento->SetEstadoTipoTratamiento($estado);
    echo $this->objTipoTratamiento->CambiarEstadoTipoTratamiento();
  }
}

?>
