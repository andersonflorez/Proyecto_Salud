$(document).ready(function(){
	validarCuenta();
})

function validarCuenta() {

	var usuario = ('#txtUsuario').val();
	var clave = ('#txtClave').val();

	$.ajax({
		type: 'POST',
		dataType: 'JSON',
		url: url+"Home/ctrlLogin/MostrarDatos",
		data: {'txtUsuario': usuario, 'txtClave': clave}
	}).done(function(data){

//		console.log(data);
		
		$.each(function(indice, valor){
			var nombre = valor.primerNombre;
			$('#nombre').val(nombre);
		});

	});

}
