<?php

include 'template.php';
require '../../global/connection.php';

if (!isset($_GET['customerid'])){
	echo "Error al obtener reporte. Variable 'customerid' no especificada.";
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

$customerId = $_GET['customerid'];
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

$reportTitle = "Ventas por Cliente";

$productString = "";
$dateString = "";

/*
if ($productId!= 0 && $productId!= ""){
	$productString = " AND td.item_id = " . $productId;
}
*/

if ($dateFrom!= "" && $dateTo!= ""){
	$dateString = " AND (th.date BETWEEN '" . $dateFrom . "' AND '". $dateTo . "')";
}

$sqlString = "(SELECT id, CONCAT(series, '-',number) AS DOC_NUMBER,
date,
delivery_date,
currency,
total_sub,
total_tax,
total_net,
(CASE
 WHEN th.status=1 THEN 'Vigente'
 WHEN th.status=2 THEN 'Anulado'
 WHEN th.status=3 THEN 'Pendiente de Pago'
 WHEN th.status=4 THEN 'Cancelado'
END) AS STATUS
FROM tbl_invoice th
WHERE th.ruc= '" . $customerId . "' " . $dateString . ")
UNION
(SELECT id, CONCAT(series, '-',number) AS DOC_NUMBER,
date,
delivery_date,
currency,
total_sub,
total_tax,
total_net,
(CASE
 WHEN th.status=1 THEN 'Vigente'
 WHEN th.status=2 THEN 'Anulado'
 WHEN th.status=3 THEN 'Pendiente de Pago'
 WHEN th.status=4 THEN 'Cancelado'
END) AS STATUS
FROM tbl_receipt th
WHERE th.ruc= '" . $customerId . "' " . $dateString . ")
ORDER BY id DESC";

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

$pdf->Cell(16,6,utf8_decode('ID'),1,0,'C',1);
$pdf->Cell(28,6,utf8_decode('Nro. Doc.'),1,0,'C',1);
$pdf->Cell(30,6,utf8_decode('Fecha Emisión'),1,0,'C',1);
$pdf->Cell(30,6,utf8_decode('Fecha Entrega'),1,0,'C',1);
$pdf->Cell(24,6,utf8_decode('Tipo Moneda'),1,0,'C',1);
$pdf->Cell(30,6,utf8_decode('Subtotal'),1,0,'C',1);
$pdf->Cell(30,6,utf8_decode('IGV'),1,0,'C',1);
$pdf->Cell(30,6,utf8_decode('Total Neto'),1,0,'C',1);
$pdf->Cell(58,6,utf8_decode('Estado'),1,0,'C',1);
$pdf->Ln();

$pdf->SetFont('Arial','',9);

if ($rowsNumber > 0) {
    foreach ($sqlStatement as $row) {
		$pdf->Cell(16,6,utf8_decode($row['id']),1,0,'C');
		$pdf->Cell(28,6,utf8_decode($row['DOC_NUMBER']),1,0,'C');
		$pdf->Cell(30,6,utf8_decode(date("d-m-Y", strtotime($row["date"]))),1,0,'C');
		$pdf->Cell(30,6,utf8_decode(date("d-m-Y", strtotime($row["delivery_date"]))),1,0,'C');
		$pdf->Cell(24,6,utf8_decode($row['currency']),1,0,'C');
		$pdf->Cell(30,6,utf8_decode(number_format($row["total_sub"], 2, '.','')),1,0,'R');
		$pdf->Cell(30,6,utf8_decode(number_format($row["total_tax"], 2, '.','')),1,0,'R');
		$pdf->Cell(30,6,utf8_decode(number_format($row["total_net"], 2, '.','')),1,0,'R');
		$pdf->Cell(58,6,utf8_decode($row['STATUS']),1,0,'C');	
		$pdf->Ln();
	}
}else{
	$pdf->Cell(276,6,utf8_decode("No existen datos para el cliente especificado"),1,0,'C');
}


$pdf->Output("I", $reportTitle . ".pdf", true);