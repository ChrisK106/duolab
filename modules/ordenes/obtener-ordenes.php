<?php
require '../../global/connection.php';
$ORD_COD = $_GET["ORDEN_NRO"];
$sqlStatement = $pdo->prepare("SELECT * FROM tbl_order WHERE number LIKE '%".$ORD_COD."%' ORDER BY number ASC");
$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();
$DATA = array();
if ($rowsNumber > 0) {    
    while ($LST = $sqlStatement->fetch()) {
        $ID_ORDEN = $LST["id"];
        //$NUM_ORDEN = $LST["number"] . " | ". date("d-m-Y",strtotime($LST["issue_date"]));
        $NUM_ORDEN = $LST["number"];
        $ROW = [ "key" => $ID_ORDEN, "value" => $NUM_ORDEN ];
        array_push($DATA, $ROW);
    }
} else {
    $ROW = [  "key" => "", "value" => "Sin resultados" ];
    array_push($DATA, $ROW);
}
echo json_encode($DATA);
