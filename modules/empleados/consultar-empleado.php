<?php
require '../../global/connection.php';
$FILTER_EMP = $_POST["FILTER"];
if ($FILTER_EMP == "ALL") {
    $sqlStatement = $pdo->prepare("SELECT * FROM tbl_employee
        ORDER BY id DESC");
    $sqlStatement->execute();
    $rowsNumber = $sqlStatement->rowCount();

    $json_data = array();
    foreach ($sqlStatement as $ROW) {
        $ROWDATA['CODIGO'] = "EMP-" . $ROW["id"];
        $ROWDATA['NOMBRES'] = $ROW["name"];
        $ROWDATA['APELLIDOS'] = $ROW["last_name_1"] . " " . $ROW["last_name_2"];
        $ROWDATA['CARGO'] = $ROW["job"];
        $ROWDATA['TIPO_DOC'] = $ROW["id_doc_type"];
        $ROWDATA['NUM_DOC'] = $ROW["id_doc_number"];
        $ROWDATA['FEC_NAC'] = date("d/m/Y",strtotime($ROW["birth_date"]));
        $ROWDATA['FEC_ING'] = date("d/m/Y",strtotime($ROW["admission_date"]));

        array_push($json_data, $ROWDATA);
    }
    
    echo json_encode(array("data" => $json_data));

} elseif ($FILTER_EMP == "SELECT_LIST") {
    $sqlStatement = $pdo->prepare("SELECT id, CONCAT(last_name_1, ' ', last_name_2,', ', name) AS empleado_nombre FROM tbl_employee");
    $sqlStatement->execute();
    $rowsNumber = $sqlStatement->rowCount();

    if ($rowsNumber > 0) {
        $DATA = array();

        while ($LST = $sqlStatement->fetch()) {
            $ID_EMP = $LST["id"];
            $NOM_EMP = $LST["empleado_nombre"];
            $ROW = [
                "id" => $ID_EMP,
                "text" => $NOM_EMP
            ];
            array_push($DATA, $ROW);
        }
    }
    
    echo json_encode($DATA);

} else {
    $ID_REAL = str_replace("EMP-","",$FILTER_EMP);
    $sqlStatement = $pdo->prepare("SELECT * FROM tbl_employee
        WHERE id=:EMPLOYEE_ID");
    $sqlStatement->bindParam("EMPLOYEE_ID", $ID_REAL, PDO::PARAM_STR);
    $sqlStatement->execute();
    $rowsNumber = $sqlStatement->rowCount();
    if ($rowsNumber > 0) {
        $json_data = array();
        foreach ($sqlStatement as $ROW) {
            $ROWDATA['CODIGO'] = $ROW["id"];
            $ROWDATA['NOMBRES'] = $ROW["name"];
            $ROWDATA['APE_PAT'] = $ROW["last_name_1"];
            $ROWDATA['APE_MAT'] = $ROW["last_name_2"];
            $ROWDATA['TIPO_DOC'] = $ROW["id_doc_type"];
            $ROWDATA['NUM_DOC'] = $ROW["id_doc_number"];
            $ROWDATA['ESTADO_CIV'] = $ROW["civil_status"];
            $ROWDATA['EMAIL'] = $ROW["email"];
            $ROWDATA['TELEFONO'] = $ROW["phone"];
            $ROWDATA['DIRECCION'] = $ROW["address"];
            $ROWDATA['GRADO_EST'] = $ROW["study_level"];
            $ROWDATA['CARRERA'] = $ROW["study_career"];
            $ROWDATA['CARGO'] = $ROW["job"];
            $ROWDATA['FEC_NAC'] = date("Y-m-d",strtotime($ROW["birth_date"]));
            $ROWDATA['FEC_ING'] = date("Y-m-d",strtotime($ROW["admission_date"]));

            array_push($json_data, $ROWDATA);
        }
        echo json_encode($json_data);
    }
}