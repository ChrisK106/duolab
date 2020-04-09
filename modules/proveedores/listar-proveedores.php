<?php
require '../../global/connection.php';
$sqlStatement = $pdo->prepare("SELECT * FROM tbl_provider ORDER BY business_name ASC");
$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();
$DATA = array();
if ($rowsNumber > 0) {
    array_push($DATA, ["id"=>"","text"=>"Seleccione proveedor"]);
    while ($LST = $sqlStatement->fetch()) {
        $ID_PROV = $LST["id"];
        $NOM_PROV = $LST["business_name"];
        $ROW = [
            "id" => $ID_PROV,
            "text" => $NOM_PROV
        ];
        array_push($DATA, $ROW);
    }
}
echo json_encode($DATA);
