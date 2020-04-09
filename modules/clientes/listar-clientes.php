<?php
require '../../global/connection.php';
$sqlStatement = $pdo->prepare("SELECT * FROM tbl_customer ORDER BY business_name ASC");
$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();
$DATA = array();
array_push($DATA, ["id"=>"","text"=>"Seleccione un cliente"]);
if ($rowsNumber > 0) {    
    while ($LST = $sqlStatement->fetch()) {
        $ID_CLI = $LST["client_id"];
        $NOM_CLI = $LST["business_name"];
        $ROW = [
            "id" => $ID_CLI,
            "text" => $NOM_CLI
        ];
        array_push($DATA, $ROW);
    }
}
echo json_encode($DATA);
