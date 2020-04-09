<?php
require '../../global/connection.php';
$order_id = $_POST['ID_ORDER'];
$sqlStatement = $pdo->prepare("DELETE FROM tbl_order_detail WHERE order_id=:IDORDER");
$sqlStatement->bindParam("IDORDER", $order_id, PDO::PARAM_INT);
$DELETE_DETALLE = $sqlStatement->execute();
if ($DELETE_DETALLE) {
    $sqlStatement = $pdo->prepare("DELETE FROM tbl_order WHERE id=:IDORDER");
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
