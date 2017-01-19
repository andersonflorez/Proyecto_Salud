<div class="n_flex  whole_wrapper n_justify_center">
  <div class="n_flex n_flex_col100 n_in_columns horizontal_padding">

    <br>
    <div class="n_flex n_in_columns n_grow_up">

      <div class="relative_element">
        <div class="n_flex_col100 horizontal_padding ovf_initial block">
          <!-- BARRA BUSQUEDA -->
          <div class="barra-filtro ">

            <!-- BÓTON DE BUSCAR -->
            <div class="btn-barra-filtro" id="btnBuscar">
              <span class="fa fa-search"></span>
            </div>
            <!--INPUT DE CONFIGURACIÓN-->
            <div class="input-barra"><input type="search" id="txtinputBusqueda" value=""></div>
            <!-- BOTÓN DE RESET BUSQUEDA -->
            <div class="reset_search" id="reset_search">
              <div class="n_flex n_justify_end tooltip">
                <span class="fa fa-refresh"></span>
                <p class="tooltiptext">Actualizar.</p>
              </div>
            </div>
            <!--BÓTON QUE DESPLIEGA EL EL MENÚ DE CONFIGURACIÓN-->
            <div class="btn-barra-menu"><span class="fa fa-cog"></span></div>
            <!--MENÚ DE CONFIGURACIÓN-->
            <form class="menu-filtro " method="post" id="formMenuFiltro" style="display: none; max-height: 410px; overflow-y: auto;">

              <!--OPCIONES DE BÚSQUEDA-->
              <div class="contenido-menu-filtro">
                <h5 class="toggle"><span class="fa fa-search"></span>Opciones de Búsqueda</h5>
                <div class="contenedor n_flex " id="filtro-avanzado">
                  <div class="contenedor-input  n_flex n_flex_col50 lg_flex_col50 md_flex_col100">
                    <label for="">N° de registros:</label>
                    <select name="limit" class="limit">
                      <option value="5">5</option>
                      <option value="10">10</option>
                      <option value="20">20</option>
                      <option value="50">50</option>
                      <option value="?" class="valueTodosLimit">Todos</option>
                    </select>
                  </div>
                  <div class="contenedor-input  n_flex n_flex_col50 lg_flex_col50 md_flex_col100">
                    <label for="">Buscar por:</label>
                    <select name="nameColumnFilter" class="nameColumnFilter">
                      <option selected value="0">Cod.Autorización</option>
                      <option value="1">Nombre Paramédico</option>
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
                        Puedes filtrar las autorizaciones que se encuentren en un rango de fecha determinado, por lo tanto debes especificar 2 fechas la primera (Fecha Inicial) es en donde comienza el rango, la segunda fecha (Fecha final) es donde termina el rango.
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
                      <option selected value="0">Cod.Autorización</option>
                      <option value="1">Nombre Paramédico</option>
                      <option value="2">Documento Paciente</option>
                      <option value="3">Fecha de envío</option>
                    </select>
                  </div>

                  <div class="contenedor-input  n_flex n_flex_col100">
                    <label for="">Ordenar de forma:</label>
                    <div class="n_flex n_justify_start n_flex_col100">
                      <div class="n-checkbox n_justify_between ">
                        <label class="descripcion-checkbox" for="radDescendente">Descendente</label>
                        <div class="contenedor-checkbox ">
                          <input type="radio" name="orderBy" checked value="DESC" class="orderBy" id="radDescendente">
                          <label class="fa fa-check" for="radDescendente"></label>
                        </div>
                      </div>
                      <div class="n-checkbox  n_flex n_justify_between ">
                        <label class="descripcion-checkbox" for="radAscendente">Ascendente</label>
                        <div class="contenedor-checkbox ">
                          <input type="radio" name="orderBy" value="ASC" class="orderBy" id="radAscendente">
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

      <!--CONTENEDORES PARA LISTAR  LAS AUTORIZACIONES-->
      <div class="relative_element n_grow_up">
        <div class="cont_hc scroll_y">
          <div class="n_flex_col100 horizontal_padding">
            <!-- Contenedores autorizaciones -->
            <form class="n_flex n_flex_col100 n_justify_between" id="contenedorNotificaciones" method="post"></form>

          </div>
        </div>
      </div>

      <!--notificacion -->
      <div id="contenedor-nueva-notificacion">


      </div>


      <!-- PAGINADOR -->
      <div class="relative_element cont_paginador n_flex n_justify_center n_align_center con_paginador">
        <div class="block n_flex n_justify_end horizontal_padding">
          <ul class="paginador" id="paginadorControlAutorizacion"></ul>
        </div>
      </div>

    </div>

  </div>
</div>
