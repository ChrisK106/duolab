<?php
require '../../global/connection.php';

$tipoDoc = $_POST['TIPO_DOC'];
$idDoc = $_POST['ID_DOC'];
$estadoDoc = $_POST['ESTADO_DOC'];
$sqlStatement = "";

if($tipoDoc == "INVOICE"){
	$sqlStatement = $pdo->prepare("UPDATE tbl_invoice SET status=:STATUS WHERE id=:ID");
} else if ($tipoDoc == "RECEIPT"){
	$sqlStatement = $pdo->prepare("UPDATE tbl_receipt SET status=:STATUS WHERE id=:ID");
} else if ($tipoDoc == "CREDIT_NOTE"){
	$sqlStatement = $pdo->prepare("UPDATE tbl_credit_note SET status=:STATUS WHERE id=:ID");
} else{
	echo false;
	return;
}

$sqlStatement->bindParam(":ID", $idDoc, PDO::PARAM_INT);
$sqlStatement->bindParam(":STATUS", $estadoDoc, PDO::PARAM_INT);

$result = $sqlStatement->execute();
echo $result;