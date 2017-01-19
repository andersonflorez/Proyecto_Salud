<div ng-controller="ctrlAntecedentesPaciente" >
  <!--FLECHA DERECHA-->
  <a  title="Siguiente" class="flecha-der" ng-click="GuardarAntecedentes('derecha')" >
    <li class="fa fa-long-arrow-right"></li>
  </a>


  <!--FLECHA IZQUIERDA-->
  <a  title="Volver" class="flecha-izq" ng-click="GuardarAntecedentes('izquierda')">
    <li class="fa fa-long-arrow-left"></li>
  </a>


  <!-- CONTENIDO -->
  <div class="n_flex n_justify_center margin-top" >

    <!-- CONTENIDO VISTA -->
    <form  method="POST" id="formAntecedentes" class="n_flex n_flex_col95 sm_flex_col90">

      <!-- TITULO VISTA -->
      <h1 class="titulo_vista">
        <span class="fa fa-heartbeat"></span>
        Antecedentes y Exámen Físico
      </h1>

      <!-- ANTECEDENTES PACIENTE -->
      <div class="n_flex n_flex_col100 n_justify_around horizontal_padding">
        <div class="panel block">
          <div class="panel-cabecera">
            <h3>Antecedentes</h3>
          </div>

          <div class="panel-contenido" id="PanelAntecedentes">
            <div class="n_flex n_justify_between">

              <!-- Antecedentes columna izquierda   -->
              <div class="n_flex n_flex_col100 lg_flex_col50 n_justify_center lg_justify_start ">

                <div class="cont-antecedente" ng-repeat="item in listaDerecha">
                  <div class="tituloAntec suspensive">
                    <span class="numOrden">{{item.nomenclatura}}</span>
                    <p class="suspensive" title="Medicamentos">{{item.descripcion}}</p>
                  </div>

                  <div class="cont-radio">
                    <div class="radio">
                      <input class="bloquear" id="{{item.idTipoAntecedente}}Si" type="radio"   ng-checked="item.si" ng-click="item.si = true;">
                      <label for="{{item.idTipoAntecedente}}Si">Si</label>
                      <input class="bloquear" id="{{item.idTipoAntecedente}}No" type="radio"  ng-checked="!item.si" ng-click="item.si = false;  VaciarInputTrue('derecha',item.idTipoAntecedente)">
                      <label for="{{item.idTipoAntecedente}}No">No</label>
                    </div>
                    <input class="bloquear" type="text" name="txtEspecifique" placeholder="Especifique" ng-clear="item.si == false;" ng-disabled="item.si == false;" ng-model="item.especificacion">
                  </div>
                </div>
              </div>

              <!-- Antecedentes columna derecha -->
              <div class="n_flex n_flex_col100 lg_flex_col50  n_justify_center lg_justify_end">

                <div class="cont-antecedente" ng-repeat="item in listaIzquierda">
                  <div class="tituloAntec suspensive">
                    <span class="numOrden">{{item.nomenclatura}}</span>
                    <p class="suspensive" title="Medicamentos">{{item.descripcion}}</p>
                  </div>

                  <div class="cont-radio">
                    <div class="radio">
                      <input class="bloquear" id="{{item.idTipoAntecedente}}Si" type="radio"   ng-checked="item.si" ng-click="item.si = true; ">
                      <label for="{{item.idTipoAntecedente}}Si">Si</label>
                      <input class="bloquear" id="{{item.idTipoAntecedente}}No" type="radio"  ng-checked="!item.si" ng-click="item.si = false;  VaciarInputTrue('izquierda',item.idTipoAntecedente)">
                      <label for="{{item.idTipoAntecedente}}No">No</label>
                    </div>

                    <input class="bloquear" type="text" name="txtEspecifique" placeholder="Especifique" ng-clear="item.si == false;" ng-disabled="item.si == false;" ng-model="item.especificacion">
                  </div>
                </div>

                <div class="cont-antecedente">
                  <div class="tituloAntec suspensive">
                    <span class="numOrden">4</span>
                    <p class="suspensive" title="Hora Última Ingesta">Fecha-Hora Última Ingesta </p>
                  </div>

                  <div class="cont-radio">
                    <input class="bloquear" type="text" name="txtFechaUltimaIngesta" ng-model="Respiracion.fechaUltimaIngesta"  ng-blur="validarFechasUltimaIngesta()"  placeholder="AA/MM/DD" id="fechaUltimaIngesta">
                    <input class="bloquear" type="text" name="txtHoraUltimaIngesta" ng-model="Respiracion.horaUltimaIngesta" ng-blur="validarFechasUltimaIngesta()"  placeholder="HH:mm:ss" id="horaUltimaIngesta">
                  </div>
                </div>

              </div>

            </div>
          </div>

        </div> <!-- Fin .panel -->
      </div> <!-- fin n_flex_col100 -->

      <!-- EXAMEN FÍSICO -->
      <div class="n_flex n_flex_col100 n_justify_around horizontal_padding">
        <div class="panel block">
          <div class="panel-cabecera">
            <h3>Examen Físico: {{horaExamenFisico}} </h3>
          </div>

          <div class="panel-contenido">
            <div class="n_flex n_justify_around">

              <div class="n_flex n_flex_col100 sm_flex_col45 lg_flex_col20 block ">
                <div class="content-solid height-fijo whole_wrapper">
                  <p class="block05 subTitulo">Respiración:</p>
                  <input class="bloquear" type="text" placeholder="Respiración/min" name="txtRespiracionMin" ng-model="Respiracion.valor">

                  <div class="radio cont-rdo block">
                    <div class="rdo">
                      <span>Presente</span>
                      <input class="bloquear" id="RespiracionPresenteSi" type="radio" name="radioRespiracion"  ng-model="Respiracion.estado" value="Presente">
                      <label for="RespiracionPresenteSi" class="rdo-redondo"></label>
                    </div>

                    <div class="rdo">
                      <span>Ausente</span>
                      <input class="bloquear" id="RespiracionAusenteSi" type="radio" name="radioRespiracion"  ng-model="Respiracion.estado" value="Ausente">
                      <label for="RespiracionAusenteSi" class="rdo-redondo"></label>
                    </div>

                    <div class="rdo">
                      <span>Dificultad</span>
                      <input class="bloquear" id="RespiracionDificultadSi" type="radio" name="radioRespiracion" ng-model="Respiracion.estado" value="Dificultad">
                      <label for="RespiracionDificultadSi" class="rdo-redondo"></label>
                    </div>

                  </div>

                  <input type="text" class="margin-top-1 bloquear" placeholder="SpO2" name="txtRespiracionSpO2" ng-model="Respiracion.spo">

                </div>
              </div>

              <div class="n_flex n_flex_col100 sm_flex_col45 lg_flex_col20 block">
                <div class="content-solid height-fijo whole_wrapper">
                  <p class="block05 subTitulo">Pulso:</p>
                  <input type="text" class="bloquear" placeholder="Pulso/min" name="txtPulsoMin" ng-model="Pulso.valor" >

                  <div class="radio cont-rdo">
                    <div class="rdo">
                      <span>Presente</span>
                      <input class="bloquear" id="PulsoPresenteSi" type="radio" name="radioPulso"  ng-model="Pulso.estado" value="Presente">
                      <label for="PulsoPresenteSi" class="rdo-redondo"></label>
                    </div>

                    <div class="rdo">
                      <span>Ausente</span>
                      <input class="bloquear" id="PulsoAusenteSi" type="radio" name="radioPulso" ng-model="Pulso.estado" value="Ausente">
                      <label for="PulsoAusenteSi" class="rdo-redondo"></label>
                    </div>

                    <div class="rdo">
                      <span>Rítmico</span>
                      <input class="bloquear" id="PulsoRitmicoSi" type="radio" name="radioPulso" ng-model="Pulso.estado" value="Rítmico">
                      <label for="PulsoRitmicoSi" class="rdo-redondo"></label>
                    </div>

                    <div class="rdo">
                      <span>Arrítmico</span>
                      <input class="bloquear" id="PulsoArritmicoSi" type="radio" name="radioPulso" ng-model="Pulso.estado" value="Arrítmico">
                      <label for="PulsoArritmicoSi" class="rdo-redondo"></label>
                    </div>

                    <div class="rdo">
                      <span>Fuerte</span>
                      <input class="bloquear" id="PulsoFuerteSi" type="radio" name="radioPulso" ng-model="Pulso.estado" value="Fuerte">
                      <label for="PulsoFuerteSi" class="rdo-redondo"></label>
                    </div>

                    <div class="rdo">
                      <span>Débil</span>
                      <input class="bloquear" id="PulsoDebilSi" type="radio" name="radioPulso" ng-model="Pulso.estado" value="Débil">
                      <label for="PulsoDebilSi" class="rdo-redondo"></label>
                    </div>

                  </div>
                </div>
              </div>

              <div class="n_flex n_flex_col100 sm_flex_col60 lg_flex_col15 block">
                <div class="content-solid height-fijo whole_wrapper">
                  <div class="cont-presionA block">
                    <p class="color-aguaM block05 subTitulo">Presión Arterial:</p>
                    <input  maxlength="7" type="text" class="presionArterial1 bloquear" name="txtPresionArterial1" ng-model="PresionArterial.sistolica" >
                    <hr class="lineaGlasgow" id="lineaGlasgowPA"></hr>
                    <input maxlength="7" type="text" class="presionArterial2 bloquear" name="txtPresionArterial2" ng-model="PresionArterial.diastolica">
                  </div>
                  <div class="cont-Glucometria ">
                    <p class="block05 subTitulo">Glucometria:</p>
                    <input class="bloquear" type="text" placeholder="mg/dl" name="txtGlucometria" ng-model="PresionArterial.glucometria">
                  </div>
                </div>
              </div>

              <div class="n_flex n_flex_col100 sm_flex_col45 lg_flex_col20 block">
                <div class="content-solid height-fijo whole_wrapper">
                  <div class="radio cont-rdo block">
                    <p class="color-aguaM block05 subTitulo">Conciencia:</p>
                    <div class="rdo">
                      <span>Alerta</span>
                      <input class="bloquear" id="ConcienciaAlertaSi" type="radio" name="radioConciencia" ng-model="Conciencia.estado" value="Alerta">
                      <label for="ConcienciaAlertaSi" class="rdo-redondo"></label>
                    </div>

                    <div class="rdo">
                      <span>Voz</span>
                      <input class="bloquear" id="ConcienciaVozSi" type="radio" name="radioConciencia" ng-model="Conciencia.estado" value="Voz">
                      <label for="ConcienciaVozSi" class="rdo-redondo"></label>
                    </div>

                    <div class="rdo">
                      <span>Dolor</span>
                      <input class="bloquear" id="ConcienciaDolorSi" type="radio" name="radioConciencia" ng-model="Conciencia.estado" value="Dolor">
                      <label for="ConcienciaDolorSi" class="rdo-redondo"></label>
                    </div>

                    <div class="rdo">
                      <span>No responde</span>
                      <input class="bloquear" id="ConcienciaNorespondeSi" type="radio" name="radioConciencia" ng-model="Conciencia.estado" value="No Responde">
                      <label for="ConcienciaNorespondeSi" class="rdo-redondo"></label>
                    </div>

                  </div>

                  <div class="cont-Glucometria">
                    <p class="color-aguaM block05 subTitulo">Glasgow:</p>
                    <div class="cont-presionA">
                      <input   type="number" class="presionArterial1 bloquear"  value="{{Ocular+Verbal+Motor}}" ng-model="Conciencia.glasgow" readonly=”readonly”   id="CalculoGlasgow" name="txtGlasgow1"  max="15" min="0">
                      <hr class="lineaGlasgow"></hr>
                      <input maxlength="7" readonly type="number" class="presionArterial2 bloquear" name="txtGlasgow2" value="15">
                    </div>
                  </div>

                </div>
              </div>

              <div class="n_flex n_flex_col100 sm_flex_col45 lg_flex_col20 block">
                <div class="content-solid height-fijo whole_wrapper">
                  <p class="color-aguaM block subTitulo">Pupilas:</p>
                  <div class="cont-Pupila">
                    <div class="cont-checbox">
                      <div class="tituloPupila">
                        <span>Normal</span>
                      </div>
                      <div class="checkbox">
                        <input class="bloquear" id="checkPupilaNormalD" type="checkbox" name="ckboxPupilaNormal" ng-model="pupilas.derecha"  ng-true-value="'Normal'" ng-false-value="''" >
                        <label for="checkPupilaNormalD">D</label>
                        <input class="bloquear" id="ckboxPupilaNormalI" type="checkbox" name="ckboxPupilaNormalI" ng-model="pupilas.izquierda" ng-true-value="'Normal'" ng-false-value="''" >
                        <label for="ckboxPupilaNormalI">I</label>
                      </div>
                    </div>

                    <div class="cont-checbox">
                      <div class="tituloPupila">
                        <span>Dilatada</span>
                      </div>
                      <div class="checkbox">
                        <input class="bloquear" id="checkPupilaDilatadaD" type="checkbox" name="ckboxPupilaDilatada" ng-model="pupilas.derecha"  ng-true-value="'Dilatada'" ng-false-value="''">
                        <label for="checkPupilaDilatadaD">D</label>
                        <input class="bloquear" id="ckboxPupilaDilatadaI" type="checkbox" name="ckboxPupilaDilatadaI" ng-model="pupilas.izquierda" ng-true-value="'Dilatada'" ng-false-value="''">
                        <label for="ckboxPupilaDilatadaI">I</label>
                      </div>
                    </div>

                    <div class="cont-checbox">
                      <div class="tituloPupila">
                        <span>Contraída</span>
                      </div>
                      <div class="checkbox">
                        <input class="bloquear" id="checkPupilaContraidaD" type="checkbox" name="ckboxPupilaContraida" ng-model="pupilas.derecha"  ng-true-value="'Contraída'">
                        <label for="checkPupilaContraidaD">D</label>
                        <input class="bloquear" id="ckboxPupilaContraidaI" type="checkbox" name="ckboxPupilaContraidaI" ng-model="pupilas.izquierda"  ng-true-value="'Contraída'">
                        <label for="ckboxPupilaContraidaI">I</label>
                      </div>
                    </div>

                    <div class="cont-checbox">
                      <div class="tituloPupila">
                        <span>Reactiva</span>
                      </div>
                      <div class="checkbox">
                        <input class="bloquear" id="checkPupilaReactivaD" type="checkbox" name="ckboxPupilaReactiva" ng-model="pupilas.derecha"  ng-true-value="'Reactiva'">
                        <label for="checkPupilaReactivaD">D</label>
                        <input class="bloquear" id="ckboxPupilaReactivaI" type="checkbox" name="ckboxPupilaReactivaI" ng-model="pupilas.izquierda"  ng-true-value="'Reactiva'">
                        <label for="ckboxPupilaReactivaI">I</label>
                      </div>
                    </div>

                    <div class="cont-checbox">
                      <div class="tituloPupila">
                        <span>No Reactiva</span>
                      </div>
                      <div class="checkbox">
                        <input class="bloquear" id="checkPupilaNoReactivaD" type="checkbox" name="ckboxPupilaNoReactiva" ng-model="pupilas.derecha"  ng-true-value="'No Reactiva'">
                        <label for="checkPupilaNoReactivaD">D</label>
                        <input class="bloquear" id="ckboxPupilaNoReactivaI" type="checkbox" name="ckboxPupilaNoReactivaI" ng-model="pupilas.izquierda"  ng-true-value="'No Reactiva'">
                        <label for="ckboxPupilaNoReactivaI">I</label>
                      </div>
                    </div>

                  </div>

                  <div class="cont-dilatacion">
                    <p class="subTitulo">Grado Dilatación (mm):</p>
                    <input class="bloquear"  type="number" placeholder="Derecha" name="txtGradoDilacionPD" ng-model="pupilas.derechaDilatacion" >
                    <input class="bloquear"  type="number" placeholder="Izquierda" name="txtGradoDilacionPI" ng-model="pupilas.izquierdaDilatacion"  >
                  </div>

                </div>
              </div>

            </div>
          </div>

        </div> <!-- Fin .panel -->
      </div> <!-- fin n_flex_col100 -->

      <!-- TABLA GLASGOW -->
      <div class="n_flex n_flex_col100 n_justify_around horizontal_padding">
        <div class="panel block">
          <div class="panel-contenido">

            <div class="n_flex_col100">
              <div class="tbl_container ">
                <table class="tbl_scroll" >
                  <thead>
                    <tr>
                      <th>Puntaje</th>
                      <th>Ocular</th>
                      <th>Verbal</th>
                      <th>Motor</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr  >
                      <td class="puntajeGlas">1</td>

                      <td class="rdo_tabla" >
                        <input id="OcularNinguna" type="checkbox" name="Ocular" class="rdo_tabla bloquear" ng-model="TablaGlasgow.ocular" ng-true-value="'Ninguna'" ng-false-value="''"   ng-click="CalcularGlasgow(1,'ocular')">
                        <label for="OcularNinguna">Ninguna</label>
                      </td>

                      <td class="rdo_tabla">
                        <input id="VerbalNinguna" type="checkbox" name="Verbal" class="rdo_tabla bloquear" ng-model="TablaGlasgow.verbal" ng-true-value="'Ninguna'" ng-false-value="''" value="Ninguna" ng-click="CalcularGlasgow(1,'verbal')">
                        <label for="VerbalNinguna">Ninguna</label>
                      </td>

                      <td class="rdo_tabla">
                        <input id="MotorNinguna" type="checkbox" name="Motor" class="bloquear" ng-model="TablaGlasgow.motor" ng-true-value="'Ninguna'" ng-false-value="''" value="Ninguna" ng-click="CalcularGlasgow(1,'motor')">
                        <label for="MotorNinguna">Ninguna</label>
                      </td>
                    </tr>

                    <tr>
                      <td class="puntajeGlas">2</td>
                      <td class="rdo_tabla">
                        <input id="OcularDolor" type="checkbox" name="Ocular" class="rdo_tabla bloquear" ng-model="TablaGlasgow.ocular" ng-true-value="'Dolor'" ng-false-value="''" ng-model="TablaGlasgow.ocular" ng-true-value="'Dolor'" ng-false-value="''"   ng-click="CalcularGlasgow(2,'ocular')">
                        <label for="OcularDolor">Dolor</label>
                      </td>

                      <td class="rdo_tabla">
                        <input id="VerbalGemidos" type="checkbox" name="Verbal" class="rdo_tabla bloquear" ng-model="TablaGlasgow.verbal" ng-true-value="'Gemidos'" ng-false-value="''" value="Gemidos" ng-click="CalcularGlasgow(2,'verbal')">
                        <label for="VerbalGemidos">Gemidos</label>
                      </td>
                      <td class="rdo_tabla">
                        <input id="MotorExtension" type="checkbox" name="Motor" class="bloquear" ng-model="TablaGlasgow.motor" ng-true-value="'Extension'" ng-false-value="''"  ng-click="CalcularGlasgow(2,'motor')">
                        <label for="MotorExtension">Extensión</label>
                      </td>
                    </tr>

                    <tr>
                      <td class="puntajeGlas">3</td>
                      <td class="rdo_tabla">
                        <input id="OcularLlamado" type="checkbox" name="Ocular" class="rdo_tabla bloquear" ng-model="TablaGlasgow.ocular" ng-true-value="'Llamado'" ng-false-value="''"   ng-click="CalcularGlasgow(3,'ocular')">
                        <label for="OcularLlamado">Llamado</label>
                      </td>
                      <td class="rdo_tabla">
                        <input id="VerbalInapropiadas" type="checkbox" name="Verbal" class="rdo_tabla bloquear" ng-model="TablaGlasgow.verbal" ng-true-value="'Inapropiadas'" ng-false-value="''" value="Inapropiadas" ng-click="CalcularGlasgow(3,'verbal')">
                        <label for="VerbalInapropiadas">Inapropiadas</label>
                      </td>
                      <td class="rdo_tabla">
                        <input id="MotorFlexion" type="checkbox" name="Motor" class="bloquear" ng-model="TablaGlasgow.motor" ng-true-value="'Flexion'" ng-false-value="''"  ng-click="CalcularGlasgow(3,'motor')">
                        <label for="MotorFlexion">Flexión</label>
                      </td>
                    </tr>
                    <tr>
                      <td class="puntajeGlas">4</td>
                      <td class="rdo_tabla">
                        <input id="OcularEspontanea" type="checkbox" name="Ocular" class="rdo_tabla bloquear" ng-model="TablaGlasgow.ocular" ng-true-value="'Espontanea'" ng-false-value="''"   ng-click="CalcularGlasgow(4,'ocular')">
                        <label for="OcularEspontanea">Espontanea</label>
                      </td>
                      <td class="rdo_tabla">
                        <input id="VerbalDesorientado" type="checkbox" name="Verbal" class="rdo_tabla bloquear" ng-model="TablaGlasgow.verbal" ng-true-value="'Desorientado'" ng-false-value="''" value="Desorientado" ng-click="CalcularGlasgow(4,'verbal')">
                        <label for="VerbalDesorientado">Desorientado</label>
                      </td>
                      <td class="rdo_tabla">
                        <input id="MotorRetirada" type="checkbox" name="Motor" class="bloquear" ng-model="TablaGlasgow.motor" ng-true-value="'Retirada'" ng-false-value="''"  ng-click="CalcularGlasgow(4,'motor')">
                        <label for="MotorRetirada">Retirada</label>
                      </td>
                    </tr>
                    <tr>
                      <td class="puntajeGlas">5</td>
                      <td class="puntajeGlas"></td>
                      <td class="rdo_tabla">
                        <input id="VerbalNormal" type="checkbox" name="Verbal" class="rdo_tabla bloquear" ng-model="TablaGlasgow.verbal" ng-true-value="'Normal'" ng-false-value="''" value="Normal" ng-click="CalcularGlasgow(5,'verbal')">
                        <label for="VerbalNormal">Normal</label>
                      </td>
                      <td class="rdo_tabla">
                        <input id="MotorLocalizacion" type="checkbox" name="Motor" class="bloquear" ng-model="TablaGlasgow.motor" ng-true-value="'Localizacion'" ng-false-value="''"  ng-click="CalcularGlasgow(5,'motor')">
                        <label for="MotorLocalizacion">Localización</label>
                      </td>
                    </tr>
                    <tr>
                      <td class="puntajeGlas">6</td>
                      <td class="puntajeGlas"></td>
                      <td class="puntajeGlas"></td>
                      <td class="rdo_tabla">
                        <input id="MotorObedece" type="checkbox" name="Motor" class="bloquear" ng-model="TablaGlasgow.motor" ng-true-value="'Obedece'" ng-false-value="''"  ng-click="CalcularGlasgow(6,'motor')">
                        <label for="MotorObedece">Obedece</label>


                      </td>
                    </tr>

                    <tr>
                      <td class="puntajeGlas">No Evaluable</td>
                      <td class="rdo_tabla">
                        <input id="OcularNoEvaluable" type="checkbox" name="Ocular" class="rdo_tabla bloquear" ng-model="TablaGlasgow.ocular" ng-true-value="'No Evaluable'" ng-false-value="''"   ng-click="CalcularGlasgow(1,'ocular')">
                        <label for="OcularNoEvaluable">No Evaluable</label>
                      </td>

                      <td class="rdo_tabla">


                        <input id="VerbalNoEvaluable" type="checkbox" name="Verbal" class="rdo_tabla bloquear" ng-model="TablaGlasgow.verbal" ng-true-value="'No Evaluable'" ng-false-value="''" value="NoEvaluable" ng-click="CalcularGlasgow(1,'verbal')">
                        <label for="VerbalNoEvaluable">No Evaluable</label>


                      </td>

                      <td class="rdo_tabla">
                        <input id="MotorNoEvaluable" type="checkbox" name="Motor" class="bloquear" ng-model="TablaGlasgow.motor" ng-true-value="'No Evaluable'" ng-false-value="''"  ng-click="CalcularGlasgow(1,'motor')">
                        <label for="MotorNoEvaluable">No Evaluable</label>
                      </td>
                    </tr>

                    <tr class="noEvaluable">
                      <td class="rdo_tabla">
                        Motivo
                      </td>
                      <td class="rdo_tabla">
                        <input  class="bloquear" id="OcularNoEvaluable" type="text" name="Ocular" placeholder="Digite un motivo" ng-model="TablaGlasgow.descripcionOcular" ng-disabled="disabledOcular">
                      </td>
                      <td class="rdo_tabla">
                        <input  class="bloquear" id="VerbalNoEvaluable" type="text" name="Verbal" placeholder="Digite un motivo" ng-model="TablaGlasgow.descripcionVerbal" ng-disabled="disabledVerbal">
                      </td>
                      <td class="rdo_tabla">
                        <input  class="bloquear" id="MotorNoEvaluable" type="text" name="Motor" placeholder="Digite un motivo" ng-model="TablaGlasgow.descripcionMotor" ng-disabled="disabledMotor">
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div> <!-- Fin .panel -->
      </div> <!-- fin n_flex_col100 -->

      <!-- PIEL Y ESTADO HEMODINÁMICO -->
      <div class="n_flex n_flex_col100 n_justify_between">

        <!-- PIEL -->
        <div class="n_flex n_flex_col100 md_flex_col60 n_justify_around horizontal_padding">
          <div class="panel block">
            <div class="panel-cabecera">
              <h3>Piel</h3>
            </div>
            <div class="panel-contenido">
              <div class="n_flex n_justify_between">

                <div class="n_flex n_flex_col100 sm_flex_col50 horizontal_padding block">
                  <div class="content-solid height-fijo whole_wrapper">

                    <div class="cont_check_rdo">
                      <div class="cont-checbox dashed-top">
                        <div><span>Normal</span>  </div>
                        <div class="checkbox">

                          <input class="bloquear" id="ckboxPielNormal" type="checkbox" name="ckboxPielNormal" value="" checklist-model="Piel" checklist-value="'Normal'"  ng-click="BorrarPiel()">
                          <label for="ckboxPielNormal" class="rdo-redondo checkPielAntecedentes"></label>

                        </div>
                      </div>
                    </div>

                    <div class="cont_check_rdo">
                      <div class="cont-checbox">
                        <div><span>Pálida</span>  </div>
                        <div class="checkbox">

                          <input class="bloquear" id="ckboxPielPalida" type="checkbox" name="ckboxPielPalida" value="" checklist-model="Piel" checklist-value="'Pálida'"  ng-click="BorrarPiel()">
                          <label for="ckboxPielPalida" class="rdo-redondo checkPielAntecedentes"></label>

                        </div>
                      </div>
                    </div>

                    <div class="cont_check_rdo">
                      <div class="cont-checbox">
                        <div><span>Fría</span>  </div>
                        <div class="checkbox">

                          <input class="bloquear" id="ckboxPielFria" type="checkbox" name="ckboxPielFria" value="" checklist-model="Piel" checklist-value="'Fría'" ng-click="BorrarPiel()">
                          <label for="ckboxPielFria" class="rdo-redondo checkPielAntecedentes"></label>

                        </div>
                      </div>
                    </div>

                    <div class="cont_check_rdo">
                      <div class="cont-checbox">
                        <div><span>Caliente</span>  </div>
                        <div class="checkbox">

                          <input class="bloquear" id="ckboxPielCaliente" type="checkbox" name="ckboxPielCaliente" checklist-model="Piel" checklist-value="'Caliente'" ng-click="BorrarPiel()">
                          <label for="ckboxPielCaliente" class="rdo-redondo checkPielAntecedentes"></label>

                        </div>
                      </div>
                    </div>

                    <div class="cont_check_rdo">
                      <div class="cont-checbox">
                        <div><span>Seca</span>  </div>
                        <div class="checkbox">

                          <input class="bloquear" id="ckboxPielSeca" type="checkbox" name="ckboxPielSeca" checklist-model="Piel" checklist-value="'Seca'" ng-click="BorrarPiel()">
                          <label for="ckboxPielSeca" class="rdo-redondo checkPielAntecedentes"></label>

                        </div>
                      </div>
                    </div>

                  </div>
                </div>

                <div class="n_flex n_flex_col100 sm_flex_col50 horizontal_padding block">
                  <div class="content-solid height-fijo whole_wrapper">

                    <div class="cont_check_rdo">
                      <div class="cont-checbox">
                        <div><span>Húmeda</span>  </div>
                        <div class="checkbox">

                          <input class="bloquear" id="ckboxPielHumeda" type="checkbox" name="ckboxPielHumeda" checklist-model="Piel" checklist-value="'Húmeda'" ng-click="BorrarPiel()">
                          <label for="ckboxPielHumeda" class="rdo-redondo checkPielAntecedentes"></label>

                        </div>
                      </div>
                    </div>

                    <div class="cont_check_rdo">
                      <div class="cont-checbox">
                        <div><span>Enrojecido</span>  </div>
                        <div class="checkbox">

                          <input class="bloquear" id="ckboxPielEnrojecido" type="checkbox" name="ckboxPielEnrojecido" checklist-model="Piel" checklist-value="'Enrojecido'" ng-click="BorrarPiel()">
                          <label for="ckboxPielEnrojecido" class="rdo-redondo checkPielAntecedentes"></label>

                        </div>
                      </div>
                    </div>

                    <div class="cont_check_rdo">
                      <div class="cont-checbox">
                        <div><span>Ictérica</span>  </div>
                        <div class="checkbox">

                          <input class="bloquear" id="ckboxPielIcterica" type="checkbox" name="ckboxPielIcterica" checklist-model="Piel" checklist-value="'Ictérica'" ng-click="BorrarPiel()">
                          <label for="ckboxPielIcterica" class="rdo-redondo checkPielAntecedentes"></label>

                        </div>
                      </div>
                    </div>

                    <div class="cont_check_rdo">
                      <div class="cont-checbox">
                        <div><span>Cianótica</span>  </div>
                        <div class="checkbox">

                          <input class="bloquear" id="ckboxPielCianotica" type="checkbox" name="ckboxPielCianotica"  checklist-model="Piel" checklist-value="'Cianótica'" ng-click="BorrarPiel()">
                          <label for="ckboxPielCianotica" class="rdo-redondo checkPielAntecedentes"></label>

                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

            </div>
          </div>
        </div> <!-- Fin .panel -->

        <!-- ESTADO HEMODINÁMICO -->
        <div class="n_flex n_flex_col100 md_flex_col40 n_justify_around horizontal_padding">
          <div class="panel block">
            <div class="panel-cabecera">
              <h3>Estado Hemodinámico</h3>
            </div>

            <div class="panel-contenido">
              <div class="n_flex n_justify_between">

                <div class="n_flex n_flex_col100">
                  <div class="content-solid height-fijo whole_wrapper">

                    <div class="cont_check_rdo">
                      <div class="cont-checbox dashed-top">
                        <div><span>Estable</span>  </div>
                        <div class="checkbox">

                          <input class="bloquear" id="rdEstable" type="radio" name="check"  ng-model="EstadoHemodinamico" value="Estable" ng-click="BorrarClaseEstado()">
                          <label for="rdEstable" class="rdo-redondo EstadoHemodinamicoAntecedentes"></label>

                        </div>
                      </div>
                    </div>

                    <div class="cont_check_rdo">
                      <div class="cont-checbox">
                        <div><span>Inestable</span>  </div>
                        <div class="checkbox">

                          <input class="bloquear" id="Rdinestable" type="radio" name="check" ng-model="EstadoHemodinamico" value="Inestable" ng-click="BorrarClaseEstado()">
                          <label for="Rdinestable" class="rdo-redondo EstadoHemodinamicoAntecedentes"></label>

                        </div>
                      </div>
                    </div>

                    <div class="cont_check_rdo">
                      <div class="cont-checbox">
                        <div><span>Paro Respiratorio</span>  </div>
                        <div class="checkbox">

                          <input class="bloquear" id="rdParoRespiratorio" type="radio" name="check"   ng-model="EstadoHemodinamico" value="Paro Respiratorio" ng-click="BorrarClaseEstado()">
                          <label for="rdParoRespiratorio" class="rdo-redondo EstadoHemodinamicoAntecedentes"></label>

                        </div>
                      </div>
                    </div>

                    <div class="cont_check_rdo">
                      <div class="cont-checbox">
                        <div><span>Paro Cardiorespiratorio</span>  </div>
                        <div class="checkbox">

                          <input class="bloquear" id="rdParoCardio" type="radio" name="check"  ng-model="EstadoHemodinamico" value="Paro Cardiorespiratorio" ng-click="BorrarClaseEstado()">
                          <label for="rdParoCardio" class="rdo-redondo EstadoHemodinamicoAntecedentes"></label>

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

      <!-- ESPECIFICACIÓN GENERAL -->
      <div class="n_flex n_flex_col100 n_justify_around horizontal_padding">
        <div class="panel block">
          <div class="panel-cabecera">
            <h3>Especificación General del Exámen</h3>

          </div>
          <div class="panel-contenido">
            <textarea class="bloquear" name="txtEspecifiqueExamenFisico" rows="8" cols="40" ng-model="EspecificacionExamen"></textarea>
          </div>
        </div> <!-- Fin .panel -->
      </div>


    </form> <!-- FIN CONTENIDO VISTA -->
  </div>
</div> <!-- fin n_flex_col100 -->
