<?php
if ( Sesion::varExist('esModoConsulta') )
$isQueryMode = ( boolval( Sesion::getValue('esModoConsulta') ) ? true : false);
?>
<div ng-controller="CtrlTratamientoA" ng-init="ListarTipoTratamiento();">
  <style media="screen">
  .lbl_autorizacion{
    background: #18B9E3 !important;
    color: #fff !important;
  }
  </style>

  <!--SOLICITUD DE AUTORIZACION-->
  <div class="" id="cuadro_autorizacion"></div>
  <!--FLECHA DERECHA-->
  <a ng-click="GuardarTratamientoAvanzado();ValidarSeleccionCampo()"  title="Siguiente" class="flecha-der">
    <li class="fa fa-long-arrow-right"></li>
  </a>


  <!--FLECHA IZQUIERDA-->
  <a ng-click="GuardarTratamientoAvanzado()" href="<?=URL?>ReporteAPH/ctrltratamientoB" title="Volver" class="flecha-izq">

    <li class="fa fa-long-arrow-left"></li>
  </a>




  <!-- CONTENIDO -->
  <div class="n_flex n_justify_center margin-top">

    <!-- CONTENIDO VISTA -->
    <div class="n_flex n_flex_col95 sm_flex_col90">

      <!-- TITULO VISTA -->
      <h1 class="titulo_vista">
        <span class="fa fa-plus-square"></span>
        Tratamiento Avanzado
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
                              <tbody id="listarTratamientoA">

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
          <div class="panel block">
            <div class="panel-cabecera" style="justify-content: flex-start;">
              <h3>Tipos de Tratamientos</h3>
            </div>

            <div class="panel-contenido">
              <!-- contenido del panel -->

              <div class="n_flex n_justify_around">

                <div class="n_flex n_flex_col100 sm_flex_col100 lg_flex_col45 block ">
                  <div class="content-solid height-fijo whole_wrapper" style="height: 230px">
                    <p class="block05 subTitulo">Tratamientos:</p>


                    <div class="cont-Pupila" style="margin-top:20px;height:150px !important;overflow-y:auto;height:auto">
                      <div class="cont-checbox" ng-repeat="tratamientoAA in tratamientoTipoA | filter:BuscarTratamientoBA">
                        <div class="tituloPupila">
                          <span>{{tratamientoAA.Descripcion}}:</span>
                        </div>
                        <div class="checkbox">
                          <input type="text" ng-disabled="<?= $isQueryMode ?>" value="{{tratamientoAA.Descripcion}}" style="display:none" name="name" id="id_check_{{tratamientoAA.idTipoTratamiento}}">
                          <input id="AutorizacionTratamientoAA{{tratamientoAA.idTipoTratamiento}}" ng-disabled="<?= $isQueryMode ?>" type="checkbox" name="ckboxPupilaNormal">
                          <?php if (!$isQueryMode) { ?>
                            <label id="id_lbl_{{tratamientoAA.idTipoTratamiento}}" for="AutorizacionTratamientoAA{{tratamientoAA.idTipoTratamiento}}" class="lbl_autorizacion" ng-click='abrirModalAutorizacion(tratamientoAA.idTipoTratamiento,tratamientoAA.Descripcion)'><i class="fa fa-paper-plane" aria-hidden="true"></i></label>
                            <?php } ?>
                            <input class="checkTratamiento1{{tratamientoAA.idTipoTratamiento}}" id="tratamientoAA{{tratamientoAA.idTipoTratamiento}}" type="checkbox" ng-disabled="<?= $isQueryMode ?>" name="ckboxTratamientoA" checklist-model="tratamientoAvanzado.idTipoTratamiento" ng-click="GuardarTratamiento();abrirModalAutorizacion1(tratamientoAA.idTipoTratamiento,tratamientoAA.Descripcion)" checklist-value="tratamientoAA.idTipoTratamiento"/>
                            <label for="tratamientoAA{{tratamientoAA.idTipoTratamiento}}"><i class="fa fa-check" aria-hidden="true"></i></label>
                          </div>
                        </div>

                      </div>


                    </div>
                  </div>

                  <div class="n_flex n_flex_col100 sm_flex_col100 lg_flex_col45 block">
                    <div class="content-solid height-fijo whole_wrapper">
                      <p class="block05 subTitulo">Tratamientos:</p>

                      <div class="cont-Pupila" style="margin-top:20px;max-height:200px;overflow-y:auto;height:auto">

                        <div class="cont-checbox" ng-repeat="tratamientoE in tratamientoEspecial | filter:BuscarTratamientoE">
                          <div class="tituloPupila">
                            <span>{{tratamientoE.Descripcion}}:</span>
                          </div>
                          <select class="" ng-disabled="<?= $isQueryMode ?>" convert-to-number id="descripcionDextrosa" class="bloquear" style="margin-right: 7px;" ng-model="tratamientoAvanzadoDextrosa.descripcionDextrosa" ng-blur="GuardarTratamientoDextrosa();validarChage()" name="">
                            <option value="" disabled="" selected="">Seleccionar Dextrosa</option>
                            <option value="1">1</option>
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                          </select>
                          <span style="margin-right: 7px;">%</span>
                          <div class="checkbox">
                            <input type="text" ng-disabled="<?= $isQueryMode ?>" value="{{tratamientoE.Descripcion}}" style="display:none" name="name" id="id_check_{{tratamientoE.idTipoTratamiento}}">
                            <input id="AutorizacionTratamientoE{{tratamientoE.idTipoTratamiento}}" type="checkbox" name="ckboxPupilaNormal">
                            <?php if (!$isQueryMode) { ?>
                              <label id="id_lbl_{{tratamientoE.idTipoTratamiento}}" for="AutorizacionTratamientoE{{tratamientoE.idTipoTratamiento}}" class="lbl_autorizacion" ng-click='abrirModalAutorizacion(tratamientoE.idTipoTratamiento,tratamientoE.Descripcion)'><i class="fa fa-paper-plane" aria-hidden="true"></i></label>
                              <?php } ?>
                              <input ng-disabled="<?= $isQueryMode ?>" class="checkTratamiento1{{tratamientoE.idTipoTratamiento}}" id="tratamientoDextrosa" type="checkbox" name="ckboxTratamientoA" checklist-model="tratamientoAvanzadoDextrosa.idTipoTratamiento" ng-click="GuardarTratamientoDextrosa();limpiarSiNoChecked();validarChageCheck();abrirModalAutorizacionDextrosa(tratamientoE.idTipoTratamiento,tratamientoE.Descripcion);" checklist-value="tratamientoE.idTipoTratamiento">
                              <label for="tratamientoDextrosa" id="lblDextrosa"><i class="fa fa-check" aria-hidden="true"></i></label>

                            </div>

                          </div>


                          <div class="cont-checbox" ng-repeat="tratamientoAB in tratamientoTipoB | filter:BuscarTratamientoE">
                            <div class="tituloPupila">
                              <span>{{tratamientoAB.Descripcion}}:</span>
                            </div>
                            <div class="checkbox">
                              <input type="text" ng-disabled="<?= $isQueryMode ?>"  value="{{tratamientoAB.Descripcion}}" style="display:none" name="name" id="id_check_{{tratamientoAB.idTipoTratamiento}}">
                              <input id="AutorizacionTratamientoAB{{tratamientoAB.idTipoTratamiento}}" type="checkbox" name="ckboxPupilaNormal">
                              <?php if (!$isQueryMode) { ?>
                                <label id="id_lbl_{{tratamientoAB.idTipoTratamiento}}" for="AutorizacionTratamientoAB{{tratamientoAB.idTipoTratamiento}}" class="lbl_autorizacion" ng-click='abrirModalAutorizacion(tratamientoAB.idTipoTratamiento,tratamientoAB.Descripcion)'><i class="fa fa-paper-plane" aria-hidden="true"></i></label>
                                <?php } ?>
                                <input ng-disabled="<?= $isQueryMode ?>" class="checkTratamiento1{{tratamientoAB.idTipoTratamiento}}" id="tratamientoAB{{tratamientoAB.idTipoTratamiento}}" type="checkbox" name="ckboxTratamientoA" checklist-model="tratamientoAvanzado.idTipoTratamiento" ng-click="GuardarTratamiento();abrirModalAutorizacion1(tratamientoAB.idTipoTratamiento,tratamientoAB.Descripcion)" checklist-value="tratamientoAB.idTipoTratamiento">
                                <label for="tratamientoAB{{tratamientoAB.idTipoTratamiento}}"><i class="fa fa-check" aria-hidden="true"></i></label>
                              </div>
                            </div>

                          </div>

                        </div>
                      </div>

                      <div class="n_flex n_flex_col100 sm_flex_col100 lg_flex_col45 block">
                        <div class="content-solid height-fijo whole_wrapper">
                          <p class="block05 subTitulo">Tratamientos:</p>

                          <div class="cont-Pupila" style="margin-top:20px;max-height:200px;overflow-y:auto;height:auto">

                            <div class="cont-checbox" ng-repeat="tratamientoED in tratamientoEspecialDesfibrilacion | filter:BuscarTratamientoE">
                              <div class="tituloPupila">
                                <span>{{tratamientoED.Descripcion}}:</span>
                              </div>

                              <div class="checkbox">
                                <input type="text" ng-disabled="<?= $isQueryMode ?>"  value="{{tratamientoED.Descripcion}}" style="display:none" name="name" id="id_check_{{tratamientoED.idTipoTratamiento}}">
                                <input ng-disabled="<?= $isQueryMode ?>"  id="AutorizacionTratamientoED{{tratamientoED.idTipoTratamiento}}" type="checkbox" name="ckboxPupilaNormal">
                                <?php if (!$isQueryMode) { ?>
                                  <label id="id_lbl_{{tratamientoED.idTipoTratamiento}}" for="AutorizacionTratamientoED{{tratamientoED.idTipoTratamiento}}" class="lbl_autorizacion" ng-click='abrirModalAutorizacion(tratamientoED.idTipoTratamiento,tratamientoED.Descripcion)'><i class="fa fa-paper-plane" aria-hidden="true"></i></label>
                                  <?php } ?>
                                  <input ng-disabled="<?= $isQueryMode ?>"class="checkTratamiento1{{tratamientoED.idTipoTratamiento}}" id="tratamientoDesfibrilacion" type="checkbox" name="ckboxTratamientoADesfibrilacion" checklist-model="tratamientoAvanzado.idTipoTratamiento" checklist-model="tratamientoAvanzado.idTipoTratamiento" ng-click="GuardarTratamiento();abrirModalAutorizacion1(tratamientoED.idTipoTratamiento,tratamientoED.Descripcion)" checklist-value="tratamientoED.idTipoTratamiento">
                                  <label for="tratamientoDesfibrilacion" ng-click="validarChageCheck1()" id="lbldesfibrilacion1"><i class="fa fa-check" aria-hidden="true"></i></label>

                                </div>

                              </div>
                              <form class="" action="index.html" method="post">
                                <input class="bloquear" style="width:42.5%;margin-bottom:5px"type="text" name="name1" id="time1" ng-blur="deseleccionar()" placeholder="Hora" ng-model="tratamientoAvanzadoDesfibrilacion.hora1" ><span style="margin-right: 7px;margin-left: 7px;">Hr</span>
                                <input class="bloquear"  style="width:42%;margin-bottom:5px"type="number" name="name2" id="julios1" placeholder="Julios" ng-model="tratamientoAvanzadoDesfibrilacion.julios1"  min="1" ng-blur="GuardarDesfibrilacion();deseleccionar()" ><span style="margin-right: 7px;margin-left: 7px;">J</span>
                                <input class="bloquear" style="width:42.5%;margin-bottom:5px"type="text" name="name1" id="time2" placeholder="Hora" ng-model="tratamientoAvanzadoDesfibrilacion.hora2" ><span style="margin-right: 7px;margin-left: 7px;">Hr</span>
                                <input class="bloquear"  style="width:42%;margin-bottom:5px"type="number" name="name2" id="julios2" placeholder="Julios" ng-model="tratamientoAvanzadoDesfibrilacion.julios2" min="1"  ng-blur="GuardarDesfibrilacion()" ><span style="margin-right: 7px;margin-left: 7px;">J</span>
                                <input class="bloquear" style="width:42.5%;margin-bottom:5px"type="text" name="name1" id="time3" placeholder="Hora" ng-model="tratamientoAvanzadoDesfibrilacion.hora3" ><span style="margin-right: 7px;margin-left: 7px;">Hr</span>
                                <input class="bloquear"  style="width:42%;margin-bottom:5px"type="number" name="name2" id="julios3" placeholder="Julios" ng-model="tratamientoAvanzadoDesfibrilacion.julios3" min="1"  ng-blur="GuardarDesfibrilacion()" ><span style="margin-right: 7px;margin-left: 7px;">J</span>

                              </form>
                              <div class="cont-checbox" ng-repeat="tratamientoAC in tratamientoTipoC | filter:BuscarTratamientoE">
                                <div class="tituloPupila">
                                  <span>{{tratamientoAC.Descripcion}}:</span>
                                </div>
                                <div class="checkbox">
                                  <input type="text" ng-disabled="<?= $isQueryMode ?>" value="{{tratamientoAC.Descripcion}}" style="display:none" name="name" id="id_check_{{tratamiCentoAC.idTipoTratamiento}}">
                                  <input ng-disabled="<?= $isQueryMode ?>" id="AutorizacionTratamientoAC{{tratamientoAC.idTipoTratamiento}}" type="checkbox" name="ckboxPupilaNormal">
                                  <label id="id_lbl_{{tratamientoAC.idTipoTratamiento}}" for="AutorizacionTratamientoAC{{tratamientoAC.idTipoTratamiento}}" class="lbl_autorizacion" ng-click='abrirModalAutorizacion(tratamientoAC.idTipoTratamiento,tratamientoAC.Descripcion)'><i class="fa fa-paper-plane" aria-hidden="true"></i></label>
                                  <input ng-disabled="<?= $isQueryMode ?>"class="checkTratamiento1="<?= $isQueryMode ?>" id="" id="tratamientoBC{{tratamientoAC.idTipoTratamiento}}" type="checkbox" name="ckboxTratamientoA" checklist-model="tratamientoAvanzado.idTipoTratamiento" checklist-model="tratamientoAvanzado.idTipoTratamiento" ng-click="GuardarTratamiento()" checklist-value="tratamientoAC.idTipoTratamiento">
                                  <label for="tratamientoBC{{tratamientoAC.idTipoTratamiento}}"><i class="fa fa-check" aria-hidden="true"></i></label>
                                </div>
                              </div>

                            </div>

                          </div>
                        </div>
                        <div class="n_flex n_flex_col100 sm_flex_col100 lg_flex_col45 block">
                          <div class="content-solid height-fijo whole_wrapper" style="    height: 230px;">
                            <p class="block05 subTitulo">Observacion:</p>


                            <div class="cont-Pupila" style="margin-top:20px;max-height:200px;overflow-y:auto;height:auto">
                              <div class="frmCont">
                                <div class="frmInput">
                                  <textarea  class="input_data bloquear" name="txtTextarea" rows="5" cols="10" data-rule-required="true" ng-model="tratamientoAvanzado.observacionTratamiento"  ng-blur="GuardarTratamientoAD()" ></textarea>
                                </div>
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
