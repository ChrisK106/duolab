<?php

include 'template.php';
require '../../global/connection.php';

if (!isset($_GET['mode'])){
	echo "Error al obtener reporte. Variable 'mode' no especificada.";
	return;
}

$mode = $_GET['mode'];
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

$sqlString="SELECT id, code, brand, name, description, STATUS, SUM(QUANTITY) AS TOTAL FROM(
(SELECT p.id, p.code, p.brand, p.name, p.description,
(CASE
 WHEN p.active_status=1 THEN 'Activo'
 WHEN p.active_status=0 THEN 'Inactivo'
END) AS STATUS,
SUM(item_quantity) AS QUANTITY
FROM tbl_invoice_detail td
JOIN tbl_invoice th ON th.id=td.invoice_id
JOIN tbl_product p ON td.item_id=p.id
WHERE th.status NOT IN (2)
GROUP BY p.id)
UNION
(SELECT p.id, p.code, p.brand, p.name, p.description,
(CASE
 WHEN p.active_status=1 THEN 'Activo'
 WHEN p.active_status=0 THEN 'Inactivo'
END) AS STATUS,
SUM(item_quantity) AS QUANTITY
FROM tbl_receipt_detail td
JOIN tbl_receipt th ON th.id=td.receipt_id
JOIN tbl_product p ON td.item_id=p.id
WHERE th.status NOT IN (2)
GROUP BY p.id)) AS T
GROUP BY id, code, brand, name, description, STATUS
ORDER BY TOTAL " . $orderString . " LIMIT 20";

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

$pdf->Cell(8,6,utf8_decode('N°'),1,0,'C',1);
$pdf->Cell(30,6,utf8_decode('Código'),1,0,'C',1);
$pdf->Cell(40,6,utf8_decode('Marca'),1,0,'C',1);
$pdf->Cell(164,6,utf8_decode('Nombre'),1,0,'C',1);
$pdf->Cell(15,6,utf8_decode('Estado'),1,0,'C',1);
$pdf->Cell(20,6,utf8_decode('UNIDADES'),1,0,'C',1);
$pdf->Ln();

$pdf->SetFont('Arial','',9);

$rowNumber=1;

if ($rowsNumber > 0) {
    foreach ($sqlStatement as $row) {
    	$pdf->Cell(8,6,utf8_decode($rowNumber),1,0,'C',1);
		$pdf->Cell(30,6,utf8_decode($row['code']),1,0,'C');
		$pdf->Cell(40,6,utf8_decode($row['brand']),1,0,'C');
		$pdf->Cell(164,6,utf8_decode($row['name']),1,0,'L');
		$pdf->Cell(15,6,utf8_decode($row['STATUS']),1,0,'C');
		$pdf->Cell(20,6,utf8_decode($row['TOTAL']),1,0,'C');
		$pdf->Ln();
		$rowNumber++;
	}
}

$pdf->Output("I", $reportTitle . ".pdf", true);