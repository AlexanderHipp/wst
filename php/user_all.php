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

    <div id="main">
    	<div id="pagehead"><span>Benutzer</span></div>
    	<div id="box">
              <input name="user_new" class="grau" type=button onClick="window.location.href='user_edit.php'" value="Benutzer anlegen"/>
        </div>
        
        <?php
			
			$sql = "SELECT * FROM user ORDER BY aktiv ASC, ben_id DESC";
			$ergebnis = mysqli_query($db, $sql) or die('Es konnten keine Informationen über die User abgerufen werden. Bitte versuchen Sie es noch einmal.');
			
		?>	
			
	  
        <div id="box">
        
			<?php echo '<table border ="0">';
                    echo '<tr style="border-bottom:solid 1px #cacaca;">';
                    echo '<th style="width:200px;" scope="col">Benutzername</th>';
                    echo '<th style="width:400px;" scope="col">Name</th>';
                    echo '<th style="width:160px;" scope="col">Rolle</th>';
					echo '<th style="width:20px;" scope="col"></th>';
                    echo '</tr>';
                  while ($zeile = mysqli_fetch_array($ergebnis)) {
                    echo '<tr>';
					
					// Die Benutzer Identifikationsnummer wird aus der DB gelesen und der Variable $ben_id übergeben
					$ben_id = $zeile['ben_id'];
					
					
					
                    // Hier wird der URL die ben_id übergeben damit er weiß welches bearbeiten PHP er aufrufen soll
                    echo '<td><a href="user_change.php?ben_id=' . $ben_id . '">' . $zeile['benutzername'] . '</a></td>';
                    echo '<td>'. $zeile['name'] . '</td>';
                    
                    // Boolean Wert zuordnen
                    if ($zeile['rolle'] == 1) {
                        echo '<td>Administrator</td>';
                    }
                    if ($zeile['rolle'] == 2) {
                        echo '<td>Hauptnutzer</td>';
                    }
                    if ($zeile['rolle'] == 3) {
                        echo '<td>App-Benutzer</td>';
                    }
                    if ($zeile['rolle'] == 4) {
                        echo '<td>User</td>';
                    }
                    
            		?><td><?php if ($zeile['aktiv'] == 1) {echo 'aktiv';} else {echo 'inaktiv';}?></td><?php
					echo '</tr>';
				}
                 echo '</table>';
				 
				//if (isset($_POST['$delete'])) {
					//$del = "DELETE FROM user WHERE ben_id = '$ben_id'";
					//$delete = mysqli_query($db, $del) or die('Es konnte nicht aus der Datenbank gelöscht werden. Überprüfen Sie bitte Ihre Eingabe.');	
				//}
            ?>	
        </div>
        	<?php 
        		
    		
	// ENDE IF SESSION
	}
	?>
    </div>
    
</div>
