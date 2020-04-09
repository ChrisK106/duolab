<?php
require '../../global/connection.php';

$QUERY_VENDEDOR = "";
$QUERY_PERIODO = "";
$COND_COMP = "";

$WHERE_SET = false;
if (isset($_POST["VENDEDOR"])) {
    $NOM_VEND = trim($_POST["VENDEDOR"]);
    if ($NOM_VEND != "" && $NOM_VEND != null) {
        $QUERY_VENDEDOR = " WHERE CONCAT(te.name, ' ', te.last_name_1, ' ', te.last_name_2) = '" . $NOM_VEND . "' ";
        $WHERE_SET = true;
    }
}
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
                $QUERY_PERIODO = $VAL_ADIC . "MONTH(ti.date) = '" . $MONTH_P . "' AND YEAR(ti.date) = '" . $YEAR_P . "' ";
                break;
            case 'YEAR':
                if ($WHERE_SET == true) {
                    $VAL_ADIC = " AND ";
                }
                $QUERY_PERIODO = $VAL_ADIC . "YEAR(ti.date) = '" . $YEAR_P . "' ";
                break;
        }
    }
}

$COND_COMP = $QUERY_VENDEDOR . $QUERY_PERIODO;

$LST_REPORT = $pdo->prepare("SELECT ti.seller_id AS ID_VEND, SUM(ti.total_net) AS TOT_VENTA, CONCAT(te.name, ' ', te.last_name_1) AS NOM_VEND, CONCAT(te.name, ' ', te.last_name_1, ' ', te.last_name_2) AS NOM_VEND_COMP FROM tbl_invoice ti INNER JOIN tbl_user tu ON ti.seller_id=tu.id LEFT JOIN tbl_employee te ON tu.employee_id=te.id $COND_COMP GROUP BY ti.seller_id ORDER BY ti.total_net ASC");
$LST_REPORT->execute();
$CANT_ROWS = $LST_REPORT->rowCount();
$ARRAY_DATA = array();
$ARRAY_LABELS = array();
$JSON_DATA = array();
if ($CANT_ROWS > 0) {
    $CONT = 0;
    foreach ($LST_REPORT as $ROW) {

        $NOM_VEND = $ROW["NOM_VEND"];
        $TOT_VENTA = round($ROW["TOT_VENTA"], 2);

        $ROW_DATA = [$CONT, $TOT_VENTA];
        $ROW_LABEL = [$CONT, $NOM_VEND];

        $CONT++;

        array_push($ARRAY_DATA, $ROW_DATA);
        array_push($ARRAY_LABELS, $ROW_LABEL);
    }
    array_push($JSON_DATA, $ARRAY_DATA, $ARRAY_LABELS);
}
echo json_encode($JSON_DATA);
