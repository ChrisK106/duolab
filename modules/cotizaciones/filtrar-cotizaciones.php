<?php
require '../../global/connection.php';
$COTIZ_NRO = $_POST["cotiz_nroo"];
$COTIZ_CLIENTE = $_POST["cotiz_client"];
$COTIZ_FINI = "";
$COTIZ_FFIN = "";

if ($_POST["cotiz_fini"] != "") {
    $COTIZ_FINI = date("Y-m-d", strtotime($_POST["cotiz_fini"]));
}
if ($_POST["cotiz_ffin"] != "") {
    $COTIZ_FFIN = date("Y-m-d", strtotime($_POST["cotiz_ffin"]));
}

$QUERY_COTIZNRO = "";
$QUERY_COTIZCLI = "";
$QUERY_COTIZRANGO = "";

$WHERE_SET = false;
if ($COTIZ_NRO != "") {
    $QUERY_COTIZNRO = " WHERE tc.number LIKE '%" . $COTIZ_NRO . "%' ";
    $WHERE_SET = true;
}
if ($COTIZ_CLIENTE != "") {
    if ($WHERE_SET == false) {
        $QUERY_COTIZCLI = " WHERE tc.name LIKE '%" . $COTIZ_CLIENTE . "%' ";
    } else {
        $QUERY_COTIZCLI = " AND tc.name LIKE '%" . $COTIZ_CLIENTE . "%' ";
    }
}
if ($COTIZ_FINI != "" && $COTIZ_FFIN != "") {
    if ($WHERE_SET == false) {
        $QUERY_COTIZRANGO = " WHERE tc.date BETWEEN '" . $COTIZ_FINI . "' AND '" . $COTIZ_FFIN . "' ";
    } else {
        $QUERY_COTIZRANGO = " AND tc.date BETWEEN '" . $COTIZ_FINI . "' AND '" . $COTIZ_FFIN . "' ";
    }
}
$COND_COMP = $QUERY_COTIZNRO . $QUERY_COTIZCLI . $QUERY_COTIZRANGO;

$sqlStatement = $pdo->prepare("SELECT tc.id AS IDCOTIZ, tc.number AS NUMCOTIZ, tc.status AS ESTCOTIZ, tc.customer_id AS CLIID, tc.ruc AS CLIRUC, tc.name AS CLINOM, tc.address AS CLIADD, tc.reference AS CLIREF, tc.payment_days AS PAYDAYS, tc.delivery_date AS DELDATE, tc.currency AS CURRENCY, tc.discount_rate AS DESCRATE, tc.discount_value AS DESCVAL, tc.total_sub AS TOTSUB, tc.total_tax AS TOTTAX, tc.total_net AS TOTNETO, tc.seller_id AS SELLERID, tc.date AS FECHA FROM tbl_quotation tc $COND_COMP");
$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();
$json_data = array();
if ($rowsNumber > 0) {
    foreach ($sqlStatement as $ROW) {
        $ROWDATA['CLIENTRUC'] = $ROW["CLIRUC"];
        $ROWDATA['CODIGOID'] = $ROW["IDCOTIZ"];
        $ROWDATA['CODIGO'] = $ROW["NUMCOTIZ"];
        $ROWDATA['ESTADO'] = $ROW["ESTCOTIZ"];
        $ROWDATA['ESTADO_VAL'] = $ROW["ESTCOTIZ"] == 1 ? "Vigente" : "Anulado";
        $ROWDATA['CLIENTNAME'] = $ROW["CLINOM"];
        $ROWDATA['CLIENTADDR'] = $ROW["CLIADD"];
        $ROWDATA['CLIENTREFER'] = $ROW["CLIREF"];
        $ROWDATA['PAY_DAYS'] = $ROW["PAYDAYS"];
        $ROWDATA['DELIV_DATE'] = date("d/m/Y", strtotime($ROW["DELDATE"]));
        $ROWDATA['CURRENCY'] = $ROW["CURRENCY"];
        $ROWDATA['DESC_RATE'] = $ROW["DESCRATE"];
        $ROWDATA['DESC_VAL'] = $ROW["DESCVAL"];
        $ROWDATA['TOTAL_SUB'] = $ROW["TOTSUB"];
        $ROWDATA['TOTAL_TAX'] = $ROW["TOTTAX"];
        $ROWDATA['TOTAL_NET'] = $ROW["TOTNETO"];
        $ROWDATA['USER_ID'] = $ROW["SELLERID"];
        $ROWDATA['FECREG'] = date("d/m/Y", strtotime($ROW["FECHA"]));
        array_push($json_data, $ROWDATA);
    }
}
echo json_encode($json_data);
