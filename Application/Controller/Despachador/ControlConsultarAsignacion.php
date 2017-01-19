<?php

/**
 *
 */
class ControlConsultarAsignacion extends Controller implements iController
{
  private $_mdlAsignacionPersonal = null;
  private $_mdlDetalleAsignacion = null;
  private  $styles;
  private  $scripts;

  public  function __construct()
  {
  /*  $this->mdlAsignacionPersonal = $this->loadModel(
    'Despachador',
    'mdlAsignacionPersonal'
  );
  $this->mdlDetalleAsignacion = $this->loadModel(
  'Despachador',
  'mdlDetalleAsignacionPersonal'
);*/
  }

  public function Index() {

    $this->styles = array(
      "Despachador/style.css",
      "Despachador/jplist-pages-Consulta.css",
      "Despachador/jplist-core-Consulta.css",
      "Despachador/jplist.pagination-bundle-Consulta.css"
    );

    // Cargar JAVASCRIPTS de 'ReporteAPH/index.php':
    $this->scripts = array(
      "Despachador/jplist.core.min.js",
      "Despachador/jplist.pagination-bundle.min.js",
      "Todos/modal.js"
    );


    require APP . 'View/_layout/header.php'; // Carga la barra de navegación y los CSS
    require APP . 'View/Despachador/ViewConsultarAsignacion.php'; // Carga nuestra vista
    require APP . 'View/_layout/footer.php'; // Carga los Javascripts
    echo "<script>
    $(document).ready(function(){

      $('#paginacion').jplist({
        itemsBox: '.list'
        ,itemPath: '.List-item'
        ,panelPath: '.jplist-panel'
      });
    });</script>";
  }


}

 ?>
