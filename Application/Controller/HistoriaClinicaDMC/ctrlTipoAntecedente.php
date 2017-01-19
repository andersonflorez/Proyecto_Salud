<?php

/**
* NOMBRE DE LA CLASE: ctrlTipoAntecedente
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Controlador de la tabla maestra tbl_tipoantecedente
* del módulo historia Clinica
*/
class ctrlTipoAntecedente extends Controller implements iController {

  private $objTipoAntecedente;

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
    $this->objTipoAntecedente = $this->loadModel('HistoriaClinicaDMC', 'mdlTipoAntecedente');
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

  // Función para registrar un tipo de antecedente:
  public function Registrar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objTipoAntecedente->SetDescripcionTipoAntecedente($valores[0]);
    echo $this->objTipoAntecedente->RegistrarTipoAntecedente();
  }

  // Función para modificar un tipo de antecedente:
  public function Modificar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objTipoAntecedente->SetIdTipoAntecedente($valores[0]);
    $this->objTipoAntecedente->SetDescripcionTipoAntecedente($valores[1]);
    echo $this->objTipoAntecedente->ModificarTipoAntecedente();

  }

  // Función para cambiar el estado de un tipo de antecedente:
  public function CambiarEstado()
  {
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo'? 'Inactivo' : 'Activo';
    $this->objTipoAntecedente->SetIdTipoAntecedente($id);
    $this->objTipoAntecedente->SetEstadoTipoAntecedente($estado);
    echo $this->objTipoAntecedente->CambiarEstadoTipoAntecedente();
  }
}

?>
