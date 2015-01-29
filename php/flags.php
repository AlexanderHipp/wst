<?php 
/** 
*	@project: Werkstück-Management CHIRON-WERKE GmbH & Co. KG
*	@author: Alexander Hipp
*	@date: 01.04.2012
*/

include("base.php");
	
		// Hier wird geprüft ob schon eine Anmeldung erfolgt ist
		if (!isset($_SESSION['ben_id'])) {
			?>
			<div id="box_anmelden" style="margin-top:10px;">Bitte zuerst <a href="index.php" style="text-decoration:underline;">anmelden</a></div><?php
			exit();
		} else { 
	?>
    
     <div id="flags">
    
     <?php if ($seite == 'wst_info.php') {?>
     		   <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>?lfd=<?php echo $zeile_wst['lfd_nr']; ?>">
     <?php } elseif  ($seite == 'entnahme_info.php') {?>
	 		   <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>?el=<?php echo $el; ?>">
	 <?php } else {?>
        	   <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
     <?php } ?>

            <div style="float:left;"/>
                <input name="ger" type="submit" class="german" alt="deutsch" value="" />
	                <?php 
					if (isset($_POST['ger'])) {
						$_SESSION['la'] = 'de';
					}
					?>
            </div>
            
            
            <div style="float:left; margin-left:5px;"/>
            	<input name="eng" type="submit" class="english" alt="english" value=""/>  
                	<?php 
					if (isset($_POST['eng'])) {
						$_SESSION['la'] = 'en';	
					}
					?> 
            </div>
            
        </form>
     </div>
 
 <?php }  ?>
 
