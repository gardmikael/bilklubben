<?php
	session_start();

    require_once('../inc/common_methods.php');

    $carID = $_POST["carID"];

    $user = getUser($_SESSION["userID"]);
    $car = getCar($carID);
    $date = $_POST["datepicker"];

    $userPoints = $user["points"];
    $carCost = $car["price"];

    if($userPoints >= $carCost){
		try{

			updatePoints($_SESSION["userID"], $carCost);
			rentCar($_SESSION["userID"], $carID, $date);

			header("location: ../yourcar.php");
	    	exit(); 
			exit;
		}catch (Exception $e){	

			$message = "DB-kobling feilet";
			echo json_encode(array('error'=>$message));
			exit;
		}

    }else{
    	echo "Du har for lite poeng";
    }


?>