<?php
if ( Sesion::varExist('esModoConsulta') )
$isQueryMode = ( boolval( Sesion::getValue('esModoConsulta') ) ? true : false);
?>

<div ng-controller="CtrlMotivoConsulta" ng-init="ListadoMotivo()">

  <!--FLECHA DERECHA-->
  <a  title="Siguiente" class="flecha-der" ng-click="GuardarUrgencias();ValidarAccidenteTransito()">
    <li class="fa fa-long-arrow-right"></li>
  </a>

  <!--FLECHA IZQUIERDA-->
  <a href="<?=URL?>ReporteAPH/CtrlTipoEvento" title="Volver" class="flecha-izq" ng-click="GuardarUrgencias()">
    <li class="fa fa-long-arrow-left"></li>
  </a>

  <!-- CONTENIDO -->
  <div class="n_flex n_justify_center margin-top">

    <!-- CONTENIDO VISTA -->
    <div class="n_flex n_flex_col95 sm_flex_col90">

      <!-- TITULO VISTA 1-->
      <div class="n_flex n_flex_col100">
        <h2 class="titulo_vista"><span class="fa fa-user-md"></span>Motivo Consulta</h2>
      </div>

      <!-- MOTIVO CONSULTA -->
      <div class="n_flex n_flex_col100 n_justify_around">

        <!-- CONTENEDOR PRINCIPAL IZQUIERDO -->
        <div class="n_flex n_flex_col100 lg_flex_col50 horizontal_padding n_in_columns">
          <!-- urgencia medica-->
          <div class="panel block max-contenido" style="max-height: 71vh;">
            <div class="panel-cabecera">
              <h3>Urgencia Médica</h3>
            </div>
            <div class="panel-contenido no-pad-lados">
              <div class="radio rdo item-rdo-flex solid-top">
                <!-- Inicio input -->
                <div class="frmCont cont_input_buscar" style="width:100%;margin-bottom: 0px;margin-top:0px">

                  <div class="frmInput">
                    <input type="text" class="input_buscar"  name="campo1" placeholder="Buscar" ng-model="BuscarUrgenciaMedica" style="">

                  </div>
                </div>
              </div>
              <div class="cont_radios_separado ">
                <div class="rdo radio item-rdo-flex solid-bottom solid-top" for="{{urgencia.id}}" ng-repeat="urgencia in UrgenciaMedica | filter:BuscarUrgenciaMedica">
                  <span><span class="fa fa-bookmark"></span> {{urgencia.descripcionMotivoConsulta}}</span>
                  <input ng-disabled="<?= $isQueryMode ?>" id="{{urgencia.idMotivoConsulta}}" type="checkbox" name="checkMotivoConsulta"   tipo="Urgencia Medica" value="{{urgencia.idMotivoConsulta}}"    checklist-model="Urgencias" checklist-value="urgencia.idMotivoConsulta" >
                  <label for="{{urgencia.idMotivoConsulta}}" class="rdo-redondo"></label>
                </div>

              </div>
            </div>
          </div>
          <!--fin urgencia medica -->
        </div>

        <!-- CONTENEDOR PRINCIPAL DERECHO -->
        <div class="n_flex n_flex_col100 lg_flex_col50 block horizontal_padding n_in_columns">
          <!-- urgencia medica-->
          <div class="panel block">
            <div class="panel-cabecera">
              <h3>Urgencia Traumática</h3>

            </div>
            <div class="panel-contenido no-pad-lados">
              <div class="radio rdo item-rdo-flex solid-top">
                <!-- Inicio input -->
                <div class="frmCont cont_input_buscar" style="width:100%;margin-bottom: 0px;margin-top:0px">

                  <div class="frmInput">
                    <input type="text" class="input_buscar"  name="campo1" placeholder="Buscar" ng-model="BuscarTraumatica" style="">

                  </div>
                </div>
              </div>
              <div class="cont_radios_separado ">
                <div class="rdo radio item-rdo-flex solid-bottom solid-top" ng-repeat="traumatica in UrgenciaTraumatica | filter:BuscarTraumatica">
                  <span><span class="fa fa-bookmark"></span> {{traumatica.descripcionMotivoConsulta}}</span>
                  <input ng-disabled="<?= $isQueryMode ?>" id="{{traumatica.idMotivoConsulta}}" type="checkbox" name="checkMotivoConsulta" tipo="Urgencia Traumática" tipo="Urgencia Traumática"   checklist-model="Urgencias" checklist-value="traumatica.idMotivoConsulta">
                  <label for="{{traumatica.idMotivoConsulta}}" class="rdo-redondo"></label>
                </div>


              </div>
            </div>
          </div>
          <!--fin urgencia medica -->
        </div>

      </div>
      <br><br>

      <!-- TITULO VISTA 2-->
      <div class="n_flex n_flex_col100">
        <h2 class="titulo_vista"><span class="fa fa-car"></span>Aseguramiento</h2>
      </div>

      <!-- ASEGURAMIENTO -->
      <div class="n_flex n_flex_col100 n_justify_around">



        <!-- CONTENEDOR PRINCIPAL DERECHO -->
        <div class="n_flex n_flex_col100 lg_flex_col50 block horizontal_padding n_in_columns">
          <!-- urgencia medica-->
          <div class="panel block" ng-init="ListarAfectado()">
            <div class="panel-cabecera">
              <h3>En Caso de Accidente de Tránsito</h3>
            </div>
            <div class="panel-contenido no-pad-lados" >
              <div class="acc_transito ">

                <div class="rdo radio item-rdo-flex solid-bottom solid-top" ng-repeat="afectado in AfectadoAccidente">
                  <span><span class="fa fa-bookmark"></span> {{afectado.descripcionAfectadoAccidenteTransito}}</span>
                  <input ng-disabled="<?= $isQueryMode ?>" id="accidente{{afectado.idAfectadoAccidenteTransito}}" type="radio" name="accidenteTransito" ng-model="Afectado.id" ng-change="ChageValidacion();" ng-click="GuardarAfectado()" ng-value="afectado.idAfectadoAccidenteTransito">
                  <label for="accidente{{afectado.idAfectadoAccidenteTransito}}" class="rdo-redondo validacion"></label>
                </div>

              </div>
              <div class="n_flex">
                <!-- 100% a partir de 0px, 50% a partir de tablet: -->
                <div class="n_flex_col100 md_flex_col50">
                  <div class="rdo item-rdo-flex solid-bottom">
                    <div class="frmCont cont_input_buscar" style="width:100%;margin-bottom: 0px;margin-top:0px">
                      <label for="txtCaracteresLatinos">Placa del Vehiculo</label>
                      <div class="frmInput txtPlaca" class="">
                        <input type="text" id="txtPlaca" ng-blur="ValidarChange();GuardarAfectado();" class="input_buscar bloquear" ng-model="Afectado.placa" ng-blur="GuardarAfectadoAccidente()"  name="txtPlaca">
                      </div>
                    </div>
                  </div>
                </div>

                <!-- 100% a partir de 0px, 50% a partir de tablet: -->
                <div class="n_flex_col100 md_flex_col50">
                  <div class="rdo item-rdo-flex solid-bottom">
                    <div class="frmCont cont_input_buscar" style="width:100%;margin-bottom: 0px;margin-top:0px">
                      <label for="txtCaracteresLatinos">Código Aseguradora</label>
                      <div class="frmInput txtCodigoAseguradora">
                        <input type="text" id="txtCodigoAseguradora" ng-blur="ValidarChange();GuardarAfectado();" class="input_buscar bloquear" ng-model="Afectado.codigoAseguradora" ng-blur="GuardarAfectadoAccidente()"  name="txtCodigoAseguradora">
                      </div>
                    </div>
                  </div>
                </div>
              </div>




              <div class="rdo item-rdo-flex solid-bottom">
                <div class="frmCont cont_input_buscar" style="width:100%;margin-bottom: 0px;margin-top:0px">
                  <label for="txtCaracteresLatinos">Número de poliza</label>
                  <div class="frmInput txtNumeroPoliza">
                    <input type="text" id="txtNumeroPoliza" ng-blur="ValidarChange();GuardarAfectado();" class="input_buscar bloquear" ng-model="Afectado.numeroPoliza" ng-blur="GuardarAfectadoAccidente()"  name="txtPoliza">
                  </div>
                </div>
              </div>
              <div class="" style="padding: 10px">
                <?php if (!$isQueryMode): ?>
                  <button type="button" style="width:100%" ng-click="cancelarTransito()" class="btn btn-cancelar" name="button">Cancelar</button>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <!--fin urgencia medica -->
        </div>

        <!-- CONTENEDOR PRINCIPAL IZQUIERDO -->
        <div class="n_flex n_flex_col100 lg_flex_col50 block horizontal_padding n_in_columns" ng-init="ListadoTipoAseguramiento()">
          <!-- urgencia medica-->
          <div class="panel block">
            <div class="panel-cabecera">
              <h3>Tipo Aseguramiento</h3>
            </div>
            <div class="panel-contenido no-pad-lados">
              <div class="radio rdo item-rdo-flex solid-top cont_input_buscar1">
                <!-- Inicio input -->
                <div class="frmCont cont_input_buscar" style="width:100%;margin-bottom: 0px;margin-top:0px">

                  <div class="frmInput">
                    <input type="text" class="input_buscar"  name="campo1" placeholder="Buscar" ng-model="BuscarAseguramiento" style="">

                  </div>
                </div>
              </div>

            </div>
            <div class="cont_radios_separado " style="max-height: 55.5vh;
            ">
            <div class="rdo radio item-rdo-flex solid-bottom solid-top motivoConsultaRadio" ng-repeat="aseguramiento in TipoAseguramiento | filter:BuscarAseguramiento">
              <span><span class="fa fa-bookmark"></span> {{aseguramiento.DescripcionTipoAseguramiento}}</span>
              <input ng-disabled="<?= $isQueryMode ?>" id="aseguramiento{{aseguramiento.idTipoAseguramiento}}"  type="radio" name="tipoaSeguramiento" class="checkValid" ng-model="Aseguramiento.id" ng-click="GuardarTipoAseguramiento()" ng-value="aseguramiento.idTipoAseguramiento">
              <label for="aseguramiento{{aseguramiento.idTipoAseguramiento}}" class="rdo-redondo tipoAseguramientoCheck"></label>
            </div>

          </div>
          <div class="radio rdo item-rdo-flex solid-bottom motivoConsultaRadio inputMotivoConsultaRadio" id="contenedor_descripcion_aseguramiento">
            <!-- Inicio input -->
            <div class="frmCont cont_input_buscar" style="width:100%;margin-bottom: 0px;margin-top:0px">

              <div class="frmInput">
                <input type="text" class="input_buscar bloquear tipoAseguramientoCheck" ng-model="Aseguramiento.otroAseguramiento"  ng-blur="ValidarSeleccionAseguramiento()" name="txtOtroAccidente" id="txtOtroAccidente" placeholder="¿Otro?,Especifique!">

              </div>
            </div>
          </div>
        </div>
      </div>
      <!--fin urgencia medica -->
    </div>
  </div>

</div>
</div> <!-- FIN CONTENIDO VISTA -->
</div> <!-- FIN CONTENIDO -->
