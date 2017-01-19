<?php
if ( Sesion::varExist('esModoConsulta') )
$isQueryMode = ( boolval( Sesion::getValue('esModoConsulta') ) ? true : false);
?>

<div ng-controller="CtrlTratamientoB" ng-init="ListarTipoTratamiento()">
  <style media="screen">
  .lbl_autorizacion{
    background: #18B9E3 !important;
    color: #fff !important;
  }
  </style>
  <!--SOLICITUD DE AUTORIZACION-->
  <div class="" id="cuadro_autorizacion"></div>

  <!--FLECHA DERECHA-->
  <a ng-click="GuardarTratamientoBasico();ValidarSeleccionCampo()" title="Siguiente" class="flecha-der">
    <li class="fa fa-long-arrow-right"></li>
  </a>


  <!--FLECHA IZQUIERDA-->
  <a ng-click="GuardarTratamientoBasico()" href="<?=URL?>ReporteAPH/CtrlLocalizacionLesiones" title="Volver" class="flecha-izq">

    <li class="fa fa-long-arrow-left"></li>
  </a>


  <!-- CONTENIDO -->
  <div class="n_flex n_justify_center margin-top">

    <!-- CONTENIDO VISTA -->
    <div class="n_flex n_flex_col95 sm_flex_col90">

      <!-- TITULO VISTA -->
      <h1 class="titulo_vista">
        <span class="fa fa-stethoscope"></span>
        Tratamiento Básico
      </h1>

      <!-- Esto es ahora una fila, de ser necesario pueden cambiar el div por un form -->
      <div class="n_flex n_flex_col100 n_justify_between" id="" method="post">
        <!-- CONTENIDO VISTA -->
        <div class="columna-hd--10 columna--10 columna-tablet--10 columna-movil--10">

          <!--LISTADO AUTORIZACION-->
          <div class="columna-hd--10 columna--10 columna-tablet--10 columna-movil--10">

            <div class="contenido">
              <div class="contenedor-notificaciones n_flex n_justify_end">
                <button type="button" target="modal1" class="btn-modal btn btn-consultar tooltip btn-modal" style="right: 22px;
                margin-bottom: 16px;" id="btnConsultarAutorizacion" >
                <span class="flotante-file fa fa-list" id="flotante-file"></span>
                <span class="tooltiptext">Listar Solicitudes</span>
              </button>

              <!-- 'id' debe ser igual a 'target' -->
              <div class="modal-ventana whole_wrapper" id="modal1">
                <div class="modal relative_element">

                  <div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between">
                    <!-- Titulo de la ventana modal -->
                    <h2>Solicitudes de Autorización</h2>
                    <span class="btn-cerrar-modal modal-cerrar fa fa-times"></span>
                  </div>

                  <div class="modal-body">
                    <!-- Contenido de la ventana modal -->
                    <div class="n_flex n_flex_col100 n_justify_around horizontal_padding">
                    <div class="panel block">
                      <div class="panel-contenido contPanel">
                        <div class="n_flex_col100">
                             <div class="tbl_container">
                          <table class="tbl_scroll" >
                            <thead>
                              <tr>
                                <th>Tipo Tratamiento</th>
                                <th >Descripcion</th>
                                <th>Observación Respuesta</th>
                                <th>Estado Autorización</th>
                              </tr>
                            </thead>
                            <tbody id="listarTratamientoB">

                            </tbody>
                          </table>
                        </div><!--container-->
                        </div>
                        <!--finTabla-->
                      </div>
                    </div>
                  </div><!--nuevo-->
                  </div>

                  <div class="modal-footer n_flex n_justify_end">
                    <button type="button" class="btn-cerrar-modal btn btn-cancelar"  name="button">Salir</button>
                  </div>

                </div>
              </div>


            </div>
          </div>


        </div>
        <!-- Esto es una columna -->
        <div class="n_flex n_flex_col100 horizontal_padding n_justify_around">
          <div class="panel block max-contenido">
            <div class="panel-cabecera" style="justify-content: flex-start;">
              <h3>Tipos de Tratamientos</h3>
            </div>

            <div class="panel-contenido">
              <!-- contenido del panel -->

              <div class="n_flex n_justify_around">

                <div class="n_flex n_flex_col100 sm_flex_col100 lg_flex_col35 block ">
                  <div class="content-solid height-fijo whole_wrapper">
                    <p class="block05 subTitulo">Tratamiento tipo A:</p>


                    <div class="cont-Pupila" style="margin-top:20px;height:231px !important;overflow-y:auto;height:auto">
                      <div class="cont-checbox" ng-repeat="tratamientoBA in tratamientoTipoA | filter:BuscarTratamientoBA">
                        <div class="tituloPupila">
                          <span>{{tratamientoBA.Descripcion}}:</span>
                        </div>
                        <div class="checkbox">

                          <input type="text" ng-disabled="<?= $isQueryMode ?>" value="{{tratamientoBA.Descripcion}}" style="display:none" name="name" id="id_check_{{tratamientoBA.idTipoTratamiento}}">
                          <input ng-disabled="<?= $isQueryMode ?>" id="AutorizacionTratamientoBA{{tratamientoBA.idTipoTratamiento}}" type="checkbox" name="ckboxPupilaNormal">
                          <?php if (!$isQueryMode) { ?>
                            <label id="id_lbl_{{tratamientoBA.idTipoTratamiento}}" for="AutorizacionTratamientoBA{{tratamientoBA.idTipoTratamiento}}" class="lbl_autorizacion" ng-click='abrirModalAutorizacion(tratamientoBA.idTipoTratamiento,tratamientoBA.Descripcion)'><i class="fa fa-paper-plane" aria-hidden="true"></i></label>
                            <?php } ?>
                            <input ng-disabled="<?= $isQueryMode ?>" class="checkTratamiento{{tratamientoBA.idTipoTratamiento}}" id="tratamientoBA{{tratamientoBA.idTipoTratamiento}}" type="checkbox" name="ckboxTratamientoA" checklist-model="tratamientoBasico.idTipoTratamiento" ng-click="GuardarTratamiento();abrirModalAutorizacion1(tratamientoBA.idTipoTratamiento,tratamientoBA.Descripcion)" checklist-value="tratamientoBA.idTipoTratamiento">
                            <label for="tratamientoBA{{tratamientoBA.idTipoTratamiento}}" class="lblC{{tratamientoBA.idTipoTratamiento}}"><i class="fa fa-check" aria-hidden="true"></i></label>
                          </div>
                        </div>

                      </div>


                    </div>
                  </div>

                  <div class="n_flex n_flex_col100 sm_flex_col100 lg_flex_col30 block">
                    <div class="content-solid height-fijo whole_wrapper">
                      <p class="block05 subTitulo">Tratamiento tipo B:</p>


                      <div class="cont-Pupila" style="margin-top:20px;height:231px !important;overflow-y:auto;height:auto">

                        <div class="cont-checbox" ng-repeat="tratamientoE in tratamientoEspecial | filter:BuscarTratamientoE">
                          <div class="tituloPupila">
                            <span>{{tratamientoE.Descripcion}}:</span>
                          </div>
                          <input ng-disabled="<?= $isQueryMode ?>" ng-blur="seleccionarCheck();validarChage();validarNegativo()" type="number" id="descripcionOxigeno" name="name" value="" style="margin-right: 7px;" placeholder="Valor" ng-model="tratamientoBasicoOxigeno.descripcionOxigeno"  ng-blur="GuardarTratamientoOxigeno()"><span style="margin-right: 7px;">Lts/min</span>
                          <div class="checkbox">
                            <input type="text" ng-disabled="<?= $isQueryMode ?>" value="{{tratamientoE.Descripcion}}" style="display:none" name="name" id="id_check_{{tratamientoE.idTipoTratamiento}}">
                            <input ng-disabled="<?= $isQueryMode ?>" id="AutorizacionTratamientoE{{tratamientoE.idTipoTratamiento}}" type="checkbox" name="ckboxPupilaNormal">
                            <?php if (!$isQueryMode) { ?>
                              <label id="id_lbl_{{tratamientoE.idTipoTratamiento}}" for="AutorizacionTratamientoE{{tratamientoE.idTipoTratamiento}}" class="lbl_autorizacion" ng-click='abrirModalAutorizacion(tratamientoE.idTipoTratamiento,tratamientoE.Descripcion)'><i class="fa fa-paper-plane" aria-hidden="true"></i></label>
                              <?php } ?>
                              <input ng-disabled="<?= $isQueryMode ?>" class="checkTratamiento{{tratamientoE.idTipoTratamiento}}" type="checkbox" id="tratamientoEOxigeno" type="checkbox" name="ckboxTratamientoA" checklist-model="tratamientoBasicoOxigeno.idTipoTratamiento" ng-click="GuardarTratamientoOxigeno();limpiarSiNoChecked();abrirModalAutorizacionOxigeno(tratamientoE.idTipoTratamiento,tratamientoE.Descripcion)" ng-change="validarChageCheck()" checklist-value="tratamientoE.idTipoTratamiento">
                              <label for="tratamientoEOxigeno" id="lblTratamientoEOxigeno"><i class="fa fa-check" aria-hidden="true"></i></label>

                            </div>

                          </div>


                          <div class="cont-checbox" ng-repeat="tratamientoBB in tratamientoTipoB | filter:BuscarTratamientoE">
                            <div class="tituloPupila">
                              <span>{{tratamientoBB.Descripcion}}:</span>
                            </div>
                            <div class="checkbox">

                              <input type="text" ng-disabled="<?= $isQueryMode ?>" value="{{tratamientoBB.Descripcion}}" style="display:none" name="name" id="id_check_{{tratamientoBB.idTipoTratamiento}}">
                              <input ng-disabled="<?= $isQueryMode ?>" id="AutorizacionTratamientoBB{{tratamientoBB.idTipoTratamiento}}" type="checkbox" name="ckboxPupilaNormal">
                              <?php if (!$isQueryMode) { ?>
                                <label id="id_lbl_{{tratamientoBB.idTipoTratamiento}}" for="AutorizacionTratamientoBB{{tratamientoBB.idTipoTratamiento}}" class="lbl_autorizacion" ng-click='abrirModalAutorizacion(tratamientoBB.idTipoTratamiento,tratamientoBB.Descripcion)'><i class="fa fa-paper-plane" aria-hidden="true"></i></label>
                                <?php } ?>
                                <input ng-disabled="<?= $isQueryMode ?>" class="checkTratamiento{{tratamientoBB.idTipoTratamiento}}" id="tratamientoBB{{tratamientoBB.idTipoTratamiento}}" type="checkbox" name="ckboxTratamientoA" checklist-model="tratamientoBasico.idTipoTratamiento" ng-click="GuardarTratamiento();abrirModalAutorizacion1(tratamientoBB.idTipoTratamiento,tratamientoBB.Descripcion)" checklist-value="tratamientoBB.idTipoTratamiento">
                                <label for="tratamientoBB{{tratamientoBB.idTipoTratamiento}}"><i class="fa fa-check" aria-hidden="true"></i></label>
                              </div>
                            </div>

                          </div>

                        </div>
                      </div>

                      <div class="n_flex n_flex_col100 sm_flex_col100 lg_flex_col30 block">
                        <div class="content-solid height-fijo whole_wrapper">
                          <p class="block05 subTitulo">Tratamiento tipo C:</p>

                          <div class="cont-Pupila" style="margin-top:20px;height:230px !important;overflow-y:auto;height:auto">
                            <div class="cont-checbox" ng-repeat="tratamientoBC in tratamientoTipoC | filter:BuscarTratamientoC">
                              <div class="tituloPupila">
                                <span>{{tratamientoBC.Descripcion}}:</span>
                              </div>
                              <div class="checkbox">

                                <input type="text" ng-disabled="<?= $isQueryMode ?>" value="{{tratamientoBC.Descripcion}}" style="display:none" name="name" id="id_check_{{tratamientoBC.idTipoTratamiento}}">
                                <input ng-disabled="<?= $isQueryMode ?>" id="AutorizacionTratamientoBC{{tratamientoBC.idTipoTratamiento}}" type="checkbox" name="ckboxPupilaNormal">
                                <?php if (!$isQueryMode) { ?>
                                  <label id="id_lbl_{{tratamientoBC.idTipoTratamiento}}" for="AutorizacionTratamientoBC{{tratamientoBC.idTipoTratamiento}}" class="lbl_autorizacion" ng-click='abrirModalAutorizacion(tratamientoBC.idTipoTratamiento,tratamientoBC.Descripcion)'><i class="fa fa-paper-plane" aria-hidden="true"></i></label>
                                  <?php } ?>
                                  <input ng-disabled="<?= $isQueryMode ?>" class="checkTratamiento{{tratamientoBC.idTipoTratamiento}}" id="tratamientoBC{{tratamientoBC.idTipoTratamiento}}" type="checkbox" name="ckboxTratamientoA" checklist-model="tratamientoBasico.idTipoTratamiento" ng-click="GuardarTratamiento();abrirModalAutorizacion1(tratamientoBC.idTipoTratamiento,tratamientoBC.Descripcion)" checklist-value="tratamientoBC.idTipoTratamiento">
                                  <label for="tratamientoBC{{tratamientoBC.idTipoTratamiento}}"><i class="fa fa-check" aria-hidden="true"></i></label>
                                </div>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="n_flex n_flex_col100 sm_flex_col100 lg_flex_col30 block">
                          <div class="content-solid height-fijo whole_wrapper">
                            <p class="block05 subTitulo">Tratamiento tipo D:</p>


                            <div class="cont-Pupila" style="margin-top:20px;height:200px !important;overflow-y:auto;height:auto">
                              <div class="cont-checbox" ng-repeat="tratamientoBD in tratamientoTipoD | filter:BuscarTratamientoD">
                                <div class="tituloPupila">
                                  <span>{{tratamientoBD.Descripcion}}:</span>
                                </div>
                                <div class="checkbox">

                                  <input type="text" ng-disabled="<?= $isQueryMode ?>" value="{{tratamientoBD.Descripcion}}" style="display:none" name="name" id="id_check_{{tratamientoBD.idTipoTratamiento}}">
                                  <input ng-disabled="<?= $isQueryMode ?>" id="AutorizacionTratamientoBD{{tratamientoBD.idTipoTratamiento}}" type="checkbox" name="ckboxPupilaNormal">
                                  <?php if (!$isQueryMode) { ?>
                                    <label id="id_lbl_{{tratamientoBD.idTipoTratamiento}}" for="AutorizacionTratamientoBD{{tratamientoBD.idTipoTratamiento}}" class="lbl_autorizacion" ng-click='abrirModalAutorizacion(tratamientoBD.idTipoTratamiento,tratamientoBD.Descripcion)'><i class="fa fa-paper-plane" aria-hidden="true"></i></label>
                                    <?php } ?>
                                    <input ng-disabled="<?= $isQueryMode ?>" class="checkTratamiento{{tratamientoBD.idTipoTratamiento}}" id="tratamientoBD{{tratamientoBD.idTipoTratamiento}}" type="checkbox" name="ckboxTratamientoA" checklist-model="tratamientoBasico.idTipoTratamiento" ng-click="GuardarTratamiento();abrirModalAutorizacion1(tratamientoBD.idTipoTratamiento,tratamientoBD.Descripcion)" checklist-value="tratamientoBD.idTipoTratamiento">
                                    <label for="tratamientoBD{{tratamientoBD.idTipoTratamiento}}"><i class="fa fa-check" aria-hidden="true"></i></label>
                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>
                          <div class="n_flex n_flex_col100 sm_flex_col100 lg_flex_col30 block">
                            <div class="content-solid height-fijo whole_wrapper">
                              <p class="block05 subTitulo">Tratamiento tipo OTRO:</p>


                              <div class="cont-Pupila" style="margin-top:20px;height:200px !important;overflow-y:auto;height:auto">
                                <div class="cont-checbox" ng-repeat="tratamientoBO in tratamientoTipoO | filter:BuscarTratamientoO">
                                  <div class="tituloPupila">
                                    <span>{{tratamientoBO.Descripcion}}:</span>
                                  </div>
                                  <div class="checkbox">
                                    <input type="text" ng-disabled="<?= $isQueryMode ?>" value="{{tratamientoBO.Descripcion}}" style="display:none" name="name" id="id_check_{{tratamientoBO.idTipoTratamiento}}">
                                    <input ng-disabled="<?= $isQueryMode ?>" id="AutorizacionTratamientoBO{{tratamientoBO.idTipoTratamiento}}" type="checkbox" name="ckboxPupilaNormal">
                                    <?php if (!$isQueryMode) { ?>
                                      <label id="id_lbl_{{tratamientoBO.idTipoTratamiento}}" for="AutorizacionTratamientoBO{{tratamientoBO.idTipoTratamiento}}" class="lbl_autorizacion" ng-click='abrirModalAutorizacion(tratamientoBO.idTipoTratamiento,tratamientoBO.Descripcion)'><i class="fa fa-paper-plane" aria-hidden="true"></i></label>
                                      <?php } ?>
                                      <input ng-disabled="<?= $isQueryMode ?>" class="checkTratamiento{{tratamientoBO.idTipoTratamiento}}" id="tratamientoBO{{tratamientoBO.idTipoTratamiento}}" type="checkbox" name="ckboxTratamientoA" checklist-model="tratamientoBasico.idTipoTratamiento" ng-click="GuardarTratamiento();abrirModalAutorizacion1(tratamientoBO.idTipoTratamiento,tratamientoBO.Descripcion)" checklist-value="tratamientoBO.idTipoTratamiento">
                                      <label for="tratamientoBO{{tratamientoBO.idTipoTratamiento}}"><i class="fa fa-check" aria-hidden="true"></i></label>
                                    </div>
                                  </div>
                                </div>

                              </div>
                            </div>
                            <div class="n_flex n_flex_col100 sm_flex_col100 lg_flex_col35 block">
                              <div class="content-solid height-fijo whole_wrapper">
                                <p class="block05 subTitulo">Descripcion:</p>
                                <div class="frmCont">

                                  <div class="frmInput">
                                    <textarea class="input_data bloquear" name="txtTextarea" rows="9" cols="10" data-rule-required="true" ng-model="tratamientoBasico.observacionTratamiento"  ng-blur="GuardarDescripcion()" ></textarea>
                                  </div>
                                </div>
                              </div>
                            </div>

                          </div>



                        </div>




                      </div>

                    </div> <!-- Fin .panel -->
                  </div>

                </div>

              </div>
            </div> <!-- FIN CONTENIDO VISTA -->
