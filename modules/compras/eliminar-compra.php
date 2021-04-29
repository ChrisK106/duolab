<?php
require '../../global/connection.php';

$order_id = $_POST['ID_ORDER'];

$sqlStatement = $pdo->prepare("DELETE FROM tbl_purchase_detail WHERE purchase_id=:IDORDER");
$sqlStatement->bindParam("IDORDER", $order_id, PDO::PARAM_INT);
$DELETE_DETALLE = $sqlStatement->execute();

if ($DELETE_DETALLE) {
    $sqlStatement = $pdo->prepare("DELETE FROM tbl_purchase WHERE id=:IDORDER");
    $sqlStatement->bindParam("IDORDER", $order_id, PDO::PARAM_INT);
    $DELETE_ORDEN = $sqlStatement->execute();
    if ($DELETE_ORDEN) {
        echo true;
    } else {
        echo false;
    }
} else {
    echo false;
}
