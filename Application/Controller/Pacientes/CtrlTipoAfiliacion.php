<?php

/**
* Class nombre_del_controlador:
* Escribe aqui la descripción de lo que hace este controlador
* Copia este formato de controlador para todos los controladores
* que necesites crear ya que todos deben tener esta estructura.
*/
class CtrlTipoAfiliacion extends Controller implements iController {

  private $objTipoAfiliacion;
  
  /**
  * Método constructor()
  * Inicializa el uso de variables de sesión y
  * valida si hay una sesión abierta, sino la hay
  * redirecciona hacia el login de la aplicación:
  */
  public function __construct() {
    Sesion::init();
    if (!Sesion::exist()) {
      //header("Location: " . URL . "Usuarios/Usuario");
    }
    $this->objTipoAfiliacion = $this->loadModel('Pacientes', 'MdlTipoAfiliacion');
  }

  /**
  * Método Index() obligatorio
  * Carga la página principal de este controlador:
  */

  public function Index(){
    header('Location: ' . URL . 'Error/Error');
  }

  public function Registrar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objTipoAfiliacion->SetdescripcionAfiliacion($valores[0]);
    echo $this->objTipoAfiliacion->RegistrarTipoAfiliacion();
  }

  public function Modificar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objTipoAfiliacion->SetidTipoAfiliacion($valores[0]);
    $this->objTipoAfiliacion->SetdescripcionAfiliacion($valores[1]);
    echo $this->objTipoAfiliacion->ModificarTipoAfiliacion();
  }

  public function CambiarEstado()
  {
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo'? 'Inactivo' : 'Activo';
    $this->objTipoAfiliacion->SetidTipoAfiliacion($id);
    $this->objTipoAfiliacion->SetestadoTabla($estado);
    echo $this->objTipoAfiliacion->CambiarEstadoTipoAfiliacion();
  }

}

?>
