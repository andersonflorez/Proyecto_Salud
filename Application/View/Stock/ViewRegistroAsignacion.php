
<div class="n_flex n_justify_center"><!--INICIO n_flex n_justify_center -->
<div class="n_flex n_flex_col95 sm_flex_col90">  <!-- INICIO  n_flex n_flex_col95 sm_flex_col90 -->

<!-- TITULO VISTA -->
<div class="n_flex n_flex_col100"><!--INICIO TITULO PÁGINA-->
  <h1 class="titulo_vista"><span class="fa fa-edit"></span>Gestión Asignaciones</h1>
</div><!--FIN TITULO PÁGINA-->
<div class="n_flex n_flex_col40 n_justify_around"><!--inicio n_flex n_flex_col100 n_justify_around-->

    <div class="panel block"><!-- INICIO PANEL BLOCK -->
      <div class="panel-cabecera"><!--INICIO PANEL-CABECERA-->
        <h3>Registro de Asignación</h3>
      </div><!--FIN PANEL-CABECERA-->
      <div class="panel-contenido"><!--INICIO PANEL CONTENIDO -->
        <div class="n_flex n_justify_center"><!-- INICIO n_flex-->
          <div class="n_flex_col100"><!--INICIO n_flex_col100-->
            <div class="tbl_container"><!--INICIO TBL-CONTAINER-->

              <form id="formAsignacion"><!--INICIO FORM REGISTRO  ASIGNACION-->
                <div class="modal-body"><!-- INICIO MODAL BODY-->
                  <div class="panel block"><!--INICIO PANEL BLOCK-->
                    <div class="panel-contenido">

                      <div class="frmCont">
                        <label for="slcTipoAsignacion">Tipo Asignación</label>
                        <div class="frmInput">
                          <select  id="txtTipoAsignacion" name="slcTipoAsignacion" data-rule-re_select="0" aria-invalid="true" aria-describedby="slcTipoAsignacion-error" >
                            <option value="0">Seleccione una opción</option>
                          </select>
                        </div>
                      </div>

                      <div class="frmCont Cambiar" id="Ambulancia">
                        <label for="slcTipoAsignacion" >Código De Ambulancia:</label>
                        <div class="frmInput">
                          <select  id= "txtCodigoAmbulancia"  name="slcCodigoAmbulancia"  data-rule-re_select="0" aria-invalid="true" aria-describedby="txtCodigoAmbulancia-error" >
                            <option value="0">Seleccione código ambulancia</option>

                          </select>
                        </div>
                      </div>


                      <div class="frmCont Cambiar" id="ca">
                        <label>Nombre De Médico:</label>
                        <div class="frmInput">
                          <select id="txtNombrePersona" name="slcNombrePersona"  data-rule-re_select="0" aria-invalid="true" aria-describedby="txtNombrePersona-error">
                          <option value="0">Seleccione nombre del medico </option>
                          </select>
                        </div>

                      </div>

                      <div class="frmCont contPaciente  Cambiar" id="Paciente">
                        <label>Nombre De Paciente:</label>
                        <div class="frmInput">
                          <select  id="txtNombrePaciente" name="slcNombrePaciente">
                            <option value="0">Seleccione nombre del paciente </option>
                          </select>
                        </div>
                      </div>

                    </div><!--FIN PANEL CONTENIDO-->
                  </div><!--FIN PANEL BLOCK-->
                </div><!-- FIN MODAL BODY-->
                <div class="n_flex_col100 md_flex_col100">
                  <button type="submit" id="btnRegistrarAsignacion" class="btn btn-registrar">Registrar</button>&nbsp&nbsp&nbsp&nbsp&nbsp
                  <button type="button" id="btnConsultarAsignacion" class="btn btn-consultar" onclick="location.href ='<?=URL?>Stock/ctrlConsultarAsignacion'">Consultar</button></a>
                </div>
              </form><!--FIN FORM REGISTRO  ASIGNACION-->
            </div><!--FIN TBL-CONTAINER-->
          </div><!--FIN n_flex_col100-->

    </div><!-- FIN n_flex-->
  </div><!--FIN PANEL CONTENIDO -->
</div><!--FIN PANEL BLOCK-->
</div><!-- FIN n_flex n_flex_col100 n_justify_around -->


<div class="n_flex n_flex_col60 horizontal_padding"><!--inicio n_flex n_flex_col100 n_justify_around-->

    <div class="panel block"><!-- INICIO PANEL BLOCK -->
      <div class="panel-cabecera"><!--INICIO PANEL-CABECERA-->
        <h3>Recurso de Asignación</h3>
      </div><!--FIN PANEL-CABECERA-->
      <div class="panel-contenido"><!--INICIO PANEL CONTENIDO -->
        <div class="n_flex n_justify_center"><!-- INICIO n_flex-->
          <div class="n_flex_col100"><!--INICIO n_flex_col100-->
            <div class="tbl_container"><!--INICIO TBL-CONTAINER-->

             <form id="formRecursosAsignacion"><!--INICIO FORM REGISTRO RECURSOS ASIGNACION-->
                <div class="modal-body"><!-- INICIO MODAL BODY-->
                  <div class="panel block"><!--INICIO PANEL BLOCK-->
                    <div class="panel-contenido">

                      <div class="frmCont" id="data_resource">
                  <thead>
                    <div class="frmCont">
                      <label>Recurso:</label>
                    </div>
                  </thead>                        

                <table class="table table-bordered table-hover tbl_responsive" id="tab_logic">

                 <thead>
                 <tr>
                   <th></th>
                   <th>Recursos</th>
                   <th>Cantidad Recurso</th>
                   </tr>
                 </thead>
                  <tbody>
                    <div class="frmCont">
                      <tr id='addr0'>
                          <td>
                          <div class="horizontal_padding">
                            <button type="button" id='delete_row' class="btn btn-eliminar btnQuitar fa fa-close"  onclick="Quitar(this)" style="cursor:pointer;"></button>
                          </div>  
                        </td>
                        <td>
                          <div class=" horizontal_padding ">
                            <select class="input_data separar selectDisable" onchange="listarComboCantidadRecurso(0); disabledMedicamento()"  id="slcidrecurso0" name="idrecurso[]" data-rule-RE_Select="0">
                            <option value="0">Seleccione una opción</option>
                          </select>
                          </div>
                        </td>
                        <td>
                          <div class="horizontal_padding">
                            <input type="text" id="txtcantidadAsignada0" class="slcidrecurso select2 separar" name='cantidadAsignada[]' placeholder='Cantidad Asignada'/>
                          </div>  
                        </td>
                      </tr>
                    </div>
      
                  </tbody>
                </table>
                <br>
                <div class="horizontal_padding ">
                  <button  type="button" id="add_row"  class="btn btn-registrar fa fa-plus-square" style="cursor:pointer;  margin-left: 2%;"></button>
                 
                  
                  </div>
                </div>
                <div id="containerTabla" style="display:none"></div>

              </div><!--FIN PANEL CONTENIDO-->
            </div><!--FIN PANEL BLOCK-->
          </div><!-- FIN MODAL BODY-->
        </form><!--FIN FORM REGISTRO RECURSOS ASIGNACION-->
            </div><!--FIN TBL-CONTAINER-->
          </div><!--FIN n_flex_col100-->

    </div><!-- FIN n_flex-->
  </div><!--FIN PANEL CONTENIDO -->
</div><!--FIN PANEL BLOCK-->
</div><!-- FIN n_flex n_flex_col100 n_justify_around -->


</div><!-- FIN n_flex n_flex_col95 sm_flex_col90-->
</div><!--FIN n_flex n_justify_center -->
