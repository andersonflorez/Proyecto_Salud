<a href="<?=URL?>Stock/ctrlregistroAsignacion" title="Volver" class="flecha-izq" id="flecha">
<li class="fa fa-long-arrow-left" ></li>
</a>

<div class="n_flex n_justify_center" id="panel1" ><!--INICIO n_flex n_justify_center -->
  <div class="n_flex n_flex_col95 sm_flex_col90">  <!-- INICIO  n_flex n_flex_col95 sm_flex_col90 -->

    <!-- TITULO VISTA -->
    <div class="n_flex n_flex_col100"><!--INICIO TITULO PÁGINA-->
      <h1 class="titulo_vista"><span class="fa fa-folder-open"></span>Consulta de Asignaciones</h1>
    </div><!--FIN TITULO PÁGINA-->
    <div class="n_flex n_flex_col100 n_justify_around"><!--inicio n_flex n_flex_col100 n_justify_around-->
      <div class="n_flex n_flex_col100 "> <!-- INICIO "n_flex n_flex_col100  -->


        <div class="panel block"><!-- INICIO PANEL BLOCK -->
          <div class="panel-cabecera"><!--INICIO PANEL-CABECERA-->
            <h3>Consulta de Asignaciones</h3>
          </div><!--FIN PANEL-CABECERA-->
          <div class="panel-contenido"><!--INICIO PANEL CONTENIDO -->
            <div class="n_flex"><!-- INICIO n_flex-->
              <div class="n_flex_col100"><!--INICIO n_flex_col100-->
                <div class="tbl_container"><!--INICIO TBL-CONTAINER-->
                  <table id="example" class="tbl_scroll" >
                    <thead>
                      <tr>
                        <th>Tipo Asignación</th>
                        <th>Fecha</th>
                        <th>Placa Ambulancia</th>
                        <th>Documento Médico</th>
                        <th>Documento Paciente</th>
                        <th>Estado</th>
                        <th>Detalles</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Tipo Asignación</th>
                        <th>Fecha</th>
                        <th>Placa Ambulancia</th>
                        <th>Documento Médico</th>
                        <th>Documento Paciente</th>
                        <th>Estado</th>
                        <th>Detalles</th>
                      </tr>
                    </tfoot>
                    <tbody id="cont-table">
                    </tbody>
                  </table>
                </div><!--FIN TBL-CONTAINER-->
              </div><!--FIN n_flex_col100-->
                </div><!--FIN MODAL REGISTRO KIT-->

                </div><!-- FIN n_flex-->
              </div><!--FIN PANEL CONTENIDO -->
            </div><!--FIN PANEL BLOCK-->


          </div><!-- FIN "n_flex n_flex_col100  -->
        </div><!-- FIN n_flex n_flex_col100 n_justify_around -->
      </div><!-- FIN n_flex n_flex_col95 sm_flex_col90-->

    
    <div class="n_flex n_justify_center" id="panel2" style="display:none"><!--INICIO n_flex n_justify_center -->
  <div class="n_flex n_flex_col95 sm_flex_col90">  <!-- INICIO  n_flex n_flex_col95 sm_flex_col90 -->
       <!-- TITULO VISTA -->
    <div class="n_flex n_flex_col100"><!--INICIO TITULO PÁGINA-->
      <h1 class="titulo_vista"><span class="fa fa-folder-open"></span>Consulta de Asignaciones</h1>
    </div><!--FIN TITULO PÁGINA-->
    <div class="n_flex n_flex_col100 n_justify_around"><!--inicio n_flex n_flex_col100 n_justify_around-->
      <div class="n_flex n_flex_col100 "> <!-- INICIO "n_flex n_flex_col100  -->


        <div class="panel block"><!-- INICIO PANEL BLOCK -->
          <div class="panel-cabecera"><!--INICIO PANEL-CABECERA-->
            <h3 style="display:inline-block">Consulta de Asignaciones</h3>
            <button type="button" class="fa fa-times btn btn-cancelar" style="
              float: right;
              margin-top: 12px;
              margin-right: 24px;
            " id="btnDevolver"></button>
          </div><!--FIN PANEL-CABECERA-->
          <div class="panel-contenido"><!--INICIO PANEL CONTENIDO -->
            <div class="n_flex"><!-- INICIO n_flex-->
              <div class="n_flex_col100"><!--INICIO n_flex_col100-->
                <div class="tbl_container"><!--INICIO TBL-CONTAINER-->
                  <table id="example" class="tbl_scroll tbl_responsive" >
                    <thead>
                      <tr>
                        <th>Recurso</th>
                        <th>Cantidad Asignada</th> 
                        <th>Cantidad Final</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Recurso</th>
                        <th>Cantidad Asignada</th>
                        <th>Cantidad Final</th>
                      </tr>
                    </tfoot>
                    <tbody id="cont-tabless">
                    </tbody>
                  </table>
                </div><!--FIN TBL-CONTAINER-->
              </div><!--FIN n_flex_col100-->

              <div class="modal-ventana whole_wrapper" id="ModalDetalleAsignacion"><!--INICIO MODAL REGISTRO KIT-->
                <div class="modal relative_element"><!--NICIO modal relative_element-->
                  <div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between">
                    <h2>Registro Recurso de Kit</h2>
                    <span class="btn-cerrar-modal modal-cerrar fa fa-times"></span>
                  </div>
                  <div class="tbl_container"><!--INICIO TBL-CONTAINER-->
                    <table id="recurso" class="tbl_scroll" >

                      <thead>
                        <tr>
                          <th>Recurso</th>
                          <th>Cantidad Asignada</th>
                          <th>Cantidad Final</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Recurso</th>
                          <th>Cantidad Asignada</th>
                          <th>Cantidad Final</th>
                        </tr>
                      </tfoot>
                      <tbody id="cont-table1">
                        <td>Cantidad Final</td>
                        <td>Cantidad Final</td>
                      </tbody>
                    </table>
                  </div><!--FIN TBL-CONTAINER-->
                </div><!--FIN n_flex_col100-->
                  </div><!--FIN modal relative_element-->
                </div><!--FIN MODAL REGISTRO KIT-->

                </div><!-- FIN n_flex-->
              </div><!--FIN PANEL CONTENIDO -->
            </div><!--FIN PANEL BLOCK-->


          </div><!-- FIN "n_flex n_flex_col100  -->
        </div><!-- FIN n_flex n_flex_col100 n_justify_around -->
      </div><!-- FIN n_flex n_flex_col95 sm_flex_col90-->
