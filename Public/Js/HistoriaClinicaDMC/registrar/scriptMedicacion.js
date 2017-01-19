var cont = 0;
var table;
var registroMedicacion = [];
var medicacionDisabled = [];


$(document).ready(function(){
    
	ValidateForm('frmMedicacion', function(formData){

		var registrosLocal = [];
		for(var i=0;i<$(".cmbMedicamento").length;i++){
			var id = $(".cmbMedicamento").eq(i).val();
			var cantidad = $(".txtCantidad").eq(i).val();
			var viaAdministracion = $(".cmbViaAdministracion").eq(i).val();
			var dosis = $(".txtDosis").eq(i).val();
			var hora = $(".txtHora").eq(i).val();
			if(id != null){
				registrosLocal.push({id:btoa(id),cantidad:cantidad,viaAdministracion:viaAdministracion,dosis:dosis,hora:hora});
			}

		}

		localStorage.setItem("medicacion",btoa(JSON.stringify(registrosLocal)));
		window.location = url+"historiaClinicaDMC/ctrlRegistrarOrdenesMedicas/index/"+idPaciente+"/"+idCita+"/"+idCitaProgramacion;
	});
	$.ajax({
		type:'POST',
		dataType:'json',
		url: url+"HistoriaClinicaDMC/ctrlRegistrarMedicacion/ListarComboMedicacion",
		async: false
	}).done(function(cmb){
		$.each(cmb, function(e,s){
			registroMedicacion.push({nombre :s.nombre,id: s.idDetalleKit, cantidad :s.cantidadTotal}); 
		});
		if(localStorage.getItem("medicacion") != null){
			var registrosMedicacion = JSON.parse(atob(localStorage.getItem("medicacion")));
			if(registrosMedicacion.length > 0){
				for(var i =0 ; i< registrosMedicacion.length;i++){
					agregarMedicacion();
					$(".cmbMedicamento ").last().val(atob(registrosMedicacion[i].id));
					$(".txtCantidad").last().val(registrosMedicacion[i].cantidad);
					$(".txtCantidad").last().attr("data-rule-required","true");
					$(".cmbViaAdministracion").last().val(registrosMedicacion[i].viaAdministracion);
					$(".cmbViaAdministracion").last().attr("data-rule-required","true");
					$(".txtDosis").last().val(registrosMedicacion[i].dosis);
					$(".txtDosis").last().attr("data-rule-required","true");
					$(".txtHora").last().val(registrosMedicacion[i].hora);
					$(".txtHora").last().attr("data-rule-required","true");
					disabledMedicacion();
				}
			}
			else{
				agregarMedicacion();
			}
		}
		else{
			agregarMedicacion();
		}
		$(".select").select2({
			placeholder: 'Seleccione una opción'
		});
	}).fail(function(){
		alert("error")
	})

	$('#btnNuevaMedicacion').click(function(){
		agregarMedicacion();

	});
	$('#btnQuitarMedicacion').click(function(){
		quitarMedicacion();

	});
    
});

function agregarMedicacion(){

	$("#containerMedicacion").append("<tr><td><button onclick='quitarMedicacion(this)' type='button' class='btn btn-eliminar btnquitarMedicacion' id='btnQuitarMedicacion'><i class='fa fa-times'></i></button></td><td><div class='frmCont'><div class='frmInput frmInput_select2'><select id='cmbMedicamento"+(cont+1)+"' class='select cmbMedicamento input_data' name='cmbMedicamento"+cont+"' onchange='seleccion("+cont+",this)'><option></option></select></div></div></td><td><div class='frmCont'><label></label><div class='frmInput'><input type='text' min='0' class='txtCantidad input_data' name='txtCantidad"+cont+"' autocomplete='off'></td><td><div class='frmCont'><label></label><div class='frmInput frmInput_select2'><select class='select input_data cmbViaAdministracion' name='cmbViaAdministracion"+cont+"'><option></option><option value='Oral'>Oral</option><option value='Sublingual'>Sublingual</option><option value='Tópica'>Tópica</option><option value='Transdérmica'>Transdérmica</option><option value='Oftálmica'>Oftálmica</option><option value='Ótica'>Ótica</option><option value='Intranasal'>Intranasal</option><option value='Inhalatoria'>Inhalatoria</option><option value='Rectal'>Rectal</option><option value='Vaginal'>vaginal</option><option value='Parenteral'>Parenteral</option></select></td><td><div class='frmCont'><label></label><div class='frmInput'><input data-rule-maxlength='50' type='text' class='txtDosis input_data' name='txtDosis"+cont+"' autocomplete='off'></td><td><div class='frmCont'><label></label><div class='frmInput'><input type='text' id='Hora"+cont+"' class='txtHora input_data' name='txtHora"+cont+"' onfocusout='hora(this,"+cont+")'></td></tr>");

	for (var i = 0;i<registroMedicacion.length;i++) {
		$('#cmbMedicamento'+(cont+1)).append('<option value="'+registroMedicacion[i].id+'">'+registroMedicacion[i].nombre+'</option');

	}
	$("#Hora"+cont).timepicker({ 
		timeFormat: 'H:i',
        minTime: horaCita,
        maxTime: '23:00',
        step: 60 
	});
   

	cont++;

	$(".select").select2({
		placeholder: 'Seleccione una opción'
	});
	disabledMedicacion();
	focusInputsValidaciones();

}



function quitarMedicacion(el){
	var posicionIndex = $(".btnquitarMedicacion").index(el);

	$("#containerMedicacion").children().eq(posicionIndex).remove();
	disabledMedicacion();
	cont--;
}


function hora(el, index){
    
        if($(".txtHora").eq(index).attr("data-rule-required") == "true"){
            var horaCita2 =  new Date (new Date().toDateString() + ' ' + horaCita);
            var horaIngresada = new Date (new Date().toDateString() + ' ' + $(".txtHora").eq(index).val());
           
            if(horaCita2.getTime() > horaIngresada.getTime()){
                Notificate({
            tipo: 'warning',
            titulo: 'Cuidado con las horas',
            descripcion: 'No debe seleccionar una hora menor a la hora de la cita.'
        });
                $(".txtHora").eq(index).val("");
            }
        }
}

function seleccion(cont,select){
	$("#"+select.id+" option").each(function(ind,el){
		if($(el).val() == $(select).val()){
			$(".txtCantidad").eq(cont).attr("max",registroMedicacion[ind-1].cantidad);

		}      
	});
	$(".txtCantidad").eq(cont).attr("data-rule-required","true");
	$(".txtCantidad").eq(cont).attr("data-rule-RE_Numbers","true");
	$(".cmbViaAdministracion").eq(cont).attr("data-rule-required","true");
	$(".txtDosis").eq(cont).attr("data-rule-required","true");
	$(".txtHora").eq(cont).attr("data-rule-required","true");
    $(".txtHora").eq(cont).attr("data-rule-RE_hours","true");
	disabledMedicacion();
}

function disabledMedicacion(){
	$(".cmbMedicamento  option").removeAttr("disabled");
	medicacionDisabled = [];
	$(".cmbMedicamento ").each(function(i,e){
		medicacionDisabled.push($(e).val());
	});

	$(".cmbMedicamento ").each(function(i,e){
		$("#"+e.id+" option").each(function(ind,el){
			for(var i =0;i<medicacionDisabled.length;i++){
				if($(el).val() == medicacionDisabled[i]){
					$(el).attr("disabled","disabled");
				}
			}

		});
	});

	$(".cmbMedicamento ").each(function(a,r){
		for(var i =0;i<medicacionDisabled.length;i++){
			if(r.value == medicacionDisabled[i]){
				$("#"+r.id+" > option[value='"+medicacionDisabled[i]+"']").removeAttr("disabled");
			}
		}
	});

	$(".select").select2({
		placeholder: 'Seleccione una opción'
	});
}