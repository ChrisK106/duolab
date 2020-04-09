<?php
require '../../global/connection.php';
$c_idcotiz = $_POST['ID_COTIZ'];

$sqlStatement = $pdo->prepare("DELETE FROM tbl_quotation_detail WHERE quotation_id=:IDCOTIZ");
$sqlStatement->bindParam("IDCOTIZ", $c_idcotiz, PDO::PARAM_INT);
$DELETE_DETALLE = $sqlStatement->execute();
if ($DELETE_DETALLE) {
    $sqlStatement = $pdo->prepare("DELETE FROM tbl_quotation WHERE id=:IDCOTIZ");
    $sqlStatement->bindParam("IDCOTIZ", $c_idcotiz, PDO::PARAM_INT);
    $DELETE_COTIZ = $sqlStatement->execute();
    if ($DELETE_COTIZ) {
        echo true;
    } else {
        echo false;
    }
} else {
    echo false;
}
