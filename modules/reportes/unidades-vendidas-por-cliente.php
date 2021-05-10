<?php

include 'template.php';
require '../../global/connection.php';

if (!isset($_GET['productid'])){
	echo "Error al obtener reporte. Variable 'productid' no especificada.";
	return;
}

if (!isset($_GET['datefrom'])){
	echo "Error al obtener reporte. Variable 'datefrom' no especificada.";
	return;
}

if (!isset($_GET['dateto'])){
	echo "Error al obtener reporte. Variable 'dateto' no especificada.";
	return;
}

$productId = $_GET['productid'];
$dateFrom = $_GET['datefrom'];
$dateTo = $_GET['dateto'];

/*
$reportTitle = "";
$orderString = "";

if ($mode == 1){
	$reportTitle = "Top 20 - Productos Más Vendidos";
	$orderString = "DESC";
}else if ($mode == 2){
	$reportTitle = "Top 20 - Productos Menos Vendidos";
	$orderString = "ASC";
}else{
	echo "Error al obtener reporte. Valor para variable 'mode' no válido.";
	return;
}
*/

$reportTitle = "Unidades Vendidas por Cliente";

$productString = "";
$dateString = "";

if ($productId!= 0 && $productId!= ""){
	$productString = " AND td.item_id = " . $productId;
}

if ($dateFrom!= "" && $dateTo!= ""){
	$dateString = " AND (th.date BETWEEN '" . $dateFrom . "' AND '". $dateTo . "')";
}

$sqlString = "(SELECT th.ruc, th.name, SUM(td.item_quantity) AS SOLD_UNITS
FROM tbl_invoice_detail td
JOIN tbl_invoice th on th.id=td.invoice_id
WHERE th.status NOT IN (2) " . $productString . $dateString .
" GROUP BY 1
ORDER BY SOLD_UNITS)
UNION
(SELECT th.ruc, th.name, SUM(td.item_quantity) AS SOLD_UNITS
FROM tbl_receipt_detail td
JOIN tbl_receipt th on th.id=td.receipt_id
WHERE th.status NOT IN (2)" . $productString . $dateString .
" GROUP BY 1
ORDER BY SOLD_UNITS)  
ORDER BY name ASC";

$sqlStatement = $pdo->prepare($sqlString);

$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->SetHeaderTitle(utf8_decode($reportTitle));
$pdf->AddPage("L","A4",0);
$pdf->SetTitle($reportTitle,true);
$pdf->SetSubject($reportTitle,true);
$pdf->SetAuthor("ESG Perú",true);
$pdf->SetCreator("fpdf v1.82",true);

$pdf->SetFillColor(232,232,232);
$pdf->SetFont('Arial','B',10);

$pdf->Cell(24,6,utf8_decode('RUC'),1,0,'C',1);
$pdf->Cell(223,6,utf8_decode('Nombre'),1,0,'L',1);
$pdf->Cell(30,6,utf8_decode('UNIDADES'),1,0,'C',1);
$pdf->Ln();

$pdf->SetFont('Arial','',9);

if ($rowsNumber > 0) {
    foreach ($sqlStatement as $row) {
		$pdf->Cell(24,6,utf8_decode($row['ruc']),1,0,'C');
		$pdf->Cell(223,6,utf8_decode($row['name']),1,0,'L');
		$pdf->Cell(30,6,utf8_decode($row['SOLD_UNITS']),1,0,'C');
		$pdf->Ln();
	}
}else{
	$pdf->Cell(277,6,utf8_decode("No existen datos para el producto especificado"),1,0,'C');
}


$pdf->Output("I", $reportTitle . ".pdf", true);