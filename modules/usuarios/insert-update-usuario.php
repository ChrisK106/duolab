<?php

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    require '../../global/connection.php';

    $u_usuario = trim($_POST['usuario_nombre']);
    $u_password = trim($_POST['usuario_pass']);
    $u_empid = $_POST['usuario_empleado_id'];

    $u_fecreg = date("Y-m-d H:i:s");

    $u_iduser = $_POST['usuario_id'];

    if ($u_iduser == "" || $u_iduser == null) {
        $sqlStatement = $pdo->prepare("SELECT * FROM tbl_user WHERE username=:usuario");
        $sqlStatement->bindParam("usuario", $u_usuario, PDO::PARAM_STR);
    } else {
        $sqlStatement = $pdo->prepare("SELECT * FROM tbl_user WHERE (username=:usuario) AND (id <> :iduser)");
         $sqlStatement->bindParam("usuario", $u_usuario, PDO::PARAM_STR);
        $sqlStatement->bindParam("iduser", $u_iduser, PDO::PARAM_INT);
    }

    $sqlStatement->execute();
    $rowsNumber = $sqlStatement->rowCount();
    if ($rowsNumber == 0) {

        if (!$u_password == "" || !$u_password == null){
            $hashedPassword = password_hash($u_password, PASSWORD_DEFAULT);
        }

        if ($u_iduser == "" || $u_iduser == null) {
            $sqlStatement = $pdo->prepare("INSERT INTO tbl_user(username,password,employee_id,registration_date) VALUES(?,?,?,?)");
            if ($sqlStatement) {
                $sqlStatement->execute([$u_usuario,$hashedPassword,$u_empid,$u_fecreg]);
                echo "OK_INSERT";
            } else {
                echo "ERROR";
            }
        } else {

            if ($u_password == "" || $u_password == null) {
                $sqlStatement = $pdo->prepare("UPDATE tbl_user SET username=?,employee_id=? WHERE id=?");
                $sqlParameters=[$u_usuario,$u_empid,$u_iduser];
            }else{
                $sqlStatement = $pdo->prepare("UPDATE tbl_user SET username=?,password=?,employee_id=? WHERE id=?");
                $sqlParameters=[$u_usuario,$hashedPassword,$u_empid,$u_iduser];
            }
            if ($sqlStatement) {
                $sqlStatement->execute($sqlParameters);
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