<!-- CONTENIDO -->
<div class="n_flex n_justify_center">

  <!-- CONTENIDO VISTA -->
  <div class="n_flex n_flex_col95 sm_flex_col90">

    <!-- TITULO VISTA -->
    <div class="n_flex n_flex_col100">

      <h1 class="titulo_vista"><span class=" fa fa-cogs"></span>Configuración</h1>
    </div>
    <div class="n_flex n_flex_col100 n_justify_around">

      <!-- CONTENEDOR PRINCIPAL IZQUIERDO -->
      <div class="n_flex n_flex_col100  xl_flex_col100 lg_flex_col100 horizontal_padding n_in_columns">

        <!-- GRID -->
        <div class="panel block">
          <div class="panel-cabecera">
            <h3>Configuración de Cup</h3>
          </div>
          <div class="panel-contenido">

            <article class="block">
              ​<div class="tbl_container"><!--INICIO TBL-CONTAINER-->

                <form id="frmModalCup">


                  <div class="panel-contenido">

                    <div class="n_flex">
                      <div class="lg_flex_col25"></div>
                      <div class="n_flex_col100 lg_flex_col50 sm_flex_col100 xs_flex_col100">
                        <div class="frmCont">
                          <label for="txtSelect2">Tipo Configuración<span class="TwoPoints">*</span></label>
                          <div class="frmInput frmInput_select2"  style="height:100%">
                            <select type=""  data-rule-RE_Select="0" class= " select input_data" name="SltTipoConfi" id="SltTipoConfi">
                              <option value="0">Seleccione una opción.</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="n_flex">
                      <div class="lg_flex_col25"></div>
                      <div class="n_flex_col100 lg_flex_col50 sm_flex_col100 xs_flex_col100">
                        <div class="frmCont">
                          <label for="cmbCodigoCUP">Código CUP: &nbsp <i style="color:red;">*</i></label>
                          <div class="frmInput frmInput_select2" style="height:100%">
                            <select data-rule-RE_Select="0" onchange='seleccionarDescripcionAutomaticamente(this)' id="cmbCodigoCUP" name="cmbCodigoCUP"><option></option></select>
                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="n_flex">
                      <div class="lg_flex_col25"></div>
                      <div class="n_flex_col100 lg_flex_col50 sm_flex_col100 xs_flex_col100">
                        <div class="frmCont">
                          <label for="cmbDescripcionCUP">Descripción CUP: &nbsp <i style="color:red;">*</i></label>
                          <div class="frmInput frmInput_select2" style="height:100%">
                            <select  data-rule-RE_Select="0" onchange='seleccionarCodigoAutomaticamente(this)'id="cmbDescripcionCUP" name="cmbDescripcionCUP"><option></option></select>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>



                  <div class="n_flex n_justify_around">

                    <div class="n_flex n_flex_col20 md_flex_col sm_flex_col20"></div>

                    <div class="n_flex n_flex_col40 md_flex_col35 sm_flex_col35">
                    </div>

                    <div class="n_flex n_flex_col40 md_flex_col35 sm_flex_col35">
                      <button type="submit" id="btnActualizarCC" class="btn btn-modificar">Actualizar</button>

                    </div>

                    <div class="n_flex n_flex_col20 md_flex_col0 sm_flex_col20">

                    </div>

                  </div>

                </form>

              </div><!--FIN TBL-CONTAINER-->​

            </article>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
