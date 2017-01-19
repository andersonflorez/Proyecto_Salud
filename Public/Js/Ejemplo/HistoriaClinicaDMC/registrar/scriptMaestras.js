$(document).ready(function(){
    
    
	$("#Item1").hide();
	$("#Item2").hide();
	$("#Item3").hide();
	$("#Item4").hide();
	$("#Item6").hide();
	$("#Item7").hide();

	$("#I"+$(".nav-cont").children().eq(0).attr("id").substring(1)).show();

	$("#item1").click(function(){
		$("#Item1").show(400);
		$("#Item2").hide(200);
		$("#Item3").hide(200);
		$("#Item4").hide(200);
		$("#Item5").hide(200);
		$("#Item6").hide(200);
		$("#Item7").hide(200);
	});

	$("#item2").click(function(){
		$("#Item2").show(400);
		$("#Item1").hide(200);
		$("#Item3").hide(200);
		$("#Item4").hide(200);
		$("#Item5").hide(200);
		$("#Item6").hide(200);
		$("#Item7").hide(200);
	});

	$("#item3").click(function(){
		$("#Item3").show(400);
		$("#Item1").hide(200);
		$("#Item2").hide(200);
		$("#Item4").hide(200);
		$("#Item5").hide(200);
		$("#Item6").hide(200);
		$("#Item7").hide(200);
	});

	$("#item4").click(function(){
		$("#Item4").show(400);
		$("#Item1").hide(200);
		$("#Item2").hide(200);
		$("#Item3").hide(200);
		$("#Item5").hide(200);
		$("#Item6").hide(200);
		$("#Item7").hide(200);
	});

	$("#item5").click(function(){
		$("#Item5").show(400);
		$("#Item1").hide(200);
		$("#Item2").hide(200);
		$("#Item3").hide(200);
		$("#Item4").hide(200);
		$("#Item6").hide(200);
		$("#Item7").hide(200);
	});

	$("#item6").click(function(){
		$("#Item6").show(400);
		$("#Item1").hide(200);
		$("#Item2").hide(200);
		$("#Item3").hide(200);
		$("#Item4").hide(200);
		$("#Item5").hide(200);
		$("#Item7").hide(200);
	});

	$("#item7").click(function(){
		$("#Item7").show(400);
		$("#Item1").hide(200);
		$("#Item2").hide(200);
		$("#Item3").hide(200);
		$("#Item4").hide(200);
		$("#Item5").hide(200);
		$("#Item6").hide(200);
	});

	$("button.btn-status0").hover(function(){
			$(this).removeClass("btn-registrar");
			$(this).addClass("btn-eliminar");
			$(this).html('Inactivar');
			}, function(){
			$(this).removeClass("btn-eliminar");
			$(this).addClass("btn-registrar");
			$(this).html('Activo');
	});

	$("button.btn-status1").hover(function(){
		  $(this).removeClass("btn-eliminar");
		  $(this).addClass("btn-registrar");
		  $(this).html('Activar');
			}, function(){
		  $(this).removeClass("btn-registrar");
		  $(this).addClass("btn-eliminar");
		  $(this).html('Inactivo');
	});
    
    $("#cmbFiltroTipoAntecedente").change(function(){
		 var valor = $("#cmbFiltroTipoAntecedente").val();
		 if(valor != ""){
			 if(valor == "ID" || valor == "descripcion"){
				 $("#containerFiltroTipoAntecedente").html("<p>Filtro de búsqueda</p><input type='text' name='name'>");
				 $("#containerFiltroTipoAntecedente").fadeIn();
			 }else{
				 $("#containerFiltroTipoAntecedente").html("<p>Filtro de búsqueda</p><select><option value=''>Seleccione una opcion</option><option value='activo'>Activo</option><option value='inactivo'>Inactivo</option><option value='pendiente'>Pendiente</option></select>");
				 $("#containerFiltroTipoAntecedente").fadeIn();
			 }
		 }else{
			  $("#containerFiltroTipoAntecedente").html("");
				 $("#containerFiltroTipoAntecedente").fadeOut();
		 }
	 });
	
	$("#cmbFiltroTipoExamenFisico").change(function(){
		 var valor = $("#cmbFiltroTipoExamenFisico").val();
		 if(valor != ""){
			 if(valor == "ID" || valor == "descripcion"){
				 $("#containerFiltroTipoExamenFisico").html("<p>Filtro de búsqueda</p><input type='text' name='name'>");
				 $("#containerFiltroTipoExamenFisico").fadeIn();
			 }else{
				 $("#containerFiltroTipoExamenFisico").html("<p>Filtro de búsqueda</p><select><option value=''>Seleccione una opcion</option><option value='activo'>Activo</option><option value='inactivo'>Inactivo</option><option value='pendiente'>Pendiente</option></select>");
				 $("#containerFiltroTipoExamenFisico").fadeIn();
			 }
		 }else{
			  $("#containerFiltroTipoExamenFisico").html("");
				 $("#containerFiltroTipoExamenFisico").fadeOut();
		 }
	 });
	
	$("#cmbFiltroTipoOrigenAtencion").change(function(){
		 var valor = $("#cmbFiltroTipoOrigenAtencion").val();
		 if(valor != ""){
			 if(valor == "ID" || valor == "descripcion"){
				 $("#containerFiltroTipoOrigenAtencion").html("<p>Filtro de búsqueda</p><input type='text' name='name'>");
				 $("#containerFiltroTipoOrigenAtencion").fadeIn();
			 }else{
				 $("#containerFiltroTipoOrigenAtencion").html("<p>Filtro de búsqueda</p><select><option value=''>Seleccione una opcion</option><option value='activo'>Activo</option><option value='inactivo'>Inactivo</option><option value='pendiente'>Pendiente</option></select>");
				 $("#containerFiltroTipoOrigenAtencion").fadeIn();
			 }
		 }else{
			  $("#containerFiltroTipoOrigenAtencion").html("");
				 $("#containerFiltroTipoOrigenAtencion").fadeOut();
		 }
	 });
	$("#cmbFiltroTipoTratamiento").change(function(){
		 var valor = $("#cmbFiltroTipoTratamiento").val();
		 if(valor != ""){
			 if(valor == "ID" || valor == "descripcion"){
				 $("#containerFiltroTipoTratamiento").html("<p>Filtro de búsqueda</p><input type='text' name='name'>");
				 $("#containerFiltroTipoTratamiento").fadeIn();
			 }else if(valor=="categoria"){
				 $("#containerFiltroTipoTratamiento").html("<p>Filtro de búsqueda</p><select><option value=''>Seleccione una opcion</option><option value='activo'>Tratamiento basico</option><option value='inactivo'>Tratamiento avanzado</option></select>");
				 $("#containerFiltroTipoTratamiento").fadeIn();
			 }else{
				 $("#containerFiltroTipoTratamiento").html("<p>Filtro de búsqueda</p><select><option value=''>Seleccione una opcion</option><option value='activo'>Activo</option><option value='inactivo'>Inactivo</option><option value='pendiente'>Pendiente</option></select>");
				 $("#containerFiltroTipoTratamiento").fadeIn();
			 }
		 }else{
			  $("#containerFiltroTipoTratamiento").html("");
				 $("#containerFiltroTipoTratamiento").fadeOut();
		 }
	 });
  
	$("#cmbFiltroCup").change(function(){
		 var valor = $("#cmbFiltroCup").val();
		 if(valor != ""){
			 if(valor == "ID" || valor == "descripcion"){
				 $("#containerFiltroCup").html("<p>Filtro de búsqueda</p><input type='text' name='name'>");
				 $("#containerFiltroCup").fadeIn();
			 }else{
				 $("#containerFiltroCup").html("<p>Filtro de búsqueda</p><select><option value=''>Seleccione una opcion</option><option value='activo'>Activo</option><option value='inactivo'>Inactivo</option><option value='pendiente'>Pendiente</option></select>");
				 $("#containerFiltroCup").fadeIn();
			 }
		 }else{
			  $("#containerFiltroCup").html("");
				 $("#containerFiltroCup").fadeOut();
		 }
	});
	 
		
		$("#cmbFiltroCIE10").change(function(){
		 var valor = $("#cmbFiltroCIE10").val();
		 if(valor != ""){
			 if(valor == "ID" || valor == "descripcion"){
				 $("#containerFiltroCIE10").html("<p>Filtro de búsqueda</p><input type='text' name='name'>");
				 $("#containerFiltroCIE10").fadeIn();
			 }else{
				 $("#containerFiltroCIE10").html("<p>Filtro de búsqueda</p><select><option value=''>Seleccione una opcion</option><option value='activo'>Activo</option><option value='inactivo'>Inactivo</option><option value='pendiente'>Pendiente</option></select>");
				 $("#containerFiltroCIE10").fadeIn();
			 }
		 }else{
			  $("#containerFiltroCIE10").html("");
				 $("#containerFiltroCIE10").fadeOut();
		 }
	 });
	
	
    
    $("#cmbFiltro").change(function(){
        if($('#cmbFiltro').val() == "codigoCup"){
            $("#campo").append('<div style="display:flex;"> <input type="text" id="codigoCup"> <button type="button" id="ConsultarCod" name="button" class="btn btn-consultar">buscar</button></div>');
        }else{
            $("#campo").find("input[id='codigoCup']").remove();
            $("#campo").find("button[id='ConsultarCod']").remove();
            
        }if($('#cmbFiltro').val() == "idConfiguración"){
            $("#campo").append(' <div style="display:flex;"> <input type="number" id="idConfiguracion"> <button type="button" id="ConsultaridConfi" name="button" class="btn btn-consultar">buscar</button></div>');
        }else{
            $("#campo").find("input[id='idConfiguracion']").remove();
            $("#campo").find("button[id='ConsultaridConfi']").remove();
            
        }if($("#cmbFiltro").val() == "idTipoCUP"){
            $("#campo").append('<div style="display:flex;"> <input type="number" id="idTipoCup"> <button type="button" id="ConsultaridTipoC" name="button" class="btn btn-consultar">buscar</button></div>')
        }else{
            $("#campo").find("input[id='idTipoCup']").remove();
            $("#campo").find("button[id='ConsultaridTipoC']").remove();
            
        }if($("#cmbFiltro").val() == "NombreCUP"){
           $("#campo").append('<div style="display:flex;"> <input type="text" id="NombreCup"> <button type="button" id="ConsultarNombreCup" name="button" class="btn btn-consultar">buscar</button></div>')
        }else{
            $("#campo").find("input[id='NombreCup']").remove();
            $("#campo").find("button[id='ConsultarNombreCup']").remove();
        }
        
                       
    });
       
      
    
    
    
});


 


