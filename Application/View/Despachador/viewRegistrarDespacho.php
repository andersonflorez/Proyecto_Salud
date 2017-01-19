<!-- CONTENIDO VISTA -->
<!-- <div class="n_flex n_flex_col95 sm_flex_col90"> -->
<div class="n_flex content_page scroll_y whole_wrapper">

  <!-- TITULO VISTA -->
  <!-- <div class="n_flex n_flex_col100">
    <h1 class="titulo_vista"><span class="fa fa-paper-plane"></span>Despachador</h1>
  </div> -->

  <!-- Ubicacion -->
  <div class="n_flex n_flex_col100 md_flex_col65 horizontal_padding vertical_padding">
    <div class="panel">
      <h1 class="titulo_vista"><span class="fa fa-paper-plane"></span>Despachador</h1>
      <div class="panel-contenido">
        <div id="map" style="width: 100%; height: 420px">
          <input type="text" id="txtLL" placeholder="Ingrese dirección" value="">
        </div>
      </div>
    </div>
  </div>

  <!-- PANELES DESPACHO Y REPORTES -->
  <div class="n_flex n_flex_col100 md_flex_col35 horizontal_padding scroll_y  vertical_padding multi_column">
    <div class="panel n_flex relative_element n_in_columns">
      <!-- Tabs -->
      <div class="n_flex tabs">
        <button class="n_flex n_align_center tab-button" tab="REGISTRO" id="tabDespacho">
          <span class="text_bold">
            <i class="fa fa-location-arrow" aria-hidden="true"></i>
            DESPACHO
          </span>
        </button>
        <button class="n_flex n_align_center tab-button active-tab" tab="REPORTES" id="tabReportes">
          <span class="text_bold">
            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
            REPORTES
          </span>
        </button>
      </div>

      <div class="panel-contenido n_flex scroll_y n_grow_up">
        <!-- Registro despacho -->
        <div id="panelRegistroDespacho" class="n_flex n_align_center col-panel hidden">
          <form id="frmDespacho">
            <div class="frmCont">
              <label for="campo1">Descripción reporte inicial:</label>
              <div class="frmInput">
                <textarea  id="txtInformacion" readonly data-rule-required="true" name="txtInformacion" placeholder="Descripcion..." rows="4"></textarea>
                <input type="hidden" class="input_data"  id="idReporte" name="txtidReporte" value="" />
              </div>
            </div>
            <div class="frmCont">
              <label for="campo1">Numero de lesionados:</label>
              <div class="frmInput">
                <input type="text" class="input_data" data-rule-required="true"  readonly id="lesionados" name="txtlesionados" placeholder="Lesionados...">
              </div>
            </div>
            <div class="frmCont">
              <label for="campo1">Tipo Ambulancia:</label>
              <div class="frmInput">
                <input type="text" id="Ambulancia"  readonly data-rule-required="true" name="txtAmbulancia" placeholder="Tipo ambulancia...">
                <input type="hidden" id="idAmbulancia"  class="input_data" data-rule-required="true" name="txtidAmbulancia" value="" >
              </div>
            </div>
            <div class="frmCont">
              <label for="campo1">Estado Despacho:</label>
              <div class="frmInput">
                <input type="text"  class="input_data " data-rule-required="true" readonly id="estadoE"   value="En proceso"  name="txtEstado" style="width: 100%" >
              </div>
            </div>
            <div class="frmCont">
              <input type="hidden" value="" class="input_data"  data-rule-required="true"  id="Longitud"  name="txtLong">
            </div>
            <div class="frmCont">
              <input type="hidden" value="" class="input_data" data-rule-required="true" id="Latitud" name="txtLati">
            </div>
            <div>
              <input type="hidden" name="txtIdNovedad" id="Novedad">
            </div>
            <div class="frmCont">
              <input type="hidden" value="5" class="input_data" data-rule-required="true" id="Persona" name="txtPersona">
            </div>
            <div class="n_flex_col100 block n_flex n_justify_center">
              <button  type="submit" id="btnRegistrarDespacho" numeroLesionados="0" class="btn btn-registrar">Realizar despacho</button>
              <button  type="submit" id="btnRegistrarDespachoNovedad" numeroLesionados="0" class="btn btn-registrar">Despachar Novedad</button>
            </div>
          </form>
        </div>
        <!-- Reportes -->
        <div id="panelReportes" class="n_flex n_grow_up scroll_y relative_element col-panel active-panel">
          <ul id="contenedor-reportes" class="scroll_y  list_panel n_flex n_align_center n_in_columns md_justify_center process-list" style="padding-bottom: 20% !important;">
          </ul>
        </div>
      </div>
      <div class="cont_paginador n_flex">
        <ul id="paginadorReportes" class="paginador"></ul>
      </div>
    </div>
  </div>

</div>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true">
</script>
<script type="text/javascript">

</script>

<!-- CAMPANA DE NOTIFICACIONES -->
<!-- <div id="contenedor-notificaciones">
  <span  class="flotante-notify fa fa-bell-o" id="flotante-notify"></span>
</div> -->

<!-- MENÚ DE NOTIFICACIONES -->
<div class=" menu-notificaciones-flotantes">
  <div class="encabezado-notfy-f">
    <div class="titulo-notificaciones-f">
      <h4>
        Notificaciones
      </h4>
      <!--<span class="cerrarMenuNF fa fa-search" id="MostrarFiltrarN"></span>-->
      <span class="cerrarMenuNF fa fa-times" id="MostrarMenuN"></span>
    </div>

    <input type="text" name="txtFiltrarNotificacionesE" id="txtFiltrarNotificacionesE" placeholder="Filtrar Notificaciones">
  </div>

  <div class="cont-notificaciones-f" id="novedad">
  </div>
</div>
