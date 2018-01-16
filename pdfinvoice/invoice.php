<?php
	require('fpdf.php');
	$pdf = new FPDF( 'P', 'mm', 'A4' );
	// the top 2 cm down
	$pdf->SetAutoPagebreak(False);
	$pdf->SetMargins(0,0,0);
	$pdf->AddPage();
	// logo: 80 of width and 55 of height
		$pdf->Image('../img/logo.png', 10, 10, 70, 20);
		// No. page in upper right
		$pdf->SetXY( 120, 5 ); $pdf->SetFont( "Arial", "B", 12 ); $pdf->Cell( 160, 8, '1/1', 0, 0, 'C');	
		
	$pdf->Output();
?>