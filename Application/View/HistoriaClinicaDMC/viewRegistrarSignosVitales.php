<form id="frmSignosVitales">


	<!-- FLECHA DERECHA -->
	<button title="Siguiente" type="submit" class="flecha-der" id="btnSiguiente">
		<li class="fa fa-long-arrow-right"></li>
	</button>


	<!-- FLECHA IZQUIERDA -->
	<button type="button" onclick="window.location = '<?PHP echo URL ?>HistoriaClinicaDMC/ctrlRegistrarAntecedentesExamenes/index/<?PHP echo $idPaciente ."/".$idCita."/".$idCitaProgramacion?>'" title="Volver" class="flecha-izq">
		<li class="fa fa-long-arrow-left"></li>
	</button>


	<div class="n_flex n_justify_center">
		<div class="n_flex n_flex_col95 sm_flex_col90">
			<div class="n_flex n_flex_col100 n_justify_around">
			<div class="n_flex n_flex_col100">
				<h1 class="titulo_vista n_flex_col70 xl_flex_col80"><span class="fa fa-heartbeat"></span>Signos Vitales</h1>
				<button type="button" id="btnAbreviaturas" class="btn btn-consultar" style="height: 41px;margin-top: 33px;">Convenciones</button>
                </div>
				<div class="n_flex_col100 horizontal_padding">
					<div class="panel">
						<div class="panel-contenido">
							<div class="n_flex_col100">
								<div class="tbl_container">
									<!-- principal-->
									<table class="tbl_scroll">
										<thead>
											<tr>
												<th align="center">Tiempo</th>
												<td align="center">
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital0-1" name="txtSignoVital0-1" placeholder="Inicio" autocomplete="off"  data-rule-RE_hours="true">
														</div>
													</div>

												</td>
												<td align="center">
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital0-2" name="txtSignoVital0-2" placeholder="Hora" autocomplete="off"  data-rule-RE_hours="true">
														</div>
													</div>

												</td>
												<td align="center">
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital0-3" name="txtSignoVital0-3" placeholder="Hora" autocomplete="off"  data-rule-RE_hours="true">
														</div>
													</div>

												</td>
												<td align="center">
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital0-4" name="txtSignoVital0-4" placeholder="Fin" autocomplete="off"  data-rule-RE_hours="true">
														</div>
													</div>

												</td>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th>F.C</th>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital1-1" name="txtSignoVital1-1" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>

												</td>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital1-2" name="txtSignoVital1-2" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>

												</td>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital1-3" name="txtSignoVital1-3" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>

												</td>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital1-4" name="txtSignoVital1-4" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>

												</td>
											</tr>
											<tr>
												<th>T.A.S</th>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital2-1" name="txtSignoVital2-1" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>

												</td>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital2-2" name="txtSignoVital2-2" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>

												</td>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital2-3" name="txtSignoVital2-3" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>

												</td>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital2-4" name="txtSignoVital2-4" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>

												</td>
											</tr>
											<tr>
												<th>T.A.D</th>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" class="campo1" id="txtSignoVital3-1" name="txtSignoVital3-1" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>

												</td>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" class="campo1" id="txtSignoVital3-2" name="txtSignoVital3-2" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>

												</td>
												<td>

													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" class="campo1" id="txtSignoVital3-3" name="txtSignoVital3-3" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>

												</td>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" class="campo1" id="txtSignoVital3-4" name="txtSignoVital3-4" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>

												</td>
											</tr>
											<tr>
												<th>F.R</th>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital4-1" name="txtSignoVital4-1" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>
												</td>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital4-2" name="txtSignoVital4-2" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>
												</td>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital4-3" name="txtSignoVital4-3" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>
												</td>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital4-4" name="txtSignoVital4-4" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<th>Temperatura °C</th>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital5-1" name="txtSignoVital5-1" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>
												</td>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital5-2" name="txtSignoVital5-2" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>
												</td>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital5-3" name="txtSignoVital5-3" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>
												</td>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital5-4" name="txtSignoVital5-4" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<th>E.C.Glasgow</th>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital6-1" name="txtSignoVital6-1" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>
												</td>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital6-2" name="txtSignoVital6-2" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>
												</td>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital6-3" name="txtSignoVital6-3" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>
												</td>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital6-4" name="txtSignoVital6-4" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<th>SpO2</th>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital7-1" name="txtSignoVital7-1" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>
												</td>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital7-2" name="txtSignoVital7-2" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>
												</td>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital7-3" name="txtSignoVital7-3" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>
												</td>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital7-4" name="txtSignoVital7-4" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<th>Glucometría</th>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital8-1" name="txtSignoVital8-1" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>
												</td>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital8-2" name="txtSignoVital8-2" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>
												</td>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital8-3" name="txtSignoVital8-3" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>
												</td>
												<td>
													<div class="frmCont">
														<label for=""></label>
														<div class="frmInput">
															<input type="text" id="txtSignoVital8-4" name="txtSignoVital8-4" data-rule-RE_NumbersIntDecimal="true" value="" autocomplete="off">
														</div>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>