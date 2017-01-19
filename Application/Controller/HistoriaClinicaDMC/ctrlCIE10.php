<?php
class CtrlCIE10 extends Controller implements iController{

private $objCie10;

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
  $this->objCie10 = $this->loadModel('HistoriaClinicaDMC', 'mdlCIE10');
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

// Función para registrar un tipo de evento:
public function Registrar()
{
  $valores = json_decode($_POST['Valores']);
  $this->objCie10->SetCodigoCie10($valores[0]);
  $this->objCie10->SetDescripcionCie10($valores[1]);
  echo $this->objCie10->RegistrarCie10();
}

public function Modificar(){
  $valores = json_decode($_POST['Valores']);
  $this->objCie10->SetIdCie10($valores[0]);
  $this->objCie10->SetCodigoCie10($valores[1]);
  $this->objCie10->SetDescripcionCie10($valores[2]);
  echo $this->objCie10->ModificarCie10();
}

public function CambiarEstado(){
  $id = $_POST['id'];
  $estado = $_POST['estado'];
  $estado = $estado == 'Activo'? 'Inactivo' : 'Activo';
  $this->objCie10->SetIdCie10($id);
  $this->objCie10->SetEstadoCie10($estado);
  echo $this->objCie10->CambiarEstadoCie10();
}





}





 ?>