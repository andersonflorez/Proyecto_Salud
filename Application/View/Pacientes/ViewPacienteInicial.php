
<div class="n_flex n_justify_center">
  <div class="n_flex n_flex_col95 sm_flex_col90">

    <div class="n_flex n_flex_col100">
      <h1 class="titulo_vista"><span class="fa fa-users"></span> Pacientes</h1>
    </div>
    <div class="n_flex n_flex_col100 n_justify_around">
      <div class="n_flex n_flex_col100">
        <div class="panel block">
          <div class="contenido">
            <div class="panel block">
              <div class="panel-cabecera relative_element ">
                <h3>Pacientes</h3>

              </div>
              <div class="n_flex "style="justify-content: flex-end;padding-right:3%;position: relative;bottom: 47px;">
              <div class="header-btn separate  n_justify_center" style="padding-right: 1%;">
                <button class="tooltip  btn btn-consultar"  onclick="location.href='<?=URL?>Pacientes/CtrlRegistroPaciente'" type="button">
                  <span class="fa fa-user-plus"></span>
                </button>
              </div>
              </div>


              <div class="n_flex  whole_wrapper n_justify_center">
                <div class="n_flex n_flex_col100 n_in_columns horizontal_padding">

                  <br>
                  <div class="n_flex n_in_columns n_grow_up">

                    <div class="relative_element">
                      <div class="n_flex_col100 horizontal_padding ovf_initial block">
                        <!-- BARRA BUSQUEDA -->
                        <div class="barra-filtro ">

                          <!-- BÓTON DE BUSCAR -->
                          <div class="btn-barra-filtro " id="btnBuscar">
                            <span class="fa fa-search"></span>
                          </div>
                          <!--INPUT DE CONFIGURACIÓN-->
                          <div class="input-barra"><input type="search" id="txtinputBusqueda" value=""></div>
                          <!-- BOTÓN DE RESET BUSQUEDA -->
                          <div class="reset_search">
                            <div class="n_flex n_justify_end tooltip">
                              <span class="fa fa-trash"></span>
                              <p class="tooltiptext">Reiniciar filtros.</p>
                            </div>
                          </div>
                          <!--BÓTON QUE DESPLIEGA EL EL MENÚ DE CONFIGURACIÓN-->
                          <div class="btn-barra-menu"><span class="fa fa-cog">
                            <span class="fa fa-caret-down">
                            </span></span>
                          </div>
                          <!--MENÚ DE CONFIGURACIÓN-->
                          <form class="menu-filtro " method="post" id="formMenuFiltro" style="display: none; max-height: 410px; overflow-y: auto;">

                            <!--OPCIONES DE BÚSQUEDA-->
                            <div class="contenido-menu-filtro">
                              <h5 class="toggle"><span class="fa fa-search"></span>Opciones de Búsqueda</h5>
                              <div class="contenedor n_flex " id="filtro-avanzado">
                                <div class="contenedor-input  n_flex n_flex_col50 lg_flex_col50 md_flex_col100">
                                  <label for="">N° de registros:</label>
                                  <select name="limit" class="limit">
                                    <option value="6">6</option>
                                    <option value="12">12</option>
                                    <option value="24">24</option>
                                    <option value="56">56</option>
                                    <option value="?" class="valueTodosLimit">Todos</option>
                                  </select>
                                </div>
                                <div class="contenedor-input  n_flex n_flex_col50 lg_flex_col50 md_flex_col100">
                                  <label for="">Buscar por:</label>
                                  <select name="nameColumnFilter" class="nameColumnFilter">
                                    <option value="0">Nombre Completo</option>
                                    <option value="1">Número Cedula</option>
                                    <option value="2">Ciudad</option>
                                    <option value="3">Fecha Nacimiento</option>
                                  </select>
                                </div>
                              </div>
                            </div><!--FIN OPCIONES DE BÚSQUEDA-->
                            <!--OPCIONES DE FECHAS-->
                            <div class="contenido-menu-filtro">
                              <h5 class="toggle"><span class="fa fa-calendar"></span>Filtrar por fechas</h5>
                              <div class="contenedor n_flex n_justify_around" id="filtro-fechas">
                                <div class="contenedor-input  n_flex n_flex_col100  lg_flex_col50 md_flex_col100 frmCont">
                                  <label for="">Fecha inicial:</label>
                                  <div class="frmInput">
                                    <input name="initialDate" class="input_data" type="date" data-rule-required="true">
                                  </div>
                                </div>
                                <div class="contenedor-input n_flex n_flex_col100 lg_flex_col50 md_flex_col100 frmCont" id="contenidoFechaFin" style="padding-top: 0px">
                                  <label for="">Fecha final:</label>
                                  <div class="frmInput">
                                    <input name="finalDate" class="input_data" type="date" data-rule-required="true">
                                  </div>
                                </div>
                                <div class="horizontal_padding">
                                  <button type="submit" class="btn btn-consultar validarFechaFiltro" >Buscar</button>
                                </div>
                                <div class="contenedor-input n_flex n_flex_col100" id="contenidoFechaFin">
                                  <div class="texto n_flex n_justify_around">
                                    <div class="texto-icono n_flex n_justify_center n_align_center">
                                      <span class="fa fa-info"></span>
                                    </div>
                                    <p class="n_flex n_flex_col100 xs_flex_col75 md_flex_col85">
                                      <label>¿Qué es esto?</label>
                                      Puedes filtrar los pacientes que se registrarón en un rango de fecha determinado, por lo tanto debes especificar 2 fechas la primera (Fecha Inicial) es en donde comienza el rango, la segunda fecha (Fecha final) es donde termina el rango.
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div><!--FIN OPCIONES DE FECHAS-->
                            <!--ORDENAR-->
                            <div class="contenido-menu-filtro">
                              <h5 class="toggle"><span class="fa fa-sort"></span>Ordenar</h5>
                              <div class="contenedor" id="filtro-order">

                                <div class="contenedor-input  n_flex n_flex_col50 lg_flex_col50 md_flex_col100">
                                  <label for="">Ordenar por:</label>
                                  <select name="nameColumnOrderBy" class="nameColumnOrderBy">
                                    <option value="0">Nombres</option>
                                    <option value="1">Fecha Afiliacion</option>
                                    <option selected value="2">Cod.Paciente</option>
                                    <option value="4">Ciudad</option>
                                  </select>
                                </div>

                                <div class="contenedor-input  n_flex n_flex_col100">
                                  <label for="">Ordenar de forma:</label>
                                  <div class="n_flex n_justify_start n_flex_col100">
                                    <div class="n-checkbox n_justify_between ">
                                      <label class="descripcion-checkbox" for="radDescendente">Descendente</label>
                                      <div class="contenedor-checkbox ">
                                        <input type="radio" name="orderBy" value="DESC" class="orderBy" id="radDescendente">
                                        <label class="fa fa-check" for="radDescendente"></label>
                                      </div>
                                    </div>
                                    <div class="n-checkbox  n_flex n_justify_between ">
                                      <label class="descripcion-checkbox" for="radAscendente">Ascendente</label>
                                      <div class="contenedor-checkbox ">
                                        <input type="radio" name="orderBy" checked value="ASC" class="orderBy" id="radAscendente">
                                        <label class="fa fa-check" for="radAscendente"></label>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div><!--FIN ORDENAR-->

                          </form> <!-- FIN MENÚ DE CONFIGURACIÓN-->

                        </div>
                      </div>
                    </div>

                    <!--CONTENEDORES PARA LISTAR  HISTORIAS CLÍNICAS-->
                    <div class="relative_element n_grow_up scroll_y">
                      <div class="scroll_y">
                        <div class="n_flex_col100 horizontal_padding">
                          <!-- Contenedores reportes -->
                          <div class="n_flex n_justify_between" id="ListarPaciente">

                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- PAGINADOR -->
                    <div class="relative_element cont_paginador n_flex n_justify_center n_align_center con_paginador">
                      <div class="block n_flex n_justify_end horizontal_padding">
                        <ul class="paginador" id="paginadorPacientes"></ul>
                      </div>
                    </div>

                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
