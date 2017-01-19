<div class="n_flex n_justify_center">
    <div class="n_flex n_flex_col100 sm_flex_col100">
        <div class="n_flex n_flex_col100 n_justify_around">
            <!-- TITULO VISTA -->
            <div class="n_flex n_flex_col100">
                <h1 class="titulo_vista"><span class="fa fa-calendar-check-o"></span>Citas</h1>
            </div>
            <div class="n_flex n_flex_col100 horizontal_padding" id="panelCita">
                <div class="panel block n_flex n_in_columns">
                    <div class="horizontal_padding vertical_padding">
                        <div class="barra-filtro ">

                            <!--BÓTON DE CONFIGURACIÓN-->
                            <div class=" btn-barra-filtro " id="btnBuscar"><span class="fa fa-search"></span></div>
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
                            <form class="menu-filtro " style="display: none;" id="frmFiltroCita">

                                <!--OPCIONES DE FILTRO-->
                                <div class="contenido-menu-filtro">
                                    <h5 class="toggle"><span class="fa fa-wrench"></span>Opciones de Filtro</h5>
                                    <div class="contenedor n_flex n_justify_around" id="filtro-general" style="display: none;">
                                        <div class="contenedor-input  n_flex n_flex_col50 lg_flex_col50 md_flex_col100">
                                            <label for="">N° de registros:</label>
                                            <select class="limit" name="limit">
                                                <option value="6">6</option>
                                                <option value="12">12</option>
                                                <option value="21">21</option>
                                                <option value="50">50</option>
                                                <option value="" id="limiteTodos">Todos</option>
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
                                                <option value="1">Primer Nombre</option>
                                                <option value="2">Primer Apellido</option>
                                                <option value="3">Numero Documento</option>
                                                <option value="4">Direccion</option>
                                            </select>
                                        </div>
                                    </div>
                                </div><!--FIN OPCIONES DE BÚSQUEDA-->

                            </form> <!-- FIN MENÚ DE CONFIGURACIÓN-->

                        </div>
                    </div>
                    <div class="panel-contenido scroll-panel">
                        <ul class="list_panel relative_element n_flex n_justify_start block" id="cont">
                        </ul>
                        <!-- PAGINADOR-->
                    </div>
                    <div class="horizontal_padding vertical_padding n_flex n_justify_end" style="border-top: solid 1px #CFCFCF; box-shadow: 0 0px 7px rgba(0,0,0,0.2);;"><ul class="paginador" id="paginadorDinamico" ></ul></div>
                </div>
            </div>
            <div class="horizontal_padding" style="display:none" id="panelDerecho">
                <div class="panel block">
                    <div class="panel-contenido scroll-panel">
                        <div class="vertical_padding horizontal_padding n_flex n_justify_end">
                            <h3>Detalles</h3>
                            <div class="header-btn separate" style="margin-left:5px;">
                                <button class=" btn btn-cancelar" id="btnCerrar">
                                    <span class="fa fa-times"></span>
                                </button>
                            </div>
                        </div>
                        <hr>
                        <div class="n_flex">
                            <div class="n_flex lg_flex_col50 xl_flex_col50 sm_flex_col50 xs_flex_col50">
                                <p class="paragraph">
                                    <span class="text_bold font-Blue">Nombre:</span><br>
                                    <label for="" id="lblNombre"></label>
                                </p>
                            </div>
                            <div class="n_flex lg_flex_col50 xl_flex_col50 sm_flex_col50 xs_flex_col50">
                                <p class="paragraph">
                                    <span class="text_bold font-Blue">Apellido:</span><br>
                                    <label for="" id="lblApellido"></label>
                                </p>
                            </div>
                            <div class="n_flex lg_flex_col100 xl_flex_col100 sm_flex_col100 xs_flex_col100">
                                <p class="paragraph">
                                    <br><span class="text_bold font-Blue">Tipo Documento:</span>
                                    <label for="" id="lblTDocumento"></label>
                                </p>
                            </div>
                            <div class="n_flex lg_flex_col100 xl_flex_col100 sm_flex_col100 xs_flex_col100">
                                <p class="paragraph">
                                    <br><span class="text_bold font-Blue">N° Documento:</span>
                                    <label for="" id="lblDocumento"></label>
                                </p>
                            </div>

                        </div>
                        <br><hr>
                        <div class="n_flex">
                            <div class="n_flex lg_flex_col100 xl_flex_col100 sm_flex_col100 xs_flex_col100">
                                <p class="paragraph">
                                    <span class="text_bold font-Blue">Hora Inicial:</span>
                                    <label for="" id="lblHi"></label>
                                </p>
                            </div>
                            <div class="n_flex lg_flex_col100 xl_flex_col100 sm_flex_col100 xs_flex_col100">
                                <p class="paragraph">
                                    <span class="text_bold font-Blue">Hora Final:</span>
                                    <label for="" id="lblHf"></label>
                                </p>
                            </div>
                        </div>
                        <br><hr>
                        <div class="n_flex">

                          <div class="n_flex lg_flex_col100 xl_flex_col100 sm_flex_col100 xs_flex_col100">
                              <p class="paragraph">
                                  <span class="text_bold font-Blue">Codigo CUP:</span>
                                  <label for="" id="lblCodigoCup"></label>
                              </p>
                          </div>
                          <div class="n_flex lg_flex_col100 xl_flex_col100 sm_flex_col100 xs_flex_col100">
                              <p class="paragraph">
                                  <span class="text_bold font-Blue">Descripcion CUP:</span><br>
                                  <label for="" id="lblCup"></label>
                              </p>
                          </div>
                        </div>
                        <br><hr>
                        <div class="n_flex">
                          <div class="n_flex lg_flex_col100 xl_flex_col100 sm_flex_col100 xs_flex_col100">
                              <p class="paragraph">
                                  <span class="text_bold font-Blue">Comuna:</span><br>
                                  <label for="" id="lblComuna"></label>
                              </p>
                          </div>
                            <div class="n_flex lg_flex_col50 xl_flex_col50 sm_flex_col50 xs_flex_col50">
                                <p class="paragraph">
                                    <span class="text_bold font-Blue">Barrio:</span><br>
                                    <label for="" id="lblBarrio"></label>
                                </p>
                            </div>
                            <div class="n_flex lg_flex_col50 xl_flex_col50 sm_flex_col50 xs_flex_col50">
                                <p class="paragraph">
                                    <span class="text_bold font-Blue">Zona:</span><br>
                                    <label for="" id="lblZona"></label>
                                </p>
                            </div>
                            <div class="n_flex lg_flex_col100 xl_flex_col100 sm_flex_col100 xs_flex_col100">
                                <p class="paragraph">
                                    <br><span class="text_bold font-Blue">Direccion:</span><br>
                                    <label for="" id="lblDir"></label>
                                </p>
                            </div>
                        </div>
                        <br><hr>
                        <div class="n_flex">
                          <div class="n_flex llg_flex_col100 xl_flex_col100 sm_flex_col50 xs_flex_col100">
                              <p class="paragraph">
                                  <span class="text_bold font-Blue">Telefono 1:</span>
                                  <label for="" id="lblTelefono1"></label>
                              </p>
                          </div>
                          <div class="n_flex lg_flex_col100 xl_flex_col100 sm_flex_col50 xs_flex_col100">
                              <p class="paragraph">
                                  <span class="text_bold font-Blue">Telefono 2:</span>
                                  <label for="" id="lblTelefono2"></label>
                              </p>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
