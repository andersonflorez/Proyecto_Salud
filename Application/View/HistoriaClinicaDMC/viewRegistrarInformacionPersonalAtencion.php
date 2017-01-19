<!-- FLECHA DERECHA -->
<form id="frmInformacionPersonalAtencion">
    <button type="submit" title="Siguiente" class="flecha-der">
        <li class="fa fa-long-arrow-right"></li>
    </button>

    <div class="n_flex n_justify_center">
        <div class="n_flex n_flex_col95 sm_flex_col90">
            <div class="n_flex n_flex_col100 n_justify_around">
                <h1 class="titulo_vista"><span class="fa fa-edit"></span>Paciente</h1>

                <div class="n_flex_col100 md_flex_col100 lg_flex_col50 xl_flex_col50 xxl_flex_col50  horizontal_padding n_in_columns">

                    <div class="panel block">

                        <div class="panel-cabecera">
                            <center>
                                <h3>Información Personal</h3>
                            </center>
                        </div>
                        <div class="panel-contenido scroll-panel">
                            <div class="fila">
                                <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                                    <div class="frmCont">
                                        <label for="txtTipoDocumento">Tipo documento</label>
                                        <input type="text" id="txtTipoDocumento" disabled value="<?php echo $queryInformacionPersonal->descripcionTdocumento ?>">
                                    </div>
                                </div>
                                <div class="columna-1 columna-hd-1"></div>
                                <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                                    <div class="frmCont">
                                        <label for="txtNumeroDocumento">Número documento</label>
                                        <input disabled value="<?php echo $queryInformacionPersonal->numeroDocumento ?>" type="text" id="txtNumeroDocumento">
                                    </div>
                                </div>
                            </div>

                            <div class="fila">
                                <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                                    <div class="frmCont">
                                        <label for="txtNombre1">1er nombre</label>
                                        <input disabled value="<?php echo $queryInformacionPersonal->primerNombre ?>" type="text" id="txtNombre1">
                                    </div>
                                </div>
                                <div class="columna-1 columna-hd-1"></div>
                                <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                                    <div class="frmCont">
                                        <label for="txtNombre2">2do nombre</label>
                                        <input disabled value="<?php echo $queryInformacionPersonal->segundoNombre ?>" type="text" id="txtNombre2">
                                    </div>
                                </div>
                            </div>

                            <div class="fila">
                                <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                                    <div class="frmCont">
                                        <label for="txtApellido1">1er apellido</label>
                                        <input disabled value="<?php echo $queryInformacionPersonal->primerApellido ?>" type="text" id="txtApellido1">
                                    </div>
                                </div>
                                <div class="columna-1 columna-hd-1"></div>
                                <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                                    <div class="frmCont">
                                        <label for="txtApellido2">2do apellido</label>
                                        <input disabled value="<?php echo $queryInformacionPersonal->segundoApellido ?>" type="text" id="txtApellido2">
                                    </div>
                                </div>
                            </div>

                            <div class="fila">
                                <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                                    <div class="frmCont">
                                        <label for="txtFechaNacimiento">Fecha nacimiento:</label>
                                        <input disabled value="<?php echo $queryInformacionPersonal->fechaNacimiento ?>" type="date" id="txtFechaNacimiento">
                                    </div>
                                </div>
                                <div class="columna-1 columna-hd-1"></div>
                                <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                                    <div class="frmCont">
                                        <label for="txtTipoSangre">Tipo sangre</label>
                                        <input disabled value="<?php echo $queryInformacionPersonal->tipoSangre ?>" type="text" id="txtTipoSangre">
                                    </div>
                                </div>
                            </div>
                            <div class="fila">
                                <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                                    <div class="frmCont">
                                        <label for="txtGenero">Género</label>
                                        <input disabled value="<?php echo $queryInformacionPersonal->genero ?>" type="text" id="txtGenero">
                                    </div>
                                </div>
                                <div class="columna-1 columna-hd-1"></div>
                                <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                                    <div class="frmCont">
                                        <label for="campo6 cmbEstadoCivil">Estado civil</label>
                                        <div class="frmInput frmInput_select2">
                                            <select class="input_data select" id="cmbEstadoCivil" name="cmbEstadoCivil">
                                                <option value="Soltero(a)">Soltero(a)</option>
                                                <option value="Casado(a)">Casado(a)</option>
                                                <option value="Dovorciado(a)">Divorciado(a)</option>
                                                <option value="Viudo(a)">Viudo(a)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="fila">
                                <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                                    <div class="frmCont">
                                        <label for="txtCiudadResidencia">Ciudad residencia &nbsp <i style="color:red;">*</i></label>
                                        <div class="frmInput">
                                            <input value="<?php echo $queryInformacionPersonal->ciudadResidencia ?>" type="text" class="input_data" data-rule-required="true" data-rule-RE_LatinCharacters="true" data-rule-maxlength="45" id="txtCiudadResidencia" name="txtCiudadResidencia" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="columna-1 columna-hd-1"></div>
                                <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                                    <div class="frmCont">
                                        <label for="txtBarrioResidencia">Barrio residencia &nbsp <i style="color:red;">*</i></label>
                                        <div class="frmInput">
                                            <input value="<?php echo $queryInformacionPersonal->barrioResidencia ?>" type="text" class="input_data" data-rule-required="true" data-rule-RE_LatinCharacters="true" data-rule-maxlength="45" id="txtBarrioResidencia" name="txtBarrioResidencia" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="fila">
                                <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                                    <div class="frmCont">
                                        <label for="txtDireccion">Dirección &nbsp <i style="color:red;">*</i></label>
                                        <div class="frmInput">
                                            <input value="<?php echo $queryInformacionPersonal->direccion ?>" type="text" data-rule-maxlength="45" class="input_data" data-rule-required="true" id="txtDireccion" name="txtDireccion" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="columna-1 columna-hd-1"></div>
                                <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                                    <div class="frmCont">
                                        <label for="txtCorreoElectronico">Correo electrónico</label>
                                        <div class="frmInput">
                                            <input value="<?php echo $queryInformacionPersonal->correoElectronico ?>" class="input_data" type="text" data-rule-RE_Email="true"  data-rule-maxlength="45" id="txtCorreoElectronico" name="txtCorreoElectronico" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="fila">
                                <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                                    <div class="frmCont">
                                        <label for="txtTelefonoFijo">Ext(+)Teléfono fijo &nbsp <i style="color:red;">*</i></label>
                                        <div class="frmInput">
                                            <input value="<?php echo $queryInformacionPersonal->telefonoFijo ?>" type="text" class="input_data" data-rule-required="true" data-rule-RE_Numbers="true" data-rule-maxlength="15" id="txtTelefonoFijo" name="txtTelefonoFijo" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="columna-1 columna-hd-1"></div>
                                <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                                    <div class="frmCont">
                                        <label for="txtTelefonoCelular">Teléfono celular</label>
                                        <div class="frmInput">
                                            <input value="<?php echo $queryInformacionPersonal->telefonoMovil ?>" type="text" class="input_data" data-rule-RE_Numbers="true" id="txtTelefonoCelular" data-rule-maxlength="20" name="txtTelefonoCelular" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="fila">
                                <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                                    <div class="frmCont">
                                        <label for="txtEmpresa">Empresa</label>
                                        <div class="frmInput">
                                            <input value="<?php echo $queryInformacionPersonal->empresa ?>" type="text" class="input_data" data-rule-required="true" data-rule-maxlength="45" id="txtEmpresa" name="txtEmpresa" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="columna-1 columna-hd-1"></div>
                                <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                                    <div class="frmCont">
                                        <label for="txtOcupacion">Ocupación</label>
                                        <div class="frmInput">
                                            <input value="<?php echo $queryInformacionPersonal->ocupacion ?>" type="text" class="input_data" data-rule-RE_LatinCharacters="true" data-rule-maxlength="45" id="txtOcupacion"  name="txtOcupacion" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="fila">
                                <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                                    <div class="frmCont">
                                        <label for="txtProfesion">Profesión</label>
                                        <input disabled value="<?php echo $queryInformacionPersonal->profesion ?>" type="text" id="txtProfesion">
                                    </div>
                                </div>
                                <div class="columna-1 columna-hd-1"></div>
                                <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                                    <div class="frmCont">
                                        <label for="txtTipoAfiliacion">Tipo afiliacion</label>
                                        <input disabled value="<?php echo $queryInformacionPersonal->descripcionAfiliacion ?>" type="text" id="txtTipoAfiliacion">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="n_flex_col100 md_flex_col100 lg_flex_col50 xl_flex_col50 xxl_flex_col50  horizontal_padding n_in_columns">
                    <div class="panel block">

                        <div class="panel-cabecera">
                            <center>
                                <h3>Atención</h3>
                            </center>
                        </div>
                        <div class="panel-contenido scroll-panel">
                            <div class="frmCont">
                                <label for="cmbOrigenAtencion">Origen atención&nbsp <i style="color:red;">*</i></label>
                                <div class="frmInput frmInput_select2">
                                    <select class="select input_data" id="cmbOrigenAtencion" name="cmbOrigenAtencion" data-rule-RE_Select="0">
                                        <option></option>
                                        <?PHP
    foreach($tiposOrigen as $registro){
        echo '<option value="'.$registro->idTipoOrigenAtencion.'">'.$registro->descripcionorigenAtencion.'</option>';
    }
                                        ?>
                                        <option value="otro">Otro</option>
                                    </select>
                                </div>
                            </div>


                            <div class="frmCont">
                                <label for="campo1">Motivo Consulta&nbsp <i style="color:red;">*</i></label>
                                <div class="frmInput">
                                    <textarea name="txtMotivoConsulta" class="input_data" id="txtMotivoConsulta" name="txtMotivoConsulta" data-rule-maxlength="25000" data-rule-required="true"></textarea>
                                </div>
                            </div>

                            <div class="frmCont">
                                <label for="campo1">Enfermedad Actual&nbsp <i style="color:red;">*</i></label>
                                <div class="frmInput">
                                    <textarea name="txtEnfermedadActual" class="input_data" id="txtEnfermedadActual" name="txtEnfermedadActual"  data-rule-maxlength="25000" data-rule-required="true"></textarea>
                                </div>
                            </div>
                            <div class="frmCont">
                                <label for="campo1">Evolución&nbsp <i style="color:red;">*</i></label>
                                <div class="frmInput">
                                    <textarea name="txtEvolucion" class="input_data" id="txtEvolucion" name="txtEvolucion" data-rule-maxlength="25000" data-rule-required="true"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

