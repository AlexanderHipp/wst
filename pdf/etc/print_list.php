<?php 
	
	require_once('fpdf.php');
	require_once('fpdi.php');
	
	$pdf = new FPDI();
	
	$pagecount =  $pdf->setSourceFile('TestDoc.pdf');
	$tplidx = $pdf->importPage(1, '/MediaBox');
	
	$pdf->addPage();
	$pdf->useTemplate(tplidx, 10, 10, 90);
	
	$pdf->Output('newpdf.pdf', 'D');
?>