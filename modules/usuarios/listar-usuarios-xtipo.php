<?php
session_start();
require '../../global/connection.php';

$LST_ARRAY = array();
$DATA = array();
$USER_ID = $_SESSION['loggedInUser']['USERID'];
$USER_JOB = $_SESSION['loggedInUser']['JOB'];

/*
if ($JOB_NAME == "Secretario" || $JOB_NAME == "Secretaria") {
    array_push($LST_ARRAY, "LIST_VENDEDORES");
} else if ($JOB_NAME == "Vendedor" || $JOB_NAME == "Vendedora") {
    array_push($LST_ARRAY, $c_user_id);
}

$sqlStatement = $pdo->prepare("SELECT tu.id AS IDUSER, tu.username AS USERNAME FROM tbl_user tu INNER JOIN tbl_employee te ON tu.employee_id=te.id
WHERE te.job='Vendedor' OR te.job='Vendedora'
ORDER BY tu.username ASC");
*/

$sqlStatement = $pdo->prepare("SELECT u.id aS USERID, u.username AS USERNAME,
    CONCAT(e.name, ' ', e.last_name_1) AS EMPLOYEE_NAME
    FROM tbl_user u JOIN tbl_employee e ON u.employee_id=e.id
    ORDER BY EMPLOYEE_NAME ASC");

$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();

//array_push($DATA, ["id" => "", "text" => "Seleccione un vendedor"]);

if ($rowsNumber > 0) {
    while ($LST = $sqlStatement->fetch()) {
        $ID_USER = $LST["USERID"];
        $NOM_USU = $LST["EMPLOYEE_NAME"] . " (@" . $LST["USERNAME"] . ")"; 
        $ROW = [
            "id" => $ID_USER,
            "text" => $NOM_USU
        ];
        array_push($DATA, $ROW);
    }
}

array_push($LST_ARRAY, $DATA);
array_push($LST_ARRAY, $USER_ID);
array_push($LST_ARRAY, $USER_JOB);

echo json_encode($LST_ARRAY);