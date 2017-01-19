<?php


class ctrlTipoExamenEspecializado extends Controller implements iController {

  private $objTipoExamenEspecializado;


  public function __construct() {
    //Sesion::init();
    //if (!Sesion::exist()) {
    //header("Location: " . URL . "Usuarios/Usuario");
    //exit();
    //} else {
    $this->objTipoExamenEspecializado = $this->loadModel('HistoriaClinicaDMC', 'mdlTipoExamenEspecializado');
    //}
  }

  public function Index() {
    header('Location: ' . URL . 'Error/Error');
  }

  public function Registrar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objTipoExamenEspecializado->SetDescripcionTipoExamenEspecializado($valores[0]);
    echo $this->objTipoExamenEspecializado->RegistrarTipoExamenEspecializado();
  }

  public function Modificar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objTipoExamenEspecializado->SetIdTipoExamenEspecializado($valores[0]);
    $this->objTipoExamenEspecializado->SetDescripcionTipoExamenEspecializado($valores[1]);
    echo $this->objTipoExamenEspecializado->ModificarTipoExamenEspecializado();
  }

  public function CambiarEstado()
  {
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo'? 'Inactivo' : 'Activo';
    $this->objTipoExamenEspecializado->SetIdTipoExamenEspecializado($id);
    $this->objTipoExamenEspecializado->SetEstadoTipoExamenEspecializado($estado);
    echo $this->objTipoExamenEspecializado->CambiarEstadoTipoExamenEspecializado();
  }
}

?>
