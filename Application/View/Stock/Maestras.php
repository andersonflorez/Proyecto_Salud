<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Maestras</title>
        <link rel="stylesheet" href="<?= URL ?>Css/main.css" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="<?= URL ?>Css/Stock/style.css">
    </head>

    <body>
        <!--Menu desplegable-->
        <!--Menu adaptable-->
        <nav class="menu_adaptable menu_desktop">
            <!--contenedor de datos usuario-->
            <div class="contenedor_usuario">
                <i class="cerrar" id="cerrar_menu"><i class="fa fa-close"></i></i>
                <div class="datos">
                    <img src="<?php echo URL; ?>Img/Todos/user.png" class="foto_usuario">
                    <div class="dato_usuario">
                        <p class="nombre_usuario">Deramirez</p>
                        <p class="correo">
                            deramirez723@misena.edu.co
                        </p>
                    </div>
                    <div class="icono_arrow">
                        <i class="fa fa-sort-desc"></i>
                    </div>
                </div>
            </div>
            <div class="header_menu"></div>
            <ul class="lista_item_menu" id="lista_primaria">

            </ul>
            <!--//contenedor de datos usuario-->
        </nav>
        <header>
            <!-- LOGO -->
            <div class="menu-izq">
                <div class="logo" id="cont_logo">
                    <span class="menu fa fa-list-ul" id="menu"></span>
                    <a href="#" id="boton_desplegable" class="icon_bar"><i class="fa fa-list-ul"></i></a>
                </div>
            </div>
            <!-- EXTRAS -->
            <div class="Extras">
                <div class="user">
                    <div id="perfil-usuario" style="cursor: pointer;"> <span id="nombreUserSpan"> Deramirez</span><span class="fa fa-caret-down"></span></div>
                </div>
                <div class="menu-desplegable" id="menu_perfil_user">
                    <div class="cont-menu-des">
                        <div class="cont cont-super">
                            <div class="foto">
                                US
                            </div>
                            <div class="datosUser">
                                <p class="nombreUsuario">Deramirez</p>
                                <p class="correoUsuario">deramirez723@misena.edu.co</p>
                                <button type="button" class="btn btn-consultar">Ver Perfil</button>
                            </div>
                        </div>
                        <div class="cont cont-infer">
                            <a href="#"><span class="fa fa-power-off"></span> Cerrar Sesión</a>
                        </div>
                    </div>
                </div><!--menu-desplegable-->
            </div><!--Extras-->
        </header>

        <!--Maestras-Menú-->
        <br>
        <br>
        <br>
        <div class="fila">
            <div class="columna-6 nav">
                <div class="nav-cont">
                    <a href="#" id="item1" class="nav-item">Tipo Devolución</a>
                    <a href="#" id="item2" class="nav-item">Tipo Novedad</a>
                    <a href="#" id="item3" class="nav-item">Tipo Asignación</a>
                    <a href="#" id="item4" class="nav-item">Tipo Categoria Recurso</a>
                 
                </div>
            </div>
        </div>

        <div  class="fila">
            <div class="columna--1">
            </div>

            <!--Tipo antecedente-->

            <div id="Item1" class="panel">
                <div class="panel-cabecera">
                    <center><strong>Tipo Devolución</strong></center>
                </div>
                <div class="panel-contenido">
                    <form id="formtipoAntecedente">
                        <div class="fila">

                            <div class="columna--4 columna-movil--10" style="">
                                <label for="">Descripción</label>
                                <input type="text" name="txttipodevolucion" id="tipodevolucion" placeholder="Descripcion">
                            </div>

                            <div class="columna--1 columna-tablet-1">

                            </div>
                            <div class="columna--2 columna-movil--10">
                                <button type="button" name="button" id="BtnRegistrarTipoDevolucion" class="btn btn-registrar btn-top">Registrar</button>

                            </div>

                        </div>
                    </form>

                    <br><br>
                    <section class="table columna--9" style="">
                        <div class="fila" style="display: none">
                            <div class="columna--3 columna-movil--10" style="">
                                <p>Columna de búsqueda</p>
                                <select name="" id="cmbFiltroTipoDevolucion">
                                    <option value="">Seleccione una opción</option>
                                    <option value="ID">ID</option>
                                    <option value="descripcion">Descripcion</option>
                                    <option value="Estado">Estado</option>
                                </select>
                            </div>
                            <div class="columna--1 columna-tablet-1"></div>
                            <div class="columna--3 columna-tablet-1" id="containerFiltroTipoDevolucion" style="display:none">

                            </div>
                            <div class="columna--1 columna-tablet-1"></div>
                            <div class="columna--2 columna-movil--10">
                                <button type="button" name="button" class="btn btn-consultar"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <br>
                        <table class="adaptable tabla-border" id="TablaTipoDevolucion">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Descripcion</th>
                                    <th>Estado</th>
                                    <th>Actualizar</th>
                                </tr>
                            </thead>
                            <tbody id="TbodyTablaTipoDevolución">

                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
            <div class="columna--1">

            </div>
        </div>
        <!--Modal modificar tipo Devolución-->

        <div class="md-fondo" id="modalDevolución">
            <div class="md-modal md-efecto1">
                <div class="md-titulo"><h5 align="center" id="tituloM">Modificar Devolución</h5>
                    <span  onclick="cerrarModal('modalDevolución')" id="cierre">X</span>
                </div>
                <form id="FormActualizarTipoDevo">
                    <div class="md-content">
                        <div class="fila">
                            <div class="columna--2 columna-tablet-2 columna-movil-9"></div>
                            <div class="columna--6">
                                <input type="text"  name="txtdescripciontipodevolucion" placeholder="Descripcion" id="descripcionTipoDevolucionDev" class="espacio">                   
                            </div>
                            <div class="columna--2 columna-tablet-2 columna-movil-9"></div>
                        </div> 
                        <div class="fila"><br></div>
                        <div class="fila">
                            <div class="columna--3 columna-tablet-2 columna-movil-9"></div>
                            <div class="columna--2">
                                <button type="button" class="btn btn-eliminar" name="btnModificar" onclick="cerrarModal('modalDevoluci)">Cancelar</button>
                            </div>
                            <div class="columna--1 columna-tablet-2 columna-movil-9"></div>
                            <div class="columna--2">
                                <button type="button" class="btn btn-registrar" id="BtnActualizarTipoDevolución" onclick="cerrarModal('modalDevolución')">Guardar</button>
                            </div>
                            <div class="columna--2 columna-tablet-2 columna-movil-9"></div>  
                        </div>
                        <div class="fila"><br></div>
                        <div class="fila"><br></div> 
                    </div>
                </form>
            </div>
        </div>



        <!--Tipo Novedad-->

        <div class="fila">
            <div class="columna--1">

            </div>
            <div id="Item2" class="panel">
                <div class="panel-cabecera">
                    <center><strong>Tipo Novedad</strong></center>
                </div>
                <div class="panel-contenido">
                    <form id="Formnovedad">
                        <div class="fila">

                            <div class="columna--4 columna-movil--10" style="">
                                <label>Descripción</label>
                                <input type="text" name="txdescripcionnovedad" id="descripcionnovedad" value="" placeholder="Descripcion">
                            </div>
                            <div class="columna--1 columna-tablet-1">

                            </div>
                            <div class="columna--4 columna-movil--10">
                                <button type="button" name="button" id="btnRegistrarnovedad" class="btn btn-registrar btn-top">Registrar</button>
                            </div>
                        </div>	
                    </form>
                    <br><br>
                    <section class="table columna--9" style="">
                        <div class="fila" style="display: none">
                            <div class="columna--3 columna-movil--10" style="">
                                <p>Columna de búsqueda</p>
                                <select name="" id="cmbFiltroTipoExamenFisico">
                                    <option value="">Seleccione una opción</option>
                                    <option value="ID">ID</option>
                                    <option value="descripcion">Descripcion</option>
                                    <option value="Estado">Estado</option>
                                </select>
                            </div>
                            <div class="columna--1 columna-tablet-1"></div>
                            <div class="columna--3 columna-tablet-1" id="containerFiltroTipoNovedad" style="display:none">

                            </div>
                            <div class="columna--1 columna-tablet-1"></div>
                            <div class="columna--2 columna-movil--10">
                                <button type="button" name="button" class="btn btn-consultar"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <br>
                        <table class="adaptable tabla-border" id="tablaNovedad">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Descripcion</th>
                                    <th>Estado</th>
                                    <th>Actualizar</th>
                                </tr>
                            </thead>
                            <tbody id="tbodynovedad">


                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
            <div class="columna--1">

            </div>
        </div>

        <!--Modal modificar tipo novedad-->

        <div class="md-fondo" id="modalExamenFisico">
            <div class="md-modal md-efecto1">
                <div class="md-titulo"><h5 align="center" id="tituloM">Modificar Novedad</h5>
                    <span  onclick="cerrarModal('modalNovedad')" id="cierre">X</span>
                </div>
                <form id="Formactualizartiponovedad">
                    <div class="md-content">
                        <div class="fila">
                            <div class="columna--2 columna-tablet-2 columna-movil-9"></div>
                            <div class="columna--6">
                                <input type="text"   name="txtdescripcionnovedad" placeholder="Descripcion" id="descripcionNovedadActualizar" class="espacio">
                                <input type="text" name="txtcodigoNovedad" id="codigonovedad" >
                               
                                <input type="text" name="txtestadonovedad" id="estadonovedad" >
                            </div>
                            <div class="columna--2 columna-tablet-2 columna-movil-9"></div>
                        </div> 
                        <div class="fila"><br></div>
                        <div class="fila">
                            <div class="columna--3 columna-tablet-2 columna-movil-9"></div>
                            <div class="columna--2">
                                <button type="button" class="btn btn-eliminar" name="btnModificar" onclick="cerrarModal('modalNovedad')">Cancelar</button>
                            </div>
                            <div class="columna--1 columna-tablet-2 columna-movil-9"></div>
                            <div class="columna--2">
                                <button type="button" class="btn btn-registrar" id="BtnActualizartiponovedad" onclick="cerrarModal('modalNovedad')">Guardar</button>
                            </div>
                            <div class="columna--2 columna-tablet-2 columna-movil-9"></div>  
                        </div>
                        <div class="fila"><br></div>
                        <div class="fila"><br></div> 
                    </div>
                </form>
            </div>
        </div>


        <!--Tipo Asignación-->

        <div class="fila">
            <div class="columna--1">

            </div>
            <div id="Item3" class="panel">
                <div class="panel-cabecera">
                    <center><strong>Tipo Asignación</strong></center>
                </div>
                <div class="panel-contenido">
                    <form id="FormAsignacion">
                    <div class="fila">
                        <div class="columna--4 columna-movil--10" style="">
                            <label for="">Descripcion</label>
                            <input type="text" name="txtdescripcionAsignacion" id="descripcionsignacion" placeholder="Descripcion">
                        </div>
                        <div class="columna--1 columna-tablet-1">

                        </div>
                        <div class="columna--4 columna-movil--10">
                            <button type="button"   id="btnRegistarasignacion" class="btn btn-registrar btn-top">Registrar</button>
                        </div>
                    </div>
                    </form>

                    <br>
                    <section class="table columna--9" style="">
                        <div class="fila" style="display: none"style="display: none">
                            <div class="columna--3 columna-movil--10" style="">
                                <p>Columna de búsqueda</p>
                                <select name="" id="cmbFiltroTipoOrigenAtencion">
                                    <option value="">Seleccione una opción</option>
                                    <option value="ID">ID</option>
                                    <option value="descripcion">Descripcion</option>
                                    <option value="Estado">Estado</option>
                                </select>
                            </div>
                            <div class="columna--1 columna-tablet-1"></div>
                            <div class="columna--3 columna-tablet-1" id="containerFiltroTipoAsignacion" style="display:none">

                            </div>
                            <div class="columna--1 columna-tablet-1"></div>
                            <div class="columna--2 columna-movil--10">
                                <button type="button"  class="btn btn-consultar"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <br>
                        <table class="adaptable tabla-border" id="TablaAsignacion">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Descripcion</th>
                                    <th>Estado</th>
                                    <th>Actualizar</th>
                                </tr>
                            </thead>
                            <tbody  id="tbodyAsignacion">
                                 
                            </tbody>
                        </table>
                    </section>
                </div>

            </div>
            <div class="columna--1">

            </div>
        </div>

        <!--Modal modificar tipo Asignacion-->

        <div class="md-fondo" id="modalTipoAsignacion">
            <div class="md-modal md-efecto1">
                <div class="md-titulo"><h5 align="center" id="tituloM">Modificar Asignación</h5>
                    <span  onclick="cerrarModal('modalTipoÁsignacion')" id="cierre">X</span>
                </div>
                <div class="md-content">
                    <form id="ActualizarAsignacion">
                    <div class="fila">
                        <div class="columna--2 columna-tablet-2 columna-movil-9"></div>
                        <div class="columna--6">
                            <input type="text"  id="DescripcionAsignacion" name="txtdescripcionasignacion" placeholder="Descripcion" class="espacio">
                            <input type="text"  id="IdAsignacion"  style="display: none" name="txtcodigoasignacion">
                            <input type="text"  id="EstadoOrigen" style="display: none" name="txtestadoasignacion">
                        </div>
                        <div class="columna--2 columna-tablet-2 columna-movil-9"></div>
                    </div> 
                    </form>
                    <div class="fila"><br></div>
                    <div class="fila">
                        <div class="columna--3 columna-tablet-2 columna-movil-9"></div>
                        <div class="columna--2">
                            <button type="button" class="btn btn-eliminar" name="btnModificar" onclick="cerrarModal('modalTipoAsignacion')">Cancelar</button>
                        </div>
                        <div class="columna--1 columna-tablet-2 columna-movil-9"></div>
                        <div class="columna--2">
                            <button type="button" class="btn btn-registrar" id="BtnActualizarAsignacion" name="btnModificar" onclick="cerrarModal('modalTipoAsignacion')">Guardar</button>
                        </div>
                        <div class="columna--2 columna-tablet-2 columna-movil-9"></div>  
                    </div>
                    <div class="fila"><br></div>
                    <div class="fila"><br></div> 
                </div>
            </div>
        </div>


        <!--Tipo Categoria Recurso-->

        <div class="fila">
            <div class="columna--1">

            </div>
            <div id="Item4" class="panel">
                <div class="panel-cabecera">
                    <center><strong>Tipo Categoria Recurso</strong></center>
                </div>
                <div class="panel-contenido">
                    <div class="fila">
                        <div class="columna--4 columna-movil--10" style="">
                            <label>Descripción</label>
                            <input type="text" name="name" value="" placeholder="Descripcion">
                        </div>
                        <div class="columna--2 columna-tablet-1">

                        </div>
                        <div class="columna--4 columna-movil--10">

                        </div>

                    </div>
                    <div class="fila"><br></div>
                    <div class="fila">
                        <div class="columna--4">
                            <label>Categororia</label>
                            <select class="" name="">
                                <option>Seleccione la categoría</option>
                                <option>Tratamiento Básico</option>
                                <option>Tratamiento Avanzado</option>
                            </select>
                        </div>
                        <div class="columna--1"></div>
                        <div class="columna--4">
                            <button type="button" name="button" class="btn btn-registrar btn-top">Registrar</button>
                        </div>
                    </div>

                    <br><br>
                    <section class="table columna--9" style="">
                        <div class="fila">
                            <div class="columna--3 columna-movil--10" style="">
                                <p>Columna de búsqueda</p>
                                <select name="" id="cmbFiltroTipoTratamiento">
                                    <option value="">Seleccione una opción</option>
                                    <option value="ID">ID</option>
                                    <option value="descripcion">Descripcion</option>
                                    <option value="categoria">Categoria</option>
                                    <option value="estado">Estado</option>
                                </select>
                            </div>
                            <div class="columna--1 columna-tablet-1"></div>
                            <div class="columna--3 columna-tablet-1" id="containerFiltroTipoCategoria" style="display:none">

                            </div>
                            <div class="columna--1 columna-tablet-1"></div>
                            <div class="columna--2 columna-movil--10">
                                <button type="button" name="button" class="btn btn-consultar"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <br>
                        <table class="adaptable tabla-border">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Descripcion</th>
                                    <th>Categoría Tratamiento</th>
                                    <th>Estado</th>
                                    <th>Actualizar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Oxigeno</td>
                                    <td>Tratamiento Básico</td>
                                    <th><button type="button" class=" btn btn-registrar btn-status0" name="bntConsultar">Activo</button></th>
                                    <th><button type="button" class="fa fa-pencil btn btn-modificar" name="bntConsultar" onclick="AbrirModal('modalTipoCategoria')"></button></th>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Dextrosa</td>
                                    <td>Tratamiento Avanzado</td>
                                    <th><button type="button" class=" btn btn-registrar btn-status0" name="bntConsultar">Activo</button></th>
                                    <th><button type="button" class="fa fa-pencil btn btn-modificar" name="bntConsultar"></button></th>
                                </tr>
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
            <div class="columna--1">

            </div>
        </div>

       <script>

            var al = "<?= URL ?>";
        </script>

        <script src="<?php echo URL; ?>Js/Lib/jquery-1.11.3.min.js"></script>
        <script src="<?php echo URL; ?>Js/Todos/script.js"></script>
        <script src="<?php echo URL; ?>Js/Todos/modal.js"></script>
        <script src="<?php echo URL; ?>Js/Todos/alerta.js"></script>
        <script src="<?php echo URL; ?>Js/HistoriaClinicaDMC/CRUDMaestras.js"></script>
        <script src="<?php echo URL; ?>Js/HistoriaClinicaDMC/scriptMaestras.js"></script>

        <script>

            $(document).ready(function () {
                tipoAntecedente.init();
                examen.init();
                origenatencion.init();
            });
        </script>
    </body>

</html>
