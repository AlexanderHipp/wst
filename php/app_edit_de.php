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
		if (!isset($_SESSION['ben_id']) OR ($_SESSION['rolle'] == 2) OR ($_SESSION['rolle'] == 4)) {
			?>
			<div id="box_anmelden" style="margin-top:10px;">Bitte zuerst <a href="index.php" style="text-decoration:underline;">anmelden</a></div><?php
			exit();
		} else {
	?>
    <div id="navi">
         <?php include("navi.php");

         	//Die Konstante für das images-Verzeichnis definieren
			define('WST_IMAGESPFAD', 'img/app/');
		  	?>

    </div>
    <div id="main">
        <div id="pagehead"><span>Applikationsblatt ergänzen / application sheet supplement </span></div>
    <?php


		// Wenn ein Wert übergeben wird dann soll dieser in die Variable $pub geschrieben werden

			$pub = $_GET['pub'];
			$sql_wst = "SELECT * FROM wst WHERE lfd_nr = $pub";
			$ergebnis_wst = mysqli_query($db, $sql_wst) or die('Es konnten keine Informationen über das Werkstück abgerufen werden. Bitte versuchen Sie es noch einmal.');
			$zeile_wst =  mysqli_fetch_array($ergebnis_wst);



		if (isset($_POST['submit'])) {

			// Variablen für das Formular füllen
			$aufsp = $_POST['aufsp'];
			$besonderheiten = $_POST['besonderheiten'];
			$kundennutzen = $_POST['kundennutzen'];
			$prod = $_POST['prod'];
			$quali = $_POST['quali'];
			$fert = $_POST['fert'];

			$bearb = $_POST['bearb'];
			$pub = $_POST['pub'];
			$bearbeiter = $_POST['bearbeiter'];
			$zuweisung_en = $_POST['zuweisung_en'];


			// Überprüfung ob die Pflichtfelder ausgefüllt wurden
			if ($aufsp == "") { $fb_aufsp = 1; }
			if ($besonderheiten == "") { $fb_besonderheiten = 1; }
			if ($kundennutzen == "") { $fb_kundennutzen = 1; }
			if ($prod == "") { $fb_prod = 1; }
			if ($quali == "") { $fb_quali = 1; }
			if ($fert == "") { $fb_fert = 1; }
			if ($bearb == "") { $fb_bearb = 1; }
			if ($zuweisung_en == "") { $fb_zuweisung_en = 1; }
			if (($aufsp == "") OR ($besonderheiten == "") OR ($kundennutzen == "") OR ($prod == "") OR ($quali == "") OR ($fert == "") OR ($bearb == "") OR ($zuweisung_en == "")) { $feedback = 1; } else {



				// Status auf fertig bearbeitet setzen
				$status = 1;


				$foto1 ="";
				$foto2 ="";
				$beschr1 ="";
				$beschr2 ="";

				if (isset($_FILES['foto1']['name'])) {
					$foto1 = $_FILES['foto1']['name'];
					$beschr1 = $_POST['beschr1'];
					$ziel1 = "../". WST_IMAGESPFAD . $foto1;
					move_uploaded_file($_FILES['foto1']['tmp_name'], $ziel1);
				}

				if (isset($_FILES['foto2']['name'])) {
					$foto2 = $_FILES['foto2']['name'];
					$beschr2 = $_POST['beschr2'];
					$ziel2 = "../". WST_IMAGESPFAD . $foto2;
					move_uploaded_file($_FILES['foto2']['tmp_name'], $ziel2);
				}

				$sql_app = "UPDATE app
							SET de = '$status',
								produktionsvolumen = '$prod',
								qualitaetsvorgaben = '$quali',
								fertigungsziele = '$fert',
								besonderheiten = '$besonderheiten',
								kundennutzen = '$kundennutzen',
								aufspannungen = '$aufsp',
								bearbeiter = '$bearb',
								foto1 = '$foto1',
								beschr1 = '$beschr1',
								foto2 = '$foto2',
								beschr2 = '$beschr2',
								zuweisung_en = '$zuweisung_en'
							WHERE pub_nr_de = '$pub'";
				$ergebnis_app = mysqli_query($db, $sql_app) or die('Der Datenbank konnten keine Informationen übermittelt werden. Überprüfen Sie bitte Ihre Eingabe.');

				$sql_app_en = "INSERT INTO app_en (pub_nr_en) VALUES ('$pub')";
				$ergebnis_app_en = mysqli_query($db, $sql_app_en) or die('Der Datenbank konnten keine Informationen übermittelt werden. Überprüfen Sie bitte Ihre Eingabe.');

			}

			//if ($true) {
			if ($ergebnis_app) {


				$sql_user = "SELECT * FROM user WHERE ben_id = $zuweisung_en";
				$ergebnis_user = mysqli_query($db, $sql_user) or die('Es konnten keine Informationen über die User abgerufen werden. Bitte versuchen Sie es noch einmal.');
				$zeile_user =  mysqli_fetch_array($ergebnis_user);

				// E-Mail benachrichtigung
				include("mail_1.php");
				mail($an2, $betreff2, $inhalt2, 'From:' . $von2);
				mail($an3, $betreff3, $inhalt3, 'From:' . $von3);
			}
		}



          ?>


              <form enctype="multipart/form-data" action="app_edit_de.php?pub=<?php echo $pub; ?>" method="post">


                 <div id="left" >
                     <div id="box_2_col">

                          <img style="float:right;" src="../img/ger.png" width="20" height="11" />
                         <?php
							// Wenn ein Ergebnis vorhanden ist, also ein Werkstück erfolgreich angelegt wurde, dann soll anstatt des "anlegen"-Buttons ein "weiter"-Button erscheinen
							if ($ergebnis_app) {
								?><input type=button onClick="window.location.href='app_all.php'" value="weiter" class="grau" /><?php
									$feedback = 2;
							} else {
								?><input type="submit" name="submit" class="grau" value="speichern"/><?php
							}


						// Wenn nicht alle Felder ausgefüllt sind wird feedback auf true gesetzt und hier dann geprüft.
						if ($feedback == 1) {?>
							<div id="red" style="padding-top:10px;">Bitte alle Felder vollst&auml;ndig ausf&uuml;llen!</div>
						<?php }

						if ($feedback == 2) {?>
							<div id="green" style="padding-top:10px;" >Das Applikationsblatt (deutsch) wurde erfolgreich angelegt!</div>
						<?php } ?>

                          <!--Dieses Feld dient dazu dem Formular den pub wert mitzugeben, dazu wird er mit HIlfe der GET_Variable ausgelesen und dann oben mit POST wieder verwendet-->
                          <input name="pub" type="hidden" value="<?php echo $_GET['pub']; ?>"/>

                     </div>


                      <div id="box_2_col">
                        <table border="0">
                            <tr>
                                <td style="width:140px;">Werkstück </td>
                                <td><strong><?php echo $zeile_wst['bezeichnung']; ?></strong></td>
                            </tr>
                         </table>
                      </div>

                      <div id="box_2_col">
                        <table border="0">
                            <tr>
                                <td style="width:140px;">Werkstoff </td>
                                <td>
									<?php

										if( $zeile_wst['werkstoff'] == 1 ) {echo "Aluminium";}
										if( $zeile_wst['werkstoff'] == 2 ) {echo "Buntmetalle";}
										if( $zeile_wst['werkstoff'] == 3 ) {echo "Chromstahl";}
										if( $zeile_wst['werkstoff'] == 4 ) {echo "Gusseisen";}
										if( $zeile_wst['werkstoff'] == 5 ) {echo "Kunststoff";}
										if( $zeile_wst['werkstoff'] == 6 ) {echo "Magnesium";}
										if( $zeile_wst['werkstoff'] == 7 ) {echo "Sonstige";}
										if( $zeile_wst['werkstoff'] == 8 ) {echo "Stahl";}
										if( $zeile_wst['werkstoff'] == 9 ) {echo "Titan";}
									?>

                            </td>
                       </tr>
                       <tr>
                                <td><label <?php if ($fb_aufsp == 1) { echo 'class="red_fb"'; } ?> for="aufsp">Aufspannungen </label></td>
                                <td><input  id="aufsp" name="aufsp" class="element text small" type="text" size="15" maxlength="255" value="<?php echo $aufsp; ?>"/></td>
                        </tr>
                       <tr>
                                <td style="width:140px;">Stück/Stunde </td>
                                <td>
									<?php
										// Es werden alle Sekunden einer Stunde (3600) durch die Stückzeit/Sekunde berechnet und dann mit einer Nachkommastelle ausgegeben
										echo number_format((3600 / $zeile_wst['stueckzeit']), 1);
									?>
                                </td>
                        </tr>
                        <tr>
                                <td style="width:140px;">Technologie </td>
                                <td>
                                    <?php
										//Abfrage welche Bilder angezeigt werden sollen in PHP picto_info
										 include("picto_info_technologie.php");
									?>
                                </td>
                        </tr>
                        <tr>
                                <td style="width:140px;">Baureihe </td>
                                <td><div style="margin-left:-5px;">
									<?php
                                		//Abfrage welche Bilder angezeigt werden sollen in PHP picto_info
                            			 include("picto_info_baureihe.php");
									?></div>
                                </td>
                        </tr>
                       <tr>
                                <td style="width:140px;">Maschinentyp </td>
                                <td><?php echo $zeile_wst['maschtyp']; ?></td>
                        </tr>
                        <tr>
                                <td colspan="2"><label <?php if ($fb_besonderheiten == 1) { echo 'class="red_fb"'; } ?> for="besonderheiten" >Konstruktive Besonderheiten</label> <br />
												(max. 5 Punkte oder 240 Zeichen, Trennung durch Semikolon)<br />
                                    <textarea  id="besonderheiten" name="besonderheiten" cols="30" rows="3" value=""/><?php echo $besonderheiten; ?></textarea>
                                </td>
                        </tr>

                         </table>
                      </div>


                      <div id="box_2_col">
                        <table border="0">

                            <tr>
                                <td style="width:140px; ">Branche </td>
                                <td>
									<?php
                                		//Abfrage welche Bilder angezeigt werden sollen in PHP picto_info
                            			include("picto_info_branche.php");
									?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><label <?php if ($fb_kundennutzen == 1) { echo 'class="red_fb"'; } ?> for="kundennutzen">Kundennutzen</label><br />
                                (max. 5 Punkte oder 240 Zeichen, Trennung durch Semikolon)<br />
                                    <textarea  id="kundennutzen" name="kundennutzen" cols="30" rows="4" value=""/><?php echo $kundennutzen; ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td><label <?php if ($fb_prod == 1) { echo 'class="red_fb"'; } ?> for="prod">Produktionsvolumen </label></td>
                                <td><input  id="prod" name="prod" class="element text small" type="text" size="15" maxlength="255" value="<?php echo $prod; ?>"/></td>
                            </tr>
                            <tr>
                                <td colspan="2"><label <?php if ($fb_quali == 1) { echo 'class="red_fb"'; } ?> for="quali">Qualit&auml;tsvorgaben</label><br />
                                (max. 3 Punkte oder 150 Zeichen, Trennung durch Semikolon)<br />
                                    <textarea  id="quali" name="quali" cols="30" rows="1" value=""/><?php echo $quali; ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><label <?php if ($fb_fert == 1) { echo 'class="red_fb"'; } ?> for="fert">Fertigungsziele</label> <br />
                                (max. 3 Punkte oder 150 Zeichen, Trennung durch Semikolon)<br />
                                    <textarea  id="fert" name="fert" cols="30" rows="1" value=""/><?php echo $fert; ?></textarea>
                                </td>
                            </tr>


                        </table>
                      </div>

                      <div id="box_2_col" >
                        <table border="0">
                            <tr>
                                <td colspan="2">Weitere Bilder hochladen <br />
                                    <input name="foto1" type="file" size="20" accept="image/*" /><?php echo $foto1; ?></input>
                                </td>
                            </tr>

                            <!-- Nach Upload soll das Bild hier erscheinen-->
                            <tr>
                                <td>-----Bild 1------</td>
                            </tr>

                            <tr>
                                <td><input  id="beschr1" name="beschr1" class="element text small" type="text" size="20" maxlength="255" value="<?php echo $beschr1; ?>"/></td>
                                <td style="width:140px;"><label for="beschr1">Beschreibung Bild 1</label></td>
                            </tr>

                            <tr>
                                <td colspan="2"> <br />
                                    <input name="foto2" type="file" size="20" accept="image/*" /><?php echo $foto2; ?></input>
                                </td>
                            </tr>

                            <!-- Nach Upload soll das Bild hier erscheinen-->
                            <tr>
                                <td>-----Bild 2------</td>
                            </tr>

                            <tr>
                                <td><input  id="beschr2" name="beschr2" class="element text small" type="text" size="20" maxlength="255" value="<?php echo $beschr2; ?>"/>
                                </td><td style="width:140px;"><label for="beschr2">Beschreibung Bild 2 </label></td>
                            </tr>

                        </table>

                     </div>
                     <div id="box_2_col" >
                        <table border="0">

                           <tr>


                                <td style="width:140px;"><label <label <?php if ($fb_bearb == 1) { echo 'class="red_fb"'; } ?> for="bearb">Bearbeiter</label></td>
                                <td>
                                	<select style="margin-left:24px;" name="bearb" />
                                    <option value="">Bitte wählen</option>
                                    <?php
										// Hier sollen alle User aufgeführt werden die als Bearbeiter in Frage kommen, deshalb werden alle user aus tabelle:user
                                    	$sql_user_1 = "SELECT * FROM user";
										$ergebnis_user_1 = mysqli_query($db, $sql_user_1) or die('Es konnten keine Informationen über die User abgerufen werden. Bitte versuchen Sie es noch einmal.');


										while ($zeile_user_1 = mysqli_fetch_array($ergebnis_user_1)) {
											?><option value="<?php echo $zeile_user_1['ben_id'] ?>" <?php if( $_POST['bearb'] == $zeile_user_1['ben_id'] ) {echo "selected='selected'";} ?> > <?php echo $zeile_user_1['name'] ?></option><?php
										}

									?>
                            	</td>
                            </tr>
                            <tr>

                                <td style="width:140px;"><label <?php if ($fb_zuweisung_en == 1) { echo 'class="red_fb"'; } ?> for="zuweisung_en">zuweisen</label></td>
                                <td>
                                	<select style="margin-left:24px;" name="zuweisung_en" />
                                    <option value="">Bitte wählen</option>
                                    <?php
										// Hier sollen alle User aufgeführt werden die als Applikations-Zuweisung in Frage kommen, deshalb werden alle user aus tabelle:user
                                    	$sql_user_2 = "SELECT * FROM user";
										$ergebnis_user_2 = mysqli_query($db, $sql_user_2) or die('Es konnten keine Informationen über die User abgerufen werden. Bitte versuchen Sie es noch einmal.');


										while ($zeile_user_2 = mysqli_fetch_array($ergebnis_user_2)) {
											?><option value="<?php echo $zeile_user_2['ben_id'] ?>" <?php if( $_POST['zuweisung_en'] == $zeile_user_2['ben_id'] ) {echo "selected='selected'";} ?> > <?php echo $zeile_user_2['name'] ?></option><?php
										}

									?>
                            	</td>
                            </tr>


                        </table>

                     </div>


                 </div>

                  </form>



                  <div id="layer_right" style="height:1140px;"></div>






          <?php
				// ENDE IF SESSION
				}
			?>


</div>
