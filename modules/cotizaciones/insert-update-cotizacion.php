<?php
session_start();
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    require '../../global/connection.php';

    $c_cotcod = "";
    
    $c_cliid = $_POST['cotizacion_cliente'];
    $c_cliid = $c_cliid==""?0:$c_cliid;

    $c_cli_ruc = trim($_POST['cotizacion_cliruc']);
    $c_clinom = trim($_POST['cotizacion_valcliente']);
    $c_clidirecc = trim($_POST['cotizacion_clidirecc']);
    $c_clirefer = trim($_POST['cotizacion_clirefer']);

    $c_currency = $_POST['cotizacion_tipmon'];
    $c_clifecentreg = date("Y-m-d", strtotime($_POST['cotizacion_fecentrega']));
    $c_porcdesc = $_POST['cotizacion_porcdesc'] == "" ? 0 : $_POST['cotizacion_porcdesc'];
    $c_valdesc = $_POST['cotizacion_cantdesc'];
    $c_diaspag = $_POST['cotizacion_formpago'];
    
    $c_fecha = date("Y-m-d", strtotime($_POST['cotizacion_fecha']));
    $c_subtotal = $_POST['cotizacion_opergrab'];
    $c_totalneto = $_POST['cotizacion_total'];
    $c_taxigv = $_POST['cotizacion_igv'];
    $c_lst_prods = $_POST['cotiz_prods'];
    $c_lst_prods = json_decode($c_lst_prods);
    $c_estado = $_POST["cotizacion_estado"];

    $c_seller_id = $_POST["cotizacion_usuarioid"];
    $c_user_id = $_SESSION['loggedInUser']['USERID'];
    
    $cotizacion_id = $_POST["id_cotizacion"];

    $c_fecreg = date("Y-m-d H:i:s");

    $id_prod = "";
    $nom_prod = "";
    $desc_prod = "";
    $prec_prod = 0;
    $import_prod = 0;
    $cant_prod = 0;

    if ($cotizacion_id == "" || $cotizacion_id == null) {

        $LSTMAXID = $pdo->prepare("SELECT MAX(id) AS MAXID FROM tbl_quotation ORDER BY id DESC");
        $LSTMAXID->execute();
        $NEXT_ID = 0;
        while ($LMI = $LSTMAXID->fetch()) {
            $MAX_ID = $LMI["MAXID"];
        }
        if ($MAX_ID == "" || $MAX_ID == 0) {
            $NEXT_ID = 1;
        } else {
            $NEXT_ID = $MAX_ID + 1;
        }
        $c_cotcod = "COTZ-" . $NEXT_ID;
        

        $sqlStatement = $pdo->prepare("INSERT INTO tbl_quotation (number,status,customer_id,ruc,name,address,reference,payment_days,date,delivery_date,currency,discount_rate,discount_value,total_sub,total_tax,total_net,seller_id,user_id,registration_date) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        if ($sqlStatement) {
            $sqlStatement->execute([$c_cotcod, $c_estado, $c_cliid, $c_cli_ruc, $c_clinom, $c_clidirecc, $c_clirefer, $c_diaspag, $c_fecha, $c_clifecentreg, $c_currency, $c_porcdesc, $c_valdesc, $c_subtotal, $c_taxigv, $c_totalneto, $c_seller_id, $c_user_id, $c_fecreg]);
            echo "OK_INSERT";

            $LSTMAXID = $pdo->prepare("SELECT MAX(id) AS MAXID FROM tbl_quotation ORDER BY id DESC");
            $LSTMAXID->execute();
            while ($LMI = $LSTMAXID->fetch()) {
                $cotizacion_id = $LMI["MAXID"];
            }
        } else {
            echo "ERROR";
        }
    } else {
        $sqlStatement = $pdo->prepare("UPDATE tbl_quotation SET status=?,customer_id=?,ruc=?,name=?,address=?,reference=?,payment_days=?,date=?,delivery_date=?,currency=?,discount_rate=?,discount_value=?,total_sub=?,total_tax=?,total_net=?,seller_id=?,user_id=?,last_update=? WHERE id=?");
        if ($sqlStatement) {
            $sqlStatement->execute([$c_estado, $c_cliid, $c_cli_ruc, $c_clinom, $c_clidirecc, $c_clirefer, $c_diaspag, $c_fecha, $c_clifecentreg, $c_currency, $c_porcdesc, $c_valdesc, $c_subtotal, $c_taxigv, $c_totalneto, $c_seller_id, $c_user_id, $c_fecreg, $cotizacion_id]);
            echo "OK_UPDATE";
        } else {
            echo "ERROR";
        }
        $sqlStatement = $pdo->prepare("DELETE FROM tbl_quotation_detail WHERE quotation_id=:IDCOTIZ");
        $sqlStatement->bindParam("IDCOTIZ", $cotizacion_id, PDO::PARAM_INT);
        $sqlStatement->execute();
    }

    if ($c_lst_prods != "") {
        if (count($c_lst_prods) > 0) {
            foreach ($c_lst_prods as $key => $value) {
                foreach ($value as $k => $v) {
                    switch ($k) {
                        case "0":
                            $id_prod = $v;
                            break;
                        case "1":
                            $nom_prod = $v;
                            break;
                        case "2":
                            $desc_prod = $v;
                            break;
                        case "3":
                            $prec_prod = $v;
                            break;
                        case "4":
                            $cant_prod = $v;
                            break;
                        case "5":
                            $import_prod = $v;
                            break;
                    }
                }
                $sqlStatement = $pdo->prepare("INSERT INTO tbl_quotation_detail (item_description,item_id,item_name,item_quantity,item_unit_price,quotation_id) VALUES (?,?,?,?,?,?)");
                $sqlStatement->execute([$desc_prod, $id_prod, $nom_prod, $cant_prod, $prec_prod, $cotizacion_id]);
            }
        }
    }
} else {
    echo "ERROR";
}
