<?php

/**
* NOMBRE DE LA CLASE: CtrlTipoAsignacion
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Controlador de la tabla maestra tbl_ TipoAsignacion
* del módulo reporte inicial
*/
class CtrlTipoAsignacion extends Controller implements iController {

  private $objTipoAsignacion;

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
    $this->objTipoAsignacion = $this->loadModel('Stock', 'mdlTipoAsignacion');
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

  // Función para registrar un Tipo Asignacion:
  public function Registrar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objTipoAsignacion->setDescripcionTipoasignacion($valores[0]);
    echo $this->objTipoAsignacion->RegistrarTipoAsignacion();
  }

  // Función para modificar un Tipo Asignacion:
  public function Modificar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objTipoAsignacion->SetIdTipoAsignacion($valores[0]);
    $this->objTipoAsignacion->SetDescripcionTipoasignacion($valores[1]);
    echo $this->objTipoAsignacion->ModificarTipoAsignacion();
  }

  // Función para cambiar el estado de un Tipo Asignacion:
  public function CambiarEstado()
  {
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo'? 'Inactivo' : 'Activo';
    $this->objTipoAsignacion->SetIdTipoAsignacion($id);
    $this->objTipoAsignacion->SetEstadoTabla($estado);
    echo $this->objTipoAsignacion->CambiarEstadoTipoAsignacion();
  }
}
?>
