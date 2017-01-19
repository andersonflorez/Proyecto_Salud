
<div class="n_flex n_justify_center"><!--INICIO n_flex n_justify_center -->
  <div class="n_flex n_flex_col95 sm_flex_col90">  <!-- INICIO  n_flex n_flex_col95 sm_flex_col90 -->

    <!-- TITULO VISTA -->
    <div class="n_flex n_flex_col100"><!--INICIO TITULO PÁGINA-->
      <h1 class="titulo_vista"><span class="fa fa-suitcase"></span>Kit Estándar</h1>
    </div><!--FIN TITULO PÁGINA-->
    <div class="n_flex n_flex_col100 n_justify_around"><!--inicio n_flex n_flex_col100 n_justify_around-->
      <div class="n_flex n_flex_col100 md_flex_col85 sm_flex_col45"> <!-- INICIO "n_flex n_flex_col100  -->

        <div class="panel block"><!-- INICIO PANEL BLOCK -->
          <div class="panel-cabecera"><!--INICIO PANEL-CABECERA-->
            <h3>Listado de Kits Estándar</h3>
          </div><!--FIN PANEL-CABECERA-->
          <div class="panel-contenido"><!--INICIO PANEL CONTENIDO -->
            <div class="n_flex"><!-- INICIO n_flex-->
              <div class="n_flex_col100"><!--INICIO n_flex_col100-->
                <div class="tbl_container" id="containerTable"><!--INICIO TBL-CONTAINER-->

                </div><!--FIN TBL-CONTAINER-->
              </div><!--FIN n_flex_col100-->


              <div class="modal-ventana whole_wrapper" id="ModalRegistroKit"><!--INICIO MODAL REGISTRO KIT-->
                <div class="modal relative_element"><!--NICIO modal relative_element-->
                  <div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between">
                    <h2>Registro Recurso de Kit</h2>
                    <span class="btn-cerrar-modal modal-cerrar fa fa-times"></span>
                  </div>
                  <form id="formRegistroKit"><!--INICIO FORM ACTUALIZAR KIT-->
                    <div class="modal-body"><!-- INICIO MODAL BODY-->
                      <div class="panel block"><!--INICIO PANEL BLOCK-->
                        <div class="panel-contenido">

                          <div class="frmCont">
                            <label for="txtSelect">Tipo Kit:</label>
                            <div class="frmInput">
                              <select class="input_data" id="slctipokit" name="tipokit" data-rule-required="true" data-rule-RE_Select="0">
                                <option value="0">Seleccione una opción</option>
                                <?PHP
                                foreach ($tipoKit as $registro) {
                                  echo "<option value='".$registro->idTipoKit."'>".$registro->descripcionTipoKit."</option>"; }
                                  ?>
                                </select>
                              </div>
                            </div>

                            <div class="frmCont">
                              <table class="table table-bordered table-hover tbl_scroll" id="tab_logic">
                                <thead><th>N.</th><th>Recurso</th><th>Stock Mínimo</th><th>Unidad de Medida</th></thead>
                              </table>
                              <br>
                              <button type="button" class="btn btn-registrar" id="add_row">+</button>
                              <button type="button" class="btn btn-eliminar" id="delete_row">x</button>
                            </div>




                          </div><!--FIN PANEL CONTENIDO-->
                        </div><!--FIN PANEL BLOCK-->
                      </div><!-- FIN MODAL BODY-->

                      <div class="modal-footer n_flex n_justify_end">
                        <button type="button" class="btn-cerrar-modal btn btn-cancelar"  name="button">Cancelar</button>
                        <button  type="button"  class="btn btn-registrar" id="btnRegistrarKit">Registrar</button>
                      </div>

                    </form><!--FIN FORM ACTUALIZAR KIT-->
                  </div><!--FIN modal relative_element-->
                </div><!--FIN MODAL REGISTRO KIT-->


                <div class="tbl_container" id="containerFormActualizarKit"><!--INICIO TBL-CONTAINER FORM ACTUALIZARKIT-->
                  <div class="panel-contenido" ><!--INICIO PANEL CONTENIDO -->
                    <form id="formModificarKit" ><!--INICIO FORM ACTUALIZAR KIT-->

                      <div class="n_flex n_justify_around" ><!--inicio primera fila-->

                        <div class="n_flex_col100 n_flex_col30 sm_flex_col30"><!--inicio n_flex-->
                          <div class="frmCont">
                            <label>ID Registro:</label>
                            <div class="frmInput">
                              <input type="text" class="input_data" id="txtidEstandarKitA"  name="idEstandarkitA" placeholder="ID Registro" readonly>
                            </div>
                          </div>
                        </div><!-- fin n_flex-->
                        <div class="n_flex_col100 n_flex_col30 sm_flex_col30"><!--inicio n_flex-->
                          <div class="frmCont">
                            <label for="txtSelect2">Recurso:</label>
                            <div class="frmInput frmInput_select2">
                              <select class="select input_data" id="slcidRecursoA" name="idRecursoA" data-rule-required="true" data-rule-RE_Select="-1">
                                <option value="-1">Seleccione una opción</option>
                                <?PHP
                                foreach ($idRecurso as $registro) {
                                  echo "<option value='".$registro->idrecurso."'>".$registro->nombre."</option>"; }
                                  ?>
                                </select>
                              </div>
                            </div>
                          </div><!-- fin n_flex-->
                          <div class="n_flex_col100 n_flex_col30 sm_flex_col30"><!--inicio n_flex-->
                            <div class="frmCont">
                              <label>Stock Mínimo:</label>
                              <div class="frmInput">
                                <input data-rule-required="true" data-rule-RE_Numbers="true" min="1" class="input_data" type="number"  class="only_numbers" id="txtstockminKitA" name="stockminKitA" placeholder="Stock Mínimo">
                              </div>
                            </div>
                          </div><!-- fin n_flex-->
                        </div><!--fin primera fila-->


                        <div class="n_flex n_justify_around" ><!--inicio primera fila-->
                          <div class=" n_flex_col100 n_flex_col45 sm_flex_col45"><!--inicio n_flex-->
                            <div class="frmCont">
                              <label for="txtSelect2">Unidad De Medida:</label>
                              <div class="frmInput frmInput_select2">
                                <select class="select input_data" id="slcunidadMedidaA" name="unidadMedidaA" data-rule-required="true" data-rule-RE_Select="-1">
                                  <option value="-1">Seleccione una opción</option>
                                  <option value="Und">Unidad</option>
                                  <option value="ml">Mililitro</option>
                                  <option value="cl">Centilitro</option>
                                  <option value="dl">Decilitro</option>
                                  <option value="L">Litro</option>
                                  <option value="Dl">Decalitro</option>
                                  <option value="Hl">Hectolitro</option>
                                  <option value="Kl">Kilolitro</option>
                                  <option value="Ml">Mirialitro</option>
                                  <option value="mg">Miligramos</option>
                                  <option value="gr">Gramos</option>
                                </select>
                              </div>
                            </div>
                          </div><!-- fin n_flex-->

                          <div class=" n_flex_col100 n_flex_col45 sm_flex_col45"><!--inicio n_flex-->
                            <div class="frmCont">
                              <label for="txtSelect2">Tipo Kit:</label>
                              <div class="frmInput frmInput_select2">
                                <select class="select input_data" id="slctipokitA" name="tipokitA" data-rule-required="true" data-rule-RE_Select="-1">
                                  <option value="-1">Seleccione una opción</option>
                                  <?PHP
                                  foreach ($tipoKit as $registro) {
                                    echo "<option value='".$registro->idTipoKit."'>".$registro->descripcionTipoKit."</option>"; }
                                    ?>
                                  </select>
                                </div>
                              </div>
                            </div><!-- fin n_flex-->
                          </div><!--fin primera fila-->

                          <button type="button" id="btnCancelar" class=" btn btn-cancelar"  name="button">Cancelar</button>
                          <button type="button" id="btnActualizarKits" class="btn btn-modificar">Modificar</button>

                        </form><!--FIN FORM ACTUALIZAR KIT-->
                      </div>
                    </div><!--FIN TBL-CONTAINER FORM ACTUALIZARKIT-->





                    <div class="tbl_container" id="containerTableRecursos"><!--INICIO TBL-CONTAINER2-->

                    </div><!--FIN TBL-CONTAINER2-->


                  </div><!-- FIN n_flex-->
                </div><!--FIN PANEL CONTENIDO -->
              </div><!--FIN PANEL BLOCK-->


            </div><!-- FIN "n_flex n_flex_col100  -->
          </div><!-- FIN n_flex n_flex_col100 n_justify_around -->
        </div><!-- FIN n_flex n_flex_col95 sm_flex_col90-->
      </div><!--FIN n_flex n_justify_center -->
