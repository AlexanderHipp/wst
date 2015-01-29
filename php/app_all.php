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
		if (!isset($_SESSION['ben_id']) OR ($_SESSION['rolle'] == 2) OR ($_SESSION['rolle'] == 4)) { 
			?><div id="box_anmelden" style="margin-top:10px;">Bitte zuerst <a href="index.php" style="text-decoration:underline;">anmelden</a></div><?php
			exit();
		} else { 
	?>
    
            <div id="navi">
                <?php include("navi.php");?>
            </div>
            
            <?php 
                // tabelle:app Daten werden geholt
                $sql_app = "SELECT * FROM app";
                $ergebnis_app = mysqli_query($db, $sql_app) or die('Es konnten keine Informationen über das Applikationsblatt abgerufen werden. Bitte versuchen Sie es noch einmal.');
            ?>	
        
            <div id="main">
                <div id="pagehead"><span>unvollst&auml;ndige Applikationsbl&auml;tter / incomplete Application Sheets</span></div>
                
                <div id="box">
                    <?php 
                        echo '<table border ="0">';
                            echo '<tr style="border-bottom:solid 1px #cacaca;">';
                                echo '<th style="width:500px;" scope="col">Werkst&uuml;ck</th>';
                                echo '<th style="width:200px;" scope="col">zust&auml;ndig</th>';
                                echo '<th style="width:40px;text-align:center;" scope="col"><img src="../img/ger.png" width="20" height="11" /></th>';
                                echo '<th style="width:40px;text-align:center;" scope="col"><img src="../img/eng.png" width="20" height="11" /></th>';
                                echo '<th style="text-align:center;"></th>';
                            echo '</tr>';
                            
                            while ($zeile_app = mysqli_fetch_array($ergebnis_app)) {
                                // Pub_nr_de aus der tabelle:app wird einer variablen übergeben
                                $pub_nr_de = $zeile_app['pub_nr_de'];
                                    
                                // tabelle:wst Daten holen
                                $sql_wst = "SELECT * FROM wst WHERE lfd_nr = $pub_nr_de";
								
                                $ergebnis_wst = mysqli_query($db, $sql_wst) or die('Es konnten keine Informationen über das Werkstück abgerufen werden. Bitte versuchen Sie es noch einmal.');
                                $zeile_wst = mysqli_fetch_array($ergebnis_wst);
                                    
                                // lfd_nr aus der tabelle:wst wird einer variable übergeben, um den Link zu wst_info.php dynamisch zu machen
                                $lfd_nr = $zeile_wst['lfd_nr'];
                                    
                                $zuweisung_de = $zeile_wst['zuweisung_de'];
                                $zuweisung_en = $zeile_app['zuweisung_en'];
                                    
                                // tabelle:user Daten holen
                                $sql_user = "SELECT * FROM user WHERE ben_id = $zuweisung_de";
								
								
                                $ergebnis_user = mysqli_query($db, $sql_user) or die('Es konnten keine Informationen über die User abgerufen werden. Bitte versuchen Sie es noch einmal.1');
                                $zeile_user = mysqli_fetch_array($ergebnis_user);
                                    
                                // tabelle:app_en Daten holen
                                $sql_app_en = "SELECT * FROM app_en WHERE pub_nr_en = $pub_nr_de";
                                $ergebnis_app_en = mysqli_query($db, $sql_app_en) or die('Es konnten keine Informationen über das Applikationsblatt (englisch) abgerufen werden. Bitte versuchen Sie es noch einmal.');
                                $zeile_app_en = mysqli_fetch_array($ergebnis_app_en);
                              
							  	//tabelle:user Daten holen
							  	// Es wird geprüft, ob das WST einem Nutzer zugewiesen wurde oder nicht. KEINE = 6
                                if ($zeile_wst['de'] != 6) {
                                    // Es wird überprüft ob schon eine zuweisung_en vorliegt wenn nicht, dann soll auch keine Abfrage stattfinden
									if ($zuweisung_en)
									{
										$sql_user_en = "SELECT * FROM user WHERE ben_id = $zuweisung_en";
										$ergebnis_user_en = mysqli_query($db, $sql_user_en) or die('Es konnten keine Informationen über die User abgerufen werden. Bitte versuchen Sie es noch einmal2.');
										$zeile_user_en = mysqli_fetch_array($ergebnis_user_en);
									}
                                }
                                    
                                // Prüfen ob beide Applikaitonsblätter schon bearbeiten wurden, wenn ja soll das WST gar nicht erst angezeigt werden
                                if (($zeile_app['de'] == 1) AND ($zeile_app_en['en'] == 1) OR ($zeile_wst['zuweisung_de'] == 0)) {
                                    //Nichts ausgeben
                                } else {
                                    //Ausgabe
                                    echo '<tr>';
                                        echo '<td><a href="wst_info.php?lfd=' . $lfd_nr . '">' . $zeile_wst['bezeichnung'] . '</a></td>';
                                            
                                        if ($zeile_app['de'] == 0) {
                                            echo '<td>'. $zeile_user['name'] . '</td>';
                                        } else {
                                            echo '<td>'. $zeile_user_en['name'] . '</td>';
                                        }							
                                        ?>
                                        <td style="text-align:center;">
                                            <?php 
                                                if ($zeile_app['de'] == 1) {
                                                    ?><img src='../img/pdf_de_app.png' border="0"/><?php
                                                } else {
                                                    echo "<img src='../img/pdf_de_app_grau.png'  />";
                                                }
                                            ?>
                                        </td>
                                        <td style="text-align:center;">
                                            <?php 
                                                // Nur wenn das deutsche schon ausgefüllt wurde kann das englische farbig gemacht werden
                                                if (($zeile_app_en['en'] == 1) AND ($zeile_app['de'] == 1)) {
                                                        ?><img src='../img/pdf_en_app.png' border="0"/><?php
                                                }
                                                else {
                                                    echo "<img src='../img/pdf_en_app_grau.png' />";
                                                }
                                            ?>
                                        </td>
                                        <td style="text-align:center;">
                                            <?php
                                                // Wenn noch keine Sprache bearbeitet wurde wird erstellen angezeigt und zum deutschen wetiergeleitet
                                                if (($zeile_app['de'] == 0) && ($zeile_app_en['en'] == 0)) {
                                                    // publikationsnumemr als pub mit geben, damit diese nachher durch $_GET geholt werden kann
                                                    echo '<a href="app_edit_de.php?pub=' . $pub_nr_de . '">erstellen</a>';
                                                }
                                                    
                                                // Wenn das deutsche schon erstellt wurde wird zum englischen weitergeleitet
                                                if (($zeile_app['de'] == 1) && ($zeile_app_en['en'] == 0)) {
                                                    echo '<a href="app_edit_en.php?pub=' . $pub_nr_de . '">edit</a>';
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php 
                                }
                            }
                        ?>
                        </table>
                    </div>
    
    <?php 
		// ENDE IF SESSION
		}
	?>
    
    </div>
</div>