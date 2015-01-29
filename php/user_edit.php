<?php 
/** 
*	@project: Werkstück-Management CHIRON-WERKE GmbH & Co. KG
*	@author: Alexander Hipp
*	@date: 01.04.2012
*/

// Fehlermeldung zurücksetzen.
$feedback = 0;

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

    <div id="main">
    	<div id="pagehead"><span>Benutzer anlegen</span></div>
        
		
		<?php		
				$user_edit = $_POST['user_edit'];
				
				// Formular abschicken
				if ($user_edit) {
				
					// Variablen füllen
					$benutzername = $_POST['benutzername'];
					$name = $_POST['name'];
					$password_set = $_POST['password_set'];
					$rolle = $_POST['rolle'];
					$email = $_POST['email'];
					$aktiv = $_POST['aktiv'];
					
					// Überprüfung ob die Pflichtfelder ausgefüllt wurden
					if ($benutzername == "") { $fb_benutzername = 1; } 
					if ($name == "") { $fb_name = 1; } 
					if ($password_set == "") { $fb_password_set = 1; } 
					if ($email == "") { $fb_email = 1; } 
					if ($rolle == "") { $fb_rolle = 1; } 
					if ($aktiv == "") { $fb_aktiv = 1; } 
					if (($benutzername == "") OR ($name == "") OR ($password_set == "") OR ($email == "") OR ($rolle == "") OR ($aktiv == "")) { $feedback = 1; } else {		
					
						$sql = "INSERT INTO user (benutzername, name, password_set, rolle, email, aktiv)".
							"VALUES ('$benutzername', '$name', '$password_set', '$rolle', '$email', '$aktiv')";
						
						$ergebnis = mysqli_query($db, $sql) or die('Der Datenbank konnten keine Informationen übermittelt werden. Überprüfen Sie bitte Ihre Eingabe.');
				
					}
				}
				
        ?>
        
    	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"  >
        <div id="box">
        	<?php 
				// Wenn ein Ergebnis vorhanden ist, also ein Werkstück erfolgreich angelegt wurde, dann soll anstatt des "anlegen"-Buttons ein "weiter"-Button erscheinen
				if ($ergebnis) {
					?><input type=button onClick="window.location.href='user_all.php'" value="weiter" class="grau" /><?php 
					 	$feedback = 2;
				} else {
					?><input type="submit" name="user_edit" class="grau" value="anlegen"/><?php 
				}

            // Wenn nicht alle Felder ausgefüllt sind wird feedback auf true gesetzt und hier dann geprüft. 
			if ($feedback == 1) {?>
				<div id="red" style="padding-top:10px;">Bitte alle Felder vollst&auml;ndig ausf&uuml;llen!</div>
			<?php } 
			
			if ($feedback == 2) {?>
				<div id="green" style="padding-top:10px;">Ein neuer Benutzer wurde erfolgreich angelegt!</div>
			<?php } ?>
            
              
        </div>
        <div id="box">
        	<table border="0">
                        <tr>
                            <td><label <?php if ($fb_benutzername == 1) { echo 'class="red_fb"'; } ?> for="benutzername">Benutzername </label></td>
                            <td><input style="margin-left:10px;" id="benutzername" name="benutzername" class="element text medium" type="text" maxlength="10" value="<?php echo $benutzername; ?>"/></td>
                        </tr>
                        
                        <tr>
                            <td><label <?php if ($fb_name == 1) { echo 'class="red_fb"'; } ?> for="name">Name </label></td>
                            <td><input style="margin-left:10px;" id="name" name="name" class="element text medium" type="text" maxlength="25" value="<?php echo $name; ?>"/></td>
                        </tr>
                        
                        <tr>
                            <td><label <?php if ($fb_password_set == 1) { echo 'class="red_fb"'; } ?> for="password_set">Passwort </label></td>
                            <td><input style="margin-left:10px;" id="password_set" name="password_set" class="element text medium" type="text" maxlength="10" value="<?php echo $password_set; ?>"/></td>
                        </tr>
                        
                         <tr>
                            <td><label <?php if ($fb_email == 1) { echo 'class="red_fb"'; } ?> for="email">E-Mail </label></td>
                            <td><input style="margin-left:10px;" id="email" name="email" class="element text medium" type="text" maxlength="25" value="<?php echo $email; ?>"/></td>
                         </tr>
                        
                        <tr>
                            <td><label <?php if ($fb_rolle == 1) { echo 'class="red_fb"'; } ?> for="rolle">Rolle </label></td>
                            
                            
                            <!--Hier ist es noch wichtig dass bei falscher Eingabe der schon eingebene Wert übernommen wird-->
                            <td><select style="margin-left:10px;" name="rolle" type="int">
                            		<option value=""  <?php if( $_POST['rolle'] == '') {echo "selected='selected'"; }?> >Bitte w&auml;hlen</option>
                                    <option value="1" <?php if( $_POST['rolle'] == 1 ) {echo "selected='selected'"; }?> >Administrator</option>
                                    <option value="2" <?php if( $_POST['rolle'] == 2 ) {echo "selected='selected'"; }?> >Hauptnutzer</option>
                                    <option value="3" <?php if( $_POST['rolle'] == 3 ) {echo "selected='selected'"; }?> >App-Benutzer</option>
                                    <option value="4" <?php if( $_POST['rolle'] == 4 ) {echo "selected='selected'"; }?> >User</option>
                                </select>
                               
                            </td>
                        </tr>
                        <tr>
                            <td><label <?php if ($fb_aktiv == 1) { echo 'class="red_fb"'; } ?> for="name">Aktiv </label></td>
                            <td><input style="margin-left:10px;margin-right:5px;" id="aktiv" name="aktiv" class="element text medium" type="text" size="1" maxlength="1" value="<?php echo $aktiv; ?>"/> (1) aktiv, (2) inaktiv</td>
                        </tr>
                        
            </table>

         
        </div>
        
        </form>
        
        
           <?php 
				}
				
		    ?>	
			
    
    </div>  
   
</div>