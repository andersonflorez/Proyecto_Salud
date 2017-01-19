<div ng-controller="CtrlMedicamento" ng-init="ListarTipoTratamiento()">
  <div id="mensaje"></div>
<style media="screen">
  .lbl_autorizacion{
    background: #18b9e3!important;
    color: #fff;
  }
</style>


<!--SOLICITUD DE AUTORIZACION-->
<div class="" id="cuadro_autorizacion" ng-model="autorizacion"></div>
  <!--FLECHA DERECHA-->
  <a href="<?=URL?>ReporteAPH/CtrlResultadosAtencion" title="Siguiente" class="flecha-der" onclick="validarBarraProgreso('ctrlResultadosAtencion')">
    <li class="fa fa-long-arrow-right"></li>
  </a>

  <!--FLECHA IZQUIERDA-->
  <a href="<?=URL?>ReporteAPH/CtrlTratamientoA" title="Volver" class="flecha-izq">
    <li class="fa fa-long-arrow-left"></li>
  </a>

  <!-- CONTENIDO -->
  <div class="n_flex n_justify_center margin-top">

    <!-- CONTENIDO VISTA -->
    <div class="n_flex n_flex_col95 sm_flex_col90">
      <!--LISTADO AUTORIZACION-->
      <div class="columna-hd--10 columna--10 columna-tablet--10 columna-movil--10">

        <div class="contenido">
          <div class="contenedor-notificaciones n_flex n_justify_end">
          <!-- 'id' debe ser igual a 'target' -->
          <div class="modal-ventana whole_wrapper" id="modal1">
            <div class="modal relative_element">
              <div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between">
                <!-- Titulo de la ventana modal -->
                <h2>Solicitudes de Autorización</h2>
                <span class="btn-cerrar-modal modal-cerrar fa fa-times"></span>
              </div>

              <div class="modal-body">
                <!-- Contenido de la ventana modal -->
                <div class="panel block">
                  <div class="panel-contenido">
                    <div class="n_flex_col10id tbl_ejemplo">

                      <table class="tbl_responsive" >
                        <thead>
                          <tr>
                            <th>Medicamento</th>
                            <th>Descripción</th>
                            <th>Observación Respuesta</th>
                            <th>Estado Autorización</th>
                          </tr>
                        </thead>
                        <tbody id="SolicitudMedicamento"></tbody>
                      </table>

                    </div>
                    <!--finTabla-->
                  </div>
                </div>
              </div>

              <div class="modal-footer n_flex n_justify_end">
                <button type="button" class="btn-cerrar-modal btn btn-cancelar"  name="button">Salir</button>
              </div>

            </div>
          </div>


        </div>
      </div>


    </div>
      <!-- TITULO VISTA -->
      <h1 class="titulo_vista">
        <span class="fa fa-medkit"></span>
        Kit de la Ambulancia
      </h1>

      <!-- Esto es ahora una fila, de ser necesario pueden cambiar el div por un form -->
      <div class="n_flex n_flex_col100 n_justify_between" id="contMedicam" method="post">

          <div class="columna-hd--10 columna--10 columna-tablet--10 columna-movil--10">

            <div class="contenido">
              <div class="contenedor-notificaciones n_flex n_justify_end">
               <button type="button" target="modal1" class="btn-modal btn btn-consultar tooltip btn-modal" id="btnConsultarAutorizacion" style="right: 35px;
                margin-bottom: 16px;">
              <span class="flotante-file fa fa-list" id="flotante-file"></span>
              <span class="tooltiptext">Mostrar Medicamentos</span>
            </button>
            <button type="button" onclick="listarMedicamentosUsados()" class="btn-modal btn btn-consultar tooltip btn-modal" id="btnConsultarAutorizacion" style="right: 22px;
             margin-bottom: 16px;">
           <span class="flotante-file fa fa-th" id="flotante-file"></span>
           <span class="tooltiptext">Mostrar Medicamentos</span>
         </button>
            </div>
          </div>


        </div>
        <div class="n_flex n_flex_col100 horizontal_padding n_justify_around">


          <div class="panel block">
            <div class="panel-cabecera">
              <h3>Medicamentos</h3>


          </div>


          <div class="panel-contenido">
            <!-- <input type="text" name="name" placeholder="Buscar" style="margin-bottom:10px" ng-model="BuscarMedicamento" value="">-->

            <div class="n_flex n_justify_around" style="max-height: 51vh;overflow-y: auto;" id="contenedorMedicamento">

            </div>

          </div>

        </div> <!-- Fin .panel -->
      </div>



    </div>



    <!-- Esto es ahora una fila, de ser necesario pueden cambiar el div por un form -->
    <div class="n_flex n_flex_col100 n_justify_between" id="contListMedicamento" style="display:none" method="post">
      <!-- Esto es una columna -->
       <div class="columna-hd--10 columna--10 columna-tablet--10 columna-movil--10">

            <div class="contenido">
              <div class="contenedor-notificaciones n_flex n_justify_end">
                <button type="button" target="modal1" class="btn-modal btn btn-segundoMedicamento btn-consultar tooltip btn-modal" id="btnConsultarAutorizacion" style="right: 35px;
                 margin-bottom: 16px;">
               <span class="flotante-file fa fa-list" id="flotante-file"></span>
               <span class="tooltiptext">Mostrar Medicamentos</span>
             </button>
             <button type="button" id="btnConsultarAutorizacion" onclick="cerrarMedicamentoUsados()" class="btn-modal btn btn-consultar cerrar-medicamento tooltip btn-modal" style="right: 22px;
                margin-bottom: 16px;">
              <span class="flotante-file fa fa-close" id="flotante-file"></span>
              <span class="tooltiptext">Mostrar Medicamentos</span>
            </button>
            </div>
          </div>


        </div>
      <div class="n_flex n_flex_col100 horizontal_padding n_justify_around">


        <div class="panel block">
          <div class="panel-cabecera">
            <h3>Medicamentos Utilizados</h3>
          </div>


          <div class="panel-contenido">
            <!-- <input type="text" name="name" placeholder="Buscar" style="margin-bottom:10px" ng-model="BuscarMedicamento" value="">-->

            <div class="n_flex n_justify_around" style="    max-height: 51vh;overflow-y: auto;">
              <ul class="list_panel relative_element n_flex n_justify_around block" style="width: 100%;" id="contenedorMedicamentoUsados">
              </ul>
            </div>

          </div>

        </div> <!-- Fin .panel -->
      </div>



    </div>

  </div>
</div> <!-- FIN CONTENIDO VISTA -->
</div>
