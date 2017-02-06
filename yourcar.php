<?php 
    session_start();

    require_once('inc/common_methods.php');
    checkAccess();
    
    $myCars = getMyCars($_SESSION["userID"]);
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
                
                <h1 class="page-title-header">Din bil</h1>
                <?php 
                $myCar;
                $carFlag = false;
                foreach ($myCars as $car) {
                    if($car['date'] == date("Y-m-d") ) {
                        $carFlag = true;
                        $myCar = $car;
                    }
                }
                ?>
                <p><?php if($carFlag){ 
                    //Hvis du har bil i dag
                    $car = getCar($myCar["car_id"]);
                    $position = getCarPosition($myCar["car_id"]);
                    
                    echo '<p>Du låner for tiden vår ' . $car["name"] . '</p>';
                    echo '<img class="img" src="' . $car["img_path"] . '">';
                ?>    
                    <div data-role="collapsibleset" data-theme="a" data-content-theme="a">
                <?php
                        echo '<div data-role="collapsible" data-collapsed-icon="gear" data-expanded-icon="delete" id="showMap">';
                        echo '<h3>Oppdater bilens posisjon</h3>';
                        echo '<div id="map"></div>';
                        echo '<div id="updatePos" class="btn green-btn">Oppdater posisjon</div';
                        echo '</div>';

                ?>
                </div>
                <?php
                }else{ echo "Du leier ingen bil av oss i dag.";
                        if(isset($myCars)){
                            echo " Men du har reservert noen biler på et senere tidspunkt. Kom tilbake da. ";
                        }
                        echo "Se vårt utvalg av <a href='cars.php'>biler</a> for å leie bil.";
                    
                    } ?></p>
                
                

            </div><!-- main -->
            
        </div><!-- page -->
                <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQrF_F7_BlmmELPgiAbUXi-VGv-af6jSM&callback=initMap"
  type="text/javascript"></script>
        <script type="text/javascript">
            <?php 
                $lat = floatval($position["lat"]);
                $long = floatval($position["long"]);
            ?>
            var uluru = {lat: <?php echo $lat; ?>, lng: <?php echo $long; ?>};
            var map = null, marker = null;
            var newLat, newLong;

            function initMap() {
                var map = new google.maps.Map(document.getElementById('map'), {
                      zoom: 16,
                      center: uluru
                });

                    var marker = new google.maps.Marker({
                      position: uluru,
                      map: map,
                      draggable: true
                    });
                google.maps.event.addListener(marker, 'dragend', function (event) {
                    newLat = this.getPosition().lat();
                    newLong = this.getPosition().lng();
                });
            }  

        $(document).ready(function(){
            $("#welcome").append(" <?php echo $_SESSION['name'];?>");
            
            $('#showMap').bind('collapsibleexpand', function () {
                initMap();
            });
            $('#updatePos').on("click", function(){
                

                $.ajax({
                    type: "POST",
                    url: "exc/updatePosition.php",
                    data: {
                        lat: newLat, 
                        lng: newLong, 
                        car_id: <?php echo $myCar["car_id"]; ?>
                    },
                    dataType: "json", 
                    beforeSend: function(xhr){
                        //send før mld
                        console.log("skal vi se...");
                    },
                    error: function(qXHR, textStatus, errorThrow){
                        console.log("det gikk ikke");
                        console.log(errorThrow);
                    },
                    success: function(data, textStatus, jqXHR){
                        console.log("det gikk fint");
                        console.log(data);
                        alert("Poisjon oppdatert!");
                    }

                });
            });



        });//end document ready
        </script>
    </body>
</html>
