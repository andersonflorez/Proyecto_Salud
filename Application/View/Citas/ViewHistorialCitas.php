<!-- CONTENIDO -->
<div class="n_flex n_justify_center">

  <!-- CONTENIDO VISTA -->
  <div class="n_flex n_flex_col95 sm_flex_col90">

    <!-- TITULO VISTA -->
    <div class="n_flex n_flex_col100">
      <h1 class="titulo_vista"><span class="fa fa-book">Historial</h1>
      </div>
      <div class="n_flex n_flex_col100 n_justify_around">

        <!-- CONTENEDOR PRINCIPAL IZQUIERDO -->
        <div class="n_flex n_flex_col100  xl_flex_col100 lg_flex_col100 horizontal_padding n_in_columns">

          <!-- GRID -->
          <div class="panel block">
            <div class="panel-cabecera">
              <h3>Citas Realizadas</h3>
            </div>
            <div class="panel-contenido">
              <p style="text-align:center" id="textNombreCUP">

              </p>
              <article class="block infoC">
                ​<div class="tbl_container"><!--INICIO TBL-CONTAINER-->
                  <table id="example" class="tbl_scroll" >
                    <thead>
                      <tr>
                        <th>N° Documento</th>
                        <th>Paciente</th>
                        <th>CUP</th>
                        <th>Fecha Cita</th>
                        <th>Hora</th>
                        <th>Dirección</th>
                        <th>Estado Cita</th>
                        <th>Personal Asistencial</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>N° Documento</th>
                        <th>Paciente</th>
                        <th>CUP</th>
                        <th>Fecha Cita</th>
                        <th>Hora</th>
                        <th>Dirección</th>
                        <th>Estado Cita</th>
                        <th>Personal Asistencial</th>

                      </tr>
                    </tfoot>
                    <tbody id="cont-table">
                    </tbody>
                  </table>
                </div><!--FIN TBL-CONTAINER-->​

              </article>
            </div>

            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- 'id' debe ser igual a 'target' -->
    <div class="modal-ventana whole_wrapper" id="modalPAsistencial">
      <div class="modal relative_element">

        <div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between">
          <!-- Titulo de la ventana modal -->
          <h2>Personal asistencial</h2>
          <span class="btn-cerrar-modal modal-cerrar fa fa-times"></span>
        </div>

        <div class="modal-body">
          <!-- Contenido de la ventana modal -->
          <div class="panel block">
            <div class="panel-contenido">

              <article class="block">
                <h6 class="text_bold block">Personal asistencial</h6>
                <p style="text-align:center">
                    <div id="AbrirPersonal">

                    </div>
                </p>
              </div>
            </div>
          </div>
          <div class="modal-footer n_flex n_justify_end">
     <button type="button" class="btn-cerrar-modal btn btn-cancelar"  name="button">Salir</button>
   </div>
 </div>
</div>
