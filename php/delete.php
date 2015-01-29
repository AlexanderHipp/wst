<?php 
/** 
*	@project: Werkstück-Management CHIRON-WERKE GmbH & Co. KG
*	@author: Alexander Hipp
*	@date: 01.04.2012
*/

include("base.php");?>

<?php 
	
	if (isset($_GET['del'])) {
		$el = $_GET['del'];
		
		//Umwandeln in Integer
		$el_int = (int)$el;
			
		// Löschen der history-stellen ist voraussetzung dafür, dass die entnahmeliste gelöscht werden kann
		//$del_his = "DELETE FROM history WHERE position = $el_int";
		//$delete_his = mysqli_query($db, $del_his) or die('Es konnte nicht aus der Datenbank gelöscht werden. Überprüfen Sie bitte Ihre Eingabe.');
		
		// Updaten der Entnahemliste an sich
		$del = "UPDATE entnahmeliste SET active = 1 WHERE el_id = $el_int";
		$delete = mysqli_query($db, $del) or die('Es konnte nicht aus der Datenbank gelöscht werden. Überprüfen Sie bitte Ihre Eingabe.');
	}
	
	
?>
<script type="text/javascript">
	location.href="entnahme.php";
</script>