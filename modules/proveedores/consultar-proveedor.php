<?php
require '../../global/connection.php';
$FILTER_PROV = $_POST["FILTER"];
if ($FILTER_PROV == "ALL") {
    $sqlStatement = $pdo->prepare("SELECT * FROM tbl_provider ORDER BY id DESC");
    $sqlStatement->execute();
    $rowsNumber = $sqlStatement->rowCount();
    $json_data = array();
    if ($rowsNumber > 0) {        
        foreach ($sqlStatement as $ROW) {
            $ROWDATA['CODIGO'] = "PROV-" . $ROW["id"];
            $ROWDATA['NUMERO'] = $ROW["code"];
            $ROWDATA['RAZ_SOC'] = $ROW["business_name"];
            $ROWDATA['DIRECC'] = $ROW["address"];
            $ROWDATA['PAIS'] = $ROW["country"];
            $ROWDATA['CIUDAD'] = $ROW["city"];
            $ROWDATA['FECREG'] = date("d/m/Y H:i",strtotime($ROW["registration_date"]));
            array_push($json_data, $ROWDATA);
        }
    }
    echo json_encode(array("data" => $json_data));
} else {
    $ID_REAL = str_replace("PROV-","",$FILTER_PROV);
    $sqlStatement = $pdo->prepare("SELECT * FROM tbl_provider
        WHERE id=:PROV_ID");
    $sqlStatement->bindParam("PROV_ID", $ID_REAL, PDO::PARAM_INT);
    $sqlStatement->execute();
    $rowsNumber = $sqlStatement->rowCount();
    $json_data = array();
    if ($rowsNumber > 0) {        
        foreach ($sqlStatement as $ROW) {
            $ROWDATA['CODIGO'] = $ROW["id"];
            $ROWDATA['NUMERO'] = $ROW["code"];
            $ROWDATA['RAZ_SOC'] = $ROW["business_name"];
            $ROWDATA['DIRECC'] = $ROW["address"];
            $ROWDATA['PAIS'] = $ROW["country"];
            $ROWDATA['CIUDAD'] = $ROW["city"];
            $ROWDATA['DISTRITO'] = $ROW["district"];
            $ROWDATA['CONT1_NAME'] = $ROW["contact1_name"];
            $ROWDATA['CONT1_PHONE'] = $ROW["contact1_phone"];            
            $ROWDATA['CONT2_NAME'] = $ROW["contact2_name"];
            $ROWDATA['CONT2_PHONE'] = $ROW["contact2_phone"];            
            $ROWDATA['BANK1_NAME'] = $ROW["bank1_name"];
            $ROWDATA['BANK1_CURR'] = $ROW["bank1_currency"];
            $ROWDATA['BANK1_ACCNUM'] = $ROW["bank1_account_number"];
            $ROWDATA['BANK1_ACCHOL'] = $ROW["bank1_account_holder"];
            $ROWDATA['BANK2_NAME'] = $ROW["bank2_name"];
            $ROWDATA['BANK2_CURR'] = $ROW["bank2_currency"];
            $ROWDATA['BANK2_ACCNUM'] = $ROW["bank2_account_number"];
            $ROWDATA['BANK2_ACCHOL'] = $ROW["bank2_account_holder"];
            $ROWDATA['FEC_REG'] = date("Y-m-d",strtotime($ROW["registration_date"]));
            array_push($json_data, $ROWDATA);
        }        
    }
    echo json_encode($json_data);
}