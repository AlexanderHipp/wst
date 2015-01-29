<?php
/**
*	@project: Werkstück-Management CHIRON-WERKE GmbH & Co. KG
*	@author: Alexander Hipp
*	@date: 01.04.2012
*/


// Fehlermeldung zurücksetzen.
$feedback = "";


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
          <?php include("navi.php");

		  //Die Konstante für das images-Verzeichnis definieren
			define('WST_IMAGESPFAD', 'img/');
		  ?>
    </div>

    <div id="main">
    	<div id="pagehead"><span>Neues Werkstück anlegen</span></div>


		<?php
			// Wenn der anlegen-Button gedrückt wird soll Folgendes ausgeführt werden
			if (isset($_POST['query_meg_codes'])) {

				// Hier werden die jeweiligen Variablen gefüllt mit den Werten aus dem array query_meg_codes
				include("wst_edit_picto.php");

				//Variablen füllen
				//Bezeichnungen
				$bezeichnung = $_POST['bezeichnung'];
				$bezeichnung_en = $_POST['bezeichnung_en'];

				//Radio Button Geheimhaltung
				if (($_POST['geheim']) == '1') {
					$geheim = 1;
				}
				if (($_POST['geheim']) == '2') {
					$geheim = 2;
				}

				//Integer ohne Anführungszeichen
				$regal = $_POST[regal];
				$reihe = $_POST[reihe];
				$fach = $_POST[fach];
				$menge = $_POST[menge];
				$menge_cur = $_POST[menge];

				//Radio Button Rohteil
				if (($_POST['rohteil']) == '1') {
					$rohteil = 1;
				}
				if (($_POST['rohteil']) == '2') {
					$rohteil = 2;
				}

				//Variablen füllen
				$lfdnr = $_POST['lfdnr'];
				$datum = $_POST['datum_set'];
				$kunde = $_POST['kunde'];
				$aerospace = $_POST['aerospace'];
				$maschnr = $_POST['maschnr'];
				$maschtyp = $_POST['maschtyp'];

				$datum_array = explode(".",$datum);
				$datum = $datum_array[0].".".$datum_array[1].".".$datum_array[2];



				//Variablen füllen
				$stueckzeit = $_POST['stueckzeit'];
				$programmierer = $_POST['programmierer'];
				$werkstoff = $_POST['werkstoff'];
				$foto = $_FILES['foto']['name'];
				$kommentar = $_POST['kommentar'];
				$zuweisung_de = $_POST['zuweisung_de'];

				//Applikationsblatt (deutsch) wird erstellt
				$app_new = 0;


				// Überprüfung ob die Pflichtfelder ausgefüllt wurden
				if ($bezeichnung == "") { $fb_bezeichnung = 1; }
				if ($bezeichnung_en == "") { $fb_bezeichnung_en = 1; }
				if ($geheim == "") { $fb_geheim = 1; }
				if ($regal == "") { $fb_regal = 1; }
				if ($reihe == "") { $fb_reihe = 1; }
				if ($fach == "") { $fb_fach = 1; }
				if ($menge == "") { $fb_menge = 1; }
				if ($rohteil == "") { $fb_rohteil = 1; }
				if ($lfdnr == "") { $fb_lfdnr = 1; }
				if ($kunde == "") { $fb_kunde = 1; }
				if ($branche == "") { $fb_branche = 1; }
				if ($technologie_1 == "") { $fb_technologie_1 = 1; }
				if ($technologie_2 == "") { $fb_technologie_2 = 1; }
				if ($technologie_3 == "") { $fb_technologie_3 = 1; }
				if ($baureihe == "") { $fb_baureihe = 1; }
				if ($maschtyp == "") { $fb_maschtyp = 1; }
				if ($maschnr == "") { $fb_maschnr = 1; }
				if ($stueckzeit == "") { $fb_stueckzeit = 1; }
				if ($programmierer == "") { $fb_programmierer = 1; }
				if ($werkstoff == "") { $fb_werkstoff = 1; }
				if ($foto == "") { $fb_foto = 1; }
				if ($zuweisung_de == "") { $fb_zuweisung_de = 1; }

				if (($bezeichnung == "") OR ($bezeichnung_en == "") OR ($geheim == "") OR ($regal == "") OR ($reihe == "") OR ($fach == "") OR ($menge == "") OR ($rohteil == "") OR ($lfdnr == "") OR ($kunde == "") OR ($branche == "") OR ($technologie_1 == "") OR ($technologie_2 == "") OR ($technologie_3 == "") OR ($baureihe == "") OR ($maschtyp == "") OR ($maschnr == "") OR ($stueckzeit == "") OR ($programmierer == "") OR ($werkstoff == "") OR ($foto == "")  OR ($zuweisung_de == "")) { $feedback = 1; } else {


					// Wenn alle Pflichtfelder ausgefüllt wurden soll Folgendes ausgeführt werden
					// START DB-SCHREIBEN
					// Die Bild-Datei in das Verzeichnis img
					$ziel = "../". WST_IMAGESPFAD . $foto;
					if (move_uploaded_file($_FILES['foto']['tmp_name'], $ziel)) {

						$sql = "INSERT INTO wst (lfd_nr, datum_alter, bezeichnung, bezeichnung_en, geheim, regal, reihe, fach, menge, menge_cur, rohteil, kunde, maschtyp, maschnr, branche, technologie_1, technologie_2, technologie_3, technologie_4, baureihe, stueckzeit, programmierer, werkstoff, foto, kommentar, zuweisung_de)".
							"VALUES ('$lfdnr', '$datum', '$bezeichnung', '$bezeichnung_en', '$geheim', '$regal', '$reihe', '$fach', '$menge', '$menge_cur', '$rohteil', '$kunde', '$maschtyp', '$maschnr', '$branche', '$technologie_1', '$technologie_2', '$technologie_3', '$technologie_4', '$baureihe',  '$stueckzeit', '$programmierer', '$werkstoff', '$foto', '$kommentar', '$zuweisung_de')";
						$ergebnis = mysqli_query($db, $sql) or die('Das Werkstück konnte nicht angelegt werden. Bitte laden Sie die Seite neu und versuchen es noch einmal.');
						$sql_app = "INSERT INTO app (pub_nr_de, de) VALUES ('$lfdnr', '$app_new')";
						$ergebnis_app = mysqli_query($db, $sql_app) or die('Der Datenbank konnten keine Informationen übermittelt werden. Überprüfen Sie bitte Ihre Eingabe.');

						// Wenn der Datenbank ein Werkstück übermittelt wurde, soll die Meldung kommen: Werkstück erfolgreich angelegt!
						if ($ergebnis) {

							$zuweisung_de = $_POST['zuweisung_de'];
							$sql_user = "SELECT * FROM user WHERE ben_id = $zuweisung_de";
							$ergebnis_user = mysqli_query($db, $sql_user) or die('Es konnten keine Informationen über die User abgerufen werden. Bitte versuchen Sie es noch einmal.');
							$zeile_user =  mysqli_fetch_array($ergebnis_user);

							// Hier werden die E-Mails automatisch verschickt
							if ($zuweisung_de != 6) {
								include("mail_1.php");
								mail($an, $betreff, $inhalt, 'From: werkstueck@chiron.de');
							}
						}
					}
					// END DB-SCHREIBEN
				}

			//abgeschickt nein
			} else {

				//Radiobutton selected Wert festlegen
				$geheim = 0;
			}

			?>

        <form enctype="multipart/form-data" name="queryform" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" class="mdbpriv1" onsubmit="return gf_onsubmit_set_meg()">
    	<div id="box">
          	<?php
				// Wenn ein Ergebnis vorhanden ist, also ein Werkstück erfolgreich angelegt wurde, dann soll anstatt des "anlegen"-Buttons ein "weiter"-Button erscheinen
				if ($ergebnis) {
					?>
                    	<input type=button onClick="window.location.href='search.php'" value="weiter" class="grau" />
                     <?php
					 	$feedback = 2;
				} else {
					?><a href="javascript:gf_onsubmit_set_meg();document.queryform.submit();" rel="nofollow"><input type="button" class="grau" value="anlegen"/></a><?php
				}

            // Wenn nicht alle Felder ausgefüllt sind wird feedback auf true gesetzt und hier dann geprüft.
			if ($feedback == 1) {?>
				<div id="red" style="padding-top:10px;">Bitte alle Felder vollst&auml;ndig ausf&uuml;llen!</div>
			<?php }

			if ($feedback == 2) {?>
				<div id="green" style="padding-top:10px;">Es wurde ein neues Werkst&uuml;ck angelegt!</div>
			<?php
			exit;}

			?>

        </div>

        <div id="box_2_col" style="height:78px; float:left;">
                  	<table border="0">

                        <tr>
                            <td><label <?php if ($fb_bezeichnung == 1) { echo 'class="red_fb"'; } ?> for="bezeichnung">Bezeichnung </label></td>
                            <td><input style="margin-left:35px;" id="bezeichnung" name="bezeichnung" class="element text medium" type="text" maxlength="255" value="<?php echo $bezeichnung; ?>"/></td>
                        </tr>
                        <tr>
                            <td><label <?php if ($fb_bezeichnung_en == 1) { echo 'class="red_fb"'; } ?> for="bezeichnung">engl. </label></td>
                            <td><input style="margin-left:35px;" id="bezeichnung_en" name="bezeichnung_en" class="element text medium" type="text" maxlength="255" value="<?php echo $bezeichnung_en; ?>"/></td>
                        </tr>
                        <tr>
                            <td><label for="geheim"></label></td>
                            <td>
                            	<input style="margin-left:40px;" id="ja" name="geheim" type="radio" <?php if( $_POST['geheim'] == 1 ) { echo "checked='checked'";}?> value="1"><a <?php if ($fb_geheim == 1) { echo 'class="red_fb"'; } ?> >geheim</a>
                            	<input style="margin-left:12px;" id="nein" name="geheim" type="radio" <?php if( $_POST['geheim'] == 2 ) {echo "checked='checked'";}?> value="2"/> <a <?php if ($fb_geheim == 1) { echo 'class="red_fb"'; } ?> >frei</a></td>
                        </tr>

                      </table>

        </div>

        <div id="box_2_col" style="float:right;">

                      <table border="0">
                            <tr>
                                <td><label <?php if (($fb_regal == 1) OR ($fb_reihe == 1) OR ($fb_fach == 1)) { echo 'class="red_fb"'; } ?> for="lagerort">Lagerort </label></td>
                                <td>
                                    <input style="margin-left:20px;" id="lagerort" name="regal" class="element text small" type="text" size="1" maxlength="3" value="<?php echo $regal; ?>"/> /
                                    <input id="lagerort" name="reihe" class="element text small" type="text" size="1" maxlength="3" value="<?php echo $reihe; ?>"/> /
                                    <input id="lagerort" name="fach" class="element text small" type="text" size="1" maxlength="3" value="<?php echo $fach; ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td><label <?php if ($fb_menge == 1) { echo 'class="red_fb"'; } ?> for="menge">Menge </label></td>
                                <td>
                                    <input style="margin-left:20px;" id="lagerort" name="menge" class="element text small" type="text" size="1" maxlength="2" value="<?php echo $menge; ?>"/>

                                </td>
                            </tr>
                            <tr>
                                <td><label <?php if ($fb_rohteil == 1) { echo 'class="red_fb"'; } ?> for="rohteil">Rohteil vorhanden</label></td>
                                <td><input style="margin-left:25px;" id="ja" name="rohteil" type="radio" value="1"

								<?php
									// Wenn ein Feld nicht ausgefüllt wurde und der Nutzer dieses ergänzen soll, muss hier geprüft werden, welcher Radiobutton zuvor schon geklickt wurde
									if( $_POST['rohteil'] == 1 ) {
											echo "checked='checked'";
										  }
								?>
                            /> ja
                                    <input style="margin-left:12px;" id="nein" name="rohteil" type="radio" value="2" <?php
									// Wenn ein Feld nicht ausgefüllt wurde und der Nutzer dieses ergänzen soll, muss hier geprüft werden, welcher Radiobutton zuvor schon geklickt wurde
									if( $_POST['rohteil'] == 2 ) {
											echo "checked='checked'";
										  }
								?> /> nein</td>
                            </tr>
                            </table>

        </div>
       <div id="box" style="clear:both;">

                      <table border="0">

                            <tr>

                                <td><label <?php if ($fb_lfdnr == 1) { echo 'class="red_fb"'; } ?> for="lfdnr">Lfd-Nr</label></td>
                                <td>
                                    <input style="margin-left:62px;" id="lfdnr" name="lfdnr" class="element text small" type="text" size="8" value="<?php echo $lfdnr; ?>"/>
                                </td>
                            </tr>
                            <tr>

                                <td><label for="datum_set">Datum</label></td>
                                <td>
                                    <input style="margin-left:62px;" id="datum_set" name="datum_set" class="element text small" type="text" size="8" value="<?php echo $datum_alter; ?>"/> (Format: dd.mm.YYYY)
                                </td>
                            </tr>
                            <tr>

                                <td><label <?php if ($fb_kunde == 1) { echo 'class="red_fb"'; } ?> for="kunde">Kunde </label></td>
                                <td>

                                		<input style="margin-left:62px;" id="kunde" name="kunde" class="element text medium" type="text" maxlength="255" value="<?php echo $kunde; ?>"/>


                                </td>
                            </tr>

                          	<input name="query_meg_codes" id="meg_codes" type="hidden">
                          <tr>
                            <td><label <?php if ($fb_branche == 1) { echo 'class="red_fb"'; } ?> for="branche">Branche </label></td>


                            <?php
								include("picto.php");
							?>


                            <td style="padding-left:63px;"colspan="3">

                                    <div id="meg201" class="meg_btn btngrp_MEG02
									<?php if( $branche[1] == 201 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="gf_toggle_btn_with_ddlb('#meg201', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_201_4multistate.png)" title="Aerospace"></div>

                                    <div id="meg202" class="meg_btn btngrp_MEG02
									<?php if( $branche[2] == 202 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="gf_toggle_btn_with_ddlb('#meg202', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_202_4multistate.png)" title="Automotive"></div>

                                    <div id="meg203" class="meg_btn btngrp_MEG02
									<?php if( $branche[3] == 203 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="gf_toggle_btn_with_ddlb('#meg203', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_203_4multistate.png)" title="Medical"></div>

                                    <div id="meg204" class="meg_btn btngrp_MEG02
									<?php if( $branche[4] == 204 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="gf_toggle_btn_with_ddlb('#meg204', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_204_4multistate.png)" title="Mechanical Engineering"></div>

                                    <div id="meg205" class="meg_btn btngrp_MEG02
									<?php if( $branche[5] == 205 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="gf_toggle_btn_with_ddlb('#meg205', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_205_4multistate.png)" title="Precision Technology"></div>

                                    <select name="aerospace" size="1" id="meg202_ddlb" class="meg_ddlb ddlbgrp_MEG02" style="display:none">
                                    <option></option>
                                    <option value="20201">Antriebsstrang</option>
                                    <option value="20202">Bremssysteme</option>
                                    <option value="20203">Klima- &amp; L&uuml;ftungssysteme</option>
                                    <option value="20204">Kraftstoffsysteme</option>
                                    <option value="20205">Abgassysteme</option>
                                    <option value="20206">Felgen</option>
                                    <option value="20207">Motor & Aggregate</option>
                                    <option value="20208">Lenk- &amp; Fahrwerksysteme</option>
                                    <option value="20209">Karosserieteile</option>
                                    </select>

                                    <select name="" size="1" id="meg204_ddlb" class="meg_ddlb ddlbgrp_MEG02" style="display:none">
                                    <option></option>
                                    <option value="20401">Armaturen</option>
                                    <option value="20402">Werkzeuge &amp; Ger&auml;te</option>
                                    <option value="20403">Maschinenbau</option>
                                    </select>

                                    <select name="" size="1" id="meg205_ddlb" class="meg_ddlb ddlbgrp_MEG02" style="display:none">
                                    <option></option>
                                    <option value="20501">Elektrik &amp; Elektronik</option>
                                    <option value="20502">Beschl&auml;ge &amp; Schlie&szlig;systeme</option>
                                    <option value="20503">Uhren, Schmuck &amp; Optik</option>
                                    <option value="20503">Wehrtechnik</option>
                                    </select>

                                  </td>
                            </tr>
                      </table>
       	 </div>
         <div id="box">
                      <table border="0">
                            <tr>
                                <td><label <?php if (($fb_technologie_1 == 1) OR ($fb_technologie_2 == 1) OR ($fb_technologie_3 == 1)) { echo 'class="red_fb"'; } ?> for="technologie">Technologie </label></td>
                                <td  style="padding-left:25px;" colspan="3">
                                    <input type="hidden">
                                    <div class="meg_group" id="MEG_GROUP_MEG01">

                                    <div class="meg_subgroup" id="MEG_SUBGROUP_MEG01_0">
                                    <div id="meg101" class="meg_btn
                                    <?php if( $technologie_1[1] == 101 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg101').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_101_4multistate.png)" title="FZ Einspindel"></div>
                                    <div id="meg102" class="meg_btn
                                    <?php if( $technologie_1[2] == 102 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg102').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_102_4multistate.png)" title="FZ Doppelspindel"></div>
                                    <div id="meg103" class="meg_btn
                                    <?php if( $technologie_1[3] == 103 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg103').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_103_4multistate.png)" title="FZ Vierspindel"></div>
                                    <div id="meg104" class="meg_btn
                                    <?php if( $technologie_1[4] == 104 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg104').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_104_4multistate.png)" title="NC-Schwenkkopf"></div>
                                    </div>

                                    <div class="meg_subgroup" id="MEG_SUBGROUP_MEG01_1">
                                    <div id="meg111" class="meg_btn
                                    <?php if( $technologie_2[1] == 111 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg111').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_111_4multistate.png)" title="Korb-Werkzeugwechsler"></div>
                                    <div id="meg112" class="meg_btn
                                    <?php if( $technologie_2[2] == 112 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg112').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_112_4multistate.png)" title="Ketten-Werkzeugwechsler"></div>
                                    </div>

                                    <div class="meg_subgroup" id="MEG_SUBGROUP_MEG01_2">
                                    <div id="meg121" class="meg_btn
                                    <?php if( $technologie_3[1] == 121 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg121').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_121_4multistate.png)" title="Starrtisch"></div>
                                    <div id="meg122" class="meg_btn
                                    <?php if( $technologie_3[2] == 122 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg122').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_122_4multistate.png)" title="Werkst&uuml;ckwechseleinrichtung"></div>
                                    <div id="meg123" class="meg_btn
                                    <?php if( $technologie_3[3] == 123 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg123').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_123_4multistate.png)" title="Five axis"></div>
                                    <div id="meg124" class="meg_btn
                                    <?php if( $technologie_3[4] == 124 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg124').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_124_4multistate.png)" title="Langbett"></div>
                                    </div>

                                    <div class="meg_subgroup" id="MEG_SUBGROUP_MEG01_3">
                                    <div id="meg131" class="meg_btn
                                    <?php if( $technologie_4[1] == 131 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg131').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_131_4multistate.png)" title="Stangen-Bearbeitung"></div>
                                    <div id="meg132" class="meg_btn
                                    <?php if( $technologie_4[2] == 132 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg132').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_132_4multistate.png)" title="MPS"></div>
                                    <div id="meg133" class="meg_btn
                                    <?php if( $technologie_4[3] == 133 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg133').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_133_4multistate.png)" title="WM Felgenbearbeitung"></div>
                                    <div id="meg141" class="meg_btn
                                    <?php if( $technologie_4[4] == 141 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg141').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_141_4multistate.png)" title="Automation"></div>
                                    </div>
                                    </div>
                                    </td>
                            </tr>


                            <tr class="mdb_meg mdb_MEG04">
                            	<td><label <?php if ($fb_baureihe == 1)  { echo 'class="red_fb"'; } ?> for="baureihe">Baureihe </label></td>
                                <td style="padding-left:25px;" colspan="3">
                            	    <div id="meg401" class="meg_btn
									<?php if( $baureihe[1] == 401 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg401').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_401_4multistate.png)" title="08"></div>
                                    <div id="meg402" class="meg_btn
									<?php if( $baureihe[2] == 402 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg402').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_402_4multistate.png)" title="12"></div>
                                    <div id="meg403" class="meg_btn
									<?php if( $baureihe[3] == 403 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg403').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_403_4multistate.png)" title="15"></div>
                                    <div id="meg404" class="meg_btn
									<?php if( $baureihe[4] == 404 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg404').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_404_4multistate.png)" title="18"></div>

																		<div id="meg407" class="meg_btn
									<?php if( $baureihe[7] == 407 ) {echo "meg_btn_pushed";} ?>
																		" onClick="$('#meg407').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_407_4multistate.png)" title="24"></div>

																		<div id="meg408" class="meg_btn
									<?php if( $baureihe[8] == 408 ) {echo "meg_btn_pushed";} ?>
																		" onClick="$('#meg408').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_408_4multistate.png)" title="26"></div>

																		<div id="meg405" class="meg_btn
									<?php if ($baureihe[5] == 405 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg405').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_405_4multistate.png)" title="MILL"></div>

																		<div id="meg409" class="meg_btn
									<?php if ($baureihe[9] == 409 ) {echo "meg_btn_pushed";} ?>
																		" onClick="$('#meg409').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_409_4multistate.png)" title="H"></div>

                              </td>
                        	</tr>


                              </td>
                        	</tr>
                            <tr>
                                <td><label <?php if ($fb_maschtyp == 1)  { echo 'class="red_fb"'; } ?> for="maschtyp">Maschinen-Typ </label></td>
                                <td><input style="margin-left:24px;" id="maschtyp" name="maschtyp" class="element text medium" type="text"  maxlength="255" value="<?php echo $maschtyp; ?>"/></td>
                            </tr>
                            <tr>
                                <td><label <?php if ($fb_maschnr == 1)  { echo 'class="red_fb"'; } ?> for="maschnr">Maschinen-Nr. </label></td>
                                <td><input style="margin-left:24px;" id="maschnr" name="maschnr" class="element text medium" type="text" size="7" maxlength="255" value="<?php echo $maschnr; ?>"/></td>
                            </tr>

                            <tr>
                                <td><label <?php if ($fb_stueckzeit == 1)  { echo 'class="red_fb"'; } ?> for="stueckzeit">St&uuml;ckzeit in Sek.</label></td>
                                <td><input style="margin-left:24px;" id="stueckzeit" name="stueckzeit" class="element text medium" type="text"  size="7" maxlength="255" value="<?php echo $stueckzeit; ?>"/></td>
                            </tr>
                            <tr>
                                <td><label <?php if ($fb_programmierer == 1)  { echo 'class="red_fb"'; } ?> for="programmierer">Programmierer </label></td>
                                <td><input style="margin-left:24px;" id="programmierer" name="programmierer" class="element text medium" type="text" maxlength="255" value="<?php echo $programmierer; ?>"/></td>
                            </tr>

                            <tr>
                                <td><label <?php if ($fb_werkstoff == 1)  { echo 'class="red_fb"'; } ?> for="werkstoff">Werkstoff </label></td>


                                    <!--Um später einen Absendewert zu bestimmen muss value="" benutzt werden. http://de.selfhtml.org/html/formulare/auswahl.htm-->
                                    <td>
                                    	<select style="margin-left:24px;" name="werkstoff" >
                                        <option value="" <?php if( $_POST['werkstoff'] == "" ) {echo "selected='selected'";} ?> >Bitte wählen</option>
                                        <option value="1" <?php if( $_POST['werkstoff'] == 1 ) {echo "selected='selected'";} ?> >Aluminium</option>
                                        <option value="2" <?php if( $_POST['werkstoff'] == 2 ) {echo "selected='selected'";} ?> >Buntmetalle</option>
                                        <option value="3" <?php if( $_POST['werkstoff'] == 3 ) {echo "selected='selected'";} ?> >Stahl</option>
                                        <option value="4" <?php if( $_POST['werkstoff'] == 4 ) {echo "selected='selected'";} ?> >Gußeisen</option>
                                        <option value="5" <?php if( $_POST['werkstoff'] == 5 ) {echo "selected='selected'";} ?> >Kunststoff</option>
                                        <option value="6" <?php if( $_POST['werkstoff'] == 6 ) {echo "selected='selected'";} ?> >Sonstige</option>
                                        <option value="7" <?php if( $_POST['werkstoff'] == 7 ) {echo "selected='selected'";} ?> >Magnesium</option>
                                        <option value="8" <?php if( $_POST['werkstoff'] == 8 ) {echo "selected='selected'";} ?> >(kein)</option>

                                    </td>
                                </tr>
                      </table>
         	</div>

        	<div id="box">
            	<label <?php if ($fb_foto == 1)  { echo 'class="red_fb"'; } ?> for="Bild">Bild </label>
                <input style="margin-left:90px;" type="file" id="foto" name="foto" /><?php echo $foto; ?></input>
            </div>

            <div id="box">
                  		<table border="0">

                            <tr>
                                 <td><label for="kommentar">Kommentar </label></td>
                                 <td style="padding-left:19px;" colspan="3"><textarea style="margin-left:25px;" id="kommentar" name="kommentar" cols="30" rows="2" value""><?php echo $kommentar; ?></textarea></td>
    						</tr>
                        </table>

          	   			<tr>
            	            <td><label <?php if ($fb_zuweisung_de == 1)  { echo 'class="red_fb"'; } ?> for="zuweisung_de">App-Zuweisung an</label></td>
                            <td>
                            	<select style="margin-left:10px;" name="zuweisung_de" />
                            	<option value="">Bitte wählen</option>

                            	<?php
                                	// Hier sollen alle User aufgeführt werden die als Bearbeiter in Frage kommen, deshalb werden alle user aus tabelle:user
                                	$sql_user = "SELECT * FROM user ORDER BY ben_id";
                                	$ergebnis_user = mysqli_query($db, $sql_user) or die('Es konnten keine Informationen über die User abgerufen werden. Bitte versuchen Sie es noch einmal.');

                                	while ($zeile_user = mysqli_fetch_array($ergebnis_user)) {
                                    	?><option value="<?php echo $zeile_user['ben_id'] ?>" <?php if( $_POST['zuweisung_de'] == $zeile_user['ben_id'] ) {echo "selected='selected'";} ?> > <?php echo $zeile_user['name'] ?></option><?php
                                	}
                            	?>
                        	</td>
                       	 </tr>
            </div>
        </form>
        <?php
			}
		?>

	</div>
</div>
