<?php
require '../../global/connection.php';

$QUERY_PERIODO = "";
$QUERY_GROUP = "";
$QUERY_ORDER = "";
$COND_COMP = "";
$FILTRO_P = 1;

$MESES = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

$WHERE_SET = false;
if (isset($_POST["PERIODO"])) {
    $PERIODO = $_POST["PERIODO"];
    if ($PERIODO != "" && $PERIODO != null) {
        $MONTH_P = $_POST["MONTH"];
        $YEAR_P = $_POST["YEAR"];
        $VAL_ADIC = " WHERE ";
        switch ($PERIODO) {
            case 'MONTH':
                if ($WHERE_SET == true) {
                    $VAL_ADIC = " AND ";
                }
                if($MONTH_P != "ALL"){
                    $QUERY_PERIODO = $VAL_ADIC . "MONTH(ti.date) = '" . $MONTH_P . "' AND YEAR(ti.date) = '" . $YEAR_P . "' ";
                } else {
                    $QUERY_PERIODO = $VAL_ADIC . "YEAR(ti.date) = '" . $YEAR_P . "' ";
                }
            break;
            case 'YEAR':
                $FILTRO_P = 2;
                if ($WHERE_SET == true) {
                    $VAL_ADIC = " AND ";
                }
                if($YEAR_P != "ALL"){
                    $QUERY_PERIODO = $VAL_ADIC . "YEAR(ti.date) = '" . $YEAR_P . "' ";
                }
                $QUERY_GROUP = " GROUP BY YEAR(ti.date) ";
                $QUERY_ORDER = " ORDER BY YEAR(ti.date) ASC ";
            break;
        }
    }
}

if($FILTRO_P == 1){
    $QUERY_GROUP = " GROUP BY MONTH(ti.date) ";
    $QUERY_ORDER = " ORDER BY MONTH(ti.date) ASC ";
}

$LST_REPORT = $pdo->prepare("SELECT MONTH(ti.date) AS MONTH_V, YEAR(ti.date) AS YEAR_V, SUM(ti.total_net) AS TOT_VENTA FROM tbl_invoice ti $QUERY_PERIODO $QUERY_GROUP $QUERY_ORDER ");
$LST_REPORT->execute();
$CANT_ROWS = $LST_REPORT->rowCount();
$ARRAY_DATA = array();
$ARRAY_LABELS = array();
$JSON_DATA = array();
if ($CANT_ROWS > 0) {
    $CONT = 0;
    foreach ($LST_REPORT as $ROW) {
        $TXT_PERIODO = "";
        switch ($FILTRO_P) {
            case "1":
                $NUM_MES = $ROW["MONTH_V"];
                $TXT_PERIODO = $MESES[$NUM_MES];
            break;
            case "2":
                $TXT_PERIODO = $ROW["YEAR_V"];
            break;
        }
        $TOT_VENTA = round($ROW["TOT_VENTA"], 2);

        $ROW_DATA = [$CONT, $TOT_VENTA];
        $ROW_LABEL = [$CONT, $TXT_PERIODO];

        $CONT++;

        array_push($ARRAY_DATA, $ROW_DATA);
        array_push($ARRAY_LABELS, $ROW_LABEL);
    }
    array_push($JSON_DATA, $ARRAY_DATA, $ARRAY_LABELS);
}
echo json_encode($JSON_DATA);
