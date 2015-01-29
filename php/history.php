<?php 
/** 
*	@project: Werkstück-Management CHIRON-WERKE GmbH & Co. KG
*	@author: Alexander Hipp
*	@date: 01.04.2012
*/

include("base.php");?>

 		<?php
			
			//aktuelle laufende Nummer aus der URL beziehen. Für welches WST die History angezeigt werden soll!
			$lfd_nr = $_GET['lfd'];
			
	
			//Hier wird die Sprache übergeben 
			$la = $_SESSION['la']; 	
	
			//Informationen aus den Tabellen holen
			$sql_history = "SELECT * FROM history WHERE werkstueck = $lfd_nr";
			$ergebnis_history = mysqli_query($db, $sql_history) or die('Es konnten keine Positionen abgerufen werden. Bitte versuchen Sie es noch einmal.');
				
		?>
        
 		
        <div id="box" style="clear:both;">
        
			<?php echo '<table border ="0">';
                    echo '<tr style="border-bottom:solid 1px #cacaca;">';
                    echo '<th style="width:450px;" scope="col"></th>';
                    ?> <th style="width:180px;" scope="col"> <?php if ($la == en) {echo 'from';} else {echo 'von';} ?></th>
                       <th style="width:130px;" scope="col"> <?php if ($la == en) {echo 'to';} else {echo 'bis';} ?></th>
					   
					   <!--<th style="width:150px;" scope="col">Status</th>-->
                     </tr>
                  
				  <?php
				  
				  // Für jeden Eintrag wird eine Zeile angelegt und diese mit Infos gefüttert
				  while ($zeile_history = mysqli_fetch_array($ergebnis_history)) {
					 
					$position = $zeile_history['position'];
			
					$sql_entnahmeliste = "SELECT * FROM entnahmeliste WHERE el_id = $position ORDER BY von";
					$ergebnis_entnahmeliste = mysqli_query($db, $sql_entnahmeliste) or die('Es konnten keine Informationen über die Entnahmelisten abgerufen werden. Bitte versuchen Sie es noch einmal.');
					
					$zeile_entnahmeliste = mysqli_fetch_array($ergebnis_entnahmeliste);
					
						// Datum umurechnen
						$time_von = $zeile_entnahmeliste['von'];
						$timestamp_von = strtotime($time_von);
						
						$time_bis = $zeile_entnahmeliste['bis'];
						$timestamp_bis = strtotime($time_bis); 
					
						$el = $zeile_entnahmeliste['el_id'];
					
						echo '<tr>';
						echo '<td><a href="entnahme_info.php?el=' . $el . '">' . $zeile_entnahmeliste['el_bez'] . '</a></td>';
						echo '<td>'. date("d.m.Y", $timestamp_von) .'</td>';
						echo '<td>'. date("d.m.Y", $timestamp_bis) .'</td>';
						
						// zugehöriger Status aus der tabelle:status auslesen
						
						//$status = $zeile_entnahmeliste['el_status'];
						
						//$sql_status = "SELECT * FROM status WHERE st_id = $status";
						//$ergebnis_status = mysqli_query($db, $sql_status) or die('Fehler bei Datenbankabfrage sql_status.');
						
						//$zeile_status = mysqli_fetch_array($ergebnis_status);
						
						//echo '<td>'. $zeile_status['status_bezeichnung'] .'</td>';
						echo '</tr>';
		          }
                  
                 echo '</table>';
    
            ?>	
        </div>
        
        
       
        	
    </div>
    
</div>
