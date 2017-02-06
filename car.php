<?php 
    session_start();

    require_once('inc/common_methods.php');
    checkAccess();

	$carID = $_GET["carID"];
    $car = getCar($carID);
    $user = getUser($_SESSION["userID"]);
    $position = getCarPosition($carID);
    $datesForThisCar = datesWhenCarIsLeased($carID);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Bilklubben AS - Hjem</title>
        <!-- Set viewport & charset -->
        <meta name="viewport" content="initial-scale=1.0" charset="utf-8"/>
        <!-- External stylesheets-->
        <link rel="stylesheet" type="text/css" href="https://necolas.github.io/normalize.css/3.0.2/normalize.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">

        <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="css/jquery-ui.structure.min.css">
        <link rel="stylesheet" type="text/css" href="css/jquery-ui.theme.min.css">
        <link rel="stylesheet" type="text/css" href="css/tk.min.css">
       
        
        <!-- Fonts, etc-->
        <link href='https://fonts.googleapis.com/css?family=Michroma' rel='stylesheet' type='text/css'>
        <!-- My stylesheet -->
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/car_style.css">
        
        <!-- jQuery, jQueryMobile -->
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

        <!-- My js -->
        <script src="js/common.js"></script>
        
    </head>
    
    <body>
        <div data-role="page" data-theme="a" class="page-wrapper">
            <div data-role="header">
                <h1 class="header">Bilklubben AS</h1>
                <a href="#leftPanel" class="ui-icon ui-alt-icon ui-nodisc-icon transparent" data-iconpos="notext" data-iconshadow="false" data-icon="bars"></a>
                <a href="#rightPanel" class="ui-icon ui-alt-icon ui-nodisc-icon transparent" data-iconpos="notext" data-iconshadow="false" data-icon="user"></a>
            </div>

            <div data-role="main" class="ui-content-main my-main-content">   
                <h1 class="page-title-header"><?php echo $car["name"]; ?></h1>
                <div class="ui-grid-b">
                    <img class="ui-block-a" src="<?php echo $car["img_path"];?>">
                    <div class="ui-block-b">
                    <p><?php echo $car["description"];?></p>
                    </div>

                    <div class="ui-block-c">
                        <div class="rent-container">
                            <form onsubmit="return validate();" method="POST" data-ajax="false" action="exc/rentCar_exc.php">
                                <label class="datelabel" for="datepicker">Velg dato</label>
                                <input id="datepicker" readonly='true' name="datepicker" type="text" data-role="date" data-inline="true">
                                <input class="btn disabled-btn" id="rentCar-btn" type="submit" value="<?php echo $car['price'] . ' poeng' ; ?>">
                                <p>Dine poeng: <b><?php echo $user["points"]; ?></b></p>
                                <input type="hidden" name="carID" value="<?php echo $carID; ?>">
                            </form>
                        </div>
                    </div>
                </div>


                <div data-role="collapsibleset" data-theme="a" data-content-theme="a">
                <?php
                        echo '<div data-role="collapsible" data-collapsed-icon="gear" data-expanded-icon="delete" id="showMap">';
                        echo '<h3>Vis på kart</h3>';
                        echo '<div id="map"></div>';
                        echo '</div>';

                        echo "<h2>Tekniske detaljer</h2>";
                        echo '<div class="container">';
                        echo '<p><b>Bilmerke:</b> ' .  $car["brand"] . '</p>';
                        echo '<p><b>Model:</b> ' .  $car["model"] . '</p>';
                        echo '<p><b>Antall seter:</b> ' .  $car["seats"] . '</p>';
                        $auto = "Ja";
                        if($car["manual"] == 0){
                            $auto = "Nei";
                        }
                        echo '<p><b>Manuelt gir:</b> ' . $auto . '</p>';
                        
                        echo '</div>';
                ?>
                    
                </div>
                

            </div><!-- main -->

        </div><!-- page -->
        
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQrF_F7_BlmmELPgiAbUXi-VGv-af6jSM&callback=initMap"
  type="text/javascript"></script>
        <script type="text/javascript">
            function validate(){
                var yourPoints = <?php echo $user["points"]; ?> ;
                var cost = <?php echo $car['price']; ?>;
                if(yourPoints < cost){
                    alert("Du har ikke nok poeng for å leie denne bilen");
                    return false;
                }else{
                    if(confirm("Er du sikker på at du vil leie denne bilen?")){
                        return true;    
                    }else{
                        return false;    
                    }
                }
                return false;
            }


            <?php 
                $lat = floatval($position["lat"]);
                $long = floatval($position["long"]);
            ?>
            var uluru = {lat: <?php echo $lat; ?>, lng: <?php echo $long; ?>};
            var map = null, marker = null;

            var unavailabledates = <?php echo json_encode($datesForThisCar); ?>;

            function initMap() {
                var map = new google.maps.Map(document.getElementById('map'), {
                      zoom: 16,
                      center: uluru
                });

                    var marker = new google.maps.Marker({
                      position: uluru,
                      map: map
                    });
            }   

        $(document).ready(function(){
            $("#welcome").append(" <?php echo $_SESSION['name'];?>");
            $("#rentCar-btn").prop("disabled", true);

            $('#showMap').bind('collapsibleexpand', function () {
            initMap();
            });

            $( "#datepicker" ).datepicker({
                minDate: 0,
                dateFormat: 'yy-mm-dd',
                beforeShowDay: function(date){
                   var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                    return [ unavailabledates.indexOf(string) == -1 ]
                },
                onSelect: function(){
                    <?php
                    if($user["points"] >= $car["price"]){
                    ?> 
                    $("#rentCar-btn").prop("disabled", false);
                    $("#rentCar-btn").removeClass("disabled-btn");
                    $("#rentCar-btn").addClass("blue-btn");
                    <?php
                    }
                    ?>
                }

            });    
            
        });
        
        </script>
    </body>
</html>
