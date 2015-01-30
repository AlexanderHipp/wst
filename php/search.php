<?php
/**
*	@project: Werkstück-Management CHIRON-WERKE GmbH & Co. KG
*	@author: Alexander Hipp
*	@date: 01.04.2012
*/


include("base.php");
include('calendar/classes/tc_calendar.php'); ?>

<div id="page">
	<div id="heading"></div>

    <?php
		// Hier wird geprüft ob schon eine Anmeldung erfolgt ist
		if (!isset($_SESSION['ben_id'])) {
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
          <div id="pagehead"><span><?php if ($la == en) {echo 'Search';} else {echo 'Suche';} ?></span></div>

               <form name="queryform" action="<?php echo $_SERVER['PHP_SELF'];?>" method="get" class="mdbpriv1" onSubmit="return gf_onsubmit_set_meg()">
                  <div id="box">


                      <a href="javascript:gf_onsubmit_set_meg();document.queryform.submit();" rel="nofollow"><input name="starten" type="submit" class="grau" value="<?php if ($la == en) {echo 'Start search';} else {echo 'Suche starten';} ?>"/></a>


                      <!--<input name="leeren" type="reset" class="grau" value="<?php if ($la == en) {echo 'Empty fields';} else {echo 'Felder leeren';} ?>"/>-->


                      <!--BENUTZERRECHTE ADMIN-->
                      <?php
					  if ($_SESSION['rolle'] == 1) {
                      	?><input name="anlegen" type=button onClick="window.location.href='wst_edit.php'" class="grau" value="<?php if ($la == en) {echo 'Edit workpiece';} else {echo 'Werkstück anlegen';} ?>"/><?php
					  }?>
                  </div>

                  <div id="box">
                  	<table border="0">
                        <tr>
                            <td><label for="werkstueck"><?php if ($la == en) {echo 'Workpiece';} else {echo 'Werkstück';} ?></label></td>
                            <td><input style="margin-left:10px;" id="werkstueck" name="suche_wst" class="element text medium" type="text" maxlength="255" value="<?php echo $_GET['suche_wst'] ?>"/></td>



                            <td><label style="margin-left:50px;" for="kunde"><?php if ($la == en) {echo 'Customer';} else {echo 'Kunde';} ?></label></td>
                            <td><input style="margin-left:10px;" id="kunde" name="s_k" class="element text medium" type="text" maxlength="255" value="<?php echo $_GET['s_k'] ?>"/></td>
                        </tr>


                        <tr>
                            <td><label for="werkstoff"><?php if ($la == en) {echo 'Material';} else {echo 'Werkstoff';} ?> </label></td>
                            <td><select style="margin-left:10px;" name="s_w" >

                                <option value=""  <?php if( $_GET['s_w'] == 0 ) {echo "selected='selected'";} ?> > <?php if ($la == en) {echo 'Choose';} else {echo 'Bitte wählen';} ?></option>
                                <option value="1" <?php if( $_GET['s_w'] == 1 ) {echo "selected='selected'";} ?> > <?php if ($la == en) {echo 'Aluminum';} else {echo 'Aluminium';} ?></option>
                                <option value="2" <?php if( $_GET['s_w'] == 2 ) {echo "selected='selected'";} ?> > <?php if ($la == en) {echo 'Non-ferrous metals';} else {echo 'Buntmetalle';} ?></option>
                                <option value="3" <?php if( $_GET['s_w'] == 3 ) {echo "selected='selected'";} ?> > <?php if ($la == en) {echo 'Steel';} else {echo 'Stahl';} ?></option>
                                <option value="4" <?php if( $_GET['s_w'] == 4 ) {echo "selected='selected'";} ?> > <?php if ($la == en) {echo 'Cast iron';} else {echo 'Gußeisen';} ?></option>
                                <option value="5" <?php if( $_GET['s_w'] == 5 ) {echo "selected='selected'";} ?> > <?php if ($la == en) {echo 'Plastic';} else {echo 'Kunststoff';} ?></option>
                                <option value="6" <?php if( $_GET['s_w'] == 6 ) {echo "selected='selected'";} ?> > <?php if ($la == en) {echo 'Other';} else {echo 'Sonstige';} ?></option>
                                <option value="7" <?php if( $_GET['s_w'] == 7 ) {echo "selected='selected'";} ?> > <?php if ($la == en) {echo 'Magnesium';} else {echo 'Magnesium';} ?></option>
                                <option value="8" <?php if( $_GET['s_w'] == 8 ) {echo "selected='selected'";} ?> > <?php if ($la == en) {echo '(no)';} else {echo '(kein)';} ?></option>
                               </select>

                            </td>
                            <td><label style="margin-left:50px;" for="mnummer"><?php if ($la == en) {echo 'Machine No.';} else {echo 'Maschinen-Nr.';} ?> </label></td>
                            <td><input style="margin-left:10px;" id="mnummer" name="s_mn" class="element text medium" type="text" maxlength="255" value="<?php echo $_GET['s_mn'] ?>"/></td>
                        </tr>

                  		<tr>
                            <td><label for="geheim"></label></td>
                            <td>


															<?php
																// Administrator
																if($_SESSION['rolle'] != "4") {
																	?>
																	<input style="margin-left:12px;" id="ja" name="suche_geheim" type="radio" value="1"	<?php if( $_GET['suche_geheim'] == 1) { echo "checked='checked'"; } ?> /> <?php if ($la == en) {echo 'confidental';} else {echo 'geheim';} ?>
																	<?php
																}
															?>

															<input style="margin-left:12px;" id="nein" name="suche_geheim" type="radio" value="2" <?php if( ( $_GET['suche_geheim'] == 2 ) OR ($_SESSION['rolle'] == "4") ) { echo "checked='checked'";}?> /> <?php if ($la == en) {echo 'free';} else {echo 'frei';} ?>


														</td>
														<td><label style="margin-left:50px;" for="lfdnr"><?php if ($la == en) {echo 'Number';} else {echo 'Lfd-Nr';} ?></label></td>
														<td><input style="margin-left:10px;" id="lfdnr" name="suche_lfdnr" class="element text medium" type="text" maxlength="255" value="<?php echo $_GET['suche_lfdnr'] ?>"/></td>
														</tr>



														<tr><td>&nbsp;</td></tr>
														<input name="query_meg_codes" id="meg_codes" type="hidden">




														<tr>
														<td><label for="branche"><?php if ($la == en) {echo 'Industry';} else {echo 'Branche';} ?> </label></td>

														<?php
														include("picto.php");
														?>

                            <td   style="padding-left:10px;"colspan="3">

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


	                            <select name="" size="1" id="meg202_ddlb" class="meg_ddlb ddlbgrp_MEG02" style="display:none">
	                            <option value="202">alle</option>

	                            <option value="20201">Antriebsstrang</option>
	                            <option value="20202">Bremssysteme</option>
	                            <option value="20203">Klima- &amp; L&uuml;ftungssysteme</option>
	                            <option value="20204">Kraftstoffsysteme</option>
	                            <option value="20205">Felgen</option>
	                            <option value="20206">Motor &amp; Aggregate</option>

	                            <option value="20207">Lenk- &amp; Fahrwerksysteme</option>
	                            <option value="20208">Karosserieteile</option>
	                            </select>

	                            <select name="" size="1" id="meg204_ddlb" class="meg_ddlb ddlbgrp_MEG02" style="display:none">
	                            <option value="204">alle</option>
	                            <option value="20401">Armaturen</option>
	                            <option value="20402">Werkzeuge &amp; Ger&auml;te</option>
	                            <option value="20403">Maschinenbau</option>
	                            <option value="20404">Zusatzinformationen</option>
	                            </select>

	                            <select name="" size="1" id="meg205_ddlb" class="meg_ddlb ddlbgrp_MEG02" style="display:none">
	                            <option value="205">alle</option>
	                            <option value="20501">Elektrik &amp; Elektronik</option>
	                            <option value="20502">Beschl&auml;ge &amp; Schlie&szlig;systeme</option>
	                            <option value="20503">Uhren, Schmuck &amp; Optik</option>
	                            </select>

                       	  </td>
                      </tr>

                        <tr>


                            <td><label  for="technologie"><?php if ($la == en) {echo 'Technology';} else {echo 'Technologie';} ?> </label></td>
                            <td  style="padding-left:10px;" colspan="3">
								<input type="hidden"><div class="meg_group" id="MEG_GROUP_MEG01">

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


                            <tr>
                            	<td><label for="baureihen"><?php if ($la == en) {echo 'Series';} else {echo 'Baureihe';} ?> </label></td>
                                <td style="padding-left:10px;" colspan="3">


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
													<tr><td>&nbsp;</td></tr>
													<tr>

														<td colspan="2">
															<label for="date_check"><?php if ($la == en) {echo 'Include Period';} else {echo 'Zeitraum berücksichtigen';} ?> </label>
															<input style="margin-left:25px;" id="date_check" name="date_check" type="checkbox" value="1" <?php if (!empty($_GET['date_check'])) {echo ' checked';} ?> />
														</td>
													</tr>

													<tr>

														<td colspan="2">
															<div style="float: left; margin-right:10px; margin-left:20px;">
																<div style="float: left; padding-right: 10px; line-height: 18px;"><?php if ($la == en) {echo 'from';} else {echo 'von';} ?> </div>
																<div style="float: left;">
																	<?php
																		$myCalendar = new tc_calendar("datea", true, false);
																		$myCalendar->setIcon("calendar/images/iconCalendar.gif");
																		$myCalendar->setPath("calendar/");
																		$myCalendar->setYearInterval(2006, 2020);
																		$myCalendar->setAlignment('left', 'bottom');
																		$myCalendar->setDatePair('date5', 'date6', $date8);
																		$myCalendar->startMonday(true);
																		$tmp_datea = $_GET['datea'];
																		$tmp_datea_arr = explode("-", $tmp_datea);
																		$myCalendar->setDate($tmp_datea_arr[2], $tmp_datea_arr[1], $tmp_datea_arr[0]);
																		$myCalendar->writeScript();

																	?>

																</div>
															</div>
															<div style="float: left; margin-right:10px;">
																<div style="float: left; padding-left: 10px; padding-right: 10px; line-height: 18px;"><?php if ($la == en) {echo 'to';} else {echo 'bis';} ?> </div>
																<div style="float: left;">
																	<?php
																		$myCalendar = new tc_calendar("dateb", true, false);
																		$myCalendar->setIcon("calendar/images/iconCalendar.gif");
																		$myCalendar->setPath("calendar/");
																		$myCalendar->setYearInterval(2006, 2020);
																		$myCalendar->setAlignment('left', 'bottom');
																		$myCalendar->setDatePair('date5', 'date6', $date7);
																		$myCalendar->startMonday(true);
																		$tmp_dateb = $_GET['dateb'];
																		$tmp_dateb_arr = explode("-", $tmp_dateb);
																		$myCalendar->setDate($tmp_dateb_arr[2], $tmp_dateb_arr[1], $tmp_dateb_arr[0]);
																		$myCalendar->writeScript();

																	?>

																</div>
															</div>
														</td>
													</tr>

                 </table>

                  </div>


                  <?php



					//Wenn suche ausgeführt wird
					if (isset($_GET['query_meg_codes'])) {

						// Texteingabe einer Variable zuordnen
						$suchtext_wst = $_GET['suche_wst'];
						$suchtext_kunde = $_GET['s_k'];
						$suchtext_mnummer = $_GET['s_mn'];
						$suchtext_werkstoff = $_GET['s_w'];
						$suchtext_geheim = $_GET['suche_geheim'];
						$suchtext_lfdnr = $_GET['suche_lfdnr'];
						$von = strtotime($_GET['datea']);
						$bis = strtotime($_GET['dateb']);



						// Hier steckt die Funktion dahinter die den MySQL_String für die Abfrage zusammenbastelt
						include("function_abfrage_aufbauen.php");

						// Hier werden die jeweiligen Variablen gefüllt mit den Werten aus dem array query_meg_codes
						include("picto.php");

						//Funktion abfrage_aufbauen wird aufgerufen. siehe ganz oben im Skripten. + Übergabe der Parameter in der KLammer
						$sql_wst = abfrage_aufbauen($suchtext_wst, $suchtext_kunde, $suchtext_mnummer, $suchtext_werkstoff, $suchtext_geheim, $suchtext_lfdnr, $branche, $technologie_1, $technologie_2, $technologie_3, $technologie_4, $baureihe);

						if (strlen($sql_wst)!=17) {
							$sql_wst .=  ' AND ( aktiv = 1)';
						} else {
							$sql_wst = "SELECT * FROM wst WHERE aktiv = 1";
						}


						$ergebnis_wst = mysqli_query($db, $sql_wst) or die('Es konnte keine Suche durchgeführt werden. Bitte starten Sie eine neue Suchanfrage.');




							while ($zeile_wst = mysqli_fetch_array($ergebnis_wst)) {

								$show_wst = 1;
								if (!empty($_GET['date_check'])) {
									$show_wst = 0;
									if ($zeile_wst['datum_alter']!="") {
										if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$zeile_wst['datum_alter']))
										{
											$zeitpunkt = strtotime($zeile_wst['datum_alter']);
										}else{
											$zeitpunkt = strtotime($zeile_wst['erstellungsdatum']);
										}
									} else {
										$zeitpunkt = strtotime($zeile_wst['erstellungsdatum']);
									}

									if (($zeitpunkt >= $von) && ($zeitpunkt <= $bis)) {
											$show_wst = 1;
									}


								}

								if ($show_wst == 1) {

								 ?>

	              <div id="box_erg">

								<div id="picture_small"><img src="../img/<?php echo $zeile_wst['foto']; ?>" height="70px" max-width="120px" /></div>


								<div id="wst_descr">
									<div id="wst_h1"><?php

									$lfd_nr = $zeile_wst['lfd_nr'];

									//Um den App-Status abzufragen muss hier eine Datenbankabfrage erfolgen
                                	$sql_app = "SELECT * FROM app WHERE pub_nr_de = '$lfd_nr'";
									$ergebnis_app = mysqli_query($db, $sql_app) or die('Es konnten keine Informationen über das Applikationsblatt (deutsch) abgerufen werden. Bitte versuchen Sie es noch einmal.
');
									$zeile_app = mysqli_fetch_array($ergebnis_app);

									echo '<a href="wst_info.php?lfd=' . $lfd_nr?>"> <?php if ($la == en) {echo $zeile_wst['bezeichnung_en'];} else {echo $zeile_wst['bezeichnung'];}?> </a></div>


									<div id="wst_customer"><?php echo $zeile_wst['kunde']; ?></div>
									<div id="wst_material"><?php

										if ($la == en) {
											if( $zeile_wst['werkstoff'] == 1 ) {echo "Aluminum";}
											if( $zeile_wst['werkstoff'] == 2 ) {echo "Non-ferrous metals";}
											if( $zeile_wst['werkstoff'] == 3 ) {echo "Steel";}
											if( $zeile_wst['werkstoff'] == 4 ) {echo "Cast iron";}
											if( $zeile_wst['werkstoff'] == 5 ) {echo "Plastic";}
											if( $zeile_wst['werkstoff'] == 6 ) {echo "Other";}
											if( $zeile_wst['werkstoff'] == 7 ) {echo "Magnesium";}
											if( $zeile_wst['werkstoff'] == 8 ) {echo "(no)";}
										} else {
											if( $zeile_wst['werkstoff'] == 1 ) {echo "Aluminium";}
											if( $zeile_wst['werkstoff'] == 2 ) {echo "Buntmetalle";}
											if( $zeile_wst['werkstoff'] == 3 ) {echo "Stahl";}
											if( $zeile_wst['werkstoff'] == 4 ) {echo "Gußeisen";}
											if( $zeile_wst['werkstoff'] == 5 ) {echo "Kunststoff";}
											if( $zeile_wst['werkstoff'] == 6 ) {echo "Sonstige";}
											if( $zeile_wst['werkstoff'] == 7 ) {echo "Magnesium";}
											if( $zeile_wst['werkstoff'] == 8 ) {echo "(kein)";}
										}

									?></div>
									<div id="wst_maschnr"><strong><?php echo $zeile_wst['maschtyp']; ?></strong>
                                    &nbsp;- <?php echo $zeile_wst['maschnr']; ?> -</div>
								</div>

								<div id="wst_picto">
									<?php
										include("picto_info_branche_search.php");
										include("picto_info_technologie_search.php");
										include("picto_info_baureihe.php");
									?>
								</div>

								<div id="wst_bestand">
									<div id="wst_lager">
										<?php echo $zeile_wst['regal']; ?> | <?php echo $zeile_wst['reihe']; ?> | <?php echo $zeile_wst['fach']; ?>
									</div>
									<div id="wst_menge">

										<?php echo $zeile_wst['menge_cur']; ?> / <?php echo $zeile_wst['menge']; ?>
									</div>
									<div id="wst_roh">
										<?php
											if ($zeile_wst['rohteil'] == 1) {
												if ($la == en) {echo 'yes';} else {echo 'ja';}
											}
											if ($zeile_wst['rohteil'] == 2) {
												if ($la == en) {echo 'no';} else {echo 'nein';}
											} ?>
									</div>
								</div>

								<div id="wst_geheim">
									<?php
											if ($zeile_wst['geheim'] == 1) {
												echo '<img src="../img/geheim.png" width="25" height="25" />';
											}
											if ($zeile_wst['geheim'] == 2) {
												echo '<img src="../img/frei.png" width="25" height="25" />';
									} ?>

								</div>


                                <div id="wst_pdf">
                                  	<?php
										if ($zeile_app['status_de'] == 1) {
                                  	  		?><a href="pdf.php?lfd=<?php echo $zeile_wst['lfd_nr'] ?>" target="_blank"><img src='../img/pdf_de.png' border="0"/></a>
											<a href="pdf_en.php?lfd=<?php echo $zeile_wst['lfd_nr'] ?>" target="_blank"><img src='../img/pdf_en.png' border="0"/></a><?php
										} else {
											?><img src='../img/pdf_de_grau.png' border="0"/>
											<img src='../img/pdf_en_grau.png' border="0"/><?php
										}
									?>
                                 </div>


								<!-- Hier soll die Anzahl der Optionen = der Anzahl der noch vorhandenen aktuellen Menge im Lager sein
								<select name="anzahl[<?php //echo  $zeile_wst['lfd_nr']; ?>]" style="float:right;">

									<?php
										//$anzahl = 0;
										//while ($anzahl <= $zeile_wst['menge_cur']) {?>
										<!--	<option value="<?php // echo $anzahl; ?>"><?php //echo $anzahl; ?></option>
										<?
										//	$anzahl = $anzahl + 1;

                                       // } ?>

                                </select> -->
								<?php
								 if (($_SESSION['rolle'] == 1) OR ($_SESSION['rolle'] == 2)) {
									?><input style="margin-left:5px; float:right;" id="check" name="check[<?php echo $zeile_wst['lfd_nr']; ?>]" type="checkbox" value="<?php echo $zeile_wst['lfd_nr']; ?>"/><?php
								 } ?>
								</div>

						<?php



							}
						}

						//END WHILE SCHLEIFE

						if (($_SESSION['rolle'] == 1) OR ($_SESSION['rolle'] == 2)) {
							// Listenlogik
							include("list.php");
						}



						// Wenn der Liste Teile hinzugefügt werden sollen
						if (isset($_GET['list_check'])) {

							if (isset($_REQUEST['check'])) {

									//$anzahl_get = array();

									//Hier werden die ausgewählten Checkboxen im Array ausgelesen
									//reset($_REQUEST['anzahl']);
									//foreach ($_REQUEST['anzahl'] as $key2 => $variable2) {

										// die Menge wird dem Array Zahl übergeben
										//$zahl[$key2] = $variable2;

									//}




									// Hier werden die ausgewählten Checkboxen im Array ausgelesen
									reset($_REQUEST['check']);
									foreach ($_REQUEST['check'] as $key1 => $variable1) {


										// Es werden nur die angeklickten Werkstücke weiterverarbeitet
										if ($key1 == $variable1) {


												// Position ist hier die Zuweisung zu welcher Liste
												$position = $_GET['list'];
												$werkstueck = $key1;

												// Hier wird die laufende Nummer gebraucht als Index für das anzahl-array
												//$sql_wst2 = "SELECT * FROM wst WHERE lfd_nr = '$key1'";
												//$ergebnis_wst2 = mysqli_query($db, $sql_wst2) or die('Fehler bei Datenbankabfrage_wst2.');
												//$zeile_wst2 = mysqli_fetch_array($ergebnis_wst2);


												// laufende nummer holen und in der Variable index speichern
												//$index = $zeile_wst2['lfd_nr'];

												//Umwandeln von Typ: String in INT
												//$index_int = (int)$index;

												// Die Menge wird für jedes WST ausgelesen aus dem Array zahl mit dem jeweiligen Index
												//$menge = $zahl[$index_int];


												// Einzelne Verwendungen festhalten in der DB tabelle:history
												$sql_his = "INSERT INTO history (position, werkstueck, aus, ein) VALUES ('$position', '$werkstueck', '0', '0')";
												$ergebnis_his = mysqli_query($db, $sql_his) or die('Der Datenbank konnten keine Informationen übermittelt werden. Überprüfen Sie bitte Ihre Eingabe.');

										}
									}

									$sql_entnahme = "SELECT * FROM entnahmeliste WHERE el_id = $position";
									$ergebnis_entnahme = mysqli_query($db, $sql_entnahme) or die('Es konnten keine Informationen über die Entnahmelisten abgerufen werden. Bitte versuchen Sie es noch einmal.');

									$zeile_entnahme = mysqli_fetch_array($ergebnis_entnahme);
									echo "<p style='float:right;'>Die Werkstücke wurden der Liste <strong><a href='entnahme_info.php?el=" . $zeile_entnahme['el_id'] . "'>" . $zeile_entnahme['el_bez'] . "</a></strong> zugeordnet</p>";


							} else {
								echo "Bitte zuerst Werkstücke auswählen";
							}

						}


			//END IF ISSET
			}



			?>

 </form>
<?php
	// ENDE IF SESSION
	}
?>
    </div>
</div>
