<!-- CONTENIDO -->
<div class="n_flex n_justify_center">
  <!-- CONTENIDO VISTA -->
  <div class="n_flex n_flex_col95 sm_flex_col90">
    <!-- TITULO VISTA -->
    <div class="n_flex n_flex_col100">
      <h1 class="titulo_vista"><span class="fa fa-user"></span>Personas</h1>
    </div>
    <div class="n_flex n_flex_col100 n_justify_around">
      <div class="n_flex n_flex_col100">
        <div class="panel block">
          <div class="panel-cabecera">
            <h3>Modificar Persona</h3>
          </div>
          <div class="panel-contenido">
            <form id="FormModificarPersona">
              <!-- Contenedor flexible obligatorio: -->
              <input type="hidden" class="input_data" name="txtIdPersona" id="txtIdPersona" value="<?php echo $queryConsultarPersona->idPersona ?>">
              <input type="hidden" class="input_data" name="txtIdUsuario" id="txtIdUsuario">
              <input type="hidden" class="input_data" name="txtIdPersonaEspecialidad" id="txtIdPersonaEspecialidad">
              <input type="hidden" class="input_data" name="txtViejaFoto" id="txtViejaFoto" value="<?php echo $queryConsultarPersona->urlFoto ?>">
              <input type="hidden" class="input_data" name="txtViejaHojaDeVida" id="txtViejaHojaDeVida" value="<?php echo $queryConsultarPersona->urlHojaDeVida ?>">

              <div class="n_flex">
                <!-- 100% a partir de 0px, 50% a partir de tablet: -->
                <div class="n_flex_col100 md_flex_col45">
                 <!-- Inicio input -->
                  <div class="frmCont">
                    <label for="campo1">Foto</label>
                    <div class="frmInput">
                      <div class="input_file">
                        <input type="text" id="limpiar_files" class="input_data" disabled="disabled" placeholder="Seleccione un archivo" value="<?php echo $queryConsultarPersona->urlFoto ?>">
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
                  <div class="frmCont">
                    <label for="campo2">Tipo de Documento &nbsp <i style="color:red;">*</i></label>
                    <div class="frmInput">
                      <select type="text" class="input_data" name="slcTipoDocumento" id="slcTipoDocumento" data-rule-required="true" data-rule-RE_Select="0">
                        <option value="0">Seleccione una opción</option>
                        <?PHP
                        foreach ($tipoDocumento as $registro) {
                          echo "<option value='".$registro->idTipoDocumento."'>".$registro->descripcionTdocumento."</option>"; }
                          ?>
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
                        <input type="text" class="input_data" name="txtNumeroDocumento" id="txtNumeroDocumento" data-rule-required="true" data-rule-RE_number_letters="true" value="<?php echo $queryConsultarPersona->numeroDocumento ?>" data-rule-maxlength="15" autocomplete="off">
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
                        <input type="text" class="input_data" data-rule-required="true" name="txtPrimerNombre" id="txtPrimerNombre" data-rule-RE_LatinCharacters="true" value="<?php echo $queryConsultarPersona->primerNombre ?>" data-rule-maxlength="15" autocomplete="off">
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
                        <input type="text" class="input_data" name="txtSegundoNombre" id="txtSegundoNombre" data-rule-RE_LatinCharacters="true" value="<?php echo $queryConsultarPersona->segundoNombre ?>" data-rule-maxlength="15" autocomplete="off">
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
                        <input type="text" class="input_data" data-rule-required="true" name="txtPrimerApellido" id="txtPrimerApellido" data-rule-RE_LatinCharacters="true" value="<?php echo $queryConsultarPersona->primerApellido ?>" data-rule-maxlength="15" autocomplete="off">
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
                        <input type="text" class="input_data" name="txtSegundoApellido" id="txtSegundoApellido" data-rule-RE_LatinCharacters="true" value="<?php echo $queryConsultarPersona->segundoApellido ?>" data-rule-maxlength="15" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                  <div class="md_flex_col10">
                  </div>
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo8">Lugar de Expedición del Documento</label>
                      <div class="frmInput">
                        <input type="text" class="input_data" name="txtLugarExpedicionDocumento" id="txtLugarExpedicionDocumento" data-rule-RE_LatinCharacters="true" value="<?php echo $queryConsultarPersona->lugarExpedicionDocumento ?>" data-rule-maxlength="20" autocomplete="off">
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
                        <input type="text" class="input_data" name="txtFechaNacimiento" id="txtFechaNacimiento" data-rule-required="true" value="<?php echo $queryConsultarPersona->fechaNacimiento ?>" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                  <div class="md_flex_col10">
                  </div>
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo10">Lugar de Nacimiento</label>
                      <div class="frmInput">
                        <input type="text" class="input_data" name="txtLugarNacimiento" id="txtLugarNacimiento" data-rule-RE_LatinCharacters="true" value="<?php echo $queryConsultarPersona->lugarNacimiento ?>" data-rule-maxlength="20" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                </div>
                <div class="n_flex">
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio select -->
                    <div class="frmCont">
                      <label for="campo11">Género &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <select  name="slcSexo" class="input_data" id="slcSexo" data-rule-required="true" data-rule-RE_Select="0">
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
                    <!-- Inicio select -->
                    <div class="frmCont">
                      <label for="campo12">Grupo Sanguíneo</label>
                      <div class="frmInput">
                        <select  class="input_data" name="slcGrupoSanguineo" id="slcGrupoSanguineo">
                          <option value="0">Seleccione una opción</option>
                          <option value="O+">O+</option>
                          <option value="O-">O-</option>
                          <option value="A+">A+</option>
                          <option value="A-">A-</option>
                          <option value="B+">B+</option>
                          <option value="B-">B-</option>
                          <option value="AB+">AB+</option>
                          <option value="AB-">AB-</option>
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
                      <label for="campo13">Dirección de Residencia &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" data-rule-required="true" name="txtDireccion" id="txtDireccion" value="<?php echo $queryConsultarPersona->direccion ?>" data-rule-maxlength="40" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                  <div class="md_flex_col10">
                  </div>
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo14">Correo Electrónico &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" name="txtCorreo" id="txtCorreo" data-rule-required="true" data-rule-RE_Email="true" value="<?php echo $queryConsultarPersona->correoElectronico ?>" data-rule-maxlength="50" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                </div>
                <div class="n_flex">
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo16">Departamento de Residencia &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" data-rule-required="true" name="txtDepartamento" id="txtDepartamento" data-rule-RE_LatinCharacters="true" value="<?php echo $queryConsultarPersona->departamento ?>" data-rule-maxlength="20" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                  <div class="md_flex_col10">
                  </div>
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo17">Ciudad de Residencia &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" data-rule-required="true" name="txtCiudad" id="txtCiudad" data-rule-RE_LatinCharacters="true" value="<?php echo $queryConsultarPersona->ciudad ?>" data-rule-maxlength="20" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                </div>
                <div class="n_flex">
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio input -->
                    <div class="frmCont">
                      <label for="campo18">Teléfono &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <input type="text" class="input_data" name="txtTelefono" id="txtTelefono" data-rule-required="true" data-rule-RE_Numbers="true" value="<?php echo $queryConsultarPersona->telefono ?>" data-rule-maxlength="10" autocomplete="off">
                      </div>
                    </div>
                    <!-- fin input -->
                  </div>
                  <div class="md_flex_col10">
                  </div>
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio input -->
                   <div class="frmCont">
                     <label for="campo19">Hoja de Vida</label>
                     <div class="frmInput">
                       <div class="input_file">
                         <input type="text" id="limpiar_files" class="input_data" disabled="disabled" placeholder="Seleccione un archivo" value="<?php echo $queryConsultarPersona->urlHojaDeVida ?>">
                         <div class="btn_group">
                           <input type="file" class="input_data" name="txtHojaVida" id="txtHojaVida" data-rule-RE_Doc="true">
                           <button type="button" class="btn">Subir</button>
                         </div>
                       </div>
                     </div>
                   </div>
                   <!-- fin input -->
                  </div>
                </div>
                <div class="n_flex">
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio select -->
                    <div class="frmCont">
                      <label for="campo21">Dependencia</label>
                      <div class="frmInput">
                        <select  class="input_data" name="slcDependencia" id="slcDependencia">
                          <option value="0">Seleccione una opción</option>
                          <option value="APH">APH</option>
                          <option value="Domiciliaria">Domiciliaria</option>
                        </select>
                      </div>
                    </div>
                    <!-- fin select -->

                  </div>
                  <div class="md_flex_col10">
                  </div>
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio select -->
                    <div class="frmCont">
                      <label for="campo2">Rol &nbsp <i style="color:red;">*</i></label>
                      <div class="frmInput">
                        <select type="text" class="input_data" name="slcRol" id="slcRol">
                          <option value="0">Seleccione una opción</option>
                          <?PHP
                           foreach ($rol as $registro) {
                             echo "<option value='".$registro->idRol."'>".$registro->descripcionRol."</option>"; }
                             ?>
                          </select>
                        </div>
                      </div>
                      <!-- fin select -->
                  </div>
                </div>
                <div class="n_flex">
                  <div class="n_flex_col100 md_flex_col45">
                    <!-- Inicio input -->
                    <div class="frmCont" style="display:none;">
                      <label for="campo20">Firma:</label>
                      <div class="frmInput">
                        <input type="hidden" class="input_data" name="txtFirma" id="txtFirma" data-rule-RE_Image="true" accept="image/*">
                      </div>
                    </div>
                    <!-- fin input -->
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
                      <button type="button" class="btn btn-cancelar" onclick="location=href='<?=URL?>Usuarios/ctrlConsultarPersona'">Volver</button>
                    </center>
                  </div>
                  <br> <br>
                  <div class="n_flex_col100 xs_flex_col50">
                    <center>
                      <button type="submit" class="btn btn-modificar" id="btnModificarPersona" name="btnModificarPersona">Modificar</button>
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
