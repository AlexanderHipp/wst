<?php 
/** 
*	@project: Werkstück-Management CHIRON-WERKE GmbH & Co. KG
*	@author: Alexander Hipp
*	@date: 01.04.2012
*/

if(isset($_POST['delbutton'])) {header("Location: #");} 

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
    
    	<div id="pagehead"><span><?php if ($la == en) {echo 'Pick lists';} else {echo 'Entnahmelisten';} ?></span></div>
    	
        
        <div id="box" style="height:30px;">
           <?php
		    	if (($_SESSION['rolle'] == 1) OR ($_SESSION['rolle'] == 2)) {
					// Listenlogik
					include("list_entnahme.php");			
				}
			?>
            
        </div>
        
        <?php
			// Hier werden alle Daten aus der tabelle:entnahmeliste geladen und in $erg_list gespeichert	
			if ($_SESSION['rolle'] == 1) {
				$list = "SELECT * FROM entnahmeliste WHERE active = 0 ORDER BY erstellungsdatum DESC";
			} else {
				$benutzer = $_SESSION['ben_id'];
				$list = "SELECT * FROM entnahmeliste WHERE ersteller = $benutzer AND WHERE active = 0 ORDER BY erstellungsdatum DESC";
			}
			$erg_list = mysqli_query($db, $list) or die('Es konnten keine Informationen über die Entnahmelisten abgerufen werden. Bitte versuchen Sie es noch einmal.');
		?>
        
         
        <div id="box">
        <?php	
				echo '<table border ="0">';
					echo '<tr style="border-bottom:solid 1px #cacaca;">';
						echo '<th style="width:400px;" scope="col"></th>';
						echo '<th style="width:150px;" scope="col">';
						if ($la == en) {echo 'Editor';} else {echo 'Ersteller';}
						echo '</th>';
						echo '<th style="width:200px;" scope="col">';
						if ($la == en) {echo 'Date';} else {echo 'Datum';}
						echo '</th>';
						//echo '<th style="width:100px;" scope="col">WST-Anzahl</th>';

						echo '<th style="width:20px;" scope="col"></th>';
					echo '</tr>';
		        
				while ($zeile = mysqli_fetch_array($erg_list)) {
              	  	echo '<tr>';
						
						
						
						// Aus der Tabelle entnahmeliste wird die ersteller ID der Variable $ersteller zugewiesen
						$ersteller = $zeile['ersteller'];
						
						// Es wird alles aus der tabelle:user geladen wo die ersteller ID aus der tabelle:entnahmeliste und die benutzer_id aus der tabelle:user identisch sind. FREMDSCHLÜSSEL
						$user = "SELECT * FROM user WHERE ben_id = $ersteller";
						
						$erg_user = mysqli_query($db, $user) or die('Es konnten keine Informationen über die User abgerufen werden. Bitte versuchen Sie es noch einmal.');
						
						// Hier wird das Array in $zeile_user gespeichert	
						$zeile_user = mysqli_fetch_array($erg_user);
						
						
						
						
						// Datum umurechnen
						$time = $zeile['erstellungsdatum'];
						$timestamp = strtotime($time);
						
					
						// Die EntnahmelistenID wird aus der DB gelesen und der Variable $el übergeben
						$el = $zeile['el_id'];
					
						// Hier wird der URL die el übergeben damit er weiß welches PHP_Einzelansicht_Script er aufrufen soll
						echo '<td><a href="entnahme_info.php?el=' . $el . '">' . $zeile['el_bez'] . '</a></td>';
						echo '<td>'. $zeile_user['name'] . '</td>';?>
                       
						<td>  
							<?php 
							// Ausgabe des Datums
							echo date("d.m.Y", $timestamp); ?>
                        </td>
                        
						<?php 
						
					//echo '<td>menge</td>';
					?>
		 				
					
					<td>	<!--Button zum Löschen einzelner Entnhamelisten-->
                            <form action="delete.php?del=<?php echo $el; ?>" method="post" rel="nofollow" >
                    			<input name="delbutton" type="submit" value="X" class="grau" >
                            </form>


                      </td>
                     <?php
					 echo '</tr>';
                   
				}
				echo '</table>';
		?>
              

        
        </div>
    
    	
   
    	<?php 
	// ENDE IF SESSION
	}
?>
    
    
    </div>
    
</div>