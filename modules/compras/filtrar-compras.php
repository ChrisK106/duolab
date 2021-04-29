<?php
require '../../global/connection.php';

$ORDEN_NRO = $_POST["orden_nroo"];
$ORDEN_PROV = $_POST["orden_prov"];
$ORDEN_FINI = "";
$ORDEN_FFIN = "";

if($_POST["orden_fini"] != ""){
    $ORDEN_FINI = date("Y-m-d", strtotime($_POST["orden_fini"]));
}
if($_POST["orden_ffin"] != ""){
    $ORDEN_FFIN = date("Y-m-d", strtotime($_POST["orden_ffin"]));
}

$QUERY_ORDNRO = "";
$QUERY_ORDPROV = "";
$QUERY_ORDFRANGO = "";

$WHERE_SET = false;
if($ORDEN_NRO != ""){
    $QUERY_ORDNRO = " WHERE ord.number LIKE '%".$ORDEN_NRO."%' ";
    $WHERE_SET = true;
}
if($ORDEN_PROV != ""){
    if($WHERE_SET == false){
        $QUERY_ORDPROV = " WHERE prov.business_name LIKE '%".$ORDEN_PROV."%' ";
        $WHERE_SET = true;
    } else {
        $QUERY_ORDPROV = " AND prov.business_name LIKE '%".$ORDEN_PROV."%' ";
    }
}
if($ORDEN_FINI != "" && $ORDEN_FFIN != ""){
    if($WHERE_SET == false){
        $QUERY_ORDFRANGO = " WHERE ord.issue_date BETWEEN '".$ORDEN_FINI."' AND '".$ORDEN_FFIN."' ";
        $WHERE_SET = true;
    } else {
        $QUERY_ORDFRANGO = " AND ord.issue_date BETWEEN '".$ORDEN_FINI."' AND '".$ORDEN_FFIN."' ";
    }
}

$COND_COMP = $QUERY_ORDNRO.$QUERY_ORDPROV.$QUERY_ORDFRANGO;

$sqlStatement = $pdo->prepare("SELECT ord.id AS P_ID, ord.type AS P_TYPE, ord.number AS P_NUMBER, ord.status AS P_STATUS, ord.currency AS P_CURRENCY, ord.issue_date AS P_DATE, ord.provider_id AS PROV_ID, prov.business_name AS PROV_NAME, ord.requester AS P_REQUESTER, ord.approver AS P_APPROVER, ord.observation AS P_OBS, ord.total_net AS P_TOTAL FROM tbl_purchase ord INNER JOIN tbl_provider prov ON ord.provider_id=prov.id $COND_COMP ORDER BY ord.number ASC");

$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();
$json_data = array();

if ($rowsNumber > 0) { 
    foreach ($sqlStatement as $ROW) {
        
        $ROWDATA['ID'] = $ROW["P_ID"];
        $ROWDATA['NUMBER'] = $ROW["P_NUMBER"];
        $ROWDATA['DATE'] = date("d/m/Y", strtotime($ROW["P_DATE"]));
        $ROWDATA['PROV_NAME'] = $ROW["PROV_NAME"];
        $ROWDATA['CURRENCY'] = $ROW["P_CURRENCY"];
        $ROWDATA['TOTAL'] = number_format($ROW["P_TOTAL"], 2, '.','');
        $ROWDATA['STATUS'] = $ROW["P_STATUS"];
        
        array_push($json_data, $ROWDATA);
    }
}

echo json_encode($json_data);