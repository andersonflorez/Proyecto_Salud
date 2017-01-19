<div class="n_flex n_justify_center"><!--INICIO n_flex n_justify_center -->
  <div class="n_flex n_flex_col95 sm_flex_col90">  <!-- INICIO  n_flex n_flex_col95 sm_flex_col90 -->

    <!-- TITULO VISTA -->
    <div class="n_flex n_flex_col100"><!--INICIO TITULO PÁGINA-->
      <h1 class="titulo_vista"><span class="fa fa-stethoscope "></span>Gestión de Recursos</h1>
    </div><!--FIN TITULO PÁGINA-->
    <div class="n_flex n_flex_col100 n_justify_around"><!--inicio n_flex n_flex_col100 n_justify_around-->
      <div class="n_flex n_flex_col100 "> <!-- INICIO "n_flex n_flex_col100  -->


        <div class="panel block"><!-- INICIO PANEL BLOCK -->
          <div class="panel-cabecera"><!--INICIO PANEL-CABECERA-->
            <h3>Recursos Registrados</h3>
          </div><!--FIN PANEL-CABECERA-->
          <div class="panel-contenido"><!--INICIO PANEL CONTENIDO -->
            <div class="n_flex"><!-- INICIO n_flex-->
              <div class="n_flex_col100"><!--INICIO n_flex_col100-->
                <div class="tbl_container"id="containerTable"><!--INICIO TBL-CONTAINER-->
                </div><!--FIN TBL-CONTAINER-->
              </div><!--FIN n_flex_col100-->




              <div id="AbrirModalKit"><!--INICIO BOTON MODAL REGISTRO RECURSO-->
                <span  id="" class=" AbrirModalKit fa fa-plus  btn-modal" target="ModalRegistroRecurso" ></span>
              </div><!--FIN BOTON MODAL REGISTRO RECURSO-->
              <div class="modal-ventana whole_wrapper" id="ModalRegistroRecurso"><!--INICIO MODAL REGISTRO RECURSO-->
                <div class="modal relative_element"><!--NICIO modal relative_element-->
                  <div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between">
                    <h2>Registro de Recursos</h2>
                    <span class="btn-cerrar-modal modal-cerrar fa fa-times"></span>
                  </div>
                  <form id="formRegistroRecurso"><!--INICIO FORM REGISTRO RECURSO-->
                    <div class="modal-body"><!-- INICIO MODAL BODY-->
                      <div class="panel block"><!--INICIO PANEL BLOCK-->
                        <div class="panel-contenido">

                          <div class="frmCont">
                            <label for="txtSelect">Nombre:</label>
                            <div class="frmInput">
                              <input type="text"  id="txtnombre" name="nombre" placeholder="Nombre Recurso" class="input_data" data-rule-required="true"  data-rule-maxlength="40"></input>
                            </div>
                          </div>

                          <div class="frmCont">
                            <label>Categoría Recurso:</label>
                            <div class="frmInput">
                              <select  id="slcidCategoriaRecurso" name="idCategoriaRecurso" class="input_data" data-rule-required="true" data-rule-RE_Select="0" >
                                <option value="0">Seleccione una opción</option>
                                <?PHP
                                foreach ($idCategoriaRecurso as $registro) {
                                  echo "<option value='".$registro->idCategoriaRecurso."'>".$registro->descripcionCategoriarecurso."</option>"; }
                                  ?>
                                </select>
                              </div>
                            </div>

                            <div class="frmCont">
                              <label>Cantidad:</label>
                              <div class="frmInput">
                                <input  id="txtcantidadRecurso" name="cantidadRecurso" placeholder="Cantidad Recurso" data-rule-required="true" min="1" class="input_data" type="number" >
                              </div>
                            </div>

                            <div class="frmCont">
                              <label for="txtSelect">Descripción:</label>
                              <div class="frmInput">
                                <textarea type="texarea"  id="txtdescripcion" name="descripcion" placeholder="Descripción" class="input_data" data-rule-required="true"  data-rule-maxlength="10000"></textarea>
                              </div>
                            </div>

                              </div><!--FIN PANEL CONTENIDO-->
                            </div><!--FIN PANEL BLOCK-->
                          </div><!-- FIN MODAL BODY-->
                          <div class="modal-footer n_flex n_justify_end">
                            <button type="button" class="btn-cerrar-modal btn btn-cancelar"  name="button">Cancelar</button>
                            <button  type="button"  class="btn btn-registrar" id="btnRegistrarRecurso">Registrar</button>
                          </div>
                        </form><!--FIN FORM REGISTRO RECURSO-->
                      </div><!--FIN modal relative_element-->
                    </div><!--FIN MODAL REGISTRO RECURSO-->



                    <div class="modal-ventana whole_wrapper" id="ModalActualizarRecurso"><!--INICIO MODAL ACTUALIZAR RECURSO-->
                      <div class="modal relative_element"><!--NICIO modal relative_element-->
                        <div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between">
                          <h2>Actualización de Recursos</h2>
                          <span class="btn-cerrar-modal modal-cerrar fa fa-times"></span>
                        </div>
                        <form id="formModificarRecurso"><!--INICIO FORM ACTUALIZAR RECURSO-->
                          <div class="modal-body"><!-- INICIO MODAL BODY-->
                            <div class="panel block"><!--INICIO PANEL BLOCK-->
                              <div class="panel-contenido">

                                <div class="frmCont">
                                  <label for="txtSelect">ID Registro:</label>
                                  <div class="frmInput">
                                    <input type="text"  id="txtidrecursoA" name="idrecursoA" readonly></input>
                                  </div>
                                </div>

                                <div class="frmCont">
                                  <label for="txtSelect">Nombre:</label>
                                  <div class="frmInput">
                                    <input type="text"  id="txtnombreA" name="nombreA" placeholder="Nombre Recurso" class="input_data" data-rule-required="true"  data-rule-maxlength="40"></input>
                                  </div>
                                </div>

                                <div class="frmCont">
                                  <label>Categoría Recurso:</label>
                                  <div class="frmInput">
                                    <select  id="slcidCategoriaRecursoA" name="idCategoriaRecursoA" class="input_data" data-rule-required="true" data-rule-RE_Select="0" >
                                      <option value="0">Seleccione una opción</option>
                                      <?PHP
                                      foreach ($idCategoriaRecurso as $registro) {
                                        echo "<option value='".$registro->idCategoriaRecurso."'>".$registro->descripcionCategoriarecurso."</option>"; }
                                        ?>
                                      </select>
                                    </div>
                                  </div>

                                  <div class="frmCont">
                                    <label>Cantidad:</label>
                                    <div class="frmInput">
                                      <input  id="txtcantidadRecursoA" name="cantidadRecursoA" placeholder="Cantidad Recurso"data-rule-required="true" data-rule-RE_Numbers="true" min="1" class="input_data only_numbers" type="number" >
                                    </div>
                                  </div>

                                  <div class="frmCont">
                                    <label>Descripción:</label>
                                    <div class="frmInput">
                                      <textarea type="texarea"  id="txtdescripcionA" name="descripcionA" placeholder="Descripción" class="input_data" data-rule-required="true"  data-rule-maxlength="10000"></textarea>
                                    </div>
                                  </div>

                                    </div><!--FIN PANEL CONTENIDO-->
                                  </div><!--FIN PANEL BLOCK-->
                                </div><!-- FIN MODAL BODY-->
                          <div class="modal-footer n_flex n_justify_end">
                            <button type="button" class="btn-cerrar-modal btn btn-cancelar"  name="button">Cancelar</button>
                            <button type="button" id="btnActualizarRecurso" class="btn btn-modificar">Modificar</button>
                          </div>
                        </form><!--FIN FORM ACTUALIZAR RECURSO-->
                      </div><!--FIN modal relative_element-->
                    </div><!--FIN MODAL ACTUALIZAR RECURSO-->



                  </div><!-- FIN n_flex-->
                </div><!--FIN PANEL CONTENIDO -->
              </div><!--FIN PANEL BLOCK-->


            </div><!-- FIN "n_flex n_flex_col100  -->
          </div><!-- FIN n_flex n_flex_col100 n_justify_around -->
        </div><!-- FIN n_flex n_flex_col95 sm_flex_col90-->
      </div><!--FIN n_flex n_justify_center -->
