
<div class="fila flex-center n_flex n_flex_col100 horizontal_padding n_justify_around n_flex n_justify_center">
  <div class="main_vista n_flex n_in_columns" style="margin-top: -1%;">

    <!-- TITULO VISTA -->
    <h1 class="titulo_vista"><span class="fa fa-users"></span> Personal Asignado</h1>

    <!-- CONTENIDO VISTA -->
    <div class="n_flex n_flex_col95 sm_flex_col90 ">


      <!-- TIPOS DE ALERTAS-->
      <div class="n_flex_col100 lg_flex_col60 horizontal_padding n_justify_around">
        <div class="contenido">
          <div class="limitar">


            <!-- Inicio panel -->
            <div class="panel block">
              <div class="panel-cabecera">
                <h3>Ambulancias</h3>
              </div>

              <div class="panel-contenido" style="height: 606px; overflow: auto;">

                <div class="fila">
                  <div class="n_flex_col100">
                    <div class="barra-filtro">

                      <!--BÓTON DE CONFIGURACIÓN-->
                      <div class=" btn-barra-filtro "><span class="fa fa-search" id="btnFiltrar"></span></div>
                      <!--INPUT DE CONFIGURACIÓN-->

                      <div class=" input-barra"><input type="search" id="txtBusqueda" value=""></div>
                      <!--BÓTON QUE DESPLIEGA EL EL MENÚ DE CONFIGURACIÓN-->

                      <div class="btn-barra-menu"><span class="fa fa-cog"><span class="fa fa-caret-down"></span></span></div>
                      <!--MENÚ DE CONFIGURACIÓN-->
                      <form class="menu-filtro " style="display: none;">



                        <!--OPCIONES DE BÚSQUEDA-->
                        <div class="contenido-menu-filtro">
                          <h5 class="toggle"><span class="fa fa-search"></span>Opciones de Búsqueda</h5>
                          <div class="contenedor n_flex " id="filtro-avanzado">
                            <div class="contenedor-input  n_flex n_flex_col50 lg_flex_col50 md_flex_col100">
                              <label for="">Buscar por:</label>
                              <select id="txtColumnaBusqueda">
                                <option value="placaAmbulancia">Placa</option>
                                <option value="idAmbulancia">Código Ambulancia</option>
                              </select>
                            </div>

                          </div>
                        </div><!--FIN OPCIONES DE BÚSQUEDA-->


                      </form> <!-- FIN MENÚ DE CONFIGURACIÓN-->

                    </div>
                    <ul class="list_panel relative_element n_flex n_justify_center block" id="Asignaciones">
                      <p class="informacion">
                        <img src="<?=URL?>Img/Todos/no-results.png"  />
                        <br>
                        En el momento no hay ambulancias con personal asignado.
                      </p>
                    </ul>
                    <ul class="paginador" id="paginadorAsignacion" ></ul>

                  </div>
                </div>





              </div>
            </div>
          </div>
          <!-- Fin panel -->

        </div>
      </div>


      <!-- VALIDACIONES-->
      <div class="n_flex_col100 lg_flex_col40">
        <div class="contenido">

          <!-- Inicio panel -->
          <div class="panel">
            <div class="panel-cabecera">
              <h3>Personal</h3>
            </div>
            <div class="panel-contenido">
              <span>Ambulancia </span><span id="codigoAmbulancia"></span>
              <input type="hidden" id="idDetalle1" value="">
              <input type="hidden" id="idDetalle2" value="">
              <input type="hidden" id="idDetalle3" value="">
              <input type="hidden" id="idAsignacion" value="">
              <div class="frmCont">
                <label for="campo22">*Persona 1:</label>
                <div class="frmInput frmInput_select2">
                  <select class="input_data" name="slcPersonaU" id="slcPersona1" data-rule-required="true" data-rule-RE_Select="0">
                    <option value="0">Seleccione una opción</option>
                  </select>
                </div>
              </div>
              <div class="frmCont">
                <label for="campo22">*Persona 2:</label>
                <div class="frmInput frmInput_select2">
                  <select class="input_data" name="slcPersonaD" id="slcpersona2" data-rule-required="true" data-rule-RE_Select="0">
                    <option value="0">Seleccione una opción</option>
                  </select>
                </div>
              </div>
              <div class="frmCont">
                <label for="campo22">*Persona 3:</label>
                <div class="frmInput frmInput_select2">
                  <select class="input_data" name="slcPersonaT" id="slcPersona3" data-rule-required="true" data-rule-RE_Select="0">
                    <option value="0">Seleccione una opción</option>
                  </select>
                </div>
              </div>
              <div class="frmCont">
                <label for="map">Ubicación:</label>
                <div id="map" style="width: 100%; height: 300px; border: solid 1px #e5e5e5">
                  <div class="alrededor">
                    <input type="input"  id="txtDireccion" placeholder="Ingrese una dirección" value="">
                  </div>
                </div>
              </div>
              <br>

              <input type="hidden" id="latitud" value="">
              <input type="hidden" id="longitud" value="">
              <div class="izquierda ">
                <button type="button" class="btn btn-cancelar block" onclick="reseteo()"> Nueva Posisción</button>
              </div>
              <div class="derecha">
                <button type="button" class="btn btn-modificar" id="btnModificarAsignacionPersonal">Modificar Asignación</button>
              </div>





            </div>



          </div>

        </div>
        <!-- Fin panel -->

      </div>
    </div>


  </div> <!-- FIN CONTENIDO VISTA -->
</div>  <!--  FIN .main_vista -->
</div> <!-- FIN CONTENIDO -->
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true">
</script>
