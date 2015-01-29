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
		if (!isset($_SESSION['ben_id']) OR ($_SESSION['rolle'] != 1)) {
			?>
			<div id="box_anmelden" style="margin-top:10px;">Bitte zuerst <a href="index.php" style="text-decoration:underline;">anmelden</a></div><?php
			exit();
		} else { 
	?>
    <div id="navi">
          <?php include("navi.php");?>
    </div>
    	<?php
				// Daten holen
				$id = $_GET['ben_id'];
				$sql = "SELECT * FROM user WHERE ben_id = $id";
				
				$ergebnis_get = mysqli_query($db, $sql) or die('Es konnten keine Informationen über die User abgerufen werden. Bitte versuchen Sie es noch einmal.');
				$zeile =  mysqli_fetch_array($ergebnis_get);
				
				$user_change = $_POST['user_change'];
					
				// Formular abschicken	
				if ($user_change) {
					
					$benutzername = $_POST['benutzername'];
					$password_set = $_POST['password_set'];
					$name = $_POST['name'];
					$rolle = $_POST['rolle'];
					$email = $_POST['email'];
					$aktiv = $_POST['aktiv'];
					
					
					
					$user_change = $_POST['user_change'];
					
					// Daten ändern
				
					// Überprüfung ob die Pflichtfelder ausgefüllt wurden
					if ($benutzername == "") { $fb_benutzername = 1; } 
					if ($name == "") { $fb_name = 1; } 
					if ($password_set == "") { $fb_password_set = 1; } 
					if ($email == "") { $fb_email = 1; } 
					if ($rolle == "") { $fb_rolle = 1; } 
					if ($aktiv == "") { $fb_aktiv = 1; } 
					if (($benutzername == "") OR ($name == "") OR ($password_set == "") OR ($email == "") OR ($rolle == "") OR ($aktiv == "")) { $feedback = 1; } else {	
					
						$sql = "UPDATE user 
								SET benutzername = '$benutzername',
									password_set = '$password_set',
									name = '$name',
									rolle = '$rolle',
									email = '$email',
									aktiv = '$aktiv'
								WHERE ben_id = '$id'";
								
						$ergebnis = mysqli_query($db, $sql)	or die('Der Datenbank konnten keine Informationen übermittelt werden. Überprüfen Sie bitte Ihre Eingabe.');
						
					}
				}
						
				
				
				
			?>
    
    
    
	
     <div id="main">
     	<div id="pagehead"><span>Benutzer bearbeiten</span></div>
    	
        	<form  method="post" action="user_change.php?ben_id=<?php echo $id; ?>">
        
        <div id="box">
        	<?php 
                // Wenn ein Ergebnis vorhanden ist, also ein Werkstück erfolgreich angelegt wurde, dann soll anstatt des "anlegen"-Buttons ein "weiter"-Button erscheinen
                if ($ergebnis) {
					?>
						<script type="text/javascript">
							location.href="user_change.php?ben_id=<?php echo $id; ?>";
						</script>
						<input type=button onClick="window.location.href='user_all.php'" value="weiter" class="grau" /><?php 
                        $feedback = '<div id="green">Der Benutzer wurde erfolgreich geändert!</div>';
                } else {
                    ?>
                    	<input type=button onClick="window.location.href='user_all.php'" value="zur Übersicht" class="grau" />
                        <input type="submit" name="user_change" class="grau" value="ändern"/>
					<?php 
                }
    
				// Wenn nicht alle Felder ausgefüllt sind wird feedback auf true gesetzt und hier dann geprüft. 
				if ($feedback == 1) {?>
					<div id="red" style="padding-top:10px;">Bitte alle Felder vollst&auml;ndig ausf&uuml;llen!</div>
				<?php }  ?>
        </div>
        
        <div id="box">
        	<table border="0">
            
                        <tr>
                            <td><label <?php if ($fb_benutzername == 1) { echo 'class="red_fb"'; } ?> for="benutzername">Benutzername </label></td>
                            <td><input style="margin-left:10px;" id="benutzername" name="benutzername" class="element text medium" type="text" maxlength="10" value="<?php echo $zeile['benutzername']; ?>"/></td>
                        </tr>
                        <tr>
                            <td><label <?php if ($fb_name == 1) { echo 'class="red_fb"'; } ?> for="name">Name </label></td>
                            <td><input style="margin-left:10px;" id="name" name="name" class="element text medium" type="text" maxlength="255" value="<?php echo $zeile['name']; ?>"/></td>
                        </tr>
                        <tr>
                            <td><label <?php if ($fb_password_set == 1) { echo 'class="red_fb"'; } ?> for="password_set">Passwort </label></td>
                            <td><input style="margin-left:10px;" id="password_set" name="password_set" class="element text medium" type="text" maxlength="16" value="<?php echo $zeile['password_set']; ?>"/></td>
                        </tr>
                        <tr>
                            <td><label <?php if ($fb_email == 1) { echo 'class="red_fb"'; } ?> for="name">E-Mail </label></td>
                            <td><input style="margin-left:10px;" id="name" name="email" class="element text medium" type="text" maxlength="25" value="<?php echo $zeile['email']; ?>"/></td>
                         </tr>
                        <tr>
                            <td><label <?php if ($fb_rolle == 1) { echo 'class="red_fb"'; } ?> for="rolle">Rolle </label></td>
                            
                            
                            <!--Um später einen Absendewert zu bestimmen muss value="" benutzt werden. http://de.selfhtml.org/html/formulare/auswahl.htm-->
                            <td><select style="margin-left:10px;" name="rolle" >
                                    <option value="1" <?php if ($zeile['rolle'] == 1) { echo 'selected="selected"'; } ?> >Administrator</option>
                                    <option value="2" <?php if ($zeile['rolle'] == 2) { echo 'selected="selected"'; } ?> >Hauptnutzer</option>
                                    <option value="3" <?php if ($zeile['rolle'] == 3) { echo 'selected="selected"'; } ?> >App-Benutzer</option>
                                    <option value="4" <?php if ($zeile['rolle'] == 4) { echo 'selected="selected"'; } ?> >User</option>
                                </select>
                            </td>
                         </tr>
                        <tr>
                            <td><label <?php if ($fb_aktiv == 1) { echo 'class="red_fb"'; } ?> for="name">Aktiv </label></td>
                            <td><input style="margin-left:10px;margin-right:5px;" id="aktiv" name="aktiv" class="element text medium" type="text" size="1" maxlength="1" value="<?php echo $zeile['aktiv']; ?>"/> (1) aktiv, (2) inaktiv</td>
                        </tr>
                        
            </table>
        </div>
                        
           <?php 
			}
			?>	
		

                        
     </div>   
</div>