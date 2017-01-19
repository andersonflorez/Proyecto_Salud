   <br><div class="n_flex n_justify_center">
   <div class="n_flex n_flex_col95 sm_flex_col90">
      <div class="n_flex n_flex_col100 n_justify_around">
         <div class="n_flex n_flex_col100">
            <div class="panel block">
               <div class="panel-inf-user panel_form global_hide active_panel panel_col vertical_margin horizontal_margin padding_right n_flex md_flex_col100 lg_flex_col100 xl_flex_co100 xxl_flex_col100 n_justify_around">
                  <div class="n_flex n_in_columns md_flex_col100 lg_flex_col100 xl_flex_col100 xxl_flex_col100 n_justify_around">

                     <div class="n_in_columns header_panel_form">
                        <div class="n_flex inf-control">
                           <div class="n_flex n_justify_center n_grow_up">
                              <p class="n_flex">MI PERFIL</p>
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
                        <div class="n_flex n_justify_center md_flex_col50 lg_flex_col50 xl_flex_col50 xxl_flex_col50">
                           <div class="datos n_flex n_justify_between">
                              <p>Usuario</p>
                              <p class=""><?=$usuario->usuario?></p>
                           </div>
                           <div class="datos n_flex n_justify_between">
                              <p>Nombre</p>
                              <p class=""><?=$usuario->primerNombre?></p>
                           </div>
                           <div class="datos n_flex n_justify_between">
                              <p>Apellido</p>
                              <p class=""><?=$usuario->primerApellido?></p>
                           </div>
                           <div class="datos n_flex n_justify_between">
                              <p>Número de Documento</p>
                              <p class=""><?=$usuario->numeroDocumento?></p>
                           </div>
                           <div class="datos n_flex n_justify_between">
                              <p>Fecha de Nacimiento</p>
                              <p class=""><?=$usuario->fechaNacimiento?></p>
                           </div>
                           <div class="datos n_flex n_justify_between">
                              <p>Género</p>
                              <p class=""><?=$usuario->sexo?></p>
                           </div>
                        </div>
                     </div>
                     <div class="n_in_columns inf-contenido scroll_y">
                        <div class="n_flex n_justify_center md_flex_col50 lg_flex_col50 xl_flex_col50 xxl_flex_col50">
                           <div class="datos n_flex n_justify_between">
                              <p>Dirección de Residencia</p>
                              <p class=""><?=$usuario->direccion?></p>
                           </div>
                           <div class="datos n_flex n_justify_between">
                              <p>Teléfono</p>
                              <p class=""><?=$usuario->telefono?></p>
                           </div>
                           <div class="datos n_flex n_justify_between">
                              <p>Correo Electrónico</p>
                              <p class=""><?=$usuario->correoElectronico?></p>
                           </div>
                           <div class="datos n_flex n_justify_between">
                              <p>Ciudad de Residencia</p>
                              <p class=""><?=$usuario->ciudad?></p>
                           </div>
                           <div class="datos n_flex n_justify_between">
                              <p>Departamento de Residencia</p>
                              <p class=""><?=$usuario->departamento?></p>
                           </div>
                           <div class="datos n_flex n_justify_between">
                              <p>País de Residencia</p>
                              <p class=""><?=$usuario->pais?></p>
                           </div>
                           <div class="n_flex_col100 xs_flex_col50">
                              <br>
                              <center>
                                 <button type="submit" class="btn btn-consultar" id="btnEditarPerfil" name="btnEditarPerfil" onclick="location=href='<?=URL?>Home/ctrlModificarPerfil/Index/'+btoa(id)">Editar mi Perfil</button>
                              </center>
                              <br>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
