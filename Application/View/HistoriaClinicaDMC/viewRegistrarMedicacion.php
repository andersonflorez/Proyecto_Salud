<form id="frmMedicacion">
	<button id="btnSiguiente" title="Siguiente" class="flecha-der">
		<li class="fa fa-long-arrow-right"></li>
	</button>


	<!-- FLECHA IZQUIERDA -->
	<button title="Volver" type="button" class="flecha-izq"onclick="window.location = '<?PHP echo URL ?>HistoriaClinicaDMC/ctrlRegistrarProcedimientoDiagnostico/index/<?PHP echo $idPaciente ."/".$idCita."/".$idCitaProgramacion?>'">
		<li class="fa fa-long-arrow-left"></li>
	</button>

	<div class="n_flex n_justify_center">
		<div class="n_flex n_flex_col95 sm_flex_col90">
			<div class="n_flex n_flex_col100 n_justify_around">
				<h1 class="titulo_vista"><span class="fa fa-medkit"></span>Medicación</h1>
				<div class="n_flex_col100 horizontal_padding">
					<div class="panel">
						<div class="panel-contenido">

							<div class="n_flex_col100">
								<div class="tbl_container">
									<!-- principal-->
									<table class="tbl_scroll">
										<thead>
											<tr>
												<th></th>
												<th>Medicamento</th>
												<th>Cantidad unidades</th>
												<th>Vía administración</th>
												<th>Dósis</th>
												<th>Hora</th>
											</tr>
										</thead>
										<tbody id="containerMedicacion">

										</tbody>
									</table>
								</div>
							</div>
							<div style="margin-top: 15px; margin-left: 12px;">
								<button type="button" class="btn btn-registrar" id="btnNuevaMedicacion"><i class="fa fa-plus"></i></button>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>