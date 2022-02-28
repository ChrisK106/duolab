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

$reportTitle = "Unidades Vendidas por Cliente";
$rptDateInterval = "UNIDADES VENDIDAS (Sin rango de fecha)";

$productString = "";
$dateString = "";
$productData = "";

if ($productId!= 0 && $productId!= ""){
	$reportTitle = "Unidades de Producto Vendidas por Cliente";
	$productString = " AND td.item_id = " . $productId;

	$sqlProductInfo = "SELECT p.id, p.code, p.brand, p.name, p.description,
		(CASE
			WHEN p.active_status = 1 THEN 'ACTIVO'
		 	WHEN p.active_status = 0 THEN 'INACTIVO'
		END) AS status
		FROM tbl_product p
		WHERE p.id = " . $productId;

	$sqlStatement = $pdo->prepare($sqlProductInfo);
	$sqlStatement->execute();
	$productData = $sqlStatement->fetch();

	if ($productData == null){
		echo "Error al obtener reporte. Variable 'productid' no es válida. No existe el producto solicitado.";
		return;
	}
}

if ($dateFrom!= "" && $dateTo!= ""){
	$dateString = " AND (th.date BETWEEN '" . $dateFrom . "' AND '". $dateTo . "')";
	$rptDateInterval = "UNIDADES VENDIDAS DEL " . date("d/m/Y", strtotime($dateFrom)) . " AL " . date("d/m/Y", strtotime($dateTo));
}

$sqlString = "SELECT ruc, name, SUM(SOLD_UNITS) AS SOLD_UNITS FROM 
((SELECT th.ruc, th.name, SUM(td.item_quantity) AS SOLD_UNITS
FROM tbl_invoice_detail td
JOIN tbl_invoice th on th.id=td.invoice_id
WHERE th.status NOT IN (2) " . $productString . $dateString .
" GROUP BY 1
ORDER BY SOLD_UNITS)
UNION
(SELECT th.ruc, th.name, SUM(td.item_quantity) AS SOLD_UNITS
FROM tbl_receipt_detail td
JOIN tbl_receipt th on th.id=td.receipt_id
WHERE th.status NOT IN (2) " . $productString . $dateString .
" GROUP BY 1
ORDER BY SOLD_UNITS)
UNION
(SELECT th.ruc, th.name, SUM(td.item_quantity*-1) AS SOLD_UNITS
FROM tbl_credit_note_detail td
JOIN tbl_credit_note th on th.id=td.credit_note_id
WHERE th.status NOT IN (2) " . $productString . $dateString .
" GROUP BY 1
ORDER BY SOLD_UNITS)) AS RPT
GROUP BY 1
ORDER BY 2 ASC";

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

if ($productId!= 0 && $productId!= ""){
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(0,6,utf8_decode('DATOS DEL PRODUCTO'),1,0,'L',1);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(20,6,utf8_decode('ID'),1,0,'R',1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(20,6,utf8_decode($productData['id']),1,0,'L',0);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(24,6,utf8_decode('Código'),1,0,'R',1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(50,6,utf8_decode($productData['code']),1,0,'L',0);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(24,6,utf8_decode('Marca'),1,0,'R',1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(90,6,utf8_decode($productData['brand']),1,0,'L',0);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(19,6,utf8_decode('Estado'),1,0,'R',1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(0,6,utf8_decode($productData['status']),1,0,'L',0);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(20,6,utf8_decode('Nombre'),1,0,'R',1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(0,6,utf8_decode($productData['name']),1,0,'L',0);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(20,6,utf8_decode('Descripción'),1,0,'R',1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(0,6,utf8_decode($productData['description']),1,0,'L',0);
	$pdf->Ln(10);
}

$pdf->SetFont('Arial','B',9);
$pdf->Cell(0,6,utf8_decode($rptDateInterval),1,0,'C',1);
$pdf->Ln();
$pdf->Cell(24,6,utf8_decode('RUC'),1,0,'C',1);
$pdf->Cell(223,6,utf8_decode('Nombre'),1,0,'L',1);
$pdf->Cell(30,6,utf8_decode('UNIDADES'),1,0,'C',1);
$pdf->Ln();

$pdf->SetFont('Arial','',9);

if ($rowsNumber > 0) {

	$totalSoldUnits = 0;

    foreach ($sqlStatement as $row) {
		$pdf->Cell(24,6,utf8_decode($row['ruc']),1,0,'C');
		$pdf->Cell(223,6,utf8_decode($row['name']),1,0,'L');

		$soldUnits = $row['SOLD_UNITS'];
		$pdf->Cell(30,6,utf8_decode($soldUnits),1,0,'C');
		$pdf->Ln();

		$totalSoldUnits += $soldUnits;
	}
	
	$pdf->Cell(197);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(50,6,utf8_decode("TOTAL UNIDADES VENDIDAS"),1,0,'C',1);
	$pdf->Cell(0,6,utf8_decode($totalSoldUnits),1,0,'C');

}else{
	$pdf->Cell(0,6,utf8_decode("No existen datos para el producto especificado"),1,0,'C');
}


$pdf->Output("I", $reportTitle . ".pdf", true);