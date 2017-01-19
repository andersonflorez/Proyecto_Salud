<?php
if (Sesion::varExist('esModoConsulta'))
$isQueryMode = (boolval(Sesion::getValue('esModoConsulta')) ? true : false);
?>

<?php if ($isQueryMode): ?>
<style media="screen">
@media screen and (max-width: 1366px) and (min-width: 768px){
  .panel-personal{
    -webkit-flex: 50% 0 0 !important;
    -ms-flex: 50% 0 0 !important;
    flex: 50% 0 0 !important;
  }
}
@media screen and (min-width: 1367px) {
  .panel-personal{
    -webkit-flex: 50% 0 0 !important;
    -ms-flex: 50% 0 0 !important;
    flex: 50% 0 0 !important;
  }
}
</style>
<?php endif; ?>

<div  ng-controller="ctrlResultadosDeAtencion" ng-init="ListarCertificadoAtencion()">

  <!--FLECHA IZQUIERDA-->
  <a href="<?= URL ?>ReporteAPH/CtrlMedicamento" title="Volver" class="flecha-izq" ng-click="GuardarResultadosFinales()" >
    <li class="fa fa-long-arrow-left"></li>
  </a>

  <!-- CONTENIDO -->
  <div class="fila flex-center margin-resultado n_in_columns">
    <div class="main_vista">

      <!-- TITULO VISTA -->
      <h1 class="titulo_vista"><span class="fa fa-flag"></span>Resultados de Atención</h1>

      <!-- CONTENIDO VISTA -->
      <div class="columna-hd--10 columna--10 columna-tablet--10 columna-movil--10">

        <!-- PANEL CONTROL MÉDICO-->
        <div class="columna-hd--5 columna--5 columna-tablet--10 columna-movil--10">
          <div class="contenido">
            <div class="panel" id="panel-control-medico">

              <div class="panel-cabecera">
                <h3>Control Médico <span class="obligatoriosCampos"> *</span></h3>
              </div>
              <div class="panel-contenido no-pad-lados">
                <input type="hidden" name="txtIdReporte" id="idReporte">
                <div class="radio rdo item-rdo-flex sombra">
                  <span> <span class="fa fa-rss"></span> Vía Texto</span>
                  <input class="bloquear " id="radioViaTexto" type="checkbox" checklist-model="ResultadoFinal.controlMedico" checklist-value="'Vía Texto'" name="radioViaComunicacion" value="" ng-click="BorrarClaseCheckViaCcion()">
                  <label for="radioViaTexto" class="rdo-redondo  CheckRojoControlMedico"></label>
                </div>
                <div class="rdo radio item-rdo-flex">
                  <span><span class="fa fa-rss"></span> Vía Radio</span>
                  <input class="bloquear " id="radioViaRadio" type="checkbox" checklist-model="ResultadoFinal.controlMedico" checklist-value="'Vía Radio'" name="radioViaComunicacion" value="" ng-click="BorrarClaseCheckViaCcion()">
                  <label for="radioViaRadio" class="rdo-redondo  CheckRojoControlMedico"></label>
                </div>
                <div class="rdo radio item-rdo-flex sombra">
                  <span><span class="fa fa-rss"></span> Vía Celular</span>
                  <input class="bloquear" id="radioViaCelular" type="checkbox" checklist-model="ResultadoFinal.controlMedico" checklist-value="'Vía Celular'" name="radioViaComunicacion" value="" ng-click="BorrarClaseCheckViaCcion()">
                  <label for="radioViaCelular" class="rdo-redondo CheckRojoControlMedico"></label>
                </div>
                <div class="rdo radio item-rdo-flex sombra">
                  <span><span class="fa fa-rss"></span> Vía Telefónica</span>
                  <input class="bloquear" id="radioViaTelefonica" type="checkbox" checklist-model="ResultadoFinal.controlMedico" checklist-value="'Vía Telefónica'" name="radioViaComunicacion" value="" ng-click="BorrarClaseCheckViaCcion()">
                  <label for="radioViaTelefonica" class="rdo-redondo CheckRojoControlMedico"></label>
                </div>
                <div class="rdo radio item-rdo-flex sombra">
                  <span><span class="fa fa-rss"></span>Aplicativo Web</span>
                  <input class="bloquear" id="radioAplicativoWeb" type="checkbox" checklist-model="ResultadoFinal.controlMedico" checklist-value="'Aplicativo Web'" name="radioViaComunicacion" value="" ng-click="BorrarClaseCheckViaCcion()">
                  <label for="radioAplicativoWeb" class="rdo-redondo CheckRojoControlMedico"></label>
                </div>
                <div class="rdo radio item-rdo-flex sombra">
                  <span><span class="fa fa-rss"></span> Médico Presente</span>
                  <input class="bloquear" id="radioMedicoPresente" type="checkbox" checklist-model="ResultadoFinal.controlMedico" checklist-value="'Médico Presente'" name="radioViaComunicacion" value="" ng-click="BorrarClaseCheckViaCcion()">
                  <label for="radioMedicoPresente" class="rdo-redondo CheckRojoControlMedico"></label>
                </div>
                <div class="rdo radio item-rdo-flex sombra">
                  <span><span class="fa fa-rss"></span> Médico No Disponible</span>
                  <input class="bloquear" id="radioMedicoNoPresente" type="checkbox" name="radioViaComunicacion" checklist-model="ResultadoFinal.controlMedico" checklist-value="'Médico No Disponible'" ng-click="BorrarClaseCheckViaCcion()">
                  <label for="radioMedicoNoPresente" class="rdo-redondo CheckRojoControlMedico"></label>
                </div>
                <label class="subtitulo">
                  Personal Presente
                </label>
                <div class="rdo radio item-rdo-flex sombra">
                  <span><span class="fa fa-user-md"></span> TAPH Presente</span>
                  <input class="bloquear" id="radioTAPH" type="checkbox" ng-click="borrarBordePersonal()" ng-model="ResultadoFinal.TAPHPresente"  ng-true-value="true" ng-false-value="false" >
                  <label for="radioTAPH" class="rdo-redondo CheckRojoPersonalPresente"></label>
                </div>
                <div class="rdo radio item-rdo-flex sombra1">
                  <span><span class="fa fa-user-md"></span> TPAPH Presente</span>
                  <input class="bloquear" id="radioTPAPH" type="checkbox" ng-click="borrarBordePersonal()" ng-model="ResultadoFinal.TPAPHPresente"  ng-true-value="true" ng-false-value="false" >
                  <label for="radioTPAPH" class="rdo-redondo CheckRojoPersonalPresente"></label>
                </div>
                <div class="rdo radio item-rdo-flex sombra1">
                  <span><span class="fa fa-user-md"></span> Otro Personal TPAPH Presente</span>
                  <input class="bloquear" id="radioTPAPHotro" type="checkbox" ng-click="validarCampollenoNombreOtroPersonal()" ng-model="ResultadoFinal.otroPersonalPresente" ng-false-value="false" ng-true-value="true"  >
                  <label for="radioTPAPHotro" class="rdo-redondo CheckotroPersonalPresente"></label>
                </div>
                <label class="subtitulo">
                  Otro personal de salud
                </label>
                <div class="rdo radio item-rdo-flex sombra">
                  <span><span class="fa fa-archive"></span> Protocolo</span>
                  <input class="bloquear" id="radioProtocolo" type="checkbox"  name="radioProtocolo" ng-model="ResultadoFinal.protocolo" ng-true-value="1" ng-false-value="0" ng-ckecked="ResultadoFinal.protocolo = 1">
                  <label for="radioProtocolo" class="rdo-redondo"></label>
                </div>

                <div class="frmCont margin-b" ng-show="ResultadoFinal.otroPersonalPresente == true">
                  <label for="txtNombreOtroPersonal" >Nombre:</label>
                  <div class="frmInput" >
                    <input class="input_data bloquear checkNombreOtroPersonal" ng-blur="quitarBordeOtroPersonal()" type="text" name="txtNombreProtocolo" ng-model="ResultadoFinal.nombreotroPersonal"  id="nombreProtocolo">
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <!-- FIN PANEL CONTROL MÉDICO-->



        <!-- PANEL RESULTADO-->
        <div class="columna-hd--5 columna--5 columna-tablet--10 columna-movil--10">
          <div class="contenido">
            <div class="panel" id="panel-resultado">

              <div class="panel-cabecera">
                <h3>Resultado <span class="obligatoriosCampos"> *</span></h3>
              </div>
              <div class="panel-contenido no-pad-lados">

                <div class="radio rdo item-rdo-flex sombra">
                  <span> <span class="fa fa-list-alt"></span> Paciente niega atención</span>
                  <input class="bloquear" id="radioNiegaAtencion" type="radio" name="radioResultado" ng-model="ResultadoFinal.resultado" value="Paciente niega atención" ng-click="BorrarCheckResultados()">
                  <label for="radioNiegaAtencion" class="rdo-redondo checkResultados"></label>
                </div>
                <div class="rdo radio item-rdo-flex sombra">
                  <span><span class="fa fa-list-alt"></span> Transporte al hospital</span>
                  <input class="bloquear" id="radioTransporteHospital" type="radio" name="radioResultado" ng-model="ResultadoFinal.resultado" value="Transporte al hospital" ng-click="BorrarCheckResultados()">
                  <label for="radioTransporteHospital" class="rdo-redondo checkResultados"></label>
                </div>
                <div class="rdo radio item-rdo-flex ">
                  <span><span class="fa fa-list-alt"></span> Dado Alta en Sitio</span>
                  <input class="bloquear" id="radioDadoAltaSitio" type="radio" name="radioResultado" ng-model="ResultadoFinal.resultado" value="Dado Alta en Sitio" ng-click="BorrarCheckResultados()">
                  <label for="radioDadoAltaSitio" class="rdo-redondo checkResultados"></label>
                </div>
                <div class="rdo radio item-rdo-flex sombra">
                  <span><span class="fa fa-list-alt"></span> Paciente niega transporte</span>
                  <input class="bloquear" id="radioNiegaTransporte" type="radio" name="radioResultado" ng-model="ResultadoFinal.resultado" value="Paciente niega transporte" ng-click="BorrarCheckResultados()">
                  <label for="radioNiegaTransporte" class="rdo-redondo checkResultados"></label>
                </div>
                <div class="rdo radio item-rdo-flex ">
                  <span><span class="fa fa-list-alt"></span> Reconocimiento/Evaluación</span>
                  <input class="bloquear" id="radioReconocimienotEvaluacion" type="radio" name="radioResultado" ng-model="ResultadoFinal.resultado" value="Reconocimiento/Evaluación" ng-click="BorrarCheckResultados()">
                  <label for="radioReconocimienotEvaluacion" class="rdo-redondo checkResultados"></label>
                </div>
                <div class="rdo radio item-rdo-flex sombra">
                  <span><span class="fa fa-list-alt"></span> Reanimación exitosa</span>
                  <input class="bloquear" id="radioReanimacionExitosa" type="radio" name="radioResultado" ng-model="ResultadoFinal.resultado" value="Reanimación exitosa" ng-click="BorrarCheckResultados()">
                  <label for="radioReanimacionExitosa" class="rdo-redondo checkResultados"></label>
                </div>
                <div class="rdo radio item-rdo-flex ">
                  <span><span class="fa fa-list-alt"></span> Muerte durante la atención</span>
                  <input class="bloquear" id="radioMuerteAtencion" type="radio" name="radioResultado" ng-model="ResultadoFinal.resultado" value="Muerte durante la atención" ng-click="BorrarCheckResultados()">
                  <label for="radioMuerteAtencion" class="rdo-redondo checkResultados"></label>
                </div>

                <div class="rdo radio item-rdo-flex sombra">
                  <span><span class="fa fa-list-alt"></span> Hallado cadaver</span>
                  <input class="bloquear" id="radioHalladoCadaver" type="radio" name="radioResultado" ng-model="ResultadoFinal.resultado" value="Hallado cadaver" ng-click="BorrarCheckResultados()">
                  <label for="radioHalladoCadaver" class="rdo-redondo checkResultados"></label>
                </div>


                <div class="frmCont">
                  <label for="txtCaracteresLatinos">Institución receptora:</label>
                  <div class="frmInput">
                    <input class="input_data checkInstitucion" ng-disabled="bloquearNoLlegada" ng-blur="borrarBordeInstitucion()" type="text" name="txtCaracteresLatinos" ng-model="ResultadoFinal.institucion" data-rule-RE_LatinCharacters="true" id="instReceptora">
                  </div>
                </div>
                <div class="frmCont">
                  <label for="txtCaracteresLatinos">Hora Arribo IPS</label>
                  <div class="frmInput">
                    <input class="input_data checkhora" ng-disabled="bloquearNoLlegada" ng-blur="borrarBordehora()" type="text" name="txtCaracteresLatinos" ng-model="ResultadoFinal.arribo" id="horaArriboIPS">
                  </div>
                </div>

              </div>
            </div>
          </div>

          <!--PANEL COMPLICACIONES-->
          <div class="columna-hd--10 columna--10 columna-tablet--10 columna-movil--10">
            <div class="contenido">
              <div class="panel" id="panel-clasiSituacion">

                <div class="panel-cabecera">
                  <h3>Complicaciones</h3>
                </div>
                <div class="frmCont">
                  <div class="frmInput">
                    <textarea class="bloquear" name="txtComplicaciones" id="complicaciones" rows="8" cols="40" ng-model="ResultadoFinal.complicacion"></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- FIN PANEL COMPLICACIONES-->
        </div><!--FIN PANEL COMPLICACIONES-->

        <!-- PANEL ENTREGA-->
        <div class="columna-hd--5 columna--5 columna-tablet--10 columna-movil--10">
          <div class="contenido">
            <div class="panel" id="panel-entrega">

              <div class="panel-cabecera">
                <h3>Entrega <span class="obligatoriosCampos"> *</span></h3>
              </div>
              <div class="panel-contenido no-pad-lados">



                <div class="radio rdo item-rdo-flex sombra">
                  <span> <span class="fa fa-hospital-o"></span> Con signos vitales</span>
                  <input class="bloquear" id="radioConsginosVitales" type="radio" name="radioEntrega" value="Con signos vitales"  ng-model="ResultadoFinal.entregaPaciente" ng-click="BorrarCheckEntregaPaciente()">
                  <label for="radioConsginosVitales" class="rdo-redondo checkEntrega"></label>
                </div>
                <div class="rdo radio item-rdo-flex">
                  <span><span class="fa fa-hospital-o"></span> Sin signos vitales</span>
                  <input class="bloquear" id="radioSinSignosVitales" type="radio" name="radioEntrega" value="Sin signos vitales"  ng-model="ResultadoFinal.entregaPaciente" ng-click="BorrarCheckEntregaPaciente()">
                  <label for="radioSinSignosVitales" class="rdo-redondo checkEntrega"></label>
                </div>
                <div class="rdo radio item-rdo-flex sombra">
                  <span><span class="fa fa-hospital-o"></span> Consciente</span>
                  <input class="bloquear" id="radioConsciente" type="radio" name="radioEntrega" value="Consciente" ng-model="ResultadoFinal.entregaPaciente"  ng-click="BorrarCheckEntregaPaciente()">
                  <label for="radioConsciente" class="rdo-redondo checkEntrega"></label>
                </div>
                <div class="rdo radio item-rdo-flex ">
                  <span><span class="fa fa-hospital-o"></span> Inconsciente</span>
                  <input class="bloquear" id="radioInconsciente" type="radio" name="radioEntrega" value="Inconsciente"  ng-model="ResultadoFinal.entregaPaciente" ng-click="BorrarCheckEntregaPaciente()">
                  <label for="radioInconsciente" class="rdo-redondo checkEntrega"></label>
                </div>




              </div>
            </div>
          </div>
          <div class="columna-hd--10 columna--10 columna-tablet--10 columna-movil--10  ">
            <div class="contenido">
              <div class="panel DiagnosticoFinal" id="panel-clasiSituacion">

                <div class="panel-cabecera">
                  <h3>Diagnóstico final <span class="obligatoriosCampos"> *</span></h3>
                </div>
                <div class="frmCont   " >
                  <label for="txtNombreOtroPersonal">Presión arterial: </label>
                  <div class="frmInput">
                    <input class="input_data bloquear presionArterialCheck" ng-blur="BorrarBordeDiagnosticoPre()" type="text"  name="txtPresionaArterial" id="PresionaArterial" placeholder="Ejemplo: 120/80" ng-model="ResultadoFinal.presionArterial">
                  </div>
                </div>

                <div class="frmCont ">
                  <label for="txtNombreOtroPersonal">Pulso/min: </label>
                  <div class="frmInput">
                    <input class="input_data bloquear pulsoCheck" type="text" ng-blur="BorrarBordeDiagnosticoPul()" name="txtPulso"  id="pulso" placeholder="Ejemplo: 90" ng-model="ResultadoFinal.pulso">
                  </div>
                </div>

                <div class="frmCont paddingBottomResultados">
                  <label for="txtNombreOtroPersonal">Respiración/min: </label>
                  <div class="frmInput">
                    <input class="input_data bloquear respiracionCheck" ng-blur="BorrarBordeDiagnosticoRes()" type="text" name="txtRespiracion" id="respiracion" placeholder="Ejemplo: 18" ng-model="ResultadoFinal.respiracion">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- FIN PANEL ENTREGA-->



        <!--PANEL TESTIGOS-->
        <div class="columna-hd--5 columna--5 columna-tablet--10 columna-movil--10">
          <div class="contenido">
            <div class="panel" id="panel-testigos">

              <div class="panel-cabecera">
                <h3>Testigos</h3>
              </div>
              <div class="panel-contenido">

                <!--TESTIGO 1-->
                <div class="testigo sombra-punteada">
                  <div class="testigo-titulo">
                    <span class="fa fa-user-secret"></span><h4>Testigo N°1</h4>
                  </div>
                  <div class="testigo-contenido">
                    <div class="frmCont ">
                      <label for="txtNombreTestigo1">Nombre:</label>
                      <div class="frmInput">
                        <input class="input_data bloquear" ng-blur="validarExistenciaTestigoUno()" type="text" name="txtNombreTestigo1" id="testigoUno" ng-model="ResultadoFinal.testigoUno.nombre">
                      </div>
                    </div>

                    <div class="frmCont ">
                      <label for="txtCedulaTestigo1">Cédula:</label>
                      <div class="frmInput">
                        <input class="input_data bloquear" ng-blur="validarExistenciaTestigoUno()" type="text" name="txtCedulaTestigo1" id="cedTestigoUno" ng-model="ResultadoFinal.testigoUno.cedula">
                      </div>
                    </div>
                  </div>
                </div>
                <!--FIN TESTIGO1 -->

                <!--TESTIGO 2-->
                <div class="testigo">
                  <div class="testigo-titulo">
                    <span class="fa fa-user-secret"></span><h4>Testigo N°2</h4>
                  </div>
                  <div class="testigo-contenido">
                    <div class="frmCont ">
                      <label for="txtNombreTestigo1">Nombre:</label>
                      <div class="frmInput">
                        <input class="input_data bloquear" type="text" ng-blur="validarExistenciaTestigoDos()" name="txtNombreTestigo2" id="nombreTestigoDos" ng-model="ResultadoFinal.testigoDos.nombre">
                      </div>
                    </div>

                    <div class="frmCont ">
                      <label for="txtCedulaTestigo1">Cédula:</label>
                      <div class="frmInput">
                        <input class="input_data bloquear" type="text" ng-blur="validarExistenciaTestigoDos()" name="txtCedulaTestigo2" id="cedulaTestigoDos" ng-model="ResultadoFinal.testigoDos.cedula">
                      </div>
                    </div>
                  </div>
                </div>
                <!--FIN TESTIGO2-->

              </div>
            </div>
          </div>
        </div>
        <!--FIN PANEL TESTIGOS-->


        <!--PANEL AUTENTIFICACION-->
        <?php if (!$isQueryMode) { ?>
          <div class="columna-hd--6 columna--6 columna-tablet--10 columna-movil--10">
            <div class="contenido">
              <div class="panel" id="panel">
                <div class="panel-cabecera">
                  <h3>Autenticación Personal que Recibe  <span class="obligatoriosCampos"> *</span></h3>
                </div>

                <div class="panel-contenido" >

                  <div class="frmCont autentificacion">
                    <label for="txtUsuarioAutentificacion">Usuario: </label>
                    <div class="frmInput">
                      <input class="input_data  usuarioCheck" ng-disabled="bloquearNoLlegada" ng-blur="BorrarBordeusuario()" ng-model="formulario.usuario" type="text" name="txtUsuarioAutentificacion" id="usuarioMedico">
                    </div>
                  </div>


                  <div class="frmCont autentificacion">
                    <label for="txtClaveAutentificacion">Clave: </label>
                    <div class="frmInput">
                      <input class="input_data  passwordCheck" ng-disabled="bloquearNoLlegada" ng-blur="BorrarBordepass()" ng-model="formulario.pass" type="password" name="txtClaveAutentificacion" id="claveMedico">
                    </div>
                  </div>


                  <div class="botones-autentificacion" id="btn-login">

                    <button type="button" ng-disabled="bloquearNoLlegada" title="Autentificarse" class=" btn btn-consultar" id="btnAutenticar"><span class="fa fa-check"></span></button>
                    <button type="button" ng-disabled="bloquearNoLlegada" target="modalMedico" title="Registrarse" class="btn-modal btn btn-registrar margin-btn-a"><span class="fa fa-user-plus"></button>
                    <!-- <button type="button" ng-disabled="bloquearNoLlegada" title="Limpiar" class="btn btn-consultar" style="margin-right: 2em;" id="btnLimpiarM"><span class="fa fa-minus-circle"></span></button> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
            <!--PANEL FIN AUTENTIFICACION-->

            <!-- PANEL ATENDIDO POR -->
            <?php if ($isQueryMode): ?>
              <div class="columna-hd--4 columna--4 columna-tablet--10 columna-movil--10 panel-personal">
                <div class="contenido">
                  <div class="panel" id="panel" style="height:18em;">

                    <div class="panel-cabecera">
                      <h3>Personal que atiende<span class="obligatoriosCampos"> *</span></h3>
                    </div>
                    <div class="panel-contenido " >
                      <div class="personal-recibe">
                        <div class="personal-titulo">
                          <div class="personal-img">
                            <img id="imagenParamedico" src="" alt="" />
                          </div>
                          <h4>
                            <b>
                              <input type="hidden" name="txtIdPersona" id="idPersona">
                              <input type="text" disabled="true" class="ocultarInput bloquear" id="nombreParamedico" name="txtNombreParamedico">
                              <input type="text" class="ocultarInput bloquear" id="ApellidoParamedico" name="txtApellidoParamedico">
                            </b>
                          </h4>
                        </div>
                      </div>
                      <div class="personal-cuerpo" >
                        <p><b>Documento:</b>
                          <b><input type="text" class="ocultarInput bloquear" id="numeroParamedico"></b></p>
                          <p id="registP"><b>Registro:</b>
                            <img id="frmaParamedico" alt=""></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
                <!-- FIN PANEL ATENDIDO POR-->


                <!--PANEL RECIBIDO POR-->
                <div class="columna-hd--4 columna--4 columna-tablet--10 columna-movil--10 panel-personal">
                  <div class="contenido">
                    <div class="panel" id="panel" style="height:18em;">

                      <div class="panel-cabecera">
                        <h3>Personal que recibe<span class="obligatoriosCampos"> *</span></h3>
                      </div>
                      <div class="panel-contenido " >
                        <div class="personal-recibe">
                          <div class="personal-titulo">
                            <div class="personal-img">
                              <img id="imagenMedico" src="" alt="" />
                            </div>
                            <h4>
                              <b>
                                <input type="hidden" name="txtIdPersona" id="idPersona">
                                <input type="text" class="ocultarInput bloquear" id="nombreMedico" name="txtNombreMedico">
                                <input type="text" class="ocultarInput bloquear" id="ApellidoMedico" name="txtApellidoMedico">
                              </b>
                            </h4>
                          </div>
                        </div>
                        <div class="personal-cuerpo" >
                          <p><b>Documento:</b>
                            <b><input type="text" class="ocultarInput bloquear" id="numeroMedico"></b></p>
                            <p id="registM"><b>Registro:</b>
                              <img id="frmaMedico" alt=""></p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- FIN PANEL RECIBIDO POR-->


                    <!--PANEL CERTIFICADO DE ATENCION-->
                    <div class="columna-hd--10 columna--10 columna-tablet--10 columna-movil--10">
                      <div class="contenido">

                        <div class="panel" id="panel-certificado-atencion">
                          <div class="panel-cabecera">
                            <h3>Certificado de Atención Médica<span class="obligatoriosCampos"> *</span></h3>
                          </div>
                          <div class="panel-contenido" >
                            <div class="certificado-atencion">
                              <p>
                                Aplicación a lo establecido a la resolución 1915 de 2008.
                                Articulo segundo parágrafo Certifico que por los hallazgos
                                clínicos se deduce que la causa de daños sufridos por la
                                persona que encabeza esta epicrisis fue en accidente de:
                              </p>
                            </div>
                            <div class="radios-contenido" >
                              <div class="" ng-repeat="categoria in listadoCertificadoAtencion">
                                <div class="rdo radio item-rdo-flex ">
                                  <span><span class="fa fa-bookmark"></span> {{categoria.descripcionCertificadoAtencion}}</span>
                                  <input ng-disabled="<?= $isQueryMode ?>" id="radio{{categoria.idCertificadoAtencion}}" ng-model="ResultadoFinal.idCertificado" value="{{categoria.idCertificadoAtencion}}" type="radio" name="radioCertificadoAtencion" ng-click="BorrarCertificadoAtencion()">
                                  <label for="radio{{categoria.idCertificadoAtencion}}" class="rdo-redondo CheckCertificadoAtencion"></label>
                                </div>
                              </div>

                            </div>



                            <div class="botones-autentificacion" >
                              <?php if (!$isQueryMode) { ?>
                                <button type="button" title="Guardar Reporte" class=" btn btn-registrar" name="btnGuardarReporte" id="guardarReporte" ng-click="GuardarReporte()" ng-hide="Disabled" >
                                  <span class="fa fa-save"></span>
                                  <span >Guardar Reporte </span>
                                </button>
                                <?php } ?>
                              </div>
                              <div class="fechaYhora-finalizacion">
                                <p>Fecha y Hora de Finalización: <span id="FechaFinish">00/00/000/ 00:00:00</span></p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!--FIN PANEL CERTIFICADO DE ATENCION-->
                      <!--InicioModal-->
                      <div class="modal-ventana whole_wrapper" id="modalMedico">
                        <div class="modal relative_element">

                          <div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between">
                            <h2>Registro Médico</h2>
                            <span class="btn-cerrar-modal modal-cerrar fa fa-times"></span>
                          </div>

                          <form id="frmMedicoRecibe">

                            <div class="modal-body">
                              <div class="panel block">
                                <div class="panel-contenido">

                                  <div class="frmCont">
                                    <span id="">Puede buscar por número de documento ó registrarse.</span><br>
                                    <label for="txtNumero">Numero Documento<span id="rojo">*</span></label>
                                    <div class="frmInput">
                                      <input class="input_data" type="text" name="txtNumeroNumeroDocumento" data-rule-required="true" id="NumeroDocumentoMedico" data-rule-RE_Numbers="true" autocomplete="off">
                                    </div>
                                  </div>

                                  <div class="frmCont">
                                    <label for="txtCaracteres">Nombre<span id="rojo">*</span></label>
                                    <div class="frmInput">
                                      <input class="input_data" type="text" name="txtNombreMedico" id="nombreMedicoR" data-rule-required="true" data-rule-RE_LatinCharacters="true" autocomplete="off">
                                    </div>
                                  </div>

                                  <div class="frmCont">
                                    <label for="txtCaracteres">Apellido<span id="rojo">*</span></label>
                                    <div class="frmInput">
                                      <input class="input_data" type="text" name="txtApellidoMedico" id="apellidoMedico" data-rule-required="true" data-rule-RE_LatinCharacters="true" autocomplete="off">
                                    </div>
                                  </div>

                                  <!-- Inicio select -->


                                  <div class="frmCont">
                                    <label for="opTipoDocumento12">Tipo Documento<span id="rojo">*</span></label>
                                    <div class="frmInput">
                                      <select data-rule-RE_Select="0"  data-rule-required="true" type="text" name="opTipoDocumento" id="opTipoDocumento">
                                        <option value="0">Seleccione una opcion</option>
                                      </select>
                                    </div>
                                  </div>


                                  <!-- fin select -->



                                  <div class="frmCont">
                                    <label for="txtNumero">Correo Electronico<span id="rojo">*</span></label>
                                    <div class="frmInput">
                                      <input class="input_data" type="text" name="txtCorreoMedico" data-rule-required="true" id="correoMedico" data-rule-RE_Email="true" autocomplete="off">
                                    </div>
                                  </div>
                                  <div class="frmCont">
                                    <label for="campo1">Foto</label>
                                    <div class="frmInput">
                                      <div class="input_file">
                                        <input type="text" class="input_data" disabled="disabled" placeholder="Seleccione un archivo" id="limpiarFoto">
                                        <div class="btn_group">
                                          <input type="file" id="cargarFoto" name="imgImagenMedico" data-rule-RE_Image="true" accept="image/*">
                                          <button type="button" class="btn">Subir</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="frmCont">
                                    <label for="campo1">Firma</label>
                                    <div class="frmInput">
                                      <div class="input_file">
                                        <input type="text" class="input_data" disabled="disabled" placeholder="Seleccione un archivo" id="limpiarFirma">
                                        <div class="btn_group">
                                          <input type="file" id="firmaMedico" name="imgFirmaMedico"  data-rule-RE_Image="true" accept="image/*">
                                          <button type="button" class="btn">Subir</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>


                                </div>
                              </div>
                            </div>

                            <div class="modal-footer n_flex n_justify_end">
                              <button type="button" class="btn-cerrar-modal btn btn-cancelar" name="button">Cancelar</button>
                              <button type="submit" class="btn btn-registrar" name="Registrar" id="btnRegistrar">Registrar</button>
                            </div>
                          </form>
                        </div>
                      </div>
                      <!--FinModal-->


                    </div>
                  </div>
                </div>
              </div>
