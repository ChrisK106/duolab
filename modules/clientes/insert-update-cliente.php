<?php

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    require '../../global/connection.php';

    $c_razsoc = trim($_POST['cliente_razsoc']);
    $c_telfij = $_POST['cliente_telfij'];
    $c_ruc = trim($_POST['cliente_ruc']);
    $c_telcel = trim($_POST['cliente_telcel']);
    $c_nomcom = trim($_POST['cliente_nomcom']);
    $c_fecreg = date("Y-m-d", strtotime($_POST['cliente_fecreg']));
    $c_nomcont_1 = trim($_POST['cliente_nomcont_1']);
    $c_celcont_1 = trim($_POST['cliente_celcont_1']);
    $c_nomcont_2 = trim($_POST['cliente_nomcont_2']);
    $c_celcont_2 = trim($_POST['cliente_celcont_2']);
    $c_pagcomi = !$_POST['cliente_pagocomision'] ? 0 : $_POST['cliente_pagocomision'];
    $c_correo = trim($_POST['cliente_correo']);
    $c_direcc = trim($_POST['cliente_direccion']);
    $c_depart = $_POST['cliente_departamento'];
    $c_provin = $_POST['cliente_provincia'];
    $c_distrit = $_POST['cliente_distrito'];

    $c_idcli = $_POST['cliente_id'];

    if ($c_idcli == "" || $c_idcli == null) {
        $sqlStatement = $pdo->prepare("SELECT * FROM tbl_customer WHERE ruc=:ruc OR business_name=:razsoc");
        $sqlStatement->bindParam("ruc", $c_ruc, PDO::PARAM_STR);
        $sqlStatement->bindParam("razsoc", $c_razsoc, PDO::PARAM_STR);
    } else {
        $sqlStatement = $pdo->prepare("SELECT * FROM tbl_customer WHERE (ruc=:ruc OR business_name=:razsoc) AND (client_id <> :idcli)");
        $sqlStatement->bindParam("ruc", $c_ruc, PDO::PARAM_STR);
        $sqlStatement->bindParam("razsoc", $c_razsoc, PDO::PARAM_STR);
        $sqlStatement->bindParam("idcli", $c_idcli, PDO::PARAM_INT);
    }
    $sqlStatement->execute();
    $rowsNumber = $sqlStatement->rowCount();
    if ($rowsNumber == 0) {
        if ($c_idcli == "" || $c_idcli == null) {
            $sqlStatement = $pdo->prepare("INSERT INTO tbl_customer (ruc,business_name,trade_name,email,phone,cellphone,address,department_id,province_id,district_id,contact1_name,contact1_phone,contact2_name,contact2_phone,commission,registration_date) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            if ($sqlStatement) {
                $sqlStatement->execute([$c_ruc, $c_razsoc, $c_nomcom, $c_correo, $c_telfij, $c_telcel, $c_direcc, $c_depart, $c_provin, $c_distrit, $c_nomcont_1, $c_celcont_1, $c_nomcont_2, $c_celcont_2, $c_pagcomi, $c_fecreg]);
                echo "OK_INSERT";
            } else {
                echo "ERROR";
            }
        } else {
            $sqlStatement = $pdo->prepare("UPDATE tbl_customer SET ruc=?,business_name=?,trade_name=?,email=?,phone=?,cellphone=?,address=?,department_id=?,province_id=?,district_id=?,contact1_name=?,contact1_phone=?,contact2_name=?,contact2_phone=?,commission=?,registration_date=? WHERE client_id=?");
            if ($sqlStatement) {
                $sqlStatement->execute([$c_ruc, $c_razsoc, $c_nomcom, $c_correo, $c_telfij, $c_telcel, $c_direcc, $c_depart, $c_provin, $c_distrit, $c_nomcont_1, $c_celcont_1, $c_nomcont_2, $c_celcont_2, $c_pagcomi, $c_fecreg, $c_idcli]);
                echo "OK_UPDATE";
            } else {
                echo "ERROR";
            }
        }
    } else {
        echo "EXISTE";
    }
} else {
    echo "ERROR";
}
