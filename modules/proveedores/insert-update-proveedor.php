<?php

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    require '../../global/connection.php';

    $p_provnum = trim($_POST['proveedor_numero']);
    $p_razsoc = trim($_POST['proveedor_razsoc']);

    $p_pais = trim($_POST['proveedor_pais']);
    $p_ciudad = trim($_POST['proveedor_ciudad']);
    $p_distrito = trim($_POST['proveedor_distrito']);
    $p_direcc = trim($_POST['proveedor_direccion']);

    $p_contnom1 = trim($_POST['proveedor_contnom_1']);    
    $p_contelf1 = trim($_POST['proveedor_conttelef_1']);   
    $p_contnom2 = trim($_POST['proveedor_contnom_2']);   
    $p_contelf2 = trim($_POST['proveedor_conttelef_2']);

    $p_banco1 = $_POST['proveedor_banco_1'];
    $p_tipmon1 = $_POST['proveedor_tipmoneda_1'];
    $p_ctacorr1 = $_POST['proveedor_ctacorriente_1'];
    $p_titcta1 = $_POST['proveedor_titularcta_1'];

    $p_banco2 = $_POST['proveedor_banco_2'];
    $p_tipmon2 = $_POST['proveedor_tipmoneda_2'];
    $p_ctacorr2 = $_POST['proveedor_ctacorriente_2'];
    $p_titcta2 = $_POST['proveedor_titularcta_2'];

    $p_fecreg = date("Y-m-d H:i:s");
    
    $p_provid = $_POST['proveedor_id'];

    if ($p_provid == "" || $p_provid == null) {
        $sqlStatement = $pdo->prepare("SELECT * FROM tbl_provider WHERE business_name=:razsoc AND code=:provcode");
        $sqlStatement->bindParam("razsoc", $p_razsoc, PDO::PARAM_STR);
        $sqlStatement->bindParam("provcode", $p_provnum, PDO::PARAM_STR);
    } else {
        $sqlStatement = $pdo->prepare("SELECT * FROM tbl_provider WHERE business_name=:razsoc AND code=:provcode AND id <> :idprov");
        $sqlStatement->bindParam("razsoc", $p_razsoc, PDO::PARAM_STR);
        $sqlStatement->bindParam("provcode", $p_provnum, PDO::PARAM_STR);
        $sqlStatement->bindParam("idprov", $p_provid, PDO::PARAM_INT);
    }
    $sqlStatement->execute();
    $rowsNumber = $sqlStatement->rowCount();
    if ($rowsNumber == 0) {
        if ($p_provid == "" || $p_provid == null) {
            $sqlStatement = $pdo->prepare("INSERT INTO tbl_provider (code,business_name,address,country,city,district,contact1_name,contact1_phone,contact2_name,contact2_phone,bank1_name,bank1_currency,bank1_account_number,bank1_account_holder,bank2_name,bank2_currency,bank2_account_number,bank2_account_holder,registration_date) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            if ($sqlStatement) {
                $sqlStatement->execute([$p_provnum,$p_razsoc,$p_direcc,$p_pais,$p_ciudad,$p_distrito,$p_contnom1,$p_contelf1,$p_contnom2,$p_contelf2,$p_banco1,$p_tipmon1,$p_ctacorr1,$p_titcta1,$p_banco2,$p_tipmon2,$p_ctacorr2,$p_titcta2,$p_fecreg]);
                echo "OK_INSERT";
            } else {
                echo "ERROR";
            }
        } else {
            $sqlStatement = $pdo->prepare("UPDATE tbl_provider SET code=?, business_name=?,address=?,country=?,city=?,district=?,contact1_name=?,contact1_phone=?,contact2_name=?,contact2_phone=?,bank1_name=?,bank1_currency=?,bank1_account_number=?,bank1_account_holder=?,bank2_name=?,bank2_currency=?,bank2_account_number=?,bank2_account_holder=?,registration_date=? WHERE id=?");
            if ($sqlStatement) {
                $sqlStatement->execute([$p_provnum,$p_razsoc,$p_direcc,$p_pais,$p_ciudad,$p_distrito,$p_contnom1,$p_contelf1,$p_contnom2,$p_contelf2,$p_banco1,$p_tipmon1,$p_ctacorr1,$p_titcta1,$p_banco2,$p_tipmon2,$p_ctacorr2,$p_titcta2,$p_fecreg,$p_provid]);
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
