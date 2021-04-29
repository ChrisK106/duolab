<?php
require '../../global/connection.php';
$ID_ORDEN = $_POST["IDORDEN"];

$sqlStatement = $pdo->prepare("SELECT item_code AS CODE, item_description AS DESCRIPTION, item_gloss AS GLOSS, item_unit_value AS UNIT_VALUE, item_unit_price AS UNIT_PRICE, item_quantity AS QUANTITY, item_discount_rate AS DISCOUNT_RATE, item_discounted_total AS DISCOUNTED_TOTAL
    FROM tbl_purchase_detail
    WHERE purchase_id =:ORDID");

$sqlStatement->bindParam("ORDID", $ID_ORDEN, PDO::PARAM_STR);
$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();
$json_data = array();

if ($rowsNumber > 0) {
    $CONT_R = 0;
    foreach ($sqlStatement as $ROW) {
        $CONT_R ++;
        $ROWDATA['ROW_ID'] = $CONT_R;
        $ROWDATA['CODE'] = $ROW["CODE"];
        $ROWDATA['DESCRIPTION'] = $ROW["DESCRIPTION"];
        $ROWDATA['GLOSS'] = $ROW["GLOSS"];
        $ROWDATA['UNIT_VALUE'] = $ROW["UNIT_VALUE"];
        $ROWDATA['UNIT_PRICE'] = $ROW["UNIT_PRICE"];
        $ROWDATA['QUANTITY'] = $ROW["QUANTITY"];
        $ROWDATA['DISCOUNT_RATE'] = $ROW["DISCOUNT_RATE"];
        $ROWDATA['DISCOUNTED_TOTAL'] = $ROW["DISCOUNTED_TOTAL"];
        array_push($json_data, $ROWDATA);
    }
}
//echo json_encode(array("data" => $json_data));
echo json_encode($json_data);