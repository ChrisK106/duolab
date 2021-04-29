<?php
session_start();
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    require '../../global/connection.php';

    $ord_code = $_POST['orden_nro'];
    $ord_tipo = $_POST['orden_tipo'];
    $ord_id = $_POST['orden_id'];

    //$ord_rcompra = $_POST['orden_tccompra'];
    //$ord_rventa = $_POST['orden_tcventa'];
    $ord_rcompra = 0;
    $ord_rventa = 0;

    if($ord_rcompra == "") $ord_rcompra = 0;
    if($ord_rventa == "") $ord_rventa = 0;

    $ord_nrocuenta = trim($_POST['orden_nrocuenta']);
    $ord_approver = trim($_POST['orden_autorizador']);
    $ord_tipomon = $_POST['orden_tipomoneda'];
    $ord_emidate = date("Y-m-d", strtotime($_POST['orden_fecemision']));
    $ord_deldate = date("Y-m-d", strtotime($_POST['orden_fecentrega']));
    $ord_observ = trim($_POST['orden_observ']);
    $ord_daypay = $_POST['orden_tipopago'];
    $ord_provider = $_POST['orden_proveedor'];
    //$ord_cotiz = trim($_POST['orden_cotizacion']);
    $ord_cotiz = "";
    $ord_request = trim($_POST['orden_solicitante']);
    $ord_estado = $_POST['orden_estado'];
    $ord_totneto = $_POST['orden_totneto'];
    $ord_totcompra = $_POST['orden_totcompra'];
    $ord_totigv = $_POST['orden_igv'];

    $ord_lstprods = "";
    $ord_lstservicios = "";

    switch ($ord_tipo) {
        case 'COMPRA':
            $ord_tipo = 1;
            //$ord_code = "CI-";
            $ord_lstprods = $_POST['orden_lstprods'];
            $ord_lstprods = json_decode($ord_lstprods);
            break;
        case 'SERVICIO':
            $ord_tipo = 2;
            //$ord_code = "CS-";
            $ord_lstservicios = $_POST['orden_lstservicios'];
            $ord_lstservicios = json_decode($ord_lstservicios);
            break;
    }

    if ($ord_id == "" || $ord_id == null) {

        /*
        $LSTMAXID = $pdo->prepare("SELECT MAX(id) AS MAXID FROM tbl_purchase WHERE type=" . $ord_tipo . " ORDER BY id DESC");
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

        $ord_code = $ord_code . $NEXT_ID;
        */

        $sqlStatement = $pdo->prepare("INSERT INTO tbl_purchase (type,number,status,currency,issue_date,delivery_date,provider_id,payment_days,account_number,quotation,requester,approver,observation,total_purchase,total_tax,total_net,exchange_rate_sale,exchange_rate_purchase) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        
        if ($sqlStatement) {
            $sqlStatement->execute([$ord_tipo, $ord_code, $ord_estado, $ord_tipomon, $ord_emidate, $ord_deldate, $ord_provider, $ord_daypay, $ord_nrocuenta, $ord_cotiz, $ord_request, $ord_approver, $ord_observ, $ord_totcompra, $ord_totigv, $ord_totneto, $ord_rventa, $ord_rcompra]);
            echo "OK_INSERT";

            $LSTMAXID = $pdo->prepare("SELECT MAX(id) AS MAXID FROM tbl_purchase WHERE type=" . $ord_tipo . " ORDER BY id DESC");
            $LSTMAXID->execute();
            while ($LMI = $LSTMAXID->fetch()) {
                $ord_id = $LMI["MAXID"];
            }
        } else {
            echo "ERROR";
        }
    } else {
        $sqlStatement = $pdo->prepare("UPDATE tbl_purchase SET type=?,number=?,status=?,currency=?,issue_date=?,delivery_date=?,provider_id=?,payment_days=?,account_number=?,quotation=?,requester=?,approver=?,observation=?,total_purchase=?,total_tax=?,total_net=?,exchange_rate_sale=?,exchange_rate_purchase=? WHERE id=?");
        if ($sqlStatement) {
            $sqlStatement->execute([$ord_tipo, $ord_code, $ord_estado, $ord_tipomon, $ord_emidate, $ord_deldate, $ord_provider, $ord_daypay, $ord_nrocuenta, $ord_cotiz, $ord_request, $ord_approver, $ord_observ, $ord_totcompra, $ord_totigv, $ord_totneto, $ord_rventa, $ord_rcompra, $ord_id]);
            echo "OK_UPDATE";
        } else {
            echo "ERROR";
        }
        $sqlStatement = $pdo->prepare("DELETE FROM tbl_purchase_detail WHERE purchase_id=:IDORDER");
        $sqlStatement->bindParam("IDORDER", $ord_id, PDO::PARAM_INT);
        $sqlStatement->execute();
    }

    $item_id = "";
    $item_nom = "";
    $item_code = "";
    $item_desc = "";
    $item_glosa = "";
    $item_unitval = "";
    $item_descpor = 0;
    $item_descval = 0;
    $item_cant = 0;
    $item_prec = 0;
    $item_total = 0;

    if ($ord_lstprods != "") {
        if (count($ord_lstprods) > 0) {
            foreach ($ord_lstprods as $key => $value) {
                foreach ($value as $k => $v) {
                    switch ($k) {
                        case "0":
                            $item_id = $v;
                            break;
                        case "1":
                            $item_code = $v;
                            break;
                        case "2":
                            $item_desc = $v;
                            break;
                        case "3":
                            $item_glosa = $v;
                            break;
                        case "4":
                            $item_unitval = $v;
                            break;
                        case "5":
                            $item_prec = $v;
                            break;
                        case "6":
                            $item_cant = $v;
                            break;
                        case "7":
                            $item_descpor = $v;
                            break;
                        case "8":
                            $item_descval = $v;
                            break;
                    }
                }

                $sqlStatement = $pdo->prepare("INSERT INTO tbl_purchase_detail(purchase_id,item_code,item_description,item_gloss,item_unit_value,item_unit_price,item_quantity,item_discount_rate,item_discounted_total) VALUES(?,?,?,?,?,?,?,?,?)");

                $sqlStatement->execute([$ord_id, $item_code, $item_desc, $item_glosa, $item_unitval, $item_prec, $item_cant, $item_descpor, $item_descval]);
                
            }
        }
    }

    if ($ord_lstservicios != "") {
        if (count($ord_lstservicios) > 0) {
            foreach ($ord_lstservicios as $key => $value) {
                foreach ($value as $k => $v) {
                    switch ($k) {
                        case "0":
                            $item_id = $v;
                            break;
                        case "1":
                            $item_desc = $v;
                            break;
                        case "2":
                            $item_glosa = $v;
                            break;
                        case "3":
                            $item_prec = $v;
                            break;
                        case "4":
                            $item_cant = $v;
                            break;
                        case "5":
                            $item_descpor = $v;
                            break;
                        case "6":
                            $item_descval = $v;
                            break;
                    }
                }

                $sqlStatement = $pdo->prepare("INSERT INTO tbl_purchase_detail(purchase_id,item_description,item_gloss,item_unit_price,item_quantity,item_discount_rate,item_discounted_total) VALUES(?,?,?,?,?,?,?)");

                $sqlStatement->execute([$ord_id, $item_desc, $item_glosa, $item_prec, $item_cant, $item_descpor, $item_descval]);
                
            }
        }
    }

} else {
    echo "ERROR";
}