<?php
class CtrlCUP extends Controller implements iController{

    private $objCup;

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
        $this->objCup = $this->loadModel('HistoriaClinicaDMC', 'mdlCUP');
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
        $this->objCup->SetCodigoCup($valores[0]);
        $this->objCup->SetDescripcionCup($valores[1]);
        echo $this->objCup->RegistrarCup();
    }

    public function Modificar(){
        $valores = json_decode($_POST['Valores']);
        $this->objCup->SetIdCup($valores[0]);
        $this->objCup->SetCodigoCup($valores[1]);
        $this->objCup->SetDescripcionCup($valores[2]);
        echo $this->objCup->ModificarCup();
    }

    public function CambiarEstado(){
        $id = $_POST['id'];
        $estado = $_POST['estado'];
        $estado = $estado == 'Activo'? 'Inactivo' : 'Activo';
        $this->objCup->SetIdCup($id);
        $this->objCup->SetEstadoCup($estado);
        echo $this->objCup->CambiarEstadoCup();
    }





}



?>