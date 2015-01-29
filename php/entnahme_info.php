<?php 
/** 
*	@project: Werkstück-Management CHIRON-WERKE GmbH & Co. KG
*	@author: Alexander Hipp
*	@date: 01.04.2012
*/

include("base.php");?>

<div id="page">
	<div id="heading"></div>
    
    <?php 
		// Hier wird geprüft ob schon eine Anmeldung erfolgt ist
		if (!isset($_SESSION['ben_id'])) {
			?>
			<div id="box_anmelden" style="margin-top:10px;">Bitte zuerst <a href="index.php" style="text-decoration:underline;">anmelden</a></div><?php
			exit();
		} else { 
		
			
			 
			//Wenn Buchung vorgenommen wird  
			if (isset($_POST['buchen']))
			{	if (isset($_REQUEST['check_aus'])) 
				{	$show_artikel = 0;
					reset($_REQUEST['check_aus']);
					foreach ($_REQUEST['check_aus'] as $key1 => $variable1)
					{	$sql_his_check = "SELECT * FROM history WHERE h_id = '$key1'";
						$ergebnis_his_check = mysqli_query($db, $sql_his_check) or die('Es konnten keine Positionen abgerufen werden. Bitte versuchen Sie es noch einmal.');
						$zeile_his_check =  mysqli_fetch_array($ergebnis_his_check);
						$ch_aus = $zeile_his_check['aus'];
						if ($ch_aus == "0")
						{	$h_id = $key1;
							$aus = $variable1;
							settype($aus, "integer");
							// AKtuelle Lagermenge ändern
							$sql_aus = "UPDATE history 
										SET aus = $aus
										WHERE h_id = '$h_id'";
												
							// Aus der tabelle:history die Wst Nummer holen
							$sql_his_cur = "SELECT * FROM history WHERE h_id = '$key1'";
							$ergebnis_his_cur = mysqli_query($db, $sql_his_cur) or die('Es konnten keine Positionen abgerufen werden. Bitte versuchen Sie es noch einmal.');
							$zeile_his_cur =  mysqli_fetch_array($ergebnis_his_cur);
							$wst_id = $zeile_his_cur['werkstueck'];
												
							// Aus der tabelle:wst die aktuelle Menge holen
							$sql_wst_cur = "SELECT * FROM wst WHERE lfd_nr = '$wst_id'";
							$ergebnis_wst_cur = mysqli_query($db, $sql_wst_cur) or die('Es konnten keine Informationen über die Werkstücke abgerufen werden. Bitte versuchen Sie es noch einmal.');
							$zeile_wst_cur =  mysqli_fetch_array($ergebnis_wst_cur);
							$menge_alt = $zeile_wst_cur['menge_cur'];
							settype($menge_alt, "Integer");

							// Ändern der Menge um - 1
							$menge_neu = $menge_alt - 1;
							$sql_wst_aus = "UPDATE wst 
							SET menge_cur = $menge_neu
							WHERE lfd_nr = '$wst_id'";
					$ergebnis_wst_aus = mysqli_query($db, $sql_wst_aus) or die('Der Datenbank konnten keine Informationen übermittelt werden. Überprüfen Sie bitte Ihre Eingabe.');
												
												$ergebnis_aus = mysqli_query($db, $sql_aus) or die('Der Datenbank konnten keine Informationen übermittelt werden. Überprüfen Sie bitte Ihre Eingabe.');
												
											}
									
								}
							}
							
							if (isset($_REQUEST['check_ein'])) {
								
								reset($_REQUEST['check_ein']);
								foreach ($_REQUEST['check_ein'] as $key2 => $variable2) {
									
									$sql_his_check2 = "SELECT * FROM history WHERE h_id = '$key2'";
									$ergebnis_his_check2 = mysqli_query($db, $sql_his_check2) or die('Es konnten keine Positionen abgerufen werden. Bitte versuchen Sie es noch einmal.');
									$zeile_his_check2 =  mysqli_fetch_array($ergebnis_his_check2);
									$ch_ein = $zeile_his_check2['ein'];
									
										if ($ch_ein == "0") {
									
											$h_id = $key2;
											$ein = $variable2;
											settype($ein, "integer");
										
										
											// Einzelne Verwendungen festhalten in der DB tabelle:history
											$sql_ein = "UPDATE history 
														SET ein = $ein
														WHERE h_id = '$h_id'";
											
											
											// Aus der tabelle:history die Wst Nummer holen
											$sql_his_cur = "SELECT * FROM history WHERE h_id = '$key2'";
											$ergebnis_his_cur = mysqli_query($db, $sql_his_cur) or die('Es konnten keine Positionen abgerufen werden. Bitte versuchen Sie es noch einmal.');
											$zeile_his_cur =  mysqli_fetch_array($ergebnis_his_cur);
											
											$wst_id = $zeile_his_cur['werkstueck'];
											
											
											
											// Aus der tabelle:wst die aktuelle Menge holen
											$sql_wst_cur_ein = "SELECT * FROM wst WHERE lfd_nr = '$wst_id'";
											$ergebnis_wst_cur_ein = mysqli_query($db, $sql_wst_cur_ein) or die('Es konnten keine Informationen über das Werkstück abgerufen werden. Bitte versuchen Sie es noch einmal.');
											$zeile_wst_cur_ein =  mysqli_fetch_array($ergebnis_wst_cur_ein);
											
											$menge_alt_ein = $zeile_wst_cur_ein['menge_cur'];
											
											settype($menge_alt_ein, "Integer");
											
											//Ändern der Menge um + 1
											$menge_neu_ein = $menge_alt_ein + 1;
											
											
											$sql_wst_ein = "UPDATE wst 
															SET menge_cur = $menge_neu_ein
															WHERE lfd_nr = '$wst_id'";
											$ergebnis_wst_ein = mysqli_query($db, $sql_wst_ein) or die('Der Datenbank konnten keine Informationen übermittelt werden. Überprüfen Sie bitte Ihre Eingabe.');
											
											
											$ergebnis_ein = mysqli_query($db, $sql_ein) or die('Der Datenbank konnten keine Informationen übermittelt werden. Überprüfen Sie bitte Ihre Eingabe.');
											
										}
									}	
								}
								
						}
    	
			
		
		// Daten holen
		$el = $_GET['el'];
		$sql = "SELECT * FROM entnahmeliste WHERE el_id = '$el'";
		
		$ergebnis_get = mysqli_query($db, $sql) or die('Es konnten keine Informationen über die Entnahmelisten abgerufen werden. Bitte versuchen Sie es noch einmal.');
		$zeile =  mysqli_fetch_array($ergebnis_get);
		$ersteller = $zeile['ersteller'];
		
		if (($_SESSION['ben_id'] == $ersteller) OR ($_SESSION['rolle'] == 1)) {?>
	
    <div id="navi">
    
          <?php 
		      //Um auf er Flags zu sagen auf welcher Seite man sich befindet
			  $seite = 'entnahme_info.php';
		     include("flags.php");?>
		  <?php include("navi.php");?>
    </div>

    <div id="main">
    
    	<?php
			//Hier wird die Sprache übergeben 
			$la = $_SESSION['la']; 
		?>
        
    	<div id="pagehead"><span><?php echo $zeile['el_bez']; ?></span> 
        <input type="button" onclick="window.print()" class="printer"  /></div>
        
    	<form action="<?php echo $_SERVER['PHP_SELF'];?>?el=<?php echo $zeile['el_id']; ?>" method="post"  >
        
        <?php
				// Werkstücke anzeigen die zur Liste gehören
				
				$pos = $zeile['el_id'];
				$his = "SELECT * FROM history WHERE position = '$pos' ORDER BY werkstueck";
				
				$ergebnis_his = mysqli_query($db, $his) or die('Es konnten keine Positionen abgerufen werden. Bitte versuchen Sie es noch einmal.');
				
				$ergebnis_gefunden = 0;
				
				$show_artikel = 1;
				
				// Für jede WST_Position wird ein Div angelegt und mit Infos ausgestattet
				while ($zeile_his =  mysqli_fetch_array($ergebnis_his)) {
					
				
               	$ergebnis_gefunden = 1;
                ?>
        		<div id="box_erg">
                  
                  	<?php	// WST-Informationen werden aus der tabelle:wst geladen
					$wst_wst = $zeile_his['werkstueck'];
					$sql_wst = "SELECT * FROM wst WHERE lfd_nr = '$wst_wst'";
					
					$ergebnis_wst = mysqli_query($db, $sql_wst) or die('Es konnten keine Informationen über die Werkstücke abgerufen werden. Bitte versuchen Sie es noch einmal.');
					
					$zeile_wst =  mysqli_fetch_array($ergebnis_wst);
				
    				?>
                  
                  	<div id="picture_small"><img src="../img/<?php echo $zeile_wst['foto']; ?>" height="70px" max-width="120px" /></div>
                  	<div id="wst_descr">
                    
                    <?php
						// Auslesen des WST-lfd-wertes zur Übergabe beim AUfruf der einzelansicht
						$lfd_nr = $zeile_wst['lfd_nr']; 
						
						//Um den App-Status abzufragen muss hier eine Datenbankabfrage erfolgen 
						$sql_app = "SELECT * FROM app WHERE pub_nr_de = '$lfd_nr'";
						$ergebnis_app = mysqli_query($db, $sql_app) or die('Es konnten keine Informationen über das Applikationsblatt (deutsch) abgerufen werden. Bitte versuchen Sie es noch einmal.');
						$zeile_app = mysqli_fetch_array($ergebnis_app);
					?>
                                 
                        <div id="wst_h1"><a href="wst_info.php?lfd=<?php echo $lfd_nr; ?>">
						   <?php 
							if ($la == en) {
								echo $zeile_wst['bezeichnung_en'];
							} else {
								echo $zeile_wst['bezeichnung'];
							}
							?></a></div>  
                        <div id="wst_customer"><?php echo $zeile_wst['kunde'];?></div>  
                        <div id="wst_material">
									<?php 
										if ($la == en) {
											if( $zeile_wst['werkstoff'] == 1 ) {echo "Aluminum";}
											if( $zeile_wst['werkstoff'] == 2 ) {echo "Non-ferrous metals";}
											if( $zeile_wst['werkstoff'] == 3 ) {echo "Steel";}
											if( $zeile_wst['werkstoff'] == 4 ) {echo "Cast iron";}
											if( $zeile_wst['werkstoff'] == 5 ) {echo "Plastic";}
											if( $zeile_wst['werkstoff'] == 6 ) {echo "Other";}
											if( $zeile_wst['werkstoff'] == 7 ) {echo "Magnesium";}
											if( $zeile_wst['werkstoff'] == 8 ) {echo "(no)";}
										}
										else {
											if( $zeile_wst['werkstoff'] == 1 ) {echo "Aluminium";}
											if( $zeile_wst['werkstoff'] == 2 ) {echo "Buntmetalle";}
											if( $zeile_wst['werkstoff'] == 3 ) {echo "Stahl";}
											if( $zeile_wst['werkstoff'] == 4 ) {echo "Gußeisen";}
											if( $zeile_wst['werkstoff'] == 5 ) {echo "Kunststoff";}
											if( $zeile_wst['werkstoff'] == 6 ) {echo "Sonstige";}
											if( $zeile_wst['werkstoff'] == 7 ) {echo "Magnesium";}
											if( $zeile_wst['werkstoff'] == 8 ) {echo "(kein)";}
										}
									?>
                    	</div>                    
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
							<?php echo $zeile_wst['regal'];?> | <?php echo $zeile_wst['reihe'];?> | <?php echo $zeile_wst['fach'];?>
                        </div>
                        <div id="wst_menge">
                        	<?php echo $zeile_wst['menge_cur']; ?> / <?php echo $zeile_wst['menge'];?>
                        </div>
                        <div id="wst_roh">
                        	(<?php 
									if ($zeile_wst['rohteil'] == 1) {
										echo '1';
									}
									if ($zeile_wst['rohteil'] == 2) {
										echo '2';
									} ?>)
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
                     
                    <?php if ($_SESSION['rolle'] == 1) { ?>
                  	<div id="wst_menge" style="float:left; margin-left:10px;">
                        	<div>
                            
                            <?php
                            	// Wenn aktuell keine Teile vorhanden sind im Lager soll der AUsbuchen Knopf gar nicht erscheinen
								if ($zeile_wst['menge_cur'] >= 1) { 
                             
                             if ($zeile_his['aus'] != 1) { ?>
                             <input id="check" name="check_aus[<?php echo $zeile_his['h_id']; ?>]" type="checkbox" value="1" <?php if( $zeile_his['aus'] == 1 ) { echo "checked='checked'"; } ?> /><label for="maschnr"><?php if ($la == en) {echo 'OUT';} else {echo 'AUS';} ?> </label> 
                            <?php  }
                             
                             
                             } ?></div>
                            <div> 
                            <?php                           
                            	if ($zeile_his['ein'] != 1) { ?>
                                <input id="check" name="check_ein[<?php echo $zeile_his['h_id']; ?>]" type="checkbox" value="1" <?php if( $zeile_his['ein'] == 1 ) { echo "checked='checked'"; } ?> /><label for="maschnr"><?php if ($la == en) {echo 'IN';} else {echo 'EIN';} ?> </label>
                              <?php  }
                                
                            ?>    
                            </div>
                    </div>
                  	<?php } 
						$h_id = $zeile_his['h_id'];
						
					?>
                  			
                            <!--Button zum Löschen einzelner Entnahmelisten-->
                            <a href="delete_wst_aus_entnahme.php?el=<?php echo $el ?>&hid=<?php echo $h_id; ?>" style="margin-left:10px;">
                            	x
                            </a>


                      
                          <!-- <input style="float:right; margin-top:5px;" size="20"  id="comment" name="comment" class="element text medium" type="text" maxlength="255" value="<?php //echo $bezeichnung_en; ?>"/>-->
                  </div> 
         
         <?php } 
		 
		
		 
		// Es sollen nur Artikel angezeigt werden wenn auch welche in der Liste vorhanden sind, ansonsten soll ein Text erscheinen 
		if ($ergebnis_gefunden == 1) { 
    		if ($_SESSION['rolle'] == 1) { 
				
				?><input style="float:right;margin-top:5px;" name="buchen" type="submit" class="grau" value="<?php if ($la == en) {echo 'make a booking';} else {echo 'buchen';} ?>"/><?php
			
			}
			
			
			?><input style="float:right;margin-top:5px;margin-right:10px;" name="zurueck" type=button onClick="window.location.href='entnahme.php'" class="grau" value="<?php if ($la == en) {echo 'back to overview';} else {echo 'Zur&uuml;ck zur &Uuml;bersicht';} ?>"/></div><?php
			
    	} 
		
		if ($ergebnis_gefunden == 0) {
			
			if (isset($_POST['buchen'])) { 
			} else {
				echo '<div id="box"><div id="red">Es wurden noch keine Artikel zur Entnahmeliste hinzugef&uuml;gt!</div></div>';
			}
		}
		
		
			
    			?>
    
    </form> 
    
				<?php if ($show_artikel == 0) {
                    echo '<div id="box" style="width:780px;margin-top:10px;float:left;"><div id="green">Buchung erfolgreich</div></div>';
                }?>         
                         
       
    
    <?php 
	
	} else { 
			?><div id="box_anmelden" style="margin-top:10px;">Bitte zuerst <a href="index.php" style="text-decoration:underline;">anmelden</a></div><?php
			exit();
	}
	// ENDE IF SESSION
	}
?>  
		
    </div>
   
   
</div>