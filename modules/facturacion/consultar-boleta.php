<?php
require '../../global/connection.php';
$FILTER_ID = $_POST["FILTER"];
$ESTADO_FAC = $_POST["ESTADO"];

$QUERY_SELECT = "SELECT ti.id AS IDFACT, ti.series AS SERIEFAC, ti.number AS NUMFAC, ti.status AS ESTFAC, ti.customer_id AS CLIID, ti.ruc AS CLIRUC, ti.name AS CLINOM, ti.address AS CLIADD, ti.reference AS CLIREF, ti.payment_days AS PAYDAYS, ti.delivery_date AS DELDATE, ti.currency AS CURRENCY, ti.discount_rate AS DESCRATE, ti.discount_value AS DESCVAL, ti.total_sub AS TOTSUB, ti.total_tax AS TOTTAX, ti.total_net AS TOTNETO, ti.seller_id AS SELLERID, ti.user_id AS USERID, ti.date AS FECHA, ti.registration_date AS REGDATE FROM tbl_receipt ti ";

if ($FILTER_ID == "ALL") {
    $sqlquery_adic = "";
    if($ESTADO_FAC != "ALL"){
        $sqlquery_adic = " WHERE ti.status = $ESTADO_FAC ";
    }
    $sqlStatement = $pdo->prepare($QUERY_SELECT." ".$sqlquery_adic ." ORDER BY ti.id DESC");
    $sqlStatement->execute();
    $rowsNumber = $sqlStatement->rowCount();
    $json_data = array();
    if ($rowsNumber > 0) {        
        foreach ($sqlStatement as $ROW) {
            $STATUS_ID = $ROW["ESTFAC"];
            $CUSTOMER_ID = $ROW["CLIID"];

            $ROWDATA['SERIE'] = $ROW["SERIEFAC"];
            $ROWDATA['CODIGO'] = $ROW["NUMFAC"];
            
            $ROWDATA['CLIENTRUC'] = $ROW["CLIRUC"];
            $ROWDATA['CODIGOID'] = $ROW["IDFACT"];
            $ROWDATA['ESTADO'] = $STATUS_ID;
            $ROWDATA['CLIENTID'] = $CUSTOMER_ID;
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
            $ROWDATA['SELLER_ID'] = $ROW["SELLERID"];
            $ROWDATA['USER_ID'] = $ROW["USERID"];
            $ROWDATA['FECREG'] = date("d-m-Y",strtotime($ROW["FECHA"]));

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
    //echo json_encode(array("data" => $json_data));
    echo json_encode($json_data);
} else {
    $sqlquery_adic = "";
    if($ESTADO_FAC != "ALL"){
        $sqlquery_adic = " AND ti.status = $ESTADO_FAC ";
    }

    if(isset($_POST["FILTER_BYCOTIZ"])){
        $sqlStatement = $pdo->prepare($QUERY_SELECT." WHERE ti.quotation_id=:IDFILTER $sqlquery_adic");
    } else {
        $sqlStatement = $pdo->prepare($QUERY_SELECT." WHERE ti.id=:IDFILTER $sqlquery_adic");
    }    
    $sqlStatement->bindParam("IDFILTER", $FILTER_ID, PDO::PARAM_STR);
    $sqlStatement->execute();
    $rowsNumber = $sqlStatement->rowCount();
    $json_data = array();
    if ($rowsNumber > 0) {        
        foreach ($sqlStatement as $ROW) {
            $CLIENTE_ID = $ROW["CLIID"];            
            $ROWDATA['CLIENTRUC'] = $ROW["CLIRUC"];
            $ROWDATA['CODIGOID'] = $ROW["IDFACT"];
            $ROWDATA['CODIGO'] = $ROW["NUMFAC"];
            $ROWDATA['SERIE'] = $ROW["SERIEFAC"];
            $ROWDATA['CODIGO_CORRELATIVO'] = $ROW["NUMFAC"];
            $ROWDATA['ESTADO'] = $ROW["ESTFAC"];
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
            $ROWDATA['SELLER_ID'] = $ROW["SELLERID"];
            $ROWDATA['USER_ID'] = $ROW["USERID"];
            $ROWDATA['FECREG'] = date("Y-m-d",strtotime($ROW["FECHA"]));
            array_push($json_data, $ROWDATA);
        }        
    }
    echo json_encode($json_data);
}