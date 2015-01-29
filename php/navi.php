<?php 
/** 
*	@project: Werkstück-Management CHIRON-WERKE GmbH & Co. KG
*	@author: Alexander Hipp
*	@date: 01.04.2012
*/

include("base.php");?>

<?php 
	// Hier wird die Sprache übergeben 
	$la = $_SESSION['la'];
?>
<div id="navi_list">
    
        <div id="nav_box"><a href="logout.php" target="_self">logout</a></div> 
        <div id="nav_box"><a href="#" onclick="history.go(-1)"><?php if ($la == en) {echo 'back';} else {echo 'zur&uuml;ck';} ?></a></div>
        <?php
           // Administrator
            if($_SESSION['rolle'] == "1") {
                ?><div id="nav_box"><a href="dashboard.php" target="_self">dashboard</a></div><?php
            }
            
            // Hauptnutzer
            if($_SESSION['rolle'] == "2") {
                ?>
                    <div id="nav_box"><a href="entnahme.php" target="_self"><?php if ($la == en) {echo 'pick list';} else {echo 'entnahmelisten';} ?></a></div>
                    <div id="nav_box"><a href="search.php" target="_self"><?php if ($la == en) {echo 'search';} else {echo 'suche';} ?></a></div>
                <?php
            }
            
            // App-Benutzer
            if($_SESSION['rolle'] == "3") {
                ?>
                    <div id="nav_box"><a href="app_all.php" target="_self"><?php if ($la == en) {echo 'application sheets';} else {echo 'Applikationsblätter';} ?></a></div>
                    <div id="nav_box"><a href="search.php" target="_self"><?php if ($la == en) {echo 'search';} else {echo 'suche';} ?></a></div>
                <?php
            }
        ?>
</div>