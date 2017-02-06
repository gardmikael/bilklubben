var leftPanel = '<div class="panel" data-role="panel" id="leftPanel" data-theme="a"><h2>Gå til</h2><ul data-role="listview" data-inset="false" class="ui-nodisc-icon ui-alt-icon"><li data-icon="home"><a data-ajax="false" href="main.php">Hjem</a></li><li><a data-ajax="false" href="cars.php">Våre biler</a></li><li data-icon="lock"><a data-ajax="false" href="./exc/logout.php">Logg ut</a></li></ul></div>';
var rightPanel = '<div class="panel" data-role="panel" id="rightPanel" data-theme="a" data-position="right"><p id="welcome">Velkommen,</p><ul data-role="listview" data-inset="false" class="ui-nodisc-icon ui-alt-icon"><li data-icon="user"><a data-ajax="false" href="profile.php">Profil</a></li><li data-icon="comment"><a data-ajax="false" href="yourcar.php">Dine biler</a></li></ul></div>';


$(document).one('pagebeforecreate', function () {
		    $.mobile.pageContainer.prepend(leftPanel);
		    $.mobile.pageContainer.prepend(rightPanel);
		    $("#leftPanel").panel().enhanceWithin();
		    $("#rightPanel").panel().enhanceWithin();
});

// Document load
$( document ).ready(function() {

	//Deal with swiping (for handheld devices)
	$( document ).on( "pageinit", "#demo-page", function() {
		$( document ).on( "swipeleft swiperight", "#demo-page", function( e ) {
	    // We check if there is no open panel on the page because otherwise
	    // a swipe to close the left panel would also open the right panel (and v.v.).
	    // We do this by checking the data that the framework stores on the page element (panel: open).
	    if ( $.mobile.activePage.jqmData( "panel" ) !== "open" ) {
	      if ( e.type === "swipeleft"  ) {
	        $( "#rightPanel" ).panel( "open" );
	      } else if ( e.type === "swiperight" ) {
	      	$( "#leftPanel" ).panel( "open" );
	      }
	    }
		});
	});

});
