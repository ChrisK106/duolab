<?php
require '../../global/connection.php';
$NOMPROV = $_GET["NOM_PROV"];
$sqlStatement = $pdo->prepare("SELECT * FROM tbl_provider WHERE business_name LIKE '%".$NOMPROV."%' ORDER BY business_name ASC");
$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();
$DATA = array();
if ($rowsNumber > 0) {    
    while ($LST = $sqlStatement->fetch()) {
        $ID_PROV = $LST["id"];
        $NOM_PROV = $LST["business_name"];
        $ROW = [ "id" => $ID_PROV, "value" => $NOM_PROV ];
        array_push($DATA, $ROW);
    }
} else {
    $ROW = [  "id" => "", "value" => "Sin resultados" ];
    array_push($DATA, $ROW);
}
echo json_encode($DATA);
