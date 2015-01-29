<?php
/** 
*	@project: Werkstück-Management CHIRON-WERKE GmbH & Co. KG
*	@author: Alexander Hipp
*	@date: 01.04.2012
*/

	
	$an = $zeile_user['email'];
	$betreff = "WST-Management: NEUES WERKSTÜCK ".$bezeichnung;
	$betreff = utf8_decode($betreff);
	$von = "alice.reger@chiron.de";
	$inhalt = "Es wurde das Werkstück " .$bezeichnung. " mit der Nummer ".$lfdnr." angelegt.\n" .
		"Bitte vervollständigen Sie die fehlenden Informationen, damit das Applikationsblatt dann erstellt werden kann.\n" . 
		"Sie finden das Werkstück in Ihrer Applikations-Sheet-Liste im Werkstücklager-Management.";
	//---------------------------------------------------------------------------------------------------------
	
	
	$an2 = $zeile_user['email'];
	$betreff2 = "WST-Management: NEW WORCPIECE";
	$von2 = "alice.reger@chiron.de";
	$inhalt2 = "The application sheet for workpiece " . $zeile_wst['bezeichnung'] . " with #" . $zeile_wst['lfd_nr'] . " was edited.\n" .
		"Please complete the information for the englisch sheet.\n" . 
		"You find the form on your application-sheet-list in workpiece management.\n".
		"Thank You.";

	//---------------------------------------------------------------------------------------------------------
	
	
	$an3 = "alice.reger@chiron.de";
	$betreff3 = "WST-Management: APP DEUTSCH ANGELEGT";
	$von3 = "wst-management";
	$inhalt3 = "Das deutsche Applikationsblatt für das Werkstück: " . $zeile_wst['bezeichnung'] . " mit der Nummer " . $zeile_wst['lfd_nr'] . " wurde angelegt.\n" .
		"Die englische Übersetzung wurde " .  $zeile_user['name'] . " [". $zeile_user['email'] . "] zugewiesen";
		
	//---------------------------------------------------------------------------------------------------------
	
	
	$an4 = "alice.reger@chiron.de";
	$betreff4 = "WST-Management: APP ENGLISCH ANGELEGT";
	$von4 = "wst-management";
	$inhalt4 = "Das deutsche und das englische Applikationsblatt für das Werkstück: " . $zeile_wst['bezeichnung'] . " wurden angelegt.\n";
	
	//----------------------------------------------------------------------------------------------------------
	
	$an5 = "reinhold.stehle@chiron.de";
	$betreff5 = "WST-Management: NEUES WERKSTÜCK";
	$betreff5 = utf8_decode($betreff5);
	$von5 = "alice.reger@chiron.de";
	$inhalt5 = "Es wurde das Werkstück " . $zeile_wst['bezeichnung'] . " mit der Nummer ".$zeile_wst['lfd_nr']."geändert.\n" .
		"Bitte vervollständigen Sie gegebenfalls die fehlenden Informationen, damit das Applikationsblatt dann neu erstellt werden kann.\n" . 
		"Sie finden das Werkstück in Ihrer Applikations-Sheet-Liste im Werkstücklager-Management.";
		
	//---------------------------------------------------------------------------------------------------------
	
	
	$an6 = "alice.reger@chiron.de";
	$betreff6 = "WST-Management: APP DEUTSCH GEÄNDERT";
	$von6 = "wst-management";
	$inhalt6 = "Das deutsche und englische Applikationsblatt für das Werkstück: " . $zeile_wst['bezeichnung'] . " mit der Nummer ".$zeile_wst['lfd_nr']." wurde geändert.\n";
	
?>