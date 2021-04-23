<?php
    require '../../global/connection.php';

    $tipoDoc = $_POST["TIPO_DOC"];
    $serie = $_POST["SERIE"];

    if ($serie == "DEFAULT"){
        if ($tipoDoc == "INVOICE") $serie="F001";
        if ($tipoDoc == "RECEIPT") $serie="B001";
        if ($tipoDoc == "CREDIT_NOTE") $serie="FNC1";     
    }

    $table = "";

    if ($tipoDoc == "INVOICE"){
        $table = "tbl_invoice";
    }else if($tipoDoc == "RECEIPT"){
        $table = "tbl_receipt";
    }else if($tipoDoc == "CREDIT_NOTE"){
        $table = "tbl_credit_note";
    }else{
        echo false;
        return;
    }

    $LSTMAXID = $pdo->prepare("SELECT CONVERT(MAX(number),UNSIGNED) AS MAXID FROM " . $table . " WHERE series=:SERIE ORDER BY id DESC");
    $LSTMAXID->bindParam(":SERIE", $serie, PDO::PARAM_STR);
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

    switch ($NEXT_ID) {
        case ($NEXT_ID < 10):
            $NEXT_ID = "000000" . $NEXT_ID;
            break;
        case ($NEXT_ID < 100):
            $NEXT_ID = "00000" . $NEXT_ID;
            break;
        case ($NEXT_ID < 1000):
            $NEXT_ID = "0000" . $NEXT_ID;
            break;
        case ($NEXT_ID < 10000):
            $NEXT_ID = "000" . $NEXT_ID;
            break;
        case ($NEXT_ID < 100000):
            $NEXT_ID = "00" . $NEXT_ID;
            break;
        case ($NEXT_ID < 1000000):
            $NEXT_ID = "0" . $NEXT_ID;
            break;
        case ($NEXT_ID < 10000000):
            $NEXT_ID = $NEXT_ID;
            break;
    }

    echo $NEXT_ID;
?>