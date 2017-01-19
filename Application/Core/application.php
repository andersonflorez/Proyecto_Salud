<?php

/*
* Este es el corazón de la aplicacion.
* No es necesario modificar este archivo
*/

class Application {
  # Modulo: almacena el nombre del modulo de la URL
  private $url_module = false;

  # Controller: almacena el nombre del controlador de la URL
  private $url_controller = false;

  # Metodo (del controlador definido), a menudo también llamado "acción"
  private $url_action = false;

  # Array con los parametros o variables pasadas en la URL
  private $url_params = array();

  // Identificar la página solicitada:
  public function __construct() {

    $this->splitUrl();

    if (!$this->url_module) {

      // Cargar página de inicio de sesión:
      require APP . 'Controller/Home/ctrlIndex.php';
      $loginPage = new ctrlIndex();
      $loginPage->Index();

    } else {

      // Identificar el verdadero nombre del módulo:
      $module = $this->getModuleName($this->url_module);

      if (!$module) {

        // Redireccionar a la página de Error:
        header('Location: ' . URL . 'Error/Error');

      } else {

        if (!$this->url_controller) {

          // Redireccionar a la página de Error:
          header('Location: ' . URL . 'Error/Error');

        } else {

          // Identificar el verdadero nombre del controlador:
          $controller = $this->getControllerName($module, $this->url_controller);

          if (!$controller) {

            // Redireccionar a la página de Error:
            header('Location: ' . URL . 'Error/Error');

          } else {

            require $module . $controller;
            $controllerClass = new $this->url_controller;

            if (method_exists($controllerClass, $this->url_action)) {
              if (!empty($this->url_params)) {
                // Llamar al método y pasarle los argumentos si tiene
                call_user_func_array(array($controllerClass, $this->url_action), $this->url_params);
              } else {
                // Si no hay parámetros, se llama el método sin parámetros, como $this->home->method();
                $controllerClass->{$this->url_action}();
              }
            } else {
              if (strlen($this->url_action) == 0) {
                // Si no hay ninguna acción definida se llama el método Index() por defecto:
                $controllerClass->Index();
              }
              else {
                header('Location: ' . URL . 'Error/Error');
              }
            }

          }

        }

      }

    }

  }

  /**
  * Obtener y dividir la URL (Con el siguietne formato: /Modulo/Controlador/Metodo/Parámetros)
  */
  private function splitUrl() {

    if (isset($_GET['url'])) {

      // dividir URL
      $url = trim($_GET['url'], '/');
      $url = filter_var($url, FILTER_SANITIZE_URL);
      $url = explode('/', $url);

      // Colocar cada parte de la URL en su respectiva variable
      $this->url_module = isset($url[0]) ? $url[0] : false;
      $this->url_controller = isset($url[1]) ? $url[1] : false;
      $this->url_action = isset($url[2]) ? $url[2] : false;

      // Remueve el Modulo,Controlador y Metodo del URL, para que sea mas sencillo manipular los parametros.
      unset($url[0], $url[1], $url[2]);

      // Almacenar los valores de los parametros
      $this->url_params = array_values($url);

    }

  }

  private function getModuleName($module) {

    $module = strtolower($module);
    $modulesDirPath = APP . 'Controller';
    $modulesDir = opendir($modulesDirPath);
    $moduleName = false;

    while (($currentModule = readdir($modulesDir)) !== false) {
      if (strtolower($currentModule) === $module) {
        if (is_dir($modulesDirPath . '/' . $currentModule)) {
          $moduleName = $modulesDirPath . '/' . $currentModule . '/';
          break;
        }
      }
    }

    closedir($modulesDir);
    return $moduleName;

  }

  private function getControllerName($module, $controller) {

    $controller = strtolower($controller) . '.php';
    $moduleDirectory = opendir($module);
    $controllerName = false;

    while (($currentController = readdir($moduleDirectory)) !== false) {
      if (strtolower($currentController) === $controller) {
        if (file_exists($module . $currentController)) {
          $controllerName = $currentController;
          break;
        }
      }
    }

    closedir($moduleDirectory);
    return $controllerName;

  }

}
