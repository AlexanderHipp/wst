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
				 <?php include("navi.php");?>
			</div>
		
			<div id="main">
				  
				 <?php
    				$pub = $_GET['pub'];
					
				
					$sql_wst = "SELECT * FROM wst WHERE lfd_nr = $pub";
					$ergebnis_wst = mysqli_query($db, $sql_wst) or die('Es konnten keine Informationen über das Werkstück abgerufen werden. Bitte versuchen Sie es noch einmal.');
					$zeile_wst =  mysqli_fetch_array($ergebnis_wst);
					
				
					$sql_app = "SELECT * FROM app WHERE pub_nr_de = $pub";
					$ergebnis_app = mysqli_query($db, $sql_app) or die('Es konnten keine Informationen über das Applikationsblatt () abgerufen werden. Bitte versuchen Sie es noch einmal.');
					$zeile_app =  mysqli_fetch_array($ergebnis_app);
					
					
					$id = $zeile_app['bearbeiter'];
					$sql_user = "SELECT * FROM user WHERE ben_id = $id";
					$ergebnis_user = mysqli_query($db, $sql_user) or die('Es konnten keine Informationen über die Benutzer abgerufen werden. Bitte versuchen Sie es noch einmal.');
					$zeile_user =  mysqli_fetch_array($ergebnis_user);
				
					//Die Konstante für das images-Verzeichnis definieren
					define('WST_IMAGESPFAD', 'img/app/');
				?>
    
    	  
          <div id="pagehead"><span>Applikationsblatt ergänzen / application sheet supplement </span></div>
          	 <div id="layer_left"></div>
                 <div id="left" >
                     <div id="box_2_col">
                          <input name="speichern" type=button onClick="window.location.href='wst_all.php'" class="grau" value="speichern"/>
                          <!--<input name="leeren" type="reset" class="grau" value="Felder leeren"/>-->
                          <img style="float:right;" src="../img/ger.png" width="20" height="11" />
                     </div>
                     
                     <!--Dynamisch machen-->
                      <div id="box_2_col">  
                        <table border="0">
                            <tr>
                                <td style="width:140px;">Werkstück </td>
                                <td><strong><?php echo $zeile_wst['bezeichnung']; ?></strong></td>
                            </tr>
                         </table>
                      </div> 
                      
                      <div id="box_2_col" style="min-height:257px;">
                        <table border="0">
                            <tr>
                                <td style="width:140px;">Werkstoff </td>
                                <td><?php 
										if( $zeile_wst['werkstoff'] == 1 ) {echo "Aluminium";}
										if( $zeile_wst['werkstoff'] == 2 ) {echo "Buntmetalle";}
										if( $zeile_wst['werkstoff'] == 3 ) {echo "Chromstahl";}
										if( $zeile_wst['werkstoff'] == 4 ) {echo "Gusseisen";}
										if( $zeile_wst['werkstoff'] == 5 ) {echo "Kunststoff";}
										if( $zeile_wst['werkstoff'] == 6 ) {echo "Magnesium";}
										if( $zeile_wst['werkstoff'] == 7 ) {echo "Sonstige";}
										if( $zeile_wst['werkstoff'] == 8 ) {echo "Stahl";}
										if( $zeile_wst['werkstoff'] == 9 ) {echo "Titan";}
									?></td>
                            </tr>
                            <tr>
                                <td style="width:140px;">Aufspannungen </td>
                                <td><?php echo $zeile_app['aufspannungen']; ?></td>
                        	</tr>
                            <tr>
                            <!--Muss eventuell errechnet werden aus Stückzeit pro Sekunde-->
                                <td style="width:140px;">Stück/Stunde </td>
                                <td><?php 
										// Es werden alle Sekunden einer Stunde (3600) durch die Stückzeit/Sekunde berechnet und dann mit einer Nachkommastelle ausgegeben
										echo number_format((3600 / $zeile_wst['stueckzeit']), 1); 
									?></td>
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
                                <td><div style="margin-left:-5px;"><?php
                                	//Abfrage welche Bilder angezeigt werden sollen in PHP picto_info
                            		 include("picto_info_baureihe.php");
								?></div></td>
                            </tr>
                            <tr>
                                <td style="width:140px;">Maschinentyp </td>
                                <td><?php echo $zeile_wst['maschtyp']; ?></td>
                       		</tr>
                            <tr>
                                <td colspan="2"><strong>Konstruktive Besonderheiten </strong><br />
                                   <em><?php echo $zeile_app['besonderheiten']; ?></em>
                                </td>
                            </tr> 
                            
                         </table>                  
                      </div>
                      
                      
                      <div id="box_2_col" style="min-height:360px;">
                        <table border="0">
                            
                            <tr>
                                <td style="width:140px;">Kunde </td>
                                <td><?php echo $zeile_wst['kunde']; ?></td>
                            </tr> 
                            <tr>
                                <td><label for="wkunden">weitere Kunden </label></td>
                                <td><?php echo $zeile_app['wkunden']; ?></td>
                            </tr> 
                            <tr>
                                <td style="width:140px; ">Branche </td>
                                <td><?php
                                	//Abfrage welche Bilder angezeigt werden sollen in PHP picto_info
                            		 include("picto_info_branche.php");
								?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Kundennutzen </strong><br />
                                    <em><?php echo $zeile_app['kundennutzen']; ?></em>
                                </td>
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td><label for="prod">Produktionsvolumen </label></td>
                                <td><?php echo $zeile_app['produktionsvolumen']; ?></td>
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td colspan="2"><strong>Qualit&auml;tsvorgaben</strong><br />
                                     <em><?php echo $zeile_app['qualitaetsvorgaben']; ?></em>
                                </td>
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td colspan="2"><strong>Fertigungsziele</strong><br />
                                   <em><?php echo $zeile_app['fertigungsziele']; ?></em>
                                </td>
                            </tr> 
                            
                            
                        </table>                  
                      </div>
                  
                      <div id="box_2_col" >
                        <table border="0">
                            
                            
                            <!-- Nach Upload soll das Bild hier erscheinen-->
                            <tr>
                                <td><img src="../img/app/<?php echo $zeile_app['foto1']; ?>" width="300px" /></td>
                            </tr>
                            
                            <tr>
                                <td><?php echo $zeile_app['beschr1']; ?></td>

                                
                            </tr> 
                            
                            <tr><td>&nbsp;</td></tr> 
                           
                            <!-- Nach Upload soll das Bild hier erscheinen-->
                            <tr>
                                <td><img src="../img/app/<?php echo $zeile_app['foto2']; ?>" width="300px" /></td>
                            </tr>
                            
                            <tr>
                                <td><?php echo $zeile_app['beschr2']; ?></td>
                                
                            </tr> 
                           
                        </table> 
                      
                     </div>
                     <div id="box_2_col" >
                        <table border="0">
                            
                            
                            <tr>
                                <td style="width:140px;"><label for="bearb">Bearbeiter</label></td>
                                <td><?php echo $zeile_user['name']; ?></td>
                            </tr> 
                            
                           
                        </table> 
                      
                     </div>
                 </div>
        
        
        <?php          
        	
		if (isset($_POST['submit'])) {
						
			// Variablen für das Formular füllen
			$besonderheiten_en = $_POST['besonderheiten_en'];
			$kundennutzen_en = $_POST['kundennutzen_en'];
			$prodv = $_POST['prodv'];
			$quali_en = $_POST['quali_en'];
			$fert_en = $_POST['fert_en'];
			$beschr1_en = $_POST['beschr1_en'];
			$beschr2_en = $_POST['beschr2_en'];
			$pub = $_POST['pub'];
			
			
			
			// Überprüfung ob die Pflichtfelder ausgefüllt wurden
			if ($besonderheiten_en == "") { $fb_besonderheiten_en = 1; } 
			if ($kundennutzen_en == "") { $fb_kundennutzen_en = 1; } 
			if ($prodv_en == "") { $fb_prodv_en = 1; } 
			if ($quali_en == "") { $fb_quali_en = 1; } 
			if ($fert_en == "") { $fb_fert_en = 1; }
			if ($bearb_en == "") { $fb_bearb_en = 1; }
			if (($besonderheiten_en == "") OR ($kundennutzen_en == "") OR ($prodv_en == "") OR ($quali_en == "") OR ($fert_en == "") OR ($bearb_en == "")) { $feedback = 1; } else {	
			
				// Status auf fertig bearbeitet setzen
				$status_en = 1;
	
				$sql_app_en = "UPDATE app_en 
								SET en = '$status_en',
									prodv = '$prodv',
									qualitaetsvorgaben_en = '$quali_en',
									fertigungsziele_en = '$fert_en',
									besonderheiten_en = '$besonderheiten_en',
									kundennutzen_en = '$kundennutzen_en',
									beschr1_en = '$beschr1_en',
									beschr2_en = '$beschr2_en'
								WHERE pub_nr_en = '$pub'";
	
				$ergebnis_app_en = mysqli_query($db, $sql_app_en) or die('Der Datenbank konnten keine Informationen übermittelt werden. Überprüfen Sie bitte Ihre Eingabe.');
								
			}
			
			
			// Wenn der Datenbank ein App übermittelt wurde, soll die jeweilige Email verschickt werden
			if ($ergebnis_app_en) {
				
				include("mail_1.php");
				mail($an4, $betreff4, $inhalt4, 'From:' . $von4);
			}
		}
		
		?>
                 
 <!----------------------------------------------------------------------------------------------------------------------------->
                 
                 <form enctype="multipart/form-data" action="app_edit_en.php?pub=<?php echo $pub; ?>" method="post">
                 <div id="right">
                     <div id="box_2_col" >
                          <img style="float:right;" src="../img/eng.png" width="20" height="11" />
                          <?php 
							// Wenn ein Ergebnis vorhanden ist, also ein Werkstück erfolgreich angelegt wurde, dann soll anstatt des "anlegen"-Buttons ein "weiter"-Button erscheinen
							if ($ergebnis_app_en) {
								?><input type=button onClick="window.location.href='app_all.php'" value="weiter" class="grau" /><?php 
									$feedback = 2;
									
							} else {
								?><input type="submit" name="submit" class="grau" value="save"/><?php 
							}
			
						// Wenn nicht alle Felder ausgefüllt sind wird feedback auf true gesetzt und hier dann geprüft. 
						if ($feedback == 1) {?>
							<div id="red" style="padding-top:10px;">Please fill out completely!</div>
						<?php } 
						
						if ($feedback == 2) {?>
							<div id="green" style="padding-top:10px;" >The application sheet (english) is complete!</div>
						<?php } ?>
									  
                          <!--Dieses Feld dient dazu dem Formular den pub wert mitzugeben, dazu wird er mit HIlfe der GET_Variable ausgelesen und dann oben mit POST wieder verwendet-->
                          <input name="pub" type="hidden" value="<?php echo $_GET['pub']; ?>"/>

                          
                      </div>
                  
                      <div id="box_2_col" >
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
                                <td><?php 
									
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
                                <td style="width:140px;">Clamping device </td>
                                <td><?php echo $zeile_app['aufspannungen']; ?></td>
                        	</tr>
                            <tr>
                            <!--Muss eventuell errechnet werden aus Stückzeit pro Sekunde-->
                                <td style="width:140px;">Parts per hour </td>
                                <td><?php 
										// Es werden alle Sekunden einer Stunde (3600) durch die Stückzeit/Sekunde berechnet und dann mit einer Nachkommastelle ausgegeben
										echo number_format((3600 / $zeile_wst['stueckzeit']), 1); 
									?></td>
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
                                <td><div style="margin-left:-5px;"><?php
                                	//Abfrage welche Bilder angezeigt werden sollen in PHP picto_info
                            		 include("picto_info_baureihe.php");
								?></div></td>
                            </tr>
                            <tr>
                                <td><label for="machtype">Machine type </label></td>
                                <td><?php echo $zeile_wst['maschtyp']; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><label <?php if ($fb_besonderheiten_en == 1) { echo 'class="red_fb"'; } ?> >Special construction features</label> <br />
                                (max. 5 Points or 240 characters, Separation with durch semicolon)<br />
                                    <textarea  id="besonderheiten_en" name="besonderheiten_en" cols="30" rows="3" value=""/><?php echo $besonderheiten_en ?></textarea>
                                </td>
                            </tr> 
                        </table>                  
                      </div>
                  
                       <div id="box_2_col" style="min-height:360px;">
                        <table border="0">
                            
                            <tr>
                                <td style="width:140px;">Customer </td>
                                <td><?php echo $zeile_wst['kunde']; ?></td>
                            </tr> 
                            
                          
                            <tr>
                                <td style="width:140px;">Further customers </td>
                                <td><?php echo $zeile_app['wkunden']; ?></td>
                            </tr> 
                            <tr>
                                <td style="width:140px;">Business </td>
                                <td><?php
                                	//Abfrage welche Bilder angezeigt werden sollen in PHP picto_info
                            		 include("picto_info_branche_search.php");
								?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><label <?php if ($fb_kundennutzen_en == 1) { echo 'class="red_fb"'; } ?> >Customer gain</label> <br />
                                (max. 5 Points or 240 characters, Separation with durch semicolon)<br />
                                    <textarea  id="kundennutzen_en" name="kundennutzen_en" cols="30" rows="4" value=""/><?php echo $kundennutzen_en ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td><label  <?php if ($fb_prodv_en == 1) { echo 'class="red_fb"'; } ?> for="prodv">Production volume </label></td>
                                <td><input  id="prodv" name="prodv" class="element text small" type="text" size="15" maxlength="255" value="<?php echo $prodv ?>"/></td>
                            </tr>
                            <tr>
                                <td colspan="2"><label <?php if ($fb_quali_en == 1) { echo 'class="red_fb"'; } ?> >Quality guidelines</label>  <br />
									(max. 3 Points or 150 characters, Separation with durch semicolon)<br />
                                    <textarea  id="quali_en" name="quali_en" cols="30" rows="1" value=""/><?php echo $quali_en ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><label <?php if ($fb_fert_en == 1) { echo 'class="red_fb"'; } ?> >Manufacturing objectives</label> <br />
                                (max. 3 Points or 150 characters, Separation with durch semicolon)<br />
                                    <textarea  id="fert_en" name="fert_en" cols="30" rows="1" value=""/><?php echo $fert_en ?></textarea>
                                </td>
                            </tr> 
                        </table>                  
                      </div>
                  
                      <div id="box_2_col" >
                        <table border="0">
                            <tr>
                                <td colspan="2">Descriptions further pictures <br />
                                (Only fill out when further pictures and description were included in the german version.)</td>
                            </tr>
                            
                            
                            <!-- Nach Upload soll das Bild hier erscheinen-->
                            
                            <tr>
                                <td><input  id="beschr1_en" name="beschr1_en" class="element text small" type="text" size="20" maxlength="255" value="<?php echo $beschr1_en ?>"/></td>
                                <td style="width:140px;"><label for="beschr1_en">Description Picture 1</label></td>
                            </tr> 
                            
                            <!-- Nach Upload soll das Bild hier erscheinen-->
                           
                            
                            
                            <tr>
                                <td><input  id="beschr2_en" name="beschr2_en" class="element text small" type="text" size="20" maxlength="255" value="<?php echo $beschr2_en ?>"/>
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
