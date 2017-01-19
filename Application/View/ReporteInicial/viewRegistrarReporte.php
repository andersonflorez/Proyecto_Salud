<style>
body{
  overflow: hidden;
}

.hidden_panel{
  display: none !important;
}

</style>

<div class="n_flex content_page whole_wrapper">

  <!-- Reportes en proceso -->
  <div class="n_flex n_flex_col100 md_flex_col40 lg_flex_col30 xl_flex_col30 vertical_padding horizontal_padding col-panel col-proceso">
    <div class="panel n_flex n_in_columns">
      <div class="n_flex order_reports">
        <button class="n_flex n_align_center order-button" type="ASC" order="2">
          <span class="text_bold">
            <i class="fa fa-angle-up" aria-hidden="true"></i>
            Ascendente
          </span>
        </button>
        <button class="n_flex n_align_center order-button active-order" type="DESC" order="1">
          <span class="text_bold">
            <i class="fa fa-angle-down" aria-hidden="true"></i>
            Descendente
          </span>
        </button>
      </div>
      <div class="n_flex n_grow_up relative_element reports">
        <ul id="contenedor-reportes" class="list_panel scroll_y relative_element n_flex n_justify_start process-list n_align_start">
          <img src="<?=URL?>/Public/Img/ReporteInicial/NoReports.png" class="img_noReports" draggable="false"/>
        </ul>
      </div>
      <div class="n_flex panel-contenido report_pagination">
        <ul class="paginador n_flex n_justify_center" id="ul_paginador">

        </ul>
      </div>
    </div>
  </div>

  <!-- Panel de descanso -->
  <div id="panel_descanso" class="n_flex n_flex_col100 md_flex_col60 lg_flex_co70 xl_flex_col70  vertical_padding horizontal_padding col-panel col-inactive active-panel">
    <div class="panel n_flex n_in_columns n_justify_center n_align_center panel-break">
      <img src="<?=URL?>Public/Img/ReporteInicial/notification.png" class="vertical_padding" draggable="false"/>
      <h4>Seleccione una notificación</h4>
      <p>Inicie un chat para registrar un reporte inicial de emergencia.</p>
    </div>
  </div>

  <!-- Registro Reporte Inicial -->
  <div class="hidden_panel n_flex n_flex_col100 md_flex_col50 lg_flex_col40 vertical_padding horizontal_padding col-panel col-registro">

    <!-- Formuario de registro reporte inicial -->
    <div class="panel n_flex n_in_columns p-reporte">
      <div class="panel-cabecera">
        <h3 class="text-center">Registrar reporte</h3>
      </div>
      <div class="panel-contenido scroll_y panel-form">
        <!-- REGISTRO REPORTE -->
        <form id="formReporteInicial" class="n_flex">
          <div class="frmCont">
            <label class="label-section">Punto de referencia</label>
            <div class="frmInput block">
              <input class="input_data txtDatosReporte txtPuntoReferencia" type="text" name="txtPuntoReferencia" placeholder="Punto de referencia...">
            </div>
          </div>

          <div class="n_flex n_in_columns inline-input block">
            <label class="label-section">DIRECCIÓN<span>*</span></label>
            <div class="n_flex dir-group">
              <div class="frmCont block">
                <select id="txtSelectNomenclatura" class="input_data txtDatosReporte" onchange="printAddress()" name="txtSelectNomenclatura" data-rule-RE_Select="0">
                  <option value="0">Nomenclatura</option>
                  <option value="Calle">Calle</option>
                  <option value="Carrera">Carrera</option>
                  <option value="Avenida">Avenida</option>
                  <option value="Autopista">Autopista</option>
                  <option value="Transversal">Transversal</option>
                  <option value="Diagonal">Diagonal</option>
                </select>
              </div>
              <div class="frmCont">
                <div class="frmInput">
                  <input id="txtNumeroDir" class="input_data txtDatosReporte" onchange="printAddress()" type="text" data name="txtNumeroDir" data-rule-required="true" placeholder="Eje: 10 A">
                </div>
              </div>
              <div class="frmCont">
                <div class="frmInput">
                  <input id="txtNum-Ciudad" class="input_data txtDatosReporte" onchange="printAddress()" type="text" name="txtNum-Ciudad" data-rule-required="true" placeholder="Eje: 15 - 25 (Ciudad - Barrio...)">
                </div>
              </div>
              <div class="frmCont hidden">
                <div class="frmInput">
                  <input id="txtDireccion" class="input_data txtDatosReporte" type="text" name="txtDireccion" placeholder="Direccion..." readonly>
                </div>
              </div>
            </div>
          </div>

          <div class="n_flex block inline-input">
            <div class="n_flex n_in_columns medium-input">
              <!-- Tipos de eventos -->
              <label class="label-section">Evento <span>*</span></label>
              <select type="select" class="selectpicker input_data" multiple data-actions-box="true" name="slcTipoEvento" id="slcTipoEvento">
                <?php foreach ($this->listaTipoEvento as $tipoEvento)
                {
                  ?>
                  <option value="<?=$tipoEvento->idTipoEvento?>"><?=$tipoEvento->descripcionTipoEvento?></option>
                  <?php
                }
                ?>
              </select>
            </div>

            <div class="n_flex n_in_columns medium-input">
              <!-- Entes externos -->
              <label class="label-section">Entidad<span>*</span></label>
              <select type="select" class="selectpicker input_data form" multiple data-actions-box="true" name="slcEnteExterno" id="slcEnteExterno">
                <?php foreach ($this->listaEnteExterno as $enteExterno)
                {
                  $selected = strtolower($enteExterno->descripcionEnteExterno) == "ambulancia" ? 'selected="true"':'';
                  ?>
                  <option <?=$selected?> value="<?=$enteExterno->idEnteExterno?>">
                    <?=$enteExterno->descripcionEnteExterno?>
                  </option>
                  <?php
                }
                ?>
              </select>
            </div>
          </div>
          <div class="n_flex inline-input block nl-hapx">
            <div class="frmCont medium-input">
              <label class="label-section">Lesionados <span>*</span></label>
              <div class="frmInput">
                <input data-rule-RE_Numbers="true" data-rule-required="true" class="input_data txtDatosReporte" type="text" name="txtNumeroLesionados" placeholder="Eje 22...">
              </div>
            </div>
            <div class="frmCont medium-input">
              <label class="label-section">Hora <span> *</span></label>
              <div class="frmInput">
                <input id="txtHoraAproximada" class="input_data txtDatosReporte" data-rule-required="true" data-rule-RE_hours="true" type="text" name="txtHoraAproximada" placeholder="Eje: 18:40:00 AM">
              </div>
            </div>
          </div>
          <div class="frmCont contDescripcion">
            <label class="label-section">Información de emergencia <span>*</span></label>
            <div class="frmInput block">
              <textarea class="input_data txtDatosReporte" name="txtDescripcion" rows="3" data-rule-required="true" placeholder="Descripcion..."></textarea>
            </div>
          </div>
        </form>
        <!-- REGISTRO NOVEDADES -->
        <form id="formNovedad" class="hidden n_flex n_in_columns">
          <div class="frmCont">
            <label class="label-section">Nuevos lesionados <span>*</span></label>
            <div class="frmInput">
              <input id="txtLesionadosNovedad" data-rule-RE_Numbers="true" data-rule-required="true" class="input_data txtDatosNovedad" type="text" name="txtLesionadosNovedad" placeholder="Eje: 3...">
            </div>
          </div>
          <div class="frmCont">
            <label class="label-section">Novedades de reporte <span>*</span></label>
            <div class="frmInput block">
              <textarea id="txtNovedad" disabled="disabled" class="input_data txtDatosNovedad" name="txtNovedad" rows="3" data-rule-required="true" placeholder="Descripcion de la novedad..."></textarea>
            </div>
          </div>
        </form>
      </div>
      <!-- Botones del formulario -->
      <div id="gButtonReporte" class="group-button n_flex">
        <button type="button" id="btnCancelarReporte" class="btn btn-cancelar form-button" name="button">CANCELAR</button>
        <button type="submit" id="btnRegistrarReporte" class="btn btn-registrar form-button" name="button">REGISTRAR</button>
      </div>
      <!-- Botones del formulario novedad -->
      <div id="gButtonNovedad" class="group-button n_flex hidden">
        <button type="button" id="btnFinalizarReporte" class="btn btn-eliminar form-button" name="button">FINALIZAR</button>
        <button type="submit" id="btnRegistrarNovedad" class="btn btn-registrar form-button" name="button">REGISTRAR</button>
      </div>
    </div>
  </div>

  <!-- Chat reporte inicial -->
  <div class="hidden_panel n_flex n_flex_col100 md_flex_col50 lg_flex_col30 vertical_padding horizontal_padding col-panel col-chat">
    <div class="panel n_flex panel-chat">

      <!-- Cabecera chat -->
      <div class="chat-header n_flex">
        <img id="img_usuario" src="" class="chat-user-img" draggable="false"/>
        <p id="nombre_usuario" class="bold">Santiago agudelo </p>
        <button type="button" class="button-user-inf" title="Perfil">
          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
        </button>
      </div>

      <!-- Contenido del chat -->
      <div class="chat-content">
        <div class="chat-history">
          <ul id="chat_history">

          </ul>
        </div>
      </div>

      <!-- Escribir mensaje y llamar -->
      <div class="chat-message n_flex">
        <div class="send-msg n_flex">
          <!-- Boton llamar -->
          <button type="button" class="button-call n_grow_up"><i class="fa fa-phone" aria-hidden="true"></i></button>
          <!-- Mensaje -->
          <input id="txtChat" type="text" class="n_grow_up" placeholder="Máximo 200 caracteres por mensaje">
          <!-- Boton enviar mensaje -->
          <button id="btnSendMessage" type="button" class="button-send n_grow_up">
            <i class="fa fa-paper-plane" aria-hidden="true"></i>
          </button>
        </div>
      </div>

    </div>

    <!-- Informacion de usuario -->
    <div id="informacion_usuario" class="panel panel-inf-user n_flex">

      <div class="inf-control n_flex n_justify_between">
        <button type="button" class="button-user-inf" title="Atras">
          <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
        </button>
        <p>PERFIL</p>
        <div>
        </div>
      </div>

      <div class="inf-cabecera n_flex n_in_columns">
        <img class="url_foto" src="" draggable="false"/>
      </div>

      <div class="inf-contenido n_flex n_in_columns panel-contenido">
        <h6 class="bold text-center">INFORMACIÓN PERSONAL</h6>
        <div class="datos n_flex">
          <p>Nombre</p>
          <p class="nombre bold"></p>
        </div>
        <div class="datos n_flex">
          <p>Correo</p>
          <p class="correoelectronico bold"></p>
        </div>
        <div class="datos n_flex">
          <p>Telefono</p>
          <p class="telefono bold"></p>
        </div>
        <div class="datos n_flex">
          <p>Dirección</p>
          <p class="direccion bold"></p>
        </div>
        <!-- <div class="datos n_flex">
        <p>Reportes realizados</p>
        <p class="reportesRealizados bold"></p>
      </div> -->
      <div class="datos n_flex">
        <p>Reportes finalizados</p>
        <p class="reportesfinalizados bold"></p>
      </div>
      <!-- <div class="datos n_flex">
      <p>Reportes cancelados</p>
      <p class="reportesCancelados bold"></p>
    </div> -->
  </div>

</div>

</div>

<!-- Submenu movil -->
<div class="n_flex movil-nav">
  <span class="button-border text-menu">
    MENÚ
  </span>
  <!-- Boton DESCANSO -->
  <button class="movil-button button-border button-break" type="DESCANSO" title="Notificacion">
    <i class="fa fa-flag-o" aria-hidden="true"></i>
  </button>
  <!-- Boton REGISTRAR REPORTE -->
  <button class="movil-button button-border" type="REGISTRO" title="Registrar reporte">
    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
  </button>
  <!-- Boton CHAT -->
  <button class="movil-button button-border" type="CHAT" title="Chat">
    <i class="fa fa-comments-o" aria-hidden="true"></i>
  </button>
  <!-- Boton REPORTES EN PROCESO -->
  <button class="movil-button button-process" type="PROCESO" title="Reportes en proceso">
    <i class="fa fa-spinner" aria-hidden="true"></i>
  </button>
</div>

</div>

<!-- MENÚ DE NOTIFICACIONES -->
<div class=" menu-notificaciones-flotantes">

  <div class="encabezado-notfy-f">
    <div class="titulo-notificaciones-f">
      <h4>
        Notificaciones
      </h4>
      <span class="cerrarMenuNF fa fa-times" id="MostrarMenuN"></span>
    </div>
  </div>

  <ul id="cont-notificaciones-f" class="cont-notificaciones-f n_flex n_in_columns">
    <li class="no_notifications n_flex n_grow_up n_justify_center n_align_center n_in_columns">
      <img src="<?=URL?>/Public/Img/ReporteInicial/NoNotify.png" class="img_noReports" draggable="false"/>
      <h6 class="text_bold">No hay ninguna notificación hasta el momento</h6>
    </li>
  </ul>

</div>
