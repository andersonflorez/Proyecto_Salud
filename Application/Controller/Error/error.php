<?php

/**
* Clase Error:
* Renderiza la vista de error
*/
class Error extends Controller {
  /**
  * METODO: index
  * Este método controla la página de error que se muestra
  * cuando una página no se encuentra.
  */
  public function Index() {
    require APP . 'View/Error/index.php';
  }
}