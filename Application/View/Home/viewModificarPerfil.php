<!-- CONTENIDO -->
  <br><div class="n_flex n_justify_center">
  <!-- CONTENIDO VISTA -->
<div class="n_flex n_flex_col95 sm_flex_col90">

    <div class="n_flex n_flex_col100 n_justify_around">
        <div class="n_flex n_flex_col100">
      <div class="panel block">
          <div class="panel-cabecera">
            <h3>Modificar Perfil</h3>
          </div>
          <div class="panel-contenido">
            <form id="FormModificarPerfil">

              <input type="hidden" class="input_data" name="txtIdPersona" id="txtIdPersona" value="<?=$usuario->idPersona?>">
              <input type="hidden" class="input_data" name="txtViejaFoto" id="txtViejaFoto" value="<?=$usuario->urlFoto?>">

               <!-- Contenedor flexible obligatorio: -->
              <div class="n_flex">
                <!-- 100% a partir de 0px, 50% a partir de tablet: -->
                <div class="n_flex_col100 md_flex_col45">
               <!-- Inicio input -->
                  <div class="frmCont">
                    <label for="campo1">Foto</label>
                    <div class="frmInput">
                      <div class="input_file">
                        <input type="text" id="limpiar_files" class="input_data" disabled="disabled" placeholder="Seleccione un archivo" value="<?=$usuario->urlFoto?>">
                        <div class="btn_group">
                          <input type="file" name="txtFoto" id="txtFoto" data-rule-RE_Image="true" accept="image/*">
                          <button type="button" class="btn">Subir</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- fin input -->
                </div>
                <div class="md_flex_col10">
                </div>
                <!-- 100% a partir de 0px, 50% a partir de tablet: -->
                <div class="n_flex_col100 md_flex_col45">
                  <!-- Inicio select -->
                  <div class="frmCont" style="display:none;">
                    <label for="campo2">Tipo de Documento &nbsp <i style="color:red;">*</i></label>
                    <div class="frmInput">
                      <select type="text" class="input_data" name="slcTipoDocumento" id="slcTipoDocumento" value="<?=$usuario->idTipoDocumento?>">
                        <option value="0">Seleccione una opción</option>
                        <?PHP
//                     foreach ($tipoDocumento as $registro) {
//                        echo "<option value='".$registro->idTipoDocumento."'>".$registro->descripcionTdocumento."</option>"; }
                          ?>
                        </select>
                      </div>
                    </div>
                    <!-- fin select -->
                    
                        <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo3">Número de Documento &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" name="txtNumeroDocumento" id="txtNumeroDocumento" data-rule-required="true" data-rule-RE_number_letters="true" value="<?=$usuario->numeroDocumento?>" data-rule-maxlength="15" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                </div>
                <div class="n_flex">
                  <div class="n_flex_col100 md_flex_col45">
                      <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo4">Primer Nombre &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" data-rule-required="true" name="txtPrimerNombre" id="txtPrimerNombre" data-rule-RE_LatinCharacters="true" value="<?=$usuario->primerNombre?>" data-rule-maxlength="15" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                  <div class="md_flex_col10">
                  </div>
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo5">Segundo Nombre</label>
                      <div class="frmInput">
                        <input type="text" class="input_data" name="txtSegundoNombre" id="txtSegundoNombre" data-rule-RE_LatinCharacters="true" value="<?=$usuario->segundoNombre?>" data-rule-maxlength="15" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                </div>
                <div class="n_flex">
                  <div class="n_flex_col100 md_flex_col45">
                 <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo6">Primer Apellido &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" data-rule-required="true" name="txtPrimerApellido" id="txtPrimerApellido" data-rule-RE_LatinCharacters="true" value="<?=$usuario->primerApellido?>" data-rule-maxlength="15" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                  <div class="md_flex_col10">
                  </div>
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo7">Segundo Apellido</label>
                      <div class="frmInput">
                        <input type="text" class="input_data" name="txtSegundoApellido" id="txtSegundoApellido" data-rule-RE_LatinCharacters="true" value="<?=$usuario->segundoApellido?>" data-rule-maxlength="15" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                </div>
                <div class="n_flex">
                  <div class="n_flex_col100 md_flex_col45">
                        <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo9">Fecha de Nacimiento &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" name="txtFechaNacimiento" id="txtFechaNacimiento" data-rule-required="true" value="<?=$usuario->fechaNacimiento?>" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                  <div class="md_flex_col10">
                  </div>
                  <div class="n_flex_col100 md_flex_col45">
                     <!-- Inicio select -->
                    <div class="frmCont" style="display:none;">
                      <label for="campo11">Género  &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <select  name="slcSexo" class="input_data" id="slcSexo" data-rule-required="true" data-rule-RE_Select="0" value="<?=$usuario->sexo?>">
                          <option value="0">Seleccione una opción</option>
                          <option value="Masculino">Masculino</option>
                          <option value="Femenino">Femenino</option>
                          <option value="Otro">Otro</option>
                        </select>
                      </div>
                    </div>
                    <!-- fin select -->
                    
                      <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo14">Dirección de Residencia &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" name="txtDireccion" id="txtDireccion" data-rule-required="true" value="<?=$usuario->direccion?>" data-rule-maxlength="40" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                </div>
                <div class="n_flex">
                  <div class="n_flex_col100 md_flex_col45">
                     <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo14">Correo Electrónico  &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" name="txtCorreo" id="txtCorreo" data-rule-required="true" data-rule-RE_Email="true" value="<?=$usuario->correoElectronico?>" data-rule-maxlength="50" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                  <div class="md_flex_col10">
                  </div>
                  <div class="n_flex_col100 md_flex_col45">
                
                           <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo18">Teléfono  &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" name="txtTelefono" id="txtTelefono" data-rule-required="true" data-rule-RE_Numbers="true" value="<?=$usuario->telefono?>" data-rule-maxlength="10" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                </div>
          
                <div class="n_flex">
                  <div class="n_flex_col100 md_flex_col45">
                         <!-- Inicio input -->
                    <div class="frmCont" style="display:none;">
                      <label for="campo16">País de Residencia &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" data-rule-required="true" name="txtPais" id="txtPais" data-rule-RE_LatinCharacters="true" value="<?=$usuario->pais?>" data-rule-maxlength="20" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  <!-- Inicio input -->
                    <div class="frmCont" style="display:none;">
                      <label for="campo16">Departamento de Residencia &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" data-rule-required="true" name="txtDepartamento" id="txtDepartamento" data-rule-RE_LatinCharacters="true" value="<?=$usuario->departamento?>" data-rule-maxlength="20" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                    

                  </div>
                  <div class="md_flex_col10">
                  </div>
                  <div class="n_flex_col100 md_flex_col45">
                  <!-- Inicio input -->
                    <div class="frmCont" style="display:none;">
                      <label for="campo17">Ciudad de Residencia &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" data-rule-required="true" name="txtCiudad" id="txtCiudad" data-rule-RE_LatinCharacters="true" value="<?=$usuario->ciudad?>" data-rule-maxlength="20" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->

                  </div>
                </div>
                 <div class="n_flex">
                  <div class="n_flex_col100 md_flex_col45">

       
                  </div>
                  <div class="md_flex_col10">
                  </div>
                  <div class="n_flex_col100 md_flex_col45">
                  </div>
                </div>

                <br>
                <div class="n_flex">
                  <div class="n_flex_col100 xs_flex_col50">
                    <center>
                      <button type="button" class="btn btn-cancelar" onclick="location=href='<?=URL?>Home/ctrlPerfil'">Volver</button>
                    </center>
                  </div>
                  <br> <br>
                  <div class="n_flex_col100 xs_flex_col50">
                    <center>
                      <button type="submit" class="btn btn-modificar" id="btnModificarPerfil" name="btnModificarPerfil">Modificar</button>
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
