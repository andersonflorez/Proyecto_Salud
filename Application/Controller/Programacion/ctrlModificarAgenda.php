<?php

/**
* Class nombre_del_controlador:
* Escribe aqui la descripción de lo que hace este controlador
* Copia este formato de controlador para todos los controladores
* que necesites crear ya que todos deben tener esta estructura.
*/
class ctrlModificarAgenda extends Controller implements iController {

    private $styles;
    private $scripts;

    private $vistasMenu;

    function __construct() {
        Sesion::init();
        if (!Sesion::exist()) {
            header("Location: ".URL);
        }
    }


    public function Index() {
   $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));
        # NOTA: No es necesario cargar 'JQuery' ni 'main.css', ya vienen cargados por defecto

        // Cargar CSS de 'ViewAlgunaVista.php':
        $this->styles = array(
            URL . 'Public/Css/Programacion/inicio.css',
            URL . 'Public/Css/Programacion/main.css',

            // Y asi sucesivamente, separando con comas (,) cada estilo.css
        );

        // Cargar JAVASCRIPTS de 'ViewAlgunaVista.php':
        $this->scripts = array(
            URL . 'Public/Js/Programacion/jquey-1.11.3.min.js',

            // Y asi sucesivamente, separando con comas (,) cada script.js
        );

        // Luego se debe cargar la vista:
        require APP . 'View/_layout/header.php'; // Obligatorio, esta es la barra de navegación, linkea los css
        require APP . 'View/Programacion/ModificarAgenda.php'; // Aqui va el nombre de nuestra vista
        require APP . 'View/_layout/footer.php'; // Obligatorio, esto linkea los javascripts
    }
    /**
  * Método constructor()
  * Inicializa el uso de variables de sesión y
  * valida si hay una sesión abierta, sino la hay
  * redirecciona hacia el login de la aplicación:
  */
    /**
  * Método Index() obligatorio
  * Carga la página principal de este controlador:
  */
}

?>
