<div class="n_flex ">
    <div class="n_flex n_flex_col100 sm_flex_col100">
        <div class="n_flex n_flex_col100 n_justify_around">
            <h1 class="titulo_vista"><span class="fa fa-file-text"></span>Consultar Atenciones</h1>
            <!--panel consultar atenciones-->
            <div class="n_flex n_flex_col100 horizontal_padding" id="panelAtencion">
                <div class="panel block n_flex n_in_columns">
                    <!--NOMBRE DEL PACIENTE-->
                    <div class="panel-cabecera">
                        <div class="n_flex">
                            <h3 class=" n_flex_col100 xl_flex_col90" id="tituloPaciente"><center><?php echo $queryInformacionPersonal->primerNombre ." ".$queryInformacionPersonal->segundoNombre." ".$queryInformacionPersonal->primerApellido." ".$queryInformacionPersonal->segundoApellido?></center></h3>

                            <div class="header-btn separate" style="margin-left:5px; margin-top:13px;">
                                <button class="tooltip btn-modal btn btn-consultar" target="modalInformacionPersonal" type="button" id="btnConsultarInformacionPersonal">
                                    <span class="fa fa-users"></span>
                                    <span class="tooltiptext">I.Personal</span>
                                </button>
                            </div>

                            <div class="header-btn separate" style="margin-left:5px; margin-top:13px;s">
                                <button class="tooltip btn btn-cancelar" id="btnCerrar2">
                                    <span class="fa fa-times"></span>
                                    <span class="tooltiptext">Salir</span>
                                </button>
                            </div>

                        </div>
                    </div>

                    <div class="horizontal_padding vertical_padding n_flex">
                        <!-- inicio buscador-->
                        <div class="barra-filtro n_flex_col100 xl_flex_col100 ovf_initial" id="barra-filtro" style="border-right: solid 1px #CCC;">

                            <!--BÓTON DE CONFIGURACIÓN-->
                            <div class="btn-barra-filtro" id="btnBuscar"><span class="fa fa-search"></span></div>
                            <!--INPUT DE CONFIGURACIÓN-->
                            <div class=" input-barra"><input type="search" id="txtinputBusqueda" value=""></div>
                            <!-- BOTÓN DE RESET BUSQUEDA -->
                            <div class="reset_search">
                                <div class="n_flex n_justify_end">
                                    <span class="fa fa-trash"></span>
                                </div>
                            </div>
                            <!--BÓTON QUE DESPLIEGA EL EL MENÚ DE CONFIGURACIÓN-->
                            <div class="btn-barra-menu"><span class="fa fa-cog"><span class="fa fa-caret-down"></span></span></div>
                            <!--MENÚ DE CONFIGURACIÓN-->
                            <form class="menu-filtro " style="display: none;" id="frmFiltroBusqueda">

                                <!--OPCIONES DE FILTRO-->
                                <div class="contenido-menu-filtro">
                                    <h5 class="toggle"><span class="fa fa-wrench"></span>Opciones de Filtro</h5>
                                    <div class="contenedor n_flex n_justify_around" id="filtro-general" style="display: none;">
                                        <div class="contenedor-input  n_flex n_flex_col50 lg_flex_col50 md_flex_col100">
                                            <label for="">N° de registros:</label>
                                            <select class="limit" name="limit">
                                                <option value="3">3</option>
                                                <option value="6">6</option>
                                                <option value="12">12</option>
                                                <option value="21">21</option>
                                                <option value="50">50</option>
                                                <option value=""id="limiteTodos">Todos</option>
                                            </select>
                                        </div>
                                    </div>
                                </div><!--FIN OPCIONES DE FILTRO-->

                                <!--OPCIONES DE BÚSQUEDA-->
                                <div class="contenido-menu-filtro">
                                    <h5 class="toggle"><span class="fa fa-search"></span>Opciones de Búsqueda</h5>
                                    <div class="contenedor n_flex " id="filtro-avanzado" style="display: none;">
                                        <div class="contenedor-input  n_flex n_flex_col50 lg_flex_col50 md_flex_col100">
                                            <label for="">Buscar por:</label>
                                            <select id="txtColumnaBusqueda" name="txtColumnaBusqueda" class="nameColumnFilter">
                                                <option value="1">Numero atencion</option>
                                                <option value="2">Primer nombre del medico</option>
                                                <option value="3">Primer apellido del medico</option>
                                                <option value="4">Numero identidicacion del medico</option>
                                            </select>
                                        </div>    
                                    </div>
                                </div><!--FIN OPCIONES DE BÚSQUEDA-->

                                <!--OPCIONES DE FECHAS-->
                                <div class="contenido-menu-filtro">
                                    <h5 class="toggle"><span class="fa fa-calendar"></span>Buscar por fechas</h5>
                                    <div class="contenedor n_flex n_justify_around" id="filtro-fechas" style="display: none;">
                                        <div class="contenedor-input  n_flex n_flex_col100  lg_flex_col50 md_flex_col100">
                                            <label for="">Primera fecha:</label>
                                            <input type="Date" id="fechaInicio" name="fechaInicio">
                                        </div>
                                        <div class="contenedor-input  n_flex n_flex_col100  lg_flex_col50 md_flex_col100" id="contenidoFechaFin">
                                            <label for="">Segunda fecha:</label>
                                            <input type="Date" id="fechaFin" name="fechaFin">
                                        </div>
                                        <div class="contenedor-input n_flex n_flex_col100" id="contenidoFechaFin">
                                            <div class="texto n_flex n_justify_around">
                                                <div class="texto-icono n_flex n_justify_center n_align_center">
                                                    <span class="fa fa-info"></span>
                                                </div>
                                                <p class="n_flex n_flex_col100 xs_flex_col75 md_flex_col85">
                                                    <label>¿Como usar el filtro de fechas?</label>
                                                    Esta seccion de fechas se busca por las fechas de las atenciondes del paciente, ingrese un rango de fechas para ver las atenciones de ese paciente en ese tiempo.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--FIN OPCIONES DE FECHAS-->

                                <!--ORDENAR-->
                                <div class="contenido-menu-filtro">
                                    <h5 class="toggle"><span class="fa fa-sort"></span>Ordenar</h5>
                                    <div class="contenedor" id="filtro-order" style="display: none;">
                                        <div class="contenedor-input  n_flex n_flex_col100">
                                            <label for="">Ordenar de forma:</label>
                                            <div class="n_flex n_justify_start n_flex_col100">
                                                <div class="n-checkbox n_justify_between ">
                                                    <label class="descripcion-checkbox" for="radDescendente">Descendente </label>
                                                    <div class="contenedor-checkbox ">
                                                        <input type="radio" checked class="orderBy" name="orderBy" value="DESC" id="radDescendente">
                                                        <label class="fa fa-check" for="radDescendente"></label>
                                                    </div>
                                                </div>
                                                <div class="n-checkbox  n_flex n_justify_between ">
                                                    <label class="descripcion-checkbox" for="radAscendente">Ascendente </label>
                                                    <div class="contenedor-checkbox ">
                                                        <input type="radio" class="orderBy" name="orderBy" value="ASC" id="radAscendente">
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

                    <div class="panel-contenido scroll-panel" style="padding:0;height:400px">
                        <ul class="list_panel relative_element n_flex n_justify_start block"  id="containerAtenciones">
                            <!--PANEL-->
                        </ul>
                        <!--FIN-PANEL-->
                    </div>
                    <div class="horizontal_padding vertical_padding n_flex n_justify_end" style="border-top: solid 1px #CFCFCF; box-shadow: 0 0px 7px rgba(0,0,0,0.2);;"><ul class="paginador" id="paginadorDinamico" ></ul></div>
                </div>
            </div>
            <!--fin panel consultar atenciones-->

            <!--panel consultar informacion  historia clinica-->
            <div class="horizontal_padding lg_flex_col60 xl_flex_col70 n_flex_col10 sm_flex_col100 xs_flex_col100" style="display:none" id="panelDerecho">
                <div class="panel">



                    <div class="panel-contenido scroll-panel">
                        <div class="panel-cabecera">
                            <div class="vertical_padding horizontal_padding n_flex n_justify_end">
                                <h3 style="margin-top: -5px; padding-bottom: 0px;" id="idAtencion"></h3>
                                <div id="cancel-report" ref="" class="header-btn separate">
                                    <button class="btn-modal btn btn-consultar tooltip" target="modalSignosV" type="button" id="btnSignosV">
                                        <span class="fa fa-heartbeat"></span>
                                        <span class="tooltiptext">S.Vitales</span>
                                    </button>
                                </div>

                                <div class="header-btn separate" style="margin-left:5px;">
                                    <button class="tooltip btn btn-consultar" id="btnOrdenesM" type="button">
                                        <span class="fa fa-file-text-o"></span>
                                        <span class="tooltiptext">O.Médicas</span>
                                    </button>
                                </div>



                                <div class="header-btn separate" style="margin-left:5px;">
                                    <button class="tooltip btn btn-cancelar" id="btnCerrar">
                                        <span class="fa fa-times"></span>
                                        <span class="tooltiptext">Cerrar</span>
                                    </button>
                                </div>


                            </div>
                        </div>
                        <!-- Origen De Atencion -->
                        <ul class="list_panel relative_element n_flex n_justify_start block" style="margin-bottom: -10px;">

                            <li class="list_item n_dont_grow" style="width:100%;">
                                <div class="list_item_header n_flex n_nowrap acordeonTitulo">
                                    <div class="item_title n_grow_up horizontal_padding ovf_hidden">
                                        <h6 class="text_bold suspensive" style="margin-bottom: auto;">Atención</h6>
                                    </div>
                                </div>

                                <div class="list_item_content suspensive_4 acordeonDescripcion xxl_flex_col100 ">
                                    <p class="paragraph">
                                    <div class="n_flex n_justify_center n_flex_col100">


                                        <div class="n_flex_col100 n_justify_center">
                                            <div class="panel-contenido scroll-panelM" id="containerAtencion">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <!--fin Origen De Atencion -->

                        <!--Antecedentes y examen fisico-->
                        <ul class="list_panel relative_element n_flex n_justify_start block" style="margin-bottom: -10px;">

                            <li class="list_item n_dont_grow" style="width:100%;">
                                <div class="list_item_header n_flex n_nowrap acordeonTitulo">
                                    <div class="item_title n_grow_up horizontal_padding ovf_hidden">
                                        <h6 class="text_bold suspensive">Antecedentes y Exámenes Físicos</h6>
                                    </div>
                                </div>

                                <div class="list_item_content suspensive_4 acordeonDescripcion">
                                    <p class="paragraph">

                                    <div class="n_flex n_justify_center">
                                        <div class="n_flex n_flex_col95 sm_flex_col90">
                                            <div class="n_flex_col50 horizontal_padding n_in_columns">
                                                <div class="panel block panelAcordeon">
                                                    <div class="panel-cabecera">
                                                        <center>
                                                            <h6 class="block" style="color: #00A8A7;"><b>Antecedentes</b></h6></center>
                                                    </div>
                                                    <div class="panel-contenido scroll-panelM" id="containerAntecedentes">

                                                    </div>

                                                </div>
                                            </div>

                                            <div class="n_flex_col50  horizontal_padding n_in_columns">
                                                <div class="panel block panelAcordeon">
                                                    <div class="panel-cabecera">
                                                        <center>
                                                            <h6 class="block" style="color: #00A8A7;"><b>Exámenes Físicos</b></h6></center>
                                                    </div>
                                                    <div class="panel-contenido scroll-panelM" id="containerExamenFisico">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </li>
                        </ul>
                        <!--fin Antecedentes y examen fisico-->
                        <!-- procedimientos -->
                        <ul class="list_panel relative_element n_flex n_justify_start block" style="margin-bottom: -10px;">

                            <li class="list_item n_dont_grow" style="width:100%;">
                                <div class="list_item_header n_flex n_nowrap acordeonTitulo">
                                    <div class="item_title n_grow_up horizontal_padding ovf_hidden">
                                        <h6 class="text_bold suspensive">Procedimientos</h6>
                                    </div>
                                </div>

                                <div class="list_item_content suspensive_4 acordeonDescripcion">
                                    <p class="paragraph">
                                    <div class="n_flex n_flex_col100" id="containerProcedimientos">



                                    </div>
                                </div>
                            </li>
                        </ul>
                        <!--fin procedimientos -->

                        <!--Diagnosticos-->
                        <ul class="list_panel relative_element n_flex n_justify_start block" style="margin-bottom: -10px;">

                            <li class="list_item n_dont_grow" style="width:100%;">
                                <div class="list_item_header n_flex n_nowrap acordeonTitulo" id="listDiagnostico">
                                    <div class="item_title n_grow_up horizontal_padding ovf_hidden">
                                        <h6 class="text_bold suspensive">Diagnósticos</h6>
                                    </div>
                                </div>
                                <div class="list_item_content suspensive_4 acordeonDescripcion">
                                    <p class="paragraph">
                                    <div class="n_flex n_justify_center n_flex_col100">
                                        <div class="n_flex_col100 n_justify_center" id="containerDiagnostico">

                                        </div>
                                    </div>

                                </div>



                            </li>
                        </ul>
                        <!-- fin Diagnosticos-->

                        <!--Medicacion-->
                        <ul class="list_panel relative_element n_flex n_justify_start block" style="margin-bottom: -10px;">

                            <li class="list_item n_dont_grow" style="width:100%;">
                                <div class="list_item_header n_flex n_nowrap acordeonTitulo">
                                    <div class="item_title n_grow_up horizontal_padding ovf_hidden">
                                        <h6 class="text_bold suspensive">Medicación</h6>
                                    </div>
                                </div>

                                <div class="list_item_content suspensive_4 acordeonDescripcion">
                                    <p class="paragraph">
                                    <div class="n_flex_col100">
                                        <div class="tbl_container" id="containerTable">

                                        </div>
                                    </div>


                                </div>
                            </li>
                        </ul>
                        <!--fin Medicacion-->

                        <!--Modal de signos vitales -->
                        <div class="modal-ventana whole_wrapper" id="modalSignosV">
                            <div class="modal relative_element">

                                <div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between">
                                    <h2>Signos Vitales</h2>
                                    <span class="btn-cerrar-modal modal-cerrar fa fa-times"></span>
                                </div>



                                <div class="modal-body" style="padding: 0px ! important; max-height:345px !important; ">
                                    <div class="panel ">
                                        <div class="panel-contenido" style="padding:0.5em !important;">
                                            <div class="n_flex n_flex_col100 ">
                                                <div class="panel">
                                                    <div class="panel-contenido">
                                                        <div class="n_flex_col100">
                                                            <div class="tbl_container">
                                                                <!-- principal-->
                                                                <table class="tbl_scroll">
                                                                    <thead>
                                                                        <tr>
                                                                            <th align="center">Tiempo</th>
                                                                            <td align="center">
                                                                                <input type="text" id="txtSignoVital0-1" readonly placeholder="Inicio" autocomplete="off">
                                                                            </td>
                                                                            <td align="center">
                                                                                <input type="text" id="txtSignoVital0-2" readonly placeholder="Hora" autocomplete="off">
                                                                            </td>
                                                                            <td align="center">
                                                                                <input type="text" id="txtSignoVital0-3" readonly placeholder="Hora" autocomplete="off">
                                                                            </td>
                                                                            <td align="center">
                                                                                <input type="text" id="txtSignoVital0-4" readonly placeholder="Fin" autocomplete="off">
                                                                            </td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <th>F.C</th>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital1-1" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital1-2" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital1-3" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital1-4" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>T.A.S</th>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital2-1" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital2-2" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital2-3" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital2-4" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>T.A.D</th>
                                                                            <td>
                                                                                <input type="text" class="campo1" readonly id="txtSignoVital3-1" name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="campo1" readonly id="txtSignoVital3-2" name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="campo1" readonly id="txtSignoVital3-3" name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="campo1" readonly id="txtSignoVital3-4" name="name" value="" autocomplete="off">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>F.R</th>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital4-1" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital4-2" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital4-3" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital4-4" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Temperatura</th>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital5-1" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital5-2" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital5-3" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital5-4" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Glasgow</th>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital6-1" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital6-2" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital6-3" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital6-4" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>SpO2</th>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital7-1" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital7-2" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital7-3" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital7-4" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Glucometría</th>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital8-1" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital8-2" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital8-3" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" id="txtSignoVital8-4" readonly name="name" value="" autocomplete="off">
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer n_flex n_justify_end">
                                    <button type="button" class="btn-cerrar-modal btn btn-cancelar" name="button">Cancelar</button>

                                </div>

                            </div>
                        </div>

                        <!-- fin de modal signos Vitales -->

                        <!--modal notas de enfermeria -->
                        <div class="modal-ventana whole_wrapper" id="modalNotasEnfermeria">
                            <div class="modal relative_element">

                                <div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between">
                                    <!-- Titulo de la ventana modal -->
                                    <h2>Notas de Enfemeria</h2>
                                    <span class="btn-cerrar-modal modal-cerrar fa fa-times"></span>
                                </div>

                                <div class="modal-body" style="padding: 2px !important;">
                                    <!-- Contenido de la ventana modal -->


                                    <div class="panel-contenido" id="modalConsultarNotasEnfermeria"></div>


                                </div>

                                <div class="modal-footer n_flex n_justify_end">
                                    <button type="button" class="btn-cerrar-modal btn btn-cancelar" name="button">Salir</button>
                                </div>

                            </div>
                        </div>


                        <!-- fin modal notas enfermeria -->
                    </div>
                </div>
            </div>
            <!-- Modal Informacion Personal-->
            <!--panel consultar informacion  historia clinica-->
        </div>
    </div>
    <!--modal I.P -->
    <div class="modal-ventana whole_wrapper" id="modalInformacionPersonal">
        <div class="modal relative_element">

            <div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between">
                <!-- Titulo de la ventana modal -->
                <h2>Información Personal</h2>
                <span class="btn-cerrar-modal modal-cerrar fa fa-times"></span>
            </div>

            <div class="modal-body" style="padding: 2px !important;">
                <!-- Contenido de la ventana modal -->


                <div class="panel-contenido" id="modalConsultarInformacionPersonal" style="padding: 12px 40px 13px 40px;">
                    <!-- FLECHA DERECHA -->





                    <div class="fila">
                        <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                            <div class="frmCont">
                                <label for="txtTipoDocumento">Tipo documento</label>
                                <input type="text" id="txtTipoDocumento" disabled value="<?php echo $queryInformacionPersonal->descripcionTdocumento ?>">
                            </div>
                        </div>
                        <div class="columna-1 columna-hd-1"></div>
                        <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                            <div class="frmCont">
                                <label for="txtNumeroDocumento">Número documento:</label>
                                <input disabled value="<?php echo $queryInformacionPersonal->numeroDocumento ?>" type="text" id="txtNumeroDocumento">
                            </div>
                        </div>
                    </div>

                    <div class="fila">
                        <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                            <div class="frmCont">
                                <label for="txtNombre1">1er nombre:</label>
                                <input disabled value="<?php echo $queryInformacionPersonal->primerNombre ?>" type="text" id="txtNombre1">
                            </div>
                        </div>
                        <div class="columna-1 columna-hd-1"></div>
                        <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                            <div class="frmCont">
                                <label for="txtNombre2">2do nombre:</label>
                                <input disabled value="<?php echo $queryInformacionPersonal->segundoNombre ?>" type="text" id="txtNombre2">
                            </div>
                        </div>
                    </div>

                    <div class="fila">
                        <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                            <div class="frmCont">
                                <label for="txtApellido1">1er apellido:</label>
                                <input disabled value="<?php echo $queryInformacionPersonal->primerApellido ?>" type="text" id="txtApellido1">
                            </div>
                        </div>
                        <div class="columna-1 columna-hd-1"></div>
                        <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                            <div class="frmCont">
                                <label for="txtApellido2">2do apellido:</label>
                                <input disabled value="<?php echo $queryInformacionPersonal->segundoApellido ?>" type="text" id="txtApellido2">
                            </div>
                        </div>
                    </div>

                    <div class="fila">
                        <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                            <div class="frmCont">
                                <label for="txtFechaNacimiento">Fecha nacimiento:</label>
                                <input disabled value="<?php echo $queryInformacionPersonal->fechaNacimiento ?>" type="date" id="txtFechaNacimiento">
                            </div>
                        </div>
                        <div class="columna-1 columna-hd-1"></div>
                        <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                            <div class="frmCont">
                                <label for="txtTipoSangre">Tipo sangre</label>
                                <input disabled value="<?php echo $queryInformacionPersonal->tipoSangre ?>" type="text" id="txtTipoSangre">
                            </div>
                        </div>
                    </div>
                    <div class="fila">
                        <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                            <div class="frmCont">
                                <label for="txtGenero">Genero</label>
                                <input disabled value="<?php echo $queryInformacionPersonal->genero ?>" type="text" id="txtGenero">
                            </div>
                        </div>
                        <div class="columna-1 columna-hd-1"></div>
                        <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                            <div class="frmCont">
                                <label for="campo6 cmbEstadoCivil">Estado civil</label>

                                <input value="<?php echo $queryInformacionPersonal->estadoCivil ?>" type="text" id="txtEstadoCivil" autocomplete="off" disabled>

                            </div>
                        </div>
                    </div>

                    <div class="fila">
                        <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                            <div class="frmCont">
                                <label for="txtCiudadResidencia">Ciudad residencia:</label>                
                                <input value="<?php echo $queryInformacionPersonal->ciudadResidencia ?>" type="text" class="input_data" data-rule-required="true" data-rule-RE_LatinCharacters="true" id="txtCiudadResidencia" name="txtCiudadResidencia" autocomplete="off" disabled>
                            </div>
                        </div>
                        <div class="columna-1 columna-hd-1"></div>
                        <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                            <div class="frmCont">
                                <label for="txtBarrioResidencia">Barrio residencia:</label>
                                <input value="<?php echo $queryInformacionPersonal->barrioResidencia ?>" type="text" class="input_data" data-rule-required="true" data-rule-RE_LatinCharacters="true" id="txtBarrioResidencia" name="txtBarrioResidencia" autocomplete="off" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="fila">
                        <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                            <div class="frmCont">
                                <label for="txtDireccion">Dirección:</label>
                                <input value="<?php echo $queryInformacionPersonal->direccion ?>" type="text" class="input_data" data-rule-required="true" id="txtDireccion" name="txtDireccion" autocomplete="off" disabled>
                            </div>
                        </div>
                        <div class="columna-1 columna-hd-1"></div>
                        <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                            <div class="frmCont">
                                <label for="txtCorreoElectronico">Correo electrónico:</label>
                                <input value="<?php echo $queryInformacionPersonal->correoElectronico ?>" type="text" class="input_data" data-rule-required="true" data-rule-RE_Email="true" id="txtCorreoElectronico" name="txtCorreoElectronico" autocomplete="off" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="fila">
                        <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                            <div class="frmCont">
                                <label for="txtTelefonoFijo">Teléfono fijo:</label>
                                <input value="<?php echo $queryInformacionPersonal->telefonoFijo ?>" type="text" class="input_data" data-rule-required="true" data-rule-RE_Numbers="true" id="txtTelefonoFijo" name="txtTelefonoFijo" autocomplete="off" disabled>
                            </div>
                        </div>
                        <div class="columna-1 columna-hd-1"></div>
                        <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                            <div class="frmCont">
                                <label for="txtTelefonoCelular">Teléfono celular:</label>
                                <input value="<?php echo $queryInformacionPersonal->telefonoMovil ?>" type="text" class="input_data" data-rule-RE_Numbers="true" id="txtTelefonoCelular" name="txtTelefonoCelular" disabled autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="fila">
                        <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                            <div class="frmCont">
                                <label for="txtEmpresa">Empresa:</label>
                                <input value="<?php echo $queryInformacionPersonal->empresa ?>" type="text" class="input_data" data-rule-required="true" id="txtEmpresa" name="txtEmpresa" disabled autocomplete="off">
                            </div>
                        </div>
                        <div class="columna-1 columna-hd-1"></div>
                        <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                            <div class="frmCont">
                                <label for="txtOcupacion">Ocupación:</label>
                                <input value="<?php echo $queryInformacionPersonal->ocupacion ?>" type="text" class="input_data" data-rule-required="true" data-rule-RE_LatinCharacters="true" id="txtOcupacion" name="txtOcupacion" autocomplete="off" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="fila">
                        <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                            <div class="frmCont">
                                <label for="txtProfesion">Profesión:</label>
                                <input disabled value="<?php echo $queryInformacionPersonal->profesion ?>" type="text" id="txtProfesion">
                            </div>
                        </div>
                        <div class="columna-1 columna-hd-1"></div>
                        <div class="columna-3 columna-hd-4 columna-movil--10 columna-tablet--10">
                            <div class="frmCont">
                                <label for="txtTipoAfiliacion">Tipo afiliacion:</label>
                                <input disabled value="<?php echo $queryInformacionPersonal->descripcionAfiliacion ?>" type="text" id="txtTipoAfiliacion">
                            </div>
                        </div>
                    </div>



                </div>


            </div>

            <div class="modal-footer n_flex n_justify_end">
                <button type="button" class="btn-cerrar-modal btn btn-cancelar" name="button">Salir</button>
            </div>

        </div>
    </div>
    <!-- fin modal I.P -->


    <script>
        function verInf(id) {
            window.location.assign(url + "HistoriaClinicaDMC/ctrlConsultarInformacionPersonal/informacion/" + btoa(id) + "");
        }

    </script>
