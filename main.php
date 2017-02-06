<?php 
    session_start();

    require_once('inc/common_methods.php');
    checkAccess();

	$navn = $_SESSION["name"];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Bilklubben AS - Hjem</title>
        <!-- Set viewport & charset -->
        <meta name="viewport" content="initial-scale=1.0" charset="utf-8"/>
        <!-- External stylesheets-->
        <link rel="stylesheet" type="text/css" href="https://necolas.github.io/normalize.css/3.0.2/normalize.css">
        <link rel="stylesheet" type="text/css" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
        <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="css/jquery-ui.structure.min.css">
        <link rel="stylesheet" type="text/css" href="css/jquery-ui.theme.min.css">
        
        <!-- Fonts, etc-->
        <link href='https://fonts.googleapis.com/css?family=Michroma' rel='stylesheet' type='text/css'>
        <!-- My stylesheet -->
        <link rel="stylesheet" type="text/css" href="css/style.css">
        
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
                <h1 class="header">Bilkblubben AS</h1>
                <a href="#leftPanel" class="ui-icon ui-nodisc-icon transparent" data-iconpos="notext" data-iconshadow="false" data-icon="bars"></a>
                <a href="#rightPanel" class="ui-icon ui-nodisc-icon transparent" data-iconpos="notext" data-iconshadow="false" data-icon="user"></a>
            </div>

            <div data-role="main" class="ui-content main">   
            
                <h1 class="page-title-header">Nyheter</h1>
                <div class="news-section">
                <?php 
                    $allNews = getAllNews();
                    foreach ($allNews as $news) {
                        echo '<h1>' . $news["title"] . '</h1>';
                        echo '<h2>' . $news["date"] . '</h2>';
                        echo '<p>' . $news["news_text"] . '</p>';
                    }
                ?>
                </div>
            </div><!-- main -->

        </div><!-- page -->
        
        <script type="text/javascript">
        $(document).ready(function(){
            $("#welcome").append("<?php echo $navn; ?>");
        });
        </script>
    </body>
</html>
