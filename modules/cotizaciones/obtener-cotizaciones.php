<?php
require '../../global/connection.php';
$COTZ_COD = $_GET["orden_cotizacion"];
$sqlStatement = $pdo->prepare("SELECT * FROM tbl_quotation WHERE number LIKE '%".$COTZ_COD."%' ORDER BY number ASC");
$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();
$DATA = array();
if ($rowsNumber > 0) {    
    while ($LST = $sqlStatement->fetch()) {
        $ID_COTIZ = $LST["id"];
        $NOM_COTIZ = $LST["number"];
        //$NOM_COTIZ = $LST["number"] . " | ". date("d-m-Y",strtotime($LST["registration_date"]));
        $ROW = [ "key" => $ID_COTIZ, "value" => $NOM_COTIZ ];
        array_push($DATA, $ROW);
    }
} else {
    $ROW = [  "key" => "", "value" => "Sin resultados" ];
    array_push($DATA, $ROW);
}
echo json_encode($DATA);
