<?php
require '../../global/connection.php';
$NOMPROD = $_GET["orden_nomprod"];
$QUERY_XPROV = "";
if(isset($_GET["prov_id"])){
    $PROVID = $_GET["prov_id"];
    if($PROVID != ""){
        $QUERY_XPROV = " AND provider_id=".$PROVID;
    }
}
$sqlStatement = $pdo->prepare("SELECT * FROM tbl_product WHERE name LIKE '%".$NOMPROD."%' $QUERY_XPROV ORDER BY name ASC");
$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();
$DATA = array();
if ($rowsNumber > 0) {    
    while ($LST = $sqlStatement->fetch()) {
        $ID_PROD = $LST["id"];
        $NOM_PROD = $LST["name"];
        $ROW = [ "id" => $ID_PROD, "value" => $NOM_PROD ];
        array_push($DATA, $ROW);
    }
} else {
    $ROW = [  "id" => "", "value" => "Sin resultados" ];
    array_push($DATA, $ROW);
}
echo json_encode($DATA);
