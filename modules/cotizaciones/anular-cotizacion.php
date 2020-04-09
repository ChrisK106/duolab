<?php
require '../../global/connection.php';
$C_IDCOTIZ = $_POST['ID_COTIZ'];
$sqlStatement = $pdo->prepare("UPDATE tbl_quotation SET status='2' WHERE id=:IDCOTIZ");
$sqlStatement->bindParam("IDCOTIZ", $C_IDCOTIZ, PDO::PARAM_INT);
$ANULAR_FACTURA = $sqlStatement->execute();
if ($ANULAR_FACTURA) {
    echo true;
} else {
    echo false;
}
