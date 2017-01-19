<?php

/**
* NOMBRE DE LA CLASE: ctrlTipoexamenFisico
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Controlador de la tabla maestra tbl_tipoexamenFisico
* del módulo historia Clinica
*/
class ctrlTipoExamenFisico extends Controller implements iController {

  private $objTipoExamenFisico;

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
    $this->objTipoExamenFisico = $this->loadModel('HistoriaClinicaDMC', 'mdlTipoExamenFisico');
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

  // Función para registrar un tipo de examenFisico:
  public function Registrar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objTipoExamenFisico->SetDescripcionTipoExamenFisico($valores[0]);
    echo $this->objTipoExamenFisico->RegistrarTipoExamenFisico();
  }

  // Función para modificar un tipo de examenFisico:
  public function Modificar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objTipoExamenFisico->SetIdTipoExamenFisico($valores[0]);
    $this->objTipoExamenFisico->SetDescripcionTipoExamenFisico($valores[1]);
    echo $this->objTipoExamenFisico->ModificarTipoExamenFisico();
  }

  // Función para cambiar el estado de un tipo de examenFisico:
  public function CambiarEstado()
  {
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo'? 'Inactivo' : 'Activo';
    $this->objTipoExamenFisico->SetIdTipoExamenFisico($id);
    $this->objTipoExamenFisico->SetEstadoTipoExamenFisico($estado);
    echo $this->objTipoExamenFisico->CambiarEstadoTipoExamenFisico();
  }
}

?>
