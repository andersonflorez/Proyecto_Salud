<?php

/*
* Interfaz iModel:
* Esta interfaz obliga a las clases del modelo a
* implementar la función estática getInstance()
* que devuelve una única instancia de dicha clase.
*
* Se debe pasar por parámetro la conexión a la
* base de datos para que la clase pueda tener
* acceso a ella.
*/
interface iModel {
  public static function getInstance($_CONEXION);
}

?>
