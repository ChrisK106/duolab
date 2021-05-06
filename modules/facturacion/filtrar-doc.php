<?php
require '../../global/connection.php';

$tipoDoc = $_POST['TIPO_DOC'];

$defaultLoad = $_POST['defaultLoad'];

$FACT_NRO = $_POST["fact_nroo"];
$FACT_CLIENT = $_POST["fact_client"];
$docStatus = $_POST["fact_estado"];
//$docVendedor = $_POST["fact_vendedor"];

$FACT_FINI = "";
$FACT_FFIN = "";

if ($_POST["fact_fini"] != "") {
    $FACT_FINI = date("Y-m-d", strtotime($_POST["fact_fini"]));
}
if ($_POST["fact_ffin"] != "") {
    $FACT_FFIN = date("Y-m-d", strtotime($_POST["fact_ffin"]));
}

$QUERY_FACTNRO = "";
$QUERY_FACTCLI = "";
$QUERY_FACTRANGO = "";
$QUERY_STATUS = "";
$WHERE_SET = false;

if ($FACT_NRO != "") {
    $QUERY_FACTNRO = " WHERE (ti.series LIKE '%" . $FACT_NRO . "%' OR ti.number LIKE '%" . $FACT_NRO . "%') ";
    $WHERE_SET = true;
}

if ($FACT_CLIENT != "") {
    if ($WHERE_SET == false) {
        $QUERY_FACTCLI = " WHERE ti.name LIKE '%" . $FACT_CLIENT . "%' ";
        $WHERE_SET = true;
    } else {
        $QUERY_FACTCLI = " AND ti.name LIKE '%" . $FACT_CLIENT . "%' ";
    }
}

if ($FACT_FINI != "" && $FACT_FFIN != "") {
    if ($WHERE_SET == false) {
        $QUERY_FACTRANGO = " WHERE ti.date BETWEEN '" . $FACT_FINI . "' AND '" . $FACT_FFIN . "' ";
        $WHERE_SET = true;
    } else {
        $QUERY_FACTRANGO = " AND ti.date BETWEEN '" . $FACT_FINI . "' AND '" . $FACT_FFIN . "' ";
    }
}

if ($docStatus != "") {
    if ($WHERE_SET == false) {
        $QUERY_STATUS = " WHERE ti.status = " . $docStatus . " ";
        $WHERE_SET = true;
    } else {
        $QUERY_STATUS = " AND ti.status = " . $docStatus . " ";
    }
}

$COND_COMP = $QUERY_FACTNRO . $QUERY_FACTCLI . $QUERY_FACTRANGO . $QUERY_STATUS;

$table = "";

if ($tipoDoc == "INVOICE"){
    $table = "tbl_invoice";
}else if($tipoDoc == "RECEIPT"){
    $table = "tbl_receipt";
}else if($tipoDoc == "CREDIT_NOTE"){
    $table = "tbl_credit_note";
}else{
    echo false;
    return;
}

$limitString = "";

if ($defaultLoad == 1){
    $limitString = "LIMIT 50";
}

$sqlStatement = $pdo->prepare("SELECT ti.id AS DOC_ID, ti.series AS DOC_SERIES, ti.number AS DOC_NUMBER, ti.status AS DOC_STATUS_ID, ti.customer_id AS CUSTOMER_ID, ti.name AS CUSTOMER_NAME, ti.date AS DOC_DATE, ti.total_net AS DOC_TOTAL_NET, ti.seller_id AS SELLER_ID, (SELECT CONCAT(e.last_name_1, ' ', e.last_name_2, ', ', e.name) FROM tbl_user u JOIN tbl_employee e ON u.employee_id = e.id WHERE u.id = ti.seller_id) AS SELLER_NAME FROM " . $table . " ti " . $COND_COMP . " ORDER BY ti.id DESC " . $limitString);

$sqlStatement->execute();

$rowsNumber = $sqlStatement->rowCount();
$json_data = array();

if ($rowsNumber > 0) {
    foreach ($sqlStatement as $ROW) {

        $DOC['ID'] = $ROW["DOC_ID"];
        $DOC['SERIES_NUMBER'] = $ROW["DOC_SERIES"] . "-" . $ROW["DOC_NUMBER"];
        $DOC['DATE'] = date("d/m/Y", strtotime($ROW["DOC_DATE"]));
        $DOC['CUSTOMER'] = $ROW["CUSTOMER_NAME"];
        $DOC['TOTAL_NET'] = number_format($ROW["DOC_TOTAL_NET"], 2, '.','');

        $STATUS_ID = $ROW["DOC_STATUS_ID"];
        
        if ($STATUS_ID == 1){
            $DOC['STATUS'] = "Vigente";
        }elseif($STATUS_ID == 2){
            $DOC['STATUS'] = "Anulado";
        }elseif($STATUS_ID == 3){
            $DOC['STATUS'] = "Pendiente de Pago";
        }elseif($STATUS_ID == 4){
            $DOC['STATUS'] = "Cancelado";
        }

        $DOC['SELLER_NAME'] = $ROW["SELLER_NAME"];
        
        /*
        $DOC['SELLER_ID'] = $ROW["SELLERID"];
        $DOC['CUSTOMER_ID'] = $ROW["CUSTOMER_ID"];
        */

        array_push($json_data, $DOC);
    }
}

echo json_encode($json_data);