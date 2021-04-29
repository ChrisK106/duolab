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

$sqlStatement = $pdo->prepare("SELECT ord.type AS TIPOORDEN, ord.id AS IDORDEN, ord.number AS ORDNUMBER, ord.status AS ORDESTADO, ord.currency AS TIPOMON, ord.issue_date AS FECEMIS, ord.delivery_date AS FECDEL, ord.provider_id AS PROVID, prov.business_name AS NOMPROV, ord.payment_days AS PAYDAYS, ord.account_number AS ACCNUM, ord.quotation AS COTIZ, ord.requester AS REQUES, ord.approver AS APROV, ord.observation AS OBSERV, ord.total_purchase AS TOTCOMP, ord.total_tax AS TOTIGV, ord.total_net AS TOTNET, ord.exchange_rate_sale AS EXCVENTA, ord.exchange_rate_purchase AS EXCCOMP FROM tbl_order ord INNER JOIN tbl_provider prov ON ord.provider_id=prov.id $COND_COMP ORDER BY ord.number ASC");
$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();
$json_data = array();
if ($rowsNumber > 0) { 
    foreach ($sqlStatement as $ROW) {
        $ROWDATA['TIPOORDEN'] = $ROW["TIPOORDEN"];
        $ROWDATA['IDORDEN'] = $ROW["IDORDEN"];
        $ROWDATA['ORDNUMBER'] = $ROW["ORDNUMBER"];
        $ROWDATA['ORDESTADO'] = $ROW["ORDESTADO"];
        $ROWDATA['TIPOMON'] = $ROW["TIPOMON"];
        $ROWDATA['FECEMIS'] = date("d-m-Y", strtotime($ROW["FECEMIS"]));
        $ROWDATA['FECDEL'] = date("d-m-Y", strtotime($ROW["FECDEL"]));
        $ROWDATA['PROVID'] = $ROW["PROVID"];
        $ROWDATA['NOMPROV'] = $ROW["NOMPROV"];
        $ROWDATA['PAYDAYS'] = $ROW["PAYDAYS"];
        $ROWDATA['ACCNUM'] = $ROW["ACCNUM"];
        $ROWDATA['COTIZ'] = $ROW["COTIZ"];
        $ROWDATA['REQUES'] = $ROW["REQUES"];
        $ROWDATA['APROV'] = $ROW["APROV"];
        $ROWDATA['OBSERV'] = $ROW["OBSERV"];
        $ROWDATA['TOTCOMP'] = $ROW["TOTCOMP"];
        $ROWDATA['TOTIGV'] = $ROW["TOTIGV"];
        $ROWDATA['PORCIGV'] = ($ROW["TOTIGV"] / $ROW["TOTCOMP"]);
        $ROWDATA['TOTNET'] = number_format($ROW["TOTNET"], 2, '.','');
        $ROWDATA['EXCVENTA'] = $ROW["EXCVENTA"];
        $ROWDATA['EXCCOMP'] = $ROW["EXCCOMP"];
        array_push($json_data, $ROWDATA);
    }
}
echo json_encode($json_data);
