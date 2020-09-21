<?php
require '../../global/connection.php';
$c_idfactura = $_POST['ID_FACTURA'];
$sqlStatement = $pdo->prepare("UPDATE tbl_receipt SET status='2' WHERE id=:IDFACTURA");
$sqlStatement->bindParam("IDFACTURA", $c_idfactura, PDO::PARAM_INT);
$ANULAR_FACTURA = $sqlStatement->execute();
if ($ANULAR_FACTURA) {
    echo true;
} else {
    echo false;
}
