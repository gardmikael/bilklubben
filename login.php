<?php 
	session_start();

	$errorMSG = $_SESSION['ERRMSG_ARR'];

?>

<!DOCTYPE html>
<html>
<head>
	<title>Bilklubben AS - Login</title>
	<!-- Settt viewport-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<!-- link til evt plugin stylesheet -->
	<link rel="stylesheet" type="text/css" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
	
	<!-- link til eget stylesheet -->
	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	
  	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link href='https://fonts.googleapis.com/css?family=Michroma' rel='stylesheet' type='text/css'>
	
</head>

<body>
	<div data-role="page" data-theme="a">
		<div data-role="header">
			<h1 class="header">Bilklubben AS</h1>
		</div>

		<div data-role="main" class="ui-content" id="login-form-container">
    		
    		<form action="exc/loginexc.php" method="POST" data-ajax="false">
				<label for="email">Epost</label>
				<input type="text" name="email" id="email" value="" data-clear-btn="true">
				<label for="password">Passord</label>
				<input type="password" data-clear-btn="true" name="password" id="password" value="">
				<div class="alert alert-danger" id="login_feedback" hidden>
  					<p ></p>	
				</div>
				<input type="submit" value="Log inn">
			</form>

  		</div>

	</div><!-- page -->

	<script type="text/javascript">
		$(document).ready(function() {
		<?php if(isset($_GET['err']) && $_GET['err'] == "1") { ?>
			$("#login_feedback").show().find('p').html("Brukernavn eller passord er feil");
			
		<?php } ?>
		});
	</script>
</body>

</html>