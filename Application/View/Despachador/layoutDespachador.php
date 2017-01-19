<!-- CONTORLADOR DE ANGULAR JS -->
<div ng-app="Despachador" ng-controller="ctrlLayoutReporteAPH">



  



  <!-- DIALOGO DE SOLICITUD -->
  
  <!-- CAMPANA DE NOTIFICACIONES -->
  <div id="contenedor-notificaciones">
    <span  class="flotante-notify fa fa-bell-o" id="flotante-notify" contador="6"></span>
  </div>

  <!--MENÚ FLOTANTE NOTIFICACIONES-->
  <div class=" menu-notificaciones-flotantes" style="right: -1000px;">
    <div class="encabezado-notfy-f">
      <div class="titulo-notificaciones-f">
        <h4>
          Notificaciones
        </h4>
        <span class="cerrarMenuNF fa fa-search" id="MostrarFiltrarN"></span>
        <span class="cerrarMenuNF fa fa-reply" id="MostrarMenuN"></span>
      </div>

      <input type="text" name="txtFiltrarNotificacionesE" id="txtFiltrarNotificacionesE" placeholder="Filtrar Notificaciones">
    </div>

    <div class="cont-notificaciones-f">
      <a href="reporteInicial.html">
        <div class="notificacion-f n-llamada">
          <div class="icon-llamada">
            <span class="fa fa-exclamation"></span>
          </div>
          <div class="contenido-notifiN">
            <h5>EMERGENCIA! <span>11:23 pm</span></h5>
            <p>
              <b>Accidente de transito:</b> Se informa que un auto colisionó con un bus...
            </p>
            <p><b>Dirección:</b> Cra: 47 #34-45</p>
          </div>
        </div>
      </a>
      <a href="reporteInicial.html">
        <div class="notificacion-f n-llamada">
          <div class="icon-llamada">
            <span class="fa fa-exclamation"></span>
          </div>
          <div class="contenido-notifiN">
            <h5>EMERGENCIA! <span>09:23 pm</span></h5>
            <p>
              <b>Herida de Bala:</b> Se informa que un hombre de mediana edad tiene una herida de fuego...
            </p>
            <p><b>Dirección:</b> Cra: 47 #34-45</p>
          </div>
        </div>
      </a>
      <a href="reporteInicial.html">
        <div class="notificacion-f n-llamada">
          <div class="icon-llamada">
            <span class="fa fa-exclamation"></span>
          </div>
          <div class="contenido-notifiN">
            <h5>EMERGENCIA! <span>01:23 pm</span></h5>
            <p>
              <b>Un herido y un Muerto:</b> Se informa que un que hay una pelea callejera con 3 individuos heridos...
            </p>
            <p><b>Dirección:</b> Cra: 47 #34-45</p>
          </div>
        </div>
      </a>
    </div>


  </div>

  <!-- DATOS NECESARIOS PARA LOS SCRIPT  -->
  <script>
  var  idReporteInicial = 5;
  var  idAmbulancia = 5;
  </script>

</div>
