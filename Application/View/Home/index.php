<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>CAD</title>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <!-- Es necesario que se carge primero para el preloader -->
  <link rel="stylesheet" href="<?=URL?>Public/Css/main.css">
  <script src="<?=URL?>Public/Js/Lib/jquery-1.11.3.min.js" charset="utf-8"></script>
  <script src="<?=URL?>Public/Js/Todos/_header.js" charset="utf-8"></script>
  <!-- ...................................................... -->
  <link rel="stylesheet" href="<?=URL?>Public/Css/Todos/animate.css">
  <link rel="stylesheet" href="<?=URL?>Public/Css/user.css">
</head>
<body>
  <!-- PRELOADER -->
  <div id="preloader">
    <div id="img_preloader"></div>
  </div>
  <!-- FIN PRELOADER -->
  <header>

    <div class="toggle_mobile_menu mobile_bar header-btn">
      <span class="fa fa-bars"></span>
    </div>

    <div class="header-menus">

      <!-- LOGOTIPO DE LA APLICACIÓN -->
      <div class="header-logo">
        <span class="fa fa-times cerrar-menu-movil"></span>
        <a href="<?=URL?>">
          <img src="<?=URL?>Public/Img/Todos/Logo3.png">
        </a>
      </div>

      <nav class="menu-main">
        <ul class="main_list">
          <li class="view">
            <a href="#home">Inicio</a>
          </li>
          <li class="view">
            <a href="#about">Acerca</a>
          </li>
          <li class="view">
            <a href="#learn">Aprender</a>
          </li>
          <li class="view">
            <a href="#joinUp">Únase</a>
          </li>
          <li class="view">
            <a href="#contact">Contáctenos</a>
          </li>
        </ul>
      </nav>

    </div>

    <div class="header-menus">

      <nav class="menu-main align_end">
        <ul class="main_list">

          <li class="view"><a href="<?=URL?>Usuarios/ctrlRegistrarPersonaExterna">Registrarse</a></li>
          <li class="view"><a href="<?=URL?>Home/ctrlLogin">Ingresar</a></li>

        </ul>
      </nav>

    </div>

  </header>

  <div class="mobile_menu">

    <div class="icon">

      <div class="toggle_mobile_menu closeM fa fa-close"></div>

      <img class="logotipo" draggable="false" src="<?=URL?>Public/Img/Todos/Logo3.png">

    </div>

    <div class="items">
      <ul>

        <li class="view">
          <a href="#home">Inicio</a>
        </li>
        <li class="view">
          <a href="#about">Acerca</a>
        </li>
        <li class="view">
          <a href="#learn">Aprender</a>
        </li>
        <li class="view">
          <a href="#joinUp">Únete</a>
        </li>
        <li class="view">
          <a href="#contact">Contáctanos</a>
        </li>

      </ul>
    </div>

  </div>

  <!-- SECCIÓN INICIO -->
  <section class="section fondo_img" id="home">
    <div class="n_flex_col100 n_flex n_align_center n_justify_center lg_justify_start whole_wrapper">
      <div class="title_container">
        <div class="title">
          <div class="icon animated bounce">
            <span class="fa fa-stethoscope"></span>
          </div>
          <div class="text animated fadeInDown">
            <h1 >Bienvenido a <span>CAD</span></h1>
            <h5>Central Automatizada de Despacho</h5>
          </div>
          <div class="go animated fadeInDown"><a href="#about"><span class="fa fa-arrow-down"></span></a></div>
        </div>
      </div>
    </div>
  </section>
  <!-- FIN SECCIÓN INICIO -->


  <!-- SECCIÓN DE ACERCA -->
  <section class="section" id="about">
    <div class="section_contenido n_flex  n_in_columns n_align_center">

      <!-- QUE ES CAD -->
      <div class="cont_description fondo_img">
        <div class="description n_flex_col100 horizontal_padding  ">
          <div class="n_flex n_in_columns n_align_center n_flex_col100 whole_wrapper">
            <h2 class="title">¿ Qué es <strong>CAD</strong>?</h2>
            <hr class="separator block">
          </div>
          <article>
            <strong>CAD</strong> (Central Automatizada de Despacho) es un aplicativo web que pretende facilitar la adquisición de habilidades y destrezas en el uso de TIC, en los procesos de formación de las áreas asistenciales y administrativos en salud, CAD busca suplir la necesidad de atención pre hospitalaria y atención domiciliaria, permitiendo a los aprendices transmitir datos en un tiempo de respuesta mínimo, manejando los procesos  en el área de APH (Gestión de reporte inicial, despacho de ambulancias mediante la geolocalización de las mismas, atención del paciente y reporte de historia clínica); en el proceso de atención domiciliaria se gestionará la agenda de médicos, registro de citas a pacientes, kit médicos, e historia clínica de cada atención, órdenes médicas, procedimientos realizados y ordenados al paciente durante la atención.
          </article>
        </div>
      </div>


      <!-- SERVICIOS  -->
      <div class="n_flex n_flex whole_wrapper vertical_padding n_justify_around">

        <!-- APH -->
        <div class="n_flex n_flex_col100 lg_flex_col50 horizontal_padding vertical_padding  panel_services">
          <h3>En Atención Pre hospitalaria Puede:</h3>

          <div class="n_flex_col100 md_flex_col50 service text-center">
            <div class="single_service ">
              <div class="ico"><i class="fa fa-comments"></i></div>
            </div>
            <h4>Llamar y Chatear</h4>
            <p>Gestiona las llamadas y chats de la comunidad.</p>
          </div>
          <div class="n_flex_col100 md_flex_col50 service text-center">
            <div class="single_service ">
              <div class="ico"><i class="fa fa-ambulance"></i></div>
            </div>
            <h4>Gestionar Ambulancias</h4>
            <p>Realiza despachos de ambulancias a través de geolocalización.</p>
          </div>
          <div class="n_flex_col100 md_flex_col50 service text-center">
            <div class="single_service ">
              <div class="ico"><i class="fa fa-file-text"></i></div>
            </div>
            <h4>Realizar Reportes APH</h4>
            <p>Gestiona de una manera más eficiente la creación de historias clínicas de atención pre hospitalaria.
            </p>
          </div>
          <div class="n_flex_col100 md_flex_col50 service text-center">
            <div class="single_service ">
              <div class="ico"><i class="fa fa-medkit"></i></div>
            </div>
            <h4>Controlar Stock de Ambulancias</h4>
            <p>Gestiona rápidamente los insumos de las ambulancias.
            </p>
          </div>
        </div>

        <!-- DOMICILIARIA -->
        <div class="n_flex n_flex_col100 lg_flex_col50 horizontal_padding vertical_padding  panel_services">
          <h3>En Atención Domiciliaria Puede:</h3>

          <div class="n_flex_col100 md_flex_col50 service text-center">
            <div class="single_service ">
              <div class="ico"><i class="fa fa-user-md"></i></div>
            </div>
            <h4>Gestionar Citas</h4>
            <p> Genera y controla las citas para los pacientes. </p>
          </div>
          <div class="n_flex_col100 md_flex_col50 service text-center">
            <div class="single_service ">
              <div class="ico"><i class="fa fa-briefcase"></i></div>
            </div>
            <h4>Gestionar los Kit Médicos</h4>
            <p>Crea y controla en todo momento los kits médicos de las atenciones.</p>
          </div>
          <div class="n_flex_col100 md_flex_col50 service text-center">
            <div class="single_service ">
              <div class="ico"><i class="fa fa-calendar"></i></div>
            </div>
            <h4>Agendar Personal</h4>
            <p>Maneja de forma rápida e interactiva la agenda del personal.
            </p>
          </div>
          <div class="n_flex_col100 md_flex_col50 service text-center">
            <div class="single_service ">
              <div class="ico"><i class="fa fa-file-text-o"></i></div>
            </div>
            <h4>Realizar Historia Clínica</h4>
            <p>Gestiona eficientemente la creación de historias clínicas de atención domiciliaria.
            </p>
          </div>
        </div>

      </div>
      <!-- FIN SERVICIOS -->
    </div>
  </section>
  <!-- FIN SECCIÓN DE ACERCA -->


  <!-- SECCIÓN DE APRENDER -->
  <section class="section " id="learn">
    <div class="section_contenido horizontal_padding">
      <div class="n_flex n_in_columns n_align_center n_flex_col100 whole_wrapper">
        <h2 class="title">¡ Aprenda a utilizar <strong>CAD</strong> !</h2>
        <hr class="separator block">
      </div>

      <!-- GALERIA DE VIDEOS E IMAGENES -->
      <div class="galery n_flex ">
        <div class="container_video">
          <img src="<?=URL?>Public/Img/Todos/v1.png" alt="Video 1">
          <div class="mascara">
            <button class="btn learnVideo" video="https://www.youtube.com/embed/xmqhnr4Lv-c">Ver video</button>
          </div>
        </div>
        <div class="container_video">
          <img src="<?=URL?>Public/Img/Todos/v2.png" alt="Video 2">
          <div class="mascara">
            <button class="btn learnVideo" video="https://www.youtube.com/embed/xmqhnr4Lv-c">Ver video</button>
          </div>
        </div>
        <div class="container_video">
          <img src="<?=URL?>Public/Img/Todos/v3.png" alt="Video 3">
          <div class="mascara">
            <button class="btn learnVideo" video="https://www.youtube.com/embed/xmqhnr4Lv-c">Ver video</button>
          </div>
        </div>
        <div class="container_video">
          <img src="<?=URL?>Public/Img/Todos/v4.png" alt="Video 4">
          <div class="mascara">
            <button class="btn learnVideo" video="https://www.youtube.com/embed/xmqhnr4Lv-c">Ver video</button>
          </div>
        </div>
        <div class="container_video">
          <img src="<?=URL?>Public/Img/Todos/v5.png" alt="Video 5">
          <div class="mascara">
            <button class="btn learnVideo" video="https://www.youtube.com/embed/xmqhnr4Lv-c">Ver video</button>
          </div>
        </div>
        <div class="container_video">
          <img src="<?=URL?>Public/Img/Todos/v6.png" alt="Video 6">
          <div class="mascara">
            <button class="btn learnVideo" video="https://www.youtube.com/embed/xmqhnr4Lv-c">Ver video</button>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- FIN SECCIÓN DE APRENDER -->


  <!-- SECCIÓN DE ÚNASENOS -->
  <section class="section" id="joinUp">
    <div class="section_contenido n_flex  n_in_columns n_align_center">

      <!-- ÚNASE A  CAD -->
      <div class="cont_description fondo_img">
        <div class="description n_flex_col100 horizontal_padding ">
          <div class="n_flex n_in_columns n_align_center n_flex_col100 whole_wrapper block">
            <h2 class="title"> Únase a <strong>CAD</strong></h2>
            <hr class="separator block">
          </div>

          <div class="n_flex n_flex_col100 n_justify_around user_types">

            <!-- Registrarse -->
            <div class="n_flex_col100 lg_flex_col35 md_flex_col45 block">
              <div class="tajeta">
                <figure class="head">
                  <img src="<?=URL?>Public/Img/Todos/reg.png"/>
                </figure>
                <div class="body">
                  <h4 class="">Regístrese, es gratis</h4>
                  <p>
                    Regístrese en CAD y sea parte de esta creciente comunidad, con el solo hecho de unirse obtendrá un montón de beneficios que puede que usted, sus amigos, conocidos o familia necesiten en algún momento, no se arrepentirá.
                  </p>
                </div>
                <div class="foot">
                  <a href="<?=URL?>Usuarios/ctrlRegistrarPersonaExterna" class="btn btn-registrar">Registrarme</a>
                </div>
              </div>
            </div>

            <!-- Iniciar Sesión -->
            <div class="n_flex_col100 lg_flex_col35 md_flex_col45 block">
              <div class="tajeta">
                <figure class="head">
                  <img src="<?=URL?>Public/Img/Todos/ini2.png"/>
                </figure>
                <div class="body">
                  <h4 class="">¿ Está de regreso ?</h4>
                  <p>
                    Si ya es parte de la comunidad, simplemente inicie sesión y mire lo nuevo que tenemos para usted, recuerde que puede contactarnos en cualquier momento, ya sea a través de chat o llamada, recuerde que para llamar necesita una app VoIP.
                    <br><br>
                    <a href="http://www.zoiper.com/en"><strong id="appR"></strong> http://www.zoiper.com/en </a>
                  </p>
                </div>
                <div class="foot">
                  <a href="<?=URL?>Home/ctrlLogin" class="btn btn-consultar">Iniciar Sesión</a>
                </div>
              </div>
            </div>


          </div>

        </div>
      </div>
    </div>
  </section>
  <!-- FIN SECCIÓN DE ÚNETENOS -->


  <!-- SECCIÓN DE CONTACTANOS -->
  <section class="section" id="contact">
    <div class="section_contenido n_flex  n_in_columns n_align_center">

      <div class="cont_description fondo_img">
        <div class="description n_flex_col100 horizontal_padding  ">
          <div class="n_flex n_in_columns n_align_center n_flex_col100 whole_wrapper">
            <h2 class="title"><strong>Contáctenos</strong></h2>
            <hr class="separator block">
          </div>

          <div class="info_contact n_flex n_justify_around">
            <div class="n_flex_col100 sm_flex_col30 contact"> <i class="fa fa-map-marker fa-2x"></i>
              <p class="dark">Calle 51 No. 57-70 Medellín</p>
            </div>
            <div class="n_flex_col100 sm_flex_col30 contact"> <i class="fa fa-envelope-o fa-2x"></i>
              <p class="dark">sena.edu.co</p>
            </div>
            <div class="n_flex_col100 sm_flex_col30 contact"> <i class="fa fa-phone fa-2x"></i>
              <p class="dark"> +57 4 5760000 | VoIP 3245343665 </p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
  <!-- FIN SECCIÓN DE CONTACTANOS -->


  <!-- VER VIDEO -->
  <div class="verVideo n_flex n_justify_center n_align_center">
    <div class="fa fa-close" id="cerrarVideo"></div>
    <iframe id="iframeVideo" src="" frameborder="0" allowfullscreen></iframe>
  </div>
  <!-- FIN VER VIDEO -->

  <section class="footer"><p>Copyright (c) 2016 Copyright Holder All Rights Reserved.</p></section>



  <!-- SCRIPTS -->
  <script type="text/javascript">const url = '<?=URL?>'</script>
  <script src="<?=URL?>Public/Js/Todos/notify.js"></script>
  <script src="<?=URL?>Public/Js/Todos/script.js"></script>
  <script src="<?=URL?>Public/Js/Todos/user.js"></script>
</body>
</html>
