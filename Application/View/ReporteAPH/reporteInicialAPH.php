<!-- MENÚ DE EMERGENCIA -->

<style media="screen">
#menu_emergencia{
  z-index: 10000;
}
.flecha-der, .flecha-izq {
  z-index: 10000000000000000000000;
}
</style>
<style>
.contenedor-barra-progreso{
  display: none;
}
</style>
<div class="contenedor-principal fila" ng-controller="ctrlReporteInicialAPH "  onload="mueveReloj()">
  <a  href="<?=URL?>ReporteAPH/ctrlInformacionGeneral" title="Siguiente" class="flecha-der FlechaDerechaMapa " ng-click="GuardarAntecedentes()" style="display:none">
    <li class="fa fa-long-arrow-right"></li>
  </a>
  <!--FLECHA IZQUIERDA-->
  <a href="<?=URL?>ReporteAPH/ctrlIndex" title="Volver" class="flecha-izq FlechaDerechaMapa" style="display:none">
    <li class="fa fa-long-arrow-left"></li>
  </a>

  <div class="" id="pintarMapa">
    <div id="map" style="width:60%; height: auto">

    </div>
    <div class="icono-llamada">
      <span class="fa fa-bullhorn"></span>
    </div>
  </div>


  <!-- MENU INFORMACION REPORTES -->
  <div class="" id="menuInfoReportes" ng-init="FuncionConsultarReporteI()">
    <!--MENÚ FLOTANTE NOTIFICACIONES-->

    <div class=" menu-notificaciones-flotantes">
      <div class="encabezado-notfy-f">
        <div class="titulo-notificaciones-f">
          <h4 class="tituloMenuNotificaciones" id="TituloReporteInicial">
            Reporte Inicial
          </h4>
          <h4 class="tituloMenuNotificaciones" id="TituloDespacho" style="display:none">
            Despacho
          </h4>

          <span class="cerrarMenuNF fa fa-reply" id="MostrarMenuN"></span>
        </div>

        <!--<input type="text" name="txtFiltrarNotificacionesE" id="txtFiltrarNotificacionesE" placeholder="Filtrar Notificaciones">-->
        <div class="contenedor-botones">
          <ul>

            <li id="RB_Inicial">Reporte Inicial </li>
            <li id="RB_Despacho">Despacho</li>
          </ul>
        </div>
      </div>

      <div class="cont-notificaciones-f">

        <div class="notificacion-f n-llamada">
          <div class="icon-llamada">
            <span class="fa fa-bullhorn"></span>
          </div>
          <div class="contenido-notifiN">
            <h5 class="li hcinco">EMERGENCIA! </h5>
            <ul class="reporteUl" id="contenidoReporteI" >
              <li class="li"><span class="p">Responsable Reporte Inicial: </span>{{ListaReporteI.responsableReporteInicial}}</li>
              <li class="li"><span class="p">Hora llamada: </span> {{ListaReporteI.horallamada}}</li>
              <li class="li"><span class="p">Hora Envío a despacho: </span> {{ListaReporteI.horaenvio}}</li>
              <li class="li"><span class="p">Número Lesionados: </span>{{ListaReporteI.numeroheridos}}</li>
              <li class="li"><span class="p">Usuario Externo: </span>{{ListaReporteI.usuarioExterno}}</li>
              <li class="li"><span class="p">Número Contacto Usuario: </span>{{ListaReporteI.telefono}}</li>
              <li class="li"><span class="p">Direccion: </span> {{ListaReporteI.direccion}}</li>
              <li class="li"><span class="p">Punto Referencia: </span>{{ListaReporteI.puntoreferencia}}</li>
              <li class="li"><span class="p">Tipo de Evento: </span>{{ListaReporteI.tipoevento}}</li>


              <ul class="list_panel relative_element n_flex n_justify_start block">

                <li class="list_item n_dont_grow n_flex_col100">
                  <div class="list_item_header n_flex n_nowrap">
                    <div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden">
                      <h5 class="text_bold suspensive">Descripción</h5>
                    </div>
                  </div>

                  <div class="list_item_content suspensive_4">
                    <p class="paragraph">
                      {{ListaReporteI.descripcion}}
                    </p>
                  </div>
                </li>

              </ul>


            </ul>

            <ul class="reporteUl" id="contenidoReporteDespacho" style="display:none;">
              <li class="li"><span class="p">Responsable del Despacho:</span> {{ListaDespacho.responsable}}</li>
              <li class="li"><span class="p">Hora Despacho:</span> {{ListaDespacho.fechaDespacho}}</li>
              <li class="li"><span class="p">Ambulancia Número:</span> {{ListaDespacho.codAmbulancia}}</li>
              <li class="li noBorder">
                <span style="margin-bottom:1em;">Personal:</span>
                <ul>
                  <li ng-repeat="(key,nom) in Nombres track by $index">
                    <ul>
                      <li>{{key+1}}.
                      {{nom}}
                    </li>
                    </ul>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>



      </div>
    </div>
  </div><!--menuInfoReportes-->


</div><!--mapa fila-->
