      <style>
      input,select,textarea{
        margin-bottom: 8px;
      }
     </style>
     <br><br><br>
        <div class="columna-tablet-1 columna-1 columna-hd-1">
        </div>
      <br>
      <div class="fila">
        <div class="columna-tablet-1 columna-1 columna-hd-1">
        </div>
        <div class="columna-tablet-6 columna-6 columna-hd-6">
          <div class="panel">
            <div class="panel-cabecera">REGISTRO DE KIT ESTÁNDAR</div>
            <div class="panel-contenido">
              <form id="formAsignacionModificar">  
                <div class="cont fila">
                  <div class="columna-10">
                    <label>ID Registro:</label>
               <input type="text" id="txtidAsignacion"  name="idAsignacion"placeholder="ID Registro" readonly value="<?php echo $ConsultAsignacionid12->idAsignacion ?>">

               </div>
                    <div class="columna-10">
                      <label>Fecha De Asignación:</label>
                    <input type="date" id="txtFechaAsiganacion" name="FechaAsiganacion" value="<?php echo $ConsultAsignacionid12->FechaAsiganacion ?>">
                   </div>
                   <div class="columna-10">
                  <label>Tipo De Asignacion:</label>
                  <select id= "txtTipoAsignacion" name="slcTipoAsignacion">
                  <?PHP
                      foreach ($slcTipoAsignacion as $registro) {
                          echo "<option value='".$registro->idTipoAsignacion."'>".$registro->descripcionTipoasignacion."</option>";
                        }
                      ?>
                    </select>
                  </div>
                  <div class="columna-10">
                  <label>Codigo De Ambulancia:</label>
                   <select id= "txtCodigoAmbulancia" name="slcCodigoAmbulancia">
                  <?PHP
                      foreach ($slcCodigoAmbulancia as $registro) {
                          echo "<option value='".$registro->idAmbulancia."'>".$registro->tipoAmbulancia."</option>";
                        }
                      ?>
                    </select>
                  </div>
                  <div class="columna-10">
                  <label>Nombre De Medico:</label>
                  <select id="txtNombrePersona" name="slcNombrePersona" >
                  <?PHP
                      foreach ($slcNombrePersona as $registro) {
                          echo "<option value='".$registro->idPersona."'>".$registro->primerNombre."</option>";
                        }
                      ?>
                    </select>
                  </div>
                  <div class="columna-10">
                  <label>Nombre De Paciente:</label>
                  <select id="txtNombrePaciente" name="slcNombrePaciente">
                  <?PHP
                      foreach ($slcNombrePaciente as $registro) {
                          echo "<option value='".$registro->idPaciente."'>".$registro->primerNombre."</option>";
                        }
                      ?>
                    </select>
                  </div>
                  <br>
                  <div class="fila">
                  <div class="columna-5 columna-tablet-5 columna-hd-5">
                    <button type="button" id="btnActualizarAsignacion" class="btn btn-modificar">ACTUALIZAR</button>
                  </div>
                </div>
                </div>
              </form>
            </div>
            </div>
        </div>
        <div class="columna-tablet-1 columna-1 columna-hd-1">
        </div>
      </div>
