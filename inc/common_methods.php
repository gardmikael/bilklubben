<?php

function checkAccess() {
  if(!isset($_SESSION['userID']))
  {
	    session_write_close();
      header("location: login.php");
	    exit();
  } 
}

function getAllCars(){
	require('database.php');
  	$query = $db->prepare("SELECT * FROM bilk_cars");
  	$query->execute();
  	$rows = $query->fetchAll();
	return $rows;
}

function getCar($carID){
  require('database.php');
    $query = $db->prepare("SELECT * FROM bilk_cars WHERE id = :carID");
    $query->bindParam(":carID", $carID);
    $query->execute();
    $rows = $query->fetch();
    return $rows;
}

function getCarPosition($carID){
    require('database.php');
    $query = $db->prepare("SELECT * FROM bilk_car_position WHERE car_id = :carID");
    $query->bindParam(":carID", $carID);
    $query->execute();
    $rows = $query->fetch();
    return $rows;
}


function getUser($userID){
  require('database.php');
    $query = $db->prepare("SELECT * FROM bilk_users WHERE id = :userID");
    $query->bindParam(":userID", $userID);
    $query->execute();
    $rows = $query->fetch();
    return $rows;
}

function getInvoices($userID){
  require('database.php');
    $query = $db->prepare("SELECT * FROM bilk_invoice WHERE user_id = :userID");
    $query->bindParam(":userID", $userID);
    $query->execute();
    $rows = $query->fetchAll();
    return $rows;
}

function datesWhenCarIsLeased($carID){
  require('database.php');
    $query = $db->prepare("SELECT date FROM bilk_cars_leased WHERE car_id = :carID");
    $query->bindParam(":carID", $carID);
    $query->execute();
    $rows = $query->fetchAll(PDO::FETCH_COLUMN, 0);
    return $rows;
}

function getMyCars($userID){
  require('database.php');
    $query = $db->prepare("SELECT * FROM bilk_cars_leased WHERE user_id = :userID");
    $query->bindParam(":userID", $userID);
    $query->execute();
    $rows = $query->fetchAll();
    return $rows;
}

function getAllNews(){
  require('database.php');
    $query = $db->prepare("SELECT * FROM bilk_news ORDER BY date DESC");
    $query->execute();
    $rows = $query->fetchAll();
    return $rows;
}

function updatePoints($userID, $pointsSpent){
  require('database.php');
    $query = $db->prepare("UPDATE bilk_users SET points = points - :points_spent WHERE id = :user_id");
    $query->bindParam(":user_id", $userID);
    $query->bindParam(":points_spent", $pointsSpent);
    $query->execute();
    return true;
}

function rentCar($userID, $carID, $date){
  require('database.php');
    $query = $db->prepare("INSERT INTO bilk_cars_leased (car_id, user_id, `date`) VALUES (:car_id, :user_id, :dato)");
    $query->bindParam(":car_id", $carID);
    $query->bindParam(":user_id", $userID);
    $query->bindParam(":dato", $date);
    $query->execute();
    return true;
}


?>
