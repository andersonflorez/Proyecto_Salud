<!-- CONTENEDOR PRINCIPAL -->
<div class="n_flex n_nowrap whole_wrapper ovf_hidden">

  <!-- SECCIÓN DE PAGINACIÓN Y REPORTES -->
  <div class="n_grow_up vertical_padding horizontal_padding n_flex">

    <!-- PANEL DE REPORTES -->
    <div class="reports_container panel n_flex n_grow_up n_in_columns">

      <!-- SECCIÓN DE FILTROS DE BÚSQUEDA Y PAGINACIÓN -->
      <div class="filter_section relative_element vertical_padding horizontal_padding">

        <div class="n_flex n_justify_center n_align_start relative_element">

          <!-- FILTROS -->
          <div class="n_grow_up ovf_initial">
            <!-- BARRA BUSQUEDA -->
            <div class="barra-filtro ">

              <!--BÓTON DE CONFIGURACIÓN-->
              <div id="btn-barra-filtro" class=" btn-barra-filtro "><span class="fa fa-search"></span></div>
              <!--INPUT DE CONFIGURACIÓN-->
              <div class=" input-barra"><input id="txtBusqueda" placeholder="Búsqueda (Revise las opciones de filtro)" class="n_grow_up" type="search" name="filter"></div>
              <!--BÓTON QUE DESPLIEGA EL EL MENÚ DE CONFIGURACIÓN-->
              <div class="btn-barra-menu"><span class="fa fa-cog"><span class="fa fa-caret-down"></span></span></div>
              <!--MENÚ DE CONFIGURACIÓN-->
              <div id="menu-filtro" class="menu-filtro " style="display: none;">
                <!--OPCIONES DE BÚSQUEDA-->
                <div class="contenido-menu-filtro">
                  <h5 class="toggle"><span class="fa fa-search"></span>Opciones de filtro</h5>
                  <div class="contenedor n_flex " id="filtro-avanzado">
                    <div class="contenedor-input  n_flex n_flex_col50 lg_flex_col50 md_flex_col100">
                      <label for="slcBusqueda">Buscar por:</label>
                      <select id="nameColumnFilter" name="nameColumnFilter" class="filter_select">
                        <option value="1">Descripción</option>
                        <option value="2">Código reporte</option>
                        <option value="3">Dirección</option>
                        <option value="4">Estado</option>
                        <option value="5">Número lesionados</option>
                        <option value="6">Punto referencia</option>
                      </select>
                    </div>
                    <div class="contenedor-input  n_flex n_flex_col50 lg_flex_col50 md_flex_col100" style="padding-top: 0px">
                      <label for="num_registros">N° de registros:</label>
                      <select id="limit" class="filter_select">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                      </select>
                    </div>
                  </div>
                </div>
                <!--FIN OPCIONES DE BÚSQUEDA-->

                <!--OPCIONES DE FECHAS-->
                <div class="contenido-menu-filtro">
                  <h5 class="toggle"><span class="fa fa-calendar"></span>Buscar por fechas</h5>
                  <form class="contenedor n_flex n_justify_around" id="filtro-fechas">
                    <div class="contenedor-input  n_flex n_flex_col100  lg_flex_col50 md_flex_col100 frmCont">
                      <label for="">Fecha inicial:</label>
                      <div class="frmInput">
                        <input id="initialDate" class="input_data" type="date" data-rule-required="true">
                      </div>
                    </div>
                    <div class="contenedor-input n_flex n_flex_col100 lg_flex_col50 md_flex_col100 frmCont" id="contenidoFechaFin" style="padding-top: 0px">
                      <label for="">Fecha final:</label>
                      <div class="frmInput">
                        <input id="finalDate" class="input_data" type="date" data-rule-required="true">
                      </div>
                    </div>
                    <div class="horizontal_padding">
                      <button type="submit" class="btn btn-consultar">Buscar</button>
                    </div>
                  </form>
                </div>
                <!--FIN OPCIONES DE FECHAS-->

                <!--ORDENAR-->
                <div class="contenido-menu-filtro">
                  <h5 class="toggle"><span class="fa fa-sort"></span>Ordenar</h5>
                  <div class="contenedor" id="filtro-order">
                    <div class="contenedor-input  n_flex n_flex_col50 lg_flex_col50 md_flex_col100">
                      <label for="">Ordenar por:</label>
                      <select id="nameColumnOrderBy" class="filter_select">
                        <option value="1">Fecha</option>
                        <option value="2">Código reporte</option>
                        <option value="3">Estado</option>
                      </select>
                    </div>
                    <div class="contenedor-input  n_flex n_flex_col100" style="padding-top: 0px">
                      <label for="">Ordenar de forma:</label>
                      <div class="n_flex n_justify_start n_flex_col100">
                        <div class="n-checkbox n_justify_between ">
                          <label class="descripcion-checkbox" for="radDescendente">Descendente</label>
                          <div class="contenedor-checkbox ">
                            <input type="radio" name="orderBy" value="1" id="radDescendente" checked class="orderBy">
                            <label class="fa fa-check" for="radDescendente"></label>
                          </div>
                        </div>
                        <div class="n-checkbox  n_flex n_justify_between ">
                          <label class="descripcion-checkbox" for="radAscendente">Ascendente</label>
                          <div class="contenedor-checkbox ">
                            <input type="radio" name="orderBy" value="2" id="radAscendente" class="orderBy">
                            <label class="fa fa-check" for="radAscendente"></label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--FIN ORDENAR-->
              </div>
              <!-- FIN MENÚ DE CONFIGURACIÓN-->

            </div>
          </div>
          <!-- FIN FILTROS -->

        </div>

      </div>
      <!-- FIN SECCIÓN DE FILTROS DE BÚSQUEDA Y PAGINACIÓN -->

      <!-- SECCIÓN DE REPORTES -->
      <div class="n_grow_up relative_element" id="abc">
        <ul id="contenedor-reportes" class="reports_main_container list_panel relative_element n_flex n_justify_center scroll_y absolute_scroll n_align_center">

        </ul>
      </div>
      <!-- FIN SECCIÓN DE REPORTES -->

      <!-- SECCIÓN DE BOTONES DE PAGINACIÓN -->
      <div class="pagination_btn_container relative_element panel-contenido">
        <div class="relative_element">

          <ul class="paginador n_flex n_justify_center md_justify_end" id="ul_paginador">

          </ul>
          <!-- <h6 class="text_bold">No hay reportes para mostrar</h6> -->
        </div>
      </div>
      <!-- FIN SECCIÓN DE BOTONES DE PAGINACIÓN -->

    </div>
    <!-- FIN PANEL REPORTES -->

  </div>
  <!-- FIN SECCIÓN PAGINACIÓN Y REPORTES -->

  <!-- SECCIÓN DE DESPLIEGUE DE REPORTES INDIVIDUALES-->
  <div class="right_panel vertical_padding horizontal_padding n_flex">

    <!-- SECCIÓN LIMPIA (CUANDO NO HAY NINGÚN REPORTE SELECCIONADO) -->
    <div id="clean_section" class="clean_section n_flex">
      <div class="panel n_flex">
        <div class="panel-contenido n_flex n_justify_center n_align_center vertical_padding horizontal_padding n_in_columns">
          <img width="150px" height="150px" class="vertical_padding" src="<?=URL?>Public/Img/ReporteInicial/tap.png" draggable="false">
          <h4>Seleccione un reporte</h4>
          <p class="horizontal_padding">Seleccione un reporte de la lista de reportes para ver su información completa en esta sección</p>
        </div>
      </div>
    </div>
    <!-- FIN SECCIÓN LIMPIA -->

    <!-- CONTENIDO DE LA INFORMACIÓN DEL REPORTE -->
    <div id="info_section" class="info_section panel n_flex n_in_columns">

      <!-- BOTONERÍA DEL ENCABEZADO -->
      <div class="right_panel_header vertical_padding horizontal_padding n_flex n_justify_end">

        <div id="cancel-report" ref="" class="header-btn separate">
          <button class="tooltip btn btn-eliminar">
            <span class="fa fa-ban btn-chat"></span>
            <span class="tooltiptext">Cancelar</span>
          </button>
        </div>

        <div id="add-new" ref="" class="header-btn separate">
          <button class="tooltip btn btn-consultar">
            <span class="fa fa-plus"></span>
            <span class="tooltiptext">Novedad</span>
          </button>
        </div>

        <div class="header-btn separate">
          <button id="show-chat" class="tooltip btn btn-consultar">
            <span class="fa fa-comments-o btn-chat"></span>
            <span class="tooltiptext">Ver chat</span>
          </button>
          <button id="show-info" class="hide btn btn-consultar">
            <span class="fa fa-th btn-info"></span>
          </button>
        </div>

        <div id="hide-right-panel" class="header-btn separate">
          <button class="tooltip btn btn-cancelar">
            <span class="fa fa-times"></span>
            <span class="tooltiptext">Cerrar</span>
          </button>
        </div>

      </div>
      <!-- FIN BOTONERÍA DEL ENCABEZADO -->

      <!-- SECCIÓN PRINCIPAL DE LA INFORMACIÓN -->
      <div class="right_panel_content n_flex relative_element n_grow_up">

        <!-- INFORMACIÓN DEL REPORTE -->
        <div class="informacion_reporte n_flex scroll_y absolute_scroll">

          <!-- INFORMACIÓN GENERAL DEL REPORTE -->
          <div class="panel block n_flex">

            <div class="panel-cabecera">
              <h3>Información del reporte</h3>
            </div>

            <div class="relative_element n_flex">

              <div class="n_flex_col100 panel-contenido">
                <h6 class="text_bold">Código del reporte</h6>
                <p id="codigo-reporte"></p>
              </div>

              <div class="n_flex_col100 panel-contenido">
                <h6 class="text_bold">Información de la emergencia</h6>
                <p id="descripcion-reporte"></p>
              </div>

              <div class="n_flex_col100 panel-contenido">
                <h6 class="text_bold">Dirección</h6>
                <p id="direccion-reporte"></p>
              </div>

              <div class="n_flex_col100 panel-contenido">
                <h6 class="text_bold">Punto de referencia</h6>
                <p id="punto-referencia-reporte"></p>
              </div>

              <div class="n_flex_col100 panel-contenido">
                <h6 class="text_bold">Número de lesionados</h6>
                <p id="numero-lesionados-reporte"></p>
              </div>

              <div class="n_flex_col100 panel-contenido">
                <h6 class="text_bold">Fecha y hora de la emergencia</h6>
                <p id="fecha-hora-emergencia"></p>
              </div>

              <div class="n_flex_col100 panel-contenido">
                <h6 class="text_bold">Fecha y hora del reporte</h6>
                <p id="fecha-hora-envio-reporte"></p>
              </div>

              <div class="n_flex_col100 panel-contenido">
                <h6 class="text_bold">Estado del reporte</h6>
                <p id="estado-reporte"></p>
              </div>

            </div>

          </div>

          <!-- NOVEDADES DEL REPORTE -->
          <div class="panel block n_flex">
            <div class="panel-cabecera">
              <h3>Novedades del reporte</h3>
            </div>

            <div class="relative_element n_flex panel-contenido n_grow_up">
              <ul id="lista-novedades" class="list_panel relative_element n_flex n_justify_center block n_grow_up">

              </ul>
            </div>
          </div>

          <!-- TIPOS DE EVENTO -->
          <div class="panel block n_flex">
            <div class="panel-cabecera">
              <h3>Tipos de evento</h3>
            </div>

            <div class="relative_element n_flex panel-contenido n_grow_up">
              <ul id="lista-tipoevento" class="list_panel relative_element n_flex n_justify_center block n_grow_up">

              </ul>
            </div>
          </div>

          <!-- ENTES EXTERNOS -->
          <div class="panel block n_flex">
            <div class="panel-cabecera">
              <h3>Ayudas solicitadas</h3>
            </div>

            <div class="relative_element n_flex panel-contenido n_grow_up">
              <ul id="lista-exteexterno" class="list_panel relative_element n_flex n_justify_center block n_grow_up">



              </ul>
            </div>
          </div>

        </div>
        <!-- FIN INFORMACIÓN DEL REPORTE -->

        <!-- INFORMACIÓN CHAT -->
        <div class="hide informacion_chat n_flex scroll_y absolute_scroll n_in_columns">

          <!-- BOTONERÍA -->
          <div class="n_flex tabs">
            <button target="section_chat" class="active n_flex n_grow_up tab vertical_padding horizontal_padding n_justify_center">
              <span class="text_bold"><i class="right_padding fa fa-comments-o"></i>Mensajes</span>
            </button>
            <button target="section_users" class="n_flex n_grow_up tab vertical_padding horizontal_padding n_justify_center">
              <span class="text_bold"><i class="right_padding fa fa-user"></i>Usuarios</span>
            </button>
          </div>
          <!-- FIN BOTONERÍA -->

          <!-- MENSAJES DEL CHAT -->
          <div id="section_chat" class="section_chat panel n_flex n_in_columns n_grow_up">

            <!-- CONTENIDO CHAT -->
            <div class="chat-content n_grow_up">
              <div class="chat-history">
                <ul id="chat_history">

                </ul>
              </div>
            </div>
            <!-- FIN CONTENIDO CHAT -->

          </div>
          <!-- FIN MENSAJES DEL CHAT -->

          <!-- INFORMACIÓN DE USUARIOS -->
          <div id="section_users" class="n_flex informacion_usuarios hide">

            <div id="informacion_receptor" class="user_info n_flex n_justify_between n_align_center n_grow_up vertical_padding horizontal_padding">

              <div class="n_flex n_justify_between n_align_center n_grow_up">
                <div class="n_flex">
                  <img class="img_receptor user_img" src="" draggable="false">
                  <div class="n_flex n_grow_up n_in_columns n_justify_center left_padding">
                    <p><span class="text_bold">Nombre: </span><span class="nombre"></span></p>
                    <p><span class="text_bold">Rol: </span><span class="rol">Receptor inicial</span></p>
                    <p class="n_flex n_align_center"><span class="text_bold">Identificador: </span><i class="left_padding fa fa-circle me"></i></p>
                  </div>
                </div>
                <div class="n_flex">
                  <button class="details" target="receptor_extra_information">
                    <span class="fa fa-ellipsis-v"></span>
                  </button>
                </div>
              </div>

              <ul id="receptor_extra_information" class="extra_information list_panel relative_element n_flex n_justify_center n_grow_up">

                <li class="list_item n_dont_grow">
                  <div class="list_item_header n_flex n_nowrap" style="background: #fafafa;">
                    <div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden">
                      <h5 class="suspensive" style="color: #666;">
                        <span class="text_bold">Información extra</span>
                      </h5>
                    </div>
                  </div>

                  <div class="list_item_content suspensive_4">
                    <p class="paragraph">
                      <span class="text_bold">Teléfono: </span>
                      <span class="telefono"></span>
                    </p>
                  </div>

                  <div class="list_item_content suspensive_4">
                    <p class="paragraph">
                      <span class="text_bold">Correo electrónico: </span>
                      <span class="correoElectronico"></span>
                    </p>
                  </div>

                  <div class="list_item_content suspensive_4">
                    <p class="paragraph">
                      <span class="text_bold">Dirección: </span>
                      <span class="direccion"></span>
                    </p>
                  </div>

                </li>

                <li class="list_item n_dont_grow">
                  <div class="list_item_header n_flex n_nowrap" style="background: #fafafa;">
                    <div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden">
                      <h5 class="suspensive" style="color: #666;">
                        <span class="text_bold">Información reportes</span>
                      </h5>
                    </div>
                  </div>

                  <div class="list_item_content suspensive_4">
                    <p class="paragraph">
                      <span class="text_bold">Reportes realizados: </span>
                      <span class="reportesRealizados"></span>
                    </p>
                  </div>

                  <div class="list_item_content suspensive_4">
                    <p class="paragraph">
                      <span class="text_bold">Reportes cancelados: </span>
                      <span class="reportesCancelados"></span>
                    </p>
                  </div>

                  <div class="list_item_content suspensive_4">
                    <p class="paragraph">
                      <span class="text_bold">Reportes finalizados: </span>
                      <span class="reportesFinalizados"></span>
                    </p>
                  </div>

                </li>

              </ul>

            </div>

            <div id="informacion_usuario" class="user_info n_flex n_justify_between n_align_center n_grow_up vertical_padding horizontal_padding" style="border-bottom: 1px solid rgba(0,0,0,.1)">

              <div class="n_flex n_justify_between n_align_center n_grow_up">
                <div class="n_flex">
                  <img class="img_usuario user_img" src="" draggable="false">
                  <div class="n_flex n_grow_up n_in_columns n_justify_center left_padding">
                    <p><span class="text_bold">Nombre: </span><span class="nombre"></span></p>
                    <p><span class="text_bold">Rol: </span><span class="rol">Usuario externo</span></p>
                    <p class="n_flex n_align_center"><span class="text_bold">Identificador: </span><i class="left_padding fa fa-circle online"></i></p>
                  </div>
                </div>
                <div class="n_flex">
                  <button class="details" target="user_extra_information">
                    <span class="fa fa-ellipsis-v"></span>
                  </button>
                </div>
              </div>

              <ul id="user_extra_information" class="extra_information list_panel relative_element n_flex n_justify_center n_grow_up">

                <li class="list_item n_dont_grow">
                  <div class="list_item_header n_flex n_nowrap" style="background: #fafafa;">
                    <div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden">
                      <h5 class="suspensive" style="color: #666;">
                        <span class="text_bold">Información extra</span>
                      </h5>
                    </div>
                  </div>

                  <div class="list_item_content suspensive_4">
                    <p class="paragraph">
                      <span class="text_bold">Teléfono: </span>
                      <span class="telefono"></span>
                    </p>
                  </div>

                  <div class="list_item_content suspensive_4">
                    <p class="paragraph">
                      <span class="text_bold">Correo electrónico: </span>
                      <span class="correoElectronico"></span>
                    </p>
                  </div>

                  <div class="list_item_content suspensive_4">
                    <p class="paragraph">
                      <span class="text_bold">Dirección: </span>
                      <span class="direccion"></span>
                    </p>
                  </div>

                </li>

                <li class="list_item n_dont_grow">
                  <div class="list_item_header n_flex n_nowrap" style="background: #fafafa;">
                    <div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden">
                      <h5 class="suspensive" style="color: #666;">
                        <span class="text_bold">Información reportes</span>
                      </h5>
                    </div>
                  </div>

                  <div class="list_item_content suspensive_4">
                    <p class="paragraph">
                      <span class="text_bold">Reportes realizados: </span>
                      <span class="reportesRealizados"></span>
                    </p>
                  </div>

                  <div class="list_item_content suspensive_4">
                    <p class="paragraph">
                      <span class="text_bold">Reportes cancelados: </span>
                      <span class="reportesCancelados"></span>
                    </p>
                  </div>

                  <div class="list_item_content suspensive_4">
                    <p class="paragraph">
                      <span class="text_bold">Reportes finalizados: </span>
                      <span class="reportesFinalizados"></span>
                    </p>
                  </div>

                </li>

              </ul>

            </div>

          </div>
          <!-- FIN INFORMACIÓN USUARIOS -->

        </div>
        <!-- FIN INFORMACIÓN CHAT -->

      </div>
      <!-- FIN SECCIÓN PRINCIPAL DE LA INFORMACIÓN -->
    </div>
    <!-- FIN CONTENIDO DE LA INFORMACIÓN DEL REPORTE -->

  </div>
  <!-- FIN SECCIÓN DE DESPLIEGUE DE REPORTES INDIVIDUALES-->

</div>
<!-- FIN CONTENEDOR PRINCIPAL -->
