<?php
require '../../global/connection.php';
$c_idprov = $_POST['proveedor_id'];
$sqlStatement = $pdo->prepare("DELETE FROM tbl_provider WHERE id=:PROVID");
$sqlStatement->bindParam("PROVID", $c_idprov, PDO::PARAM_INT);
if ($sqlStatement) {
    $sqlStatement->execute();
    echo true;
} else {
    echo false;
}