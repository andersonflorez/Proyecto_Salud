<form id="frmProcedimientoDiagnostico">
    <!-- FLECHA DERECHA -->
    <button type="submit" id="btnSiguiente" title="Siguiente" class="flecha-der">
        <li class="fa fa-long-arrow-right"></li>
    </button>


    <!-- FLECHA IZQUIERDA -->
    <button title="Volver" type="button" class="flecha-izq"onclick="window.location = '<?PHP echo URL ?>HistoriaClinicaDMC/ctrlRegistrarSignosVitales/index/<?PHP echo $idPaciente ."/".$idCita."/".$idCitaProgramacion?>'">
        <li class="fa fa-long-arrow-left"></li>
    </button>

    <div class="n_flex n_justify_center">
        <div class="n_flex n_flex_col95 sm_flex_col90">
            <div class="n_flex n_flex_col100 n_justify_around">
                <h1 class="titulo_vista"><span class="fa fa-flask"></span>Procedimientos  y Diagnósticos</h1>

                <div class="n_flex_col100 md_flex_col100 lg_flex_col50 xl_flex_col50 xxl_flex_col50  horizontal_padding n_in_columns">
                    <div class="panel block">
                        <div class="panel-cabecera">                           
                            <center><h3>Procedimientos</h3></center>
                        </div>
                        <div class="panel-contenido scroll-panel">
                            <div class="n_flex_col100">
                                <div class="tbl_container">
                                    <table class="tbl_scroll">
                                        <thead>
                                            <tr>
                                               <th></th>
                                                <th>Descripción CUPS</th>
                                                <th>Código CUPS</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody id="containerProcedimiento"> 
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div style="margin-top: 15px; margin-left: 12px;">
                                <button type="button" class="btn btn-registrar" id="btnNuevoProcedimiento"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="n_flex_col100 md_flex_col100 lg_flex_col50 xl_flex_col50 xxl_flex_col50  horizontal_padding n_in_columns">
                    <div class="panel block">
                        <div class="panel-cabecera">
                            <center><h3>Diagnósticos</h3></center>
                        </div>
                        <div class="panel-contenido scroll-panel">
                            <div class="n_flex_col100">
                                <div class="tbl_container">
                                    <table class="tbl_scroll">
                                        <thead>
                                            <tr>
                                               <th></th>
                                                <th>Descripción CIE10</th>
                                                <th>Código CIE10</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody id="containerDiagnostico"> 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class=""style="margin-top: 15px;">                                
                                <button type="button" class="btn btn-registrar" id="btnNuevoDiagnostico"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>