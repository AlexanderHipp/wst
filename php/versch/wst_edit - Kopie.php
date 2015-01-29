<?php include("base.php");?>




<div id="page">
	<div id="heading"></div>
    <div id="navi">
          <?php include("navi.php");
		  
		  //Die Konstante für das images-Verzeichnis definieren
			define('WST_IMAGESPFAD', 'img/');
		  ?>
    </div>

    <div id="main">
           
    
    	  <!--Überschrift im grauen Kasten-->
          <div id="pagehead"><span>Neues Werkstück anlegen</span></div>
        
		
		<?php
			
                //Prüfen ob das Formular schon einmal abgeschickt wurde
				//abgeschickt ja
				if (isset($_POST['submit'])) {
				
				
					//Variablen füllen
					$bezeichnung = $_POST['bezeichnung'];
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
					//Radio Button Geheimhaltung
					if (($_POST['rohteil']) == '1') {
						$rohteil = 1;
					}
					if (($_POST['rohteil']) == '2') {
						$rohteil = 2;
					}
					
					
					$kunde = $_POST['kunde'];
					$aerospace = $_POST['aerospace'];
					$maschnr = $_POST['maschnr'];
					$maschtyp = $_POST['maschtyp'];
					
					$stueckzeit = $_POST['stueckzeit'];
					$programmierer = $_POST['programmierer'];
					$werkstoff = $_POST["werkstoff"];
					$foto = $_FILES['foto']['name'];
					$kommentar = $_POST['kommentar'];
					
					
										
					//Initialisierung der Variable um zu prüfen ob Textfelder leer sind
					$form_ausgeben = false;
					$feedback = false;
					
					 
					
					if ((!empty($bezeichnung)) && (!empty($geheim)) && (!empty($regal)) && (!empty($reihe)) && (!empty($fach)) && (!empty($menge)) && (!empty($rohteil)) && (!empty($kunde)) && (!empty($maschnr)) && (!empty($maschtyp)) && (!empty($stueckzeit)) && (!empty($programmierer)) && (!empty($werkstoff)) && (!empty($foto))) {
						
						//Die Bild-Datei in das Verzeichnis img 
						$ziel = "../". WST_IMAGESPFAD . $foto;
						if (move_uploaded_file($_FILES['foto']['tmp_name'], $ziel)) {
							
							$form_ausgeben = false;
						
							$sql = "INSERT INTO wst (bezeichnung, geheim, regal, reihe, fach, menge, rohteil, kunde, maschnr, maschtyp, stueckzeit, programmierer, werkstoff, foto, kommentar)".
								"VALUES ('$bezeichnung', '$geheim', '$regal', '$reihe', '$fach', '$menge', '$rohteil', '$kunde', '$maschnr', '$maschtyp', '$stueckzeit', '$programmierer', '$werkstoff', '$foto', '$kommentar')";
	
													
							$ergebnis = mysqli_query($db, $sql)
								or die('Fehler bei Datenbankabfrage.');
								
							
							
							// Wenn der Datenbank ein Benutzer übermittelt wurde, soll die Meldung kommen: Benutzer erfolgreich angelegt!
							if ($ergebnis) {
								?><div id="box">
									 <div id="green">WST wurde erfolgreich angelegt!</div><br /><br />
								   <input type=button onClick="window.location.href='user_all.php'" value="zur WST" class="grau" />
									
								</div><?php 
							}
						}
					
					}
					else {
						$form_ausgeben = true;
						$feedback = true;
						
					}
					
					
				}
				
				//abgeschickt nein
				else {
					$form_ausgeben = true;
					//Radiobutton selected Wert festlegen
						$geheim = 0;
				}
				
				if ($form_ausgeben) {
            ?>
        
       
        
        
    	<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"  >
        <div id="box">
        <!-- Aktion noch hinzufügen zu Link alles auf einem Button  onclick="window.location.href='user_all.php'""-->
              <input name="submit" type="submit"  value="anlegen" class="grau" />
        </div>
        <div id="box_2_col" style="height:78px; float:left;">
                  	<table border="0">
                                         
                        <tr>
                            <td><label for="bezeichnung">Bezeichnung </label></td>
                            <td><input style="margin-left:10px;" id="bezeichnung" name="bezeichnung" class="element text medium" type="text" maxlength="255" value="<?php echo $bezeichnung; ?>"/></td>
                        </tr>
                        <tr>
                            <td><label for="geheim"></label></td>
                            <td><input style="margin-left:12px;" id="ja" name="geheim" type="radio" <?php 
							// Wenn ein Feld nicht ausgefüllt wurde und der Nutzer dieses ergänzen soll, muss hier geprüft werden, welcher Radiobutton zuvor schon geklickt wurde
							if( $_POST['geheim'] == 1 ) { echo "checked='checked'";  }?>value="1"> geheim
                            <input style="margin-left:12px;" id="nein" name="geheim" type="radio" <?php if( $_POST['geheim'] == 2 ) {echo "checked='checked'";}?> value="2"/> frei</td>
                        </tr>
                        
                      </table>
                  
        </div>

        <div id="box_2_col" style="float:right;">
                  
                      <table border="0">
                            <tr>
                                <td><label for="lagerort">Lagerort </label></td>
                                <td>
                                    <input style="margin-left:10px;" id="lagerort" name="regal" class="element text small" type="text" size="1" maxlength="3" value="<?php echo $regal; ?>"/> /
                                    <input id="lagerort" name="reihe" class="element text small" type="text" size="1" maxlength="3" value="<?php echo $reihe; ?>"/> /
                                    <input id="lagerort" name="fach" class="element text small" type="text" size="1" maxlength="3" value="<?php echo $fach; ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="menge">Menge </label></td>
                                <td>
                                    <input style="margin-left:10px;" id="lagerort" name="menge" class="element text small" type="text" size="1" maxlength="2" value="<?php echo $menge; ?>"/> 
                                    
                                </td>
                            </tr>
                            <tr>
                                <td><label for="rohteil">Rohteil vorhanden</label></td>
                                <td><input style="margin-left:12px;" id="ja" name="rohteil" type="radio" value="1"
								
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
                            <!--AUTO-VERVOLLSTÄNDIGUNG einbauen-->
                                <td><label for="kunde">Kunde </label></td>
                                <td><input style="margin-left:62px;" id="kunde" name="kunde" class="element text medium" type="text" maxlength="255" value="<?php echo $kunde; ?>"/></td>
                            </tr>
                           <!--<tr>
                            <td><label for="branche">Branche </label></td>
                                                       
                            <td style="padding-left:63px;"colspan="3">
                                    
                                    
                                    <!--MEG02 = Zuweisung, dass nur eins angeweählt werden kann
                                    
                                    <div id="meg201" class="meg_btn btngrp_MEG02" onClick="gf_toggle_btn_with_ddlb('#meg201', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_201_4multistate.png)" title="Aerospace"></div>
                                    <div id="meg202" class="meg_btn btngrp_MEG02" onClick="gf_toggle_btn_with_ddlb('#meg202', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_202_4multistate.png)" title="Automotive"></div>
                                    <div id="meg203" class="meg_btn btngrp_MEG02" onClick="gf_toggle_btn_with_ddlb('#meg203', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_203_4multistate.png)" title="Medical"></div>
                                    <div id="meg204" class="meg_btn btngrp_MEG02" onClick="gf_toggle_btn_with_ddlb('#meg204', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_204_4multistate.png)" title="Mechanical Engineering"></div>
                                    <div id="meg205" class="meg_btn btngrp_MEG02" onClick="gf_toggle_btn_with_ddlb('#meg205', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_205_4multistate.png)" title="Precision Technology"></div>
                                    
                                    
                                   
                                    
                                    <select name="aerospace" size="1" id="meg202_ddlb" class="meg_ddlb ddlbgrp_MEG02" style="display:none">
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
                            </tr>-->
                      </table>
       	 </div>
         <div id="box">
                      <table border="0">
                           <!-- <tr>
                                <td><label  for="technologie">Technologie </label></td>
                                <td  style="padding-left:25px;" colspan="3">
                                    <input type="hidden">
                                    <div class="meg_group" id="MEG_GROUP_MEG01">
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
                            </tr>-->
                            
                            
                             
										
										
										 
                                        
                                        
                                        
                                       
                            <!--<tr>
                            	<td><label for="baureihen">Baureihen </label></td>
                                <td style="padding-left:25px;" colspan="3">
                                    
                                    <div class="meg_group" id="MEG_GROUP_MEG01">
                                    	<div class="meg_subgroup" id="MEG_SUBGROUP_MEG01_0">
                                    		<div id="meg401" class="meg_btn" onClick="$('#meg401').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_401_4multistate.png)" title="08">
                                            <div id="meg402" class="meg_btn" onClick="$('#meg402').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_402_4multistate.png)" title="12"></div>
                                            <div id="meg403" class="meg_btn" onClick="$('#meg403').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_403_4multistate.png)" title="15"></div>
                                            <div id="meg404" class="meg_btn" onClick="$('#meg404').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_404_4multistate.png)" title="18"></div>
                                            <div id="meg405" class="meg_btn" onClick="$('#meg405').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_405_4multistate.png)" title="MILL"></div>
                                            <div id="meg406" class="meg_btn" onClick="$('#meg406').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_406_4multistate.png)" title="BIG MILL"></div>
                                        </div>
                                    </div>
									-->		
											
                              </td>
                        	</tr>
                            <tr>
                                <td><label for="maschtyp">Maschinen-Typ </label></td>
                                <td><input style="margin-left:24px;" id="maschtyp" name="maschtyp" class="element text medium" type="text"  maxlength="255" value="<?php echo $maschtyp; ?>"/></td>
                            </tr>
                            <tr>
                                <td><label for="maschnr">Maschinen-Nr. </label></td>
                                <td><input style="margin-left:24px;" id="maschnr" name="maschnr" class="element text medium" type="text" size="7" maxlength="255" value="<?php echo $maschnr; ?>"/></td>
                            </tr>
                            
                            <tr>
                                <td><label for="stueckzeit">St&uuml;ckzeit </label></td>
                                <td><input style="margin-left:24px;" id="stueckzeit" name="stueckzeit" class="element text medium" type="text"  size="7" maxlength="255" value="<?php echo $stueckzeit; ?>"/></td>
                            </tr>
                            <tr>
                                <td><label for="programmierer">Programmierer </label></td>
                                <td><input style="margin-left:24px;" id="programmierer" name="programmierer" class="element text medium" type="text" maxlength="255" value="<?php echo $programmierer; ?>"/></td>
                            </tr>
                            
                            
                            			<?php 
										
											$sql =  "SELECT * FROM werkstoff";
								
							
											$ergebnis = mysqli_query($db, $sql)
											or die('Fehler bei Datenbankabfrage.');
											
											
											
                                        ?>
                            
                            <tr>
                                <td><label for="werkstoff">Werkstoff </label></td>
                            
                            
                                    <!--Um später einen Absendewert zu bestimmen muss value="" benutzt werden. http://de.selfhtml.org/html/formulare/auswahl.htm-->
                                    <td><select style="margin-left:24px;" name="werkstoff" >
                                        <option value="0" 
											<?php
											//MUSS NOCH ANGEPASST WERDEN
                                                if( $_POST['werkstoff'] == 0 ) {
                                                    echo "selected='selected'";
                                                  }
                                            ?> 
                                        >Bitte wählen</option>
                                        <option value="1"
											<?php 
                                                if( $_POST['werkstoff'] == 1 ) {
                                                    echo "selected='selected'";
                                                  }
                                            ?> >Aluminium</option>
                                        <option value="2"
                                        	<?php 
                                                if( $_POST['werkstoff'] == 2 ) {
                                                    echo "selected='selected'";
                                                  }
                                            ?> >Buntmetalle</option>
                                        <option value="3"<?php 
                                                if( $_POST['werkstoff'] == 3 ) {
                                                    echo "selected='selected'";
                                                  }
                                            ?> >Chromstahl</option>
                                        <option value="4"<?php 
                                                if( $_POST['werkstoff'] == 4 ) {
                                                    echo "selected='selected'";
                                                  }
                                            ?> >Gusseisen</option>
                                        <option value="5"<?php 
                                                if( $_POST['werkstoff'] == 5 ) {
                                                    echo "selected='selected'";
                                                  }
                                            ?> >Kunststoff</option>
                                        <option value="6"<?php 
                                                if( $_POST['werkstoff'] == 6 ) {
                                                    echo "selected='selected'";
                                                  }
                                            ?> >Magnesium</option>
                                        <option value="7"<?php 
                                                if( $_POST['werkstoff'] == 7 ) {
                                                    echo "selected='selected'";
                                                  }
                                            ?> >Sonstige</option>
                                        <option value="8"<?php 
                                                if( $_POST['werkstoff'] == 8 ) {
                                                    echo "selected='selected'";
                                                  }
                                            ?> >Stahl</option>
                                        <option value="9"<?php 
                                                if( $_POST['werkstoff'] == 9 ) {
                                                    echo "selected='selected'";
                                                  }
                                            ?> >Titan</option></select>
                                         
                                        
                                    </td>
                                </tr>
                      </table>
         </div>
        
        
       
        	<div id="box">
            	<label for="Bild">Bild </label>
                <input type="file" id="foto" name="foto" /><?php echo $foto; ?></input>
                
            </div>
            
            <div id="box">
                  		<table border="0">
                            
                            <tr>
                                    <td><label  for="kommentar">Kommentar </label></td>
                                    <td  style="padding-left:19px;" colspan="3"><textarea style="margin-left:25px;" id="kommentar" name="kommentar" cols="30" rows="2" value""><?php echo $kommentar; ?></textarea></td>
    						</tr>
                        </table>
                  
          	</div>
        <form>
           <?php 
			}
			
			// Wenn nicht alle Felder ausgefüllt sind wird feedback auf true gesetzt und hier dann geprüft. 
			// Wenn true, dann Aufforderung: Bitte alles Felder ausfüllen!
			if ($feedback) {
				?><div id="box"><div id="red">Bitte vollst&auml;ndig ausf&uuml;llen!</div></div><?php 
            }

			?>	
			
    
    	
      </div>  
   
</div>