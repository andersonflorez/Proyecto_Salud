<!DOCTYPE html>
<html lang="es" ng-app="ReporteAPH">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>Proyecto salud</title>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <!-- Es necesario que se carge primero para el preloader -->
  <link rel="stylesheet" href="<?=URL?>Public/Css/main.css">
  <script src="<?=URL?>Public/Js/Lib/jquery-1.11.3.min.js" charset="utf-8"></script>
  <script src="<?=URL?>Public/Js/Todos/_header.js" charset="utf-8"></script>
  <!-- ...................................................... -->
  <link rel="stylesheet" href="<?=URL?>Public/Css/Todos/select2.css">
  <link rel="stylesheet" href="<?=URL?>Public/Css/Todos/validacion.css">
  <link rel="stylesheet" href="<?=URL?>Public/Css/Todos/datepicker.css">
  <link rel="stylesheet" href="<?=URL?>Public/Css/Todos/jquery.timepicker.css">
  <?php

  // El siguiente fragmento de código linkea los CSS de la variable $styles automáticamente:

  if (isset($this->styles)) {
    foreach ($this->styles as $style) {
      ?>
      <link rel="stylesheet" href="<?=URL?>Public/Css/<?=$style?>">
      <?php
    }
  }

  // Para cambio de disponiblidad de ambulancia(ReporteAPH)
  if ( Sesion::varExist('esModoConsulta') )
    $isQueryMode = ( boolval( Sesion::getValue('esModoConsulta') ) ? true : false);
  else
    $isQueryMode = true;

  ?>
</head>
<body>
  <!-- PRELOADER -->
  <div id="preloader">
    <div id="img_preloader"></div>
  </div>
  <!-- FIN PRELOADER -->

  <!-- BARRA DE NAVEGACIÓN -->
  <header>

    <div class="toggle_mobile_menu mobile_bar header-btn">
      <span class="fa fa-bars"></span>
    </div>

    <!-- MENÚ PRINCIPAL DE LA APLICACIÓN -->
    <div class="header-menus">

      <!-- LOGOTIPO DE LA APLICACIÓN -->
      <div class="header-logo">
        <span class="fa fa-times cerrar-menu-movil"></span>
        <a href="<?=URL?>Home/ctrlPrincipal">
          <img src="<?=URL?>Public/Img/Todos/Logo3.png" draggable="false">
        </a>
      </div>

      <nav class="menu-main">
        <ul class="main_list">

          <?php
          $i = 0;
          foreach ( $this->vistasMenu as $vista) {
            if ($i < 3) {
              ?>

              <li class="view">
                <a href="#"><?=$vista->Modulo?></a>
                <ul class="dropdown single_dropdown">

                  <!-- VISTAS -->
                  <?php foreach ($vista->Vistas as $Vista): ?>
                    <li class="view">
                      <a href="<?=URL.$Vista->urlVista?>">
                        <span class="fa fa-<?=$Vista->iconoVista?>"></span>
                        <?=$Vista->descripcionVista?>
                      </a>
                    </li>
                  <?php endforeach ?>
                  <!-- FIN VISTAS -->

                </ul>
              </li>

              <?php
            } else if ($i === 3) {
              ?>
              <li class="view">
                <a href="#">Más <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown dropdown_more">
                  <li class="view">
                    <a href="#">
                      <?=$vista->Modulo?> <i class="fa fa-caret-right"></i>
                    </a>
                    <ul class="dropdown single_dropdown">
                      <?php foreach ($vista->Vistas as $Vista): ?>
                        <li class="view">
                          <a href="<?=URL.$Vista->urlVista?>">
                            <span class="fa fa-<?=$Vista->iconoVista?>"></span>
                            <?=$Vista->descripcionVista?>
                          </a>
                        </li>
                      <?php endforeach ?>
                    </ul>
                  </li>
                  <?php
                } else {
                  ?>
                  <li class="view">
                    <a href="#">
                      <?=$vista->Modulo?> <i class="fa fa-caret-right"></i>
                    </a>
                    <ul class="dropdown single_dropdown">
                      <?php foreach ($vista->Vistas as $Vista): ?>
                        <li class="view">
                          <a href="<?=URL.$Vista->urlVista?>">
                            <span class="fa fa-<?=$Vista->iconoVista?>"></span>
                            <?=$Vista->descripcionVista?>
                          </a>
                        </li>
                      <?php endforeach ?>
                    </ul>
                  </li>
                  <?php
                }
                $i++;
              }
              ?>
            </ul>
          </li>

        </ul>
      </nav>

    </div>

    <div class="header-menus">

      <!-- BOTÓN DE CONFIGURACIÓN -->
      <?php if (Sesion::getValue('TIPO_USUARIO') === 'ADMINISTRADOR'): ?>
        <div class="header-btn">
          <a href="<?=URL?>Maestras/ctrlMaestras" class="fa fa-cogs"></a>
        </div>
      <?php endif; ?>
      <?php if (isset($this->notificaciones) && $this->notificaciones): ?>
        <!-- BOTÓN NOTIFICACIONES REPORTE APH -->
        <div class="header-btn " id="contenedor-notificaciones">
          <a class="fa fa-bell-o <?=isset($numero) ? 'notify-nueva' : ''?>" id="flotante-notify" contador="<?=isset($numero) ? $numero->Numero : ''?>"></a>
        </div>
      <?php endif; ?>

      <?php if (isset($this->menuEmergencia) && $this->menuEmergencia): ?>
        <!-- BOTÓN DE MENÚ EMERGENCIA REPORTE APH -->
        <div class="header-btn" id="menu-emerg">
          <a class="fa fa-th"></a>
        </div>
      <?php endif; ?>

      <?php if (isset($this->cambiarEstadoAmbulancia) && $this->cambiarEstadoAmbulancia): ?>
        <?php if ( isset($isQueryMode) && $isQueryMode ): ?>
          <!-- BOTÓN DISPONIBILIDAD LA AMBULANCIA -->
          <div class="header-btn relative_element" id="cambiar_estado_ambu">
            <a class="fa fa fa-signal"></a>
          </div>
        <?php endif; ?>
      <?php endif; ?>

      <!-- BOTÓN CERRAR SESIÓN MOVIL -->
      <div class="header-btn sign_out">
        <a href="<?=URL?>Home/ctrlLogin/CerrarSesion" class="fa fa-power-off"></a>
      </div>

      <!-- SECCIÓN DE USUARIO -->
      <div class="header-user">
        <!-- EXTRAS -->
        <div class="extras">
          <!-- NOMBRE DE USUARIO -->
          <div class="user header-btn" id="perfil-usuario">
            <span id="nombreUserSpan"><?=str_replace('\"', "", Sesion::getValue('NOMBRES'))?></span>
            <span class="fa fa-caret-down"></span>
          </div>

          <!-- DESPLEGABLE DE INFORMACIÓN DE USUARIO -->
          <div class="menu-desplegable" id="menu_perfil_user">
            <div class="relative_element">
              <div class="cont-menu-des">

                <div class="cont cont-super">
                  <div class="foto" id="tamano">

                    <img draggable="false" src=<?php echo URL.str_replace("/","\\",Sesion::getValue('FOTO'))?> style="width:90px !important; height:90px !important;">

                  </div>
                  <div class="datosUser n_flex n_in_columns n_justify_between">
                    <div class="n_flex n_in_columns">
                      <span class="nombreUsuario" id="nombre">
                        <?=Sesion::getValue('NOMBRES') . ' ' . Sesion::getValue('APELLIDOS')?>
                      </span>
                      <span class="correoUsuario" id="usuario" title="<?php echo Sesion::getValue('USUARIO') ?>">
                        <?php
                        if(strlen(Sesion::getValue('USUARIO'))<=29){
                          echo Sesion::getValue('USUARIO');
                        }else{
                          echo substr(Sesion::getValue('USUARIO'),0,26)."...";
                        }
                        ?>
                      </span>
                    </div>
                    <button type="button" class="btn btn-consultar" onclick="location.href='<?=URL?>Home/ctrlPerfil'">Ver Perfil</button>
                  </div>
                </div>

                <div class="cont cont-infer">
                  <a href="<?=URL?>Home/ctrlLogin/CerrarSesion"><span class="fa fa-power-off"></span> Cerrar Sesión</a>
                </div>

              </div>
            </div>
          </div><!-- FIN DESPLEGABLE -->
        </div><!-- FIN EXTRAS -->
      </div><!-- FIN SECCION USUARIO -->
    </div>

  </header>
  <!-- FIN BARRA DE NAVEGACIÓN -->

  <div class="mobile_menu">
    <div class="icon">

      <div class="toggle_mobile_menu closeM fa fa-close"></div>

      <img class="foto_usuario" draggable="false" src="<?=URL . Sesion::getValue('FOTO')?>">


      <div class="info" title="<?php echo Sesion::getValue('USUARIO') ?>">
        <?php
        if(strlen(Sesion::getValue('USUARIO'))<=32){
          echo Sesion::getValue('USUARIO');
        }else{
          echo substr(Sesion::getValue('USUARIO'),0,32)."...";
        }
        ?>
      </div>

      <div class="info">
        <a href="<?=URL?>Home/ctrlPerfil" class="btn btn-consultar">Ver Perfil</a>
      </div>

    </div>

    <div class="items">
      <ul>
        <?php foreach ( $this->vistasMenu as $vista): ?>

          <li class="view">
            <a href="#"><span class="fa fa-<?=$vista->iconoModulo?>"></span><?=$vista->Modulo?></a>
            <ul class="dropdown">

              <!-- VISTAS -->
              <?php foreach ($vista->Vistas as $Vista): ?>
                <li class="view">
                  <a href="<?=URL.$Vista->urlVista?>">
                    <span class="fa fa-<?=$Vista->iconoVista?>"></span>
                    <?=$Vista->descripcionVista?>
                  </a>
                </li>
              <?php endforeach ?>
              <!-- FIN VISTAS -->

            </ul>
          </li>

        <?php endforeach ?>
      </ul>
    </div>

  </div>

  <section id="main-section-container-page">
