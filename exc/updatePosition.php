<?php

require_once('../inc/common_methods.php');
$lng = $_POST['lng'];
$lat = $_POST['lat'];
$car_id = $_POST["car_id"];

$message;

try{
	require_once('../inc/database.php');

	$query = $db->prepare("UPDATE bilk_car_position SET lat = :lat, `long` = :long WHERE car_id = :car_id");
	$query->bindParam(":lat", $lat);
	$query->bindParam(":long", $lng);
	$query->bindParam(":car_id", $car_id);

	$query->execute();
	$message = "Rad innsatt";
	echo json_encode(array('success'=>$message));
	exit;
}catch (Exception $e){	

	$message = "DB-kobling feilet";
	echo json_encode(array('error'=>$message));
	exit;
}


?>