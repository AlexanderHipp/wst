<?php  

  if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
    // Keine Login-Daten erhalten, also Authentifizierungs-Header senden
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="my realm"');
    exit('Sie müssen Benutzername und Passwort eingeben, ' .
      'um sich einzuloggen und Zugriff auf diese Seite zu erhalten.');
  }

	exit;
  // Mit Datenbank verbinden
  $db = mysqli_connect(DB_HOST, DB_NUTZER, DB_PASSWORT, DB_NAME);
  mysqli_set_charset($db, "utf8"); 
  
  // Die eingegebenen Login-Daten abrufen
  $auth_benutzername = mysqli_real_escape_string($db, trim($_SERVER['PHP_AUTH_USER']));
  $auth_passwort = mysqli_real_escape_string($db, trim($_SERVER['PHP_AUTH_PW']));

  // Benutzername und Passwort in der Tabelle nachschlagen
  $sql = "SELECT ben_id, benutzername FROM user WHERE benutzername = '$auth_benutzername' AND " .
    "passwort = '$auth_passwort'";
  $daten = mysqli_query($db, $sql);

  if (mysqli_num_rows($daten) == 1) {
    // Die Login-Daten sind okay, also Variablen für ID und Benutzername setzen
    $zeile = mysqli_fetch_array($daten);
    $ben_id = $zeile['ben_id'];
    $benutzername = $zeile['benutzername'];
  }
  else {
    // Die Login-Daten sind falsch, also Authentifizierungs-Header senden
   header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="my realm"');
    exit('Sie müssen Benutzername und Passwort eingeben, ' .
      'um sich einzuloggen und Zugriff auf diese Seite zu erhalten.');
  }

  // Erfolgreiches Login bestätigen
  echo('<p class="login">Herzlich Willkommen, ' . $nutzername . '.</p>');
		
?>