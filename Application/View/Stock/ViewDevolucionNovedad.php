
<div class="n_flex n_justify_center"><!--INICIO n_flex n_justify_center -->
  <div class="n_flex n_flex_col95 sm_flex_col90">  <!-- INICIO  n_flex n_flex_col95 sm_flex_col90 -->
    <!-- TITULO VISTA -->
    <div class="n_flex n_flex_col100"><!--INICIO TITULO PÁGINA-->
      <h1 class="titulo_vista"><span class="fa fa-reply-all"></span>Gestión de Devoluciones</h1>
    </div><!--FIN TITULO PÁGINA-->
    <div class="n_flex n_flex_col100 n_justify_around"><!--inicio n_flex n_flex_col100 n_justify_around-->
      <div class="n_flex n_flex_col100 md_flex_col90 sm_flex_col45"> <!-- INICIO "n_flex n_flex_col100  -->

        <div class="panel block"><!-- INICIO PANEL BLOCK -->
          <div class="panel-cabecera"><!--INICIO PANEL-CABECERA-->
            <h3>Consultar Asignación</h3>
          </div><!--FIN PANEL-CABECERA-->
          <div class="panel-contenido" ><!--INICIO PANEL CONTENIDO -->

            <form id="formConsultaAsignacion"><!--inicio formulario Confirmar datos-->

              <div class="n_flex n_justify_around" ><!--inicio primera fila-->

                <div class="n_flex_col100 md_flex_col40"><!--inicio n_flex-->
                  <div class="frmCont">
                    <label for="txtSelect2">Fecha Asignación*:</label>
                    <div class="frmInput ">
                      <input class="input_data" data-rule-required="true" type="text" name="fechaHoraAsignacion" id="txtfechaHoraAsignacion" class="frm_input" autocomplete="off" >

                    </div>
                  </div>
                </div><!-- fin n_flex-->

                <div class="n_flex_col100 md_flex_col40"><!--inicio n_flex-->
                  <div class="frmCont">
                    <label for="txtSelect2">Asignado A*:</label>
                    <div class="frmInput frmInput_select2">
                      <select type="text"   class="select input_data" name="asignacion" id="slcasignacion" data-rule-required="true" data-rule-RE_Select="0">
                        <option value="0">Seleccione una opción</option>
                        <option value="1">Médico</option>
                        <option value="2">Paciente</option>
                        <option value="3">Ambulancia</option>
                      </select>
                    </div>
                  </div>
                </div><!-- fin n_flex-->

              </div><!--fin primera fila-->

              <div class="n_flex n_justify_around" ><!--inicio primera fila-->
                <div class="n_flex n_flex_col100 md_flex_col40"><!--inicio n_flex-->
                  <div class="frmCont Cambiar" id="medico">
                    <label for="txtSelect2">Documento Médico:</label>
                    <div class="frmInput frmInput_select2">
                      <select type="text"  class="select input_data" name="idPersona" id="slcidPersona" data-rule-required="true" data-rule-RE_Select="-1">
                        <option value="-1">Seleccione una opción.</option>
                        <?PHP
                        foreach ($idPersona as $registro) {
                          echo "<option value='".$registro->idPersona."'>".$registro->numeroDocumento."</option>"; }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div><!-- fin n_flex-->
                </div><!--fin primera fila-->
                <div class="n_flex n_justify_around" ><!--inicio primera fila-->
                  <div class="n_flex n_flex_col100 md_flex_col40"><!--inicio n_flex-->
                    <div class="frmCont Cambiar" id="paciente">
                      <label for="txtSelect2">Documento Paciente:</label>
                      <div class="frmInput frmInput_select2">
                        <select type="text"  class="select input_data" name="idPaciente" id="slcidPaciente" data-rule-required="true" data-rule-RE_Select="-1">
                          <option value="-1">Seleccione una opción</option>
                          <?PHP
                          foreach ($idPaciente as $registro) {
                            echo "<option value='".$registro->idPaciente."'>".$registro->numeroDocumento."</option>"; }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div><!-- fin n_flex-->
                  </div><!--fin primera fila-->
                  <div class="n_flex n_justify_around" ><!--inicio primera fila-->
                    <div class="n_flex n_flex_col100 md_flex_col40"><!--inicio n_flex-->
                      <div class="frmCont Cambiar" id="ambulancia">
                        <label for="txtSelect2">Placa Ambulancia:</label>
                        <div class="frmInput frmInput_select2">
                          <select type="text"   class="input_data select" name="idAmbulancia" id="slcidAmbulancia" data-rule-required="true" data-rule-RE_Select="-1">
                            <option value="-1">Seleccione una opción</option>
                            <?PHP
                            foreach ($idAmbulancia as $registro) {
                              echo "<option value='".$registro->idAmbulancia."'>".$registro->placaAmbulancia."</option>"; }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div><!-- fin n_flex-->
                    </div><!--fin primera fila-->

                    <button type="button" class="btn btn-consultar" id="btnconfirmarAsignacion">Confirmar</button>


                  </form><!--Fin formulario Confirmar datos-->



                  <form id="formRegistroDevolucion"><!--inicio formulario Registrar Devolucion-->
                    <div class="n_flex n_justify_around" ><!--inicio primera fila-->
                      <div class="n_flex_col100 md_flex_col40"><!--inicio n_flex-->
                        <div class="frmCont">
                          <label for="txtSelect2">Documento Médico:</label>
                          <div class="frmInput frmInput_select2">
                            <select type="text"  data-rule-RE_Select="-1" class="select input_data" name="idPersona" id="slcidPersonaD">
                              <option value="-1">Seleccione una opción.</option>
                              <?PHP
                              foreach ($idPersona as $registro) {
                                echo "<option value='".$registro->idPersona."'>".$registro->numeroDocumento."</option>"; }
                                ?>
                              </select>
                            </div>
                          </div>
                        </div><!-- fin n_flex-->
                        <div class="n_flex_col100 md_flex_col40"><!--inicio n_flex-->
                          <div class="frmCont">
                            <label for="txtSelect2">Tipo de Devolución:</label>
                            <div class="frmInput frmInput_select2">
                              <select type="text"  data-rule-RE_Select="-1" class="select input_data" name="idTipoDevolucion" id="slcidTipoDevolucionD">
                                <option value="-1">Seleccione una opción.</option>
                                <?PHP
                                foreach ($idTipoDevolucion as $registro) {
                                  echo "<option value='".$registro->idTipoDevolucion."'>".$registro->descripcionDevolucion."</option>"; }
                                  ?>
                                </select>
                              </div>
                            </div>
                          </div><!-- fin n_flex-->
                          <div class="contenedor-btn-registrar">
                          </div>

                        </div><!--fin primera fila-->
                      </form><!--Fin formulario Registrar Devolucion-->

                      <div class="n_flex n_flex_col100 md_flex_col50 sm_flex_col45 tbl_container" id="containerTable"><!--inicio n_flex-->
                      </div><!-- fin n_flex-->


                      <div class="modal-ventana whole_wrapper" id="ModalRegistroNovedad"><!--INICIO MODAL REGISTRO NOVEDAD-->
                        <div class="modal relative_element"><!--NICIO modal relative_element-->
                          <div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between">
                            <h2>Registro de Novedad</h2>
                            <span class="btn-cerrar-modal modal-cerrar fa fa-times"></span>
                          </div>
                          <form id="formRegistroNovedad"><!--INICIO FORM ACTUALIZAR NOVEDAD-->
                            <div class="modal-body"><!-- INICIO MODAL BODY-->
                              <div class="panel block"><!--INICIO PANEL BLOCK-->
                                <div class="panel-contenido">

                                  <div class="frmCont">
                                    <label>Detalle Kit:</label>
                                    <div class="frmInput">
                                      <input id="txtidDetallekit" name="idDetallekit" class="input_data" data-rule-required="true" readonly/>
                                    </div>
                                  </div>

                                  <div class="frmCont">
                                    <label>Tipo Novedad:</label>
                                    <div class="frmInput">
                                      <select  id="slcidTipoNovedad" name="idTipoNovedad" class="input_data" data-rule-required="true" data-rule-RE_Select="0" >
                                        <option value="0">Seleccione una opción</option>
                                        <?PHP
                                        foreach ($idTipoNovedad as $registro) {
                                          echo "<option value='".$registro->idTipoNovedad."'>".$registro->descripcionTiponovedad."</option>"; }
                                          ?>
                                        </select>
                                      </div>
                                    </div>

                                    <div class="frmCont">
                                      <label for="txtSelect">Persona:</label>
                                      <div class="frmInput">
                                        <select  id="slcidPersonaNovedad" name="idPersona" class="input_data" data-rule-required="true" data-rule-RE_Select="0">
                                          <option value="0">Seleccione una opción</option>
                                          <?PHP
                                          foreach ($idPersona as $registro) {
                                            echo "<option value='".$registro->idPersona."'>".$registro->numeroDocumento."</option>"; }
                                            ?>
                                          </select>
                                        </div>
                                      </div>

                                      <div class="frmCont">
                                        <label for="txtSelect">Descripción Novedad:</label>
                                        <div class="frmInput">
                                          <textarea type="texarea"  id="txtdescripcionNovedad" name="descripcionNovedad" placeholder="Descripción Novedad" class="input_data" data-rule-required="true"  data-rule-maxlength="10000"></textarea>
                                        </div>
                                      </div>

                                    </div><!--FIN PANEL CONTENIDO-->
                                  </div><!--FIN PANEL BLOCK-->
                                </div><!-- FIN MODAL BODY-->
                                <div class="modal-footer n_flex n_justify_end">
                                  <button type="button" class="btn-cerrar-modal btn btn-cancelar"  name="button">Cancelar</button>
                                  <button  type="button"  class="btn btn-registrar" id="btnRegistrarNovedad">Registrar</button>
                                </div>
                              </form><!--FIN FORM ACTUALIZAR NOVEDAD-->
                            </div><!--FIN modal relative_element-->
                          </div><!--FIN MODAL REGISTRO NOVEDAD-->



                        </div><!--FIN PANEL CONTENIDO -->
                      </div><!--FIN PANEL BLOCK-->
                    </div><!-- FIN "n_flex n_flex_col100  -->
                  </div><!-- FIN n_flex n_flex_col100 n_justify_around -->
                </div><!-- FIN n_flex n_flex_col95 sm_flex_col90-->
              </div><!--FIN n_flex n_justify_center -->
