<!-- Login CAD -->
<!-- Login CAD -->
<head>
  <meta charset="UTF-8">
  <title>Proyecto salud</title>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <!-- Es necesario que se carge primero para el preloader -->
  <link rel="stylesheet" href="<?=URL?>Public/Css/main.css">
  <script src="<?=URL?>Public/Js/Lib/jquery-1.11.3.min.js" charset="utf-8"></script>
  <script src="<?=URL?>Public/Js/Todos/_header.js" charset="utf-8"></script>
  <!-- ...................................................... -->
  <link rel="stylesheet" href="<?=URL?>Public/Css/Home/login.css">
  <link rel="stylesheet" href="<?=URL?>Public/Css/user.css">
  <link rel="stylesheet" href="<?=URL?>Public/Css/Todos/sweetalert.css">
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
            <a href="<?=URL?>#home">Inicio</a>
          </li>
          <li class="view">
            <a href="<?=URL?>#about">Acerca</a>
          </li>
          <li class="view">
            <a href="<?=URL?>#learn">Aprender</a>
          </li>
          <li class="view">
            <a href="<?=URL?>#joinUp">Únase</a>
          </li>
          <li class="view">
            <a href="<?=URL?>#contact">Contáctenos</a>
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
          <a href="<?=URL?>#home">Inicio</a>
        </li>
        <li class="view">
          <a href="<?=URL?>#about">Acerca</a>
        </li>
        <li class="view">
          <a href="<?=URL?>#learn">Aprender</a>
        </li>
        <li class="view">
          <a href="<?=URL?>#joinUp">Únete</a>
        </li>
        <li class="view">
          <a href="<?=URL?>#contact">Contáctanos</a>
        </li>

      </ul>
    </div>

  </div>

  <section class="n_flex" id="home">
    <div class="logotipo_cad n_flex n_grow_up n_align_center n_justify_center lg_justify_start ">
      <div class="title_container n_grow_up">
        <div class="title">
          <div class="icon animated bounce">
            <span class="fa fa-stethoscope"></span>
          </div>
          <div class="text animated fadeInDown">
            <h1>Bienvenido a <span>CAD</span></h1>
            <h5>Central Automatizada de Despacho</h5>
          </div>
        </div>
      </div>
    </div>

    <div class="login_section n_flex n_in_columns">

      <div class="n_flex complement n_flex_col30 mitad_1 relative_element" style="min-height: 200px;">
        <div class="n_flex n_grow_up block n_align_center n_justify_center">
          <img draggable="false" src="<?=URL?>Public/Img/Todos/Logo3.png" id="logoLogin">
        </div>
      </div>

      <div class="cont_bola_sep relative_element n_flex n_justify_center">
        <div class="border_bola">
          <div class="bola_separacion"><i class="fa fa-user" aria-hidden="true"></i></div>
        </div>
      </div>

      <div class="login_form n_flex n_align_center n_justify_center n_flex_col70 mitad_2 scroll_y">
        <form id="frmLogin" class="n_grow_up"  action="<?=URL?>Home/ctrlLogin/validarUsuario" method="POST">
          <h2>Iniciar Sesión</h2>

          <div class="frmCont">
            <label for="txtUsuario">Usuario</label>
            <div class="frmInput">
              <input type="text" name="txtUsuario" id="txtUsuario" class="input_data" data-rule-required="true" autocomplete="off">
            </div>
          </div>
          <div class="frmCont">
            <label for="txtClave">Contraseña</label>
            <div class="frmInput">
              <input type="password" name="txtClave" id="txtClave" class="input_data" data-rule-required="true" autocomplete="off">
            </div>
          </div>
          <div class="n_flex n_grow_up">
            <button id="btnLogin" type="submit" class="btn btn-registrar">Ingresar</button>
          </div>
          <br>
          <div class="vertical_paddin">
            <label for="">¿Olvidó su contraseña?</label> <br><a class="btn-modal" id="btnSolicitarCodigo" style="cursor:pointer;">Solicitar código de restablecimiento</a><br><a class="btn-modal" id="btnRestablecerCodigo" style="cursor:pointer;">Restablecer contraseña</a>
          </div><br>

        </form>
      </div>

    </div>
  </section>

  <!--
  <div class="n_flex" style="z-index: 100;">
  <div class="n_flex n_in_columns n_align_center n_flex_col100">
  <h2 class="title">Iniciar <strong>Sesión</strong></h2>
  <hr class="separator block">
</div>
<div class="n_flex_col5 sm_flex_col15">
</div>

<div class="n_flex_col90 sm_flex_col70 panel-login">
<div class="n_flex">

<div class="n_flex_col100 md_flex_col50 n_justify_center form-login">
<form id="frmLogin" name="frmLogin"  action="<?=URL?>Home/ctrlLogin/validarUsuario" method="POST">
<div class="frmCont">
<label for="txtUsuario">Usuario:</label>
<div class="frmInput">
<input data-rule-required="true" type="text" name="txtUsuario" id="txtUsuario" class="input_data">
</div>
</div>
<div class="frmCont">
<label for="txtClave">Contraseña:</label>
<div class="frmInput">
<input data-rule-required="true" type="password" name="txtClave" id="txtClave" class="input_data">
</div>
</div>
<div class="text-center text-olv-cont esp-form">
<button type="button" class="btn btn-cancelar" onclick="location.href='<?=URL?>'">Cancelar</button>&nbsp; &nbsp;
<button id="btnLogin" type="submit" class="btn btn-registrar">Ingresar</button>
</div>

</form><br>

<div class="text-center text-olv-cont esp-form">

<label for="">¿Olvidó su contraseña?</label> </br><a class="btn-modal" id="btnSolicitarCodigo" style="cursor:pointer;">Solicitar código de restablecimiento</a></br><a class="btn-modal" id="btnRestablecerCodigo" style="cursor:pointer;">Restablecer contraseña</a>


</div>
</div>
<div class="sm_flex_none md_flex_col50 n_justify_center">
<img src="<?=URL?>Public/Img/Todos/reg.png" style="height:100%; width:100%;"/>
</div>
</div>
</div>
<div class="n_flex_col5 sm_flex_col15">

</div>

</div> -->

<script>
var loginError;
<?php if(isset($loginError)): ?>
loginError = <?=$loginError?>;
<?php else: ?>
loginError = false;
<?php endif; ?>
</script>

</section>
<script type="text/javascript">const url = '<?=URL?>'</script>
<script src="<?=URL?>Public/Js/Lib/jquery.validate.js" charset="utf-8"></script>
<script src="<?=URL?>Public/Js/Lib/additional-methods.min.js" charset="utf-8"></script>
<script src="<?=URL?>Public/Js/Validaciones/Functions_Validation.js" charset="utf-8"></script>
<script src="<?=URL?>Public/Js/Lib/messages_es.min.js" charset="utf-8"></script>
<script src="<?=URL?>Public/Js/Lib/select2.js" charset="utf-8"></script>
<script src="<?=URL?>Public/Js/Todos/notify.js" charset="utf-8"></script>
<script src="<?=URL?>Public/Js/Todos/script.js" charset="utf-8"></script>
<script src="<?=URL?>Public/Js/Home/login.js" charset="utf-8"></script>
<script src="<?=URL?>Public/Js/Todos/modal.js" charset="utf-8"></script>
<script src="<?=URL?>Public/Js/Todos/sweetalert.js" charset="utf-8"></script>
<script src="<?=URL?>Public/Js/Todos/user.js"></script>
<script src="<?=URL?>Public/Js/Todos/_header.js"></script>
</body>
</html>
