<?php

require '../../global/connection.php';

$ID_PROV = "";
$COND_PROV = "";
$sqlquery_adic = "";
$ESTADO_PROD = $_POST["ESTADO"];
$REPORT = "";

if(isset($_POST["PROV_ID"])){
    $ID_PROV = $_POST["PROV_ID"];
    $COND_PROV = " WHERE provider_id=:PROVID ";
    if ($ESTADO_PROD != "ALL") {
        $sqlquery_adic = " AND active_status = $ESTADO_PROD ";
    }
} else {
    if ($ESTADO_PROD != "ALL") {
        $sqlquery_adic = " WHERE active_status = $ESTADO_PROD ";
    }
}

if(isset($_POST["REPORT"])){
    $REPORT = $_POST["REPORT"];
}

$sqlStatement = $pdo->prepare("SELECT tbl_product.id AS ID, tbl_product.name as NAME, tbl_product.code as CODE FROM tbl_product $COND_PROV $sqlquery_adic ORDER BY name ASC");

if(isset($_POST["PROV_ID"])){
    $sqlStatement->bindParam("PROVID", $ID_PROV, PDO::PARAM_INT);
}

$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();
$DATA = array();

if ($REPORT == ""){
    array_push($DATA, ["id" => "", "text" => "Seleccione un producto"]);
}else{
    array_push($DATA, ["id" => "0", "text" => "(Todos)"]);
}

if ($rowsNumber > 0) {
    
    while ($LST = $sqlStatement->fetch()) {
        $ID_PROD = $LST["ID"];
        $NOM_PROD = $LST["NAME"];
        $COD_PROD = $LST["CODE"];
        $ROW = [
            "id" => $ID_PROD,
            "text" => $NOM_PROD . " - " . $COD_PROD
        ];
        array_push($DATA, $ROW);
    }

} else {
    array_push($DATA, ["id" => "", "text" => "No se encontraron productos"]);    
}

echo json_encode($DATA);