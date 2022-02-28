<?php

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    require '../../global/connection.php';

    session_start();
  
    $tipo = $_POST['mov_tipo'];
    $prod = $_POST['mov_prod_code'];
    $guia_orden = trim($_POST['mov_guia_orden']);
    $prov = $_POST['mov_prov'];
    $fec_venc = $_POST['mov_fec_venc'];
    $obs = trim($_POST['mov_obs']);
    $cant = $_POST['mov_cantidad'];
    $user_id = $_SESSION['loggedInUser']['USERID'];

    $mov_type = 0;
    $sqlStatement = "";
    $stock_actual = 0;

    if ($tipo == "Ingreso"){
        $mov_type = 1;
    }else if($tipo == "Ajuste"){
        $mov_type = 2;
    }else{
        echo "ERROR";
        return;
    }
    
    // INGRESO ALMACÉN
    if ($mov_type == 1){
        $sqlStatement = $pdo->prepare("INSERT INTO tbl_warehouse_movement(type,product_id,quantity,observation,provider_id,doc_reference,expiration_date,user_id) VALUES(?,?,?,?,?,?,?,?)");
    // AJUSTE DE STOCK
    }else if ($mov_type == 2){
        $sqlStatement = $pdo->prepare("INSERT INTO tbl_warehouse_movement(type,product_id,quantity,observation,user_id) VALUES(?,?,?,?,?)");
    }

    if ($sqlStatement) {
        // INGRESO ALMACÉN
        if ($mov_type == 1){
            $sqlStatement->execute([$mov_type,$prod,$cant,$obs,$prov,$guia_orden,$fec_venc,$user_id]);
        // AJUSTE DE STOCK
        }else if ($mov_type == 2){
            $sqlStatement->execute([$mov_type,$prod,$cant,$obs,$user_id]);
        }

        // ACTUALIZAR STOCK PRODUCTO
        $sqlStatement = $pdo->prepare("SELECT * FROM tbl_product WHERE id=" . $prod . " ");
        $sqlStatement->execute();
        if($sqlStatement->rowCount() > 0){
            while($statementItem=$sqlStatement->fetch()){
                $stock_actual = $statementItem["stock_quantity"];
            }
            $new_stock = $stock_actual + $cant;

            $update_producto = $pdo->prepare("UPDATE tbl_product SET stock_quantity=? WHERE id=?");
            if ($update_producto) {
                $update_producto->execute([$new_stock,$prod]);
            }else{
                echo "ERROR";
            }
        }else{
            echo "ERROR";
        }

        echo "OK_INSERT";
    } else {
        echo "ERROR";
    }
    
} else {
    echo "ERROR";
}
