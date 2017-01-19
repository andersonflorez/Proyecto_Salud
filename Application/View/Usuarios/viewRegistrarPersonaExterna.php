<!DOCTYPE html>
<html>
<head lang="es">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <title>Registro de usuario</title>
  <!-- Es necesario que se carge primero para el preloader -->
  <link rel="stylesheet" href="<?=URL?>Public/Css/main.css">
  <script src="<?=URL?>Public/Js/Lib/jquery-1.11.3.min.js" charset="utf-8"></script>
  <script src="<?=URL?>Public/Js/Todos/_header.js" charset="utf-8"></script>
  <!-- ...................................................... -->
  <link rel="stylesheet" href="<?=URL?>Public/Css/Todos/select2.css">
  <link rel="stylesheet" href="<?=URL?>Public/Css/Todos/validacion.css">
  <link rel="stylesheet" href="<?=URL?>Public/Css/Todos/datepicker.css">
  <link rel="stylesheet" href="<?=URL?>Public/Css/Todos/jquery.timepicker.css">
  <link rel="stylesheet" href="<?=URL?>Public/Css/user.css">
  <style>
  body{
    background:#f5f5f5 !important;
  }

  button[disabled=disabled]{
    background: #2ecc71;
  }
  </style>
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

  <br><br><br><br>
  <!-- CONTENIDO -->
  <div class="n_flex n_justify_center">
    <!-- CONTENIDO VISTA -->
    <div class="n_flex n_flex_col95 sm_flex_col90">
      <div class="n_flex n_flex_col100 n_justify_around">
        <div class="n_flex n_flex_col100">
          <div class="panel block">
            <div class="panel-cabecera">
              <h3>Regístrese</h3>
            </div>
            <div class="panel-contenido">
              <form id="FormPersonaExterna">
                <div class="n_flex">
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo1">Foto</label>
                      <div class="frmInput">
                        <div class="input_file">
                          <input type="text" id="limpiar_foto" class="input_data" disabled="disabled" placeholder="Seleccione un archivo">
                          <div class="btn_group">
                            <input type="file" name="txtFoto" id="txtFoto" data-rule-RE_Image="true" accept="image/*">
                            <button type="button" class="btn">Subir</button>
                          </div>
                        </div>
                        <!-- <input type="file" class="input_data" name="txtFoto" id="txtFoto"  data-rule-RE_Image="true" accept="image/*"> -->
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                  <div class="md_flex_col10">
                  </div>
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio select -->
                    <div class="frmCont">
                      <label for="campo2">Tipo de Documento &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput frmInput_select2">
                        <select type="text" class="input_data" name="slcTipoDocumento" id="slcTipoDocumento" data-rule-required="true" data-rule-RE_Select="0">
                          <option value="0">Seleccione una opción</option>
                        </select>
                      </div>
                    </div>
                    <!-- fin select -->
                  </div>
                </div>
                <div class="n_flex">
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo3">Número de Documento &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" name="txtNumeroDocumento" id="txtNumeroDocumento" data-rule-required="true" data-rule-RE_number_letters="true" data-rule-maxlength="15" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                  <div class="md_flex_col10">
                  </div>
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo4">Primer Nombre &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" data-rule-required="true" name="txtPrimerNombre" id="txtPrimerNombre" data-rule-RE_LatinCharacters="true" data-rule-maxlength="15" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                </div>
                <div class="n_flex">
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo5">Segundo Nombre</label>
                      <div class="frmInput">
                        <input type="text" class="input_data" name="txtSegundoNombre" id="txtSegundoNombre" data-rule-RE_LatinCharacters="true" data-rule-maxlength="15" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                  <div class="md_flex_col10">
                  </div>
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo6">Primer Apellido &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" data-rule-required="true" name="txtPrimerApellido" id="txtPrimerApellido" data-rule-RE_LatinCharacters="true" data-rule-maxlength="15" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                </div>
                <div class="n_flex">
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo7">Segundo Apellido</label>
                      <div class="frmInput">
                        <input type="text" class="input_data" name="txtSegundoApellido" id="txtSegundoApellido" data-rule-RE_LatinCharacters="true" data-rule-maxlength="15" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                  <div class="md_flex_col10">
                  </div>
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo8">Fecha de Nacimiento &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" name="txtFechaNacimiento" id="txtFechaNacimientoo" data-rule-required="true" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                </div>
                <div class="n_flex">
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio select -->
                    <div class="frmCont">
                      <label for="campo9">Género &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <select  class="input_data" name="slcSexo" id="slcSexo" data-rule-RE_Select="0" data-rule-required="true">
                          <option value="0">Seleccione una opción</option>
                          <option value="Masculino">Masculino</option>
                          <option value="Femenino">Femenino</option>
                          <option value="Otro">Otro</option>
                        </select>
                      </div>
                    </div>
                    <!-- fin select -->
                  </div>
                  <div class="md_flex_col10">
                  </div>
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo10">Dirección de Residencia &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" data-rule-required="true" name="txtDireccion" id="txtDireccion" data-rule-maxlength="40" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                </div>
                <div class="n_flex">
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo11">Teléfono &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" name="txtTelefono" id="txtTelefono" data-rule-required="true" data-rule-RE_Numbers="true" data-rule-maxlength="10" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                  <div class="md_flex_col10">
                  </div>
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo12">Correo Electrónico &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" name="txtCorreo" id="txtCorreo" data-rule-required="true" data-rule-RE_Email="true" data-rule-maxlength="50" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                </div>
                <div class="n_flex">
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo14">Departamento de Residencia &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" data-rule-required="true" name="txtDepartamento" id="txtDepartamento" data-rule-RE_LatinCharacters="true" data-rule-maxlength="20" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                  <div class="md_flex_col10">
                  </div>
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo15">Ciudad de Residencia &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" data-rule-required="true" name="txtCiudad" id="txtCiudad" data-rule-RE_LatinCharacters="true" data-rule-maxlength="20" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                </div>
              
                <br>
                <div class="n_flex">
                  <div class="md_flex_col30">
                  </div>
                  <div class="n_flex_col100 md_flex_col40">
                    <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo16">Usuario &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" data-rule-required="true" data-rule-Re_Username="true" name="txtUsuario" id="txtUsuario" data-rule-maxlength="20" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                  <div class="md_flex_col30">
                  </div>
                </div>
                <div class="n_flex">
                  <div class="md_flex_col30">
                  </div>
                  <div class="n_flex_col100 md_flex_col40">
                    <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo17">Contraseña &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="password" class="input_data" data-rule-required="true" data-rule-RE_Passwords2="true" name="txtClave1" id="txtClave1">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                  <div class="md_flex_col30">
                  </div>
                </div>
                <div class="n_flex">
                  <div class="md_flex_col30">
                  </div>
                  <div class="n_flex_col100 md_flex_col40">
                    <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo18">Confirmar contraseña &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="password" class="input_data" name="txtClave2" id="txtClave2" data-rule-required="true" data-rule-RE_Passwords2="true">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                  <div class="md_flex_col30">
                  </div>
                </div>
                <br>
                <div class="n_flex">
                  <div class="n_flex_col100 xs_flex_col50">
                    <center>
                      <button type="button" class="btn btn-cancelar" onclick="location.href='<?=URL?>'">Volver</button>
                    </center>
                  </div>
                  <br> <br>
                  <div class="n_flex_col100 xs_flex_col50">
                    <center>
                      <button type="submit" class="btn btn-registrar" id="btnRegistrarPersona" name="btnRegistrarPersona">Registrar</button>
                    </center>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- FIN CONTENIDO VISTA -->
</body>
</html>
