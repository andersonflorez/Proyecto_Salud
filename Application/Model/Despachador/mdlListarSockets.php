<?php 

	require "Library/DataBase.php";

	$conex= new DataBase();
	$conex->dbconect("localhost","root","1234","sprint");
	$db = $conex->getCon();

	$q = "SELECT * FROM tbl_despacho";
	$res = $db->prepare($q);
	$res->execute();

	$datos = $res->fetchAll();

 ?>