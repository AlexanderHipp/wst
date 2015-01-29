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
			?><div id="box_anmelden" style="margin-top:10px;">Bitte zuerst <a href="index.php" style="text-decoration:underline;">anmelden</a></div><?php
			exit();
		} else { 
	?>
    
    <div id="navi">
         <?php 
		 	include("navi.php");
            
			//Die Konstante für das images-Verzeichnis definieren
			define('WST_IMAGESPFAD', 'img/app/');
		 ?>
         
    </div>
    	<div id="main">
     		<div id="pagehead"><span>Applikationsblatt ändern / application sheet supplement </span></div>
    		<?php
    			$pub = $_GET['lfd'];
				
				// Informationen aus WST holen
				$sql_wst = "SELECT * FROM wst WHERE lfd_nr = $pub";
				$ergebnis_wst = mysqli_query($db, $sql_wst) or die('Es konnten keine Informationen über das Werkstück abgerufen werden. Bitte versuchen Sie es noch einmal.');
				$zeile_wst =  mysqli_fetch_array($ergebnis_wst);
				
				// Informationen aus App holen
				$sql_app = "SELECT * FROM app WHERE pub_nr_de = $pub";
				$ergebnis_app = mysqli_query($db, $sql_app) or die('Es konnten keine Informationen über das Applikationsblatt (deutsch) abgerufen werden. Bitte versuchen Sie es noch einmal.');
				$zeile_app =  mysqli_fetch_array($ergebnis_app);
				
				// Informationen aus App_en holen
				$sql_app_en = "SELECT * FROM app_en WHERE pub_nr_en = $pub";
				$ergebnis_app_en = mysqli_query($db, $sql_app_en) or die('Es konnten keine Informationen über das Applikationsblatt (englisch) abgerufen werden. Bitte versuchen Sie es noch einmal.');
				$zeile_app_en =  mysqli_fetch_array($ergebnis_app_en);
			
				if (isset($_POST['submit1'])) {
					$pub = $_GET['lfd'];
			
					// Informationen aus App holen
					$sql_app = "SELECT * FROM app WHERE pub_nr_de = $pub";
					$ergebnis_app = mysqli_query($db, $sql_app) or die('Es konnten keine Informationen über das Applikationsblatt (deutsch) abgerufen werden. Bitte versuchen Sie es noch einmal.');
					$zeile_app =  mysqli_fetch_array($ergebnis_app);
					
					// Informationen aus App_en holen
					$sql_app_en = "SELECT * FROM app_en WHERE pub_nr_en = $pub";
					$ergebnis_app_en = mysqli_query($db, $sql_app_en) or die('Es konnten keine Informationen über das Applikationsblatt (englisch) abgerufen werden. Bitte versuchen Sie es noch einmal.');
					$zeile_app_en =  mysqli_fetch_array($ergebnis_app_en);
					
					// Variablen für das Formular füllen
					$aufsp = $_POST['aufsp'];
					$besonderheiten = $_POST['besonderheiten'];
					$wkunden = $_POST['wkunden'];
					$kundennutzen = $_POST['kundennutzen'];
					$prod = $_POST['prod'];
					$prodv = $_POST['prodv'];
					$quali = $_POST['quali'];
					$fert = $_POST['fert'];
					
					if ($_FILES['foto1']['name']) {
						$foto1 = $_FILES['foto1']['name'];
					} else {
						$foto1 = $zeile_app['foto1'];
					}
			
					$beschr1 = $_POST['beschr1'];
					
					if ($_FILES['foto2']['name']) {
						$foto2 = $_FILES['foto2']['name'];
					} else {
						$foto2 = $zeile_app['foto2'];
					}
					
					$beschr2 = $_POST['beschr2'];
					
					if ($_POST['bearb'] != "") {
						$bearb = $_POST['bearb'];
					} else {
						$bearb = $zeile_app['bearbeiter'];
					}
					
				
					
					//Hier wird der aktuelle Status übergeben, dieser wird in zwei variablen gespeichert für jede Sprache einzeln, falls später mal seperat auf die Stati zugegriffen werden will
					$status_de = $_POST['aktiv'];
					$status_en = $_POST['aktiv'];
			
					// Englische Variablen füllen
					$besonderheiten_en = $_POST['besonderheiten_en'];
					$kundennutzen_en = $_POST['kundennutzen_en'];
					$quali_en = $_POST['quali_en'];
					$fert_en = $_POST['fert_en'];
					$beschr1_en = $_POST['beschr1_en'];
					$beschr2_en = $_POST['beschr2_en'];
					
					$bearbeiter = $bearb;
					
					//Die Bild-Datei in das Verzeichnis img 
					$ziel1 = "../". WST_IMAGESPFAD . $foto1;
					$ziel2 = "../". WST_IMAGESPFAD . $foto2;
					
					move_uploaded_file($_FILES['foto1']['tmp_name'], $ziel1);
					move_uploaded_file($_FILES['foto2']['tmp_name'], $ziel2);
					
					// Überprüfung ob die Pflichtfelder ausgefüllt wurden
					if ($aufsp == "") { $feedback = 'Das Textfeld Aufspannungen ist ein Pflichtfeld.'; } else {
						if ($besonderheiten == "") { $feedback = 'Das Textfeld Konstruktive Besonderheiten ist ein Pflichtfeld.'; } else {
							if ($kundennutzen == "") { $feedback = 'Das Textfeld Kundennutzen ist ein Pflichtfeld.'; } else {
								if ($prod == "") { $feedback = 'Das Textfeld Produktionsvolumen ist ein Pflichtfeld.'; } else {
									if ($quali == "") { $feedback = 'Das Textfeld Qualitätsvorgaben  ist ein Pflichtfeld.'; } else {
										if ($fert == "") { $feedback = 'Das Textfeld Fertigungsziele ist ein Pflichtfeld.'; } else {
											if ($besonderheiten_en == "") { $feedback = 'The text field "Special construction features" is a required field.'; } else {
												if ($kundennutzen_en == "") { $feedback = 'The text field "Customer gain"  is a required field.'; } else {
													if ($prodv == "") { $feedback = 'The text field "Production volume"  is a required field.'; } else {
														if ($quali_en == "") { $feedback = 'The text field "Quality guidelines"  is a required field.'; } else {
															if ($fert_en == "") { $feedback = 'The text field "Manufacturing objectives" is a required field.'; } else {
																if ($status_de == "") { $feedback = 'Bitte einen Status zuweisen.'; } else {
						
																	$sql_app = "UPDATE app 
																				SET produktionsvolumen = '$prod',
																					qualitaetsvorgaben = '$quali',
																					fertigungsziele = '$fert',
																					besonderheiten = '$besonderheiten',
																					wkunden = '$wkunden',
																					kundennutzen = '$kundennutzen',
																					aufspannungen = '$aufsp',
																					bearbeiter = '$bearb',
																					foto1 = '$foto1',
																					beschr1 = '$beschr1',
																					foto2 = '$foto2',
																					beschr2 = '$beschr2',
																					status_de = '$status_de',
																					bearbeiter = '$bearbeiter'
																				WHERE pub_nr_de = '$pub'";
																	
																	$ergebnis_app = mysqli_query($db, $sql_app) or die('1Der Datenbank konnten keine Informationen übermittelt werden. Überprüfen Sie bitte Ihre Eingabe.');
																	
																	$sql_app_en = "UPDATE app_en
																				   SET pub_nr_en = '$pub',
																					   qualitaetsvorgaben_en = '$quali_en',
																					   fertigungsziele_en = '$fert_en',
																					   besonderheiten_en = '$besonderheiten_en',
																					   kundennutzen_en = '$kundennutzen_en',
																					   beschr1_en = '$beschr1_en',
																					   beschr2_en = '$beschr2_en',
																					   status_en = '$status_en',
																					   prodv = '$prodv'																					   
																					WHERE pub_nr_en = '$pub'";
															
																	$ergebnis_app_en = mysqli_query($db, $sql_app_en) or die('2Der Datenbank konnten keine Informationen übermittelt werden. Überprüfen Sie bitte Ihre Eingabe.');
																
																	$ergebnis = 1;
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
			
					if ($ergebnis_app AND $ergebnis_app_en) {
						include("mail_1.php");
						mail($an6, $betreff6, $inhalt6, 'From:' . $email6);
					}		
				
				}
					?>
            
              		<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'] . '?lfd=' . $_GET['lfd']; ?>" method="post">
                  	<div id="box" style="width:777px;">
                          <img style="float:right;" src="../img/eng.png" width="20" height="11" />
                          <img style="float:right;margin-right:5px;" src="../img/ger.png" width="20" height="11" />
                           <input style="float:right;margin-left:10px;margin-right:5px;" id="aktiv" name="aktiv" class="element text medium" type="text" size="1" maxlength="1" value="<?php echo $zeile_app['status_de']; ?>"/>
                          <label for="aktiv" style="float:right;">(1) aktiv, (0) inaktiv </label> 
                          	<?php
                                if ($ergebnis == 1) {
										?>
                                            <script type="text/javascript">
                                                location.href="app_change.php?lfd=<?php echo $pub; ?>";
                                            </script>
                                            <input type=button onClick="window.location.href='wst_info.php?lfd=<?php echo $pub; ?>'" value="weiter" class="grau" /><?php 
                                            $feedback = '<div id="green">Das Applikationsblatt wurde erfolgreich geändert!</div>';
                                } else {
                                    ?>
                                        <input type=button onClick="window.location.href='wst_info.php?lfd=<?php echo $pub; ?>'" value="zurück zum Werkstück" class="grau" />
                                        <input type="submit" name="submit1" class="grau" value="speichern / save"/>
                                    <?php 
                                }
                    
                                // Wenn nicht alle Felder ausgefüllt sind wird feedback auf true gesetzt und hier dann geprüft. 
                                if ($feedback != "") {?>
                                    <div id="red" style="padding-top:10px;"><?php echo $feedback ?></div>
                            <?php } ?>
                          
                          
                          <?php //Dieses Feld dient dazu dem Formular den pub wert mitzugeben, dazu wird er mit Hilfe der GET_Variable ausgelesen und dann oben mit POST wieder verwendet ?>
                          <input name="pub" type="hidden" value="<?php echo $_GET['lfd']; ?>"/>
                          
                         
                     </div>
                     
	                 <div id="left" >  
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
                            	<td><label for="aufsp">Aufspannungen </label></td>
                                <td><input  id="aufsp" name="aufsp" class="element text small" type="text" size="15" maxlength="255" value="<?php echo html_entity_decode( $zeile_app['aufspannungen']); ?>"/></td>
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
                            	<td>
									<?php echo htmlentities($zeile_wst['maschtyp']); ?>
                                </td>
                        	</tr>
                        	<tr>
                            	<td colspan="2">Konstruktive Besonderheiten (max. 5 Punkte)<br />
                                	<textarea  id="besonderheiten" name="besonderheiten" cols="30" rows="3" value=""/><?php echo html_entity_decode($zeile_app['besonderheiten']); ?></textarea>
                                </td>
                        	</tr> 
                      	</table>                  
                   	 </div>
                      
                     
                     <div id="box_2_col" style="height:360px;">
                     	<table border="0">
                        	<tr>
                            	<td style="width:140px;">Kunde </td>
                                <td><?php echo htmlentities($zeile_wst['kunde']); ?></td>
                            </tr> 
                            <tr>
                                <td><label for="wkunden">weitere Kunden </label></td>
                                <td><input  id="wkunden" name="wkunden" class="element text small" type="text" size="15" maxlength="255" value="<?php echo html_entity_decode($zeile_app['wkunden']); ?>"/></td>
                            </tr> 
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
                                <td colspan="2">Kundennutzen (max. 5 Punkte)<br />
                                    <textarea  id="kundennutzen" name="kundennutzen" cols="30" rows="4" value=""/><?php echo html_entity_decode($zeile_app['kundennutzen']); ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="prod">Produktionsvolumen </label></td>
                                <td><input  id="prod" name="prod" class="element text small" type="text" size="15" maxlength="255" value="<?php echo html_entity_decode($zeile_app['produktionsvolumen']); ?>"/></td>
                            </tr>
                            <tr>
                                <td colspan="2">Qualit&auml;tsvorgaben (max. 3 Punkte)<br />
                                    <textarea  id="quali" name="quali" cols="30" rows="1" value=""/><?php echo html_entity_decode($zeile_app['qualitaetsvorgaben']); ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">Fertigungsziele (max. 3 Punkte)<br />
                                    <textarea  id="fert" name="fert" cols="30" rows="1" value=""/><?php echo html_entity_decode($zeile_app['fertigungsziele']); ?></textarea>
                                </td>
                            </tr> 
                       	</table>                  
                        </div>
                  
                        <div id="box_2_col" >
                        	<table border="0">
                            	<tr>
                                	<td><img src="../img/app/<?php echo $zeile_app['foto1']; ?>" width="300px" /><br />
                                	Dateipfad: <?php echo $zeile_app['foto1']; ?></td>
                            	</tr>
                        	</table>
                         	<table border="0">   
                            	<tr>
                            		<td><label for="beschr1">Bild ersetzen</label></td>
                                	<td><input name="foto1" type="file" size="20" accept="image/*" /><br /></input></td>
                            	</tr>
                         	</table> 
                         	<table border="0">   
                            	<tr>
                            		<td><label for="beschr1">Beschreibung Bild 1 </label></td>
                                	<td><input  id="beschr1" name="beschr1" class="element text small" type="text" size="20" maxlength="255" value="<?php echo html_entity_decode($zeile_app['beschr1']); ?>"/></td>
                            	</tr> 
							</table> 
                       	</div>    
                       	<div id="box_2_col" >
                        	<table border="0">
                            	<tr>
                                	<td><img src="../img/app/<?php echo $zeile_app['foto2']; ?>" width="300px" /><br />
                                	Dateipfad: <?php echo $zeile_app['foto2']; ?></td>
                            	</tr>
                         	</table>
                         	<table border="0">   
                         		<tr>
                            		<td><label for="beschr1">Bild ersetzen</label></td>
                                	<td><input name="foto2" type="file" size="20" accept="image/*" /><br /></input></td>
 	                           	</tr>
                            </table> 
                         	<table border="0">  
                            	<tr>
                                	<td><label for="beschr2">Beschreibung Bild 2 </label></td>
                                	<td><input  id="beschr2" name="beschr2" class="element text small" type="text" size="20" maxlength="255" value="<?php echo html_entity_decode($zeile_app['beschr2']); ?>"/></td>
                            	</tr> 
                        	</table> 
                      	</div>
                     	<div id="box_2_col" >
                        	<table border="0">
                            <tr>
                           		<td style="width:140px;"><label for="bearb"> Aktueller Bearbeiter</label></td>
                                <td>
									<?php 
										//Speziell den ausgewählten user aus DB auslesen
										$user = $zeile_app['bearbeiter']; 
										$sql_user_select = "SELECT * FROM user WHERE ben_id = $user";
										$ergebnis_user_select = mysqli_query($db, $sql_user_select) or die('Es konnten keine Informationen über die User abgerufen werden. Bitte versuchen Sie es noch einmal.');
										$zeile_user_select = mysqli_fetch_array($ergebnis_user_select);
									?>
									<?php echo $zeile_user_select['name'] ?>
                                </td>
                            </tr>
                            <tr>
                            	<td></td>
                                <td>
                                	<select name="bearb" />
                                    <option value="">Bearbeiter wechseln</option>
                                    <?php 
										// Hier sollen alle User aufgeführt werden die als Bearbeiter in Frage kommen, deshalb werden alle user aus tabelle:user
                                    	$sql_user = "SELECT * FROM user";
										$ergebnis_user = mysqli_query($db, $sql_user) or die('Es konnten keine Informationen über die User abgerufen werden. Bitte versuchen Sie es noch einmal.');
										while ($zeile_user = mysqli_fetch_array($ergebnis_user)) {	
											?><option value="<?php echo  $zeile_user['ben_id'] ?>" <?php if( $_POST['bearbeiter'] == $zeile_user_select['ben_id'] ) {echo "selected='selected'";} ?> > <?php echo $zeile_user['name'] ?></option><?php
										}
									?>
                            	</td>
                            </tr> 
                        </table> 
                     </div>
                 </div>
                 
<!----------------------------------------------------------------------------------------------------------------------------->
                 
                 <div id="right">
                 	<div id="box_2_col">
                    	<table border="0">
                        	<tr>
                            	<td style="width:140px;">Workpiece </td>
                                <td><strong><?php echo $zeile_wst['bezeichnung_en']; ?></strong></td>
                         	</tr>
                        </table>
                    </div>
                  
                    <div id="box_2_col" style="min-height:257px;" >
                    	<table border="0">
                        	<tr>
                            	<td style="width:140px;">Material </td>
                                <td>
									<?php 
										if( $zeile_wst['werkstoff'] == 1 ) {echo "Aluminum";}
										if( $zeile_wst['werkstoff'] == 2 ) {echo "Non-ferrous metals";}
										if( $zeile_wst['werkstoff'] == 3 ) {echo "Chrome steel";}
										if( $zeile_wst['werkstoff'] == 4 ) {echo "Cast iron";}
										if( $zeile_wst['werkstoff'] == 5 ) {echo "Plastic";}
										if( $zeile_wst['werkstoff'] == 6 ) {echo "Magnesium";}
										if( $zeile_wst['werkstoff'] == 7 ) {echo "Other";}
										if( $zeile_wst['werkstoff'] == 8 ) {echo "Steel";}
										if( $zeile_wst['werkstoff'] == 9 ) {echo "Titanium";}
									?>	
								</td>
                            </tr>
                            <tr>
                            	<td><label for="aufsp_en">Clamping device </label></td>
                                <td><?php echo $zeile_app['aufspannungen']; ?></td>
                        	</tr>
                            
                            <tr>
                            	<td style="width:140px;">Parts per hour </td>
                                <td>
									<?php 
										// Es werden alle Sekunden einer Stunde (3600) durch die Stückzeit/Sekunde berechnet und dann mit einer Nachkommastelle ausgegeben
										echo number_format((3600 / $zeile_wst['stueckzeit']), 1); 
									?>
                            	</td>
                            </tr> 
                            <tr>
                                <td style="width:140px;">Technology </td>
                                <td>
                                     <?php
                                		//Abfrage welche Bilder angezeigt werden sollen in PHP picto_info
                            		 	include("picto_info_technologie.php");
									?>
                                </td>
                            </tr>    
                            <tr>
                                <td style="width:140px;">Series </td>
                                <td><div style="margin-left:-5px;">
									<?php
                                		//Abfrage welche Bilder angezeigt werden sollen in PHP picto_info
                            			include("picto_info_baureihe.php");
									?></div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="machtype">Machine type </label></td>
                                <td><?php echo $zeile_wst['maschtyp']; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2">Special construction features (max. 5 points)<br />
                                	<textarea  id="besonderheiten_en" name="besonderheiten_en" cols="30" rows="3" value=""/><?php echo html_entity_decode($zeile_app_en['besonderheiten_en']); ?></textarea>
                                </td>
                            </tr> 
                        </table>                  
                    </div>
                  
                    <div id="box_2_col" style="min-height:360px;">
                    	<table border="0">
                        	<tr>
                            	<td style="width:140px;">Customer </td>
                                <td><?php echo html_entity_decode($zeile_wst['kunde']); ?></td>
                            </tr> 
                            <tr>
                                <td><label for="wkunden">Further customers </label></td>
                                <td><?php echo html_entity_decode($zeile_app['wkunden']); ?></td>
                            </tr> 
                            <tr>
                            	<td style="width:140px;">Business </td>
                                <td>
									<?php
                                		//Abfrage welche Bilder angezeigt werden sollen in PHP picto_info
                            			include("picto_info_branche.php");
									?>
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="2">Customer gain (max. 5 points)<br />
                                	<textarea  id="kundennutzen_en" name="kundennutzen_en" cols="30" rows="4" value=""/><?php echo html_entity_decode($zeile_app_en['kundennutzen_en']); ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="prodv">Production volume </label></td>
                                <td><input  id="prodv" name="prodv" class="element text small" type="text" size="15" maxlength="255" value="<?php echo htmlentities($zeile_app_en['prodv']); ?>"/></td>
                            </tr>
                            <tr>
                                <td colspan="2">Quality guidelines (max. 3 points)<br />
                                    <textarea  id="quali_en" name="quali_en" cols="30" rows="1" value=""/><?php echo html_entity_decode($zeile_app_en['qualitaetsvorgaben_en']); ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">Manufacturing objectives (max. 3 points)<br />
                                    <textarea  id="fert_en" name="fert_en" cols="30" rows="1" value=""/><?php echo html_entity_decode($zeile_app_en['fertigungsziele_en']); ?></textarea>
                                </td>
                            </tr> 
                        </table>                  
                     </div>
                  
                     <div id="box_2_col" >
                     	<table border="0">
                        	<tr>
                            	<td colspan="2">Descriptions further pictures <br /></td>
                            </tr>
                            <tr>
                            	<td><input  id="beschr1_en" name="beschr1_en" class="element text small" type="text" size="20" maxlength="255" value="<?php echo html_entity_decode($zeile_app_en['beschr1_en']); ?>"/></td>
                                <td style="width:140px;"><label for="beschr1_en">Description Picture 1</label></td>
                            </tr> 
                            <tr>
                                <td><input  id="beschr2_en" name="beschr2_en" class="element text small" type="text" size="20" maxlength="255" value="<?php echo html_entity_decode($zeile_app_en['beschr2_en']); ?>"/>
                                </td><td style="width:140px;"><label for="beschr2_en">Description Picture 2 </label></td>
                            </tr> 
                        </table> 
                     </div>
                 </div>
            </form>   
            <?php 
             
	// ENDE IF SESSION
	}
?>  
</div>	
