<?php

/*
* Controlador de controladres.
* No es necesario modificar este archivo
*/
class Controller {

    # Variable de conexión a la base de datos:
    public $conexion = null;

    # Variable que contiene el modelo al que pertenece el controlador solicitado:
    public $model = null;

    /**
  * Abrir la conexión a la base de datos teniendo en cuenta
  * su configuración en el archivo config.php:
  */

    public function validarVista($actual){
        $modelo = Self::loadModel("Home","mdlLogin");
        $vista  = $modelo->validarUrl($_SESSION["ID_ROL"]);
        foreach($vista as $registro){
            if($actual == $registro->urlVista){
                return true;
            }
        }
        return false;
    }

    private function openDatabaseConnection() {
        // (Opcional) Opciones de la conexion PDO. En este caso se establece que el 'fetch mode' de PDO
        // por defecto será "Objects", esto significa que todas los resultados de los querys serán tratados
        // como objetos, por ejemplo:
        # $resultado_query->usuario; // Obtiene el campo 'usuario' del resultado del query.
        # $resultado_query->contraseña; // Obtiene el campo 'contraseña' del resultado del query.
        // 'FETCH_ASSOC' puede ser otra opción, da como resultado:
        # $resultado_query['usuario']; // Obtiene el campo 'usuario' del resultado del query.
        # $resultado_query['contraseña']; // Obtiene el campo 'contraseña' del resultado del query.
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

        // Generar una conexión a la base de datos usando el conector PDO:
        $this->conexion = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS, $options);
    }

    /**
  * La siguiente función instancia un objeto del modelo solicitado.
  * Dicho de otra forma, carga el modelo asociado al presente controlador.
  * @return objeto del modelo
  */
    public function loadModel($nombreModulo, $nombreModelo) {
        $this->openDatabaseConnection();
        require APP . 'Model/'. $nombreModulo .'/'. $nombreModelo .'.php';
        // Crear un nuevo "modelo" (al cual se le pasa la conexión a la base de datos)
        return $nombreModelo::getInstance($this->conexion);
    }
}
