    <script>
       
    </script>
<button type="button" id="btnTerminarHistoriaClinica" title="Terminar" class="flecha-der">
    <li class="fa fa-floppy-o"></li>
</button>

<button title="Volver" type="btton" class="flecha-izq" id="flecha-izq" onclick="window.location='<?PHP echo URL ?>HistoriaClinicaDMC/ctrlRegistrarMedicacion/index/<?PHP echo $idPaciente ."/".$idCita."/".$idCitaProgramacion?>'">
    <li class="fa fa-long-arrow-left"></li>
</button>

<div class="contenedor-principal">
    <div class="menu-principal-maestras" style="background: transparent;margin-top:15px">

        <!-- MÓDULOS -->
        <ul class="ul-contenedor-modulos nav-cont">
            <li class="modulo" style="display:none" id="item1" >
                <div class="text-container">
                    <div class="grupo">
                        <div><b>T</b></div>
                        <span>Tratamiento</span></div>
                    <i class="flecha-derecha fa fa-angle-right"></i>
                </div>
            </li>
            <li class="modulo" style="display:none" id="item2">
                <div class="text-container">
                    <div class="grupo">
                        <div><b>F</b></div>
                        <span>Fórmula Médica</span></div>
                    <i class="flecha-derecha fa fa-angle-right"></i>
                </div>
            </li>
            <li class="modulo" style="display:none" id="item3">
                <div class="text-container">
                    <div class="grupo">
                        <div><div><b>E-E</b></div></div>
                        <span>Exámen Especializado</span></div>
                    <i class="flecha-derecha fa fa-angle-right"></i>
                </div>
            </li>
            <li class="modulo" style="display:none" id="item4">
                <div class="text-container">
                    <div class="grupo">
                        <div><div><b>I</b></div></div>
                        <span>Interconsulta</span></div>
                    <i class="flecha-derecha fa fa-angle-right"></i>
                </div>
            </li>
            <li class="modulo" style="display:none" id="item5">
                <div class="text-container">
                    <div class="grupo">
                        <div><div><b>I</b></div></div>
                        <span>Incapacidad</span></div>
                    <i class="flecha-derecha fa fa-angle-right"></i>
                </div>
            </li>
            <li class="modulo" style="display:none" id="item6">
                <div class="text-container">
                    <div class="grupo">
                        <div><div><b>O</b></div></div>
                        <span>Otro</span></div>
                    <i class="flecha-derecha fa fa-angle-right"></i>
                </div>
            </li>
            <li class="modulo" id="item7">
                <div class="text-container">
                    <div class="grupo">
                        <div><i class="fa fa-plus-square "></i></div>
                        <span>Agregar</span>
                    </div>
                </div>
            </li>
        </ul>

    </div>

    <div  class="fila">
        <div class="marcaAgua" id="marcaOrdenesMedicas" style="width:100%; margin-top: 80px">
            <center>
                <img src="<?PHP echo URL?>/Public/Img/HistoriaClinicaDMC/eps.png" class="n_justify_center">
                <h1 id="tituloOrden" class="n_justify_center">ÓRDENES MÉDICAS</h1></center>
        </div>
        <div id="Item1" style="margin:15px 58px 15px 15px;">

            <div class="panel">
                <div class="panel-cabecera">
                    <center><h3>Tratamiento</h3></center>
                </div>
                <div class="panel-contenido">
                    <div class="fila">
                        <div class="columna-3 columna-hd--3">
                            <div class="frmCont" >
                                <label for="cmbTipoTratamiento">Tipo Tratamiento  &nbsp <i style="color:red;">*</i></label>
                                <div class="frmInput frmInput_select2">
                                    <select data-rule-RE_Select="0" class="input_data" id="cmbTipoTratamiento" name="cmbTipoTratamiento"></select>
                                </div>
                            </div>
                           
                            <br>
                            <div class="frmCont">
                                <label for="txtFechaLimite">Fecha limite  &nbsp <i style="color:red;">*</i></label>
                                <div class="frmInput">
                                    <input data-rule-required="true" type="text" id="txtFechaLimite" name="txtFechaLimite" placeholder="Fecha Tratamiento" data-language='es' class="input_data datepicker-here">
                                </div>
                            </div>
                        
                            <br>
                            <div class="frmCont">
                                <label for="txtDescripcionTratamiento">Descripcion de tratamiento &nbsp <i style="color:red;">*</i></label>
                                <div class="frmInput">
                                    <textarea data-rule-required="true" data-rule-maxlength="15000" name="txtDescripcionTratamiento" placeholder="" id="txtDescripcionTratamiento" name="txtDescripcionTratamiento" class="input_data"></textarea>
                                </div>
                            </div>

                            <div class="frmCont">
                                <label for="txtDosisTratamiento">Dósis del Tratamiento:</label>
                                <div class="frmInput">
                                    <textarea name="txtDosisTratamiento" data-rule-maxlength="15000" placeholder="" id="txtDosisTratamiento"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="columna--1 columna-hd--1"></div>

                        <div class="columna--5 columna-hd--5">
                            <div class="fila" style="border: 1px solid #ddd;padding-left: 10px;">Equipos Biomédicos &nbsp <i style="color:red;">*</i>
                                <div id="containerEquipo" class="EquipoBiome"></div>
                            </div>
                            <div class="fila">
                                <div class="group columna--0 columna-movil--5 columna-tablet--5"style="margin-top: 20px;">
                                    <button type="button" class="btn btn-registrar" id="btnNuevoEquipo"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Agregar equipo</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <!--Formula medica-->

        <div id="Item2" class="fila oFormulaM">
            <div class="panel">
                <div class="panel-cabecera">
                    <center><h3>Fórmula Médica</h3></center>
                </div>
                <div class="panel-contenido">
                    <div class="n_flex_col100">
                        <div class="tbl_container">
                            <!-- principal-->
                            <table class="tbl_scroll">
                                <thead>
                                    <tr>
                                       <th></th>
                                        <th>Medicamento</th>
                                        <th>Cantidad Unidades</th>
                                        <th>Dosificación</th>
                                        <th>Descripción</th>
                                    </tr>
                                </thead>
                                <tbody id="containerMedicamentos" style="width:50%;">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div style="margin-top: 15px; margin-left: 12px;">
                        <button type="button" class="btn btn-registrar" id="btnNuevoMedicamento"><i class="fa fa-plus"></i></button>
                    </div>
                    <br/><br/>
                    <button type="button" class="btn btn-registrar" id="btnAgregarDescripcion">Agregar Recomendaciones</button>

                </div>
            </div>
        </div>


        <!--Examen especializado-->

        <div id="Item3" class="fila" style="margin:15px 58px 15px 15px;">
            <div class="panel">
                <div class="panel-cabecera">
                    <center><h3>Exámen Especializado</h3></center>
                </div>
                <div class="panel-contenido">
                    <div class="fila">
                        <div class="columna-hd--5 columna--5">
                            <div class="frmCont">
                                <label for="txtObservacionExamenEspecializado">Observaciones:&nbsp <i style="color:red;">*</i></label>
                                <div class="frmInput">
                                    <textarea name="txtObservacionExamenEspecializado" data-rule-required="true" data-rule-maxlength="15000" class="input_data" id="txtObservacionExamenEspecializado"></textarea>
                                </div>
                            </div>
                            <div class="frmCont">
                                <label for="txtDescripcionExamenEspecializado">Descripción:&nbsp <i style="color:red;">*</i></label>
                                <div class="frmInput">
                                    <textarea name="txtDescripcionExamenEspecializado" data-rule-required="true" data-rule-maxlength="15000" class="input_data" id="txtDescripcionExamenEspecializado"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="columna-hd--1 columna--1"></div>
                        <div class="columna-hd--4 columna--4" >
                            <div class="frmCont">
                                <label for="cmbTipoExamenEspecializado">Tipo exámen especializado&nbsp <i style="color:red;">*</i></label>
                                <div class="frmInput frmInput_select2">
                                    <select data-rule-RE_Select="0" id="cmbTipoExamenEspecializado" name="cmbTipoExamenEspecializado" class="select input_data"></select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--Interconsulta-->

        <div id="Item4" class="fila" style="margin:15px 58px 15px 15px;">
            <div class="panel">
                <div class="panel-cabecera">
                    <center><h3>Interconsulta</h3></center>
                </div>
                <div class="panel-contenido">
                    <div class="frmCont">
                        <label for="txtFechaLimite">Fecha limite para la interconsulta:&nbsp <i style="color:red;">*</i></label>
                        <div class="frmInput">
                            <input type="text" data-rule-required="true" class="input_data" id="txtFechaLimiteInterconsulta" name="txtFechaLimiteInterconsulta" autocomplete="off">
                        </div>
                    </div>
                    <div class="frmCont">
                        <label for="campo4">Especialidad:&nbsp <i style="color:red;">*</i></label>
                        <div class="frmInput frmInput_select2">
                            <select data-rule-RE_Select="0" id="cmbEspecialidad" name="cmbEspecialidad" class="select input_data"></select>
                        </div>
                    </div>
                    <div class="frmCont">
                        <label for="txtDescripcionInterconsulta">Descripción:&nbsp <i style="color:red;">*</i></label>
                        <div class="frmInput">
                            <textarea name="txtDescripcionInterconsulta" class="input_data" data-rule-required="true" data-rule-maxlength="15000" placeholder="" id="txtDescripcionInterconsulta" ></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--Incapacidad-->
        <div id="Item5" class="fila" style="margin:15px 58px 15px 15px;">
            <div class="panel">
                <div class="panel-cabecera">
                    <center><h3>Incapacidad</h3></center>
                </div>
                <div class="panel-contenido">
                    <div class="frmCont">
                        <label for="txtNumeroDias">Número de días: &nbsp <i style="color:red;">*</i>	</label>
                        <div class="frmInput">
                            <input type="number" data-rule-required="true" class="input_data" id="txtNumeroDias" name="txtNumeroDias" min="1" max="100">
                        </div>
                    </div>

                    <div class="fila">
                        <div class="columna--10 columna-hd--10 columna-tablet--10 columna-movil--10">
                            <div class="fila">
                                <div class="columna--4 columna-hd--4 columna-movil--10 columna-tablet--10">
                                    <div class="frmCont">
                                        <label for="cmbDescripcionCIE10">Descripción CIE10: &nbsp <i style="color:red;">*</i></label>
                                        <div class="frmInput frmInput_select2">
                                            <select  data-rule-RE_Select="0" onchange='seleccionarCodigoAutomaticamente(this)'id="cmbDescripcionCIE10" name="cmbDescripcionCIE10" class="select"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="columna--1 columna-hd--1"></div>
                                <div class="columna--5 columna-hd--5 columna-movil--10 columna-tablet--10">
                                    <div class="frmCont">

                                        <label for="cmbCodigoCIE10">Código CIE10: &nbsp <i style="color:red;">*</i></label>
                                        <div class="frmInput frmInput_select2">
                                            <select data-rule-RE_Select="0" onchange='seleccionarDescripcionAutomaticamente(this)' id="cmbCodigoCIE10" name="cmbCodigoCIE10" class="select"></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="frmCont">
                        <label for="txtDescripcionIncapacidad">Descripción de Incapacidad: &nbsp <i style="color:red;">*</i></label>
                        <div class="frmInput">
                            <textarea data-rule-required="true" data-rule-maxlength="15000"  class="input_data" name="txtDescripcionIncapacidad" placeholder="" id="txtDescripcionIncapacidad"></textarea>
                        </div>
                    </div>
                    <br> Prórroga &nbsp <i style="color:red;">*</i>
                    <div class="fila">
                        <div class="columna--1 columna-hd--1 columna-movil--10 columna-tablet--3">
                            <div class="radio cont-rdo">
                                <div class="rdo">
                                    <input type="radio" id="siProrroga" value="Si" name="rdoPrroga" class="rdoExamenFisicoN">
                                    <label for="siProrroga">Si</label>
                                </div>
                            </div>
                        </div>
                        <div class="columna--1 columna-hd--1 columna-movil--10 columna-tablet--5">
                            <div class="radio cont-rdo">
                                <div class="rdo">
                                    <input type="radio" id="noProrroga" value="No" name="rdoPrroga" class="rdoExamenFisicoA">
                                    <label for="noProrroga">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!--Otro-->
        <div id="Item6" class="fila" style="margin:15px 58px 15px 15px;">
            <div class="panel">
                <div class="panel-cabecera">
                    <center><h3>Otro</h3></center>
                </div>
                <div class="panel-contenido">
                    <div class="fila">
                        <div class="frmCont">
                            <label for="txtDescripcionOtro">Descripcion: &nbsp <i style="color:red;">*</i></label>
                            <div class="frmInput">
                                <textarea data-rule-required="true" class="input_data" name="txtDescripcionOtro" placeholder="" id="txtDescripcionOtro"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



