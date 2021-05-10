<?php

require '../../global/connection.php';

$sqlStatement = $pdo->prepare("(SELECT DISTINCT th.ruc, th.name
FROM tbl_invoice th
GROUP BY th.ruc)
UNION
(SELECT DISTINCT th.ruc, th.name
FROM tbl_receipt th
GROUP BY th.ruc)
ORDER BY name");

$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();
$DATA = array();

array_push($DATA, ["id"=>"","text"=>"Seleccione un cliente"]);

if ($rowsNumber > 0) {
    
    while ($LST = $sqlStatement->fetch()) {
        $CUSTOMER_ID = $LST["ruc"];
        $CUSTOMER_NAME = $LST["name"];
        $ROW = [
            "id" => $CUSTOMER_ID,
            "text" => $CUSTOMER_NAME . " - " . $CUSTOMER_ID
        ];
        array_push($DATA, $ROW);
    }

} else {
    array_push($DATA, ["id" => "", "text" => "No se encontraron clientes"]);    
}

echo json_encode($DATA);