<?php

/*
* Interfaz iController:
* Esta interfaz obliga a las clases controladoras a
* implementar el método Index() el cual se encarga
* de cargar la página principal de dicho controlador
*/
interface iController {
  public function Index();
}

?>
