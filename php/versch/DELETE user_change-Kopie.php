<?php include("base.php");?>

<div id="page">
	<div id="heading"></div>
    <div id="navi">
          <?php include("navi.php");?>
    </div>



	<?php
	
	
	
		
		
		
	// Die Benutzer_ID wird von der URL übernommen 
	// Wenn keine GET_benutzer id vorhanden ist soll er die id = 1 setzen
	if (isset($_GET['ben_id'])) {
		$id = $_GET['ben_id'];
	}
	else {
		$id = 1;
	}
	
	$sql = "SELECT * FROM user WHERE ben_id = $id";
	
	$ergebnis_get = mysqli_query($db, $sql)
				or die('Fehler bei Datenbankabfrage1.');
		
	
	$zeile =  mysqli_fetch_array($ergebnis_get);
	
	
	
						
	//NEUE DATEN EINGEBEN
	//Prüfen ob das Formular schon einmal abgeschickt wurde
	
	if (!isset($_POST['submit'])) {
	
		// Variablen füllen
		$benutzername_new = $_POST['benutzername'];
		$nam_newe = $_POST['name'];
		$password_set_new = $_POST['password_set'];
		$rolle_new = $_POST['rolle'];
	
	
	
		
		//Initialisierung der Variable um zu prüfen ob Textfelder leer sind
		$form_ausgeben = false;
		$feedback = false;
	
					if ((!empty($benutzername)) &&  (!empty($name)) && (!empty($password_set)) && (!empty($rolle))) {
						$form_ausgeben = false;
					
						$new = "INSERT INTO user (benutzername, name, password_set, rolle)".
							"VALUES ('$benutzername_new', '$name_new', '$password_set_new', '$rolle_new')";
							
						
						
						
						$ergebnis = mysqli_query($db, $sql)
							or die('Fehler bei Datenbankabfrage2.');
							
						
						
						// Wenn der Datenbank ein Benutzer übermittelt wurde, soll die Meldung kommen: Benutzer erfolgreich angelegt!
						if ($ergebnis) {
							?><div id="box">
                            	 <div id="green">Benutzer wurde erfolgreich angelegt!</div><br /><br />
                               <input type=button onclick="window.location.href='user_all.php'" value="zur Benutzerübersicht" class="grau" />
                            	
                            </div><?php 
						}
						
					
					}
					else {
						$form_ausgeben = true;
						$feedback = true;
					}
					
					
				}
				
	
	else {
		$form_ausgeben = true;
		echo "Das Formular wird ausgeben weil der submit-Button noch nicht geklickt wurde";
	}
	
		
	?>



    <div id="main">
    	<div id="pagehead"><span>Benutzer bearbeiten</span></div>
    	 <form action="<?php echo $_SERVER['PHP_SELF'];?>">
        <div id="box">
        <!-- Aktion noch hinzufügen zu Link alles auf einem Button-->
              <input name="user_change" type="submit" value="&auml;ndern" class="grau" />
        </div>
        <div id="box">
        	<table border="0">
            <!--Die Werte die im Textfeld stehen, müssen aus der DB ausgelesen werden-->
                        <tr>
                            <td><label for="benutzername">Benutzername </label></td>
                            <td><input style="margin-left:10px;" id="benutzername" name="benutzername" class="element text medium" type="text" maxlength="10" value="<?php echo $zeile['benutzername']; ?>"/></td>
                        </tr>
                        
                        <tr>
                            <td><label for="name">Name </label></td>
                            <td><input style="margin-left:10px;" id="name" name="name" class="element text medium" type="text" maxlength="255" value="<?php echo $zeile['name']; ?>"/></td>
                        </tr>
                        
                        <tr>
                            <td><label for="password_set">Passwort </label></td>
                            <td><input style="margin-left:10px;" id="password_set" name="password_set" class="element text medium" type="text" maxlength="255" value="<?php echo $zeile['password_set']; ?>"/></td>
                        </tr>
                        
                        <tr>
                            <td><label for="rolle">Rolle </label></td>
                            
                            
                            <!--Um später einen Absendewert zu bestimmen muss value="" benutzt werden. http://de.selfhtml.org/html/formulare/auswahl.htm-->
                            <td><select style="margin-left:10px;" name="rolle" >
                                    <option value="" selected="selected">
									
									<?php  
                                    
                                    if ($zeile['rolle'] == 1) {
                                        ?>Administrator<?php ;
                                    }
                                    if ($zeile['rolle'] == 2) {
                                        ?>Hauptnutzer<?php ;
                                    }
                                    if ($zeile['rolle'] == 3) {
                                        ?>App-Benutzer<?php ;
                                    }
                                    if ($zeile['rolle'] == 4) {
                                       ?>User<?php ;
                                    }
                                    
                                    
                                    ?> </option>
                                    <option value="1">Administrator</option>
                                    <option value="2">Hauptnutzer</option>
                                    <option value="3">App-Benutzer</option>
                                    <option value="4">User</option>
                                </select>
                            </td>
                         </tr>
            </table>
		</div>	<?php 
			
				// Wenn nicht alle Felder ausgefüllt sind wird feedback auf true gesetzt und hier dann geprüft. 
				// Wenn true, dann Aufforderung: Bitte alles Felder ausfüllen!
				if ($feedback) {
					?><div id="box"><div id="red">Bitte vollst&auml;ndig ausf&uuml;llen!</div></div><?php 
					echo "hier";

			}?>	
        
        
    
    	</form>
    
    
    <?php 
		
	
	
	
	?>
    
    
    
    </div>
    
</div>