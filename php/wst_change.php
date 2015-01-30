<?php
/**
*	@project: Werkstück-Management CHIRON-WERKE GmbH & Co. KG
*	@author: Alexander Hipp
*	@date: 01.04.2012
*/

include("base.php");?>

<?php
	$feedback = 0;
?>


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

		<?php

				// Daten holen
				$lfd = $_GET['lfd'];
				$sql = "SELECT * FROM wst WHERE lfd_nr = '$lfd'";

				$ergebnis_get = mysqli_query($db, $sql) or die('Es konnten keine Informationen über das Werkstück abgerufen werden. Bitte versuchen Sie es noch einmal.');
				$zeile =  mysqli_fetch_array($ergebnis_get);


			if (isset($_POST['query_meg_codes'])) {
				//Variablen füllen
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
				$menge = $_POST['menge'];

				//Differenz der Menge muss auch für die aktuelle Menge errechnet werden und dann auch dort geändert werden.
				$menge_alt = $zeile['menge'];
				$menge_neu = $_POST['menge'];
				$menge_differenz_ohne_zeichen = abs($menge_neu - $menge_alt);

				if ($menge_neu < $menge_alt) {
					$menge_differenz = $menge_differenz_ohne_zeichen*(-1);
				} else {
					$menge_differenz = $menge_differenz_ohne_zeichen;
				}
				//Aktuelle Menge mit der Differenz verrechnen
				$menge_cur_neu = $zeile['menge_cur'] + $menge_differenz;



				//Radio Button Geheimhaltung
				if (($_POST['rohteil']) == '1') {
					$rohteil = 1;
				}
				if (($_POST['rohteil']) == '2') {
					$rohteil = 2;
				}

				$datum = $_POST['datum_change'];
				$aktiv = $_POST['aktiv'];
				$kunde = $_POST['kunde'];
				$maschnr = $_POST['maschnr'];
				$maschtyp = $_POST['maschtyp'];
				$stueckzeit = $_POST['stueckzeit'];
				$programmierer = $_POST['programmierer'];
				$werkstoff = $_POST["werkstoff"];

				//Hier wird geprüft ob ein neues Foto hochgeladen wurde oder ob man das alte benutzt
				$foto = $_FILES['foto']['name'];

				$kommentar = $_POST['kommentar'];
				$wst_change = $_POST['wst_change'];

				// Für Änderungs-Email
				$zuweisung_de = $zeile['zuweisung_de'];



				// Hier werden die jeweiligen Variablen gefüllt mit den Werten aus dem array query_meg_codes
				include("wst_edit_picto.php");


				// Überprüfung ob die Pflichtfelder ausgefüllt wurden
				if ($bezeichnung == "") { $fb_bezeichnung = 1; }
				if ($bezeichnung_en == "") { $fb_bezeichnung_en = 1; }
				if ($geheim == "") { $fb_geheim = 1; }
				if ($regal == "") { $fb_regal = 1; }
				if ($reihe == "") { $fb_reihe = 1; }
				if ($fach == "") { $fb_fach = 1; }
				if ($menge == "") { $fb_menge = 1; }
				if ($rohteil == "") { $fb_rohteil = 1; }
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

				if (($bezeichnung == "") OR ($bezeichnung_en == "") OR ($geheim == "") OR ($regal == "") OR ($reihe == "") OR ($fach == "")
				OR ($menge == "") OR ($rohteil == "") OR ($kunde == "") OR ($branche == "") OR ($technologie_1 == "") OR ($technologie_2 == "")
				OR ($technologie_3 == "") OR ($baureihe == "") OR ($maschtyp == "") OR ($maschnr == "") OR ($stueckzeit == "") OR ($programmierer == "") OR ($werkstoff == "")) { $feedback = 1; } else {

					// Die Bild-Datei in das Verzeichnis img
					$ziel = "../". WST_IMAGESPFAD . $foto;
					if ($foto != "") {
						move_uploaded_file($_FILES['foto']['tmp_name'], $ziel);
					}


					$sql = "UPDATE wst
							SET datum_alter = '$datum',
								bezeichnung = '$bezeichnung',
								bezeichnung_en = '$bezeichnung_en',
								geheim = '$geheim',
								regal = '$regal',
								reihe = '$reihe',
								fach = '$fach',
								menge = '$menge',
								menge_cur = '$menge_cur_neu',
								rohteil = '$rohteil',
								kunde = '$kunde',
								branche = '$branche',
								technologie_1 = '$technologie_1',
								technologie_2 = '$technologie_2',
								technologie_3 = '$technologie_3',
								technologie_4 = '$technologie_4',
								baureihe = '$baureihe',
								maschnr = '$maschnr',
								maschtyp = '$maschtyp',
								stueckzeit = '$stueckzeit',
								programmierer = '$programmierer',
								werkstoff = '$werkstoff',";
								if ($foto != "") {
									$sql .= "foto = '$foto',";
								}
								$sql .= "
								kommentar = '$kommentar',
								aktiv = '$aktiv'
							WHERE lfd_nr = '$lfd'";

					$ergebnis = mysqli_query($db, $sql)	or die('Der Datenbank konnten keine Informationen übermittelt werden. Überprüfen Sie bitte Ihre Eingabe.');

					if ($ergebnis) {
						$sql_user = "SELECT * FROM user WHERE ben_id = $zuweisung_de";
						$ergebnis_user = mysqli_query($db, $sql_user) or die('Es konnten keine Informationen über die User abgerufen werden. Bitte versuchen Sie es noch einmal.');
						$zeile_user =  mysqli_fetch_array($ergebnis_user);

						//include("mail_1.php");
						//mail($an5, $betreff5, $inhalt5, 'From:' . $email5);

					}
				}
			}


            ?>

        <div id="pagehead"><span>Werkstück bearbeiten</span></div>
        <form enctype="multipart/form-data" name="queryform" action="wst_change.php?lfd=<?php echo $lfd; ?>" method="post" class="mdbpriv1" onsubmit="return gf_onsubmit_set_meg()">

        <div id="box">


              <?php

                if ($ergebnis) {
					?>
						<script type="text/javascript">
							location.href="wst_change.php?lfd=<?php echo $lfd; ?>";
						</script>
					<?php
   				} else {
					?>
                    	<input type=button onClick="window.location.href='wst_info.php?lfd=<?php echo $lfd; ?>'" value="zum Werkstück" class="grau" />
                      <a href="javascript:gf_onsubmit_set_meg();document.queryform.submit();" rel="nofollow"><input name="wst_change" type="submit"  value="speichern" class="grau" /></a>
											<div>
													<select style="float:right;" name="aktiv" >
														<option value="0" <?php if( $zeile['aktiv'] == 0 ) {echo "selected='selected'";}?> >deaktivieren</option>
														<option value="1" <?php if( $zeile['aktiv'] == 1 ) {echo "selected='selected'";}?> >aktiv</option>
													</select>
											</div>
					<?php
				}

				// Wenn nicht alle Felder ausgefüllt sind wird feedback auf true gesetzt und hier dann geprüft.
				if ($feedback == 1) {?>
					<div id="red" style="padding-top:10px;">Bitte alle Felder vollst&auml;ndig ausf&uuml;llen!</div>
				<?php }  ?>

        </div>
        <div id="box_2_col" style="height:78px; float:left;">
            <table border="0">
               <tr>
                    <td><label <?php if ($fb_bezeichnung == 1) { echo 'class="red_fb"'; } ?> for="bezeichnung">Bezeichnung </label></td>
                    <td><input style="margin-left:35px;" id="bezeichnung" name="bezeichnung" class="element text medium" type="text" maxlength="255" value="<?php echo $zeile['bezeichnung']; ?>"/></td>
                </tr>
                <tr>
                    <td><label <?php if ($fb_bezeichnung_en == 1) { echo 'class="red_fb"'; } ?> for="bezeichnung_en">engl. </label></td>
                    <td><input style="margin-left:35px;" id="bezeichnung_en" name="bezeichnung_en" class="element text medium" type="text" maxlength="255" value="<?php echo $zeile['bezeichnung_en']; ?>"/></td>
                </tr>
                <tr>
                    <td><label for="geheim"></label></td>
                    <td><input style="margin-left:35px;" id="ja" name="geheim" type="radio" <?php
                    // Wenn ein Feld nicht ausgefüllt wurde und der Nutzer dieses ergänzen soll, muss hier geprüft werden, welcher Radiobutton zuvor schon geklickt wurde
                    if( $zeile['geheim'] == 1 ) { echo "checked='checked'"; } ?>  value="1"> <a <?php if ($fb_geheim == 1) { echo 'class="red_fb"'; } ?> >geheim</a>
                        <input style="margin-left:10px;" id="nein" name="geheim" type="radio" <?php if( $zeile['geheim'] == 2 ) {echo "checked='checked'";}?> value="2"/> <a <?php if ($fb_geheim == 1) { echo 'class="red_fb"'; } ?> >frei</a></td>
                </tr>
            </table>
        </div>

        <div id="box_2_col" style="float:right;">
        	<table border="0">
                <tr>
                    <td><label <?php if (($fb_regal == 1) OR ($fb_reihe == 1) OR ($fb_fach == 1)) { echo 'class="red_fb"'; } ?> for="lagerort">Lagerort </label></td>
                    <td>
                        <input style="margin-left:35px;" id="lagerort" name="regal" class="element text small" type="text" size="1" maxlength="3" value="<?php echo $zeile['regal']; ?>"/> /
                        <input id="lagerort" name="reihe" class="element text small" type="text" size="1" maxlength="3" value="<?php echo $zeile['reihe']; ?>"/> /
                        <input id="lagerort" name="fach" class="element text small" type="text" size="1" maxlength="3" value="<?php echo $zeile['fach']; ?>"/>
                    </td>
                </tr>
                <tr>
                    <td><label <?php if ($fb_menge == 1) { echo 'class="red_fb"'; } ?> for="menge">Menge </label></td>
                    <td>
                        <input style="margin-left:35px;" id="menge" name="menge" class="element text small" type="text" size="1" maxlength="2" value="<?php echo $zeile['menge']; ?>"/>

                    </td>
                </tr>
                <tr>
                    <td><label <?php if ($fb_rohteil == 1) { echo 'class="red_fb"'; } ?> for="rohteil">Rohteil vorhanden</label></td>
                    <td><input style="margin-left:35px;" id="ja" name="rohteil" type="radio" value="1"

                    <?php
                        // Wenn ein Feld nicht ausgefüllt wurde und der Nutzer dieses ergänzen soll, muss hier geprüft werden, welcher Radiobutton zuvor schon geklickt wurde
                        if( $zeile['rohteil'] == 1 ) {
                                echo "checked='checked'";
                              }
                    ?>
                /> ja
                        <input style="margin-left:12px;" id="nein" name="rohteil" type="radio" value="2" <?php
                        // Wenn ein Feld nicht ausgefüllt wurde und der Nutzer dieses ergänzen soll, muss hier geprüft werden, welcher Radiobutton zuvor schon geklickt wurde
                        if( $zeile['rohteil'] == 2 ) {
                                echo "checked='checked'";
                              }
                    ?> /> nein</td>
                </tr>
        	</table>
        </div>

        <div id="box" style="clear:both;">

                      <table border="0">
                      		<tr>

                                <td><label for="datum_change">Datum</label></td>
                                <td>
                                    <input style="margin-left:62px;" id="datum_change" name="datum_change" class="element text small" type="text" size="8" value="<?php echo $zeile['datum_alter']; ?>"/>
                                </td>
                            </tr>


                            <tr>
                                <td><label <?php if ($fb_kunde == 1) { echo 'class="red_fb"'; } ?> for="kunde">Kunde </label></td>
                                <td><input style="margin-left:62px;" id="kunde" name="kunde" class="element text medium" type="text" maxlength="255" value="<?php echo $zeile['kunde']; ?>"/></td>
                            </tr>
                            <tr>
                            	<!-- Dieses Feld wird benötigt- um die Piktogramme auszulesen -->
                                <input name="query_meg_codes" id="meg_codes" type="hidden">

                            <td><label <?php if ($fb_branche == 1) { echo 'class="red_fb"'; } ?> for="branche">Branche </label></td>

						    <?php
                            	include("picto.php");
							?>

                            <td style="padding-left:63px;"colspan="3">
                                    <input type="hidden">
                                    <div id="meg201" class="meg_btn btngrp_MEG02
									<?php if( $zeile['branche'] == 201 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="gf_toggle_btn_with_ddlb('#meg201', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_201_4multistate.png)" title="Aerospace"></div>
                                    <div id="meg202" class="meg_btn btngrp_MEG02
									<?php if(( $zeile['branche'] == 202 ) OR ( $zeile['branche'] == 20201 ) OR ( $zeile['branche'] == 20202 ) OR ( $zeile['branche'] == 20203 ) OR ( $zeile['branche'] == 20204 ) OR ( $zeile['branche'] == 20205 ) OR ( $zeile['branche'] == 20206 ) OR ( $zeile['branche'] == 20207 ) OR ( $zeile['branche'] == 20208 ) OR ( $zeile['branche'] == 20209 )) {  echo "meg_btn_pushed";
									} ?>
                                    " onClick="gf_toggle_btn_with_ddlb('#meg202', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_202_4multistate.png)" title="Automotive"></div>
                                    <div id="meg203" class="meg_btn btngrp_MEG02
									<?php if( $zeile['branche'] == 203 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="gf_toggle_btn_with_ddlb('#meg203', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_203_4multistate.png)" title="Medical"></div>
                                    <div id="meg204" class="meg_btn btngrp_MEG02
									<?php if(( $zeile['branche'] == 204 ) OR ( $zeile['branche'] == 20401 ) OR ( $zeile['branche'] == 20402 ) OR ( $zeile['branche'] == 20403 )) {echo "meg_btn_pushed";} ?>
                                    " onClick="gf_toggle_btn_with_ddlb('#meg204', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_204_4multistate.png)" title="Mechanical Engineering"></div>
                                    <div id="meg205" class="meg_btn btngrp_MEG02
									<?php if(( $zeile['branche'] == 205 ) OR ( $zeile['branche'] == 20501 ) OR ( $zeile['branche'] == 20502 ) OR ( $zeile['branche'] == 20503 ) OR ( $zeile['branche'] == 20504 )) {echo "meg_btn_pushed";} ?>
                                    " onClick="gf_toggle_btn_with_ddlb('#meg205', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_205_4multistate.png)" title="Precision Technology"></div>





                                      <?php if(( $zeile['branche'] == 202 ) OR ( $zeile['branche'] == 20201 ) OR ( $zeile['branche'] == 20202 ) OR ( $zeile['branche'] == 20203 ) OR ( $zeile['branche'] == 20204 ) OR ( $zeile['branche'] == 20205 ) OR ( $zeile['branche'] == 20206 ) OR ( $zeile['branche'] == 20207 ) OR ( $zeile['branche'] == 20208 ) OR ( $zeile['branche'] == 20209 )) {

									 echo '      <select name="aerospace" size="1" id="meg202_ddlb" class="meg_ddlb ddlbgrp_MEG02" >';

									}
									  else
									  {
       	   								echo '       <select name="aerospace" size="1" id="meg202_ddlb" class="meg_ddlb ddlbgrp_MEG02" style="display:none">';

									 }
                                    ?>


                                    <option></option>

                                    <option value="20201" <? if ($zeile['branche'] == 20201 ) { echo "selected = selected" ;} ?>>Antriebsstrang</option>
                                    <option value="20202" <? if ($zeile['branche'] == 20202 ) { echo "selected = selected" ;} ?>>Bremssysteme</option>
                                    <option value="20203" <? if ($zeile['branche'] == 20203 ) { echo "selected = selected" ;} ?>>Klima- &amp; L&uuml;ftungssysteme</option>
                                    <option value="20204" <? if ($zeile['branche'] == 20204 ) { echo "selected = selected" ;} ?>>Kraftstoffsysteme</option>
                                    <option value="20205" <? if ($zeile['branche'] == 20205 ) { echo "selected = selected" ;} ?>>Abgassysteme</option>
                                    <option value="20206" <? if ($zeile['branche'] == 20206 ) { echo "selected = selected" ;} ?>>Felgen</option>
                                    <option value="20207" <? if ($zeile['branche'] == 20207 ) { echo "selected = selected" ;} ?>>Motor &amp; Aggregate</option>
                                    <option value="20208" <? if ($zeile['branche'] == 20208 ) { echo "selected = selected" ;} ?>>Lenk- &amp; Fahrwerksysteme</option>
                                    <option value="20209" <? if ($zeile['branche'] == 20209 ) { echo "selected = selected" ;} ?>>Karosserieteile</option>
                                    </select>



                                        <?php if(( $zeile['branche'] == 204 ) OR ( $zeile['branche'] == 20401 ) OR ( $zeile['branche'] == 20402 ) OR ( $zeile['branche'] == 20403 )) {

									 echo '    <select name="" size="1" id="meg204_ddlb" class="meg_ddlb ddlbgrp_MEG02"> ';

									}
									  else
									  {
       	   								echo '      <select name="" size="1" id="meg204_ddlb" class="meg_ddlb ddlbgrp_MEG02" style="display:none">';

									 }
                                    ?>


                                    <option></option>
                                    <option value="20401" <? if ($zeile['branche'] == 20401 ) { echo "selected = selected" ;} ?>>Armaturen</option>
                                    <option value="20402" <? if ($zeile['branche'] == 20402 ) { echo "selected = selected" ;} ?>>Werkzeuge &amp; Ger&auml;te</option>
                                    <option value="20403" <? if ($zeile['branche'] == 20503 ) { echo "selected = selected" ;} ?>>Maschinenbau</option>

                                    </select>


                                      <?php if(( $zeile['branche'] == 205 ) OR ( $zeile['branche'] == 20501 ) OR ( $zeile['branche'] == 20502 ) OR ( $zeile['branche'] == 20503 ) OR ( $zeile['branche'] == 20504 )) {

									 echo '   <select name="" size="1" id="meg205_ddlb" class="meg_ddlb ddlbgrp_MEG02" > ';

									}
									  else
									  {
       	   								echo '    <select name="" size="1" id="meg205_ddlb" class="meg_ddlb ddlbgrp_MEG02" style="display:none">';

									 }
                                    ?>




                                    <option></option>
                                    <option value="20501" <? if ($zeile['branche'] == 20501 ) { echo "selected = selected" ;} ?>>Elektrik &amp; Elektronik</option>
                                    <option value="20502" <? if ($zeile['branche'] == 20502 ) { echo "selected = selected" ;} ?>>Beschl&auml;ge &amp; Schlie&szlig;systeme</option>
                                    <option value="20503" <? if ($zeile['branche'] == 20503 ) { echo "selected = selected" ;} ?>>Uhren, Schmuck &amp; Optik</option>
                                    <option value="20504" <? if ($zeile['branche'] == 20504 ) { echo "selected = selected" ;} ?>>Wehrtechnik</option>
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
                                    <div class="meg_subgroup" id="MEG_SUBGROUP_MEG01_0">
                                    <div id="meg101" class="meg_btn
                                    <?php if( $zeile['technologie_1'] == 101 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg101').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_101_4multistate.png)" title="FZ Einspindel"></div>
                                    <div id="meg102" class="meg_btn
                                    <?php if( $zeile['technologie_1'] == 102 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg102').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_102_4multistate.png)" title="FZ Doppelspindel"></div>
                                    <div id="meg103" class="meg_btn
                                    <?php if( $zeile['technologie_1'] == 103 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg103').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_103_4multistate.png)" title="FZ Vierspindel"></div>
                                    <div id="meg104" class="meg_btn
                                    <?php if( $zeile['technologie_1'] == 104 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg104').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_104_4multistate.png)" title="NC-Schwenkkopf"></div>
                                    </div>

                                    <div class="meg_subgroup" id="MEG_SUBGROUP_MEG01_1">
                                    <div id="meg111" class="meg_btn
                                    <?php if( $zeile['technologie_2'] == 111 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg111').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_111_4multistate.png)" title="Korb-Werkzeugwechsler"></div>
                                    <div id="meg112" class="meg_btn
                                    <?php if( $zeile['technologie_2'] == 112 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg112').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_112_4multistate.png)" title="Ketten-Werkzeugwechsler"></div>
                                    </div>

                                    <div class="meg_subgroup" id="MEG_SUBGROUP_MEG01_2">
                                    <div id="meg121" class="meg_btn
                                    <?php if( $zeile['technologie_3'] == 121 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg121').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_121_4multistate.png)" title="Starrtisch"></div>
                                    <div id="meg122" class="meg_btn
                                    <?php if( $zeile['technologie_3'] == 122 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg122').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_122_4multistate.png)" title="Werkst&uuml;ckwechseleinrichtung"></div>
                                    <div id="meg123" class="meg_btn
                                    <?php if( $zeile['technologie_3'] == 123 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg123').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_123_4multistate.png)" title="Five axis"></div>
                                    <div id="meg124" class="meg_btn
                                    <?php if( $zeile['technologie_3'] == 124 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg124').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_124_4multistate.png)" title="Langbett"></div>
                                    </div>

                                    <div class="meg_subgroup" id="MEG_SUBGROUP_MEG01_3">
                                    <div id="meg131" class="meg_btn
                                    <?php if( $zeile['technologie_4'] == 131 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg131').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_131_4multistate.png)" title="Stangen-Bearbeitung"></div>
                                    <div id="meg132" class="meg_btn
                                    <?php if( $zeile['technologie_4'] == 132 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg132').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_132_4multistate.png)" title="MPS"></div>
                                    <div id="meg133" class="meg_btn
                                    <?php if( $zeile['technologie_4'] == 133 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg133').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_133_4multistate.png)" title="WM Felgenbearbeitung"></div>
                                    <div id="meg141" class="meg_btn
                                    <?php if( $zeile['technologie_4'] == 141 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg141').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_141_4multistate.png)" title="Automation"></div>
                                    </div>
                                    </div>
                            	</td>
                            </tr>


                            <tr>
                            	<td><label <?php if ($fb_baureihe == 1) { echo 'class="red_fb"'; } ?> for="baureihen">Baureihen </label></td>
                                <td style="padding-left:25px;" colspan="3">
                                    <div id="meg401" class="meg_btn
									<?php if( $zeile['baureihe'] == 401 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg401').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_401_4multistate.png)" title="08"></div>
                                    <div id="meg402" class="meg_btn
									<?php if( $zeile['baureihe'] == 402 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg402').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_402_4multistate.png)" title="12"></div>
                                    <div id="meg403" class="meg_btn
									<?php if( $zeile['baureihe'] == 403 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg403').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_403_4multistate.png)" title="15"></div>
                                    <div id="meg404" class="meg_btn
									<?php if( $zeile['baureihe'] == 404 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg404').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_404_4multistate.png)" title="18"></div>

                                    <div id="meg407" class="meg_btn
									<?php if( $zeile['baureihe'] == 407 ) {echo "meg_btn_pushed";} ?>
                                    " onClick="$('#meg407').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_407_4multistate.png)" title="24"></div>

																		<div id="meg408" class="meg_btn
									<?php if( $zeile['baureihe'] == 408 ) {echo "meg_btn_pushed";} ?>
																		" onClick="$('#meg408').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_408_4multistate.png)" title="26"></div>

																		<div id="meg405" class="meg_btn
									<?php if ($zeile['baureihe'] == 405 ) {echo "meg_btn_pushed";} ?>
																		" onClick="$('#meg405').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_405_4multistate.png)" title="MILL"></div>

																		<div id="meg409" class="meg_btn
									<?php if( $zeile['baureihe'] == 409 ) {echo "meg_btn_pushed";} ?>
																		" onClick="$('#meg409').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_409_4multistate.png)" title="H"></div>


                                </td>
                        	</tr>
                            <tr>
                                <td><label <?php if ($fb_maschtyp == 1) { echo 'class="red_fb"'; } ?> for="maschtyp">Maschinen-Typ </label></td>
                                <td><input style="margin-left:24px;" id="maschtyp" name="maschtyp" class="element text medium" type="text"  maxlength="255" value="<?php echo $zeile['maschtyp']; ?>"/></td>
                            </tr>
                            <tr>
                                <td><label <?php if ($fb_maschnr == 1) { echo 'class="red_fb"'; } ?> for="maschnr">Maschinen-Nr. </label></td>
                                <td><input style="margin-left:24px;" id="maschnr" name="maschnr" class="element text medium" type="text" size="7" maxlength="255" value="<?php echo $zeile['maschnr']; ?>"/></td>
                            </tr>
                            <tr>
                                <td><label <?php if ($fb_stueckzeit == 1) { echo 'class="red_fb"'; } ?> for="stueckzeit">St&uuml;ckzeit </label></td>
                                <td><input style="margin-left:24px;" id="stueckzeit" name="stueckzeit" class="element text medium" type="text"  size="7" maxlength="255" value="<?php echo $zeile['stueckzeit']; ?>"/></td>
                            </tr>
                            <tr>
                                <td><label<?php if ($fb_programmierer == 1) { echo 'class="red_fb"'; } ?> for="programmierer">Programmierer </label></td>
                                <td><input style="margin-left:24px;" id="programmierer" name="programmierer" class="element text medium" type="text" maxlength="255" value="<?php echo $zeile['programmierer']; ?>"/></td>
                            </tr>

                            <tr>
                                <td><label <?php if ($fb_werkstoff == 1) { echo 'class="red_fb"'; } ?> for="werkstoff">Werkstoff </label></td>
                                <td>
                                    <select style="margin-left:24px;" name="werkstoff" >
                                    <option value="0" <?php if( $zeile['werkstoff'] == 0 ) {echo "selected='selected'";}?> >Bitte wählen</option>
                                    <option value="1" <?php if( $zeile['werkstoff'] == 1 ) {echo "selected='selected'";}?> >Aluminium</option>
                                    <option value="2" <?php if( $zeile['werkstoff'] == 2 ) {echo "selected='selected'";}?> >Buntmetalle</option>
                                    <option value="3" <?php if( $zeile['werkstoff'] == 3 ) {echo "selected='selected'";}?> >Stahl</option>
                                    <option value="4" <?php if( $zeile['werkstoff'] == 4 ) {echo "selected='selected'";}?> >Gußeisen</option>
                                    <option value="5" <?php if( $zeile['werkstoff'] == 5 ) {echo "selected='selected'";}?> >Kunststoff</option>
                                    <option value="6" <?php if( $zeile['werkstoff'] == 6 ) {echo "selected='selected'";}?> >Sonstige</option>
                                    <option value="7" <?php if( $zeile['werkstoff'] == 7 ) {echo "selected='selected'";}?> >Magnesium</option>
                                    <option value="8" <?php if( $zeile['werkstoff'] == 8 ) {echo "selected='selected'";}?> >(kein)</option>
                                </td>
                             </tr>
                      </table>
         	</div>

        	<div id="box">

                <label <?php if ($fb_foto == 1) { echo 'class="red_fb"'; } ?> for="Bild">Bild </label>
                <input type="file" id="foto" name="foto" style="margin-left:90px;"/></input>
                <br/>
                <?php echo $zeile['foto']; ?>
            </div>

            <div id="box">
                <table border="0">
                    <tr>
                        <td><label  for="kommentar">Kommentar </label></td>
                        <td  style="padding-left:19px;" colspan="3"><textarea style="margin-left:25px;" id="kommentar" name="kommentar" cols="30" rows="2" value""><?php echo $zeile['kommentar']; ?></textarea></td>
                    </tr>
                </table>
            </div>
        <form>
           <?php
			}

			?>



      </div>

</div>
