<?php
if ( Sesion::varExist('esModoConsulta') )
$isQueryMode = ( boolval( Sesion::getValue('esModoConsulta') ) ? true : false);
?>

<div  ng-controller="CtrlTipoEvento" >


  <!-- FLECHA DERECHA -->
  <a   title="Siguiente" class="flecha-der" ng-click="GuadarTipoEvento()">
    <li class="fa fa-long-arrow-right"></li>
  </a>


  <!-- FLECHA IZQUIERDA -->
  <a href="<?=URL?>ReporteAPH/ctrlInformacionGeneral" title="Volver" class="flecha-izq">
    <li class="fa fa-long-arrow-left"></li>
  </a>


  <!-- CONTENIDO -->
  <div class="n_flex n_justify_center margin-top" >

    <!-- CONTENIDO VISTA -->
    <div class="n_flex n_flex_col95 sm_flex_col90">

      <!-- TITULO VISTA -->
      <h1 class="titulo_vista">
        <span class="fa fa-edit"></span>
        Tipo de evento
      </h1>


      <div class="n_flex n_flex_col100 n_justify_between">

        <!-- TIPO DE EVENTO-->
        <div class="n_flex n_flex_col100 xs_flex_col100 sm_flex_col100 md_flex_col100 lg_flex_col40 xl_flex_col35 xxl_flex_col40 vertical_padding horizontal_padding n_justify_around" >
          <div class="panel ">
            <div class="panel-cabecera">
              <h3>Tipo de evento</h3>
            </div>

            <div class="panel-contenido ajustarPanel " id="PanelTipoEventos">

              <div class="n_flex n_justify_between">
                <!-- Inicio input -->
                <div class="frmCont cont_input_buscar" style="width:100%;">
                  <div class="frmInput">
                    <input type="text" class="input_buscar"  name="campo1" placeholder="Buscar Tipo Evento" ng-model="BuscarTipoevento" style="">
                  </div>
                </div>
                <!-- Columna 1 -->
                <div class="n_flex_col100 horizontal_padding lg_flex_col100" ng-repeat="uno in ListadoTipoEvento | filter:BuscarTipoevento">

                  <div class="cont-tipoEvento" >
                    <div class="titulo-tipoEvento">
                      <p>{{uno.descripcionTipoEvento}}</p>
                    </div>
                    <div class="checkbox">
                      <input id="{{uno.idTipoEvento}}" ng-disabled="<?= $isQueryMode ?>" type="checkbox" ng-click="quitarBordeTipoEvento()"  checklist-model="TipoEvento" checklist-value="uno.idTipoEvento" >
                      <label for="{{uno.idTipoEvento}}" class="labelCheckTipo">Si</label>
                    </div>
                  </div>


                </div>
              </div>

            </div>

          </div> <!-- Fin .panel -->
        </div>
        <!--Triage-->
        <div class="n_flex n_flex_col100 xs_flex_col100 sm_flex_col100 md_flex_col45 lg_flex_col30 xl_flex_col30 xxl_flex_col30 vertical_padding horizontal_padding n_justify_around" id="ContenedorTriage">
          <div class="panel ">
            <div class="panel-cabecera">
              <h3>Clasificación Triage</h3>

            </div>
            <div class="panel-contenido ajustarPanel" >
              <!-- Inicio input -->
              <div class="frmCont cont_input_buscar" style="width:100%;margin-bottom: 0px;margin-top:0px">
                <div class="frmInput">
                  <input type="text" class="input_buscar"  name="campo1" placeholder="Buscar Triage" ng-model="BuscarTriage" style="">
                </div>
              </div>
              <div class="rdo radio item-rdo-flex solid-bottom solid-top ajustarRd" for="rdRojo" ng-repeat="triage in ListaTriaje | filter:BuscarTriage">

                <span><span class="fa fa-bookmark"></span>{{triage.descripcionTriage}}</span>
                <input id="rd{{triage.descripcionTriage}}" ng-disabled="<?= $isQueryMode ?>" type="radio" name="checkTriage" tipo="Triage" value="{{triage.descripcionTriage}}"  ng-click="GuardarTriage(triage.idTriage)" ng-checked="Checktriage(triage.idTriage)">
                <label for="rd{{triage.descripcionTriage}}" class="rdo-redondo checkTriageID"></label>
              </div>

            </div>
          </div>
        </div>
        <div class="n_flex n_flex_col100 xs_flex_col100 sm_flex_col100 md_flex_col45 lg_flex_col30 xl_flex_col30 xxl_flex_col30 vertical_padding horizontal_padding n_justify_around" id="ContenedorTriage">
          <div class="panel ">
            <div class="panel-cabecera">
              <h3>Cuidados Antes del Arribo</h3>
            </div>
            <div class="panel-contenido ajustarPanel" >
              <!-- Inicio input -->
              <div class="frmCont cont_input_buscar" style="width:100%;margin-bottom: 0px;margin-top:0px">
                <div class="frmInput">
                  <input type="text" class="input_buscar"  name="campo1" placeholder="Buscar Cuidados" ng-model="BuscarCuidados" style="">
                </div>
              </div>
              <div class="rdo radio item-rdo-flex solid-bottom solid-top ajustarRd" for="rdRojo" ng-repeat="cui in ListaCuidados | filter:BuscarCuidados">

                <span><span class="fa fa-bookmark"></span>{{cui}}</span>
                <input id="rd{{cui}}" ng-disabled="<?= $isQueryMode ?> "  type="checkbox" class="checkCuidadosInput" name="checkcui" ng-click="quitarBordeCuidados()" checklist-model="Cuidados" checklist-value="cui">
                <label for="rd{{cui}}" class="rdo-redondo checkCuidados"></label>
              </div>
              <div class="rdo radio item-rdo-flex solid-bottom solid-top ajustarRd" for="rdRojo">
                <span><span class="fa fa-bookmark"></span>Ninguno</span>
                <input id="rd{{Ninguno}}" ng-disabled="<?= $isQueryMode ?>" type="checkbox" class="checkCuidadosNInput" ng-click="quitarBordeCuidadosNinguno()" checklist-model="Cuidados" checklist-value="'Ninguno'">
                <label for="rd{{Ninguno}}" class="rdo-redondo checkCuidadosN"></label>
              </div>

            </div>
          </div>
        </div>
        <!-- PACIENTE -->
        <!-- Panel paciente-->

        <div class="n_flex n_flex_col100 xs_flex_col100 sm_flex_col100 md_flex_col60 lg_flex_col60 xl_flex_col60 xxl_flex_col60 vertical_padding horizontal_padding n_justify_around" id="camposPaciente">

          <div class="panel ">
            <div class="panel-cabecera">
              <h3>Paciente</h3>
            </div>
            <div class="panel-contenido " id="contPaciente">
              <!-- PACIENTE -->
              <form id="formPaciente" method="POST">
                <!-- <form class="" id="frmPaciente" method="post">-->
                <input type="hidden" name="txtIdPaciente" id="txtIdPaciente">

                <!-- inicio input -->
                <div class="columna--10">
                  <div class="contenido ajustar">
                    <div class="frmCont" id="ocultarDocumento">
                      <label  for="txtIdentificacionPaciente">Número Documento<span id="rojo">*</span>:</label>
                      <div class="frmInput">
                        <input type="text" autocomplete="off" data-rule-RE_number_letters="true" data-rule-required="true"  data-rule-maxlength="45" class="input_data"  id="txtNumeroDocumento" name="txtIdentificacionPaciente">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- fin input -->
                <!-- Inicio input -->
                <div class="columna--10">
                  <div class="contenido ajustar">
                    <div class="frmCont">
                      <label for="txtPrimerNombrePaciente">Primer Nombre<span id="rojo">*</span></label>
                      <div class="frmInput">
                        <input type="text" autocomplete="off"  data-rule-required=
                        "true" data-rule-RE_LatinCharacters="true" data-rule-maxlength="45" class="input_data"  name="txtPrimerNombrePaciente" id="primerNombrePa">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- fin input -->


                <!-- Inicio input -->
                <div class="columna--10">
                  <div class="contenido ajustar">
                    <div class="frmCont">
                      <label for="txtSegundoNombrePaciente">Segundo Nombre</label>
                      <div class="frmInput">
                        <input type="text" autocomplete="off" data-rule-RE_LatinCharacters="true" data-rule-maxlength="45" class="input_data" name="txtSegundoNombrePaciente" id="segundoNombrePa">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- fin input -->


                <!-- Inicio input -->
                <div class="columna--10">
                  <div class="contenido ajustar">
                    <div class="frmCont">
                      <label for="txtPrimerApellidoPaciente">Primer Apellido<span id="rojo">*</span></label>
                      <div class="frmInput">
                        <input type="text"  data-rule-required=
                        "true" data-rule-RE_LatinCharacters="true" data-rule-maxlength="45" class="input_data"  name="txtPrimerApellidoPaciente" id="primerApellidoPa" autocomplete="off">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- fin input -->


                <!-- Inicio input -->
                <div class="columna--10">
                  <div class="contenido ajustar">
                    <div class="frmCont">
                      <label for="txtSegundoApellidoPaciente" >Segundo Apellido:</label>
                      <div class="frmInput">
                        <input type="text" data-rule-RE_LatinCharacters="true" data-rule-maxlength="45" class="input_data" name="txtSegundoApellidoPaciente" id="segundoApellidoPa" autocomplete="off">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- fin input -->




                <!-- Inicio select -->
                <div class="columna--10">
                  <div class="contenido ajustar">
                    <div class="frmCont">
                      <label for="opTipoDocumento12">Tipo Documento<span id="rojo">*</span></label>
                      <div class="frmInput">
                        <select  type="text" RE_Select="0" name="opTipoDocumento12" id="opTipoDocumento">
                          <option value="0">Seleccione una opcion</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- fin select -->

  <!-- inicio select -->
                <div class="columna--10">
                  <div class="contenido ajustar">
                    <div class="frmCont">
                      <label for="opGenero">Género<span id="rojo">*</span></label>
                      <div class="frmInput">
                        <select   type="text" RE_Select="0"  name="opGenero" id="generoPac">
                          <option value="0">Seleccione Género</option>
                          <option>Masculino</option>
                          <option>Femenino</option>
                          <option>Otro</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- fin  select -->

                <div class="columna--10">
                  <div class="contenido ajustar">
                    <div class="frmCont">
                      <label  for="txtFechaNacimiento">Fecha Nacimiento</label>
                      <div class="frmInput">
                        <input type="text" autocomplete="off"  class="input_data"  id="fechaNacimi"  name="txtFechaNacimiento">
                      </div>
                    </div>
                  </div>
                </div>

                <!-- inicio  input -->
                <div class="columna">
                  <div class="contenido ajustar">
                    <div class="frmCont" id="ocultarEdad">
                      <label for="txtEdad">Edad<span id="rojo">*</span></label>
                      <div class="frmInput">
                        <input type="number" data-rule-maxlength="10"  data-rule-RE_Numbers="true" class="input_data"  id="edadP"  name="txtEdad">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- fin  input -->


                <div class="columna--10">
                  <div class="contenido ajustar">
                    <div class="frmCont">
                      <label  for="txtMunicipioPaciente">Municipio<span id="rojo">*</span></label>
                      <div class="frmInput">
                        <input type="text"  data-rule-required=
                        "true" data-rule-RE_LatinCharacters="true" data-rule-maxlength="45" class="input_data" name="txtMunicipioPaciente"  id="municipioPacien" autocomplete="off">
                      </div>
                    </div>
                  </div>
                </div>




                <div class="columna--10">
                  <div class="contenido ajustar">
                    <div class="frmCont">
                      <label  for="txtDireccionPaciente">Dirección</label>
                      <div class="frmInput">
                        <input type="text"  class="input_data"  name="txtDireccionPaciente" data-rule-maxlength="45" id="direccionPaciente" autocomplete="off">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="columna--10">
                  <div class="contenido ajustar">
                    <div class="frmCont">
                      <label  for="txtTelefonoMovilPaciente">Télefono</label>
                      <div class="frmInput">
                        <input type="text" data-rule-RE_number_letters="true" class="input_data"  name="txtTelefonoMovilPaciente" data-rule-maxlength="45" id="teleMovilPaciente" autocomplete="off">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="columna--10">
                  <div class="contenido ajustar">
                    <div class="frmCont">
                      <label for="txtEstadoCivil">Estado Cívil</label>
                      <div class="frmInput">
                        <select  type="text" name="txtEstadoCivil" id="estadoCivilPaciente">
                          <option value="0">Seleccione una Opción</option>
                          <option>Soltero(a)</option>
                          <option >Casado(a)</option>
                          <option >Divorciado(a)</option>
                          <option >Viudo(a)</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="columna--10">
                  <div class="contenido ajustar">
                    <div class="frmCont">
                      <label  for="txtOcupacionPaciente">Ocupación</label>
                      <div class="frmInput">
                        <input type="text" data-rule-RE_LatinCharacters="true" class="input_data"  name="txtOcupacionPaciente" data-rule-maxlength="45"  id="ocupacionPacie" autocomplete="off">
                      </div>
                    </div>
                  </div>
                </div>
              </form>
              <!--Botones-->
              <div class="columna--10">
                <div class="contenido n_flex n_justify_end">
                  <div class="left_padding  xxl_flex_col100">
                    <button type="submit" class="btn btn-registrar correrBoton" id="btnRegistrarPaciente" submit-form="formPaciente" name="button">Registrar</button>
                  </div>
                  <!--Boton Editar-->
                  <div class="left_padding n_flex">
                    <button type="button" class="btn btn-consultar correrBoton" id="btnActualizarPaciente" name="actualizarPaciente">Editar</button>
                  </div>
                  <!--FinBoton-->
                  <!--Limpiar-->
                  <div class="left_padding n_flex">
                    <button type="button" class="btn btn-consultar" id="btnLimpiar" name="">Limpiar</button>
                  </div>
                  <!--finLimpiar-->
                  <!--Modificar-->
                  <div class="left_padding n_flex">
                    <button type="submit" class="btn btn-modificar correrBoton" id="btnGuardarDatos" submit-form="formPaciente" guardar="no" name="guardarDatos">Modificar</button>
                  </div>
                  <!--FinModificar-->
                </div>
              </div>
              <!--FinBotones-->
            </div>
          </div>
        </div>



        <!--FinPanelPaciente-->

        <!--Panel acompañante-->
        <div class="n_flex n_flex_col100 xs_flex_col100 sm_flex_col100 md_flex_col40 lg_flex_col40 xl_flex_col40 xxl_flex_col40 vertical_padding horizontal_padding n_justify_around" id="camposAcompanante">
          <div class="panel">
            <div class="panel-cabecera">
              <h3>Acompañante</h3>
            </div>
            <div class="panel-contenido">
              <form id="formAcompanante">
                <input type="hidden" name="txtIdA" id="idAcompanante">

                <!--inicio Input-->

                <div class="columna--10">
                  <div class="contenido">
                    <div class="frmCont" id="ocultarAcompanante">
                      <label for="txtIdentificacionAcomp">Identificación<span id="rojo">*</span></label>
                      <div class="frmInput">
                        <input type="text"  id="ideAcompanante" name="txtIdentificacionAcomp" data-rule-required="true"  data-rule-maxlength="45" autocomplete="off">
                      </div>
                    </div>
                  </div>
                </div>

                <!--Fin Input-->

                <!--inicio Input-->
                <div class="columna--10">
                  <div class="contenido ajustar">
                    <div class="frmCont">
                      <label for="txtLugarExpedicion">Lugar Expedición</label>
                      <div class="frmInput">
                        <input type="text" name="txtLugarExpedicion" data-rule-RE_LatinCharacters="true" class="input_data" id="lugarExpedicion" data-rule-maxlength="45" autocomplete="off">
                      </div>
                    </div>
                  </div>
                </div>
                <!--Fin Input-->

                <!--inicio Input-->
                <div class="columna--10">
                  <div class="contenido ajustar">
                    <div class="frmCont">
                      <label for="txtNombreAcomp">Nombre(s)<span id="rojo">*</span></label>
                      <div  class="frmInput">
                        <input type="text" id="nombreA" name="txtNombreAcomp" data-rule-RE_LatinCharacters="true" class="input_data" data-rule-required="true"  data-rule-maxlength="45" autocomplete="off">
                      </div>
                    </div>
                  </div>
                </div>
                <!--Fin Input-->

                <!--inicio Input-->
                <div class="columna--10">
                  <div class="contenido ajustar">
                    <div class="frmCont">
                      <label for="txtApellidoAcomp">Apellido(s)<span id="rojo">*</span></label>
                      <div class="frmInput">
                        <input type="text" id="apellido" name="txtApellidoAcomp"  data-rule-RE_LatinCharacters="true" class="input_data" data-rule-required="true"  data-rule-maxlength="45" autocomplete="off">
                      </div>
                    </div>
                  </div>
                </div>
                <!--fin Input-->

                <!--inicio Input-->
                <div class="columna--10">
                  <div class="contenido ajustar">
                    <div class="frmCont">
                      <label for="txtParentescoAcomp">Parentesco<span id="rojo">*</span></label>
                      <div class="frmInput">
                        <input type="text" id="parentesco" name="txtParentescoAcomp"  data-rule-RE_LatinCharacters="true" class="input_data" data-rule-required="true"  data-rule-maxlength="45" autocomplete="off">
                      </div>
                    </div>
                  </div>
                </div>
                <!--fin Input-->

                <!--inicio Input-->
                <div class="columna--10">
                  <div class="contenido ajustar">
                    <div class="frmCont">
                      <label for="txtTelefonoAcomp">Télefono</label>
                      <div class="frmInput">
                        <input type="text" autocomplete="off" id="telefono"  name="txtTelefonoAcomp"  data-rule-RE_number_letters="true" class="input_data" data-rule-RE_Numbers="true"  data-rule-maxlength="45">
                      </div>
                    </div>
                  </div>
                </div>
                <!--fin Input-->
              </form>
              <!--Inicio Botones-->
              <div class="columna--10">
                <div class="contenido n_justify_end n_flex">
                  <div class="left_padding xxl_flex_col100">
                    <button type="submit" class="btn btn-registrar correrBoton" id="btnAgregarAcompanante" submit-form="formAcompanante" name="button">Registrar</button>
                  </div>
                  <div class="left_padding n_flex">
                    <button type="button" class="btn btn-consultar correrBoton" id="btnActualizarAcompanante" name="actualizarAcompanante">Editar</button>
                  </div>
                  <!--Limpiar Acompañante-->
                  <div class="left_padding n_flex">
                    <button type="button" class="btn btn-consultar" id="btnLimpiarAC" name="">Limpiar</button>
                  </div>
                  <!--Modificar Acompañante-->
                  <div class="left_padding n_flex">
                    <button type="button" class="btn btn-modificar" id="btnModificarAcompanante" submit-form="formAcompanante" guardarA="Si" name="acompanante">Modificar </button>
                  </div>
                </div>
              </div>
              <!--fin Botones-->
            </div>
          </div>
        </div>
        <!--FinPanelAcompañante-->

      </div>
    </div>
  </div>
</div> <!-- FIN CONTENIDO VISTA -->
