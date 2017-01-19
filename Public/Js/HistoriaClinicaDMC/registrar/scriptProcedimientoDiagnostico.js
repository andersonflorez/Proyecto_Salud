var contP = 0;
var contD = 0;
var registros = [];
var tabla;

var codigoLimiteProcedimiento =[];
var descripcionLimiteProcedimiento =[];
$(document).ready(function(){
	ValidateForm('frmProcedimientoDiagnostico', function(formData){
		var registroProcedimientos = [];
		for(var i=0;i<$(".cmbCodigoProcedimiento").length;i++){
			var id = $(".cmbCodigoProcedimiento").eq(i).val();
			var descripcion = $(".txtDescripcionCups").eq(i).val();
			if(id!=null){
				registroProcedimientos.push({id:btoa(id),descripcion:descripcion});
			}
		}

		localStorage.setItem("procedimientos",btoa(JSON.stringify(registroProcedimientos)));




		var registroDiagnostico= [];
		for(var i=0;i<$(".cmbCodigoDiagnostico").length;i++){
			var id = $(".cmbCodigoDiagnostico").eq(i).val();
			var descripcion = $(".txtDescripcionDiagnostico").eq(i).val();
			if(id!=null){
				registroDiagnostico.push({id:btoa(id),descripcion:descripcion});
			}
		}

		localStorage.setItem("diagnostico",btoa(JSON.stringify(registroDiagnostico)));

		window.location = url+"historiaClinicaDMC/ctrlRegistrarMedicacion/index/"+idPaciente+"/"+idCita+"/"+idCitaProgramacion;
	});

	if(localStorage.getItem("procedimientos") != null){
		var registrosProcedimientos = JSON.parse(atob(localStorage.getItem("procedimientos")));
		if(registrosProcedimientos.length > 0){
			if(registrosProcedimientos[0].id != ""){
				for(var i =0 ; i< registrosProcedimientos.length;i++){
					console.log(registrosProcedimientos[i].id)
					agregarProcedimiento();
					$(".txtDescripcionCups").last().val(registrosProcedimientos[i].descripcion);
					$(".txtDescripcionCups").last().attr("data-rule-required","true");
					$.ajax({
						url: url+"HistoriaClinicaDMC/ctrlRegistrarProcedimientoDiagnostico/consultarDescripcionIdCup",
						type:"POST",
						data:{
							id:atob(registrosProcedimientos[i].id)
						},
						async:false
					}).done(function(data){
						$(".cmbDescripcionProcedimiento").last().html("<option selected='select' value='"+atob(registrosProcedimientos[i].id)+"'>"+data+"</option>");
						select2DescripcionCup();
						select2CodigoCup();
					});
					$.ajax({
						url: url+"HistoriaClinicaDMC/ctrlRegistrarProcedimientoDiagnostico/consultarCodigoIdCup",
						type:"POST",
						data:{
							id:atob(registrosProcedimientos[i].id)
						},
						async:false
					}).done(function(data){
						$(".cmbCodigoProcedimiento").last().html("<option selected='select' value='"+atob(registrosProcedimientos[i].id)+"'>"+data+"</option>");
						select2DescripcionCup();
						select2CodigoCup();
					});
				}
			}
			else{
				agregarProcedimiento();
			}
		}
		else{
			agregarProcedimiento();
		}
	}
	else{
		agregarProcedimiento();
	}

	$('#btnNuevoProcedimiento').click(function(){
		agregarProcedimiento();
	});
	$('#btnQuitarProcedimiento').click(function(){
		quitarProcedimiento();
	});

	if(localStorage.getItem("diagnostico") != null){
		var registrosDiagnosticos = JSON.parse(atob(localStorage.getItem("diagnostico")));
		if(registrosDiagnosticos.length > 0){
			if(registrosDiagnosticos[0].id != ""){
				for(var i =0 ; i< registrosDiagnosticos.length;i++){
					console.log(registrosDiagnosticos[i].id)
					agregarDiagnostico();
					$(".txtDescripcionDiagnostico").last().val(registrosDiagnosticos[i].descripcion);
					$(".txtDescripcionDiagnostico").last().attr("data-rule-required","true");
					$.ajax({
						url: url+"HistoriaClinicaDMC/ctrlRegistrarProcedimientoDiagnostico/consultarDescripcionIdCie10",
						type:"POST",
						data:{
							id:atob(registrosDiagnosticos[i].id)
						},
						async:false
					}).done(function(data){
						$(".cmbDescripcionDiagnostico").last().html("<option selected='select' value='"+atob(registrosDiagnosticos[i].id)+"'>"+data+"</option>");
						select2DescripcionCie10();
						select2CodigoCie10();
					});
					$.ajax({
						url: url+"HistoriaClinicaDMC/ctrlRegistrarProcedimientoDiagnostico/consultarCodigoIdCie10",
						type:"POST",
						data:{
							id:atob(registrosDiagnosticos[i].id)
						},
						async:false
					}).done(function(data){
						$(".cmbCodigoDiagnostico").last().html("<option selected='select' value='"+atob(registrosDiagnosticos[i].id)+"'>"+data+"</option>");
						select2DescripcionCie10();
						select2CodigoCie10();
					});
				}
			}
			else{
				agregarDiagnostico();
			}
		}
		else{
			agregarDiagnostico();
		}
	}
	else{
		agregarDiagnostico();
	}

	$('#btnNuevoDiagnostico').click(function(){
		agregarDiagnostico();
	});
	$('#btnQuitarDiagnostico').click(function(){
		quitarDiagnostico();

	});
});

function seleccionarCodigoAutomaticamente(select,cont){

	$(".txtDescripcionCups").eq(cont).attr("data-rule-required","true");
	var valor = $(select).val(); 
	console.log(select);
	$("#"+select.id+" > option").first().remove();
	$("#"+select.id+" > option[value='"+valor+"']").html($("#"+select.id).parent().children().eq(1).children().children().children().eq(0).html());
	$("#"+select.id+" > option[value='"+valor+"']").attr("selected","selected");

	$.ajax({
		url: url+"HistoriaClinicaDMC/ctrlRegistrarProcedimientoDiagnostico/consultarCodigoIdCup",
		type:"POST",
		data:{
			id:valor
		}
	}).done(function(data){
		$(".cmbCodigoProcedimiento").eq(cont).html("<option selected='select' value='"+valor+"'>"+data+"</option>");
		select2DescripcionCup();
		select2CodigoCup();
	});
}
function seleccionarDescripcionAutomaticamente(select,cont){
	$(".txtDescripcionCups").eq(cont).attr("data-rule-required","true");
	var valor = $(select).val();
	$("#"+select.id+" > option").first().remove();
	$("#"+select.id+" > option[value='"+valor+"']").html($("#"+select.id).parent().children().eq(1).children().children().children().eq(0).html());
	$("#"+select.id+" > option[value='"+valor+"']").attr("selected","selected");

	$.ajax({
		url: url+"HistoriaClinicaDMC/ctrlRegistrarProcedimientoDiagnostico/consultarDescripcionIdCup",
		type:"POST",
		data:{
			id:valor
		}
	}).done(function(data){
		$(".cmbDescripcionProcedimiento").eq(cont).html("<option selected='select' value='"+valor+"'>"+data+"</option>");
		select2DescripcionCup();
		select2CodigoCup();
	});
}

function agregarProcedimiento(){

	$("#containerProcedimiento").append("<tr><td rowspan='2'><button onclick='quitarProcedimiento(this)' type='button' class='btn btn-eliminar btnquitarProcedimiento' id='btnQuitarProcedimiento'><i class='fa fa-times'></i></button></td><td width='600px;'><div class='frmCont'><Label></label><div class='frmInput frmInput_select2'><select onchange ='seleccionarCodigoAutomaticamente(this,"+contP+")'id='cmbDescripcionCups"+(contP+1)+"' class='cmbDescripcionProcedimiento' name=''><option selected='selected'></option></select></div></div></td><td><div class='frmCont'><label></label><div class='frmInput frmInput_select2'><select onchange= 'seleccionarDescripcionAutomaticamente(this,"+contP+")'  id='codigoCupCmb"+(contP+1)+"' class='cmbCodigoProcedimiento' name=''><option selected='selected'></option></select></div></div></td></tr><tr><td colspan='2'><div class='frmCont'><label></label><div class='frmInput'><input autocomplete='off' data-rule-maxlength='1000' placeholder='Descripción del Procedimiento'type='text' name='txtP"+contP+"' class='input_data txtDescripcionCups'></div></div></td></tr>");
	select2DescripcionCup();
	select2CodigoCup();
	focusInputsValidaciones();
	contP++;

}
//Esta funcion me permite quitar un procedimiento
function quitarProcedimiento(el){
	var posicionIndex = $(".btnquitarProcedimiento").index(el);
	$("#containerProcedimiento").children().eq(posicionIndex).remove();
	$("#containerProcedimiento").children().eq(posicionIndex).remove();
	contP--;
}

function select2DescripcionCup(){
	$('.cmbDescripcionProcedimiento').select2({
		placeholder: 'Seleccione una opción',
		minimumInputLength: 2,
		ajax: {
			url: url+"HistoriaClinicaDMC/ctrlRegistrarProcedimientoDiagnostico/consultarDescripcionCup",
			dataType: 'json',
			delay: 250,
			type:'POST',
			data: function (params) {
				return {
					q: params.term, // search term
					page: params.page
				};
			},
			processResults: function (data, params) {
				// parse the results into the format expected by Select2
				// since we are using custom formatting functions we do not need to
				// alter the remote JSON data, except to indicate that infinite
				// scrolling can be used
				params.page = params.page || 1;

				return {
					results: data.items
				};
			},
			cache: true
		},
		escapeMarkup: function (markup) { return markup; },
		minimumInputLength: 3,
		templateResult: function (data) {
			if (data.loading) return data.text;

			var markup = data.nombreCup;
			return markup;
		},
		templateSelection: function (data) {
			return data.nombreCup || data.text;
		}
	});
}

function select2CodigoCup(){
	$('.cmbCodigoProcedimiento').select2({
		placeholder: 'Seleccione una opción',
		minimumInputLength: 2,
		ajax: {
			url: url+"HistoriaClinicaDMC/ctrlRegistrarProcedimientoDiagnostico/consultarCodigoCup",
			dataType: 'json',
			delay: 250,
			type:'POST',
			data: function (params) {
				return {
					q: params.term, // search term
					page: params.page
				};
			},
			processResults: function (data, params) {
				// parse the results into the format expected by Select2
				// since we are using custom formatting functions we do not need to
				// alter the remote JSON data, except to indicate that infinite
				// scrolling can be used
				params.page = params.page || 1;

				return {
					results: data.items,
					pagination: {
						more: (params.page * 30) < data.total
					}
				};
			},
			cache: true
		},
		escapeMarkup: function (markup) { return markup; },
		minimumInputLength: 2,
		templateResult: function (data) {
			if (data.loading) return data.text;
			if (data.loading) return data.text;
			var markup = data.codigoCup;
			return markup;
		},
		templateSelection: function (data) {
			return data.codigoCup || data.text;
		}
	});

}

//diagnostico
function seleccionarCodigoAutomaticamenteDiagnostico(select,cont){

	$(".txtDescripcionDiagnostico").eq(cont).attr("data-rule-required","true");
	var valor = $(select).val();   

	$("#"+select.id+" > option").first().remove();
	$("#"+select.id+" > option[value='"+valor+"']").html($("#"+select.id).parent().children().eq(1).children().children().children().eq(0).html());
	$("#"+select.id+" > option[value='"+valor+"']").attr("selected","selected");

	$.ajax({
		url: url+"HistoriaClinicaDMC/ctrlRegistrarProcedimientoDiagnostico/consultarCodigoIdCie10",
		type:"POST",
		data:{
			id:valor
		}
	}).done(function(data){
		$(".cmbCodigoDiagnostico").eq(cont).html("<option selected='select' value='"+valor+"'>"+data+"</option>");
		select2DescripcionCie10();
		select2CodigoCie10();
	});
}
function seleccionarDescripcionAutomaticamenteDiagnostico(select,cont){
	$(".txtDescripcionDiagnostico").eq(cont).attr("data-rule-required","true");
	var valor = $(select).val();
	$("#"+select.id+" > option").first().remove();
	$("#"+select.id+" > option[value='"+valor+"']").html($("#"+select.id).parent().children().eq(1).children().children().children().eq(0).html());
	$("#"+select.id+" > option[value='"+valor+"']").attr("selected","selected");

	$.ajax({
		url: url+"HistoriaClinicaDMC/ctrlRegistrarProcedimientoDiagnostico/consultarDescripcionIdCie10",
		type:"POST",
		data:{
			id:valor
		}
	}).done(function(data){
		$(".cmbDescripcionDiagnostico").eq(cont).html("<option selected='select' value='"+valor+"'>"+data+"</option>");
		select2DescripcionCie10();
		select2CodigoCie10();
	});
}





function agregarDiagnostico(){
	if(contD<5){
		$("#containerDiagnostico").append("<tr><td rowspan= '2'><button onclick='quitarDiagnostico(this)' type='button' class='btn btn-eliminar btnquitarDiagnostico'id='btnQuitarDiagnostico'><i class='fa fa-times'></i></button></td><td width='600px;'><div><div class='frmCont'><label></label><div class='frmInput frmInput_select2'><select onchange='seleccionarCodigoAutomaticamenteDiagnostico(this,"+contD+")' id= 'cmbDescripcionCie10"+(contD+1)+"'class='select cmbDescripcionDiagnostico' name=''><option></option></select></div></div></td><td><div class='frmCont'><label></label><div class='frmInput frmInput_select2'><select onchange= 'seleccionarDescripcionAutomaticamenteDiagnostico(this,"+contD+")' id= 'cmbCodigoCie10"+(contD+1)+"'class='cmbCodigoDiagnostico select' name=''><option></option></select></div></div></td></tr><tr><td colspan='2'><div class='frmCont'><label></label><div class='frmInput'><input data-rule-maxlength='1000'placeholder='Diagnóstico Realizado' autocomplete='off'type='text' name='txtD"+contD+"'class='txtDescripcionDiagnostico input_data'></div></div></td></tr>");
		select2DescripcionCie10();
		select2CodigoCie10();
		focusInputsValidaciones();
		contD++;
	}
}

function quitarDiagnostico(el){
	var posicionIndex = $(".btnquitarDiagnostico").index(el);
	$("#containerDiagnostico").children().eq(posicionIndex).remove();
	$("#containerDiagnostico").children().eq(posicionIndex).remove();
	contD--;
}

function select2DescripcionCie10(){
	$('.cmbDescripcionDiagnostico').select2({
		placeholder: 'Seleccione una opción',
		minimumInputLength: 2,
		ajax: {
			url: url+"HistoriaClinicaDMC/ctrlRegistrarProcedimientoDiagnostico/consultarDescripcionCie10",
			dataType: 'json',
			delay: 250,
			type:'POST',
			data: function (params) {
				return {
					q: params.term, // search term
					page: params.page
				};
			},
			processResults: function (data, params) {
				// parse the results into the format expected by Select2
				// since we are using custom formatting functions we do not need to
				// alter the remote JSON data, except to indicate that infinite
				// scrolling can be used
				params.page = params.page || 1;

				return {
					results: data.items
				};
			},
			cache: true
		},
		escapeMarkup: function (markup) { return markup; },
		minimumInputLength: 3,
		templateResult: function (data) {
			if (data.loading) return data.text;

			var markup = data.descripcionCIE10;
			return markup;
		},
		templateSelection: function (data) {
			return data.descripcionCIE10 || data.text;
		}
	});
}

function select2CodigoCie10(){
	$('.cmbCodigoDiagnostico').select2({
		placeholder: 'Seleccione una opción',
		minimumInputLength: 2,
		ajax: {
			url: url+"HistoriaClinicaDMC/ctrlRegistrarProcedimientoDiagnostico/consultarCodigoCie10",
			dataType: 'json',
			delay: 250,
			type:'POST',
			data: function (params) {
				return {
					q: params.term, // search term
					page: params.page
				};
			},
			processResults: function (data, params) {
				// parse the results into the format expected by Select2
				// since we are using custom formatting functions we do not need to
				// alter the remote JSON data, except to indicate that infinite
				// scrolling can be used
				params.page = params.page || 1;

				return {
					results: data.items,
					pagination: {
						more: (params.page * 30) < data.total
					}
				};
			},
			cache: true
		},
		escapeMarkup: function (markup) { return markup; },
		minimumInputLength: 2,
		templateResult: function (data) {
			if (data.loading) return data.text;
			if (data.loading) return data.text;
			var markup = data.codigoCIE10;
			return markup;
		},
		templateSelection: function (data) {
			return data.codigoCIE10 || data.text;
		}
	});

}