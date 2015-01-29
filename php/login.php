<?php 
/** 
*	@project: Werkstück-Management CHIRON-WERKE GmbH & Co. KG
*	@author: Alexander Hipp
*	@date: 01.04.2012
*/

// Fehlermeldung zurücksetzen.
$fehlermldg = "";
$fehlermldg2 = "";
$abort = false;

	session_start();

// Wenn Session mit Sperrzeit besteht, prüfen ob bereits 10 Min vorrüber sind
if (isset($_SESSION["sperrzeit"]) && ($_SESSION["sperrzeit"] > time() - 600) )
{	
	$abort = true;
}


// Versuchen, den Benutzer einzuloggen, wenn er nicht eingeloogt ist.
if (!isset($_SESSION['ben_id'])) {
	if (isset($_POST['submit'])) {
		
		
		$failed = false;
		
	

		//MIt Datenbank verbinden 
		$db = mysqli_connect("db1080.mydbserver.com", "p161002", "tester", "usr_p161002_1") or die ("Es konnte keine Verbindung zur Datenbank hergestellt werden");
		//$db = mysqli_connect("127.0.0.1", "root", "", "wst-management") or die ("Es konnte keine Verbindung zur Datenbank hergestellt werden");
		
		// Die eingegebenen Login-Daten abrufen.
		$auth_nutzername = mysqli_real_escape_string($db, trim($_POST['nutzername']));
		$auth_passwort = mysqli_real_escape_string($db, trim($_POST['passwort']));
		
		if (!empty($auth_nutzername) && !empty($auth_passwort))  {
			
			// Benutzername und Passwort in der Tabelle nachschlagen.
			$sql = "SELECT * FROM user WHERE benutzername = '$auth_nutzername' AND " .
					"password_set = '$auth_passwort'";
			
			$ergebnis = mysqli_query($db, $sql) or die('Es konnten keine Informationen über die User abgerufen werden. Bitte versuchen Sie es noch einmal.');
			
			
			
			if (mysqli_num_rows($ergebnis) == 1) {
				// Login erfolgreich, also die Cookies setzen und den Benutzer zu Hauptseite umleiten.
				$zeile = mysqli_fetch_array($ergebnis);
				if ($zeile['aktiv'] == 1) {
					$_SESSION['ben_id'] = $zeile['ben_id'];
					$_SESSION['nutzername'] = $zeile['benutzername'];
					$_SESSION['rolle'] = $zeile['rolle'];
					$_SESSION['la'] = 'de';
					$hauptseite = dirname($_SERVER['PHP_SELF']) . '/search.php';
					header('Location: ' . $hauptseite);
				} else {
					// Aktivstatus auf inaktiv, also Fehlermeldung setzen.
					$fehlermldg = '<div id="box"><div id="red">Ihr Aktivierungsstatus wurde auf inaktiv gesetzt. Bitte kontaktieren Sie den Administrator.</div></div>';
					$failed = true;
				}
				
			} else {
				// Benutzername/Passwort falsch, also Fehlermeldung setzen.
				$fehlermldg = '<div id="box"><div id="red">Sie müssen gültige Zugangsdaten eingeben, um sich einzuloggen.</div></div>';
				$failed = true;
			} 
		} else {
			// Benutzname/Passwort nicht eingegeben also Fehlermeldung setzen.
			$fehlermldg = '<div id="box"><div id="red">Sie müssen Ihre Zugangsdaten eingeben, um sich einzuloggen.</div></div>';
			$failed = true;
		}
	}
}

if ($abort == true)
{	$fehlermldg2 = '<div id="box"><div id="red">Sie haben Sich zu oft falsch angemeldet. Bitte versuchen Sie es in 10 Minuten noch einmal</div></div>';
}

if ($failed == true)
{	if (isset($_SESSION["loginversuche"]))
	{	$aktuell = $_SESSION["loginversuche"] ;
		$neu = $aktuell + 1;
		$_SESSION["loginversuche"] = $neu;
	}
	else
	{	$_SESSION["loginversuche"] = "1";
	}	
	
	if (isset($_SESSION["loginversuche"]) && ($_SESSION["loginversuche"] >= 3))
	{	$_SESSION["sperrzeit"] = time();
	}
}






include("base.php");

if ($_GET['logout'] == 1) {
	$logout = 1;
	$logout_text = '<div id="box"><div id="green">Sie haben sich erfolgreich abgemeldet.</div></div>';
}

?>

<div id="page">
	<div id="heading"></div>
    <div id="main">
    	
    	  <!--Überschrift im grauen Kasten-->
          <div id="pagehead"><span><?php if ($logout == 1) {echo 'Auf Wiedersehen';} else {echo 'login';} ?></span></div>
          
          <?php 
		  	// Wenn Cookie leer ist, Fehlermeldungen und Formular anzeigen, ansonsten Login bestätigen.
			if (empty($_COOKIE['ben_id'])) {
				
				if ($abort == true)
				{	echo $fehlermldg2;
				}
				else
				{	echo $fehlermldg;
					echo $logout_text;
				}
		  
		  ?>
          
          
          <? // wenn abort == true, abbrechen da noch nicht 10 Minuten seit letztem 3-maligen fehlerhaften Anmelden vergangen sind
		  
		  if ($abort == false)
		  { ?>
          
          <!--Anmeldeformular mit Button-->
          <div id="box">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                	
                    <table border="0">
                    <tr>
                        <td><label for="benutzername">Benutzername </label></td>
                        <td><input style="margin-left:10px;" id="nutzername" name="nutzername" class="element text medium" type="text" maxlength="25" value="<?php if(!empty($auth_nutzername)) echo $auth_nutzername; ?>" /></td>
                    </tr>
                    <tr>
                        <td><label  for="passwort">Passwort </label></td>
                        <td><input style="margin-left:10px;" id="passwort" name="passwort" class="element text medium" type="password" maxlength="25" value=""/></td>
                    </tr>
                        
                    </table>   
                    <!--Button mit Verlinkung zu dashboard.php-->     
                        	<div style="margin-top:15px;"><input name="submit"  class="grau" type="submit" value="anmelden" /></div>
                    
                </form>
                
               
         </div>  
        <? } ?>
    </div>	
</div>

<?php 
	 } else {
		 // Erfolgreiches Login bestätigen.
		 echo 'Erfolgreich angemeldet';
	 }

?>