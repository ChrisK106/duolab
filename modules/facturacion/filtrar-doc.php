<?php
require '../../global/connection.php';

$tipoDoc = $_POST['TIPO_DOC'];
$FACT_NRO = $_POST["fact_nroo"];
$FACT_CLIENT = $_POST["fact_client"];
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
$WHERE_SET = false;

if ($FACT_NRO != "") {
    $QUERY_FACTNRO = " WHERE ti.number LIKE '%" . $FACT_NRO . "%' ";
    $WHERE_SET = true;
}

if ($FACT_CLIENT != "") {
    if ($WHERE_SET == false) {
        $QUERY_FACTCLI = " WHERE ti.name LIKE '%" . $FACT_CLIENT . "%' ";
    } else {
        $QUERY_FACTCLI = " AND ti.name LIKE '%" . $FACT_CLIENT . "%' ";
    }
}

if ($FACT_FINI != "" && $FACT_FFIN != "") {
    if ($WHERE_SET == false) {
        $QUERY_FACTRANGO = " WHERE ti.date BETWEEN '" . $FACT_FINI . "' AND '" . $FACT_FFIN . "' ";
    } else {
        $QUERY_FACTRANGO = " AND ti.date BETWEEN '" . $FACT_FINI . "' AND '" . $FACT_FFIN . "' ";
    }
}

$COND_COMP = $QUERY_FACTNRO . $QUERY_FACTCLI . $QUERY_FACTRANGO;

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

$sqlStatement = $pdo->prepare("SELECT (SELECT CONCAT(e.last_name_1, ' ', e.last_name_2, ', ', e.name) FROM tbl_user u JOIN tbl_employee e ON u.employee_id = e.id WHERE u.id = ti.seller_id) AS SELLERNAME, ti.id AS IDFACT, ti.series AS SERIEFAC, ti.number AS NUMFAC, ti.status AS ESTFAC, ti.customer_id AS CLIID, ti.ruc AS CLIRUC, ti.name AS CLINOM, ti.address AS CLIADD, ti.reference AS CLIREF, ti.payment_days AS PAYDAYS, ti.delivery_date AS DELDATE, ti.currency AS CURRENCY, ti.discount_rate AS DESCRATE, ti.discount_value AS DESCVAL, ti.total_sub AS TOTSUB, ti.total_tax AS TOTTAX, ti.total_net AS TOTNETO, ti.seller_id AS SELLERID, ti.user_id AS USERID, ti.date AS FECHA, ti.registration_date AS REGDATE FROM " . $table . " ti " . $COND_COMP . " ORDER BY ti.id DESC");

$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();
$json_data = array();

if ($rowsNumber > 0) {
    foreach ($sqlStatement as $ROW) {
        $STATUS_ID = $ROW["ESTFAC"];
        $CUSTOMER_ID = $ROW["CLIID"];

        $ROWDATA['CLIENTRUC'] = $ROW["CLIRUC"];
        $ROWDATA['CODIGOID'] = $ROW["IDFACT"];
        $ROWDATA['CODIGO'] = $ROW["SERIEFAC"] . "-" . $ROW["NUMFAC"];
        $ROWDATA['ESTADO'] = $STATUS_ID;
        $ROWDATA['CLIENTID'] = $CUSTOMER_ID;
        $ROWDATA['CLIENTNAME'] = $ROW["CLINOM"];
        $ROWDATA['CLIENTADDR'] = $ROW["CLIADD"];
        $ROWDATA['CLIENTREFER'] = $ROW["CLIREF"];
        $ROWDATA['PAY_DAYS'] = $ROW["PAYDAYS"];
        $ROWDATA['DELIV_DATE'] = date("d-m-Y", strtotime($ROW["DELDATE"]));
        $ROWDATA['CURRENCY'] = $ROW["CURRENCY"];
        $ROWDATA['DESC_RATE'] = $ROW["DESCRATE"];
        $ROWDATA['DESC_VAL'] = $ROW["DESCVAL"];
        $ROWDATA['TOTAL_SUB'] = $ROW["TOTSUB"];
        $ROWDATA['TOTAL_TAX'] = $ROW["TOTTAX"];
        $ROWDATA['TOTAL_NET'] = $ROW["TOTNETO"];
        $ROWDATA['SELLER_ID'] = $ROW["SELLERID"];
        $ROWDATA['SELLER_NAME'] = $ROW["SELLERNAME"];
        $ROWDATA['USER_ID'] = $ROW["USERID"];
        $ROWDATA['FECREG'] = date("d-m-Y", strtotime($ROW["FECHA"]));

        if ($STATUS_ID == 1){
            $ROWDATA['ESTADO_VAL'] = "Vigente";
        }elseif($STATUS_ID == 2){
            $ROWDATA['ESTADO_VAL'] = "Anulado";
        }elseif($STATUS_ID == 3){
            $ROWDATA['ESTADO_VAL'] = "Pendiente de Pago";
        }elseif($STATUS_ID == 4){
            $ROWDATA['ESTADO_VAL'] = "Cancelado";
        }

        array_push($json_data, $ROWDATA);
    }
}

echo json_encode($json_data);