<?php
require '../../global/connection.php';
$ID_COTIZ = $_POST["IDCOTIZ"];
$sqlStatement = $pdo->prepare("SELECT * FROM tbl_quotation_detail tqd INNER JOIN tbl_product tp ON tqd.item_id=tp.id  WHERE tqd.quotation_id =:COTIZID");
$sqlStatement->bindParam("COTIZID", $ID_COTIZ, PDO::PARAM_STR);
$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();
$json_data = array();
if ($rowsNumber > 0) {
    foreach ($sqlStatement as $ROW) {
        $ROWDATA['IDPROD'] = $ROW["item_id"];
        $ROWDATA["CODPROD"] = $ROW["code"];
        $ROWDATA['STOCKPROD'] = $ROW["stock_quantity"];
        $ROWDATA['NOMBRE'] = $ROW["item_name"];
        $ROWDATA['DESCRIP'] = $ROW["item_description"];
        $ROWDATA['PRECIOUNIT'] = $ROW["item_unit_price"];
        $ROWDATA['CANTIDAD'] = $ROW["item_quantity"];
        $ROWDATA['IMPORTE'] = $ROW["item_quantity"] * $ROW["item_unit_price"];
        array_push($json_data, $ROWDATA);
    }
}
//echo json_encode(array("data" => $json_data));
echo json_encode($json_data);
