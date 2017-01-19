<?php

class control extends Controller {



    private $mdlPersonaI = null;


    function __construct() {


    }


    public function consultar() {
        $this->loadModel("clase","SSP");


        //require APP . "model/clase.php";
        $table = 'prueba';

        $primaryKey = 'id';

        $columns = array(
            array('db' => 'id', 'dt' => 0),
            array('db' => 'name', 'dt' => 1),
            array('db' => 'lastname', 'dt' => 2),
            array('db' => 'country', 'dt' => 3),
            array('db' => 'estado', 'dt' => 4),
            array('btn' => 'modificar', 'dt' =>5),
            array('btn' => 'eliminar', 'dt' => 6)
        );

        echo json_encode(
                //SSP::simple( $_GET, $table, $primaryKey, $columns )
                $this->model->simple($_GET, $table, $primaryKey, $columns)
        );
    }
    public function RegistrarPersona() {
        $this->loadModel("mdlPersona","mdl");
        $nombre = $_POST["txtnombre"];
        $apellido = $_POST["txtapellido"];
        $pais = $_POST["txtpais"];
        $registrar =  $this->model->MdlRegistrarPersona($nombre, $apellido,$pais);
        if ($registrar) {
            echo json_encode(["Bien"]);
        } else {
            echo json_encode(["Mal"]);
        }
    }
    public function ActualizarPersona(){
        $this->loadModel("mdlPersona","mdl");
        $nombre = $_POST["txtnombre"];
        $apellido = $_POST["txtapellido"];
        $pais = $_POST["txtpais"];
        $id = $_POST["txtCodigo"];
        $Actualizar =  $this->model->ActualizarPersona($nombre, $apellido,$pais,$id);
        if ($Actualizar) {
            echo json_encode(["Bien"]);
        } else {
            echo json_encode(["Mal"]);
        }
    }

}
