

<!-- FLECHA DERECHA -->
<a href="#personalAmbulancia" title="Siguiente" class="flecha-der" id="SigAsignacion">
  <li id="SgDerecha" class="fa fa-long-arrow-right"></li>
</a>

<a href="#" title="Guardar" class="flecha-der" id="GuardarAsignacion">
  <li id="SgDerecha" class="fa fa-floppy-o"></li>
</a>



<!-- FLECHA IZQUIERDA -->
<a href="#ambulanciasUbicacion" title="Volver" class="flecha-izq" id="AntAsignacion">
  <li class="fa fa-long-arrow-left"></li>
</a>


<!-- CONTENIDO -->
<section id="ambulanciasUbicacion">


  <div class="fila flex-center n_flex n_flex_col100 horizontal_padding n_justify_around n_flex n_justify_center">
    <div class="main_vista n_flex n_in_columns" style="margin-top: -1%;">

      <!-- TITULO VISTA -->
      <h1 class="titulo_vista"><span class="fa fa-ambulance"></span> Ambulancia y Ubicación </h1>

      <!-- CONTENIDO VISTA -->
      <div class="n_flex n_flex_col95 sm_flex_col90 ">


        <!-- TIPOS DE ALERTAS-->
        <div class="n_flex_col100 lg_flex_col50 horizontal_padding n_justify_around">
          <div class="contenido">
            <div class="limitar">


              <!-- Inicio panel -->
              <div class="panel block">
                <div class="panel-cabecera" style="text-align: -webkit-auto !important;">
                  <h3>Ambulancias</h3>
                </div>

                <div class="panel-contenido scroll_y" style="height: 606px;">

                  <div class="fila">
                    <div class="n_flex_col100">

                      <ul class="list_panel relative_element n_flex n_justify_center block" id="Ambulancias">
                        <p class="informacion">
                          <img src="<?=URL?>Img/Todos/no-results.png"  />
                          <br>
                          En el momento no hay ambulancias disponibles.
                        </p>
                      </ul>
                      <ul class="paginador" id="paginadorDinamico" ></ul>
                    </div>
                  </div>





                </div>
              </div>
            </div>
            <!-- Fin panel -->

          </div>
        </div>


        <!-- VALIDACIONES-->
        <div class="n_flex_col100 lg_flex_col50">
          <div class="contenido">

            <!-- Inicio panel -->
            <div class="panel">
              <div class="panel-cabecera">
                <h3>Ubicación</h3>
              </div>
              <div class="panel-contenido">

                <div id="map" style="width: 100%; height: 500px">
                  <div class="alrededor">
                    <input type="input"  id="txtDireccion"  placeholder="Ingrese una dirección" value="" >
                  </div>

                </div>
                <br>
                <button type="button" class="btn btn-modificar" onclick="reseteo()">Reiniciar Marcadores</button>
                <input type="hidden" name="TxtLongitud" id="TxtLongitud">
                <input type="hidden" name="TxtLatitud" id="TxtLatitud">
              </div>



            </div>

          </div>
          <!-- Fin panel -->

        </div>
      </div>


    </div> <!-- FIN CONTENIDO VISTA -->
  </div>  <!--  FIN .main_vista n_flex n_in_columnsn_flex n_in_columnsn_flex n_in_columns-->
</div> <!-- FIN CONTENIDO -->
</section>

<section id="personalAmbulancia">
  <div class="fila flex-center n_flex n_flex_col100 horizontal_padding n_justify_around n_flex n_justify_center">
    <div class="main_vista  n_flex n_in_columns" style="margin-top: -1%;">

      <!-- TITULO VISTA -->
      <h1 class="titulo_vista"><span class="fa fa-users"></span> Personal Ambulancia </h1>

      <!-- CONTENIDO VISTA -->
      <div class="n_flex n_flex_col95 sm_flex_col90">


        <!-- TIPOS DE ALERTAS-->
        <div class="n_flex_col100 horizontal_padding n_justify_center">
          <div class="contenido">

            <!-- Inicio panel -->
            <div class="panel">
              <div class="panel-cabecera">
                <h3>Personal</h3>
              </div>

              <div class="panel-contenido">
                <div class="fila">
                  <div class="n_flex_col100">
                    <div class="n_flex_col100 horizontal_padding ovf_initial block">
                      <!-- BARRA BUSQUEDA -->

                      <div class="barra-filtro ">

                        <!--BÓTON DE CONFIGURACIÓN-->
                        <div class=" btn-barra-filtro "><span class="fa fa-search" id="btnFiltrar"></span></div>
                        <!--INPUT DE CONFIGURACIÓN-->

                        <div class=" input-barra"><input type="search" id="txtinputBusqueda" value=""></div>
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
                                  <option value="primerNombre">Nombre</option>
                                  <option value="primerApellido">Apellido</option>
                                </select>
                              </div>

                            </div>
                          </div><!--FIN OPCIONES DE BÚSQUEDA-->


                        </form> <!-- FIN MENÚ DE CONFIGURACIÓN-->

                      </div>
                    </div>
                    <ul class="list_panel relative_element n_flex n_justify_center block" id="PersonaAmbulancia" >

                      <div class="n_flex n_flex_col100 n_flex_justify_center">
                        <p class="informacion">
                          <img src="<?=URL?>Img/Todos/no-results.png"  />
                          <br>
                          En el momento no hay personas disponibles para asignar a la ambulancia.
                        </p>
                      </div>

                    </ul>
                    <ul class="paginador" id="paginadorAsignaciones" ></ul>
                  </div>








                </div>
              </div>
            </div>
            <!-- Fin panel -->

          </div>
        </div>


        <!-- VALIDACIONES-->

      </div>


    </div> <!-- FIN CONTENIDO VISTA -->
  </div>  <!--  FIN .main_vista n_flex n_in_columnsn_flex n_in_columnsn_flex n_in_columns-->
</section>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true">
</script>
