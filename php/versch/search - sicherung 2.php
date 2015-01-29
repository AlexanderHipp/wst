
<!--DEUTSCH UND ENGLISCH NOCH TRENNEN-->
<?php include("base.php");?>

<div id="page">
	<div id="heading"></div>
    <div id="navi">
          <?php include("flags.php");?>
		  <?php include("navi.php");?>
    </div>

    <div id="main">
           
    	
        	<?php 
				// Hier wird die Sprache übergeben 
				if (isset($_GET['l'])) {
					$la = $_GET['l'];
				}
				else {
					$la = 'de';
				}
				
				function abfrage_aufbauen($suchtext_wst, $suchtext_kunde, $suchtext_mnummer, $suchtext_werkstoff, $suchtext_geheim) {
					  
					  $sql_wst = "SELECT * FROM wst";
						
					  //-------------------------------BEZEICHNUNG---------------------------------
					
					  // WST Suchbegriffe zerlegen und in einem Array speichern
					  $suche_sauber = str_replace(',', ' ', $suchtext_wst);
					  $suchbegriffe = explode(' ', $suche_sauber);
					  $echte_suchbegriffe = array();
					  if (count($suchbegriffe) > 0) {
						foreach ($suchbegriffe as $wort) {
						  if (!empty($wort)) {
							$echte_suchbegriffe[] = $wort;
						  }
						}
					  }
					
					  // WST Eine WHERE-Klausel mit allen Suchbegriffen erstellen
					  $where_liste = array();
					  if (count($echte_suchbegriffe) > 0) {
						foreach($echte_suchbegriffe as $wort) {
						  $where_liste[] = "bezeichnung LIKE '%$wort%'";
						}
					  }
					  $where_klausel = implode(' OR ', $where_liste);
					  
					  //------------------------------KUNDE-----------------------------------------	
					  
					   // Kunde Suchbegriffe zerlegen und in einem Array speichern
					  $suche_sauber_k = str_replace(',', ' ', $suchtext_kunde);
					  $suchbegriffe_k = explode(' ', $suche_sauber_k);
					  $echte_suchbegriffe_k = array();
					  if (count($suchbegriffe_k) > 0) {
						foreach ($suchbegriffe_k as $wort_k) {
						  if (!empty($wort_k)) {
							$echte_suchbegriffe_k[] = $wort_k;
						  }
						}
					  }
					
					  // Kunde Eine WHERE-Klausel mit allen Suchbegriffen erstellen
					  $where_liste_k = array();
					  if (count($echte_suchbegriffe_k) > 0) {
						foreach($echte_suchbegriffe_k as $wort_k) {
						  $where_liste_k[] = "kunde LIKE '%$wort_k%'";
						}
					  }
					  $where_klausel_k = implode(' OR ', $where_liste_k);
					  
					  //-------------------------------MASCHINEN-NUMMER---------------------------------
					  
					  // MNUMMER Suchbegriffe zerlegen und in einem Array speichern
					  $suche_sauber_m = str_replace(',', ' ', $suchtext_mnummer);
					  $suchbegriffe_m = explode(' ', $suche_sauber_m);
					  $echte_suchbegriffe_m = array();
					  if (count($suchbegriffe_m) > 0) {
						foreach ($suchbegriffe_m as $wort_m) {
						  if (!empty($wort_m)) {
							$echte_suchbegriffe_m[] = $wort_m;
						  }
						}
					  }
					
					  // MNUMMER Eine WHERE-Klausel mit allen Suchbegriffen erstellen
					  $where_liste_m = array();
					  if (count($echte_suchbegriffe_m) > 0) {
						foreach($echte_suchbegriffe_m as $wort_m) {
						  $where_liste_m[] = "maschnr LIKE '%$wort_m%'";
						}
					  }
					  $where_klausel_m = implode(' OR ', $where_liste_m);
					
					
					  //-------------------------------Werkstoff---------------------------------
					  
					  if ($suchtext_werkstoff == "") {
					  } else {						 
						  $wort_w = $suchtext_werkstoff;
						  $where_klausel_w = "werkstoff = '$wort_w'";
					  }
					  
					  //-------------------------------Geheimhaltung-----------------------------
					  if ($suchtext_geheim == 0) {
					  } else {
					  	  $wort_g = $suchtext_geheim;
					      $where_klausel_g = "geheim = '$wort_g'";
					  }
					  
					  //-------------------------------Abfragen----------------------------------------	
					
					  // WST und Kunde und MaschNr und Werkstoff  und geheim : Gib alle aus!!
					  if (empty($where_klausel) AND empty($where_klausel_k) AND empty($where_klausel_m) AND empty($where_klausel_w) AND empty($where_klausel_g))  {
												
						return $sql_wst;
						break;
					  }
					  
					  // WST und Kunde und MaschNr und Werkstoff Die WHERE-Klausel an die Abfrage anhängen
					  if (!empty($where_klausel) AND !empty($where_klausel_k) AND !empty($where_klausel_m) AND !empty($where_klausel_w) AND !empty($where_klausel_g))   {
						$sql_wst .= " WHERE $where_klausel AND $where_klausel_k AND $where_klausel_m AND $where_klausel_w AND $where_klausel_g";
						
						return $sql_wst;
						break;
					  }
					  
					  
					  // Wst 
					  if (!empty($where_klausel)) {
							$sql_wst .= " WHERE $where_klausel";
							
							if (!empty($where_klausel_k)) {
								$sql_wst .= " AND $where_klausel_k";
							}
							if (!empty($where_klausel_m)) {
								$sql_wst .= " AND $where_klausel_m";
							}
							if (!empty($where_klausel_w)) {
								$sql_wst .= " AND $where_klausel_w";
							}
							if (!empty($where_klausel_g)) {
								$sql_wst .= " AND $where_klausel_g";
							}
							
							return $sql_wst;
							break;
					  }
					  
					  
					  // Kunde 
					  if (!empty($where_klausel_k)) {
							$sql_wst .= " WHERE $where_klausel_k";
							
							if (!empty($where_klausel)) {
								$sql_wst .= " AND $where_klausel";
							}
							if (!empty($where_klausel_m)) {
								$sql_wst .= " AND $where_klausel_m";
							}
							if (!empty($where_klausel_w)) {
								$sql_wst .= " AND $where_klausel_w";
							}
							if (!empty($where_klausel_g)) {
								$sql_wst .= " AND $where_klausel_g";
							}
							
							return $sql_wst;
							break;
					  }
					  
					  // MNummer 
					  if (!empty($where_klausel_m)) {
							$sql_wst .= " WHERE $where_klausel_m";
					  		
							if (!empty($where_klausel_k)) {
								$sql_wst .= " AND $where_klausel_k";
							}
							if (!empty($where_klausel)) {
								$sql_wst .= " AND $where_klausel";
							}
							if (!empty($where_klausel_w)) {
								$sql_wst .= " AND $where_klausel_w";
							}
							if (!empty($where_klausel_g)) {
								$sql_wst .= " AND $where_klausel_g";
							}
							
							return $sql_wst;
							 break;
					  }
					
					 					  
					  // Werkstoff 
					  if (!empty($where_klausel_w)) {
							$sql_wst .= " WHERE $where_klausel_w";
							
							if (!empty($where_klausel_k)) {
								$sql_wst .= " AND $where_klausel_k";
							}
							if (!empty($where_klausel_m)) {
								$sql_wst .= " AND $where_klausel_m";
							}
							if (!empty($where_klausel)) {
								$sql_wst .= " AND $where_klausel";
							}
							if (!empty($where_klausel_g)) {
								$sql_wst .= " AND $where_klausel_g";
							}
							
							return $sql_wst;
							 break;
					  }
					  
					  // Geheimhaltung 
					  if (!empty($where_klausel_g)) {
							$sql_wst .= " WHERE $where_klausel_g";
							
							if (!empty($where_klausel_k)) {
								$sql_wst .= " AND $where_klausel_k";
							}
							if (!empty($where_klausel_m)) {
								$sql_wst .= " AND $where_klausel_m";
							}
							if (!empty($where_klausel)) {
								$sql_wst .= " AND $where_klausel";
							}
							if (!empty($where_klausel_w)) {
								$sql_wst .= " AND $where_klausel_w";
							}
							
							return $sql_wst;
							 break;
					  }
					  
					 //-------------------------------------------------------------------------------------
					
					
					
					 
				 }
			?>
        
        
        			
        
    	  <!--Überschrift im grauen Kasten-->
          <div id="pagehead"><span>Suche</span></div>
              <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                  <div id="box">
                      <input name="starten" type="submit" class="grau" value="<?php if ($la == en) {echo 'Start search';} else {echo 'Suche starten';} ?>"/>
                      <input name="leeren" type="reset" class="grau" value="<?php if ($la == en) {echo 'Empty fields';} else {echo 'Felder leeren';} ?>"/>
                      <!--BENUTZERRECHTE ADMIN-->
                      <input name="anlegen" type=button onClick="window.location.href='wst_edit.php'" class="grau" value="<?php if ($la == en) {echo 'Edit workpiece';} else {echo 'Werkstück anlegen';} ?>"/>
                  </div>
                  
                  <div id="box">
                  	<table border="0">
                        <tr>
                            <td><label for="werkstueck"><?php if ($la == en) {echo 'Workpiece';} else {echo 'Werkstück';} ?></label></td>
                            <td><input style="margin-left:10px;" id="werkstueck" name="suche_wst" class="element text medium" type="text" maxlength="255" value="<?php echo $_POST['suche_wst'] ?>"/></td>
                            
                            <td><label style="margin-left:50px;" for="kunde"><?php if ($la == en) {echo 'Customer';} else {echo 'Kunde';} ?></label></td>
                            <td><input style="margin-left:10px;" id="kunde" name="suche_kunde" class="element text medium" type="text" maxlength="255" value="<?php echo $_POST['suche_kunde'] ?>"/></td>
                        </tr>
                        
                        <tr>
                            <td><label for="werkstoff"><?php if ($la == en) {echo 'Material';} else {echo 'Werkstoff';} ?> </label></td>
                            
                            
                            <!--Um später einen Absendewert zu bestimmen muss value="" benutzt werden. http://de.selfhtml.org/html/formulare/auswahl.htm-->
                            <td><select style="margin-left:10px;" name="suche_werkstoff" >
                            	
                                <option value=""  <?php if( $_POST['suche_werkstoff'] == 0 ) {echo "selected='selected'";} ?> > <?php if ($la == en) {echo 'Choose';} else {echo 'Bitte wählen';} ?></option>
                                <option value="1" <?php if( $_POST['suche_werkstoff'] == 1 ) {echo "selected='selected'";} ?> > <?php if ($la == en) {echo 'Aluminum';} else {echo 'Aluminium';} ?></option>
                                <option value="2" <?php if( $_POST['suche_werkstoff'] == 2 ) {echo "selected='selected'";} ?> > <?php if ($la == en) {echo 'Non-ferrous metals';} else {echo 'Buntmetalle';} ?></option>
                                <option value="3" <?php if( $_POST['suche_werkstoff'] == 3 ) {echo "selected='selected'";} ?> > <?php if ($la == en) {echo 'Chrome steel';} else {echo 'Chromstahl';} ?></option>
                                <option value="4" <?php if( $_POST['suche_werkstoff'] == 4 ) {echo "selected='selected'";} ?> > <?php if ($la == en) {echo 'Cast iron';} else {echo 'Gusseisen';} ?></option>
                                <option value="5" <?php if( $_POST['suche_werkstoff'] == 5 ) {echo "selected='selected'";} ?> > <?php if ($la == en) {echo 'Plastic';} else {echo 'Kunststoff';} ?></option>
                                <option value="6" <?php if( $_POST['suche_werkstoff'] == 6 ) {echo "selected='selected'";} ?> > <?php if ($la == en) {echo 'Magnesium';} else {echo 'Magnesium';} ?></option>
                                <option value="7" <?php if( $_POST['suche_werkstoff'] == 7 ) {echo "selected='selected'";} ?> > <?php if ($la == en) {echo 'Other';} else {echo 'Sonstige';} ?></option>
                                <option value="8" <?php if( $_POST['suche_werkstoff'] == 8 ) {echo "selected='selected'";} ?> > <?php if ($la == en) {echo 'Steel';} else {echo 'Stahl';} ?></option>
                                <option value="9" <?php if( $_POST['suche_werkstoff'] == 9 ) {echo "selected='selected'";} ?> > <?php if ($la == en) {echo 'Titanium';} else {echo 'Titan';} ?></option></select>
                            
                            </td>
                            <td><label style="margin-left:50px;" for="mnummer"><?php if ($la == en) {echo 'Machine No.';} else {echo 'Maschinen-Nr.';} ?> </label></td>
                            <td><input style="margin-left:10px;" id="mnummer" name="suche_mnummer" class="element text medium" type="text" maxlength="255" value="<?php echo $_POST['suche_mnummer'] ?>"/></td>
                        </tr>
                        
                  		<tr>
                            <td><label for="geheim"></label></td>
                            <td>
                            	<input style="margin-left:12px;" id="ja" name="suche_geheim" type="radio" value="1" <?php if( $_POST['suche_geheim'] == 1 ) { echo "checked='checked'";}?> /> <?php if ($la == en) {echo 'secret';} else {echo 'geheim';} ?>
                                <input style="margin-left:12px;" id="nein" name="suche_geheim" type="radio" value="2" <?php if( $_POST['suche_geheim'] == 2 ) { echo "checked='checked'";}?> /> <?php if ($la == en) {echo 'free';} else {echo 'frei';} ?>
                            </td>
                        </tr>
                       <!-- <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td><label  for="technologie"><?php if ($la == en) {echo 'Technology';} else {echo 'Technologie';} ?> </label></td>
                            <td  style="padding-left:10px;" colspan="3">
								<input type="hidden"><div class="meg_group" id="MEG_GROUP_MEG01">
                                <div class="meg_subgroup" id="MEG_SUBGROUP_MEG01_0">
                                <div id="meg101" class="meg_btn" onClick="$('#meg101').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_101_4multistate.png)" title="FZ Einspindel"></div>
                                <div id="meg102" class="meg_btn" onClick="$('#meg102').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_102_4multistate.png)" title="FZ Doppelspindel"></div>
                                
                                <div id="meg103" class="meg_btn" onClick="$('#meg103').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_103_4multistate.png)" title="FZ Vierspindel"></div>
                                <div id="meg104" class="meg_btn" onClick="$('#meg104').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_104_4multistate.png)" title="NC-Schwenkkopf"></div>
                                </div>
                                <div class="meg_subgroup" id="MEG_SUBGROUP_MEG01_1">
                                <div id="meg111" class="meg_btn" onClick="$('#meg111').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_111_4multistate.png)" title="Korb-Werkzeugwechsler"></div>
                                <div id="meg112" class="meg_btn" onClick="$('#meg112').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_112_4multistate.png)" title="Ketten-Werkzeugwechsler"></div>
                                </div>
                                <div class="meg_subgroup" id="MEG_SUBGROUP_MEG01_2">
                                <div id="meg121" class="meg_btn" onClick="$('#meg121').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_121_4multistate.png)" title="Starrtisch"></div>
                                <div id="meg122" class="meg_btn" onClick="$('#meg122').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_122_4multistate.png)" title="Werkst&uuml;ckwechseleinrichtung"></div>
                                <div id="meg123" class="meg_btn" onClick="$('#meg123').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_123_4multistate.png)" title="Five axis"></div>
                                <div id="meg124" class="meg_btn" onClick="$('#meg124').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_124_4multistate.png)" title="Langbett"></div>
                                </div>
                                <div class="meg_subgroup" id="MEG_SUBGROUP_MEG01_3">
                                <div id="meg131" class="meg_btn" onClick="$('#meg131').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_131_4multistate.png)" title="Stangen-Bearbeitung"></div>
                                <div id="meg132" class="meg_btn" onClick="$('#meg132').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_132_4multistate.png)" title="MPS"></div>
                                <div id="meg133" class="meg_btn" onClick="$('#meg133').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_133_4multistate.png)" title="WM Felgenbearbeitung"></div>
                                
                                <div id="meg141" class="meg_btn" onClick="$('#meg141').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_141_4multistate.png)" title="Automation"></div>
                                </div>
                                </div>
                                </td>
                        </tr>
                        
                        <tr>
                            <td><label for="branche"><?php if ($la == en) {echo 'Industry';} else {echo 'Branche';} ?> </label></td>
                                                       
                            <td   style="padding-left:10px;"colspan="3">
                                    
                                    <div id="meg201" class="meg_btn btngrp_MEG02" onClick="gf_toggle_btn_with_ddlb('#meg201', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_201_4multistate.png)" title="Aerospace"></div>
                                    <div id="meg202" class="meg_btn btngrp_MEG02" onClick="gf_toggle_btn_with_ddlb('#meg202', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_202_4multistate.png)" title="Automotive"></div>
                                    <div id="meg203" class="meg_btn btngrp_MEG02" onClick="gf_toggle_btn_with_ddlb('#meg203', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_203_4multistate.png)" title="Medical"></div>
                                    <div id="meg204" class="meg_btn btngrp_MEG02" onClick="gf_toggle_btn_with_ddlb('#meg204', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_204_4multistate.png)" title="Mechanical Engineering"></div>
                                    <div id="meg205" class="meg_btn btngrp_MEG02" onClick="gf_toggle_btn_with_ddlb('#meg205', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_205_4multistate.png)" title="Precision Technology"></div>
                                    
                                    
                                    <select name="" size="1" id="meg202_ddlb" class="meg_ddlb ddlbgrp_MEG02" style="display:none">
                                    <option></option>
                                    
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
                                    <option></option>
                                    <option value="20401">Armaturen</option>
                                    <option value="20402">Werkzeuge &amp; Ger&auml;te</option>
                                    
                                    <option value="20403">Maschinenbau</option>
                                    <option value="20404">Zusatzinformationen</option>
                                    </select>
                                    
                                    
                                    <select name="" size="1" id="meg205_ddlb" class="meg_ddlb ddlbgrp_MEG02" style="display:none">
                                    <option></option>
                                    <option value="20501">Elektrik &amp; Elektronik</option>
                                    <option value="20502">Beschl&auml;ge &amp; Schlie&szlig;systeme</option>
                                    
                                    <option value="20503">Uhren, Schmuck &amp; Optik</option>
                                    </select>
                                    
                                    
                            	</td>
                            </tr>
                            <tr>
                            	<td><label for="baureihen"><?php if ($la == en) {echo 'Series';} else {echo 'Baureihe';} ?> </label></td>
                                <td style="padding-left:10px;" colspan="3">
                                    
                                    <div id="meg401" class="meg_btn" onClick="$('#meg401').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_401_4multistate.png)" title="08"></div>
                                    <div id="meg402" class="meg_btn" onClick="$('#meg402').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_402_4multistate.png)" title="12"></div>
                                    <div id="meg403" class="meg_btn" onClick="$('#meg403').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_403_4multistate.png)" title="15"></div>
                                    <div id="meg404" class="meg_btn" onClick="$('#meg404').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_404_4multistate.png)" title="18"></div>
                                    <div id="meg405" class="meg_btn" onClick="$('#meg405').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_405_4multistate.png)" title="MILL"></div>
                                    <div id="meg406" class="meg_btn" onClick="$('#meg406').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_406_4multistate.png)" title="BIG MILL"></div>
                                    
                                </td>
                        	</tr>-->
                        
                        </table>   
                    </form>
                  </div>
                  
                  <!--SUCHLOGIK BAUEN-->
                  
                  <!--Ergebnisse wenn was gefunden wird-->
                  
                  <?php
						
			  
				  
						
						
					if (isset($_POST['starten'])) {
						
						// Texteingabe einer Variable zuordnen
						$suchtext_wst = $_POST['suche_wst'];
						$suchtext_kunde = $_POST['suche_kunde'];
						$suchtext_mnummer = $_POST['suche_mnummer'];
						$suchtext_werkstoff = $_POST['suche_werkstoff'];
						$suchtext_geheim = $_POST['suche_geheim'];
						
						
						
						$sql_wst = abfrage_aufbauen($suchtext_wst, $suchtext_kunde, $suchtext_mnummer, $suchtext_werkstoff, $suchtext_geheim);
						echo $sql_wst;
						
						$ergebnis_wst = mysqli_query($db, $sql_wst) or die('Fehler bei Datenbankabfrage_wst.');
							
					
                  
                   		while ($zeile_wst = mysqli_fetch_array($ergebnis_wst)) {	?>
                      
                      
                          <div id="box_erg">
                          
                            <div id="picture_small"><img src="../img/<?php echo $zeile_wst['foto']; ?>" height="70px" max-width="120px" /></div>
                            
                            
                            <div id="wst_descr">
                                <div id="wst_h1"><?php 
                                $lfd_nr = $zeile_wst['lfd_nr'];
                                echo '<a href="wst_info.php?lfd=' . $lfd_nr . '&l='. $la .'">' . $zeile_wst['bezeichnung'] . '</a>' ?></div>
                                
                                  
                                <div id="wst_customer"><?php echo $zeile_wst['kunde']; ?></div>  
                                <div id="wst_material"><?php 
                                
                                    if ($la == en) {
                                        if( $zeile_wst['werkstoff'] == 1 ) {
                                            echo "Aluminum";
                                        }
                                        if( $zeile_wst['werkstoff'] == 2 ) {
                                            echo "Non-ferrous metals";
                                        }
                                        if( $zeile_wst['werkstoff'] == 3 ) {
                                            echo "Chrome steel";
                                        }
                                        if( $zeile_wst['werkstoff'] == 4 ) {
                                            echo "Cast iron";
                                        }
                                        if( $zeile_wst['werkstoff'] == 5 ) {
                                            echo "Plastic";
                                        }
                                        if( $zeile_wst['werkstoff'] == 6 ) {
                                            echo "Magnesium";
                                        }
                                        if( $zeile_wst['werkstoff'] == 7 ) {
                                            echo "Other";
                                        }
                                        if( $zeile_wst['werkstoff'] == 8 ) {
                                            echo "Steel";
                                        }
                                        if( $zeile_wst['werkstoff'] == 9 ) {
                                            echo "Titanium";
                                        }
                                    }
                                    else {
                                        if( $zeile_wst['werkstoff'] == 1 ) {
                                            echo "Aluminium";
                                        }
                                        if( $zeile_wst['werkstoff'] == 2 ) {
                                            echo "Buntmetalle";
                                        }
                                        if( $zeile_wst['werkstoff'] == 3 ) {
                                            echo "Chromstahl";
                                        }
                                        if( $zeile_wst['werkstoff'] == 4 ) {
                                            echo "Gusseisen";
                                        }
                                        if( $zeile_wst['werkstoff'] == 5 ) {
                                            echo "Kunststoff";
                                        }
                                        if( $zeile_wst['werkstoff'] == 6 ) {
                                            echo "Magnesium";
                                        }
                                        if( $zeile_wst['werkstoff'] == 7 ) {
                                            echo "Sonstige";
                                        }
                                        if( $zeile_wst['werkstoff'] == 8 ) {
                                            echo "Stahl";
                                        }
                                        if( $zeile_wst['werkstoff'] == 9 ) {
                                            echo "Titan";
                                        }
                                        
                                    }
								?></div>                    
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
                             <!--akutelle Menge noch ermitteln-->
                                3 / <?php echo $zeile_wst['menge']; ?>
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
										echo '<img src="../img/geheim.jpg" width="25" height="25" />';
									}
									if ($zeile_wst['geheim'] == 2) {
										echo '<img src="../img/frei.png" width="25" height="25" />';
							} ?>
                            
                        </div>
                        
                        <div id="wst_pdf">
                        	<!--LOGIK NOCH BAUEN-->
                            <img src="../img/pdf_de.png" width="32" height="32" />
                            <img src="../img/pdf_en.png" width="32" height="32" />
                        </div>
                        
                        <!-- Hier soll die Anzahl der Optionen = der Anzahl der noch vorhandenen aktuellen Menge im Lager sein-->
                        <select name="anzahl" style="float:right;">
                        <option selected="selected" value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        </select>
                        
                        <input style="margin-left:5px; float:right;" id="auswahl" name="auswahl" type="checkbox" value="1"/>
                      
                        </div> 
                    
                    <?php }
					
					
					} 
						
					else {
					   echo "Es wurde noch keine Suche durchgeführt.";
					}
					?>
                 
                 	<div id="wst_list_check" style="margin:5px 0 10px;">
                        <form action="post">
                            <label for="list_new"><?php if ($la == en) {echo 'Edit new list';} else {echo 'neue Liste anlegen';} ?> </label>
                            <input style="margin-left:10px;" id="list_new" name="list_new" class="element text medium" type="text" maxlength="255" value=""/>
                            <input name="list_new_ok" type="submit" value="ok" class="button_text"/>
                            <select style="margin-left:10px;" name="list" >
                            <option value="" selected="selected"><?php if ($la == en) {echo 'Choose list';} else {echo 'Liste wählen';} ?></option>
                            <option value="(kein)"><?php if ($la == en) {echo '(no)';} else {echo '(keine)';} ?></option></select>
                       </form>
                	
                	</div>
                
                 
                 
                 <!-- Wenn nichts gefunden wird. Logik bauen
                 
                  <div id="box">
                  Es wurden keine mit Ihrer Suchanfrage übereinstimmenden Werkstücke gefunden.
                  </div>-->
              
              
              
          
    </div>	
</div>

<!--
			// WHILE SCHLEIFE für Suchergebnis-Ausgabe
			$all = "SELECT * FROM user";
			$ergebnis = mysqli_query($db, $all);
			
			while($zeile = mysqli_fetch_array($ergebnis)) {
				echo $zeile[kuerzel].'&nbsp;'.$zeile[benutzername].'&nbsp;'.$zeile[password_set].'<br />';
			}
            
-->