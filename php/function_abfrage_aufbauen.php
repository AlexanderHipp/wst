<?php 
/** 
*	@project: Werkstück-Management CHIRON-WERKE GmbH & Co. KG
*	@author: Alexander Hipp
*	@date: 01.04.2012
*/


				function abfrage_aufbauen($suchtext_wst, $suchtext_kunde, $suchtext_mnummer, $suchtext_werkstoff, $suchtext_geheim, $suchtext_lfdnr, $branche, $technologie_1, $technologie_2, $technologie_3, $technologie_4, $baureihe) {
					  
					  
					  $sql_wst = "SELECT * FROM wst";
						
					  //-------------------------------BEZEICHNUNG---------------------------------
					
					  // WST Suchbegriffe zerlegen und in einem Array speichern
					  $suche_sauber = str_replace(',', ' ', $suchtext_wst);
					  $suchbegriffe = explode(' ', $suche_sauber);
					  $echte_suchbegriffe = array();
					  if (count($suchbegriffe) > 0) {
						foreach ($suchbegriffe as $wort) {
						  if (!empty($wort)) {
							$echte_suchbegriffe[] = $wort;
						  }
						}
					  }
					  
					  // WST Eine WHERE-Klausel mit allen Suchbegriffen erstellen
					  $where_liste = array();
					  if (count($echte_suchbegriffe) > 0) {
						foreach($echte_suchbegriffe as $wort) {
						  $where_liste[] = "bezeichnung LIKE '%$wort%' OR bezeichnung_en LIKE '%$wort%'";
						}
						$where_klausel_1 = implode(' OR ', $where_liste);
					    $where_klausel .= " ( $where_klausel_1 ) ";
					  }
					  
					  
					  //------------------------------KUNDE-----------------------------------------	
					  
					   // Kunde Suchbegriffe zerlegen und in einem Array speichern
					  $suche_sauber_k = str_replace(',', ' ', $suchtext_kunde);
					  $suchbegriffe_k = explode(' ', $suche_sauber_k);
					  $echte_suchbegriffe_k = array();
					  if (count($suchbegriffe_k) > 0) {
						foreach ($suchbegriffe_k as $wortk) {
						  if (!empty($wortk)) {
							$echte_suchbegriffe_k[] = $wortk;
						  }
						}
					  }
					
					  // Kunde Eine WHERE-Klausel mit allen Suchbegriffen erstellen
					  $where_liste_k = array();
					  if (count($echte_suchbegriffe_k) > 0) {
						foreach($echte_suchbegriffe_k as $wortk) {
						  $where_liste_k[] = "kunde LIKE '%$wortk%'";
						}
						$where_klausel_k_1 = implode(' OR ', $where_liste_k);
					    $where_klausel_k .= " ( $where_klausel_k_1 ) ";
					  }
					  
					  
					  
					  
					  //-------------------------------MASCHINEN-NUMMER---------------------------------
					  
					  // MNUMMER Suchbegriffe zerlegen und in einem Array speichern
					  $suche_sauber_m = str_replace(',', ' ', $suchtext_mnummer);
					  $suchbegriffe_m = explode(' ', $suche_sauber_m);
					  $echte_suchbegriffe_m = array();
					  if (count($suchbegriffe_m) > 0) {
						foreach ($suchbegriffe_m as $wortm) {
						  if (!empty($wortm)) {
							$echte_suchbegriffe_m[] = $wortm;
						  }
						}
					  }
					
					  // MNUMMER Eine WHERE-Klausel mit allen Suchbegriffen erstellen
					  $where_liste_m = array();
					  if (count($echte_suchbegriffe_m) > 0) {
						foreach($echte_suchbegriffe_m as $wortm) {
						  $where_liste_m[] = "maschnr LIKE '%$wortm%'";
						}
						$where_klausel_m_1 = implode(' OR ', $where_liste_m);
					    $where_klausel_m .= " ( $where_klausel_m_1 ) ";
					
					  }
					  
					
					  //-------------------------------Werkstoff---------------------------------
					  
					  if ($suchtext_werkstoff == "") {
					  } else {						 
						  $wortw = $suchtext_werkstoff;
						  $where_klausel_w = "werkstoff = '$wortw'";
					  }
					  
					  //-------------------------------Geheimhaltung-----------------------------
					  if ($suchtext_geheim == "") {
					  } else {
					  	  $wortg = $suchtext_geheim;
					      $where_klausel_g = "geheim = '$wortg'";
					  }
					  
					  //-------------------------------LFD-NR---------------------------------
					  
					  // LFDNR Suchbegriffe zerlegen und in einem Array speichern
					  $suche_sauber_lfdnr = str_replace(',', ' ', $suchtext_lfdnr);
					  $suchbegriffe_lfdnr = explode(' ', $suche_sauber_lfdnr);
					  $echte_suchbegriffe_lfdnr = array();
					  if (count($suchbegriffe_lfdnr) > 0) {
						foreach ($suchbegriffe_lfdnr as $wortlfdnr) {
						  if (!empty($wortlfdnr)) {
							$echte_suchbegriffe_lfdnr[] = $wortlfdnr;
						  }
						}
					  }
					
					  // LFDNR Eine WHERE-Klausel mit allen Suchbegriffen erstellen
					  $where_liste_lfdnr = array();
					  if (count($echte_suchbegriffe_lfdnr) > 0) {
						foreach($echte_suchbegriffe_lfdnr as $wortlfdnr) {
						  $where_liste_lfdnr[] = "lfd_nr LIKE '%$wortlfdnr%'";
						}
						$where_klausel_lfdnr_1 = implode(' OR ', $where_liste_lfdnr);
					    $where_klausel_lfdnr .= " ( $where_klausel_lfdnr_1 ) ";
					
					  }
					  
					  //-------------------------------Branche-----------------------------
					  
					  $echter_inhalt_b = array();
					  
					  if ($branche[1] == 201) {
						  $echter_inhalt_b[] = 201;
					  }
					  if ($branche[2] == 202) {
						  // Wenn der Oberbegriff Automotive ausgewählt wird und keine Spezifizierung vorgenommen wird, sollen alle Automotive angezeigt werden
						  $echter_inhalt_b[] = 202;
						  $echter_inhalt_b[] = 20201;
						  $echter_inhalt_b[] = 20202;
						  $echter_inhalt_b[] = 20203;
						  $echter_inhalt_b[] = 20204;
						  $echter_inhalt_b[] = 20205;
						  $echter_inhalt_b[] = 20206;
						  $echter_inhalt_b[] = 20207;
						  $echter_inhalt_b[] = 20208;
							   
					  }
					  if ($branche[3] == 203) {
						  $echter_inhalt_b[] = 203;
					  }
					  if ($branche[4] == 204) {
						  $echter_inhalt_b[] = 204;
						  $echter_inhalt_b[] = 20401;
						  $echter_inhalt_b[] = 20402;
						  $echter_inhalt_b[] = 20403;
						  $echter_inhalt_b[] = 20404;
					  }
					  if ($branche[5] == 205) {
						  $echter_inhalt_b[] = 205;
						  $echter_inhalt_b[] = 20501;
						  $echter_inhalt_b[] = 20502;
						  $echter_inhalt_b[] = 20503;
					  }
					  
					  if ($branche[2] == 20201) {
						  $echter_inhalt_b[] = 20201;
					  }
					  if ($branche[2] == 20202) {
						  $echter_inhalt_b[] = 20202;
					  }
					  if ($branche[2] == 20203) {
						  $echter_inhalt_b[] = 20203;
					  }
					  if ($branche[2] == 20204) {
						  $echter_inhalt_b[] = 20204;
					  }
					  if ($branche[2] == 20205) {
						  $echter_inhalt_b[] = 20205;
					  }
					  if ($branche[2] == 20206) {
						  $echter_inhalt_b[] = 20206;
					  }
					  if ($branche[2] == 20207) {
						  $echter_inhalt_b[] = 20207;
					  }
					  if ($branche[2] == 20208) {
						  $echter_inhalt_b[] = 20208;
					  }
					  if ($branche[4] == 20401) {
						  $echter_inhalt_b[] = 20401;
					  }
					  if ($branche[4] == 20402) {
						  $echter_inhalt_b[] = 20402;
					  }
					  if ($branche[4] == 20403) {
						  $echter_inhalt_b[] = 20403;
					  }
					  if ($branche[4] == 20404) {
						  $echter_inhalt_b[] = 20404;
					  }
					  if ($branche[5] == 20501) {
						  $echter_inhalt_b[] = 20501;
					  }
					  if ($branche[5] == 20502) {
						  $echter_inhalt_b[] = 20502;
					  }
					  if ($branche[5] == 20503) {
						  $echter_inhalt_b[] = 20503;
					  }
					  
					  
					  
					  if (count($echter_inhalt_b) > 0) {
							foreach($echter_inhalt_b as $worttb) {
							  $where_liste_b[] = "branche = '$worttb'";
							}
					  		$where_klausel_b_1 = implode(' OR ', $where_liste_b);
							$where_klausel_b .= " ( $where_klausel_b_1 ) ";
					  }
					  
					  
					  //--------------------------Baureihe-----------------------------
					  
					  $echter_inhalt_br = array();
					  
					  
					  if ($baureihe[1] == 401) {
						  $echter_inhalt_br[] = 401;
					  } 
					  if ($baureihe[2] == 402) {
						  $echter_inhalt_br[] = 402;
					  } 
					  if ($baureihe[3] == 403) {
						 $echter_inhalt_br[] = 403;
					  } 
					  if ($baureihe[4] == 404) {
						  $echter_inhalt_br[] = 404;
					  } 
					  if ($baureihe[5] == 405) {
						 $echter_inhalt_br[] = 405;
					  } 
					  if ($baureihe[6] == 406) {
						  $echter_inhalt_br[] = 406;
					  } 
					  
					  if (count($echter_inhalt_br) > 0) {
							foreach($echter_inhalt_br as $wortbr) {
							  $where_liste_br[] = "baureihe = '$wortbr'";
							}
					  		$where_klausel_br_1 = implode(' OR ', $where_liste_br);
							$where_klausel_br .= " ( $where_klausel_br_1 ) ";
					  }
					  
					  //--------------------------Technologie_1-----------------------------
					  $echter_inhalt_t1 = array();
					  
					  if ($technologie_1[1] == 101) {
						  $echter_inhalt_t1[] = 101;
					  }
					  if ($technologie_1[2] == 102) {
						  $echter_inhalt_t1[] = 102;
					  }
					  if ($technologie_1[3] == 103) {
						  $echter_inhalt_t1[] = 103;
					  }
					  if ($technologie_1[4] == 104) {
						  $echter_inhalt_t1[] = 104;
					  }
					  
					  if (count($echter_inhalt_t1) > 0) {
							foreach($echter_inhalt_t1 as $wortt1) {
							  $where_liste_t1[] = "technologie_1 = '$wortt1'";
							}
					  		$where_klausel_t1_1 = implode(' OR ', $where_liste_t1);
							$where_klausel_t1 .= " ( $where_klausel_t1_1 ) ";
					  }
					  
					  
					  //--------------------------Technologie_2-----------------------------
					  $echter_inhalt_t2 = array();
					  
					  if ($technologie_2[1] == 111) {
						  $echter_inhalt_t2[] = 111;
					  }
					  if ($technologie_2[2] == 112) {
						  $echter_inhalt_t2[] = 112;
					  }
					 
					  
					  if (count($echter_inhalt_t2) > 0) {
							foreach($echter_inhalt_t2 as $wortt2) {
							  $where_liste_t2[] = "technologie_2 = '$wortt2'";
							}
					  		$where_klausel_t2_1 = implode(' OR ', $where_liste_t2);
							$where_klausel_t2 .= " ( $where_klausel_t2_1 ) ";
					  }
					  
					  
					  //--------------------------Technologie_3-----------------------------
					  
					  $echter_inhalt_t3 = array();
					  
					  if ($technologie_3[1] == 121) {
						  $echter_inhalt_t3[] = 121;
					  }
					  if ($technologie_3[2] == 122) {
						  $echter_inhalt_t3[] = 122;
					  }
					  if ($technologie_3[3] == 123) {
						  $echter_inhalt_t3[] = 123;
					  }
					  if ($technologie_3[4] == 124) {
						  $echter_inhalt_t3[] = 124;
					  }
					  
					  if (count($echter_inhalt_t3) > 0) {
							foreach($echter_inhalt_t3 as $wortt3) {
							  $where_liste_t3[] = "technologie_3 = '$wortt3'";
							}
					  		$where_klausel_t3_1 = implode(' OR ', $where_liste_t3);
							$where_klausel_t3 .= " ( $where_klausel_t3_1 ) ";
					  }
					  
					  //--------------------------Technologie_4-----------------------------
					  $echter_inhalt_t4 = array();
					  
					  if ($technologie_4[1] == 131) {
						  $echter_inhalt_t4[] = 131;
					  }
					  if ($technologie_4[2] == 132) {
						  $echter_inhalt_t4[] = 132;
					  }
					  if ($technologie_4[3] == 133) {
						  $echter_inhalt_t4[] = 133;
					  }
					  if ($technologie_4[4] == 141) {
						  $echter_inhalt_t4[] = 141;
					  }
					  
					  if (count($echter_inhalt_t4) > 0) {
							foreach($echter_inhalt_t4 as $wortt4) {
							  $where_liste_t4[] = "technologie_4 = '$wortt4'";
							}
					  		$where_klausel_t4_1 = implode(' OR ', $where_liste_t4);
							$where_klausel_t4 .= " ( $where_klausel_t4_1 ) "; 
					  }
					  
					  
					  
					  //-------------------------------Abfragen----------------------------------------	
					
					  // Wenn nichts ausgewählt wurde: Gib alle aus!!
					  if (empty($where_klausel) AND empty($where_klausel_k) AND empty($where_klausel_m) AND empty($where_klausel_lfdnr) AND empty($where_klausel_w) AND empty($where_klausel_g) AND empty($where_klausel_b) AND empty($where_klausel_t1) AND empty($where_klausel_t2) AND empty($where_klausel_t3) AND empty($where_klausel_t4) AND empty($where_klausel_br))  {
												
						return $sql_wst;
						break;
					  }
					  
					  // Alle
					  if (!empty($where_klausel) AND !empty($where_klausel_k) AND !empty($where_klausel_m) AND !empty($where_klausel_w) AND !empty($where_klausel_lfdnr) AND !empty($where_klausel_g) AND !empty($where_klausel_b) AND !empty($where_klausel_t1) AND !empty($where_klausel_t2) AND !empty($where_klausel_t3) AND !empty($where_klausel_t4) AND !empty($where_klausel_br))   {
						$sql_wst .= " WHERE ". $where_klausel . "
										AND ". $where_klausel_k . "
										AND ". $where_klausel_m . "
										AND ". $where_klausel_w . "
										AND ". $where_klausel_lfdnr . "
										AND ". $where_klausel_g . "
										AND ". $where_klausel_b . "
										AND ". $where_klausel_br. "
										AND ". $where_klausel_t1 . "
										AND ". $where_klausel_t2 . "
										AND ". $where_klausel_t3 . "
										AND ". $where_klausel_t4;
						
						return $sql_wst;
						
						break;
					  }
					  
					  
					  // Wst 
					  if (!empty($where_klausel)) {
							$sql_wst .= " WHERE $where_klausel";
							
							if (!empty($where_klausel_k)) {
								$sql_wst .= " AND $where_klausel_k";
							}
							if (!empty($where_klausel_m)) {
								$sql_wst .= " AND $where_klausel_m";
							}
							if (!empty($where_klausel_w)) {
								$sql_wst .= " AND $where_klausel_w";
							}
							if (!empty($where_klausel_g)) {
								$sql_wst .= " AND $where_klausel_g";
							}
							if (!empty($where_klausel_b)) {
								$sql_wst .= " AND $where_klausel_b";
							}
							if (!empty($where_klausel_br)) {
								$sql_wst .= " AND $where_klausel_br";
							}
							if (!empty($where_klausel_t1)) {
								$sql_wst .= " AND $where_klausel_t1";
							}
							if (!empty($where_klausel_t2)) {
								$sql_wst .= " AND $where_klausel_t2";
							}
							if (!empty($where_klausel_t3)) {
								$sql_wst .= " AND $where_klausel_t3";
							}
							if (!empty($where_klausel_t4)) {
								$sql_wst .= " AND $where_klausel_t4";
							}
							if (!empty($where_klausel_lfdnr)) {
								$sql_wst .= " AND $where_klausel_lfdnr";
							}
							
							
							return $sql_wst;
							break;
					  }
					  
					  
					  // Kunde 
					  if (!empty($where_klausel_k)) {
							$sql_wst .= " WHERE $where_klausel_k";
							
							if (!empty($where_klausel)) {
								$sql_wst .= " AND $where_klausel";
							}
							if (!empty($where_klausel_m)) {
								$sql_wst .= " AND $where_klausel_m";
							}
							if (!empty($where_klausel_w)) {
								$sql_wst .= " AND $where_klausel_w";
							}
							if (!empty($where_klausel_g)) {
								$sql_wst .= " AND $where_klausel_g";
							}
							if (!empty($where_klausel_b)) {
								$sql_wst .= " AND $where_klausel_b";
							}
							if (!empty($where_klausel_br)) {
								$sql_wst .= " AND $where_klausel_br";
							}
							if (!empty($where_klausel_t1)) {
								$sql_wst .= " AND $where_klausel_t1";
							}
							if (!empty($where_klausel_t2)) {
								$sql_wst .= " AND $where_klausel_t2";
							}
							if (!empty($where_klausel_t3)) {
								$sql_wst .= " AND $where_klausel_t3";
							}
							if (!empty($where_klausel_t4)) {
								$sql_wst .= " AND $where_klausel_t4";
							}
							if (!empty($where_klausel_lfdnr)) {
								$sql_wst .= " AND $where_klausel_lfdnr";
							}
							
							
							return $sql_wst;
							break;
					  }
					  
					  // MNummer 
					  if (!empty($where_klausel_m)) {
							$sql_wst .= " WHERE $where_klausel_m";
					  		
							if (!empty($where_klausel_k)) {
								$sql_wst .= " AND $where_klausel_k";
							}
							if (!empty($where_klausel)) {
								$sql_wst .= " AND $where_klausel";
							}
							if (!empty($where_klausel_w)) {
								$sql_wst .= " AND $where_klausel_w";
							}
							if (!empty($where_klausel_g)) {
								$sql_wst .= " AND $where_klausel_g";
							}
							if (!empty($where_klausel_b)) {
								$sql_wst .= " AND $where_klausel_b";
							}
							if (!empty($where_klausel_br)) {
								$sql_wst .= " AND $where_klausel_br";
							}
							if (!empty($where_klausel_t1)) {
								$sql_wst .= " AND $where_klausel_t1";
							}
							if (!empty($where_klausel_t2)) {
								$sql_wst .= " AND $where_klausel_t2";
							}
							if (!empty($where_klausel_t3)) {
								$sql_wst .= " AND $where_klausel_t3";
							}
							if (!empty($where_klausel_t4)) {
								$sql_wst .= " AND $where_klausel_t4";
							}
							if (!empty($where_klausel_lfdnr)) {
								$sql_wst .= " AND $where_klausel_lfdnr";
							}
							
							
							return $sql_wst;
							break;
					  }
					
					 					  
					  // Werkstoff 
					  if (!empty($where_klausel_w)) {
							$sql_wst .= " WHERE $where_klausel_w";
							
							if (!empty($where_klausel_k)) {
								$sql_wst .= " AND $where_klausel_k";
							}
							if (!empty($where_klausel_m)) {
								$sql_wst .= " AND $where_klausel_m";
							}
							if (!empty($where_klausel)) {
								$sql_wst .= " AND $where_klausel";
							}
							if (!empty($where_klausel_g)) {
								$sql_wst .= " AND $where_klausel_g";
							}
							if (!empty($where_klausel_b)) {
								$sql_wst .= " AND $where_klausel_b";
							}
							if (!empty($where_klausel_br)) {
								$sql_wst .= " AND $where_klausel_br";
							}
							if (!empty($where_klausel_t1)) {
								$sql_wst .= " AND $where_klausel_t1";
							}
							if (!empty($where_klausel_t2)) {
								$sql_wst .= " AND $where_klausel_t2";
							}
							if (!empty($where_klausel_t3)) {
								$sql_wst .= " AND $where_klausel_t3";
							}
							if (!empty($where_klausel_t4)) {
								$sql_wst .= " AND $where_klausel_t4";
							}
							if (!empty($where_klausel_lfdnr)) {
								$sql_wst .= " AND $where_klausel_lfdnr";
							}
							
							
							return $sql_wst;
							break;
					  }
					  
					  // Geheimhaltung 
					  if (!empty($where_klausel_g)) {
							$sql_wst .= " WHERE $where_klausel_g";
							
							if (!empty($where_klausel_k)) {
								$sql_wst .= " AND $where_klausel_k";
							}
							if (!empty($where_klausel_m)) {
								$sql_wst .= " AND $where_klausel_m";
							}
							if (!empty($where_klausel)) {
								$sql_wst .= " AND $where_klausel";
							}
							if (!empty($where_klausel_w)) {
								$sql_wst .= " AND $where_klausel_w";
							}
							if (!empty($where_klausel_b)) {
								$sql_wst .= " AND $where_klausel_b";
							}
							if (!empty($where_klausel_br)) {
								$sql_wst .= " AND $where_klausel_br";
							}
							if (!empty($where_klausel_t1)) {
								$sql_wst .= " AND $where_klausel_t1";
							}
							if (!empty($where_klausel_t2)) {
								$sql_wst .= " AND $where_klausel_t2";
							}
							if (!empty($where_klausel_t3)) {
								$sql_wst .= " AND $where_klausel_t3";
							}
							if (!empty($where_klausel_t4)) {
								$sql_wst .= " AND $where_klausel_t4";
							}
							if (!empty($where_klausel_lfdnr)) {
								$sql_wst .= " AND $where_klausel_lfdnr";
							}
							
							
							return $sql_wst;
							break;
					  }
					  
					  // Branche 
					  if (!empty($where_klausel_b)) {
							$sql_wst .= " WHERE $where_klausel_b";
							
							if (!empty($where_klausel_k)) {
								$sql_wst .= " AND $where_klausel_k";
							}
							if (!empty($where_klausel_m)) {
								$sql_wst .= " AND $where_klausel_m";
							}
							if (!empty($where_klausel)) {
								$sql_wst .= " AND $where_klausel";
							}
							if (!empty($where_klausel_w)) {
								$sql_wst .= " AND $where_klausel_w";
							}
							if (!empty($where_klausel_g)) {
								$sql_wst .= " AND $where_klausel_g";
							}
							if (!empty($where_klausel_br)) {
								$sql_wst .= " AND $where_klausel_br";
							}
							if (!empty($where_klausel_t1)) {
								$sql_wst .= " AND $where_klausel_t1";
							}
							if (!empty($where_klausel_t2)) {
								$sql_wst .= " AND $where_klausel_t2";
							}
							if (!empty($where_klausel_t3)) {
								$sql_wst .= " AND $where_klausel_t3";
							}
							if (!empty($where_klausel_t4)) {
								$sql_wst .= " AND $where_klausel_t4";
							}
							if (!empty($where_klausel_lfdnr)) {
								$sql_wst .= " AND $where_klausel_lfdnr";
							}
							
							
							return $sql_wst;
							break;
					  }
					  
					  // Baureihe 
					  if (!empty($where_klausel_br)) {
							$sql_wst .= " WHERE $where_klausel_br";
							
							if (!empty($where_klausel_k)) {
								$sql_wst .= " AND $where_klausel_k";
							}
							if (!empty($where_klausel_m)) {
								$sql_wst .= " AND $where_klausel_m";
							}
							if (!empty($where_klausel)) {
								$sql_wst .= " AND $where_klausel";
							}
							if (!empty($where_klausel_w)) {
								$sql_wst .= " AND $where_klausel_w";
							}
							if (!empty($where_klausel_g)) {
								$sql_wst .= " AND $where_klausel_g";
							}
							if (!empty($where_klausel_b)) {
								$sql_wst .= " AND $where_klausel_b";
							}
							if (!empty($where_klausel_t1)) {
								$sql_wst .= " AND $where_klausel_t1";
							}
							if (!empty($where_klausel_t2)) {
								$sql_wst .= " AND $where_klausel_t2";
							}
							if (!empty($where_klausel_t3)) {
								$sql_wst .= " AND $where_klausel_t3";
							}
							if (!empty($where_klausel_t4)) {
								$sql_wst .= " AND $where_klausel_t4";
							}
							if (!empty($where_klausel_lfdnr)) {
								$sql_wst .= " AND $where_klausel_lfdnr";
							}
							
							
							return $sql_wst;
							break;
					  }
					  
					  // Technologie_1 
					  if (!empty($where_klausel_t1)) {
							$sql_wst .= " WHERE $where_klausel_t1";
							
							if (!empty($where_klausel_k)) {
								$sql_wst .= " AND $where_klausel_k";
							}
							if (!empty($where_klausel_m)) {
								$sql_wst .= " AND $where_klausel_m";
							}
							if (!empty($where_klausel)) {
								$sql_wst .= " AND $where_klausel";
							}
							if (!empty($where_klausel_w)) {
								$sql_wst .= " AND $where_klausel_w";
							}
							if (!empty($where_klausel_g)) {
								$sql_wst .= " AND $where_klausel_g";
							}
							if (!empty($where_klausel_br)) {
								$sql_wst .= " AND $where_klausel_br";
							}
							if (!empty($where_klausel_b)) {
								$sql_wst .= " AND $where_klausel_b";
							}
							if (!empty($where_klausel_t2)) {
								$sql_wst .= " AND $where_klausel_t2";
							}
							if (!empty($where_klausel_t3)) {
								$sql_wst .= " AND $where_klausel_t3";
							}
							if (!empty($where_klausel_t4)) {
								$sql_wst .= " AND $where_klausel_t4";
							}
							if (!empty($where_klausel_lfdnr)) {
								$sql_wst .= " AND $where_klausel_lfdnr";
							}
							
							
							return $sql_wst;
							break;
					  }
					  
					  // Technologie_2 
					  if (!empty($where_klausel_t2)) {
							$sql_wst .= " WHERE $where_klausel_t2";
							
							if (!empty($where_klausel_k)) {
								$sql_wst .= " AND $where_klausel_k";
							}
							if (!empty($where_klausel_m)) {
								$sql_wst .= " AND $where_klausel_m";
							}
							if (!empty($where_klausel)) {
								$sql_wst .= " AND $where_klausel";
							}
							if (!empty($where_klausel_w)) {
								$sql_wst .= " AND $where_klausel_w";
							}
							if (!empty($where_klausel_g)) {
								$sql_wst .= " AND $where_klausel_g";
							}
							if (!empty($where_klausel_br)) {
								$sql_wst .= " AND $where_klausel_br";
							}
							if (!empty($where_klausel_b)) {
								$sql_wst .= " AND $where_klausel_b";
							}
							if (!empty($where_klausel_t1)) {
								$sql_wst .= " AND $where_klausel_t1";
							}
							if (!empty($where_klausel_t3)) {
								$sql_wst .= " AND $where_klausel_t3";
							}
							if (!empty($where_klausel_t4)) {
								$sql_wst .= " AND $where_klausel_t4";
							}
							if (!empty($where_klausel_lfdnr)) {
								$sql_wst .= " AND $where_klausel_lfdnr";
							}
							
							
							return $sql_wst;
							break;
					  }
					  
					  // Technologie_3 
					  if (!empty($where_klausel_t3)) {
							$sql_wst .= " WHERE $where_klausel_t3";
							
							if (!empty($where_klausel_k)) {
								$sql_wst .= " AND $where_klausel_k";
							}
							if (!empty($where_klausel_m)) {
								$sql_wst .= " AND $where_klausel_m";
							}
							if (!empty($where_klausel)) {
								$sql_wst .= " AND $where_klausel";
							}
							if (!empty($where_klausel_w)) {
								$sql_wst .= " AND $where_klausel_w";
							}
							if (!empty($where_klausel_g)) {
								$sql_wst .= " AND $where_klausel_g";
							}
							if (!empty($where_klausel_br)) {
								$sql_wst .= " AND $where_klausel_br";
							}
							if (!empty($where_klausel_b)) {
								$sql_wst .= " AND $where_klausel_b";
							}
							if (!empty($where_klausel_t1)) {
								$sql_wst .= " AND $where_klausel_t1";
							}
							if (!empty($where_klausel_t2)) {
								$sql_wst .= " AND $where_klausel_t2";
							}
							if (!empty($where_klausel_t4)) {
								$sql_wst .= " AND $where_klausel_t4";
							}
							if (!empty($where_klausel_lfdnr)) {
								$sql_wst .= " AND $where_klausel_lfdnr";
							}
							
							
							return $sql_wst;
							break;
					  }
					  
					  // Technologie_4 
					  if (!empty($where_klausel_t4)) {
							$sql_wst .= " WHERE $where_klausel_t4";
							
							if (!empty($where_klausel_k)) {
								$sql_wst .= " AND $where_klausel_k";
							}
							if (!empty($where_klausel_m)) {
								$sql_wst .= " AND $where_klausel_m";
							}
							if (!empty($where_klausel)) {
								$sql_wst .= " AND $where_klausel";
							}
							if (!empty($where_klausel_w)) {
								$sql_wst .= " AND $where_klausel_w";
							}
							if (!empty($where_klausel_g)) {
								$sql_wst .= " AND $where_klausel_g";
							}
							if (!empty($where_klausel_br)) {
								$sql_wst .= " AND $where_klausel_br";
							}
							if (!empty($where_klausel_b)) {
								$sql_wst .= " AND $where_klausel_b";
							}
							if (!empty($where_klausel_t1)) {
								$sql_wst .= " AND $where_klausel_t1";
							}
							if (!empty($where_klausel_t2)) {
								$sql_wst .= " AND $where_klausel_t2";
							}
							if (!empty($where_klausel_t3)) {
								$sql_wst .= " AND $where_klausel_t3";
							}
							if (!empty($where_klausel_lfdnr)) {
								$sql_wst .= " AND $where_klausel_lfdnr";
							}
							
							
							return $sql_wst;
							break;
					  }
					  
					  // Laufende Nummer
					  if (!empty($where_klausel_lfdnr)) {
							$sql_wst .= " WHERE $where_klausel_lfdnr";
							
							if (!empty($where_klausel_k)) {
								$sql_wst .= " AND $where_klausel_k";
							}
							if (!empty($where_klausel_m)) {
								$sql_wst .= " AND $where_klausel_m";
							}
							if (!empty($where_klausel)) {
								$sql_wst .= " AND $where_klausel";
							}
							if (!empty($where_klausel_w)) {
								$sql_wst .= " AND $where_klausel_w";
							}
							if (!empty($where_klausel_g)) {
								$sql_wst .= " AND $where_klausel_g";
							}
							if (!empty($where_klausel_br)) {
								$sql_wst .= " AND $where_klausel_br";
							}
							if (!empty($where_klausel_b)) {
								$sql_wst .= " AND $where_klausel_b";
							}
							if (!empty($where_klausel_t1)) {
								$sql_wst .= " AND $where_klausel_t1";
							}
							if (!empty($where_klausel_t2)) {
								$sql_wst .= " AND $where_klausel_t2";
							}
							if (!empty($where_klausel_t3)) {
								$sql_wst .= " AND $where_klausel_t3";
							}
							if (!empty($where_klausel_t4)) {
								$sql_wst .= " AND $where_klausel_t4";
							}
							
							
							return $sql_wst;
							break;
					  }
					  
					 //-------------------------------------------------------------------------------------
					
					
					
					 
				 }
                 
                ?>