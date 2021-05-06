<?php
session_start();

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    require '../../global/connection.php';

    $f_faccod = "";
    $f_series = $_POST['facturacion_series'];

    $f_cliid = $_POST['facturacion_cliente'];
    $f_cliid = $f_cliid == "" ? 0 : $f_cliid;

    $f_cli_ruc = trim($_POST['facturacion_cliruc']);
    $f_clinom = trim($_POST['facturacion_valcliente']);
    $f_clidirecc = trim($_POST['facturacion_clidirecc']);
    $f_clirefer = trim($_POST['facturacion_clirefer']);

    $f_currency = $_POST['facturacion_tipmon'];
    $f_clifecentreg = date("Y-m-d", strtotime($_POST['facturacion_fecentrega']));
    $f_porcdesc = $_POST['facturacion_porcdesc'] == "" ? 0 : $_POST['facturacion_porcdesc'];
    $f_valdesc = $_POST['facturacion_cantdesc'];
    $f_diaspag = $_POST['facturacion_formpago'];
    $f_reason = $_POST['facturacion_motivo_nc'];

    $f_fecha = date("Y-m-d", strtotime($_POST['facturacion_fecha']));
    $f_subtotal = $_POST['facturacion_opergrab'];
    $f_totalneto = $_POST['facturacion_total'];
    $f_taxigv = $_POST['facturacion_igv'];
    $f_lst_prods = $_POST['facturacion_prods'];
    $f_lst_prods = json_decode($f_lst_prods);
    $f_estado = $_POST["facturacion_estado"];

    $f_selectcotizid = $_POST["facturacion_listadofact"];
    $f_selectcotizid = $f_selectcotizid == "" ? 0 : $f_selectcotizid;

    $f_referenced_doc_type = 1;
    
    if ($f_series[0] == "F"){
        $f_referenced_doc_type = 1;
    } else {
        $f_referenced_doc_type = 2;
    }

    $f_seller_id = $_POST["facturacion_usuarioid"];
    $f_user_id = $_SESSION['loggedInUser']['USERID'];
    $id_facturacion = "";

    $f_faccod = $_POST["facturacion_nro"];

    $f_fecreg = date("Y-m-d H:i:s");

    $id_prod = "";
    $cod_prod = "";
    $nom_prod = "";
    $desc_prod = "";
    $prec_prod = 0;
    $import_prod = 0;
    $cant_prod = 0;
    
    $sqlStatement = $pdo->prepare("INSERT INTO tbl_credit_note (series,number,status,referenced_doc_id,referenced_doc_type_id,customer_id,ruc,name,address,reference,payment_days,date,delivery_date,currency,reason,discount_rate,discount_value,total_sub,total_tax,total_net,seller_id,user_id,registration_date,last_update) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    if ($sqlStatement) {
        $sqlStatement->execute([$f_series,$f_faccod, $f_estado, $f_selectcotizid, $f_referenced_doc_type, $f_cliid, $f_cli_ruc, $f_clinom, $f_clidirecc, $f_clirefer, $f_diaspag, $f_fecha, $f_clifecentreg, $f_currency, $f_reason, $f_porcdesc, $f_valdesc, $f_subtotal, $f_taxigv, $f_totalneto, $f_seller_id, $f_user_id, $f_fecreg, $f_fecreg]);
        echo "OK_INSERT";

        $LSTMAXID = $pdo->prepare("SELECT MAX(id) AS MAXID FROM tbl_credit_note ORDER BY id DESC");
        $LSTMAXID->execute();
        while ($LMI = $LSTMAXID->fetch()) {
            $id_facturacion = $LMI["MAXID"];
        }
    } else {
        echo "ERROR";
    }

    if ($f_lst_prods != "") {
        if (count($f_lst_prods) > 0) {
            foreach ($f_lst_prods as $key => $value) {
                foreach ($value as $k => $v) {
                    switch ($k) {
                        case "0":
                            $id_prod = $v;
                            break;
                        case "1":
                            $cod_prod = $v;
                            break;
                        case "2":
                            $nom_prod = $v;
                            break;
                        case "3":
                            $desc_prod = $v;
                            break;
                        case "4":
                            $prec_prod = $v;
                            break;
                        case "5":
                            $cant_prod = $v;
                            break;
                        case "6":
                            $import_prod = $v;
                            break;
                    }
                }

                //ACTUALIZAR STOCK PRODUCTO
                $lstprodxid = $pdo->prepare("SELECT * FROM tbl_product WHERE id=" . $id_prod . " ");
                $lstprodxid->execute();
                if($lstprodxid->rowCount() > 0){
                    while($lpxi=$lstprodxid->fetch()){
                        $stock_actual = $lpxi["stock_quantity"];
                    }
                    $new_stock = $stock_actual + $cant_prod;
    
                    $update_producto = $pdo->prepare("UPDATE tbl_product SET stock_quantity=? WHERE id=?");
                    if ($update_producto) {
                        $update_producto->execute([$new_stock,$id_prod]);
                    }
                }

                $sqlStatement = $pdo->prepare("INSERT INTO tbl_credit_note_detail (item_description,item_id,item_code, item_name,item_quantity,item_unit_price,credit_note_id) VALUES (?,?,?,?,?,?,?)");
                $sqlStatement->execute([$desc_prod, $id_prod, $cod_prod, $nom_prod, $cant_prod, $prec_prod, $id_facturacion]);
            }
        }
    }
} else {
    echo "ERROR";
}