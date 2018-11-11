<?php
require_once (__DIR__.'/includes/classes/global.inc.php');
//require(__DIR__.'/includes/classes/fpdf.php');
require(__DIR__.'/includes/classes/rotate.php');
class PDF extends PDF_Rotate
{
function RotatedText($x,$y,$txt,$angle)
{
    //Text rotated around its origin
    $this->Rotate($angle,$x,$y);
    $this->Text($x,$y,$txt);
    $this->Rotate(0);
}
}

if(!empty($_REQUEST['Token']) && (hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/orders.php', $_SESSION['csrf_token']))) && !empty($_REQUEST['action'])&& !empty($_REQUEST['Oid']) ){
  $action = isset($_REQUEST['action']) ? filter_var(($_REQUEST['action']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH): '';
  $Oid = isset($_REQUEST['Oid']) ? filter_var(($_REQUEST['Oid']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : '';

        $name_file = "InvoiceWEB-".$Oid.".pdf";

$EmailOrderMstr=$order->QueryOrderMaster($Oid);
$rows =  mysqli_fetch_array($EmailOrderMstr);
$SubTotal=0;
$slno=0;
$totqty=0;

$sql = "select count(*) FROM orders_products where orders_id='".$Oid."'";
$result = $db->select($sql);
$row_client = mysqli_fetch_row($result);
mysqli_free_result($result);
$nb_page = $row_client[0];
$sql = 'select abs(FLOOR(-' . $nb_page . '/25))';
$result = $result = $db->select($sql);
$row_client = mysqli_fetch_row($result);
mysqli_free_result($result);
$nb_page = $row_client[0];
$num_page = 1; $limit_inf = 0; $limit_sup = 25;
//print_r($nb_page);
$sql= "select * from payment_details where order_id='".$Oid."'";
$result = $db->select($sql);
$row_pymnt = mysqli_fetch_array($result);

//$pdf = new FPDF( 'P', 'mm', 'A4' );
$pdf = new PDF('P', 'mm', 'A4');
	// the top 2 cm down
	$pdf->SetAutoPagebreak(False);
	$pdf->SetMargins(0,0,0);

	$num_page = 1; $limit_inf = 0; $limit_sup = 25;
While ($num_page <= $nb_page)
	{
	$pdf->AddPage();
  // logo: 80 of width and 55 of height
		$pdf->Image('../img/logo.png', 5, 5, 70, 20);
		// Address  in upper right
		//$pdf->SetXY( 120, 5 ); $pdf->SetFont( "rupeeforadian", "B", 12 ); $pdf->Cell( 160, 8, $num_page . '/' . $nb_page, 0, 0, 'C');
	$pdf->SetXY( 5, 19 );$pdf->SetFont( "rupeeforadian", "", 9 );$pdf->Cell( 5, 19, strtoupper('Ayurveda College Jn'), 0, 0, 'L');
	$pdf->SetXY( 5, 22 );$pdf->Cell( 5, 22, strtoupper('Old Sreekandeswaram Road'), 0, 0, 'L');
	$pdf->SetXY( 5, 25 );$pdf->Cell( 5, 25, strtoupper('Thiruvananthapuram, KERALA - 695 001'), 0, 0, 'L');
	$pdf->SetXY( 5, 28 );$pdf->Cell( 5, 28, 'Contact :- +91-471-2478397', 0, 0, 'L');
	$pdf->SetXY( 5, 31 );$pdf->Cell( 5, 31, 'Email : salesteam@prabhusbooks.com', 0, 0, 'L');

	$pdf->SetXY(150, 5 );$pdf->SetFont( "rupeeforadian", "", 9 );$pdf->Cell( 3, 3, strtoupper('GST No: 32AADFP2938F2ZH'), 0, 0, 'L');
//invoice
$pdf->SetTextColor(153, 153, 153);
$pdf->SetXY( 150, 18 );$pdf->SetFont( "rupeeforadian", "", 24 );$pdf->Cell( 8, 8, 'INVOICE', 0, 0, 'L');

	//order Number
$num_fact = "Invoice No:-" . $annee .'WEB-' . str_pad($rows['orders_id'], 4, '0', STR_PAD_LEFT);
$pdf->SetXY( 150, 30 );$pdf->SetTextColor(0, 0, 0);$pdf->SetFont( "rupeeforadian", "", 12 );$pdf->Cell( 85, 8, $num_fact, 0, 0, 'L');

// date BILL
$champ_date = date_create($row['date_purchased']); $date_fact = date_format($champ_date, 'd/m/Y');
$date_fact = str_pad($date_fact, 4, '0', STR_PAD_LEFT);
$pdf->SetXY( 150, 42 );$pdf->SetFont('rupeeforadian','',11);$pdf->Cell( 85, 8, "Invoice Date:-" . $date_fact, 0, 0, 'L');
$pdf->SetLineWidth(0.1); $pdf->Line(5, 50, 205, 50);$pdf->Line(5, 50, 205, 50);
//Billed to
$pdf->SetXY( 10, 50 );$pdf->SetFont('rupeeforadian','',10);$pdf->Cell( 85, 8, "Billed To:-", 0, 0, 'L');
$pdf->SetXY( 26, 55 );$pdf->SetFont('rupeeforadian','',9);$pdf->Cell( 85, 8, ''.strtoupper($rows['customers_name']), 0, 0, 'L');
if (empty($rows['customers_company'])){
  $pdf->SetXY( 26, 60 );$pdf->Cell( 85, 8, strtoupper($rows['customers_street_address']), 0, 0, 'L');
  $pdf->SetXY( 26, 65 );$pdf->Cell( 85, 8, strtoupper($rows['customers_suburb'].', '.$rows['customers_city']), 0, 0, 'L');
  $pdf->SetXY( 26, 70 );$pdf->Cell( 85, 8, strtoupper($rows['customers_state']).' - '.$rows['customers_postcode'], 0, 0, 'L');
}
else {
  $pdf->SetXY( 26, 60 );$pdf->Cell( 85, 8, strtoupper($rows['customers_company']), 0, 0, 'L');
  $pdf->SetXY( 26, 65 );$pdf->Cell( 85, 8, strtoupper($rows['customers_street_address']), 0, 0, 'L');
  $pdf->SetXY( 26, 70 );$pdf->Cell( 85, 8, strtoupper($rows['customers_suburb'].', '.$rows['customers_city']), 0, 0, 'L');
  $pdf->SetXY( 26, 75 );$pdf->Cell( 85, 8, strtoupper($rows['customers_state']).' - '.$rows['customers_postcode'], 0, 0, 'L');
}
//Shipped To
$pdf->SetXY( 110, 50 );$pdf->SetFont('rupeeforadian','',10);$pdf->Cell( 85, 8, "Shipping Address:-", 0, 0, 'L');
$pdf->SetXY( 130, 55 );$pdf->SetFont('rupeeforadian','',9);$pdf->Cell( 85, 8, strtoupper($rows['delivery_name']), 0, 0, 'L');
if (empty($rows['delivery_company'])){
  $pdf->SetXY( 130, 60 );$pdf->Cell( 85, 8, strtoupper($rows['delivery_street_address']), 0, 0, 'L');
  $pdf->SetXY( 130, 65 );$pdf->Cell( 85, 8, strtoupper($rows['delivery_suburb'].', '.$rows['delivery_city']), 0, 0, 'L');
  $pdf->SetXY( 130, 70 );$pdf->Cell( 85, 8, strtoupper($rows['delivery_state']).' - '.$rows['delivery_postcode'], 0, 0, 'L');
}
else{
  $pdf->SetXY( 130, 60 );$pdf->Cell( 85, 8, strtoupper($rows['delivery_company']), 0, 0, 'L');
  $pdf->SetXY( 130, 65 );$pdf->Cell( 85, 8, strtoupper($rows['delivery_street_address']), 0, 0, 'L');
  $pdf->SetXY( 130, 70 );$pdf->Cell( 85, 8, strtoupper($rows['delivery_suburb'].', '.$rows['delivery_city']), 0, 0, 'L');
  $pdf->SetXY( 130, 75 );$pdf->Cell( 85, 8, strtoupper($rows['delivery_state']).' - '.$rows['delivery_postcode'], 0, 0, 'L');
}
$pdf->SetLineWidth(0.1);$pdf->Line(5, 83, 205, 83);$pdf->Line(105, 50, 105, 83);$pdf->Line(5, 50, 5, 83);$pdf->Line(205, 50, 205, 83);
//headings
$pdf->SetXY( 1, 85 ); $pdf->SetFont('rupeeforadian','',8); $pdf->Cell( 18, 8, "SlNo", 0, 0, 'C');
$pdf->SetXY( 15, 85 ); $pdf->SetFont('rupeeforadian','',8); $pdf->Cell( 140, 8, "Purticulars", 0, 0, 'C');
$pdf->SetXY( 145, 85 ); $pdf->SetFont('rupeeforadian','',8); $pdf->Cell( 13, 8, "Qty", 0, 0, 'C');
$pdf->SetXY( 156, 85 ); $pdf->SetFont('rupeeforadian','',8); $pdf->Cell( 22, 8, "Price", 0, 0, 'C');
$pdf->SetXY( 180, 85 ); $pdf->SetFont('rupeeforadian','',8); $pdf->Cell( 22, 8, "Total", 0, 0, 'C');
//Lines
if ($num_page <> $nb_page)
{
// frame with 18 lines max! and 118 in height -> 95 + 118 = 213 for vertical lines
$pdf->SetLineWidth(0.1); $pdf->Rect(5, 85, 200, 160, "D");
// column title frame
$pdf->Line(5, 92, 205, 92);
// the vertical columns
$pdf->Line(18, 85, 18, 245);$pdf->Line(145, 85, 145, 245); $pdf->Line(158, 85, 158, 245); $pdf->Line(176, 85, 176, 245); //$pdf->Line(187, 95, 187, 213);
}
else {
	// frame with 18 lines max! and 118 in height -> 95 + 118 = 213 for vertical lines
	$pdf->SetLineWidth(0.1);$pdf->Rect(5, 85, 200, 160, "D");
	// column title frame
	$pdf->Line(5, 92, 205, 92);
	// the vertical columns
	$pdf->Line(18, 85, 18, 245);$pdf->Line(145, 85, 145, 245); $pdf->Line(158, 85, 158, 245); $pdf->Line(176, 85, 176, 245); //$pdf->Line(187, 95, 187, 213);
}
// les articles
$pdf->SetFont('rupeeforadian',"",8);
$y = 85;

// 1st page = LIMIT 0,18 ;  2nd page = LIMIT 18,36 etc...
$sql = "select * from orders_products	where orders_id = '".$Oid."' order by orders_products_id";
$sql .= ' LIMIT ' . $limit_inf . ',' . $limit_sup;
$res = $db->select($sql);
while ($data =  mysqli_fetch_assoc($res))
{
	$slno=$slno+1;
	//SlNo
	$pdf->SetXY( 7, $y+9 );$pdf->SetFont('rupeeforadian','',8); $pdf->Cell( 20, 5, $slno.',', 0, 0, 'L');
	// Wording
	$pdf->SetXY( 18, $y+9 );$pdf->SetFont('rupeeforadian','',8); $pdf->ClippedCell( 125, 5, '['.$data['products_model'].'] '.$data['products_name'], 0, 0, 'L');
	// Qty
	$pdf->SetXY( 143, $y+9 );$pdf->SetFont('rupeeforadian','',8); $pdf->Cell( 13, 5, strrev(wordwrap(strrev($data['products_quantity']), 3, ' ', true)), 0, 0, 'R');
	// PU
	$nombre_format_francais = number_format($data['products_price'], 2);
	$pdf->SetXY( 158, $y+9 );$pdf->SetFont('rupeeforadian','',8); $pdf->Cell( 18, 5, $nombre_format_francais, 0, 0, 'R');
	// Taux
	//$nombre_format_francais = number_format($data['taux_tva'], 2, ',', ' ');
	//$pdf->SetXY( 177, $y+9 ); $pdf->Cell( 10, 5, $nombre_format_francais, 0, 0, 'R');
	// total
	$number_format = number_format($data['products_price']*$data['products_quantity'], 2);
	$pdf->SetXY( 187, $y+9 );$pdf->SetFont('rupeeforadian','',8); $pdf->Cell( 18, 5, $number_format, 0, 0, 'R');

	//$pdf->Line(5, $y+14, 205, $y+14);
$y += 6;
	$SubTotal=$SubTotal+($data['products_price']*$data['products_quantity']);
	$totqty=$totqty+$data['products_quantity'];
}
mysqli_free_result($res);
// ifnot last page then show Sub total
if ($num_page <> $nb_page)
{
	// the totals, we only display the HT. the frame after the lines, starts at 213
	$pdf->SetLineWidth(0.1); //$pdf->SetFillColor(192); $pdf->Rect(5, 213, 90, 8, "DF");
	// HT, VAT and VAT are calculated after
	//$number_format = "Total HT : " . number_format($SubTotal, 2, ',', ' ') . "";
	$pdf->SetFont('rupeeforadian','',10); $pdf->SetXY( 105, 280 ); $pdf->Cell( 63, 8, 'Sub Total', 0, 0, 'L');
	$pdf->SetFont('rupeeforadian','',10); $pdf->SetXY( 120, 280 ); $pdf->Cell( 63, 8, $totqty, 0, 0, 'C');
	// bottom right
	$pdf->SetFont('rupeeforadian','',10); $pdf->SetXY( 181, 280 ); $pdf->Cell( 24, 8, number_format($SubTotal, 2), 0, 0, 'R');

	// vertical stroke frame totals, 8 in height -> 213 + 8 = 221
	//$pdf->Rect(5, 255, 200, 8, "D");	$pdf->Line(145, 255, 145, 263); $pdf->Line(158, 255, 158, 263);$pdf->Line(176, 255, 176, 263);
}

// if last page then display Total box
if ($num_page == $nb_page)
{
  $pdf->SetFont('rupeeforadian','',20);
  $pdf->SetTextColor(242, 242, 242);
  //<145 angle = 45, y>146<192 or y>200 and >230
  if ($y<145){
    $pdf->SetXY( 180, $y); $pdf->RotatedText(20,$y+(247-$y),'This portion is intentionally left blank',45);
  }
  elseif (($y>146) && ($y<200)) {
    $pdf->SetXY( 180, $y); $pdf->RotatedText(20,$y+(247-$y),'This portion is intentionally left blank',15);
  }

  $pdf->SetTextColor(0,0,0);

	$pdf->SetFont('rupeeforadian','',10); $pdf->SetXY( 105, 245 ); $pdf->Cell( 63, 8, 'Total', 0, 0, 'L');
	$pdf->SetFont('rupeeforadian','',10); $pdf->SetXY( 120, 245 ); $pdf->Cell(63, 8, $totqty, 0, 0, 'C');
	// bottom right
	$pdf->SetFont('rupeeforadian','',10); $pdf->SetXY( 181, 245 ); $pdf->Cell( 24, 8, number_format($SubTotal, 2), 0, 0, 'R');
	// vertical stroke frame totals, 8 in height -> 213 + 8 = 221
	//$pdf->Rect(5, 232, 200, 8, "D");	$pdf->Line(145, 232, 145, 240); $pdf->Line(158, 232, 158, 240);$pdf->Line(176, 232, 176, 240);
//Bottom left
$pdf->SetFont('rupeeforadian','',8);
$pdf->SetXY( 5, 256 ); $pdf->Cell( 38, 5, "Pay Mode:", 0, 0, 'L'); $pdf->Cell( 45, 5, $row_pymnt['card_name'].' - '.$row_pymnt['payment_mode'], 0, 0, 'L');
$pdf->SetXY( 5, 262 ); $pdf->Cell( 38, 5, "Bank Ref:", 0, 0, 'L'); $pdf->Cell( 45, 5, $row_pymnt['bank_ref_no'], 0, 0, 'L');
$pdf->SetXY( 5, 268 ); $pdf->Cell( 38, 5, "Shipping:", 0, 0, 'L'); $pdf->Cell( 45, 5, $rows['shipping_method'], 0, 0, 'L');
$pdf->SetXY( 5, 274 ); $pdf->Cell( 38, 5, "Instructions:", 0, 0, 'L'); $pdf->Cell( 45, 5, '', 0, 0, 'L');
//Bottom Right
	$pdf->SetFont('rupeeforadian','',8);
	$pdf->SetXY( 152, 256 ); $pdf->Cell( 25, 6, "Add Shipping Fee:", 0, 0, 'R');
	$pdf->SetXY( 152, 262 ); $pdf->Cell( 25, 6, "IGST:", 0, 0, 'R');
	$pdf->SetXY( 152, 268 ); $pdf->Cell( 25, 6, "CGST:", 0, 0, 'R');
	$pdf->SetXY( 152, 274 ); $pdf->Cell( 25, 6, "SGST:", 0, 0, 'R');
	$pdf->SetFont('rupeeforadian','',10);$pdf->SetXY( 152, 280 ); $pdf->Cell( 25, 6, "Total:", 0, 0, 'R');
	// bottom right
	$pdf->SetFont('rupeeforadian','',9); $pdf->SetXY( 181, 256 ); $pdf->Cell( 24, 6, number_format($rows['shipping_cost'], 2), 0, 0, 'R');
	// IGST
	$pdf->SetFont('rupeeforadian','',9); $pdf->SetXY( 181, 262 ); $pdf->Cell( 24, 6, number_format(0, 2), 0, 0, 'R');
	$pdf->SetFont('rupeeforadian','',9); $pdf->SetXY( 181, 268 ); $pdf->Cell( 24, 6, number_format(0, 2), 0, 0, 'R');
 $pdf->SetFont('rupeeforadian','',9); $pdf->SetXY( 181, 274 ); $pdf->Cell( 24, 6, number_format(0, 2), 0, 0, 'R');
 $pdf->SetFont('rupeeforadian','',10); $pdf->SetXY( 181, 280 ); $pdf->Cell( 24, 6, '` '.number_format(($rows['order_total']), 2), 0, 0, 'R');

}

//Footer
$pdf->SetXY( 1, 290); $pdf->SetFont('rupeeforadian','',7);
//$pdf->SetFont( "rupeeforadian", "", 10 );
$pdf->Cell( $pdf->GetPageWidth(), 7, " It's a Computer Generated Document Hence No Signature is needed", 0, 0, 'L');

$pdf->SetXY( 120, 290 ); $pdf->SetFont( "rupeeforadian", "", 8 ); $pdf->Cell( 160, 8, $num_page . '/' . $nb_page, 0, 0, 'C');
			// par page de 18 lignes
			$num_page++; $limit_inf += 25; $limit_sup = 25;

}
$pdf->SetXY( 1, 280); $pdf->SetFont('rupeeforadian','',7);
$pdf->SetFont( "rupeeforadian", "", 9 );
$pdf->Cell( $pdf->GetPageWidth(), 7, getIndianCurrency($rows['order_total']), 0, 0, 'L');
	$pdf->Output("I", $name_file);
}
else{
$response= array("ERROR","Invalid Access");
echo json_encode($response);
}
?>
