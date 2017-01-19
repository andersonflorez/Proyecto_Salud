 <!-- CONTORLADOR DE ANGULAR JS -->
<div  ng-controller="ctrlLayoutReporteAPH">

  <?php if ( Sesion::varExist('esModoConsulta') ): ?>
    <?php if ( (bool) !Sesion::getValue('esModoConsulta') ): ?>
      <div class="menu_emergencia" >

        <div class="menu-desplegable" id="menu_emergencia">
          <div class="cont-menu-des">
            <h5>Carrera 12 Calle 34 # 45 </h5>

            <div class="fila-menu fm1">
              <div class="col-menu abrir-menu-ambulancias">
                <a href="#">
                  <i class="fa fa-ambulance"></i>
                  <p>Consultar Ambulancias</p>
                </a>
              </div>
              <div class="col-menu">
                <a href="<?=URL?>ReporteAPH/ctrlReporteInicialAPH">
                  <i class="fa fa-bullhorn"></i>
                  <p>Reporte Inicial</p>
                </a>
              </div>
            </div>

            <div class="fila-menu">
              <div class="col-menu">
                <a href="#" ng-click="PedirAyudaExterna(4)">
                  <div class="img-ayuda">
                    <img src="<?=URL?>Img/ReporteAPH/policia.png" alt="" />
                  </div>
                  <p>Policia</p>
                </a>
              </div>
              <div class="col-menu">
                <a href="#" ng-click="PedirAyudaExterna(2)">
                  <div class="img-ayuda">
                    <img src="<?=URL?>Img/ReporteAPH/bomberoscolombia.jpg" alt="" />
                  </div>
                  <p>Bomberos</p>
                </a>
              </div>
              <div class="col-menu">
                <a href="#" ng-click="PedirAyudaExterna(3)">
                  <div class="img-ayuda">
                    <img src="<?=URL?>Img/ReporteAPH/transito.png" alt="" />
                  </div>
                  <p>Tránsito</p>
                </a>
              </div>
              <div class="col-menu">
                <a href="#" ng-click="PedirAyudaExterna(5)">
                  <div class="img-ayuda">
                    <img src="<?=URL?>Img/ReporteAPH/dagrd2.jpg" alt="" />
                  </div>
                  <p>Dagrd</p>
                </a>
              </div>
              <div class="col-menu">
                <a href="#" id="btn_ayuda"  ng-click="rdoNovedad = 'Novedad' ">
                  <div class="img-ayuda ambu">
                    <img src="<?=URL?>Img/ReporteAPH/ambulancia.png" alt="" />
                  </div>
                  <p>Novedad Emergencia</p>
                </a>

              </div>
            </div>

            <div class="fila-menu">
              <div class="col-menu" id="cont_btn_llegada">
                <a href="#" id="btn_llegada" ng-click="ConfirmarLlegada()">
                  <i class="fa fa-thumbs-o-up"></i>
                  <p id="text_hora_llegada" ></p>
                </a>
              </div>
              <div class="col-menu">
                <a href="#" ng-click="CancelarEmergencia()">
                  <i class="fa fa-thumbs-o-down"></i>
                  <p>Cancelar</p>
                </a>
              </div>
            </div>

          </div>
        </div><!--menu-desplegable-->
      </div>


      <!-- DIALOGO DE SOLICITUD -->
      <div class="md_solicitarAyuda" >
        <div class="head_md_confirmar">
          <h5>Novedad de Emergencia</h5>
          <span class="cerrarSolicitudAyuda">x</span>
        </div>

        <div class="contenido_md_confirmacion">

          <div class="contenido no-pad">
            <div class="fila">

              <!-- Elegir que tipo de novedad desea -->
              <div class="columna--10 div_botones">
                <div class="cont-antecedente">
                  <div class="cont-radio">
                    <div class="radio">
                      <input id="ayuda" type="radio" name="rdoNovedad" ng-model="rdoNovedad" value="Ayuda" ng-click="verRegistroNovedad = false; verListaNovedades = false;">
                      <label for="ayuda">Ayuda</label>

                      <input id="novedad" type="radio" name="rdoNovedad" ng-model="rdoNovedad"  value="Novedad" ng-click="verRegistroNovedad = false; verListaNovedades = false;">
                      <label for="novedad">Novedad</label>
                    </div>
                  </div>
                </div>
              </div>


              <div class="cont_pedirAyuda">

                <!-- Pedir nueva ambulancia -->
                <form ng-submit="PedirNuevaAmbulancia(formSolicitarAyuda)" name="form_PedirNuevaAmbulancia">

                  <div id="solicitudAyuda" ng-show="rdoNovedad == 'Ayuda' ">
                    <div class="columna--10 div_botones">
                      <div class="cont-antecedente">
                        <div class="tituloAntec">

                          <p>Básica</p>
                        </div>

                        <div class="cont-radio">
                          <div class="radio">
                            <input id="basicaSi" type="radio" name="radioSolicitudBasica" ng-model="radioAngular.radioSolicitudBasica" value="SI">
                            <label for="basicaSi">Si</label>

                            <input id="basicaNo" type="radio" name="radioSolicitudBasica" ng-model="radioAngular.radioSolicitudBasica"  value="NO">
                            <label for="basicaNo"  data-ng-click="formSolicitarAyuda.txtNumeroBasico = '' ">No</label>
                          </div>

                          <input
                          ng-show="radioAngular.radioSolicitudBasica =='SI' " ng-required="radioAngular.radioSolicitudBasica =='SI'"  ng-class="{'input-invalid':form_PedirNuevaAmbulancia.txtNumeroBasico.$invalid && form_PedirNuevaAmbulancia.txtNumeroBasico.$dirty}"
                          type="number"
                          ng-model="formSolicitarAyuda.txtNumeroBasico"
                          name="txtNumeroBasico"
                          placeholder="Número de unidades"
                          min="1">

                          <span ng-show="!form_PedirNuevaAmbulancia.txtNumeroBasico.$pristine && form_PedirNuevaAmbulancia.txtNumeroBasico.$error.required" class="msjRequeridoAngular">Este campo es obligatorio.</span>

                        </div>
                      </div>
                    </div>
                    <div class="columna--10 div_botones">
                      <div class="contenido no-pad">
                        <div class="cont-antecedente">
                          <div class="tituloAntec">

                            <p>Medicalizada</p>
                          </div>

                          <div class="cont-radio">
                            <div class="radio">
                              <input id="medicalizadoSi" type="radio" name="radioSolicitudMedicalizado" ng-model="radioAngular.radioSolicitudMedicalizado" value="SI" >
                              <label for="medicalizadoSi">Si</label>

                              <input id="medicalizadoNo" type="radio" name="radioSolicitudMedicalizado" ng-model="radioAngular.radioSolicitudMedicalizado" value="NO">
                              <label for="medicalizadoNo"  data-ng-click="formSolicitarAyuda.txtNumeroMedicalizada = '' " >No</label>
                            </div>


                            <input
                            ng-show="radioAngular.radioSolicitudMedicalizado =='SI' " ng-required="radioAngular.radioSolicitudMedicalizado =='SI'"  ng-class="{'input-invalid':form_PedirNuevaAmbulancia.txtNumeroMedicalizada.$invalid && form_PedirNuevaAmbulancia.txtNumeroMedicalizada.$dirty}"
                            type="number"
                            ng-model="formSolicitarAyuda.txtNumeroMedicalizada"
                            name="txtNumeroMedicalizada"
                            placeholder="Número de unidades"
                            min="1">

                            <span ng-show="!form_PedirNuevaAmbulancia.txtNumeroMedicalizada.$pristine && form_PedirNuevaAmbulancia.txtNumeroMedicalizada.$error.required" class="msjRequeridoAngular">Este campo es obligatorio.</span>
                          </div>
                        </div>
                      </div>



                    </div>
                    <div class="columna--10">
                      <div class="cont-antecedente">
                        <div class="tituloAntec">

                          <p>Motivo</p>
                        </div>

                        <div class="cont-radio">
                          <textarea name="" cols="30" rows="5" required ng-model="formSolicitarAyuda.txtMotivoAyuda"></textarea>
                        </div>
                      </div>
                    </div>


                    <div class="columna--10 div_botones">

                      <div class="cont-antecedente">
                        <input
                        type="submit"
                        ng-show="radioAngular.radioSolicitudMedicalizado =='SI' || radioAngular.radioSolicitudBasica =='SI' "
                        class="btn btn-registrar" style="width: 100%;"
                        value="Solicitar">

                        <input type="button" class="btn btn-eliminar cerrarSolicitudAyuda" style="width: 100%;margin-top:2px" value="Cancelar" >
                      </div>

                    </div>
                  </div>
                </form>

                <!-- Listar o registrar novedad -->
                <form ng-submit="AgregarNovedadLocalStorage(RegistroNovedad)">


                  <!-- Mostrar opciones de novedad -->
                  <div id="opcionesNovedad" ng-show="rdoNovedad == 'Novedad' " ng-hide="verRegistroNovedad || rdoNovedad == 'Ayuda' || verListaNovedades">

                    <div class="columna--10 columna-hd--10 columna-tablet--10 columna-movil--10 div_botones">

                      <div class="cont-antecedente">
                        <input type="button"  class="btn btn-registrar" style="width: 100%;" value="Agregar" ng-click="verRegistroNovedad = true; verBtnRegistrarNovedad = true; verBtnEditarNovedad = false; RegistroNovedad.txtNumeroLesionados = ''; RegistroNovedad.txtNovedadLibre = ''; ">

                        <input type="button" class="btn btn-consultar" style="width: 100%;margin-top:2px" value="Listar" ng-click="verListaNovedades = true">
                      </div>

                    </div>

                  </div>


                  <!-- Registrar novedad en locacalStorage -->
                  <div id="registroNovedad"  ng-show="verRegistroNovedad">

                    <div class="columna--10 div_botones">
                      <div class="cont-antecedente">
                        <div class="tituloAntec">
                          <p>Número de lesionados </p>
                        </div>

                        <div class="cont-radio">

                          <input type="number" name="txtNumeroLesionados" ng-model="RegistroNovedad.txtNumeroLesionados" placeholder="Eje: 10" min="1">
                        </div>
                      </div>
                    </div>

                    <div class="columna--10">
                      <div class="cont-antecedente">
                        <div class="tituloAntec">
                          <p>Novedad</p>
                        </div>

                        <div class="cont-radio">
                          <textarea name="txtNovedadLibre" ng-model="RegistroNovedad.txtNovedadLibre"  cols="30" rows="5" required ng-class="{'input-invalid':RegistroNovedad.txtNovedadLibre.$invalid && RegistroNovedad.txtNovedadLibre.$dirty}"></textarea>

                          <span ng-show="!RegistroNovedad.txtNovedadLibre.$pristine && RegistroNovedad.txtNovedadLibre.$error.required" class="msjRequeridoAngular">Este campo es obligatorio.</span>
                        </div>
                      </div>
                    </div>


                    <div class="columna--10 columna-hd--10 columna-tablet--10 columna-movil--10 div_botones">

                      <div class="cont-antecedente">
                        <input type="submit" ng-show="verBtnRegistrarNovedad"  class="btn btn-registrar" style="width: 100%;" value="Agregar" ng-click="ClickBtnEditar(false)">

                        <input type="submit" ng-show="verBtnEditarNovedad" class="btn btn-modificar" style="width: 100%;" value="Editar" ng-click="ClickBtnEditar(true); EditarNovedadLocalStorage(RegistroNovedad);">

                        <input type="button" class="btn btn-eliminar cerrarSolicitudAyuda" style="width: 100%;margin-top:2px" value="Cancelar">
                      </div>

                    </div>

                  </div>


                  <!-- Listar Novedades localStorage -->
                  <div class="ListarNovedades" ng-show="verListaNovedades">
                    <div class="filtroNovedades">
                      <div class="fa fa-search"></div>
                      <input type="text" placeholder="Filtrar novedades..." ng-model="txtFiltroNovedades">
                    </div>

                    <div class="columna--10 div_botones">

                      <div class="item-novedad cont-antecedente" ng-repeat="novedad in Novedades | filter:txtFiltroNovedades as resultsNovedades ">
                        <div class="text-novedad" title="{{novedad.txtNovedadLibre}}">{{novedad.txtNovedadLibre}}</div>

                        <div class="botones-item-novedad">
                          <span class="btn-item-novedad" ng-click="ConsultarNovedadLocalStorage(novedad.idNovedad , RegistroNovedad)"><i class="fa fa-pencil"></i></span>

                          <span class="btn-item-novedad" ng-click="EliminarNovedad(novedad.idNovedad)"><i class="fa fa-trash"></i></span>
                        </div>
                      </div>

                      <!-- Solo se muestra cuando no hay resultados -->
                      <div class="novedades_no_resultados" ng-if="Novedades.length == 0">
                        <h4>No hay novedades para mostrar.</h4>
                      </div>

                    </div>
                  </div>

                </form>


              </div>


            </div>
          </div>

        </div>

      </div>
    <?php endif; ?>
  <?php endif; ?>

  <!--MENÚ FLOTANTE NOTIFICACIONES-->
  <div class=" menu-notificaciones-flotantes">
    <div class="encabezado-notfy-f">
      <div class="titulo-notificaciones-f">
        <h4>
          Notificaciones
        </h4>
        <span class="cerrarMenuNF fa fa-search" id="MostrarFiltrarN"></span>
        <span class="cerrarMenuNF fa fa-reply" id="MostrarMenuN"></span>
      </div>

      <input type="text" name="txtFiltrarNotificacionesE" id="txtFiltrarNotificacionesE" placeholder="Filtrar Notificaciones">
    </div>

    <div class="cont-notificaciones-f" id="ContenedorNotifyAPH">
      <?php
      if ($datos != false || $datos!= null) {
        # code...

        ?>  <a href="#">
          <div class="notificacion-f n-llamada"  onClick="AceptarNotificacion(<?=$idDespacho->idDespacho?>,<?=$datos[0]->idReporteInicial?>,'falses')" >
            <div class="icon-llamada">
              <span class="fa fa-exclamation" style="padding: 0.7em 0.7em !important"></span>
            </div>
            <div class="contenido-notifiN">
              <h5>EMERGENCIA! <span id="spanFecha"><?= $datos[0]->fechaHoraAproximadaEmergencia; ?></span></h5>
              <p id="pinformacionInicial">
                <?= $datos[0]->informacionInicial; ?>
              </p>
              <p id="pubicacion"><b>Dirección:</b> <?= $datos[0]->ubicacionIncidente; ?></p>
              <p id="pdescripciontipoEvento"><b>Tipos de evento:</b><?= $datos[0]->descripciontipoevento.'.';?> </p>
            </div>
          </div>
        </a>
        <?php
        }
      ?>

    </div>


  </div>

   <!--BARRA DE PROGRESO-->

  <div class="n_flex n_flex_col100 contenedor-barra-progreso ">
    <div class="barra-progreso n_flex n_flex_col100">
        <!-- <div class="progress-basica" title="Resultado de Atención"></div> -->

        <?php
        $iconosBarras = array(
          'fa fa-file-archive-o',
          'fa fa-edit',
          'fa fa-user-md',
          'fa fa-heartbeat',
          'fa fa-child',
          'fa fa-stethoscope',
          'fa fa-plus-square',
          'fa fa-medkit',
          'fa fa-flag'
       );
       $nombresBarra = array(
         'Información General',
         'Tipo de Evento',
         'Motivo Consulta',
         'Antecedentes Paciente',
         'Localización de Lesiones',
         'Tratamiento Básico',
         'Tratamiento Avanzado',
         'Medicamentos',
         'Resultado de Atención'
      );
        $vistas = Sesion::getValue('VISTAS_BARRA_PROGRESO');
        $vistaActual = Sesion::getValue('VISTA_ACTUAL');
        $bola = '';
        $i = 0;
        $x = 1;
        foreach ($vistas as $key => $value) {
            if ($value == true) {
              $cont = $x;
              if ($vistaActual == $key) {
                $url = "#";
                $clase = "pagina-barra-progreso estoy-aqui";
              }else {
                $url = URL."ReporteAPH/".$key;
                $clase = "pagina-barra-progreso progres-active";
              }
            }else{
              $clase = "pagina-barra-progreso";
              $url = "#";
            }

            $bola = $bola.'
            <a id="'.$key.'" href="'.$url.'" title="'.$nombresBarra[$i].'" class="'.$clase.'">
            <span class="'.$iconosBarras[$i].'"></span>
            </a>
            ';
            $i++;
            $x++;
        }
        $estado = '<div class="progreso progres-active" ancho="'.$cont.'" id="progressbar" title=""></div>';
        echo $estado;
        echo $bola;

         ?>


    </div>
  </div>


  <!---MENÚ DE AMBULANCIAS--->
  <div class="contenedor-ambulancia">
    <div class="contenedor-titulo">
      <h3>Ambulancias</h3>
      <span class="cerrar-menu-ambulancia fa fa-reply" id="MostrarMenuN"></span>
    </div>

    <div class="contenedor-cuerpo">
    </div>
  </div>

  <!-- DATOS NECESARIOS PARA LOS SCRIPT  -->
  <script>
  var ri = JSON.parse(localStorage.getItem('ReporteAPH-ReporteInicial')) || {};
  const idDespacho = ri.idDespacho;
  const idReporteInicial = ri.idReporteInicial;
  const idAmbulancia = ri.idAmbulancia;
  </script>

</div>
