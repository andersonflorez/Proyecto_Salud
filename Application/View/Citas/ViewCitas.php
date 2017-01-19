
<!-- FLECHA DERECHA -->
<button submit-form="formDatosPaciente" type="submit" id="SgteCita" title="Siguiente" class="flecha-der ">
  <li id="sgt" class="fa fa-long-arrow-right"></li>
</button>
<!-- FLECHA IZQUIERDA -->
<button id="AntCita" title="Volver" class="flecha-izq">
  <li class="fa fa-long-arrow-left"></li>
</button>

<form id="formDatosPaciente" method="POST" class="active_form">

  <div id="part1"class="" >

    <!-- CONTENIDO -->
    <div class="n_flex n_justify_center">

      <!-- CONTENIDO VISTA -->
      <div class="n_flex n_flex_col95 sm_flex_col90">

        <!-- TITULO VISTA -->
        <div class="n_flex n_flex_col100">
          <h1 class="titulo_vista"><span class="fa fa-calendar-plus-o"></span>Cita</h1>
        </div>
        <div class="n_flex n_flex_col100 n_justify_around">

          <!-- CONTENEDOR PRINCIPAL IZQUIERDO -->
          <div class="n_flex n_flex_col100  xl_flex_col100 lg_flex_col100 horizontal_padding n_in_columns">

            <!-- GRID -->
            <div class="panel block">

              <div class="panel-cabecera">
                <h3>Confirmación del Paciente</h3>
            </div>
            <div class="n_flex "style="justify-content: flex-end;padding-right:3%;position: relative;bottom: 47px;">
            <div class="header-btn separate  n_justify_center" style="padding-right: 1%;">
              <button class="tooltip  btn btn-consultar"  onclick="location.href='<?=URL?>Citas/ctrlHistorialCitas'" type="button">
                <span class="fa fa-book"></span>
              </button>
            </div>


            <div class="header-btn separate   n_justify_center" >
              <button class="tooltip  btn btn-consultar"  onclick="location.href='<?=URL?>Citas/ctrlConfiguracionCup'" type="button">
                <span class="fa fa-cogs"></span>
              </button>
            </div>
          </div>


              <div class="panel-contenido">

                <article class="block">
                  <div class="n_flex">

                    <div class="lg_flex_col25"></div>
                    <div class="n_flex_col100 lg_flex_col50 sm_flex_col100 xs_flex_col100">
                      <div class="frmCont">
                        <label for="txtSelect2">Tipo de Documento<span class="TwoPoints">*</span></label>
                        <div class="frmInput frmInput_select2">
                          <select type="text"  data-rule-RE_Select="-1" class="select input_data" name="SltTipoDocumento1" id="SltTipoDocumento1">
                            <option value="-1">Seleccione una opción.</option>
                          </select>
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="n_flex">
                    <div class="lg_flex_col25"></div>
                    <div class="n_flex_col100 lg_flex_col50 sm_flex_col100 xs_flex_col100">
                      <div class="frmCont">
                        <label for="campo1" class="frm_tituloInput">Documento<span class="TwoPoints">*</span></label>
                        <div class="frmInput">
                          <input type="text" data-rule-maxlength="12" class="input_data" data-rule-required="true" data-rule-RE_number_letters="true" name="txtDocumento1" id="txtDocumento1" autocomplete="off" placeholder="Ejm:982323523">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="n_flex">
                    <div class="lg_flex_col25"></div>
                    <div class="n_flex_col100 lg_flex_col50 sm_flex_col100 xs_flex_col100">
                      <div class="frmCont">
                        <label for="campo1">Fecha de Nacimiento<span class="TwoPoints">*</span></label>
                        <div class="frmInput">
                          <input type="text" class="input_data" data-rule-required="true" name="txtFechaNacimiento1" id="txtFechaNacimiento1" autocomplete="off" placeholder="Ejm:1997/09/22">
                        </div>
                      </div>
                    </div>

                  </div>
                  <br><br>

                </article>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<form id="formInfoPaciente" method="POST" >
  <div id="part2"class="contPart" >
    <!-- CONTENIDO -->
    <div class="n_flex n_justify_center">

      <!-- CONTENIDO VISTA -->
      <div class="n_flex n_flex_col95 sm_flex_col90">

        <!-- TITULO VISTA -->
        <div class="n_flex n_flex_col100">
          <h1 class="titulo_vista"><span class="fa fa-calendar-plus-o"></span>Cita</h1>
        </div>
        <div class="n_flex n_flex_col100 n_justify_around">

          <!-- CONTENEDOR PRINCIPAL IZQUIERDO -->
          <div class="n_flex n_flex_col100  xl_flex_col100 lg_flex_col100 horizontal_padding n_in_columns">

            <!-- GRID -->
            <div class="panel block">
              <div class="panel-cabecera">
                <h3>Información de <span class="NombrePaciente"></span></h3>
              </div>
              <div class="panel-contenido">
                <article class="block">
                  <div class="n_flex">
                    <div class="md_flex_col30 xl_flex_col30"></div>
                    <div class="n_flex_col100 md_flex_col40 xl_flex_col40 horizontal_padding">
                      <div class="frmCont">
                        <label for="txtSelect2">Estado del Paciente :</label>
                        <div class="frmInput frmInput_select2">
                          <select type="text" class="select input_data infoP" name="SltEstadoPaciente" id="SltEstadoPaciente">
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="n_flex ">
                    <div class="n_flex_col100 lg_flex_col50 xl_flex_col50 md_flex_col50 horizontal_padding ">
                      <div class="frmCont">
                        <label for="campo1">Primer Nombre<span class="TwoPoints">*</span></label>
                        <div class="frmInput">
                          <input type="text" data-rule-required="true" data-rule-maxlength="15" data-rule-RE_LatinCharacters="true" class="input_data infoP" name="txtPrimerNombre" id="txtPrimerNombre" autocomplete="off" placeholder="Ejm: Alfonso">
                        </div>
                      </div>
                    </div>
                    <div class="n_flex_col100 lg_flex_col50 xl_flex_col50 md_flex_col50 sm_flex_col100 xs_flex_col100  horizontal_padding">
                      <div class="frmCont">
                        <label for="campo1">Segundo Nombre :</label>
                        <div class="frmInput">
                          <input type="text" data-rule-maxlength="15" data-rule-RE_LatinCharacters="true" class="input_data infoP" name="txtSegundoNombre" id="txtSegundoNombre" autocomplete="off" placeholder="Ejm:Alberto">
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="n_flex ">
                    <div class="n_flex_col100 lg_flex_col50 xl_flex_col50 md_flex_col50 sm_flex_col100 xs_flex_col100  horizontal_padding">
                      <div class="frmCont">
                        <label for="campo1">Primer Apellido<span class="TwoPoints">*</span></label>
                        <div class="frmInput">
                          <input type="text" data-rule-required="true" data-rule-maxlength="15" data-rule-RE_LatinCharacters="true" class="input_data infoP"name="txtPrimerApellido" id="txtPrimerApellido" autocomplete="off" placeholder="Ejm:Isaza">
                        </div>
                      </div>
                    </div>
                    <div class="n_flex_col100 lg_flex_col50 xl_flex_col50 md_flex_col50 sm_flex_col100 xs_flex_col100  horizontal_padding">
                      <div class="frmCont">
                        <label for="campo1">Segundo Apellido :</label>
                        <div class="frmInput">
                          <input type="text" data-rule-maxlength="15" data-rule-RE_LatinCharacters="true" class="input_data infoP" name="txtSegundoApellido" id="txtSegundoApellido" autocomplete="off" placeholder="Ejm:Jaramillo">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="n_flex ">
                    <div class="n_flex_col100 lg_flex_col50 xl_flex_col50 md_flex_col50 sm_flex_col100 xs_flex_col100  horizontal_padding">
                      <div class="frmCont">
                        <label for="campo1">Ciudad de Residencia<span class="TwoPoints">*</span></label>
                        <div class="frmInput">
                          <input type="text" data-rule-required="true"  data-rule-maxlength="15" data-rule-RE_LatinCharacters="true" class="input_data infoP" name="txtCiudadResidencia" id="txtCiudadResidencia" autocomplete="off" placeholder="Ejm:Medellín">
                        </div>
                      </div>
                    </div>
                    <div class="n_flex_col100 lg_flex_col50 xl_flex_col50 md_flex_col50 sm_flex_col100 xs_flex_col100  horizontal_padding">
                      <div class="frmCont">
                        <label for="campo1">Barrio de Residencia<span class="TwoPoints">*</span></label>
                        <div class="frmInput">
                          <input type="text" data-rule-required="true" data-rule-maxlength="15" data-rule-RE_LatinCharacters="true" class="input_data infoP" name="txtBarrioResidencia" id="txtBarrioResidencia" autocomplete="off" placeholder="Ejm:Castilla">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="n_flex ">
                    <div class="n_flex_col100 lg_flex_col50 xl_flex_col50 md_flex_col50 sm_flex_col100 xs_flex_col100  horizontal_padding">
                      <div class="frmCont">
                        <label for="campo1">Dirección de Residencia<span class="TwoPoints">*</span></label>
                        <div class="frmInput">
                          <input type="text" data-rule-required="true" data-rule-maxlength="30" class="input_data infoP" name="txtDireccion" id="txtDireccion" autocomplete="off" placeholder="Ejm:CLL 11 # 21 A 32">
                        </div>
                      </div>
                    </div>
                    <div class="n_flex_col100 lg_flex_col50 xl_flex_col50 md_flex_col50 sm_flex_col100 xs_flex_col100  horizontal_padding">
                      <div class="frmCont">
                        <label for="campo1">Correo Electrónico :</label>
                        <div class="frmInput">
                          <input type="text" data-rule-RE_Email="true" class="input_data infoP" name="txtCorreo" id="txtCorreo" autocomplete="off" placeholder="Ejm: Ejemplo@ejemplo.com">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="n_flex ">
                    <div class="n_flex_col100 lg_flex_col50 xl_flex_col50 md_flex_col50 sm_flex_col100 xs_flex_col100  horizontal_padding">
                      <div class="frmCont">
                        <label for="campo1">Teléfono Fijo - Extensión<span class="TwoPoints">*</span></label>
                        <div class="frmInput">
                          <input type="text" data-rule-required="true" data-rule-maxlength="7"  data-rule-RE_Numbers="true" class="input_data infoP" name="txtTelefono" id="txtTelefono" autocomplete="off" placeholder="Ejm:4648153">
                          <div class="aggInput">
                            <input type="text" class="input_data only_numbers quantity_maximun_input infoP" name="txtExtTelefonoCita3" id="txtExtTelefonoCita3" placeholder="Ejm:586" autocomplete="off">
                          </div>
                          <span class="aggExt fa fa-plus " id="Ext4" ></span>
                        </div>
                      </div>
                    </div>
                    <div class="n_flex_col100 lg_flex_col50 xl_flex_col50 md_flex_col50 sm_flex_col100 xs_flex_col100  horizontal_padding">
                      <div class="frmCont">
                        <label for="campo1">Teléfono Celular :</label>
                        <div class="frmInput">
                          <input type="text" data-rule-maxlength="10" data-rule-RE_Numbers="true" class="input_data infoP" name="txtTelefonoCelular" id="txtTelefonoCelular" autocomplete="off" placeholder="Ejm:312123431">
                          <input name="txtidPaciente" id="txtidPaciente" class="input_data frm_input" autocomplete="off" type="hidden" >
                        </div>
                      </div>
                    </div>
                  </div>

                  <br>
                  <div class="n_flex ">
                    <div class="n_flex_col100 lg_flex_col50 xl_flex_col50 md_flex_col50 sm_flex_col100 xs_flex_col100  horizontal_padding">
                      <button class="btn btn-consultar" type="button" id="btnModificar" name="btnModificar" hidden>Modificar</button>
                    </div>
                  </div>

                  <div class="n_flex n_justify_around">
                    <div class="n_flex n_flex_col20 md_flex_col sm_flex_col20"></div>
                    <div class="n_flex n_flex_col40 md_flex_col35 sm_flex_col35"></div>

                    <div class="n_flex n_flex_col40 md_flex_col35 sm_flex_col35">
                      <button class="btn-modal btn btn-consultar"   type="button" id="btnConsultaCP" name="btnConsultaCP">Consultar Citas</button>
                    </div>

                    <div class="n_flex n_flex_col20 md_flex_col0 sm_flex_col20"></div>
                  </div>
                </article>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- 'id' debe ser igual a 'target' -->
<div class="modal-ventana whole_wrapper" id="modalCitas">
  <div class="modal relative_element">

    <div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between">
      <!-- Titulo de la ventana modal -->
      <h2 id="NombreP"></h2>
      <span class="btn-cerrar-modal modal-cerrar fa fa-times"></span>
    </div>

    <div class="modal-body">
      <!-- Contenido de la ventana modal -->
      <div class="panel block">
        <div class="panel-contenido">

          <article class="block">
            <h6 class="text_bold block">Citas Asignadas</h6>
            <p style="text-align:center" id="textNombreCUP">

            </p>
            <br>
            <div class="n_flex_col10">


              <table class="tbl_responsive" id="example" >
                <thead>
                  <tr>
                    <th>Cup</th>
                    <th>Fecha Cita</th>
                    <th>Hora</th>
                    <th>Estado Cita</th>
                    <th>Cancelar Cita</th>
                  </tr>
                </thead>
                <tbody id="cont-table">

                </tbody>
              </table>

            </div>

          </div>
        </div>
      </div>

      <div class="modal-footer n_flex n_justify_end">
        <button type="button" class=" btn btn-cancelar btn-cerrar-modal"  name="button">Salir</button>
      </div>

    </div>
  </div>

  <form id="formCita" method="post">
    <div id="part3"class="contPart" >
      <!-- CONTENIDO -->
      <div class="n_flex n_justify_center">

        <!-- CONTENIDO VISTA -->
        <div class="n_flex n_flex_col95 sm_flex_col90">

          <!-- TITULO VISTA -->
          <div class="n_flex n_flex_col100">
            <h1 class="titulo_vista"><span class="fa fa-calendar-plus-o"></span>Cita</h1>
          </div>
          <div class="n_flex n_flex_col100 n_justify_around">

            <!-- CONTENEDOR PRINCIPAL IZQUIERDO -->
            <div class="n_flex n_flex_col100  xl_flex_col100 lg_flex_col100 horizontal_padding n_in_columns">
              <!-- GRID -->
              <div class="panel block">
                <div class="panel-cabecera">
                  <h3>Datos de la Cita de <span class="NombrePaciente"></span></h3>
                </div>
                <div class="panel-contenido">
                  <article class="block">


                  </span>
                    <div class="n_flex">
                      <div class="tooltip ">
                      <span class="button  fa fa-home fa-lg"id="telResident"style="position: absolute;left: 213px;top: 8px; color:#1f95d0; cursor:pointer;"></span>
                      <span class="tooltiptext" style="bottom: 100% !important; margin-left: 181px !important;">Teléfono residencia.</span>
                    </div>
                      <div class="n_flex_col100 lg_flex_col50 xl_flex_col50 md_flex_col50 sm_flex_col100 xs_flex_col100  horizontal_padding">

                        <div class="frmCont">
                          <label for="campo1">Teléfono Uno - Extensión <span class="TwoPoints">*</span>
                          </label>
                          <div class="frmInput">
                            <input type="text" data-rule-maxlength="7" data-rule-required="true" data-rule-RE_Numbers="true" class="input_data" name="txtTelefonoUno" id="txtTelefonoUno" autocomplete="off" placeholder="Ejm:4648153">
                            <div class="aggInput">
                              <input type="text" class="input_data only_numbers quantity_maximun_input" name="txtExtTelefonoCita1" id="txtExtTelefonoCita1" placeholder="Ejm:896" autocomplete="off">
                            </div>
                            <span class="aggExt fa fa-plus " id="Ext1" ></span>
                          </div>
                        </div>
                      </div>
                      <div class="n_flex_col100 lg_flex_col50 xl_flex_col50 md_flex_col50 sm_flex_col100 xs_flex_col100  horizontal_padding">
                        <div class="frmCont">
                          <label for="campo1">Teléfono Dos - Extensión:</label>
                          <div class="frmInput">
                            <input type="text" data-rule-maxlength="7"  data-rule-RE_Numbers="true" class="input_data" name="txtTelefonoDos" id="txtTelefonoDos" autocomplete="off" placeholder="Ejm:4648153">
                            <div class="aggInput">
                              <input type="text" class="input_data only_numbers quantity_maximun_input" name="txtExtTelefonoCita2" id="txtExtTelefonoCita2" placeholder="Ejm:856" autocomplete="off">
                            </div>
                            <span class="aggExt fa fa-plus " id="Ext2" ></span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="n_flex">
                      <div class="n_flex_col100 lg_flex_col50 xl_flex_col50 md_flex_col50 sm_flex_col100 xs_flex_col100  horizontal_padding">
                        <div class="frmCont">
                          <label for="txtSelect2">Comuna<span class="TwoPoints">*</span></label>
                          <div class="frmInput frmInput_select2">
                            <select type="text" data-rule-RE_Select="-1" class="select input_data" name="SltComuna" id="SltComuna">
                              <option value="-1">Seleccione una comuna.</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="n_flex_col100 lg_flex_col50 xl_flex_col50 md_flex_col50 sm_flex_col100 xs_flex_col100  horizontal_padding">
                        <div class="frmCont">
                          <label for="txtSelect2">Barrio<span class="TwoPoints">*</span></label>
                          <div class="frmInput frmInput_select2">
                            <select type="text" data-rule-RE_Select="-1" disabled="true" class="select input_data" name="SltBarrio" id="SltBarrio">
                              <option value="-1">Seleccione un barrio.</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="n_flex">
                      <div class="tooltip ">
                      <span class="button  fa fa-home fa-lg"id="direcResident"style="position: absolute;left: 100px;top: 8px; color:#1f95d0;cursor:pointer;"></span>
                      <span class="tooltiptext"style="bottom: 100% !important; margin-left: 69px !important;">Dirección residencia.</span>
                    </div>
                      <div class="n_flex_col100 lg_flex_col50 xl_flex_col50 md_flex_col50 sm_flex_col100 xs_flex_col100  horizontal_padding">
                        <div class="frmCont">
                          <label for="campo1">Dirección<span class="TwoPoints">*</span></label>
                          <div class="frmInput">
                            <input type="text" data-rule-required="true" data-rule-maxlength="30" class="input_data" name="txtDireccionCita" id="txtDireccionCita" autocomplete="off" placeholder="Ejm:CL 132 # 74 A 23">
                          </div>
                        </div>
                      </div>
                      <div class="n_flex_col100 lg_flex_col50 xl_flex_col50 md_flex_col50 sm_flex_col100 xs_flex_col100  horizontal_padding">
                        <div class="frmCont">
                          <label for="cmbCodigoCUP">Código CUP<span class="TwoPoints">*</span></label>
                          <div class="frmInput frmInput_select2" style="height:100%">
                            <select class="input_data" data-rule-RE_Select="0" onchange='seleccionarDescripcionAutomaticamente(this)' id="cmbCodigoCUP" name="cmbCodigoCUP"><option></option></select>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="n_flex">
                      <div class=" lg_flex_col20 xl_flex_col20 md_flex_col20 sm_flex_col20 xs_flex_col20  horizontal_padding">
                      </div>
                      <div class="n_flex_col100 lg_flex_col60 xl_flex_col60 md_flex_col100 sm_flex_col100 xs_flex_col100  horizontal_padding">
                        <div class="frmCont">
                          <label for="cmbDescripcionCUP">Descripción CUP<span class="TwoPoints">*</span></label>
                          <div class="frmInput frmInput_select2" style="height:100%">
                            <select class="input_data" data-rule-RE_Select="0" onchange='seleccionarCodigoAutomaticamente(this)'id="cmbDescripcionCUP" name="cmbDescripcionCUP"><option></option></select>
                          </div>
                        </div>

                      </div>
                    </div>



                  </article>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </form>


  <form id="frmC" method="post">
    <div class="calen">
      <section class="calendario" id="part4"class="contPart">
        <!-- CONTENIDO -->
        <div class="n_flex n_justify_center">

          <!-- CONTENIDO VISTA -->
          <div class="n_flex n_flex_col95 sm_flex_col90">

            <!-- TITULO VISTA -->
            <div class="n_flex n_flex_col100">
              <h1 class="titulo_vista"><span class="fa fa-calendar-plus-o"></span>Cita</h1>
            </div>
            <div class="n_flex n_flex_col100 n_justify_around">

              <!-- CONTENEDOR PRINCIPAL IZQUIERDO -->
              <div class="n_flex n_flex_col100  xl_flex_col100 lg_flex_col100 horizontal_padding n_in_columns">


                <!-- GRID -->
                <div class="panel block">
                  <div class="panel-cabecera">
                    <h3>Turnos para <span class="NombrePaciente"></span></h3>
                  </div>
                  <div class="panel-contenido">
                    <article class="block">
                      <div class="contenido-calendario">
                        <div class="encabezado-calendario">

                          <div class="encabezado-meses">
                            <ul>
                              <li id="hora"><strong id="faa"></strong></li>
                            </ul>
                            <ul>
                              <li name="izquierda" ><button onclick="cll(1)" type="button" name="AnteriorMes" class="li1 fa fa-chevron-left"></button></li>
                              <li class="li2" id="li2"></li>
                              <li  id="derecha"><button onclick="cll(2)" type="button" name="SiguienteMes" class="li3 fa fa-chevron-right"></button></li>
                            </ul>
                          </div>
                          <div class="encabezado-nuevo"></div>
                        </div>
                        <div class="cuerpo-calendario">
                          <div class="cuerpo-titulo">
                            <ul>
                              <li><a href="javascript:openVentana();">Domingo</a></li>
                              <li><a href="javascript:openVentana();">Lunes</a></li>
                              <li><a href="javascript:openVentana();">Martes</a></li>
                              <li><a href="javascript:openVentana();">Miércoles</a></li>
                              <li><a href="javascript:openVentana();">Jueves</a></li>
                              <li><a href="javascript:openVentana();">Viernes</a></li>
                              <li><a href="javascript:openVentana();">Sábado</a></li>
                            </ul>
                          </div>
                          <div class="cuerpo-titulo2">
                            <ul>
                              <li><a href="">D</a></li>
                              <li><a href="">L</a></li>
                              <li><a href="">M</a></li>
                              <li><a href="">M</a></li>
                              <li><a href="">J</a></li>
                              <li><a href="">V</a></li>
                              <li><a href="">S</a></li>
                            </ul>
                          </div>
                          <div class="cuerpo-dias " id="cuerpo-dias"></div>

                        </div>
                      </div>

                    </article>
                    <article class="block">
                      <!-- 'id' debe ser igual a 'target' -->
                      <div class="modal-ventana whole_wrapper dont_close" id="modalTurnos">
                        <div class="modal relative_element">

                          <div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between">
                            <!-- Titulo de la ventana modal -->
                            <h2>Turnos para <span class="NombrePaciente"></span></h2>
                            <span class="btn-cerrar-modal modal-cerrar fa fa-times"></span>
                          </div>

                          <div class="modal-body">
                            <!-- Contenido de la ventana modal -->
                            <div class="panel block">
                              <div class="panel-contenido">
                                <article class="block">
                                  <h6 class="text_bold block" id="DaySem"></h6>
                                  <div id="divTbl"></div>
                                </article>
                              </div>
                            </div>
                          </div>

                          <div class="modal-footer n_flex n_justify_end">
                            <button type="button" class="btn-cerrar-modal btn btn-cancelar"  name="button">Cerrar</button>
                            <button type="submit" class="btn btn-consultar btn-cerrar-modal" name="button" id="sgteMedicos">Siguiente</button>
                          </div>

                        </div>
                      </div>
                    </article>
                  </div>

                </div>

              </div>
            </div>
          </div>
        </div>

      </section>
    </div>
  </form>


  <div id="part5"class="contPart" >
    <!-- CONTENIDO -->
    <div class="n_flex n_justify_center">

      <!-- CONTENIDO VISTA -->
      <div class="n_flex n_flex_col95 sm_flex_col90">

        <!-- TITULO VISTA -->
        <div class="n_flex n_flex_col100">
          <h1 class="titulo_vista"><span class="fa fa-calendar-plus-o"></span>Cita</h1>
        </div>
        <div class="n_flex n_flex_col100 n_justify_around">

          <!-- CONTENEDOR PRINCIPAL IZQUIERDO -->
          <div class="n_flex n_flex_col100  xl_flex_col100 lg_flex_col100 horizontal_padding n_in_columns">

            <!-- GRID -->
            <div class="panel block">
              <div class="panel-cabecera">
                <h3>Personal Médico</h3>
              </div>
              <div class="panel-contenido scroll-panel">
                <div class="n_flex_col100 horizontal_padding ovf_initial block">
                  <!-- BARRA BUSQUEDA -->
                  <label for="">Búsqueda especializada:</label>
                  <br><br>
                  <div class="barra-filtro ">
                    <!--BÓTON DE CONFIGURACIÓN-->
                    <div class=" btn-barra-filtro "><span class="fa fa-search"></span></div>
                    <!--INPUT DE CONFIGURACIÓN-->
                    <div class=" input-barra"><input type="search" id="txtBusquedaMedicos" placeholder="Ejm:Psicólogo"></div>
                    <!--BÓTON QUE DESPLIEGA EL EL MENÚ DE CONFIGURACIÓN-->
                    <div class="btn-barra-menu"><span class="fa fa-cog"><span class="fa fa-caret-down"></span></span></div>
                    <!--MENÚ DE CONFIGURACIÓN-->
                    <form class="menu-filtro " style="display: none;">

                      <!--OPCIONES DE BÚSQUEDA-->
                      <div class="contenido-menu-filtro">
                        <h5 class="toggle"><span class="fa fa-search"></span>Opciones de Búsqueda</h5>
                        <div class="contenedor-input  n_flex n_flex_col50 lg_flex_col50 md_flex_col100">
                          <label for="" style="padding: 5%">Buscar por:</label>
                          <div class="divFiltro">
                            <select id="sltFiltroMedicos">
                              <option value="1">Especialidad</option>
                              <option value="2">Nombres</option>
                            </select>
                          </div>
                        </div>

                      </div><!--FIN OPCIONES DE BÚSQUEDA-->
                    </form>

                  </div>
                </div>

                <form id="formPersonalMedico" method="post">
                  <div class="n_flex">

                    <ul class="list_panel relative_element n_flex n_justify_start block n_grow_up medicos" id="tblMedicos">

                    </ul>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    </div>


    <div id="part6"class="contPart" >
      <!-- CONTENIDO -->
      <div class="n_flex n_justify_center">

        <!-- CONTENIDO VISTA -->
        <div class="n_flex n_flex_col95 sm_flex_col90">

          <!-- TITULO VISTA -->
          <div class="n_flex n_flex_col100">
            <h1 class="titulo_vista"><span class="fa fa-calendar-plus-o"></span>Cita</h1>
          </div>
          <div class="n_flex n_flex_col100 n_justify_around">

            <!-- CONTENEDOR PRINCIPAL IZQUIERDO -->
            <div class="n_flex n_flex_col100  xl_flex_col100 lg_flex_col100 horizontal_padding n_in_columns">

              <!-- GRID -->
              <div class="panel block">
                <div class="panel-cabecera">
                  <h3>Personal de Jefes en Enfermería</h3>
                </div>
                <div class="panel-contenido scroll-panel">
                  <div class="n_flex">
                    <div class="n_flex_col100 lg_flex_col35 xl_flex_col30 md_flex_col45 sm_flex_col100 xs_flex_col100 sugerenciaEnfermeria"id="sgEnferJefes">
                      <label for="">Sugerencias:</label>
                      <button class="addSugerenciasEnf" id="personalEnfer">Mostrar más</button>
                      <ul  id="sugerenciaEnf"style="padding-right: 25px;padding-top: 20px;padding-bottom: 30px;" class="n_align_start n_grow_up list_panel relative_element n_flex n_justify_start block n_in_columns"></ul>

                    </div>

                  <div class="n_flex_col100 lg_flex_col65 xl_flex_col70 md_flex_col55 sm_flex_col100 xs_flex_col100">
                  <div class="n_flex_col100 horizontal_padding ovf_initial block">
                    <!-- BARRA BUSQUEDA -->
                    <label for="">Buscar por nombre:</label>
                    <br><br>
                    <div class="barra-filtro ">
                      <!--BÓTON DE CONFIGURACIÓN-->
                      <div class=" btn-barra-filtro "><span class="fa fa-search"></span></div>
                      <!--INPUT DE CONFIGURACIÓN-->
                      <div class=" input-barra"><input type="search" id="txtBusquedaEnfermerosJefe" placeholder="Ejm: Juan"></div>
                      <!--MENÚ DE CONFIGURACIÓN-->
                      <form class="menu-filtro " style="display: none;"></form>
                    </div>

                  <form id="frmPersonalJefeEnfermeros" method="post">

                    <ul class="list_panel relative_element n_flex n_justify_start block enfermeros" id="tblEnfJefe">

                    </ul>
                  </form>
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

    <div id="part7"class="contPart" >
      <!-- CONTENIDO -->
      <div class="n_flex n_justify_center">

        <!-- CONTENIDO VISTA -->
        <div class="n_flex n_flex_col95 sm_flex_col90">

          <!-- TITULO VISTA -->
          <div class="n_flex n_flex_col100">
            <h1 class="titulo_vista"><span class="fa fa-calendar-plus-o"></span>Cita</h1>
          </div>
          <div class="n_flex n_flex_col100 n_justify_around">

            <!-- CONTENEDOR PRINCIPAL IZQUIERDO -->
            <div class="n_flex n_flex_col100  xl_flex_col100 lg_flex_col100 horizontal_padding n_in_columns">

              <!-- GRID -->
              <div class="panel block">
                <div class="panel-cabecera">
                  <h3>Personal de Auxiliares en Enfemería</h3>
                </div>
                <div class="panel-contenido scroll-panel">
                  <div class="n_flex">
                    <div class="n_flex_col100 lg_flex_col35 xl_flex_col30 md_flex_col45 sm_flex_col100 xs_flex_col100 sugerenciaEnfermeria">
                      <label for="">Sugerencias:</label>
                      <button class="addSugerenciasEnf" id="personalAux">Mostrar más</button>
                      <ul  id="sugerenciaAux"style="padding-right: 25px;padding-top: 20px;padding-bottom: 30px;" class="n_align_start list_panel relative_element n_flex n_justify_start block n_in_columns"></ul>

                    </div>
                    <div class="n_flex_col100 lg_flex_col65 xl_flex_col70 md_flex_col55 sm_flex_col100 xs_flex_col100 ">
                  <div class="n_flex_col100 horizontal_padding ovf_initial block">
                    <!-- BARRA BUSQUEDA -->
                    <label for="">Buscar por nombre:</label>
                    <br><br>
                    <div class="barra-filtro ">
                      <!--BÓTON DE CONFIGURACIÓN-->
                      <div class=" btn-barra-filtro "><span class="fa fa-search"></span></div>
                      <!--INPUT DE CONFIGURACIÓN-->
                      <div class=" input-barra"><input type="text" autocomplete="off" class="input_data" onkeyup="ConsultaNombresAuxEnf(this.value)" placeholder="Ejm:Mateo"></div>
                      <!--MENÚ DE CONFIGURACIÓN-->
                      <form class="menu-filtro " style="display: none;"></form>
                    </div>
                  </div>

                  <form id="frmAxuEnfermeria" method="post">

                    <ul class="n_grow_up list_panel relative_element n_flex n_justify_start block auxiliares" id="tblAuxEnferm">

                    </ul>
                  </form>
                </div>
              </div>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-ventana whole_wrapper dont_close" id="modalInformeCitas">
        <div class="modal relative_element">

          <div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between">
            <!-- Titulo de la ventana modal -->
            <h2>Informe de la cita.</h2>
          </div>

          <div class="modal-body">
            <!-- Contenido de la ventana modal -->
            <div class="panel block">
              <div class="panel-contenido">
                <article class="block">
                  <div class="reporte_cita">
                    <div class="encabezado_informe"></div>
                    <div class="bodyInform n_flex"style="justify-content: center;border-bottom: 1px solid rgba(0, 0, 0, 0.14902);"></div>
                    <div class="n_flex n_flex_col100 n_justify_around">
                      <div class="informepart1 n_flex n_flex_col100 lg_flex_col50 horizontal_padding n_in_columns"></div>
                      <div class="informepart2 n_flex n_flex_col100 lg_flex_col50 horizontal_padding n_in_columns"></div>
                    </div>
                  </div>
                </article>
              </div>
            </div>
          </div>

          <div class="modal-footer n_flex n_justify_end">
            <button type="button" class="btn btn-registrar" id="terminarCita">Terminar</button>
          </div>

        </div>
      </div>
    </div>
