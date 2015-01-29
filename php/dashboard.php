<?php 
/** 
*	@project: Werkstück-Management CHIRON-WERKE GmbH & Co. KG
*	@author: Alexander Hipp
*	@date: 01.04.2012
*/

include("base.php");?>


<div id="page">
	<div id="heading"></div>
    
    <?php 
		// Hier wird geprüft ob schon eine Anmeldung erfolgt ist
		if (!isset($_SESSION['ben_id']) OR ($_SESSION['rolle'] != 1)) {
			?>
			<div id="box_anmelden" style="margin-top:10px;">Bitte zuerst <a href="index.php" style="text-decoration:underline;">anmelden</a></div><?php
			exit();
		} else { 
	?>
    <div id="navi">
		<?php include("flags.php");?>
          <?php include("navi.php");?>
    </div>

    <div id="main">
    
    	<?php
				
				//Hier wird die Sprache übergeben 
				$la = $_SESSION['la']; 
			?>
    
    	  <!--Überschrift im grauen Kasten-->
          <div id="pagehead"><span>dashboard</span></div>
          <!--<div id="left">-->
              
              <div id="box">
              	<h1><a href="search.php" target="_self"><?php if ($la == en) {echo 'search';} else {echo 'suchen';} ?></a></h1>
               <!-- Hier kann nach Werkstücken gesucht werden-->
              </div>
              
      
              
              <div id="box">
              	<h1><a href="entnahme.php" target="_self"><?php if ($la == en) {echo 'pick list';} else {echo 'entnahmelisten';} ?></a></h1>
              	<!--Hier bekommen Sie eine Übersicht aller Entnahmelisten-->
              </div>
              
              <div id="box">
              
              <h1><a href="app_all.php" target="_self"><?php if ($la == en) {echo 'applications sheets';} else {echo 'applikationsbl&auml;tter';} ?></a></h1>
              	<!--Übersicht der unvollständigen Application Sheets-->
              </div>
              
              <div id="box">
              	<h1><a href="user_all.php" target="_self"><?php if ($la == en) {echo 'user';} else {echo 'benutzer';} ?></a></h1>
              	<!--Übersicht, Benutzer anlegen  -->
              </div>
              
              <!--Hier könnte man eine Pinnwand machen, die die letzten Aktionen für einen Admin ausgibt-->
              
          <!--</div>
          <div id="right">
	          <div id="box_comment"><h1>Allgemeine Kommentare</h1></div>
          </div>-->      
         <?php 
	// ENDE IF SESSION
	}
?> 
    </div>	
</div>