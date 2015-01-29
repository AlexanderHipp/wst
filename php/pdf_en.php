<?php
/**
*	@project: Werkstück-Management CHIRON-WERKE GmbH & Co. KG
*	@author: Alexander Hipp
*	@date: 01.04.2012
*/


session_start();


		// Hier wird geprüft ob schon eine Anmeldung erfolgt ist
		if (!isset($_SESSION['ben_id'])) {
			?>
			<div id="box_anmelden" style="margin-top:10px;">Bitte zuerst <a href="index.php" style="text-decoration:underline;">anmelden</a></div><?php
			exit();
		} else {

error_reporting(E_ALL);

	$db = mysqli_connect("db1080.mydbserver.com", "p161002", "tester", "usr_p161002_1") or die ("Es konnte keine Verbindung zur Datenbank hergestellt werden.");
	//$db = mysqli_connect("127.0.0.1", "root", "", "wst-management") or die ("Es konnte keine Verbindung zur Datenbank hergestellt werden.");

	// Hier werden die jeweiligen Werkstück-Informationen aus der GET['lfd'] gelesen
	$lfd_nr = $_GET['lfd'];
	$sql_wst = "SELECT * FROM wst WHERE lfd_nr = $lfd_nr";
	$ergebnis_wst = mysqli_query($db, $sql_wst) or die('Es konnten keine Informationen über das Werkstück abgerufen werden. Bitte versuchen Sie es noch einmal.');
	$zeile_wst =  mysqli_fetch_array($ergebnis_wst);

	$sql_app_en = "SELECT * FROM app_en WHERE pub_nr_en = $lfd_nr";
	$ergebnis_app_en = mysqli_query($db, $sql_app_en) or die('Es konnten keine Informationen über das Applikationsblatt (englisch) abgerufen werden. Bitte versuchen Sie es noch einmal.');
	$zeile_app_en =  mysqli_fetch_array($ergebnis_app_en);

	$sql_app = "SELECT * FROM app WHERE pub_nr_de = $lfd_nr";
	$ergebnis_app = mysqli_query($db, $sql_app) or die('Es konnten keine Informationen über das Applikationsblatt (deutsch) abgerufen werden. Bitte versuchen Sie es noch einmal.');
	$zeile_app =  mysqli_fetch_array($ergebnis_app);



	//Übergabe der Variablen
	$bezeichnung = $zeile_wst['bezeichnung_en'];

	if( $zeile_wst['werkstoff'] == 1 ) {$werkstoff = "Aluminum";}
	if( $zeile_wst['werkstoff'] == 2 ) {$werkstoff = "Non-ferrous-metal";}
	if( $zeile_wst['werkstoff'] == 3 ) {$werkstoff = "Steel";}
	if( $zeile_wst['werkstoff'] == 4 ) {$werkstoff = "Cast iron";}
	if( $zeile_wst['werkstoff'] == 5 ) {$werkstoff = "Plastic";}
	if( $zeile_wst['werkstoff'] == 6 ) {$werkstoff = "other";}
	if( $zeile_wst['werkstoff'] == 7 ) {$werkstoff = "Magnesium";}
	if( $zeile_wst['werkstoff'] == 8 ) {$werkstoff = "(no)";}

	$aufspannungen = $zeile_app['aufspannungen'];

	$stueckzeit = number_format((3600 / $zeile_wst['stueckzeit']), 1);

	include("picto_info_branche_pdf.php");
	include("picto_info_technologie_pdf.php");
	include("picto_info_baureihe_pdf.php");


	$maschtyp = $zeile_wst['maschtyp'];

	$pfad_1 = $zeile_wst['foto'];
	$image_1 = '../img/' . $pfad_1;

	if ($zeile_app['foto1'] != "") {
	$pfad_2 = $zeile_app['foto1'];
	$image_2 = '../img/app/' . $pfad_2;
	}

	if ($zeile_app['foto2'] != "") {
	$pfad_3 = $zeile_app['foto2'];
	$image_3 = '../img/app/' . $pfad_3;
	}

	$maschnr = utf8_decode($zeile_wst['maschnr']);

	$image_beschr_1 = utf8_decode($zeile_app_en['beschr1_en']);
	$image_beschr_2 = utf8_decode($zeile_app_en['beschr2_en']);

	$produktionsvolumen = $zeile_app['produktionsvolumen'];


	//Trimmen von Array - Funktion
	function trim_value(&$value) {
		$value = trim($value);
	}


	//Besonderheiten
	$strich_besonder = chr(149) ." ";
	$array_besonder = explode(";", $zeile_app_en['besonderheiten_en']);
	array_walk($array_besonder, 'trim_value');
	$string_besonder_os = implode("\n" . chr(149) . " ", $array_besonder);
	$string_besonder = $strich_besonder . $string_besonder_os;

	//Qualitätsvorgaben
	$strich_vorg = chr(149) ." ";
	$array_vorg = explode(";", $zeile_app_en['qualitaetsvorgaben_en']);
	array_walk($array_vorg, 'trim_value');
	$string_vorg_os = implode("\n" . chr(149) . " ", $array_vorg);
	$string_vorg = $strich_vorg . $string_vorg_os;


	//Feritgungsziele
	$strich_fert = chr(149) ." ";
	$array_fert = explode(";", $zeile_app_en['fertigungsziele_en']);
	array_walk($array_fert, 'trim_value');
	$string_fert_os = implode("\n" . chr(149) . " ", $array_fert);
	$string_fert = $strich_fert . $string_fert_os;


	//Kundennutzen
	$strich_nutzen = chr(149) ." ";
	$array_nutzen = explode(";", $zeile_app_en['kundennutzen_en']);
	array_walk($array_nutzen, 'trim_value');
	$string_nutzen_os = implode("\n" . chr(149) . " ", $array_nutzen);
	$string_nutzen = $strich_nutzen . $string_nutzen_os;



	$time = $zeile_wst['erstellungsdatum'];
	$timestamp = strtotime($time);
	$datum = date("d.m.Y", $timestamp);

	$zuweisung_bearbeiter = $zeile_app['bearbeiter'];

	$sql_user = "SELECT * FROM user WHERE ben_id = $zuweisung_bearbeiter";
	$ergebnis_user = mysqli_query($db, $sql_user) or die("Das Applikationsblatt (englisch) kann nicht aufgerufen werden.");
	$zeile_user =  mysqli_fetch_array($ergebnis_user);

	$bearbeiter = $zeile_user['name'];
	$pub_nr = $zeile_wst['lfd_nr'];
	$verwendetefotos = $zeile_wst['foto'] . ', ' . $zeile_app['foto1'] . ', ' . $zeile_app['foto2'];



	// Einbindung der Bibliothekdatei
	require('fpdf/fpdf.php');

	class PDF extends FPDF {
		function Header() {

			//Text Formatierung
			$this->setTextColor(28, 27, 33);
			$this->SetFont('Arial', 'B', 10);
			$this->Cell(7.6,5, '');
			$this->Cell(0,5, html_entity_decode('Confidental! For internal use only.'));
			$this->Cell(0,18, '', 0, 1);
			//Logo
			$this->Image('fpdf/logo.png', 145, 13, 50);
			//Slogan
			$this->Image('fpdf/slogan_en.png', 10, 30, 75);

		}

		function Footer() {
			//Position 1,5 cm von unten
			$this->SetY(-15);
			//Text Formatierung
			$this->setTextColor(105, 105, 105);
			$this->SetFontSize(8);

			$this->Cell(15,3, 'Date');
			$this->Cell(23,3, $this->datum);
			$this->Cell(55,3, 'Used photos / adress');
			$this->Cell(90,3, 'CHIRON-WERKE GMBH & Co. KG');
			$this->Ln();

			$this->Cell(15,3, 'Publ-No.');
			$this->Cell(23,3, $this->pub_nr);
			$this->Cell(55,3, $this->vfotos);
			$this->Cell(90,3,  html_entity_decode('Kreuzstra&szlig;e 75 I D-78532 Tuttlingen I telephone (07461) 940-8000'));
			$this->Ln();

			$this->Cell(15,3, 'Editor');
			$this->Cell(78,3, $this->bearbeiter);
			$this->Cell(90,3, 'info@chiron.de I www.chiron.de');
		}
	}



	// Objekt erstellen
	$pdf=new PDF();

	//Header und Footer Variable übergeben
	$pdf->datum = $datum;
	$pdf->pub_nr = $pub_nr;
	$pdf->bearbeiter = $bearbeiter;
	$pdf->vfotos = $verwendetefotos;
		$pdf->docname = $pub_nr."_en.pdf";

	//Seitenrand festlegen
	$pdf->AddPage();
	$pdf->SetMargins(17.6, 0);
	$pdf->Ln();

	//Inhalt

	//Inhaltsheader
	$pdf->SetFillColor(128, 127, 132);
	$pdf->setTextColor(255, 255, 255);
	$pdf->SetFont('Arial', 'B', 14);
	$pdf->Cell(1,10, '');
	$pdf->Cell(100,10, $bezeichnung, 0, 0, 'L', 1);
	$pdf->Cell(76.3,10, $maschnr, 0, 1, 'R', 1);

	//Hintergrundfarbe und Textfarbe
	$pdf->SetFillColor(236, 236, 236);
	$pdf->setTextColor(54, 54, 54);
	$pdf->setDrawColor(193, 193, 193);

	//Werkstoff / Aufspannungen / Stück/Stunde
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->Cell(1,8, '');
	$pdf->Cell(30,8, 'Material', 'L', 0, 'L', 1);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(55,8, $werkstoff, 'R', 1, 'L', 1);
	$pdf->Cell(1,5, '');
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->Cell(30,5, 'Clamping device', 'L', 0, 'L', 1);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(55,5, $aufspannungen, 'R', 1, 'L', 1);
	$pdf->Cell(1,5, '');
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->Cell(30,8, html_entity_decode('Pieces/hour'), 'LB', 0, 'L', 1);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(55,8, $stueckzeit, 'BR', 1, 'L', 1);

	//Piktogramme
	$pdf->Image($branche, 109.8, 62, 10);
	$pdf->Image($technologie_1, 124.8, 62, 10);
	$pdf->Image($technologie_2, 139.8, 62, 10);
	$pdf->Image($technologie_3, 154.8, 62, 10);
	$pdf->Image($technologie_4, 169.8, 62, 10);
	$pdf->Image($baureihe, 184.8, 62, 10);

	//Spacer
	$pdf->Cell(177.3,3, '', 0, 1);

	//Maschinentyp
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->Cell(1,8, '');
	$pdf->Cell(85,8,$maschtyp, '1', 0, 'L', 1);

	//WST-Bild
	$pdf->Cell(6.3,49, '');
	$pdf->Cell(85,49, '', '1', 0, 'L', 1);
	$pdf->Image($image_1, 120, 85, 60);

	//Spacer
	$pdf->Cell(85,11, '', 0, 1);


	//Konstruktive Besonderheiten
	$pdf->Cell(1,8, '');
	$pdf->Cell(85,8, 'Special construction features', 'TLR', 1, 'L', 1);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(1,5, '');
	$pdf->MultiCell(85,5, $string_besonder, 'RLB', 1, 'L', 1);

	//Spacer
	$pdf->Cell(177.3,3, '', 0, 1);


	//Kundenvorgaben & Kundennutzen
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->Cell(1,8, '');
	$pdf->Cell(85,8, 'Customer requirements', 'TLR', 0, 'L', 1);
	$pdf->Cell(6.3,8, '', 0, 0);
	$pdf->Cell(85,8, 'Customer gain', 'TLR', 1, 'L', 1);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(1,8, '');
	$pdf->Cell(35,8, 'Production volume ', 'L', 0, 'L', 1);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(50,8, $produktionsvolumen, 'R', 0, 'L', 1);
	$pdf->Cell(6.3,8, '', 0, 0);
	$curr_x = $pdf->GetX();
	$curr_y = $pdf->GetY();
	$pdf->MultiCell(85,5, $string_nutzen, 'RLB', 1, 'L', 1);
	$pdf->SetXY($curr_x+85, $curr_y);
	$pdf->Cell(1,8, '', 0, 1);
	$pdf->Cell(1,8, '');
	$pdf->Cell(85,8, html_entity_decode('Quality guidelines'), 'LR', 1, 'L', 1);
	$pdf->Cell(1,8, '');
	$pdf->MultiCell(85,5, $string_vorg, 'RL', 1, 'L', 1);
	$pdf->Cell(1,1, '');
	$pdf->Cell(85,1, '', 'LR', 1, 'L', 1);
	$pdf->Cell(1,8, '');
	$pdf->Cell(85,8, 'Manufacturing objectives', 'LR', 1, 'L', 1);
	$pdf->Cell(1,8, '');
	$pdf->MultiCell(85,5, $string_fert, 'RLB', 1, 'L', 1);

	//Spacer
	$pdf->Cell(177.3,6, '', 0, 1);

	//Bilder
	$pdf->SetXY(17.6, 210);
	if (isset($image_2)) {
		$pdf->Cell(1,55, '');
		if (isset($image_3)) {
			$pdf->Cell(85,55, '', 'LTR', 0, 'L', 1);
		} else {
			$pdf->Cell(85,55, '', 'LTR', 1, 'L', 1);
		}
		$pdf->Image($image_2, 23.5, 214, 75);
	}

	if (isset($image_3)) {
		$pdf->Cell(6.3,55, '');
		$pdf->Cell(85,55, '', 'LTR', 1, 'L', 1);
		$pdf->Image($image_3, 114.5,214, 75);
	}


	if (isset($image_2)) {
		$pdf->Cell(1,8, '');
		$pdf->Cell(85,8, $image_beschr_1, 'LRB', 0, 'C', 1);
	}
	if (isset($image_3)) {
		$pdf->Cell(6.3,8, '');
		$pdf->Cell(85,8, $image_beschr_2, 'LRB', 0, 'C', 1);
	}



	$pdf->Output();
}
?>
