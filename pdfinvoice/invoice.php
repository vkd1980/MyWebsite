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
		// bottom right
			$pdf->SetFont('Arial','B',8); $pdf->SetXY( 181, 227 ); $pdf->Cell( 24, 6, number_format(100, 2, ',', ' '), 0, 0, 'R');
		
	$pdf->Output();
?>