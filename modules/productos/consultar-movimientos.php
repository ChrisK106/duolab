<?php
require '../../global/connection.php';

$sqlStatement = $pdo->prepare("SELECT t.id AS ID, "
    . "t.type AS TIPO, t.quantity AS CANTIDAD, t.observation AS OBSERVACION, t.doc_reference as DOC_REFERENCIA, "
    . "t.expiration_date AS FECVENC, t.registration_date AS FECREG, "
    . "tp.code AS CODIGO_PRODUCTO, tp.name AS NOMBRE_PRODUCTO, tpr.business_name AS NOMBRE_PROVEEDOR, tu.username AS NOMBRE_USUARIO "
    . "FROM tbl_warehouse_movement t "
    . "JOIN tbl_product tp on tp.id=t.product_id "
    . "LEFT JOIN tbl_provider tpr on tpr.id=t.provider_id "
    . "JOIN tbl_user tu on tu.id=t.user_id "
    . "ORDER BY t.id DESC");

$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();
$json_data = array();

if ($rowsNumber > 0) {        
    foreach ($sqlStatement as $ROW) {
        $ROWDATA['ID'] = $ROW["ID"];

        if ($ROW["TIPO"] == 1){
            $ROWDATA['TIPO'] = "Ingreso Almacén";
        }else if($ROW["TIPO"] == 2){
            $ROWDATA['TIPO'] = "Ajuste Stock";
        }
        
        $ROWDATA['CANTIDAD'] = $ROW["CANTIDAD"];
        $ROWDATA['FECREG'] = date("d/m/Y H:i",strtotime($ROW["FECREG"]));
        $ROWDATA['NOMBRE_USUARIO'] = $ROW["NOMBRE_USUARIO"];

        $ROWDATA['CODIGO_PRODUCTO'] = $ROW["CODIGO_PRODUCTO"];
        $ROWDATA['NOMBRE_PRODUCTO'] = $ROW["NOMBRE_PRODUCTO"];
 
        $ROWDATA['DOC_REFERENCIA'] = $ROW["DOC_REFERENCIA"];
        $ROWDATA['FECVENC'] = date("d/m/Y",strtotime($ROW["FECVENC"]));
        $ROWDATA['NOMBRE_PROVEEDOR'] = $ROW["NOMBRE_PROVEEDOR"];

        if ($ROW["OBSERVACION"] == ""){
            $ROWDATA['OBSERVACION'] = "-";
        }else{
            $ROWDATA['OBSERVACION'] = $ROW["OBSERVACION"];
        }

        if ($ROW["DOC_REFERENCIA"] == ""){
            $ROWDATA['DOC_REFERENCIA'] = "-";
        }else{
            $ROWDATA['DOC_REFERENCIA'] = $ROW["DOC_REFERENCIA"];
        }

        if ($ROW["FECVENC"] == ""){
            $ROWDATA['FECVENC'] = "-";
        }else{
            $ROWDATA['FECVENC'] = date("d/m/Y",strtotime($ROW["FECVENC"]));
        }

        if ($ROW["NOMBRE_PROVEEDOR"] == ""){
            $ROWDATA['NOMBRE_PROVEEDOR'] = "-";
        }else{
            $ROWDATA['NOMBRE_PROVEEDOR'] = $ROW["NOMBRE_PROVEEDOR"];
        }
        
        array_push($json_data, $ROWDATA);
    }        
}
echo json_encode(array("data" => $json_data));
