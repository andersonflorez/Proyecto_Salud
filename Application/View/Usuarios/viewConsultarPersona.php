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
            <h3>Listado de Personas</h3>
          </div>
          <div class="panel-contenido">
            <div class="tbl_container">
              <table id="example" class="tbl_scroll" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Número documento</th>
                    <th>Primer nombre</th>
                    <th>Primer apellido</th>
                    <th>Correo electrónico</th>
                    <th>Teléfono</th>
                    <th>Estado</th>
                    <th>Ver</th>
                    <th>Editar</th>
                    <th><i class="fa fa-lock"></i>/<i class="fa fa-unlock"></i></th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="display:none;"></th>
                    <th style="display:none;"></th>
                    <th style="display:none;"></th>
                  </tr>
                </tfoot>
                <tbody id="cont-table">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- FIN CONTENIDO VISTA -->
<div class="modal-ventana whole_wrapper" id="modalVerPersona">
  <div class="modal relative_element">
    <!--NICIO modal relative_element-->
    <div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between">
      <h2>Información</h2>
      <span class="btn-cerrar-modal modal-cerrar fa fa-times"></span>
    </div>
    <form>
      <div class="modal-body" style="max-height:400px !important;">
        <!-- INICIO MODAL BODY-->
        <div class="panel block">
          <!--INICIO PANEL BLOCK-->
          <div class="panel-contenido">

            <div class="n_flex n_justify_center">
              <img id="imagenPersona" src="" alt="" style="width:100px; height:100px; border-radius:50%; border:2px solid #D3D3D3;">
            </div>

            <div class="n_flex">
              <!-- 100% a partir de 0px, 50% a partir de tablet: -->
              <div class="n_flex_col100 md_flex_col45">
                <!-- Inicio select -->
                <div class="frmCont">
                  <label for="campo1">Tipo de documento:</label>
                  <div class="frmInput">
                    <select class="input_data" name="slcTipoDocumento" id="slcTipoDocumentoP" readonly disabled>
                      <option value="0">Seleccione una opción</option>
                      <?PHP
                      foreach ($tipoDocumento as $registro1) {
                        echo "<option value='".$registro1->idTipoDocumento."'>".$registro1->descripcionTdocumento."</option>"; }
                        ?>
                      </select>
                    </div>
                  </div>
                  <!-- fin select -->
                </div>
                <div class="md_flex_col10">
                </div>
                <!-- 100% a partir de 0px, 50% a partir de tablet: -->
                <div class="n_flex_col100 md_flex_col45">
                  <!-- Inicio input -->
                  <div class="frmCont">
                    <label for="campo2">Número de documento:</label>
                    <div class="frmInput">
                      <input name="txtNumeroDocumento" id="txtNumeroDocumentoP" readonly>
                    </div>
                  </div>
                  <!-- fin input -->
                </div>
              </div>
              <div class="n_flex">
                <div class="n_flex_col100 md_flex_col45">
                  <!-- Inicio input -->
                  <div class="frmCont">
                    <label for="campo3">Primer nombre:</label>
                    <div class="frmInput">
                      <input name="txtPrimerNombre" id="txtPrimerNombreP" readonly>
                    </div>
                  </div>
                  <!-- fin input -->
                </div>
                <div class="md_flex_col10">
                </div>
                <div class="n_flex_col100 md_flex_col45">
                  <!-- Inicio input -->
                  <div class="frmCont">
                    <label for="campo4">Segundo nombre:</label>
                    <div class="frmInput">
                      <input name="txtSegundoNombre" id="txtSegundoNombreP" readonly>
                    </div>
                  </div>
                  <!-- fin input -->
                </div>
              </div>
              <div class="n_flex">
                <div class="n_flex_col100 md_flex_col45">
                  <!-- Inicio input -->
                  <div class="frmCont">
                    <label for="campo4">Primer apellido:</label>
                    <div class="frmInput">
                      <input name="txtPrimerApellido" id="txtPrimerApellidoP" readonly>
                    </div>
                  </div>
                  <!-- fin input -->
                </div>
                <div class="md_flex_col10">
                </div>
                <div class="n_flex_col100 md_flex_col45">
                  <!-- Inicio input -->
                  <div class="frmCont">
                    <label for="campo5">Segundo apellido:</label>
                    <div class="frmInput">
                      <input name="txtSegundoApellido" id="txtSegundoApellidoP" readonly>
                    </div>
                  </div>
                  <!-- fin input -->
                </div>
              </div>
              <div class="n_flex">
                <div class="n_flex_col100 md_flex_col45">
                  <!-- Inicio input -->
                  <div class="frmCont">
                    <label for="campo6">Lugar de expedición del documento:</label>
                    <div class="frmInput">
                      <input name="txtLugarExpedicionDocumento" id="txtLugarExpedicionDocumentoP" readonly>
                    </div>
                  </div>
                  <!-- fin input -->
                </div>
                <div class="md_flex_col10">
                </div>
                <div class="n_flex_col100 md_flex_col45">
                  <!-- Inicio input -->
                  <div class="frmCont">
                    <label for="campo7">Fecha de nacimiento:</label>
                    <div class="frmInput">
                      <input name="txtFechaNacimiento" id="txtFechaNacimientoP" readonly>
                    </div>
                  </div>
                  <!-- fin input -->
                </div>
              </div>
              <div class="n_flex">
                <div class="n_flex_col100 md_flex_col45">
                  <!-- Inicio input -->
                  <div class="frmCont">
                    <label for="campo8">Lugar de nacimiento:</label>
                    <div class="frmInput">
                      <input name="txtLugarNacimiento" id="txtLugarNacimientoP" readonly>
                    </div>
                  </div>
                  <!-- fin input -->
                </div>
                <div class="md_flex_col10">
                </div>
                <div class="n_flex_col100 md_flex_col45">
                  <!-- Inicio select -->
                  <div class="frmCont">
                    <label for="campo9">Género:</label>
                    <div class="frmInput">
                      <select  name="slcSexo" id="slcSexoP" readonly disabled>
                        <option value="0">Seleccione una opción</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                      </select>
                    </div>
                  </div>
                  <!-- fin select -->
                </div>
              </div>
              <div class="n_flex">
                <div class="n_flex_col100 md_flex_col45">
                  <!-- Inicio select -->
                  <div class="frmCont">
                    <label for="campo10">Grupo sanguíneo:</label>
                    <div class="frmInput">
                      <select name="slcGrupoSanguineo" id="slcGrupoSanguineoP" readonly disabled>
                        <option value="0"></option>
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
                <div class="md_flex_col10">
                </div>
                <div class="n_flex_col100 md_flex_col45">
                  <!-- Inicio input -->
                  <div class="frmCont">
                    <label for="campo11">Dirección:</label>
                    <div class="frmInput">
                      <input name="txtDireccion" id="txtDireccionP" readonly>
                    </div>
                  </div>
                  <!-- fin input -->
                </div>
              </div>
              <div class="n_flex">
                <div class="n_flex_col100 md_flex_col45">
                  <!-- Inicio input -->
                  <div class="frmCont">
                    <label for="campo12">Correo electrónico:</label>
                    <div class="frmInput">
                      <input name="txtCorreo" id="txtCorreoP" readonly>
                    </div>
                  </div>
                  <!-- fin input -->
                </div>
                <div class="md_flex_col10">
                </div>
                <div class="n_flex_col100 md_flex_col45">
                  <!-- Inicio input -->
                  <div class="frmCont">
                    <label for="campo13">País:</label>
                    <div class="frmInput">
                      <input name="txtPais" id="txtPaisP" readonly>
                    </div>
                  </div>
                  <!-- fin input -->
                </div>
              </div>
              <div class="n_flex">
                <div class="n_flex_col100 md_flex_col45">
                  <!-- Inicio input -->
                  <div class="frmCont">
                    <label for="campo14">Departamento:</label>
                    <div class="frmInput">
                      <input name="txtDepartamento" id="txtDepartamentoP" readonly>
                    </div>
                  </div>
                  <!-- fin input -->
                </div>
                <div class="md_flex_col10">
                </div>
                <div class="n_flex_col100 md_flex_col45">
                  <!-- Inicio input -->
                  <div class="frmCont">
                    <label for="campo15">Ciudad:</label>
                    <div class="frmInput">
                      <input name="txtCiudad" id="txtCiudadP" readonly>
                    </div>
                  </div>
                  <!-- fin input -->
                </div>
              </div>
              <div class="n_flex">
                <div class="n_flex_col100 md_flex_col45">
                  <!-- Inicio input -->
                  <div class="frmCont">
                    <label for="campo16">Teléfono:</label>
                    <div class="frmInput">
                      <input name="txtTelefono" id="txtTelefonoP" readonly>
                    </div>
                  </div>
                  <!-- fin input -->
                </div>
                <div class="md_flex_col10">
                </div>
                <div class="n_flex_col100 md_flex_col45">
                  <!-- Inicio select -->
                  <div class="frmCont">
                    <label for="campo17">Dependencia:</label>
                    <div class="frmInput">
                      <select name="slcDependencia" id="slcDependenciaP" readonly disabled>
                        <option value="0"></option>
                        <option value="APH">APH</option>
                        <option value="Domiciliaria">Domiciliaria</option>
                      </select>
                    </div>
                  </div>
                  <!-- fin select -->
                </div>
              </div>
              <div class="n_flex">
                <div class="n_flex_col100 md_flex_col45">

                                <!-- Inicio select -->
                                <div class="frmCont">
                                  <label for="campo1">Rol:</label>
                                  <div class="frmInput">
                                    <select class="input_data" name="slcRol" id="slcRolP" readonly disabled>
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
                <div class="md_flex_col10">
                </div>
                <div class="n_flex_col100 md_flex_col45">

                </div>
              </div>

            </div>
            <!--FIN PANEL CONTENIDO-->
          </div>
          <!--FIN PANEL BLOCK-->
        </div>
        <!-- FIN MODAL BODY-->
        <div class="modal-footer n_flex n_justify_end">
          <button type="button" class="btn-cerrar-modal btn btn-cancelar" name="button">Salir</button>
        </div>
      </form>
    </div>
    <!--FIN modal relative_element-->
  </div>
