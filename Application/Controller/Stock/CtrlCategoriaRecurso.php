<?php

/**
* NOMBRE DE LA CLASE: CtrlCategoriaRecurso
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Controlador de la tabla maestra tbl_categoriarecurso
* del módulo reporte inicial
*/
class CtrlCategoriaRecurso extends Controller implements iController {

  private $objCategoriaRecurso;

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
    $this->objCategoriaRecurso = $this->loadModel('Stock', 'mdlCategoriaRecurso');
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

  // Función para registrar una categoria Recurso:
  public function Registrar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objCategoriaRecurso->setDescripcionCategoriarecurso($valores[0]);
    echo $this->objCategoriaRecurso->RegistrarCategoriaRecurso();
  }

  // Función para modificar una categoria recurso:
  public function Modificar()
  {
    $valores = json_decode($_POST['Valores']);
    $this->objCategoriaRecurso->SetIdCategoriaRecurso($valores[0]);
    $this->objCategoriaRecurso->setDescripcionCategoriarecurso($valores[1]);
    echo $this->objCategoriaRecurso->ModificarCategoriaRecurso();
  }

  // Función para cambiar el estado de una categoria recurso:
  public function CambiarEstado()
  {
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo'? 'Inactivo' : 'Activo';
    $this->objCategoriaRecurso->SetIdCategoriaRecurso($id);
    $this->objCategoriaRecurso->SetEstadoTabla($estado);
    echo $this->objCategoriaRecurso->CambiarEstadoCategoriaRecurso();
  }
}
?>
