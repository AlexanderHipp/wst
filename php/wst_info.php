<?php
/**
*	@project: Werkstück-Management CHIRON-WERKE GmbH & Co. KG
*	@author: Alexander Hipp
*	@date: 01.04.2012
*/

include("base.php");?>

<?php
	// Hier werden die jeweiligen Werkstück-Informationen aus der GET['lfd'] gelesen
	if (isset($_GET['lfd'])) {
		$lfd_nr = $_GET['lfd'];
		$sql_wst = "SELECT * FROM wst WHERE lfd_nr = $lfd_nr";
		$ergebnis_wst = mysqli_query($db, $sql_wst) or die('Es konnten keine Informationen über das Werkstück abgerufen werden. Bitte versuchen Sie es noch einmal.');
		$zeile_wst =  mysqli_fetch_array($ergebnis_wst);

		//Um den App-Status abzufragen muss hier eine Datenbankabfrage erfolgen
		$sql_app = "SELECT * FROM app WHERE pub_nr_de = '$lfd_nr'";
		$ergebnis_app = mysqli_query($db, $sql_app) or die('Es konnten keine Informationen über das Applikationsblatt (deutsch) abgerufen werden. Bitte versuchen Sie es noch einmal.');
		$zeile_app = mysqli_fetch_array($ergebnis_app);
	}
?>
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
          <?php
		  //Um auf der Flags zu sagen auf welcher Seite man sich befindet
		  $seite = 'wst_info.php';
		  include("flags.php");?>
		  <?php include("navi.php");?>
    </div>
    		<?php
                // Hier wird die Sprache übergeben
				$la = $_SESSION['la'];
			?>



    <div id="main">
          <div id="pagehead"><span><?php if ($la == en) {echo $zeile_wst['bezeichnung_en'];} else {echo $zeile_wst['bezeichnung'];} ?></span></div>
              <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">

		  <div id="box" style="height:22px;">
                      	 <?php if ($_SESSION['rolle'] == 1) { ?>
                            <input name="aendern" value="<?php if ($la == en) {echo 'change';} else {echo 'ändern';} ?>" class="grau" type=button onClick="window.location.href='wst_change.php?lfd=<?php echo $zeile_wst['lfd_nr']; ?>'"/>
                            <!--<input name="submit"  type="submit" class="grau" value="<?php // if ($la == en) {echo 'delete';} else {echo 'löschen';} ?>"/>-->
                            <input name="app_change" value="<?php if ($la == en) {echo 'App change';} else {echo 'App ändern';} ?>" class="grau" type=button onClick="window.location.href='app_change.php?lfd=<?php echo $zeile_wst['lfd_nr']; ?>'"/>
														<?php
														if ($zeile_wst['aktiv'] == 0) {
															?><div style="float:left;color:red;margin-right:20px;font-weight:bold;">Dieses Werkstück wurde deaktiviert. Unter "ändern" kann der Status angepasst werden.</div><?php
														}


						 	}
							if (isset($_POST['submit'])) {
								$sql_wst = "DELETE FROM wst WHERE lfd_nr ='".$zeile_wst['lfd_nr']."'";
								$ergebnis_wst = mysqli_query($db, $sql_wst) or die('Es konnte nicht aus der Datenbank gelöscht werden. Überprüfen Sie bitte Ihre Eingabe.');
							}
						?>


                      <div style="margin-top:-6px;padding:0;float:right;">
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

           </div>


                  <div id="box_2_col" style="float:left;">
                  	<div style="float:right;">
						<?php
                                if ($zeile_wst['geheim'] == 1) {
                                    echo '<img src="../img/geheim.png" width="25" height="25" />';
                                }
                                if ($zeile_wst['geheim'] == 2) {
                                    echo '<img src="../img/frei.png" width="25" height="25" />';
                        		}
						?>
                    </div>

                    <table border="0">
                        <tr>
                            <td style="width:140px;"><?php if ($la == en) {echo 'Serial number';} else {echo 'Lfd. Nr.';} ?> </td>
                            <td><?php echo $zeile_wst['lfd_nr']; ?></td>
                        </tr>
                        <tr>
                        	<?php
								// Datum umurechnen
								$time = $zeile_wst['erstellungsdatum'];
								$timestamp = strtotime($time);
							?>

                            <td style="width:140px;"><?php if ($la == en) {echo 'Creation date';} else {echo 'Erstellungsdatum';} ?></td>
                            <td><?php echo date("d.m.Y", $timestamp); ?></td>

                        	<?php

								if ($zeile_wst['datum_alter'] != "") {
								// Alternatives Datum umurechnen
								$time = $zeile_wst['datum_alter'];
								$timestamp = strtotime($time);
							?>


                            <td>(<?php echo date("d.m.Y", $timestamp); ?>)</td>

                            <?php } ?>
                        </tr>

                  	</table>
                  </div>

                  <div id="box_2_col" style="float:right; height:234px;">
                  	<div id="picture_big"><img src="../img/<?php echo $zeile_wst['foto']; ?>" height="225px" /></div>
                  </div>

                  <div id="box_2_col" style="float:left;" >
                  	<table border="0">
                        <tr>
                            <td style="width:140px;"><?php if ($la == en) {echo 'Storage location';} else {echo 'Lagerort';} ?></td>
                            <td><?php echo $zeile_wst['regal']; ?> | <?php echo $zeile_wst['reihe']; ?> | <?php echo $zeile_wst['fach']; ?></td>
                        </tr>
                        <tr>
                        <!-- Verrechnung einbauen-->
                            <td style="width:140px;"><?php if ($la == en) {echo 'Quantity in stock';} else {echo 'Menge im Lager';} ?></td>
                            <td><?php echo $zeile_wst['menge_cur']; ?> <?php //echo $zeile_wst['menge']; ?></td>
                        </tr>
                        <tr>
                            <td style="width:140px;"><?php if ($la == en) {echo 'Rough part available';} else {echo 'Rohteil vorhanden';} ?></td>
                            <td><?php
									if ($zeile_wst['rohteil'] == 1) {
										if ($la == en) {echo 'yes';} else {echo 'ja';};
									}
									if ($zeile_wst['rohteil'] == 2) {
										if ($la == en) {echo 'no';} else {echo 'nein';};
									} ?>
                            </td>
                        </tr>
                  	</table>
                  </div>

                  <div id="box_2_col" style="float:left;">
                  	<table border="0">
                        <tr>
                            <td style="width:140px;"><?php if ($la == en) {echo 'Customer';} else {echo 'Kunde';} ?> </td>
                            <td><?php echo $zeile_wst['kunde']; ?></td>
                        </tr>
                        <tr>
                            <td style="width:140px; "><?php if ($la == en) {echo 'Industry';} else {echo 'Branche';} ?> </td>
                            <td>
								<?php

                                	 //Abfrage welche Bilder angezeigt werden sollen in PHP picto_info
                            		 include("picto_info_branche.php");
									 $la = $_SESSION['la'];
								?>
                            </td>
                        </tr>
                  	</table>
                  </div>

                  <div id="box_2_col" style="float:left;">
                  	<table border="0">
                        <tr>
                            <td style="width:140px;"><?php if ($la == en) {echo 'Technology';} else {echo 'Technologie';} ?> </td>
                            <td style="width:200px;">
                            	<?php
                                	//Abfrage welche Bilder angezeigt werden sollen in PHP picto_info
                            		 include("picto_info_technologie.php");
								?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:140px; height:35px;"><?php if ($la == en) {echo 'Series';} else {echo 'Baureihe';} ?> </td>
                            <td><div style="margin-left:-5px;">
								<?php
                                	//Abfrage welche Bilder angezeigt werden sollen in PHP picto_info
                            		 include("picto_info_baureihe.php");
								?></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:140px;"><?php if ($la == en) {echo 'Machine number';} else {echo 'Masch. Nr.';} ?> </td>
                            <td><?php echo $zeile_wst['maschnr']; ?></td>
                        </tr>
                        <tr>
                            <td style="width:140px;"><?php if ($la == en) {echo 'Part time';} else {echo 'Stückzeit';} ?> </td>
                            <td><?php echo $zeile_wst['stueckzeit']; ?> sec</td>
                        </tr>
                        <tr>
                            <td style="width:140px;"><?php if ($la == en) {echo 'Programmer';} else {echo 'Programmierer';} ?> </td>
                            <td><?php echo $zeile_wst['programmierer']; ?></td>
                        </tr>
                        <tr>
                            <td style="width:140px;"><?php if ($la == en) {echo 'Material';} else {echo 'Werkstoff';} ?> </td>
                            <td><?php

								if ($la == en) {
									if( $zeile_wst['werkstoff'] == 1 ) {echo "Aluminum";}
									if( $zeile_wst['werkstoff'] == 2 ) {echo "Non-ferrous metals";}
									if( $zeile_wst['werkstoff'] == 3 ) {echo "Steel";}
									if( $zeile_wst['werkstoff'] == 4 ) {echo "Cast iron";}
									if( $zeile_wst['werkstoff'] == 5 ) {echo "Plastic";}
									if( $zeile_wst['werkstoff'] == 6 ) {echo "other";}
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
							</td>
                        </tr>
                  	</table>
                  </div>


                  <?php if ($zeile_wst['kommentar'] != "") { ?>
                  		<div id="box_2_col" style="float:right; clear:right;">
                  			<table border="0">
								<tr>

									<td style="width:100px;"><?php if ($la == en) {echo 'Comment';} else {echo 'Kommentar';} ?></td>
									<td>
										<?php echo $zeile_wst['kommentar']; ?>
									</td>
								</tr>
							</table>
						  </div>
                  	<?php } ?>



                  <?php require_once('history.php'); ?>

            </form>
           <?php
	// ENDE IF SESSION
	}
?>

</div>
