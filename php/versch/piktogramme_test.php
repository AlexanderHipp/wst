<?php include("base.php");?>



<script type="text/javascript" src="../js/jquery.all.js"></script>
<script type="text/javascript" src="../js/jquery-latest.js"></script>
<script type="text/javascript" src="../js/epos.js"></script>
<link rel="stylesheet" href="../css/search_picto.css" type="text/css">


<div id="page">
	<div id="heading"></div>
    <div id="navi">
          <?php include("navi.php"); ?>
    </div>

    <div id="main">
           
           
            <?php 
			   if (isset($_GET['query_meg_codes'])) {
					
					
					$gut = $_GET['query_meg_codes'];
					
					
					echo $gut;
					
					if ($gut == 401) {
						echo "es funktioniert";
					}
					
					if ($gut == 402) {
						echo "das auch";
					}
			   }
		   ?> 
           
           

    
    	  <!--Überschrift im grauen Kasten-->
          <div id="pagehead"><span>Neues Werkstück anlegen</span></div>
        
        
    	<form name="queryform" action="<?php echo $_SERVER['PHP_SELF'];?>" method="get" class="mdbpriv1" onsubmit="return gf_onsubmit_set_meg()">
        
        
        <div id="box">
        <!-- Aktion noch hinzufügen zu Link alles auf einem Button  onclick="window.location.href='user_all.php'""-->
              <input name="query_meg_codes" id="meg_codes" type="hidden">
              <a href="javascript:gf_onsubmit_set_meg();document.queryform.submit();" rel="nofollow">start</a>
              
        </div>
        

        
       <div id="box" style="clear:both;">
                  
                      <table border="0">
                            
                           <tr>
                            <td><label for="branche">Branche </label></td>
                                                       
                            <td style="padding-left:63px;"colspan="3">
                                    
                                    
                               
                                    
                                    <div id="meg201" class="meg_btn btngrp_MEG02" onClick="gf_toggle_btn_with_ddlb('#meg201', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_201_4multistate.png)" title="Aerospace"></div>
                                    <div id="meg202" class="meg_btn btngrp_MEG02" onClick="gf_toggle_btn_with_ddlb('#meg202', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_202_4multistate.png)" title="Automotive"></div>
                                    <div id="meg203" class="meg_btn btngrp_MEG02" onClick="gf_toggle_btn_with_ddlb('#meg203', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_203_4multistate.png)" title="Medical"></div>
                                    <div id="meg204" class="meg_btn btngrp_MEG02" onClick="gf_toggle_btn_with_ddlb('#meg204', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_204_4multistate.png)" title="Mechanical Engineering"></div>
                                    <div id="meg205" class="meg_btn btngrp_MEG02" onClick="gf_toggle_btn_with_ddlb('#meg205', 'meg_btn_pushed', 'MEG02')" style="background-image:url(../img/meg_205_4multistate.png)" title="Precision Technology"></div>
                                    
                                    
                                   
                                    
                                    <select name="aerospace" size="1" id="meg202_ddlb" class="meg_ddlb ddlbgrp_MEG02" style="display:none">
                                    <option></option>
                                    
                                    <option value="20201">Antriebsstrang</option>
                                    <option value="20202">Bremssysteme</option>
                                    <option value="20203">Klima- &amp; L&uuml;ftungssysteme</option>
                                    <option value="20204">Kraftstoffsysteme</option>
                                    <option value="20205">Felgen</option>
                                    <option value="20206">Motor &amp; Aggregate</option>
                                    
                                    <option value="20207">Lenk- &amp; Fahrwerksysteme</option>
                                    <option value="20208">Karosserieteile</option>
                                    </select>
                                    
                                    
                                    <select name="" size="1" id="meg204_ddlb" class="meg_ddlb ddlbgrp_MEG02" style="display:none">
                                    <option></option>
                                    <option value="20401">Armaturen</option>
                                    <option value="20402">Werkzeuge &amp; Ger&auml;te</option>
                                    
                                    <option value="20403">Maschinenbau</option>
                                    <option value="20404">Zusatzinformationen</option>
                                    </select>
                                    
                                    
                                    <select name="" size="1" id="meg205_ddlb" class="meg_ddlb ddlbgrp_MEG02" style="display:none">
                                    <option></option>
                                    <option value="20501">Elektrik &amp; Elektronik</option>
                                    <option value="20502">Beschl&auml;ge &amp; Schlie&szlig;systeme</option>
                                    
                                    <option value="20503">Uhren, Schmuck &amp; Optik</option>
                                    </select>
                                    
                                    
                                    
                            	</td>
                            </tr>
                      </table>
       	 </div>
         <div id="box">
                      <table border="0">
                            <tr>
                                <td><label  for="technologie">Technologie </label></td>
                                <td  style="padding-left:25px;" colspan="3">
                                    <input type="hidden">
                                    <div class="meg_group" id="MEG_GROUP_MEG01">
                                    	<div class="meg_subgroup" id="MEG_SUBGROUP_MEG01_0">
                                            <div id="meg101" class="meg_btn" onClick="$('#meg101').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_101_4multistate.png)" title="FZ Einspindel"></div>
                                            <div id="meg102" class="meg_btn" onClick="$('#meg102').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_102_4multistate.png)" title="FZ Doppelspindel"></div>
                                            
                                            <div id="meg103" class="meg_btn" onClick="$('#meg103').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_103_4multistate.png)" title="FZ Vierspindel"></div>
                                            <div id="meg104" class="meg_btn" onClick="$('#meg104').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_104_4multistate.png)" title="NC-Schwenkkopf"></div>
                                            </div>
                                            <div class="meg_subgroup" id="MEG_SUBGROUP_MEG01_1">
                                            <div id="meg111" class="meg_btn" onClick="$('#meg111').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_111_4multistate.png)" title="Korb-Werkzeugwechsler"></div>
                                            <div id="meg112" class="meg_btn" onClick="$('#meg112').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_112_4multistate.png)" title="Ketten-Werkzeugwechsler"></div>
                                            </div>
                                            <div class="meg_subgroup" id="MEG_SUBGROUP_MEG01_2">
                                            <div id="meg121" class="meg_btn" onClick="$('#meg121').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_121_4multistate.png)" title="Starrtisch"></div>
                                            <div id="meg122" class="meg_btn" onClick="$('#meg122').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_122_4multistate.png)" title="Werkst&uuml;ckwechseleinrichtung"></div>
                                            <div id="meg123" class="meg_btn" onClick="$('#meg123').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_123_4multistate.png)" title="Five axis"></div>
                                            <div id="meg124" class="meg_btn" onClick="$('#meg124').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_124_4multistate.png)" title="Langbett"></div>
                                            </div>
                                            <div class="meg_subgroup" id="MEG_SUBGROUP_MEG01_3">
                                            <div id="meg131" class="meg_btn" onClick="$('#meg131').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_131_4multistate.png)" title="Stangen-Bearbeitung"></div>
                                            <div id="meg132" class="meg_btn" onClick="$('#meg132').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_132_4multistate.png)" title="MPS"></div>
                                            <div id="meg133" class="meg_btn" onClick="$('#meg133').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_133_4multistate.png)" title="WM Felgenbearbeitung"></div>
                                            
                                            <div id="meg141" class="meg_btn" onClick="$('#meg141').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_141_4multistate.png)" title="Automation"></div>
                                        </div>
                                    </div>
                                    </td>
                            </tr>
                            
                            <tr class="mdb_meg mdb_MEG04">
                            	<td class="query_label">Baureihe</td><td colspan="3">
                            	    <div class="meg_group" id="MEG_GROUP_MEG04">
                                    	<div class="meg_subgroup" id="MEG_SUBGROUP_MEG04_">
                                    		<div id="meg401" class="meg_btn" onClick="$('#meg401').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_401_4multistate.png)" title="08"></div>
                                            <div id="meg402" class="meg_btn" onClick="$('#meg402').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_402_4multistate.png)" title="12"></div>
                                            <div id="meg403" class="meg_btn" onClick="$('#meg403').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_403_4multistate.png)" title="15"></div>
                                            <div id="meg404" class="meg_btn" onClick="$('#meg404').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_404_4multistate.png)" title="18"></div>
                                            <div id="meg405" class="meg_btn" onClick="$('#meg405').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_405_4multistate.png)" title="MILL"></div>
                                            <div id="meg406" class="meg_btn" onClick="$('#meg406').toggleClass('meg_btn_pushed')" style="background-image:url(../img/meg_406_4multistate.png)" title="BIG MILL"></div>
                                        </div>
                                    </div>											
                              </td>
                        	</tr>
                            
                          
                          
                      </table>
         </div>
        
        
       
        <form>
           
    
    	
      </div>  
   
</div>