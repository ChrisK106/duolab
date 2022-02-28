<?php
require '../../global/connection.php';
$FILTER_COTIZ = $_POST["FILTER"];
$ESTADO_COTIZ = $_POST["ESTADO"];

$QUERY_SELECT = "SELECT tc.id AS IDCOTIZ, tc.number AS NUMCOTIZ, tc.status AS ESTCOTIZ, tc.customer_id AS CLIID, tc.ruc AS CLIRUC, tc.name AS CLINOM, tc.address AS CLIADD, tc.reference AS CLIREF, tc.payment_days AS PAYDAYS, tc.delivery_date AS DELDATE, tc.currency AS CURRENCY, tc.discount_rate AS DESCRATE, tc.discount_value AS DESCVAL, tc.total_sub AS TOTSUB, tc.total_tax AS TOTTAX, tc.total_net AS TOTNETO, tc.seller_id AS SELLERID, tc.date AS FECHA FROM tbl_quotation tc ";

if ($FILTER_COTIZ == "ALL") {
    $sqlquery_adic = "";
    if($ESTADO_COTIZ != "ALL"){
        $sqlquery_adic = " WHERE tc.status = $ESTADO_COTIZ ";
    }
    $sqlStatement = $pdo->prepare($QUERY_SELECT." ".$sqlquery_adic ." ORDER BY tc.id DESC");
    $sqlStatement->execute();
    $rowsNumber = $sqlStatement->rowCount();
    $json_data = array();
    if ($rowsNumber > 0) {        
        foreach ($sqlStatement as $ROW) {
            $CLIENTE_ID = $ROW["CLIID"];

            $ROWDATA['CLIENTRUC'] = $ROW["CLIRUC"];
            $ROWDATA['CODIGOID'] = $ROW["IDCOTIZ"];
            $ROWDATA['CODIGO'] = $ROW["NUMCOTIZ"];
            $ROWDATA['ESTADO'] = $ROW["ESTCOTIZ"];
            $ROWDATA['ESTADO_VAL'] = $ROW["ESTCOTIZ"]==1?"Vigente":"Anulado";
            $ROWDATA['CLIENTID'] = $CLIENTE_ID;
            $ROWDATA['CLIENTNAME'] = $ROW["CLINOM"];
            $ROWDATA['CLIENTADDR'] = $ROW["CLIADD"];
            $ROWDATA['CLIENTREFER'] = $ROW["CLIREF"];
            $ROWDATA['PAY_DAYS'] = $ROW["PAYDAYS"];
            $ROWDATA['DELIV_DATE'] = date("d-m-Y",strtotime($ROW["DELDATE"]));
            $ROWDATA['CURRENCY'] = $ROW["CURRENCY"];
            $ROWDATA['DESC_RATE'] = $ROW["DESCRATE"];
            $ROWDATA['DESC_VAL'] = $ROW["DESCVAL"];
            $ROWDATA['TOTAL_SUB'] = $ROW["TOTSUB"];
            $ROWDATA['TOTAL_TAX'] = $ROW["TOTTAX"];
            $ROWDATA['TOTAL_NET'] = $ROW["TOTNETO"];
            $ROWDATA['USER_ID'] = $ROW["SELLERID"];
            $ROWDATA['FECREG'] = date("d/m/Y",strtotime($ROW["FECHA"]));
            array_push($json_data, $ROWDATA);
        }        
    }
    //echo json_encode(array("data" => $json_data));
    echo json_encode($json_data);
} else {
    $ID_REAL = $FILTER_COTIZ;
    $sqlquery_adic = "";
    if($ESTADO_COTIZ != "ALL"){
        $sqlquery_adic = " AND tc.status = $ESTADO_COTIZ ";
    }
    $sqlStatement = $pdo->prepare($QUERY_SELECT." WHERE tc.id=:COTIZID $sqlquery_adic");
    $sqlStatement->bindParam("COTIZID", $ID_REAL, PDO::PARAM_STR);
    $sqlStatement->execute();
    $rowsNumber = $sqlStatement->rowCount();
    $json_data = array();
    if ($rowsNumber > 0) {        
        foreach ($sqlStatement as $ROW) {
            $CLIENTE_ID = $ROW["CLIID"];
            
            $ROWDATA['CLIENTRUC'] = $ROW["CLIRUC"];

            $ROWDATA['CODIGOID'] = $ROW["IDCOTIZ"];
            $ROWDATA['CODIGO'] = $ROW["NUMCOTIZ"];
            $ROWDATA['ESTADO'] = $ROW["ESTCOTIZ"];
            $ROWDATA['CLIENTID'] = $CLIENTE_ID;
            $ROWDATA['CLIENTNAME'] = $ROW["CLINOM"];            
            $ROWDATA['CLIENTADDR'] = $ROW["CLIADD"];
            $ROWDATA['CLIENTREFER'] = $ROW["CLIREF"];
            $ROWDATA['PAY_DAYS'] = $ROW["PAYDAYS"];
            $ROWDATA['DELIV_DATE'] = date("Y-m-d",strtotime($ROW["DELDATE"]));
            $ROWDATA['CURRENCY'] = $ROW["CURRENCY"];
            $ROWDATA['DESC_RATE'] = $ROW["DESCRATE"];
            $ROWDATA['DESC_VAL'] = $ROW["DESCVAL"];
            $ROWDATA['TOTAL_SUB'] = $ROW["TOTSUB"];
            $ROWDATA['TOTAL_TAX'] = $ROW["TOTTAX"];
            $ROWDATA['TOTAL_NET'] = $ROW["TOTNETO"];
            $ROWDATA['USER_ID'] = $ROW["SELLERID"];
            $ROWDATA['FECREG'] = date("d/m/Y",strtotime($ROW["FECHA"]));
            array_push($json_data, $ROWDATA);
        }        
    }
    echo json_encode($json_data);
}
