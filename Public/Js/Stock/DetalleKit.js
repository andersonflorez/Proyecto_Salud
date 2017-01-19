$(document).ready(function(){
listarComboRecursokit();
listarComboRecurso();
 //ValidateForm('formRecursosAsignacion');
});

function listarComboCantidadRecurso(i){
	var a=$("#slcidrecurso"+i).val();
$.ajax({
	type:'POST',
	dataType:'JSON',
	url:url+"Stock/ctrlregistroAsignacion/listarComboCantidadRecurso",
	data:{"idrecurso":a}
}).done(function(r){
	let cantidad =r[0].stockminKit;
	$("#txtcantidadAsignada"+i).val(cantidad)

}).fail(function(r) {
	//console.log('fail');
});

}

function listarComboRecurso(){
$.ajax({
	type:'POST',
	dataType:'JSON',
	url:url+"Stock/ctrlregistroAsignacion/listarComboRecurso",
	data:{"":""},
	async: false
}).done(function(p){
	$.each(p,function( j, s){
		
		//console.log(p);
		$('#slcidrecurso0').append("<option value='"+s.idrecurso+"'>"+s.nombre+"</option>");
	});
	 
}).fail(function(p) {
	//console.log('fail');
});

}

function listaCompletaRecursoEstandar(){
	$.ajax({
		dataType:"JSON",
	    url:url+"Stock/ctrlregistroAsignacion/listaCompletaRecursoEstandar"
  }).done(function(data){
  	$("#data_resource").fadeOut(function(){
  		$('#containerTabla').fadeIn();
  	});
  	     $('#containerTabla').html("<h5>Recursos estandar</h5>");

  	    var Contenido = "<div class='n_flex_col10id' id='tbl_ejemplo'><table class='tbl_responsive'>"
  	     +"<thead id='RegistrarEstandar'>"
         +"<tr>"
  	     +"<th>id Estandar kit</th><th>Recurso Kit</th><th>stock minimo Kit</th>"
         +"</tr>";
  	     +"</thead>"
  	     +"<tbody>";
  	     
        $.each(data,function(i,e){
         Contenido+="<tr>"
         +"<td>"+e.idEstandarKit+"</td><td>"+e.nombre+"</td><td>"+e.stockminKit+"</td>"
         +"</tr>";
        	//Contenido = "<input type='text' value="e.recursoKit"/>";
	    });
	   Contenido+="</tbody>"
	    +"</table></div>";
	    console.log(Contenido);
        $('#containerTabla').append(Contenido);
  }).fail(function(d) {
    console.log('fail');
  });
}
 
 function LLamarTablaPrestamo(){

 	 	$('#containerTabla').fadeOut(function(){
  		$("#data_resource").fadeIn();
  	});
  	    
 }



function listarComboRecursokit(){
$.ajax({
	type:'POST',
	dataType:'JSON',
	url:url+"Stock/ctrlregistroAsignacion/listarComboRecursokit",
	data:{"":""},
	async: false
}).done(function(d){
	$.each(d,function( f, g){
		//console.log(d);
		$('#slcidrecurso').append("<option value='"+g.idrecurso+"'>"+g.cantidadRecurso+"</option>");
	});
	 
}).fail(function(d) {
	//console.log('fail');
});

}

