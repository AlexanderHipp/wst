<?php 
/** 
*	@project: Werkstück-Management CHIRON-WERKE GmbH & Co. KG
*	@author: Alexander Hipp
*	@date: 01.04.2012
*/

include("base.php");?>

<?php 

	if (isset($_GET['hid'])) {
		$h_id = $_GET['hid'];
		$el = $_GET['el'];
				
		//Umwandeln in Integer
		$hid_int = (int)$h_id;
			
		// Löschen der history-stellen ist voraussetzung dafür, dass die entnahmeliste gelöscht werden kann
		//$del_his = "DELETE FROM history WHERE position = $el_int";
		//$delete_his = mysqli_query($db, $del_his) or die('Es konnte nicht aus der Datenbank gelöscht werden. Überprüfen Sie bitte Ihre Eingabe.');
		
		// Updaten der Entnahemliste an sich
		$del = "DELETE FROM history WHERE h_id = $hid_int";
		
		
		$delete = mysqli_query($db, $del) or die('Es konnte nicht aus der Datenbank gelöscht werden. Überprüfen Sie bitte Ihre Eingabe.');
	}
	
	
?>
<script type="text/javascript">
	location.href="entnahme_info.php?el=<?php echo $el ?>";
</script>