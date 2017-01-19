<form id="frmAntecedentesExamenes">
    <button id="btnSiguiente" type="submit" title="Siguiente" class="flecha-der">
        <li class="fa fa-long-arrow-right"></li>
    </button>


    <!-- FLECHA IZQUIERDA -->
    <button title="Volver" type="button" class="flecha-izq"onclick="window.location = '<?PHP echo URL ?>HistoriaClinicaDMC/ctrlRegistrarInformacionPersonalAtencion/index/<?PHP echo $idPaciente ."/".$idCita."/".$idCitaProgramacion?>'">
        <li class="fa fa-long-arrow-left"></li>
    </button>

    <div class="n_flex n_justify_center">
        <div class="n_flex n_flex_col95 sm_flex_col90">
            <div class="n_flex n_flex_col100 n_justify_around">
                <h1 class="titulo_vista"><span class="fa fa-clock-o"></span> Antecedentes y Exámenes </h1>
                <div class="n_flex_col100 md_flex_col100 lg_flex_col50 xl_flex_col50 xxl_flex_col50  horizontal_padding n_in_columns">
                    <div class="panel block">
                        <div class="panel-cabecera">
                            <center><h3>Antecedentes</h3></center>
                        </div>
                        <div class="horizontal_padding vertical_padding">
                            <div class="barra-filtro ">

                                <!--BÓTON DE CONFIGURACIÓN-->
                                <div class=" btn-barra-filtro " id="btnBuscarAntecedentes"><span class="fa fa-search"></span></div>
                                <!--INPUT DE CONFIGURACIÓN-->
                                <div class=" input-barra"><input type="search" autocomplete="off" id="txtinputBusquedaAntecedentes" value=""></div>
                                <!-- BOTÓN DE RESET BUSQUEDA -->
                                <div class="reset_search" id="btnBorrarAntecedentes">
                                    <div class="n_flex n_justify_end">
                                        <span class="fa fa-trash"></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="panel-contenido scroll-panel">
                            <div class="fila">

                                <?php
    $cont = 0;
            foreach($queryTipoAntecedentes as $columna){
                echo '<div class="n_flex n_flex_col100" style="margin-top:13px">
                              <div class="columna--10 columna-hd--10 columna-movil--8 columna-tablet--7 Center">
                                  <label class="descripcionTipoAntecedente" for="'.$cont.'">'.$columna->descripcion.'</label>
                              </div>
                              <div class="columna--1  columna-hd--1 columna-tablet--2 checkbox Center">
                                  <input id="'.$cont.'" class="chbAntecedentes" type="checkbox">
                                  <label for="'.$cont.'"><i class="fa fa-check"></i></label>
                              </div>
                              <div  class="columna--8  columna-hd--8 columna-movil--10 columna-tablet--9">
                              <input type="hidden" value="'.$columna->idTipoAntecedente.'" class="txtIdAntecedente"/>
                              <div class="frmCont">
                              <label></label>
                              <div class="frmInputAntecedentes">
                                  <input type="text" data-rule-maxlength="5000" name="txtAntecedentes'.$cont.'" class="input_data txtAntecendentes" disabled placeholder="Debe seleccionar el checkbox">
                              </div>
                              </div>
                              </div>
                            </div>';
                $cont++;
            }



                                ?>
                                <ul class="paginador" id="paginadorDinamico" ></ul>

                            </div>


                        </div>
                    </div>
                </div>

                <div class="n_flex_col100 md_flex_col100 lg_flex_col50 xl_flex_col50 xxl_flex_col50  horizontal_padding n_in_columns">
                    <div class="panel block">
                        <div class="panel-cabecera">
                            <center><h3>Exámenes Físicos</h3></center>
                        </div>
                        <div class="horizontal_padding vertical_padding">
                            <div class="barra-filtro ">

                                <!--BÓTON DE CONFIGURACIÓN-->
                                <div class=" btn-barra-filtro " id="btnBuscarExamenes"><span class="fa fa-search"></span></div>
                                <!--INPUT DE CONFIGURACIÓN-->
                                <div class=" input-barra"><input type="search" autocomplete="off" id="txtinputBusquedaExamenes" value=""></div>
                                <!-- BOTÓN DE RESET BUSQUEDA -->
                                <div class="reset_search" id="btnBorrarExamenes">
                                    <div class="n_flex n_justify_end">
                                        <span class="fa fa-trash"></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="panel-contenido scroll-panel">

                            <div class="fila">

                                <?php

                                $cont=0;
                                foreach($queryListarExamenFisico as $registros){
                                    echo '<div class="n_flex n_flex_col100">
								<!-- LABEL -->
								<div class="n_flex n_flex_col40 Center">
									<label class="descripcionTipoExamen" for="'.$cont.'A">
										'.$registros->descripcionExamenFisico.'
									</label>
								</div>
								<!-- CHECK BOX-->
								<div class="n_flex n_flex_col20 checkbox Center">
									<input id="'.$cont.'A" class="chbExamenFisico" type="checkbox">
									<label for="'.$cont.'A"><i class="fa fa-check"></i></label>
								</div>

								<!-- RADIO B. -->
								<div class="n_flex n_flex_col30 radios" >
									<div class="radio cont-rdo" >
										<div class="rdo Center">
											<input type="radio" disabled id="'.$cont.'B" name="'.$cont.'" class="rdoExamenFisicoN">
											<label for="'.$cont.'B">N</label>
										</div>

									</div>
									<div class="radio cont-rdo">
										<div class="rdo">
											<input type="radio" disabled id="'.$cont.'C" name="'.$cont.'" class="rdoExamenFisicoA">
											<label for="'.$cont.'C">A</label>
										</div>
									</div>
								</div>
								<!-- INPUT -->
								<div class="columna--9 columna-hd--9 columna-movil--9 columna-tablet--9">
                                <input type="hidden" value="'.$registros->idtipoExamenFisico.'" class="txtIdExamenFisico"/>
                                <div class="frmCont">
                                <label></label>
                                <div class="frmInputExamenes">
									<input type="text" data-rule-maxlength="5000" name="txtExamenFisico'.$cont.'" class="input_data txtExamenFisico" disabled placeholder="Debe seleccionar el check">
								</div>
                                </div>
                                </div>

							</div>';
                                    $cont++;
                                }

                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>
