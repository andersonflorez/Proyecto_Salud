<!-- CONTENIDO -->
<div class="n_flex n_justify_center">
  <!-- CONTENIDO VISTA -->
  <div class="n_flex n_flex_col95 sm_flex_col90">
    <!-- TITULO VISTA -->
    <div class="n_flex n_flex_col100">
      <h1 class="titulo_vista"><span class="fa fa-key"></span>Permisos</h1>
    </div>
    <div class="n_flex n_flex_col100 n_justify_around">
      <div class="n_flex n_flex_col100">
        <div class="panel block">
          <div class="panel-cabecera">
            <h3>Asignación de Permisos</h3>
          </div>
          <div class="panel-contenido">
            <form id="FormPermisos">
              <div class="n_flex">
                <div class="n_flex_col100 md_flex_col25">
                  <!-- Inicio select -->
                  <div class="frmCont">
                    <div class="frmInput frmInput_select2">
                      <select class="input_data" name="slcRol" id="slcRol" data-rule-RE_Select="0" data-rule-required="true">
                        <option value="0">Seleccione un rol</option>
                      </select>
                    </div>
                  </div>
                  <!-- fin select -->
                </div>
                <br><br><br>
                <div class="md_flex_col5">
                </div>
                <?php $cont = 0; foreach ( $this->vistasMenu as $vista) {
                  ?>
                  <div class="n_flex_col100 md_flex_col70">
                    <div class="accordion">
                      <div class="accordion-section">
                        <a class="accordion-section-title" href="#accordion<?=$cont ?>"><span class="fa fa-<?=$vista->iconoModulo?>">&nbsp</span><?=$vista->Modulo?></a>
                        <div id="accordion<?=$cont ?>" class="accordion-section-content">

                          <div class="tbl_container">
                            <table class="tbl_scroll">
                              <thead>
                                <th>Permisos</th>
                                <th>
                                  <div class="checkbox">
                                    <input id="<?=$vista->Modulo?>" onclick="check(<?php echo $vista->idModulo?>)" name="<?=$vista->Modulo?>" type="checkbox" name="" value="">
                                    <label for="<?=$vista->Modulo?>">Todo</label>
                                  </div>
                                </th>
                              </thead>
                              <?php $cont++; ?>
                              <?php foreach ($vista->Vistas as $Vista): ?>
                                <tbody>
                                  <tr>
                                    <td><i class="fa fa-<?=$Vista->iconoVista?>"></i>&nbsp<label><?=$Vista->descripcionVista?></label></td>
                                    <th>

                                      <div class="checkbox">
                                        <input id="<?= $Vista->idVista ?>" type="checkbox" name="<?= $Vista->descripcionVista ?>" value="<?php echo $vista->idModulo.'-'.$Vista->idVista ?>">
                                        <label for="<?= $Vista->idVista ?>" class="fa fa-check"></label>
                                      </div>
                                    </th>
                                  </tr>
                                <?php endforeach ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <!--end .accordion-section-content-->
                      </div>
                    </div>
                    <?php
                  }  ?>

                  <!--end .accordion-section-->
                  <br>
                  <br>
                  <div class="n_flex">
                    <div class="n_flex_col100 xs_flex_col50">
                      <center>
                        <button type="button" class="btn btn-cancelar" onclick="location.href='<?=URL?>Home/ctrlPrincipal'">Volver</button>
                      </center>
                    </div>
                    <br> <br>
                    <div class="n_flex_col100 xs_flex_col50">
                      <center>
                        <button type="submit" class="btn btn-registrar" id="btnAsignarPermisos" name="btnAsignarPermisos">Aceptar</button>
                      </center>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
