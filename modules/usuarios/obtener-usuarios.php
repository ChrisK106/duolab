<?php
require '../../global/connection.php';
$PARAM_VEND = $_GET["NOM_VEND"];
$sqlStatement = $pdo->prepare("SELECT CONCAT(te.name, ' ', te.last_name_1, ' ', te.last_name_2) AS NOM_VEND, tu.id AS ID_USER FROM tbl_user tu INNER JOIN tbl_employee te ON tu.employee_id=te.id WHERE te.name LIKE '%".$PARAM_VEND."%' OR te.last_name_1 LIKE '%".$PARAM_VEND."%' OR te.last_name_2 LIKE '%".$PARAM_VEND."%' ORDER BY te.name ASC");
$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();
$DATA = array();
if ($rowsNumber > 0) {    
    while ($LST = $sqlStatement->fetch()) {
        $ID_VEND = $LST["ID_USER"];
        $NOM_VEND = $LST["NOM_VEND"];
        $ROW = [ "id" => $ID_VEND, "value" => $NOM_VEND ];
        array_push($DATA, $ROW);
    }
} else {
    $ROW = [  "id" => "", "value" => "Sin resultados" ];
    array_push($DATA, $ROW);
}
echo json_encode($DATA);
