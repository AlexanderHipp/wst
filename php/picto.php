<?php
/**
*	@project: Werkstück-Management CHIRON-WERKE GmbH & Co. KG
*	@author: Alexander Hipp
*	@date: 01.04.2012
*/


	//Erzeugung eines Arrays. Es wird jedohc ein Strin gin $array[0] erzeugt
	$array = array($_GET['query_meg_codes']);


	// Aufteilung auf die Variablen mit Explode. Trennung nach jedem Komma
	list($eins, $zwei, $drei, $vier, $fuenf, $sechs, $sieben, $acht) = explode(",", $array[0]);



	//print_r($array);

	//Hier wird der Array query_meg_codes ausgelesenen und die jewieligen Werte den variablen übergeben, diese werden dann in wst_edit.php weiterverarbeitet

	//Branche

	$branche = array();

	if ($eins == '201' OR $zwei == '201' OR $drei == '201' OR $vier == '201' OR $fuenf == '201' OR $sechs == '201' OR $sieben == '201' OR $acht == '201') {
		$branche[1] = 201;
	}
	if ($eins == '202' OR $zwei == '202' OR $drei == '202' OR $vier == '202' OR $fuenf == '202' OR $sechs == '202' OR $sieben == '202' OR $acht == '202') {
		$branche[2] = 202;
	}
	if ($eins == '20201' OR $zwei == '20201' OR $drei == '20201' OR $vier == '20201' OR $fuenf == '20201' OR $sechs == '20201' OR $sieben == '20201' OR $acht == '20201') {
		$branche[2] = 20201;
	}
	if ($eins == '20202' OR $zwei == '20202' OR $drei == '20202' OR $vier == '20202' OR $fuenf == '20202' OR $sechs == '20202' OR $sieben == '20202' OR $acht == '20202') {
		$branche[2] = 20202;
	}
	if ($eins == '20203' OR $zwei == '20203' OR $drei == '20203' OR $vier == '20203' OR $fuenf == '20203' OR $sechs == '20203' OR $sieben == '20203' OR $acht == '20203') {
		$branche[2] = 20203;
	}
	if ($eins == '20204' OR $zwei == '20204' OR $drei == '20204' OR $vier == '20204' OR $fuenf == '20204' OR $sechs == '20204' OR $sieben == '20204' OR $acht == '20204') {
		$branche[2] = 20204;
	}
	if ($eins == '20205' OR $zwei == '20205' OR $drei == '20205' OR $vier == '20205' OR $fuenf == '20205' OR $sechs == '20205' OR $sieben == '20205' OR $acht == '20205') {
		$branche[2] = 20205;
	}
	if ($eins == '20206' OR $zwei == '20206' OR $drei == '20206' OR $vier == '20206' OR $fuenf == '20206' OR $sechs == '20206' OR $sieben == '20206' OR $acht == '20206') {
		$branche[2] = 20206;
	}
	if ($eins == '20207' OR $zwei == '20207' OR $drei == '20207' OR $vier == '20207' OR $fuenf == '20207' OR $sechs == '20207' OR $sieben == '20207' OR $acht == '20207') {
		$branche[2] = 20207;
	}
	if ($eins == '20208' OR $zwei == '20208' OR $drei == '20208' OR $vier == '20208' OR $fuenf == '20208' OR $sechs == '20208' OR $sieben == '20208' OR $acht == '20208') {
		$branche[2] = 20208;
	}
	if ($eins == '203' OR $zwei == '203' OR $drei == '203' OR $vier == '203' OR $fuenf == '203' OR $sechs == '203' OR $sieben == '203' OR $acht == '203') {
		$branche[3] = 203;
	}
	if ($eins == '204' OR $zwei == '204' OR $drei == '204' OR $vier == '204' OR $fuenf == '204' OR $sechs == '204' OR $sieben == '204' OR $acht == '204') {
		$branche[4] = 204;
	}
	if ($eins == '20401' OR $zwei == '20401' OR $drei == '20401' OR $vier == '20401' OR $fuenf == '20401' OR $sechs == '20401' OR $sieben == '20401' OR $acht == '20401') {
		$branche[4] = 20401;
	}
	if ($eins == '20402' OR $zwei == '20402' OR $drei == '20402' OR $vier == '20402' OR $fuenf == '20402' OR $sechs == '20402' OR $sieben == '20402' OR $acht == '20402') {
		$branche[4] = 20402;
	}
	if ($eins == '20403' OR $zwei == '20403' OR $drei == '20403' OR $vier == '20403' OR $fuenf == '20403' OR $sechs == '20403' OR $sieben == '20403' OR $acht == '20403') {
		$branche[4] = 20403;
	}
	if ($eins == '20404' OR $zwei == '20404' OR $drei == '20404' OR $vier == '20404' OR $fuenf == '20404' OR $sechs == '20404' OR $sieben == '20404' OR $acht == '20404') {
		$branche[4] = 20404;
	}
	if ($eins == '205' OR $zwei == '205' OR $drei == '205' OR $vier == '205' OR $fuenf == '205' OR $sechs == '205' OR $sieben == '205' OR $acht == '205') {
		$branche[5] = 205;
	}
	if ($eins == '20501' OR $zwei == '20501' OR $drei == '20501' OR $vier == '20501' OR $fuenf == '20501' OR $sechs == '20501' OR $sieben == '20501' OR $acht == '20501') {
		$branche[5] = 20501;
	}
	if ($eins == '20502' OR $zwei == '20502' OR $drei == '20502' OR $vier == '20502' OR $fuenf == '20502' OR $sechs == '20502' OR $sieben == '20502' OR $acht == '20502') {
		$branche[5] = 20502;
	}
	if ($eins == '20503' OR $zwei == '20503' OR $drei == '20503' OR $vier == '20503' OR $fuenf == '20503' OR $sechs == '20503' OR $sieben == '20503' OR $acht == '20503') {
		$branche[5] = 20503;
	}

	//Baureihe
	$baureihe = array();


	if ($eins == '401' OR $zwei == '401' OR $drei == '401' OR $vier == '401' OR $fuenf == '401' OR $sechs == '401' OR $sieben == '401' OR $acht == '401') {
		$baureihe[1] = 401;
	}
	if ($eins == '402' OR $zwei == '402' OR $drei == '402' OR $vier == '402' OR $fuenf == '402' OR $sechs == '402' OR $sieben == '402' OR $acht == '402') {
		$baureihe[2] = 402;
	}
	if ($eins == '403' OR $zwei == '403' OR $drei == '403' OR $vier == '403' OR $fuenf == '403' OR $sechs == '403' OR $sieben == '403' OR $acht == '403') {
		$baureihe[3] = 403;
	}
	if ($eins == '404' OR $zwei == '404' OR $drei == '404' OR $vier == '404' OR $fuenf == '404' OR $sechs == '404' OR $sieben == '404' OR $acht == '404') {
		$baureihe[4] = 404;
	}
	if ($eins == '405' OR $zwei == '405' OR $drei == '405' OR $vier == '405' OR $fuenf == '405' OR $sechs == '405' OR $sieben == '405' OR $acht == '405') {
		$baureihe[5] = 405;
	}
	if ($eins == '406' OR $zwei == '406' OR $drei == '406' OR $vier == '406' OR $fuenf == '406' OR $sechs == '406' OR $sieben == '406' OR $acht == '406') {
		$baureihe[6] = 406;
	}
	if ($eins == '407' OR $zwei == '407' OR $drei == '407' OR $vier == '407' OR $fuenf == '407' OR $sechs == '407' OR $sieben == '407' OR $acht == '407') {
		$baureihe[7] = 407;
	}
	if ($eins == '408' OR $zwei == '408' OR $drei == '408' OR $vier == '408' OR $fuenf == '408' OR $sechs == '408' OR $sieben == '408' OR $acht == '408') {
		$baureihe[8] = 408;
	}
	if ($eins == '409' OR $zwei == '409' OR $drei == '409' OR $vier == '409' OR $fuenf == '409' OR $sechs == '409' OR $sieben == '409' OR $acht == '409') {
		$baureihe[9] = 409;
	}





	//Technologie
	$technologie_1 = array();

	if ($eins == '101' OR $zwei == '101' OR $drei == '101' OR $vier == '101' OR $fuenf == '101' OR $sechs == '101' OR $sieben == '101' OR $acht == '101') {
		$technologie_1[1] = 101;
	}
	if ($eins == '102' OR $zwei == '102' OR $drei == '102' OR $vier == '102' OR $fuenf == '102' OR $sechs == '102' OR $sieben == '102' OR $acht == '102') {
		$technologie_1[2] = 102;
	}
	if ($eins == '103' OR $zwei == '103' OR $drei == '103' OR $vier == '103' OR $fuenf == '103' OR $sechs == '103' OR $sieben == '103' OR $acht == '103') {
		$technologie_1[3] = 103;
	}
	if ($eins == '104' OR $zwei == '104' OR $drei == '104' OR $vier == '104' OR $fuenf == '104' OR $sechs == '104' OR $sieben == '104' OR $acht == '104') {
		$technologie_1[4] = 104;
	}

	$technologie_2 = array();

	if ($eins == '111' OR $zwei == '111' OR $drei == '111' OR $vier == '111' OR $fuenf == '111' OR $sechs == '111' OR $sieben == '111' OR $acht == '111') {
		$technologie_2[1] = 111;
	}
	if ($eins == '112' OR $zwei == '112' OR $drei == '112' OR $vier == '112' OR $fuenf == '112' OR $sechs == '112' OR $sieben == '112' OR $acht == '112') {
		$technologie_2[2] = 112;
	}


	$technologie_3 = array();
	if ($eins == '121' OR $zwei == '121' OR $drei == '121' OR $vier == '121' OR $fuenf == '121' OR $sechs == '121' OR $sieben == '121' OR $acht == '121') {
		$technologie_3[1] = 121;
	}
	if ($eins == '122' OR $zwei == '122' OR $drei == '122' OR $vier == '122' OR $fuenf == '122' OR $sechs == '122' OR $sieben == '122' OR $acht == '122') {
		$technologie_3[2] = 122;
	}
	if ($eins == '123' OR $zwei == '123' OR $drei == '123' OR $vier == '123' OR $fuenf == '123' OR $sechs == '123' OR $sieben == '123' OR $acht == '123') {
		$technologie_3[3] = 123;
	}
	if ($eins == '124' OR $zwei == '124' OR $drei == '124' OR $vier == '124' OR $fuenf == '124' OR $sechs == '124' OR $sieben == '124' OR $acht == '124') {
		$technologie_3[4] = 124;
	}

	$technologie_4 = array();

	if ($eins == '131' OR $zwei == '131' OR $drei == '131' OR $vier == '131' OR $fuenf == '131' OR $sechs == '131' OR $sieben == '131' OR $acht == '131') {
		$technologie_4[1] = 131;
	}
	if ($eins == '132' OR $zwei == '132' OR $drei == '132' OR $vier == '132' OR $fuenf == '132' OR $sechs == '132' OR $sieben == '132' OR $acht == '132') {
		$technologie_4[2] = 132;
	}
	if ($eins == '133' OR $zwei == '133' OR $drei == '133' OR $vier == '133' OR $fuenf == '133' OR $sechs == '133' OR $sieben == '133' OR $acht == '133') {
		$technologie_4[3] = 133;
	}
	if ($eins == '141' OR $zwei == '141' OR $drei == '141' OR $vier == '141' OR $fuenf == '141' OR $sechs == '141' OR $sieben == '141' OR $acht == '141') {
		$technologie_4[4] = 141;
	}





?>
