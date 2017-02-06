<?php

session_start();

require_once('../inc/database.php'); //=>link to the .php file containing your connection to the database


//Sanitize the POST values
$input_email = strtolower(trim($_POST['email']));
$input_password = trim($_POST['password']);


// Retrieve the user that match the email variable from the input form
try {
  	$qry = "SELECT * FROM bilk_users WHERE email = :email";
	$query = $db->prepare($qry);
	$query->bindParam(":email", $input_email);
	$query->execute();
	$result = $query->fetchAll();
	
	if(!empty($result)){
		if($input_password == $result[0]['password']){
			
			$_SESSION['userID'] = $result[0]['id'];
			$_SESSION['name'] = $result[0]['firstname'];
      		header("location: ../main.php");
	    	exit(); 
		}else{
			//epost fins, men passord er feil
			header("location: ../login.php?err=1");
			exit();
		}

	}else{
		//epost fins ikke
		$errmsg = 'Youre not a registered user';
		$errflag = true;
		if($errflag) {
			$_SESSION['ERRMSG_ARR'] = $errmsg;
			//session_write_close();
			header("location: ../login.php?err=1");
			exit();
		}
	}

}
//catch exception
catch(Exception $e) {
	//Exception handling
	echo 'Message: ' .$e->getMessage();
}


/*


if (empty($result)){
	//eposten er ikke registret i db 
	$_SESSION['ERRMSG_ARR'] = "User dont exist";
	session_write_close();
	header("location: ../login.php?err=2");
	exit();
}

$db_id = $result[0][0];
$db_email = $result[0][1];
$db_password = $result[0][2];
$db_name = $result[0][3];

//Check whether the query was successful or not
if(count($result) > 0) {
	if($input_password == $db_password) {
		//Login Successful
		session_regenerate_id();

		$_SESSION['user_id'] = $db_id;
		$_SESSION['email'] = $db_email;
		$_SESSION['name'] = $db_name;
		
		session_write_close();
		header("location: ../login.php?navn=" . $db_name);
		exit();
	}else {
		//Login failed
		$errmsg_arr[] = 'username or password not found';
		$errflag = true;
		if($errflag) {
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			session_write_close();
			header("location: ../login.php?err=3");
			exit();
		}
	}
}else {
	$errmsg_arr[] = 'username or password not found';
	$errflag = true;
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: ../login.php");
		exit();
		}
}


header("location: ../login.php");
exit();
*/
?>