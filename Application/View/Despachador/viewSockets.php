<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<input type="text" name="direccion" id="direccion" >
	<br />
	<input type="button" value="enviar" onclick="insertar();" >

	<script language="javascript" src="js/jquery-1.12.0.min.js"></script>
	<script language="javascript" src="js/fancywebsocket.js"></script>
	<script language="javascript">
		function insertar()
		{	
			$.ajax({
				type: "POST",
				url: "Controller/guardar.php",
				data: {direccion:$("#direccion").val()},
				dataType:"html"
			}).done(function(data){
				send(data);
			});
		}
	</script>
</body>
</html>
