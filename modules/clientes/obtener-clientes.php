<?php
require '../../global/connection.php';
$NOM_CLI = $_GET["cotiz_nomcliente"];
$sqlStatement = $pdo->prepare("SELECT * FROM tbl_customer WHERE business_name LIKE '%".$NOM_CLI."%' ORDER BY business_name ASC");
$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();
$DATA = array();
if ($rowsNumber > 0) {    
    while ($LST = $sqlStatement->fetch()) {
        $ID_CLI = $LST["client_id"];
        $NOM_CLI = $LST["business_name"];
        $ROW = [ "id" => $ID_CLI, "value" => $NOM_CLI ];
        array_push($DATA, $ROW);
    }
} else {
    $ROW = [  "id" => "", "value" => "Sin resultados" ];
    array_push($DATA, $ROW);
}
echo json_encode($DATA);
