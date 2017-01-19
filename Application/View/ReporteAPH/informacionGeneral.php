<div ng-controller="CtrlInformacionGeneral">


  <!--FLECHA DERECHA-->
  <a href="<?=URL?>ReporteAPH/CtrlTipoEvento" title="Siguiente" class="flecha-der" onclick="validarBarraProgreso('ctrlTipoEvento')">
    <li class="fa fa-long-arrow-right"></li>
  </a>

  <!--FLECHA IZQUIERDA-->
  <a  title="Volver" class="flecha-izq" ng-click="FlechaIzquierdaInformacionGeneral()">
    <li class="fa fa-long-arrow-left" ></li>
  </a>


<!-- CONTENIDO -->
<div class="n_flex n_justify_center margin-top"  >

  <!-- CONTENIDO VISTA -->
  <div class="n_flex n_flex_col95 sm_flex_col90">

    <!-- TITULO VISTA -->
    <h1 class="titulo_vista">
      <span class="fa fa-file-archive-o"></span>
      Información General
    </h1>

    <form class="n_flex n_flex_col100 n_justify_between" id="" method="post">

      <!-- DATOS INCIDENTE -->
      <div class="n_flex n_flex_col100 lg_flex_col60 horizontal_padding n_justify_around">
        <div class="panel block">
          <div class="panel-cabecera">
            <h3>Datos incidente</h3>
          </div>

          <div class="panel-contenido">
            <label>Ubicación del Incidente:</label>
            <input type="text" class="campo bloquear" value="{{ReporteInicial.direccion}}" name="txtUbicacionIncidente" readonly="readonly">

            <label>Punto de Referencia:</label>
            <input type="text" class="campo bloquear" value="{{ReporteInicial.puntoreferencia}}" name="txtPuntoReferencia" readonly="readonly">

            <label>Información Inicial:</label>
            <textarea name="name" class="campo bloquear" readonly="readonly" style="height:80px;">{{ReporteInicial.descripcionEmergencia}}</textarea>
          </div>

        </div> <!-- Fin .panel -->
      </div>

      <!-- CLASIFICACIÓN DE LA SITUACIÓN -->
      <div class="n_flex n_flex_col100 lg_flex_col40 n_justify_around horizontal_padding">
        <div class="panel block">
          <div class="panel-cabecera">
            <h3>Clasificación de la situación</h3>
          </div>

          <div class="panel-contenido no-pad-lados">
            <div class="rdo radio item-rdo-flex solid-top">
              <span><span class="fa fa-bookmark"></span>Emergencia</span>
              <input id="clasificacionEmergencia" type="radio" ng-disabled="true" name="radioClasificacion" value="">
              <label for="clasificacionEmergencia" class="rdo-redondo"></label>
            </div>
            <div class="rdo radio item-rdo-flex  solid-top">
              <span><span class="fa fa-bookmark"></span>Urgencia</span>
              <input id="clasificacionUrgencia" type="radio" ng-disabled="true" name="radioClasificacion" value="" ng-checked="true">
              <label for="clasificacionUrgencia" class="rdo-redondo"></label>
            </div>
            <div class="rdo radio item-rdo-flex solid-bottom solid-top">
              <span><span class="fa fa-bookmark"></span>Consulta</span>
              <input id="clasificacionConsulta" type="radio" ng-disabled="true" name="radioClasificacion" value="">
              <label for="clasificacionConsulta" class="rdo-redondo"></label>
            </div>
          </div>

        </div> <!-- Fin .panel -->
      </div>

      <!-- PERSONAL QUE ATIENDE -->
      <div class="n_flex n_flex_col100 lg_flex_col60 horizontal_padding n_justify_around">
        <div class="panel block">
          <div class="panel-cabecera">
            <h3>Personal que atiende</h3>
          </div>

          <div class="panel-contenido">
            <span class="subPersonal">Apoyo 1:</span>
            <input type="text" class="bloquear campo camposTres" value="{{apoyo1}}" name="txtApoyoUno" readonly="readonly">

            <span class="subPersonal">Apoyo 2:</span>
            <input type="text" class="bloquear campo camposTres" value="{{apoyo2}}" name="txtApoyoDos" readonly="readonly">

            <span class="subPersonal">Apoyo 3:</span>
            <input type="text" class="bloquear campo camposTres" value="{{apoyo3}}" name="txtApoyoTres" readonly="readonly">
          </div>

        </div> <!-- Fin .panel -->
      </div>

      <!-- TIEMPOS -->
      <div class="n_flex n_flex_col100 lg_flex_col40 n_justify_around horizontal_padding">
        <div class="panel block">
          <div class="panel-cabecera">
            <h3>Tiempos</h3>
          </div>

          <div class="panel-contenido">
            <label>Hora de Despacho:</label>
               <input type="time" class="campo" ng-disabled="true" name="txtHoraDespacho"  ng-value="tiempos.despacho">

               <label>Arribo a la escena:</label>
               <input type="time" class="campo" ng-disabled="true" name="txtArriboEscena" ng-value="tiempos.arriboEscena">

               <label>Arribo a la IPS:</label>
               <input type="time" class="campo" ng-disabled="true" name="txtArriboIPS" ng-value="tiempos.arriboIPS">

               <label>Fin de la Atención:</label>
               <input type="time" class="campo " ng-disabled="true" name="txtFinAtencion" style="margin-bottom:0.5em" ng-value="tiempos.finAtencion">
          </div>

        </div> <!-- Fin .panel -->
      </div>

    </form>

  </div>
</div> <!-- FIN CONTENIDO VISTA -->
</div>
