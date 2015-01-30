<?php
/**
*	@project: Werkstück-Management CHIRON-WERKE GmbH & Co. KG
*	@author: Alexander Hipp
*	@date: 01.04.2012
*/

require_once('calendar/classes/tc_calendar.php');
?>

            <link href="calendar/calendar.css" rel="stylesheet" type="text/css" />
			<script language="javascript" src="calendar/calendar.js"></script>


					<?php
             					// Hier werden die einzelnen Listen geholt die der User angelegt hat
								$user = $_SESSION['ben_id'];
								$sql_el_get = "SELECT * FROM entnahmeliste WHERE ersteller = $user";
								$ergebnis_el_get = mysqli_query($db, $sql_el_get) or die('Es konnten keine Informationen über die Entnahmelisten abgerufen werden. Bitte versuchen Sie es noch einmal.');
					?>

                 	<div id="wst_list_check" style="margin:5px 0 10px;">
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">


                            <label for="list_new" style="float: left;"><?php if ($la == en) {echo 'Edit new list';} else {echo 'neue Liste anlegen';} ?> </label>



							<!-- Textfeld neue Liste anlegen -->
                            <input style="margin-left:5px; float: left;" id="list_new" name="list_new" class="element text medium" type="text" maxlength="255" value=""/>

                            <!-- Button -->
                            <input name="list_new_ok" class="grau" type="submit" value="ok" class="button_text" style="float: left;" />

                            <div style="float: left; margin-right:10px; margin-left:20px;">
                            <div style="float: left; padding-right: 10px; line-height: 18px;">von </div>
                            <div style="float: left;">
                              <?php
                                    $thisweek = date('W');
                                    $thisyear = date('Y');

                                    $dayTimes = getDaysInWeek($thisweek, $thisyear);
                                    //----------------------------------------

                                    $date1 = date('Y-m-d', $dayTimes[0]);
                                    $date2 = date('Y-m-d', $dayTimes[(sizeof($dayTimes)-1)]);

                                    function getDaysInWeek ($weekNumber, $year, $dayStart = 1) {
                                      // Count from '0104' because January 4th is always in week 1
                                      // (according to ISO 8601).
                                      $time = strtotime($year . '0104 +' . ($weekNumber - 1).' weeks');
                                      // Get the time of the first day of the week
                                      $dayTime = strtotime('-' . (date('w', $time) - $dayStart) . ' days', $time);
                                      // Get the times of days 0 -> 6
                                      $dayTimes = array ();
                                      for ($i = 0; $i < 7; ++$i) {
                                        $dayTimes[] = strtotime('+' . $i . ' days', $dayTime);
                                      }
                                      // Return timestamps for mon-sun.
                                      return $dayTimes;
                                    }


                                  $myCalendar = new tc_calendar("date3", true, false);
                                  $myCalendar->setIcon("calendar/images/iconCalendar.gif");
                                  $myCalendar->setDate(date('d', strtotime($date1)), date('m', strtotime($date1)), date('Y', strtotime($date1)));
                                  $myCalendar->setPath("calendar/");
                                  $myCalendar->setYearInterval(2012, 2020);
                                  //$myCalendar->dateAllow('2009-02-20', "", false);
                                  $myCalendar->setAlignment('left', 'bottom');
                                  $myCalendar->setDatePair('date3', 'date4', $date2);
								                  $myCalendar->startMonday(true);
                                  //$myCalendar->setSpecificDate(array("2011-04-01", "2011-04-04", "2011-12-25"), 0, 'year');
                                  $myCalendar->writeScript();
								                  $von = $myCalendar->getDate();


                                  ?>

                            </div>
                          </div>
                          <div style="float: left; margin-right:10px;">
                            <div style="float: left; padding-left: 10px; padding-right: 10px; line-height: 18px;">bis </div>
                            <div style="float: left;">
                              <?php
                                  $myCalendar = new tc_calendar("date4", true, false);
                                  $myCalendar->setIcon("calendar/images/iconCalendar.gif");
                                  $myCalendar->setDate(date('d', strtotime($date2)), date('m', strtotime($date2)), date('Y', strtotime($date2)));
                                  $myCalendar->setPath("calendar/");
                                  $myCalendar->setYearInterval(2012, 2020);
                                  //$myCalendar->dateAllow("", '2009-11-03', false);
                                  $myCalendar->setAlignment('left', 'bottom');
                                  $myCalendar->setDatePair('date3', 'date4', $date1);
								                  $myCalendar->startMonday(true);
                                  //$myCalendar->setSpecificDate(array("2011-04-01", "2011-04-04", "2011-12-25"), 0, 'year');
                                  $myCalendar->writeScript();
								                  $bis = $myCalendar->getDate();
                                  ?>
                            </div>
                          </div>


						  <?php

                            // Wenn der OK_BUTTON gedrückt wird soll eine neue Liste angelegt werden
                            if (isset($_GET['list_new_ok'])) {

                                $el_bez = $_GET['list_new'];

                                $ersteller = $_SESSION['ben_id'];;

                                if (!empty($el_bez)) {

                                    $sql_el = "INSERT INTO entnahmeliste (el_bez, von, bis, ersteller) VALUES ('$el_bez', '$von', '$bis', '$ersteller')";
                                    $ergebnis_el = mysqli_query($db, $sql_el) or die('Der Datenbank konnten keine Informationen übermittelt werden. Überprüfen Sie bitte Ihre Eingabe.');
                                }

								// Hier werden die einzelnen nach dem erstellen einer neuen Liste nochmals geholt

								$sql_el_get = "SELECT * FROM entnahmeliste WHERE ersteller = $ersteller ORDER BY el_id DESC";


								$ergebnis_el_get = mysqli_query($db, $sql_el_get) or die('Es konnten keine Informationen über die Entnahmelisten abgerufen werden. Bitte versuchen Sie es noch einmal.');
                            }
                          ?>

                            <!-- Dropdown -->
                            <select style="margin-left:5px;width:100px;" name="list"  >
                            <option value="" selected="selected"><?php if ($la == en) {echo 'Choose list';} else {echo 'Liste wählen';} ?></option>


							<?php while ($zeile_el_get =  mysqli_fetch_array($ergebnis_el_get)) {?>
									<option value="<?php echo $zeile_el_get['el_id']; ?>"><?php echo $zeile_el_get['el_bez']; ?></option>
							<? } ?>

                            </select>

                            <!-- Button -->
                            <input name="list_check" class="grau" type="submit" value="<?php if ($la == en) {echo 'add to list';} else {echo 'hinzufügen';} ?>" class="button_text" />

                      	</form>
                    </div>
