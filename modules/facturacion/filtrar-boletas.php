<?php
require '../../global/connection.php';
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

$sqlStatement = $pdo->prepare("SELECT ti.id AS IDFACT, ti.number AS NUMFAC, ti.status AS ESTFAC, ti.customer_id AS CLIID, ti.ruc AS CLIRUC, ti.name AS CLINOM, ti.address AS CLIADD, ti.reference AS CLIREF, ti.payment_days AS PAYDAYS, ti.delivery_date AS DELDATE, ti.currency AS CURRENCY, ti.discount_rate AS DESCRATE, ti.discount_value AS DESCVAL, ti.total_sub AS TOTSUB, ti.total_tax AS TOTTAX, ti.total_net AS TOTNETO, ti.seller_id AS SELLERID, ti.user_id AS USERID, ti.date AS FECHA, ti.registration_date AS REGDATE FROM tbl_receipt ti $COND_COMP");
$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();
$json_data = array();
if ($rowsNumber > 0) {
    foreach ($sqlStatement as $ROW) {
        $CLIENTE_ID = $ROW["CLIID"];
        $ROWDATA['CLIENTRUC'] = $ROW["CLIRUC"];
        $ROWDATA['CODIGOID'] = $ROW["IDFACT"];
        $ROWDATA['CODIGO'] = $ROW["NUMFAC"];
        $ROWDATA['ESTADO'] = $ROW["ESTFAC"];
        $ROWDATA['ESTADO_VAL'] = $ROW["ESTFAC"] == 1 ? "Vigente" : "Anulado";
        $ROWDATA['CLIENTID'] = $CLIENTE_ID;
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
        $ROWDATA['USER_ID'] = $ROW["USERID"];
        $ROWDATA['FECREG'] = date("d-m-Y", strtotime($ROW["FECHA"]));
        array_push($json_data, $ROWDATA);
    }
}
echo json_encode($json_data);
