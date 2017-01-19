<button title="Volver" type="btton" class="flecha-izq" id="flecha-izq" onclick="window.location='<?PHP echo URL ?>HistoriaClinicaDMC/ctrlConsultarAtencion/Index/<?PHP echo $idPersona ?>'">
    <li class="fa fa-long-arrow-left"></li>
</button>

<div class="contenedor-principal">
    <div class="menu-principal-maestras" style="background: transparent;margin-top:15px">

        <!-- MÓDULOS -->
        <ul class="ul-contenedor-modulos nav-cont">
            <li class="modulo" id="item1">
                <div class="text-container">
                    <div class="grupo">
                        <div>
                            <div><b>T</b></div>
                        </div>
                        <span>Tratamiento</span></div>
                    <i class="flecha-derecha fa fa-angle-right"></i>
                </div>
            </li>
            <li class="modulo" id="item2">
                <div class="text-container">
                    <div class="grupo">
                        <div><b>F</b></div>
                        <span>Fórmula Médica</span></div>
                    <i class="flecha-derecha fa fa-angle-right"></i>
                </div>
            </li>
            <li class="modulo" id="item3">
                <div class="text-container">
                    <div class="grupo">
                        <div>
                            <div><b>E-E</b></div>
                        </div>
                        <span>Exámen Especializado</span></div>
                    <i class="flecha-derecha fa fa-angle-right"></i>
                </div>
            </li>
            <li class="modulo" id="item4">
                <div class="text-container">
                    <div class="grupo">
                        <div>
                            <div><b>I</b></div>
                        </div>
                        <span>Interconsulta</span></div>
                    <i class="flecha-derecha fa fa-angle-right"></i>
                </div>
            </li>
            <li class="modulo" id="item5">
                <div class="text-container">
                    <div class="grupo">
                        <div>
                            <div><b>I</b></div>
                        </div>
                        <span>Incapacidad</span></div>
                    <i class="flecha-derecha fa fa-angle-right"></i>
                </div>
            </li>
            <li class="modulo" id="item6">
                <div class="text-container">
                    <div class="grupo">
                        <div>
                            <div><b>O</b></div>
                        </div>
                        <span>Otro</span></div>
                    <i class="flecha-derecha fa fa-angle-right"></i>
                </div>
            </li>
        </ul>

    </div>

    <div class="marcaAgua" id="marcaOrdenesMedicas" style="width:100%; margin-top: 80px">
        <center>
            <img src="<?PHP echo URL?>/Public/Img/HistoriaClinicaDMC/eps.png" class="n_justify_center">
            <h1 id="tituloOrden" class="n_justify_center">CONSULTA DE ÓRDENES MÉDICAS</h1></center>
    </div>

    <div id="Item1" class="fila" style="margin:15px 58px 15px 15px;">

        <div class="panel">
            <div class="panel-cabecera">
                <div class="vertical_padding horizontal_padding n_flex n_justify_end">
                    <h3 style="margin-top: -5px; padding-bottom: 0px;">Tratamiento</h3>
                    <div class="header-btn separate" style="margin-left:5px;">
                        <button class="tooltip btn btn-registrar btnEnviarOrdenes" onclick="EnviarReporteTratamiento()">
                            <span class="fa fa-paper-plane"></span> Enviar
                        </button>
                        <button class="tooltip btn btn-cancelar" onclick="generarReporteTratamiento()" id="btnCerrar2">
                            <span class="fa fa-download"></span> Descargar
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-contenido">
                <div class="n_flex info_head" id="containerConsultarTratamiento">
                    <div class="n_flex_col45">
                      <div class="n_flex">
                          <p class="paragraph">
                            <span class="text_bold block" style="color: #00A8A7;">Tipo Tratamiento : </span><br>
                            <label id="txtTipoTratamiento"></label>
                          </p>
                      </div>
                      <br><hr>
                      <div class="n_flex">
                          <p class="paragraph">
                              <span class="text_bold block" style="color: #00A8A7;">Fecha limite: </span><br>
                              <label for="" id="txtFechaLimiteTratamiento"></label>
                          </p>
                      </div>
                      <br><hr>
                      <div class="n_flex">
                          <p class="paragraph">
                              <span class="text_bold block" style="color: #00A8A7;">Descripción Tratamiento : </span><br>
                              <label for="" id="txtDescripcionTratamiento"></label>
                          </p>
                      </div>
                      <br><hr>
                      <div class="n_flex">
                          <p class="paragraph">
                              <span class="text_bold block" style="color: #00A8A7;">Dósis del Tratamiento : </span><br>
                              <label for="" id="txtDosisTratamiento"></label>
                          </p>
                      </div>
                    </div>
                    <div class="n_flex_col10">
                    </div>
                    <div class="n_flex_col45 horizontal_padding">
                        <div class="table-responsive">
                            <table class="tbl_scroll">
                                <thead>
                                    <th>Equipo biomedico</th>
                                    <th>Existencias</th>
                                </thead>
                                <tbody id="containerConsultarEquipos">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!--Formula medica-->

    <div id="Item2" class="fila" style="margin:15px 58px 15px 15px;">
        <div class="panel">
            <div class="panel-cabecera">
                <div class="vertical_padding horizontal_padding n_flex n_justify_end">
                    <h3 style="margin-top: -5px; padding-bottom: 0px;">Fórmula Médica</h3>
                    <div class="header-btn separate" style="margin-left:5px;">

                        <button class="tooltip btn btn-registrar btnEnviarOrdenes" onclick="EnviarReporteFormulaMedica()">
                            <span class="fa fa-paper-plane"></span> Enviar
                        </button>
                        <button class="tooltip btn btn-cancelar" onclick="generarReporteFormulaM()" id="btnCerrar2">
                            <span class="fa fa-download"></span> Descargar
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-contenido">
                <div class="n_flex info_head">
                    <div class="n_flex_col100" id="tablaConsultarFormulaMedica">
                    </div>
                    <div class="n_flex_col100"><br><hr></div>
                    <div  class="">
                        <span class="text_bold block" style="color: #00A8A7;">Recomendaciones: </span>
                        <p class="block" id="txtRecomendaciones"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--Examen especializado-->

    <div id="Item3" class="fila" style="margin:15px 58px 15px 15px;">
        <div class="panel">
            <div class="panel-cabecera">
                <div class="vertical_padding horizontal_padding n_flex n_justify_end">
                    <h3 style="margin-top: -5px; padding-bottom: 0px;">Examen Expecializado</h3>
                    <div class="header-btn separate" style="margin-left:5px;">

                        <button class="tooltip btn btn-registrar btnEnviarOrdenes" onclick="EnviarReporteExamenEspecializado()">
                            <span class="fa fa-paper-plane"></span> Enviar
                        </button>
                        <button class="tooltip btn btn-cancelar" onclick="generarReporteExamenE()" id="btnCerrar2">
                            <span class="fa fa-download"></span> Descargar
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-contenido">

                <div class="n_flex info_head">
                    <div class="n_flex_col45">
                        <span class="text_bold block" style="color: #00A8A7;">Observaciones : </span>
                        <p  class="block" id="txtObservaciones"></p>
                        <br>
                        <hr>
                        <span class="text_bold block" style="color: #00A8A7;">Descripción : </span>
                        <p  class="block" id="txtDescripcion"></p>
                        <br>

                    </div>
                    <div class="n_flex_col10">

                    </div>
                    <div class="n_flex_col45 horizontal_padding">
                        <span class="text_bold block" style="color: #00A8A7;">Tipo exámen especializado : </span><br>
                        <span id="txtNombreTipo"></span>
                        <br><br><br>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!--Interconsulta-->

    <div id="Item4" class="fila" style="margin:15px 58px 15px 15px;">
        <div class="panel">
            <div class="panel-cabecera">
                <div class="vertical_padding horizontal_padding n_flex n_justify_end">
                    <h3 style="margin-top: -5px; padding-bottom: 0px;">Interconsulta</h3>
                    <div class="header-btn separate" style="margin-left:5px;">

                        <button class="tooltip btn btn-registrar btnEnviarOrdenes" onclick="EnviarReporteInterconsulta()">
                            <span class="fa fa-paper-plane"></span> Enviar
                        </button>
                        <button class="tooltip btn btn-cancelar" onclick="generarReporteInterconsulta()" id="btnCerrar2">
                            <span class="fa fa-download"></span> Descargar
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-contenido">
                <div class="n_flex info_head">
                    <div class="n_flex_col100">
                      <div class="n_flex">
                          <p class="paragraph">
                            <span class="text_bold block" style="color: #00A8A7;">Fecha limite de interconsulta : </span><br>
                            <label id="txtFechaLimiteInterconsulta"></label>
                          </p>
                      </div>
                      <br><hr>
                      <div class="n_flex">
                          <p class="paragraph">
                            <span class="text_bold block" style="color: #00A8A7;">Especialidad : </span><br>
                            <label id="txtEspecialidad"></label>
                          </p>
                      </div>
                      <br><hr>
                      <div class="n_flex">
                          <p class="paragraph">
                            <span class="text_bold block" style="color: #00A8A7;">Descripcion : </span><br>
                            <label id="txtDescripcionInterconsulta"></label>
                          </p>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--Incapacidad-->
    <div id="Item5" class="fila" style="margin:15px 58px 15px 15px;">
        <div class="panel">
            <div class="panel-cabecera">
                <div class="vertical_padding horizontal_padding n_flex n_justify_end">
                    <h3 style="margin-top: -5px; padding-bottom: 0px;">Incapacidad</h3>
                    <div class="header-btn separate" style="margin-left:5px;">

                        <button class="tooltip btn btn-registrar btnEnviarOrdenes" onclick="EnviarReporteIncapacidad()">
                            <span class="fa fa-paper-plane"></span> Enviar
                        </button>
                        <button class="tooltip btn btn-cancelar" onclick="generarReporteIncapacidad()" id="btnCerrar2">
                            <span class="fa fa-download"></span> Descargar
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-contenido">
                <div class="n_flex info_head">
                    <div class="n_flex_col100">
                        <span class="text_bold block" style="color: #00A8A7;">Número de días : </span>
                        <p class="block" id="txtNumeroDias"></p>
                        <br><hr>
                    </div>
                    <div class="n_flex_col50 ">
                        <span class="text_bold block" style="color: #00A8A7;">Código CIE10 : </span>
                        <p class="block" id="txtCodigoCie10"></p>
                        <br><hr>
                    </div>
                    <div class="n_flex_col50">
                        <span class="text_bold block" style="color: #00A8A7;">Descripción CIE10 : </span>
                        <p class="block" id="txtDescripcionCie10s"></p>
                        <br><hr>
                    </div>
                    <div class="n_flex_col100">
                        <span class="text_bold " style="color: #00A8A7;">Descripción : </span>
                        <p class="" id="txtDescripcionIncapacidad"></p>
                        <hr>
                        <span class="text_bold block" style="color: #00A8A7;">Prórroga</span><br>
                        <p class="block" id="txtProrroga"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!--Otro-->
    <div id="Item6" class="fila" style="margin:15px 58px 15px 15px;">
        <div class="panel">
            <div class="panel-cabecera">
                <div class="vertical_padding horizontal_padding n_flex n_justify_end">
                    <h3 style="margin-top: -5px; padding-bottom: 0px;">Otro</h3>
                    <div class="header-btn separate" style="margin-left:5px;">

                        <button class="tooltip btn btn-registrar btnEnviarOrdenes" onclick="EnviarReporteOtro()">
                            <span class="fa fa-paper-plane"></span> Enviar
                        </button>
                        <button class="tooltip btn btn-cancelar" onclick="generarReporteOtro()" id="btnCerrar2">
                            <span class="fa fa-download"></span> Descargar
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-contenido">
                <div class="n_flex info_head">
                    <div class="n_flex_col100">
                        <span class="text_bold block" style="color: #00A8A7;">Descripcion : </span>
                        <p class="block" id="txtOtro"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
