<?php
session_start();
include('inc/common_methods.php');

	
    $user = getUser($_SESSION['userID']);
    $invoices = getInvoices($_SESSION['userID']);

?>
<!DOCTYPE html>
<html>
<head>
		<title>Trondheim kino vaktweb - profil</title>
		<!-- Settt viewport & charset-->
		<meta name="viewport" content="initial-scale=1.0" charset="utf-8">
		<!-- External stylesheets-->
		<link rel="stylesheet" type="text/css" href="https://necolas.github.io/normalize.css/3.0.2/normalize.css">
		<link rel="stylesheet" type="text/css" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">
		
		<!-- Fonts, etc-->
		<link href='https://fonts.googleapis.com/css?family=Michroma' rel='stylesheet' type='text/css'>
		<!-- My stylesheet -->
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/profile.css">
		
		<!-- jQuery, jQueryMobile -->
		<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
		<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<!-- My js -->
		<script src="js/common.js"></script>
</head>
<body>

	<div data-role="page" data-theme="a" id="demo-page">

		<div data-role="header">
			<h1 class="header">Bilklubben AS</h1>
			<a href="#leftPanel" class="ui-icon ui-nodisc-icon transparent" data-iconpos="notext" data-iconshadow="false" data-icon="bars"></a>
			<a href="#rightPanel" class="ui-icon ui-nodisc-icon transparent" data-iconpos="notext" data-iconshadow="false" data-icon="user"></a>
		</div>


		<div data-role="main" class="ui-content main">	 

			<h1 class="page-title-header">Din profil</h1>
			<div class="container">
	 	 		<p><b>Fornavn:</b> <?php echo $user["firstname"];?></p>
	 	 		<p><b>Etternavn:</b> <?php echo $user["lastname"];?></p>
	 	 		<p><b>Adresse:</b> <?php echo $user["address"];?></p>
	 	 		<p><b>Poeng:</b> <?php echo $user["points"];?></p>
			</div>
			<div class="container">
			<h2>Dine faktura</h1>
			<table >
				<tr style="background-color:#aaa;color:#000;">
				<th>Fakturaid</th><th>Dato</th><th>Status</th><th>Beløp</th><th class=alignleft>Last ned</th></tr>
				<?php 
				foreach ($invoices as $invoice) {
					$status = "Ikke betalt";
					if($invoice["invoice_id"] == 1){
						$status = "Betalt";
					}
					echo '<tr><td>' . $invoice["invoice_id"] .'</td><td>' . $invoice["date"] .  '</td><td>' . $status. '</td><td>' . $invoice["price"] .  '</td><td><a href="$">pdf</a></tr>';
				}
				?>	
			</table>
			</div>
  		</div><!-- main -->

	</div><!-- page -->

	<script type="text/javascript">
	$(document).ready(function(){
		$("#welcome").append(" <?php echo $_SESSION['name'];?>");
	});

	</script>
</body>

</html>
