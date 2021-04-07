<?php
require '../../global/connection.php';

$FAC_COD = $_GET["factura_num"];
$sqlStatement = $pdo->prepare("SELECT * FROM tbl_credit_note WHERE number LIKE '%".$FAC_COD."%' ORDER BY number ASC");
$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();
$DATA = array();
if ($rowsNumber > 0) {    
    while ($LST = $sqlStatement->fetch()) {
        $ID_FAC = $LST["id"];
        $NUM_FAC = $LST["number"];
        $ROW = [ "key" => $ID_FAC, "value" => $NUM_FAC ];
        array_push($DATA, $ROW);
    }
} else {
    $ROW = [  "key" => "", "value" => "Sin resultados" ];
    array_push($DATA, $ROW);
}
echo json_encode($DATA);
