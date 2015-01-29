<?php
/** 
*	@project: Werkstück-Management CHIRON-WERKE GmbH & Co. KG
*	@author: Alexander Hipp
*	@date: 01.04.2012
*/	
	session_start();
	
	
	// Verbindung zum Datenbankserver
	$db = mysqli_connect("db1080.mydbserver.com", "p161002", "tester", "usr_p161002_1") or die ("Es konnte keine Verbindung zur Datenbank hergestellt werden");
	//$db = mysqli_connect("127.0.0.1", "root", "", "wst-management") or die ("Es konnte keine Verbindung zur Datenbank hergestellt werden");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<link rel="stylesheet" type="text/css" href="../css/style.css" />
<link rel="stylesheet" href="../css/search_picto.css" type="text/css">

      <link href="calendar/calendar.css" rel="stylesheet" type="text/css" />
			<script language="javascript" src="calendar/calendar.js"></script>
			 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8;" />


<script type="text/javascript" src="../js/jquery.all.js"></script>
<script type="text/javascript" src="../js/jquery-latest.js"></script>
<script type="text/javascript" src="../js/epos.js"></script>

<!-- Kalender Plugin -->
<script type="text/javascript" src="../js/calender.js"></script>


