<?php 
/** 
*	@project: Werkstück-Management CHIRON-WERKE GmbH & Co. KG
*	@author: Alexander Hipp
*	@date: 01.04.2012
*/


// Wenn der Benutzer eingeloggt ist,die Sitzung beenden

session_start();
if (isset($_SESSION['ben_id'])) {
	$_SESSION = array();
					   
	if (isset($_COOKIE[session_name()])) {
	setcookie(session_name(), '', time()-3600);
	}
	
	// DIe Sitzung zerstören
	session_destroy();
}

	//Zur index-Seite zurückleiten.
	$hauptseite = dirname($_SERVER['PHP_SELF']) . '/index.php?logout=1';
	header('Location: ' . $hauptseite);

?>
