<?php
require '../../global/connection.php';
$ID_PROV = "";
$COND_PROV = "";
$sqlquery_adic = "";
$ESTADO_PROD = $_POST["ESTADO"];
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
$sqlStatement = $pdo->prepare("SELECT * FROM tbl_product $COND_PROV $sqlquery_adic ORDER BY name ASC");
if(isset($_POST["PROV_ID"])){
    $sqlStatement->bindParam("PROVID", $ID_PROV, PDO::PARAM_INT);
}
$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();
$DATA = array();
if ($rowsNumber > 0) {
    array_push($DATA, ["id" => "", "text" => "Seleccione un producto"]);
    while ($LST = $sqlStatement->fetch()) {
        $ID_PROD = $LST["id"];
        $NOM_PROD = $LST["name"];
        $COD_PROD = $LST["code"];
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
