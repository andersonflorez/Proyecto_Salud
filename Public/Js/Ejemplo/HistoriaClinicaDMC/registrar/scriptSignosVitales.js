$(document).ready(function(){
    
    $("#txtSignoVital0-1").datetimepicker({ 
		datepicker:false,
		format:'H:i'
	});
    
   
	ValidateForm('frmSignosVitales', function(formData){
		var registros = [];

		for(var i=1;i<=8;i++){
			for(var j=1;j<=4;j++){
				registros.push({hora:$("#txtSignoVital0-"+j).val(),idValoracion: btoa(i),resultado:$("#txtSignoVital"+i+"-"+j).val()});
			}
		}
		localStorage.setItem("signosVitales",btoa(JSON.stringify(registros)));
		window.location = url+"HistoriaClinicaDMC/ctrlRegistrarProcedimientoDiagnostico/index/"+idPaciente+"/"+idCita+"/"+idCitaProgramacion;
	});

	
	$("#txtSignoVital0-2").datetimepicker({ 
		datepicker:false,
		format:'H:i'       
	});
	$("#txtSignoVital0-3").datetimepicker({ 
		datepicker:false,
		format:'H:i'       
	});
	$("#txtSignoVital0-4").datetimepicker({ 
		datepicker:false,
		format:'H:i'       
	});


	if(localStorage.getItem("signosVitales") != null){
		var registrosSignosVitales = JSON.parse(atob(localStorage.getItem("signosVitales")));
		for(var j=0;j<4;j++){
			$("#txtSignoVital0-"+(j+1)).val(registrosSignosVitales[j].hora);
		}
		var h = 0;
		for(var i=1;i<=8;i++){
			for(var j=1;j<=4;j++){
				$("#txtSignoVital"+i+"-"+j).val(registrosSignosVitales[h].resultado);
				h++;
			}
		}
	}

});