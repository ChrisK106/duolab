<?php
require '../../global/connection.php';
$c_idemp = $_POST['empleado_id'];
$sqlStatement = $pdo->prepare("DELETE FROM tbl_employee WHERE id=:EMPID");
$sqlStatement->bindParam("EMPID", $c_idemp, PDO::PARAM_INT);
if ($sqlStatement) {
    $sqlStatement->execute();
    echo true;
} else {
    echo false;
}