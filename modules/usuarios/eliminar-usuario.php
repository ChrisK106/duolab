<?php
require '../../global/connection.php';
$u_iduser = $_POST['user_id'];
$sqlStatement = $pdo->prepare("DELETE FROM tbl_user WHERE id=:USERID");
$sqlStatement->bindParam("USERID", $u_iduser, PDO::PARAM_INT);
if ($sqlStatement) {
    $sqlStatement->execute();
    echo true;
} else {
    echo false;
}