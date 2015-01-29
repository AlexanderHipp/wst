<?php 
/** 
*	@project: Werkstück-Management CHIRON-WERKE GmbH & Co. KG
*	@author: Alexander Hipp
*	@date: 01.04.2012
*/

 // Hier wird die Sprache übergeben 
$la = $_SESSION['la']; 
				
				
	// Auswahl welche Piktogrammer angezeigt werden sollen
	//Branche
	if ($zeile_wst['branche'] == 201) {
		echo '<img style="float:left;" src="../img/picto/meg_201.png" width="32" height="32" />';
	}
	
	
	if ($zeile_wst['branche'] == 202) {
		echo '<img style="float:left;" src="../img/picto/meg_202.png" width="32" height="32" />';
	}
	if ($zeile_wst['branche'] == 20201) {
		echo '<img style="float:left;" src="../img/picto/meg_202.png" width="32" height="32" />';
		?><div id="branche_zusatz"><?php if ($la == en) {echo 'Transmission & Drive Train';} else {echo 'Antriebsstrang';}?></div><?php
	}
	if ($zeile_wst['branche'] == 20202) {
		echo '<img style="float:left;" src="../img/picto/meg_202.png" width="32" height="32" />';
		?><div id="branche_zusatz"><?php if ($la == en) {echo 'Braking Systems';} else {echo 'Bremssysteme';}?></div><?php
	}
	if ($zeile_wst['branche'] == 20203) {
		echo '<img style="float:left;" src="../img/picto/meg_202.png" width="32" height="32" />';
		?><div id="branche_zusatz"><?php if ($la == en) {echo 'Air Condition & Ventilation Systems';} else {echo 'Klima- & L&uuml;ftungssysteme';}?></div><?php
	}
	if ($zeile_wst['branche'] == 20204) {
		echo '<img style="float:left;" src="../img/picto/meg_202.png" width="32" height="32" />';
		?><div id="branche_zusatz"><?php if ($la == en) {echo 'Fuel systems';} else {echo 'Kraftstoffsysteme';}?></div><?php
	}
	if ($zeile_wst['branche'] == 20205) {
		echo '<img style="float:left;" src="../img/picto/meg_202.png" width="32" height="32" />';
		?><div id="branche_zusatz"><?php if ($la == en) {echo 'Exhaust Systems';} else {echo 'Abgassysteme';}?></div><?php
	}
	if ($zeile_wst['branche'] == 20206) {
		echo '<img style="float:left;" src="../img/picto/meg_202.png" width="32" height="32" />';
		?><div id="branche_zusatz"><?php if ($la == en) {echo 'Wheels';} else {echo 'Felgen';}?></div><?php
	}
	if ($zeile_wst['branche'] == 20207) {
		echo '<img style="float:left;" src="../img/picto/meg_202.png" width="32" height="32" />';
		?><div id="branche_zusatz"><?php if ($la == en) {echo 'Engine Components';} else {echo 'Motor & Aggregate';}?></div><?php
	}
	if ($zeile_wst['branche'] == 20208) {
		echo '<img style="float:left;" src="../img/picto/meg_202.png" width="32" height="32" />';
		?><div id="branche_zusatz"><?php if ($la == en) {echo 'Steering & Suspension Systems';} else {echo 'Lenk- & Fahrwerke';}?></div><?php
	}
	if ($zeile_wst['branche'] == 20209) {
		echo '<img style="float:left;" src="../img/picto/meg_202.png" width="32" height="32" />';
		?><div id="branche_zusatz"><?php if ($la == en) {echo 'Body Components';} else {echo 'Karosserieteile';}?></div><?php
	}
	
	
	if ($zeile_wst['branche'] == 203) {
		echo '<img src="../img/picto/meg_203.png" width="32" height="32" />';
	}
	
	
	if ($zeile_wst['branche'] == 204) {
		echo '<img style="float:left;" src="../img/picto/meg_204.png" width="32" height="32" />';
	}
	if ($zeile_wst['branche'] == 20401) {
		echo '<img style="float:left;" src="../img/picto/meg_204.png" width="32" height="32" />';
		?><div id="branche_zusatz"><?php if ($la == en) {echo 'Valves';} else {echo 'Armaturen';}?></div><?php
	}
	if ($zeile_wst['branche'] == 20402) {
		echo '<img style="float:left;" src="../img/picto/meg_204.png" width="32" height="32" />';
		?><div id="branche_zusatz"><?php if ($la == en) {echo 'Tools & equipment';} else {echo 'Werkzeuge & Ger&auml;te';}?></div><?php
	}
	if ($zeile_wst['branche'] == 20403) {
		echo '<img style="float:left;" src="../img/picto/meg_204.png" width="32" height="32" />';
		?><div id="branche_zusatz"><?php if ($la == en) {echo 'Engineering';} else {echo 'Maschinenbau';}?></div><?php
	}
		
	
	if ($zeile_wst['branche'] == 205) {
		echo '<img src="../img/picto/meg_205.png" width="32" height="32" />';
	}
	if ($zeile_wst['branche'] == 20501) {
		echo '<img style="float:left;" src="../img/picto/meg_205.png" width="32" height="32" />';
		?><div id="branche_zusatz"><?php if ($la == en) {echo 'Electrical & Electronics';} else {echo 'Elektrik & Elektronik';}?></div><?php
	}
	if ($zeile_wst['branche'] == 20502) {
		echo '<img style="float:left;" src="../img/picto/meg_205.png" width="32" height="32" />';
		?><div id="branche_zusatz"><?php if ($la == en) {echo 'Hardware & locking systems';} else {echo 'Beschl&auml;ge & Schlie&amp;system';}?></div><?php
	}
	if ($zeile_wst['branche'] == 20503) {
		echo '<img style="float:left;" src="../img/picto/meg_205.png" width="32" height="32" />';
		?><div id="branche_zusatz"><?php if ($la == en) {echo 'Waches, Jewellery & Optics';} else {echo 'Uhren, Schmuck & Optik';}?></div><?php
	}
	if ($zeile_wst['branche'] == 20504) {
		echo '<img style="float:left;" src="../img/picto/meg_205.png" width="32" height="32" />';
		?><div id="branche_zusatz"><?php if ($la == en) {echo 'Defence Technology';} else {echo 'Wehrtechnik';}?></div><?php
	}
	
	
?>