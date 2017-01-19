<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<?php 
		require "Controller/listar.php";
	?>

	<ul id="lista">
		<?php foreach ($datos as $key => $value):?>
			<li><?= $value["fechaHoraDespacho"] ?> <small><?= $value["direccion"] ?></small></li>
		<?php endforeach; ?>
	</ul>

	<script language="javascript" src="js/jquery-1.12.0.min.js"></script>
	<script language="javascript" src="js/fancywebsocket.js"></script>
</body>
</html>