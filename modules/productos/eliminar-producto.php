<?php
require '../../global/connection.php';
$p_idprod = $_POST['producto_id'];
$sqlStatement = $pdo->prepare("DELETE FROM tbl_product WHERE id=:PRODID");
$sqlStatement->bindParam("PRODID", $p_idprod, PDO::PARAM_INT);
if ($sqlStatement) {
    $sqlStatement->execute();
    echo true;
} else {
    echo false;
}