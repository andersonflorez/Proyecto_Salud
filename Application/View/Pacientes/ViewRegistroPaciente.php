
<div class="n_flex n_justify_center">
  <div class="n_flex n_flex_col95 sm_flex_col90">


    <div class="n_flex n_flex_col100">
      <h1 class="titulo_vista"><span class="fa fa-user-plus"></span> Paciente</h1>
    </div>
    <div class="n_flex n_flex_col100 n_justify_around">

      <div class="n_flex n_flex_col100">
        <div class="panel block">


          <div class="n_flex n_justify_around">
            <div class="n_flex n_flex_col100">
              <div class="contenido">
                <div class="panel block">
                  <div class="panel-cabecera">
                    <h3>Registrar Datos Paciente</h3>
                  </div>
                  <div class="panel-contenido">
                    <form id="FormularioPaciente" method="post" >
                      <div class="n_flex n_justify_around ">


                        <div class="columna--3 columna-hd-3 columna-movil--0 columna-tablet--5"></div>
                      </div>

                      <!--primer n_flex n_justify_around-->

                      <div class="n_flex n_justify_around" >
                        <!--Inicio Select desde bd-->
                        <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45">
                          <div class="frmCont">
                            <label for="SlcTipoDocumento">Tipo Documento<span id="rojo">*</span></label>
                            <div class="frmInput ">
                              <select data-rule-required:"true" data-rule-RE_Select="0" class= " input_data" type="text" name="SlcTipoDocumento" id="SlcTipoDocumento">
                                <option value="0">Seleccione una opción</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <!-- Final Select desde bd-->
                        <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45">
                          <div class="frmCont">
                            <label for="campo1">Número de Documento<span id="rojo">*</span></label>
                            <div class="frmInput">
                              <input data-rule-RE_number_letters="true" class="input_data" data-rule-maxlength="12"  data-rule-required="true"   type="text"    name="txtDocumento" id="txtDocumento" class="frm_input" autocomplete="off">
                            </div>
                          </div>
                        </div>

                        <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45">
                          <div class="frmCont" >
                            <label for="campo1">Fecha de Nacimiento<span id="rojo">*</span></label>
                            <div class="frmInput">
                              <input  class="input_data" data-rule-required="true" type="text" name="txtFechanacimiento" id="txtFechanacimiento" class="frm_input" autocomplete="off" >
                            </div>
                          </div>
                        </div>




                        <!--  fin primer fial-->


                        <!---Segunda fila-->


                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 ">
                      <div class="frmCont" >
                        <label for="campo4">Tipo de Sangre<span id="rojo">*</span></label>
                        <div class="frmInput">
                          <select data-rule-RE_Select="0"  class="input_data"  type="text" class="select"  name="SlcTipoSangre" id="SlcTipoSangre">
                            <option value="0">Seleccione una opción</option>
                            <option value="O+">O-</option>
                            <option value="O+">O+</option>
                            <option value="A-">A−</option>
                            <option value="A+">A+</option>
                            <option value="B-">B−</option>
                            <option value="B+">B+</option>
                            <option value="AB-">AB−</option>
                            <option value="AB+">AB+</option>
                          </select>
                        </div>
                      </div>
                    </div>

                        <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 ">
                          <div class="frmCont" >
                            <label  for="campo3" >Primer Nombre <span id="rojo">*</span></label>
                            <div class="frmInput">
                              <input data-rule-maxlength="15" data-rule-required="true" data-rule-RE_LatinCharacters="true" class="input_data"  type="text" name="txtPrimerNombre" id="txtPrimerNombre" class="frm_input" autocomplete="off" >
                            </div>
                          </div>
                        </div>

                        <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 ">
                          <div class="frmCont">
                            <label  for="campo3" >Segundo Nombre</label>
                            <div class="frmInput">
                              <input data-rule-maxlength="15" ddata-rule-required="false" data-rule-RE_LatinCharacters="true" class="input_data"   type="text"  name="txtSegundoNombre" id="txtSegundoNombre" class="frm_input" autocomplete="off" >
                            </div>
                          </div>
                        </div>


                        <!---Tercer n_flex n_justify_around-->




                        <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 ">
                          <div class="frmCont" >
                            <label for="txtPrimerApellido" >Primer Apellido <span id="rojo">*</span></label>
                            <div class="frmInput">
                              <input  data-rule-maxlength="15" data-rule-required="true" data-rule-RE_LatinCharacters="true" class="input_data"   type="text"  name="txtPrimerApellido"  id="txtPrimerApellido" class="frm_input" autocomplete="off" >
                            </div>
                          </div>
                        </div>

                        <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 ">
                          <div class="frmCont" >
                            <label for="campo3">Segundo Apellido</label>
                            <div class="frmInput">
                              <input data-rule-maxlength="15"  data-rule-required="false" data-rule-RE_LatinCharacters="true" class="input_data"  type="text"  name="txtSegundoApellido" id="txtSegundoApellido" class="frm_input" autocomplete="off" >
                            </div>
                          </div>
                        </div>

                        <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 ">
                          <div class="frmCont" >
                            <label for="campo4">Género<span id="rojo">*</span></label>
                            <div class="frmInput">
                              <select  data-rule-required:"true" data-rule-RE_Select="0"  class="input_data"  type="text" class="select" name="SlcGenero" id="SlcGenero" >
                                <option value="0">Seleccione una opción</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Otro">Otro</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <!---Cuarta n_flex n_justify_around-->





                        <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 ">
                          <div class="frmCont" >
                            <label for="campo4">Estado Civil <span id="rojo">*</span></label>
                            <div class="frmInput">
                              <select data-rule-RE_Select="0"  class="input_data select2"  type="text" name="SlcEstadoCivil" id="SlcEstadoCivil">
                                <option value="0">Seleccione una opción</option>
                                <option value="Soltero(a)">Soltero(a)</option>
                                <option value="Casado(a)">Casado(a)</option>
                                <option value="Dovorciado(a)">Divorciado(a)</option>
                                <option value="Viudo(a)">Viudo(a)</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 ">
                          <div class="frmCont">
                            <label for="txtExtTelefono">Teléfono Fijo - Extensión<span id="rojo">*</span></label>
                            <div class=" frmInput">
                              <input type="text" data-rule-RE_Numbers="true" data-rule-required="true"  data-rule-maxlength="7" class="input_data"  name="txtTelefonoFijo"  id="txtTelefonoFijo" class="frm_input" autocomplete="off" >
                              <div class="aggInput">
                                <input type="text" class="input_data only_numbers quantity_maximun_input" name="txtExt" id="txtExt" placeholder="Ext." autocomplete="off">
                              </div>
                              <span class="aggExt fa fa-plus " id="Ext" ></span>
                            </div>
                          </div>
                        </div>

                        <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 " >
                          <div class="frmCont">
                            <label for="campo3" >Teléfono Celular</label>
                            <div class="frmInput">
                              <input type="text" data-rule-RE_Numbers="true"   data-rule-maxlength="10"  class="input_data"  name="txtTelefonoCelular"  id="txtTelefonoCelular" autocomplete="off" >
                            </div>
                          </div>
                        </div>


                        <!--Quinta n_flex n_justify_around-->



                        <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 " >
                          <div class="frmCont" >
                            <label for="campo3" >Dirección de Residencia <span id="rojo">*</span></label>
                            <div class="frmInput">
                              <input  data-rule-required="true"  data-rule-maxlength="30"  type="text"   class="input_data" name="txtDireccion" id="txtDireccion"  autocomplete="off" >
                            </div>
                          </div>
                        </div>


                        <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 " >
                          <div class="frmCont" >
                            <label for="campo3" >Barrio de Residencia <span id="rojo">*</span></label>
                            <div class="frmInput">
                              <input data-rule-required="true" data-rule-maxlength="15" data-rule-RE_LatinCharacters="true" class="input_data"  type="text" name="txtBarrioR" id="txtBarrioR" autocomplete="off" >
                            </div>
                          </div>
                        </div>

                        <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 " >
                          <div class="frmCont" >
                            <label for="campo3">Ciudad de Residencia <span id="rojo">*</span></label>
                            <div class="frmInput">
                              <input data-rule-required="true" data-rule-maxlength="15"   data-rule-RE_LatinCharacters="true"  type="text"  class="input_data" name="TxtCiudadR"  id="TxtCiudadR" autocomplete="off" >
                            </div>
                          </div>
                        </div>


                        <!--Sexta n_flex n_justify_around-->



                        <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 " >
                          <div class="frmCont" >
                            <label for="campo3" >Correo Electrónico</label>
                            <div class="frmInput">
                              <input   data-rule-maxlength="30"  data-rule-RE_Email="true" name="txtCorreo" id="txtCorreo" class="input_data" autocomplete="off" >
                            </div>
                          </div>
                        </div>


                        <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 " >
                          <div class="frmCont" >
                            <label for="campo3">Empresa Laboral</label>
                            <div class="frmInput">
                              <input  data-rule-maxlength="20" type="text" data-rule-RE_LatinCharacters="true"  name="txtEmpresa" id="txtEmpresa" class="input_data" autocomplete="off" >
                            </div>
                          </div>
                        </div>

                        <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 " >
                          <div class="frmCont">
                            <label for="campo3">Ocupación</label>
                            <div class="frmInput">
                              <input data-rule-maxlength="20"  data-rule-RE_LatinCharacters="true" class="input_data"  type="text" name="txtOcupacion" id="txtOcupacion" class="frm_input" autocomplete="off" >
                            </div>
                          </div>
                        </div>

                        <!--Septima Fila-->

                        <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 " >
                          <div class="frmCont">
                            <label for="campo3">Profesión</label>
                            <div class="frmInput">
                              <input data-rule-maxlength="20"  data-rule-RE_LatinCharacters="true" class="input_data"  type="text"  name="txtProfesion" id="txtProfesion" class="frm_input" autocomplete="off" >
                            </div>
                          </div>
                        </div>

                        <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 ">
                          <div class="frmCont">
                            <label for="campo4">Tipo de Afiliación<span id="rojo">*</span></label>
                            <div class="frmInput ">
                              <select data-rule-required:"true"  data-rule-RE_Select="0"  class="input_data select2"  type="text" name="SlcTipoAfiliacion" id="SlcTipoAfiliacion">
                                <option value="0">Seleccione una opción</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <!--Octava Fila-->

                        <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 ">
                          <div class="frmCont">
                            <label for="campo1">Foto</label>
                            <div class="frmInput">
                              <div class="input_file">
                                <input type="text" class="input_data" disabled="disabled" id="txtfile" placeholder="Seleccione un archivo">
                                <div class="btn_group">
                                  <input data-rule-RE_Image="true"  class="input_data"  type="file"  name="txtUrl" accept="image/*" id="txtUrl" class="frm_input" autocomplete="off">                                  <button type="button" class="btn">Subir</button>
                                </div>
                              </div>
                              <!-- <input type="file" class="input_data" name="txtFoto" id="txtFoto"  data-rule-RE_Image="true" accept="image/*"> -->
                            </div>
                          </div>
                        </div>


                      </div>
                      <br>

                      <!--Novena n_flex n_justify_around -->

                      <div class="n_flex n_justify_around">

                        <div class="n_flex n_flex_col20 md_flex_col sm_flex_col20"></div>

                        <div class="n_flex n_flex_col40 md_flex_col35 sm_flex_col35">
                          <button type="button" class="btn btn-cancelar" id="btnCancelarP" name="btnCancelarP" onclick="location.href='<?=URL?>Pacientes/CtrlPacienteInicial '">Cancelar</button>
                        </div>

                        <div class="n_flex n_flex_col40 md_flex_col35 sm_flex_col35">
                          <button  type="submit" class="btn btn-registrar" id="btnResgistrarPaciente" name="btnResgistrarPaciente">Registrar</button>

                        </div>

                        <div class="n_flex n_flex_col20 md_flex_col0 sm_flex_col20">
                        </div>
                      </div>

                    </form>
                    <div class="n_flex ">
                      <div class="n_flex n_flex_col20 md_flex_col sm_flex_col20"></div>
                      <div class="n_flex n_flex_col40 md_flex_col35 sm_flex_col35">
                        <button  type="submit" class="btn btn-consultar" id="btnLimpiarCampos" name="btnLimpiarCampos" hidden="">Limpiar</button>          <!--Octava n_flex n_justify_around -->
                      </div>
                    </div>
                  </div>
                  <div class="panel-pie">Nota: todos los campos con (*) son obligatorios</div>
                </div>
              </div>

            </div>
          </div>


        </div>
      </div>
    </div>
  </div>
</div>
