<?php
require '../../global/connection.php';

$ID_ORDEN = $_POST['ID_ORDEN'];

$sqlStatement = $pdo->prepare("UPDATE tbl_purchase SET status='Anulado' WHERE id=:IDORDEN");
$sqlStatement->bindParam("IDORDEN", $ID_ORDEN, PDO::PARAM_INT);
$ANULAR_ORDEN = $sqlStatement->execute();

if ($ANULAR_ORDEN) {
    echo true;
} else {
    echo false;
}
