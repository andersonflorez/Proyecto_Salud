<!-- <!DOCTYPE html> -->
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Proyecto salud</title>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link rel="stylesheet" href="<?=URL?>Public/Css/main.css">
  <link rel="stylesheet" href="<?=URL?>Public/Css/Todos/sweetalert.css">
  <link rel="stylesheet" href="<?=URL?>Public/Css/Todos/validacion.css">
  <link rel="stylesheet" href="<?=URL?>Public/Css/ReporteInicial/usuario.css">
  <link rel="stylesheet" href="<?=URL?>Public/Css/ReporteInicial/comun.css">
</head>
<body>

  <!-- CONTENEDOR PRINCIPAL -->
  <div class="n_flex whole_wrapper ovf_hidden n_nowrap n_in_columns">

    <!-- CONTENEDOR BARRA LATERAL -->
    <div class="nav_bar n_flex n_align_start n_grow_up">
      <nav class="n_flex n_grow_up">
        <ul class="user_nav n_flex n_grow_up n_justify_between">
          <div class="n_flex">
            <li type="USER" class="nav_option view_nav"><span class="fa fa-user"></span></li>
            <li type="LIST" class="nav_option view_nav"><span class="fa fa-list"></span></li>
            <li type="CHAT" class="nav_option view_nav"><span class="fa fa-comments-o"></span></li>
          </div>
          <li type="nav_option" type="SESION" class="last_li "><a href="http://localhost/PROYECTO_SALUD_DEV/Home/ctrlLogin/CerrarSesion"><span class="fa fa-power-off"></span></a></li>
        </ul>
      </nav>
    </div>

    <!-- FIN CONTENEDOR BARRA LATERAL -->

    <div class="n_flex whole_wrapper ovf_hidden n_nowrap horizontal_padding vertical_padding">


      <!-- CONTENEDOR DATOS PERSONA -->
      <div class="panel-inf-user panel_form global_hide active_panel panel_col vertical_margin horizontal_margin padding_right n_flex md_flex_col45 lg_flex_col40 xl_flex_col25 xxl_flex_col30">
        <div class="n_flex n_in_columns n_grow_up">

          <div class="n_in_columns header_panel_form">
            <div class="n_flex inf-control">
              <div class="n_flex n_justify_center n_grow_up">
                <p class="n_flex">PERFIL</p>
              </div>
            </div>
            <div class="inf-cabecera">
              <div class=" n_flex n_align_center n_justify_center n_wrap">
                <img src="<?=URL . Sesion::getValue('FOTO')?>" draggable="false"/>
              </div>
            </div>
          </div>

          <div class="n_in_columns inf-contenido scroll_y">
            <div class="n_flex n_justify_center title_content">
              <h6>INFORMACIÓN PERSONAL</h6>
            </div>
            <div class="n_flex n_justify_center">
              <div class="datos n_flex n_justify_between">
                <p>Nombre</p>
                <p class=""><?=$usuario->nombre?></p>
              </div>
              <div class="datos n_flex n_justify_between">
                <p>Correo</p>
                <p class=""><?=$usuario->correoElectronico?></p>
              </div>
              <div class="datos n_flex n_justify_between">
                <p>Dirección</p>
                <p class=""><?=$usuario->direccion?></p>
              </div>
              <div class="datos n_flex n_justify_between">
                <p>Teléfono</p>
                <p class=""><?=$usuario->telefono?></p>
              </div>
              <div class="datos n_flex n_justify_between">
                <p>Reportes realizados</p>
                <p class=""><?=$usuario->reportesRealizados?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- FIN CONTENEDOR DATOS PERSONA -->


      <!-- CONTENEDOR LISTA DE CHATS -->
      <div class="panel_list_chat global_hide panel panel_col n_flex n_grow_up padding_right md_flex_col45 lg_flex_col40 xl_flex_col30 xxl_flex_col30">

        <div  class="n_flex n_in_columns n_grow_up">
          <!-- SECCIÓN DE FILTROS DE BÚSQUEDA Y PAGINACIÓN -->
          <div class="panel-cabecera">
            <div class="horizontal_padding vertical_padding">

              <div class="n_flex n_justify_center n_align_start relative_element">

                <!-- FILTROS -->
                <div class="n_grow_up ovf_initial">
                  <!-- BARRA BUSQUEDA -->
                  <div class="barra-filtro ">

                    <!--BÓTON DE CONFIGURACIÓN-->
                    <div id="btn-barra-filtro" class="btn-barra-filtro">
                      <span class="fa fa-search"></span>
                    </div>
                    <!--INPUT DE CONFIGURACIÓN-->
                    <div class="input-barra">
                      <input id="txtBusqueda" placeholder="Búsqueda" class="n_grow_up" type="search" name="filter">
                    </div>
                  </div>
                </div>
                <!-- FIN FILTROS -->

              </div>
            </div>
          </div>

          <!-- CONTENIDO HISTORY CHAT -->
          <div class="scroll_y n_flex n_grow_up n_in_columns">
            <div id="panel_content_history_clean" class="panel_content_history_clean n_flex n_grow_up global_hide">
              <div class="panel-contenido n_flex vertical_padding horizontal_padding n_grow_up">
                <div class="clean_history n_flex n_align_center n_justify_center n_in_columns n_grow_up">
                  <img draggable="false" src="<?=URL?>/Public/Img/ReporteInicial/NoNotify.png">
                  <h4>Historial vacío</h4>
                  <p class="horizontal_padding vertical_padding">Hasta el momento no se ha reportado ninguna emergencia</p>
                </div>
              </div>
            </div>
            <div id="panel_content_history" class="panel_content_history n_flex n_in_columns n_grow_up"></div>
            <div id="panel_no_reports" class="panel_content_history_clean n_flex n_grow_up global_hide">
              <div class="panel-contenido n_flex vertical_padding horizontal_padding n_grow_up">
                <div class="clean_noreports n_flex n_align_center n_justify_center n_in_columns n_grow_up">
                  <img draggable="false" src="<?=URL?>/Public/Img/ReporteInicial/chat.png">
                  <h4>Sin resultados</h4>
                  <p class="horizontal_padding vertical_padding">Ningún chat coincide con los filtros de búsqueda especificados</p>
                </div>
              </div>
            </div>
            <div id="clear_search" class="clear_container n_flex n_align_end n_nowrap horizontal_padding global_hide">
              <span id="clear" class="n_flex">
                <img draggable="false" src="<?=URL?>/Public/Img/ReporteInicial/clean.png">
              </span>
              <div class="n_flex">
                <span class="">Limpiar Búsqueda</span>
              </div>
            </div>
          </div>
          <!-- FIN CONTENIDO HISTORY CHAT -->

        </div>
      </div>
      <!-- FIN CONTENEDOR HISTORYCHAT -->


      <!-- CHAT USUARIO -->
      <div class="panel_chat global_hide panel_col n_flex n_grow_up">

        <!-- SECTION LOAD -->
        <div id="section_load" class="section_load panel n_grow_up">
          <div class="panel-contenido n_flex n_align_center n_justify_center n_grow_up">
            <span class="load" aria-hidden="true"></span>
          </div>
        </div>
        <!-- FIN SECTION LOAD -->

        <!-- SECTION CLEAN -->
        <div id="clean_section" class="n_flex panel">
          <div class="panel-contenido n_flex vertical_padding horizontal_padding">
            <div class="clean_chat n_flex n_justify_end n_align_center n_in_columns clean">
              <img draggable="false" src="<?=URL?>/Public/Img/ReporteInicial/tap.png">
              <h4>Seleccione un chat</h4>
              <p class="horizontal_padding vertical_padding">Seleccione un chat del historial de chats para ver la conversación completa en esta sección.</p>
            </div>
            <div id="emergency_container" class="emergency_container n_flex n_align_end n_nowrap">
              <span id="emergency" class="n_flex emergency_disabled">
                <li class="fa fa-bell-o"></li>
              </span>
              <span class="emergency_label">Reportar Emergencia</span>
            </div>
            <div id="connection_error" class="global_hide emergency_container connection_error n_flex n_align_end n_nowrap">
              <span class="n_flex error_button">
                <li class="fa fa-refresh"></li>
              </span>
              <span class="emergency_label text_bold">Error de conexión</span>
            </div>
          </div>
        </div>
        <!-- FIN SECTION CLEAN -->

        <!-- SECTION CHAT -->
        <div id="section_chat" class="section_chat global_hide panel n_flex n_in_columns">

          <!-- CABECERA CHAT HISTORY-->
          <div id="chat_header" class="chat-header n_flex">
            <div class="n_flex n_grow_up n_nowrap n_justify_between">
              <div class="cont_aph n_flex">
                <img id="img_receptor" src="" class="chat-user-img" draggable="false">
                <div class="inf_aph n_flex n_grow_up n_in_columns">
                  <p id="nombre_receptor"></p>
                  <div class="n_flex n_grow_up n_nowrap n_align_center">
                    <p id="dateChat" class="global_hide"></p>
                    <div class="inline">
                      <span class="line">En linea</span>
                      <i class="icon_line fa fa-circle online"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="n_flex close_history_chat">
                <button type="button" class="button-user-inf" title="Perfil">
                  <i class="fa fa-times" aria-hidden="true"></i>
                </button>
              </div>
            </div>
          </div>

          <!-- CONTENIDO CHAT -->
          <div class="chat-content n_grow_up">
            <div class="chat-history">
              <ul id="chat_history">

              </ul>
            </div>
          </div>

          <!-- ESCRIBIR MENSAJE Y LLAMAR -->
          <div class="chat-message n_flex n_justify_center n_align_center">
            <div class="send-msg n_flex n_grow_up n_justify_center">

              <!-- BOTON LLAMAR -->
              <button type="button" class="button-call n_grow_up n_align_center n_justify_center"><i class="fa fa-phone" aria-hidden="true"></i></button>

              <!-- MENSAJE -->
              <input id="txtChat" type="text" class="n_grow_up" placeholder="Máximo 200 caracteres por mensaje">

              <!-- BOTON ENVIAR MENSAJE -->
              <button id="btnSendMessage" type="button" class="button-send n_grow_up n_justify_center n_align_center">
                <i class="fa fa-paper-plane" aria-hidden="true"></i>
              </button>
            </div>
          </div>
        </div>
        <!-- FIN SECTION CLEAN -->
      </div>
      <!-- FIN CONTENEDOR CHAT -->

    </div>
  </div>
  <!-- FIN CONTENEDOR PRINCIPAL -->
  <script type="text/javascript">const url = '<?=URL?>';</script>
  <script src="<?=URL?>Public/Js/Lib/fancywebsocket.js" charset="utf-8"></script>
  <script src="<?=URL?>Public/Js/Lib/jquery-1.11.3.min.js" charset="utf-8"></script>
  <script src="<?=URL?>Public/Js/ReporteInicial/chat_controller.js" charset="utf-8"></script>
  <script src="<?=URL?>Public/Js/ReporteInicial/socket_usuario.js" charset="utf-8"></script>
  <script src="<?=URL?>Public/Js/Lib/jquery.validate.js" charset="utf-8"></script>
  <script src="<?=URL?>Public/Js/Lib/additional-methods.min.js" charset="utf-8"></script>
  <script src="<?=URL?>Public/Js/Validaciones/Functions_Validation.js" charset="utf-8"></script>
  <script src="<?=URL?>Public/Js/Lib/messages_es.min.js" charset="utf-8"></script>
  <script src="<?=URL?>Public/Js/Lib/select2.js" charset="utf-8"></script>
  <script src="<?=URL?>Public/Js/Todos/notify.js" charset="utf-8"></script>
  <script src="<?=URL?>Public/Js/Todos/script.js" charset="utf-8"></script>
  <script src="<?=URL?>Public/Js/ReporteInicial/funciones_reporte_inicial.js" charset="utf-8"></script>
  <script src="<?=URL?>Public/Js/ReporteInicial/usuario.js" charset="utf-8"></script>
  <script src="<?=URL?>Public/Js/Todos/sweetalert.js" charset="utf-8"></script>
