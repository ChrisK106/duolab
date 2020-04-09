<?php
require '../../global/connection.php';
$FILTER_USER = $_POST["FILTER"];
if ($FILTER_USER == "ALL") {
    $sqlStatement = $pdo->prepare("SELECT u.id AS usuario_id, 
        u.username, u.registration_date, e.id AS empleado_id, e.job,
        CONCAT(e.last_name_1, ' ', e.last_name_2, ', ', e.name) AS empleado_nombre 
        FROM tbl_user u JOIN tbl_employee e 
        ON u.employee_id = e.id
        ORDER BY u.id DESC");
    
    $sqlStatement->execute();
    $rowsNumber = $sqlStatement->rowCount();

        $json_data = array();
        foreach ($sqlStatement as $ROW) {
            $ROWDATA['CODIGO_USR'] = "USR-" . $ROW["usuario_id"];
            $ROWDATA['CODIGO_EMP'] = "EMP-" . $ROW["empleado_id"];
            $ROWDATA['USERNAME'] = $ROW["username"];
            $ROWDATA['NOMBRE_EMP'] = $ROW["empleado_nombre"];
            $ROWDATA['CARGO_EMP'] = $ROW["job"];
            $ROWDATA['FEC_REG'] = date("d/m/Y H:i",strtotime($ROW["registration_date"]));

            array_push($json_data, $ROWDATA);
        }
        echo json_encode(array("data" => $json_data));

} else {
    $ID_REAL = str_replace("USR-","",$FILTER_USER);
    $sqlStatement = $pdo->prepare("SELECT * FROM tbl_user
        WHERE id=:USER_ID");
    $sqlStatement->bindParam("USER_ID", $ID_REAL, PDO::PARAM_STR);
    $sqlStatement->execute();
    $rowsNumber = $sqlStatement->rowCount();
    if ($rowsNumber > 0) {
        $json_data = array();
        foreach ($sqlStatement as $ROW) {
            $ROWDATA['CODIGO'] = $ROW["id"];
            $ROWDATA['USERNAME'] = $ROW["username"];
            $ROWDATA['CODIGO_EMP'] = $ROW["employee_id"];
            $ROWDATA['FEC_REG'] = date("Y-m-d",strtotime($ROW["registration_date"]));

            array_push($json_data, $ROWDATA);
        }
        echo json_encode($json_data);
    }
}