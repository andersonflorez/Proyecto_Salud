<div class="n_flex n_justify_center" >
  <div class="n_flex n_flex_col95 sm_flex_col90">

    <div class="n_flex n_flex_col100">
      <h1 class="titulo_vista"><span class="fa fa-eye"></span> Paciente</h1>
    </div>
    <div class="n_flex n_flex_col100 n_justify_around">

      <div class="n_flex n_flex_col100">
        <div class="panel block">
          <form  class="block" id="FormularioConsultaPaciente" method="post">
            <div class="n_flex n_justify_around">
              <div class="n_flex n_flex_col100">
                <div class="contenido">
                  <div class="panel block">
                    <div class="panel-cabecera">
                      <h3>Datos Paciente</h3>
                    </div>
                    <div class="panel-contenido">
                      <div class="n_flex n_justify_around n_flex n_justify_center ">
                        <center>
                          <div class="n_flex md_flex_col30 n_flex n_justify_center">
                            <div class="personal-img n_flex n_justify_center ">
                              <!-- <img id="imagenPaciente" src="" alt=""> -->
                                <div class="imgPaciente" id="imagenPaciente"></div>
                            </div>

                          </div>
                        </div>

                        <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col95 ">
                          <div class="n_flex md_flex_col35 sm_flex_col20 lg_flex_col35" ></div>
                          <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col60 xs_flex_col100 ">
                            <div class="frmCont">
                              <label for="campo1">Foto</label>
                              <div class="frmInput">
                                <div class="input_file">
                                  <input  data-rule-RE_Image="true" type="text" name="txtVieja"  id="txtVieja" class="frm_input" autocomplete="off">
                                  <div class="btn_group">
                                    <input data-rule-RE_Image="true"  class="input_data"  type="file"  name="txtUrl" accept="image/*" id="txtUrl" class="frm_input" autocomplete="off">                                  <button type="button" class="btn">Subir</button>
                                  </div>
                                </div>
                                <!-- <input type="file" class="input_data" name="txtFoto" id="txtFoto"  data-rule-RE_Image="true" accept="image/*"> -->
                              </div>
                            </div>
                          </div>
                        </div>
                      </center>
                    </div>

                    <!--primer fila-->

                    <div class="n_flex n_justify_around" >

                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 ">
                        <div class="frmCont" >
                          <label for="campo4">Estado Paciente</label>
                          <div class="frmInput ">
                            <select   name="SlcEstado" id="SlcEstado" class="input_data select2" data-rule-RE_Select="0" >
                              <option value="0">Seleccione una opción</option>
                            </select>
                          </div>
                        </div>
                      </div>


                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 ">
                        <div class="frmCont" >
                          <label for="SlcTipoDocumento">Tipo Documento<span id="rojo">*</span>:</label>
                          <div class="frmInput ">
                            <select data-rule-required="true" class="input_data select2" type="text"  name="SlcTipoDocumento" id="SlcTipoDocumento" disabled data-rule-RE_Select="0">
                              <option value="0">Seleccione una opción</option>

                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 ">
                        <div class="frmCont">
                          <label for="campo1">Número de Documento<span id="rojo">*</span>:</label>
                          <div class="frmInput" >
                            <input data-rule-RE_number_letters="true" class="input_data" data-rule-maxlength="12"  data-rule-required="true"   type="text"  name="txtDocumento" id="txtDocumento" class="input_data" autocomplete="off" >
                          </div>
                        </div>
                      </div>

                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 ">
                        <div class="frmCont" >
                          <label for="campo1">Fecha de Nacimiento</label>
                          <div class="frmInput">
                            <input   data-rule-required="true" type="date" name="txtFechanacimiento" id="txtFechanacimiento" class="frm_input" autocomplete="off" >
                          </div>
                        </div>
                      </div>


                      <!---Segunda fila-->

                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 ">
                                <div class="frmCont" >
                                  <label for="campo4">Tipo de Sangre:</label>
                                  <div class="frmInput">
                                    <select data-rule-RE_Select="0" type="text"   name="SlcTipoSangre" id="SlcTipoSangre" disabled="">
                                      <option value="0">Seleccione una opción</option>
                                      <option value="O+">O-</option>
                                      <option value="O+">O+</option>
                                      <option value="A-">A−</option>
                                      <option value="A+">A+</option>
                                      <option value="B-">B−</option>
                                      <option value="B+">B+</option>
                                      <option value="AB-">AB−</option>
                                      <option value="AB+" >AB+</option>
                                    </select>
                                  </div>
                                </div>
                              </div>

                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 ">
                        <div class="frmCont" >
                          <label  for="campo3" >Primer Nombre<span id="rojo">*</span></label>
                          <div class="frmInput">
                            <input  data-rule-maxlength="15" data-rule-required="true" data-rule-RE_LatinCharacters="true" class="input_data" type="text"  name="txtPrimerNombre" id="txtPrimerNombre" class="input_data" autocomplete="off" >
                          </div>
                        </div>
                      </div>

                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 ">
                        <div class="frmCont">
                          <label  for="campo3" >Segundo Nombre</label>
                          <div class="frmInput">
                            <input  data-rule-maxlength="15"  data-rule-RE_LatinCharacters="true" class="input_data"   type="text" name="txtSegundoNombre" id="txtSegundoNombre" class="input_data" autocomplete="off" >
                          </div>
                        </div>
                      </div>

                      <!---Tercer fila-->

                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 ">
                        <div class="frmCont" >
                          <label for="campo3" >Primer Apellido<span id="rojo">*</span></label>
                          <div class="frmInput">
                            <input  data-rule-maxlength="15" data-rule-required="true" data-rule-RE_LatinCharacters="true" class="input_data"   type="text"  name="txtPrimerApellido"  id="txtPrimerApellido" class="input_data" autocomplete="off">
                          </div>
                        </div>
                      </div>

                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45">
                        <div class="frmCont" >
                          <label for="campo3">Segundo Apellido</label>
                          <div class="frmInput">
                            <input   data-rule-maxlength="15"  data-rule-RE_LatinCharacters="true" class="input_data"  type="text"  name="txtSegundoApellido" id="txtSegundoApellido" class="input_data" autocomplete="off">
                          </div>
                        </div>
                      </div>

                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 ">
                        <div class="frmCont" >
                          <label for="campo4">Género</label>
                          <div class="frmInput ">
                            <select  data-rule-RE_Select="0" type="text"  class="input_data select2" name="SlcGenero" id="SlcGenero" disabled="true">
                              <option value="0">Seleccione una opción</option>
                              <option value="Femenino">Femenino</option>
                              <option value="Masculino">Masculino</option>
                              <option value="Otro">Otro</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <!--otra fila -->
                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 ">
                        <div class="frmCont" >
                          <label for="campo4">Estado Civil<span id="rojo">*</span>:</label>
                          <div class="frmInput ">
                            <select data-rule-RE_Select="0" type="text" class="input_data select2"  name="SlcEstadoCivil" id="SlcEstadoCivil" disabled="">
                              <option value="0">Seleccione una opcion</option>
                              <option value="Soltero(a)">Soltero(a)</option>
                              <option value="Casado(a)">Casado(a)</option>
                              <option value="Dovorciado(a)">Divorciado(a)</option>
                              <option value="Viudo(a)">Viudo(a)</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 ">
                        <div class="frmCont" >
                          <label for="campo1">Teléfono Fijo - Extensión<span id="rojo">*</span></label>
                          <div class=" frmInput">
                            <input type="text" data-rule-RE_Numbers="true" data-rule-required="true"  data-rule-maxlength="7"  name="txtTelefonoFijo"  id="txtTelefonoFijo" class="input_data" autocomplete="off" >
                            <div class="aggInput">
                              <input type="text" class="input_data only_numbers quantity_maximun_input" name="txtExt2" id="txtExt2" placeholder="Ext." autocomplete="off">
                            </div>
                            <span class="aggExt fa fa-plus " id="Ext2" ></span>
                          </div>
                        </div>
                      </div>

                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 " >
                        <div class="frmCont">
                          <label for="campo3" >Teléfono Celular</label>
                          <div class="frmInput">
                            <input  type="text" data-rule-RE_Numbers="true" name="txtTelefonoCelular" id="txtTelefonoCelular" data-rule-maxlength="10"  class="input_data" autocomplete="off" >
                          </div>
                        </div>
                      </div>



                      <!---Cuarta fila-->

                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45" >
                        <div class="frmCont" >
                          <label for="campo3" >Dirección de Residencia<span id="rojo">*</span></label>
                          <div class="frmInput">
                            <input data-rule-required="true"  data-rule-maxlength="30"  type="text"  name="txtDireccion" id="txtDireccion" class="input_data" >
                          </div>
                        </div>
                      </div>


                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45" >
                        <div class="frmCont" >
                          <label for="campo3" >Barrio de Residencia<span id="rojo">*</span></label>
                          <div class="frmInput">
                            <input data-rule-required="true" data-rule-maxlength="15" data-rule-RE_LatinCharacters="true"  type="text" name="txtBarrioR" id="txtBarrioR" class="input_data" autocomplete="off" >
                          </div>
                        </div>
                      </div>


                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45" >
                        <div class="frmCont" >
                          <label for="campo3">Ciudad de Residencia<span id="rojo">*</span></label>
                          <div class="frmInput">
                            <input data-rule-required="true" data-rule-maxlength="15"   data-rule-required="false" data-rule-RE_LatinCharacters="true"  type="text" name="TxtCiudadR"  id="TxtCiudadR" class="input_data" autocomplete="off" >
                          </div>
                        </div>
                      </div>


                      <!--Quinta fila-->


                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 " >
                        <div class="frmCont" >
                          <label for="campo3" >Correo Electrónico</label>
                          <div class="frmInput">
                            <input data-rule-required="false" data-rule-maxlength="30"  data-rule-RE_Email="true" type="email"  name="txtCorreo" id="txtCorreo" class="input_data" autocomplete="off" >
                          </div>
                        </div>
                      </div>


                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45" >
                        <div class="frmCont" >
                          <label for="campo3">Empresa Laboral</label>
                          <div class="frmInput">
                            <input data-rule-maxlength="20" type="text"  name="txtEmpresa" id="txtEmpresa" class="input_data" autocomplete="off" data-rule-RE_LatinCharacters="true">
                          </div>
                        </div>
                      </div>

                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45" >
                        <div class="frmCont">
                          <label for="campo3" >Ocupación</label>
                          <div class="frmInput">
                            <input data-rule-maxlength="20" data-rule-required="false" data-rule-RE_LatinCharacters="true" type="text"  name="txtOcupacion" id="txtOcupacion" class="input_data" autocomplete="off" >
                          </div>
                        </div>
                      </div>

                      <!--Sexta fila-->


                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 " >
                        <div class="frmCont">
                          <label for="campo3">Profesión</label>
                          <div class="frmInput">
                            <input data-rule-maxlength="20"   data-rule-required="false" data-rule-RE_LatinCharacters="true" type="text"  name="txtProfesion" id="txtProfesion" class="input_data" autocomplete="off">
                          </div>
                        </div>
                      </div>

                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45">
                        <div class="frmCont">
                          <label for="campo4">Tipo de Afiliación<span id="rojo">*</span></label>
                          <div class="frmInput ">
                            <select data-rule-RE_Select="0" type="text"  class="input_data select2" name="SlcTipoAfiliacion" id="SlcTipoAfiliacion" disabled>
                              <option value="0">Seleccione una opción</option>

                            </select>
                          </div>
                        </div>
                      </div>


                      <!--ultima fila-->

                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 " >
                        <div class="frmCont" >
                          <label for="campo1" >Fecha de Afiliación</label>
                          <div class="frmInput">
                            <input  type="date" name="txtFechaAfili" id="txtFechaAfili" class="frm_input" autocomplete="off">
                          </div>
                        </div>
                      </div>




                      <div class="n_flex n_flex_col100 md_flex_col30 sm_flex_col45 " >
                        <div class="frmCont" >
                          <label for="campo3">Edad</label>
                          <div class="frmInput">
                            <input  type="number"  class="input_data"  name="txtEdad" id="txtEdad" autocomplete="off" >
                            <input   name="txtid" id="txtid" class="frm_input" autocomplete="off" type="" hidden >
                          </div>
                        </div>
                      </div>

                    </div>

                    <br>


                    <!--Septima fila-->

                    <div class="n_flex n_justify_around">

                      <div class="n_flex n_flex_col20 md_flex_col sm_flex_col20"></div>

                      <div class="n_flex n_flex_col40 md_flex_col35 sm_flex_col35">
                        <button type="button" class="btn btn-cancelar" id="btnCancelar" onclick="location.href='<?=URL?>Pacientes/CtrlPacienteInicial'" hidden="">Cancelar</button>
                      </div>



                      <div class="n_flex n_flex_col40 md_flex_col35 sm_flex_col35">
                        <button type="button" id="btnActualizarPaciente" class="btn btn-consultar">Editar</button>
                        <button type="submit" id="btnGuardarDatos" class="btn btn-modificar" hidden="">Modificar</button>

                      </div>

                      <div class="n_flex n_flex_col20 md_flex_col0 sm_flex_col20">

                      </div>

                    </div>

                    <!--Octava fila-->

                  </div>
                  <div class="panel-pie">Nota: En este espacio se pueden modificar los campos del paciente (si se requiere).</div>

                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
