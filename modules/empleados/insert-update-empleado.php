<?php

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    require '../../global/connection.php';

    $e_nombres = trim($_POST['empleado_nombres']);
    $e_apepat = trim($_POST['empleado_apepat']);
    $e_apemat = trim($_POST['empleado_apemat']);
    $e_direccion = trim($_POST['empleado_direccion']);
    $e_tipodoc = $_POST['empleado_tipodoc'];
    $e_numdoc = trim($_POST['empleado_numdoc']);
    $e_estadociv = $_POST['empleado_estado_civ'];
    $e_fecnac = date("Y-m-d", strtotime($_POST['empleado_fecnac']));
    $e_cargo = $_POST['empleado_cargo'];
    $e_fecing = date("Y-m-d", strtotime($_POST['empleado_fecing']));
    $e_telefono = trim($_POST['empleado_telefono']);
    $e_correo = trim($_POST['empleado_correo']);
    $e_gradoest = $_POST['empleado_grado_est'];
    $e_carrera = trim($_POST['empleado_carrera']);

    //$c_celcont_2 = $_POST['cliente_celcont_2'] == "" ? "ninguno" : $_POST['cliente_celcont_2'];
    //$c_pagcomi = !$_POST['cliente_pagocomision'] ? 0 : $_POST['cliente_pagocomision'];

    $e_idemp = $_POST['empleado_id'];

    if ($e_idemp == "" || $e_idemp == null) {
        $sqlStatement = $pdo->prepare("SELECT * FROM tbl_employee WHERE id_doc_number=:id_doc_number");
        $sqlStatement->bindParam("id_doc_number", $e_numdoc, PDO::PARAM_STR);
    } else {
        $sqlStatement = $pdo->prepare("SELECT * FROM tbl_employee WHERE (id_doc_number=:id_doc_number) AND (id <> :idemp)");
        $sqlStatement->bindParam("id_doc_number", $e_numdoc, PDO::PARAM_STR);
        $sqlStatement->bindParam("idemp", $e_idemp, PDO::PARAM_INT);
    }

    $sqlStatement->execute();
    $rowsNumber = $sqlStatement->rowCount();
    if ($rowsNumber == 0) {
        if ($e_idemp == "" || $e_idemp == null) {
            $sqlStatement = $pdo->prepare("INSERT INTO tbl_employee (name,last_name_1,last_name_2,id_doc_type,id_doc_number,civil_status,email,phone,address,job,study_level,study_career,birth_date,admission_date) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            if ($sqlStatement) {
                $sqlStatement->execute([$e_nombres,$e_apepat,$e_apemat,$e_tipodoc,$e_numdoc,$e_estadociv,$e_correo,$e_telefono,$e_direccion,$e_cargo,$e_gradoest,$e_carrera,$e_fecnac,$e_fecing]);
                echo "OK_INSERT";
            } else {
                echo "ERROR";
            }
        } else {
            $sqlStatement = $pdo->prepare("UPDATE tbl_employee SET name=?,last_name_1=?,last_name_2=?,id_doc_type=?,id_doc_number=?,civil_status=?,email=?,phone=?,address=?,job=?,study_level=?,study_career=?,birth_date=?,admission_date=? WHERE id=?");
            if ($sqlStatement) {
                $sqlStatement->execute([$e_nombres,$e_apepat,$e_apemat,$e_tipodoc,$e_numdoc,$e_estadociv,$e_correo,$e_telefono,$e_direccion,$e_cargo,$e_gradoest,$e_carrera,$e_fecnac,$e_fecing,$e_idemp]);
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
