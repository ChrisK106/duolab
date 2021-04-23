<?php
require '../../global/connection.php';

$query_adic = "";

if(isset($_POST["ESTADO"])){
    $estado = $_POST["ESTADO"];
    $query_adic = " WHERE status=$estado ";
}

$sqlStatement = $pdo->prepare("SELECT * FROM tbl_receipt $query_adic ORDER BY id DESC");
$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();
$DATA = array();

if ($rowsNumber > 0) {
    array_push($DATA, ["id"=>"","text"=>"Seleccione una boleta"]);
    while ($LST = $sqlStatement->fetch()) {
        $ID_FAC = $LST["id"];
        $NOM_FAC = $LST["series"] . "-" . $LST["number"] . " | ". date("d-m-Y",strtotime($LST["date"]));
        $ROW = [
            "id" => $ID_FAC,
            "text" => $NOM_FAC
        ];
        array_push($DATA, $ROW);
    }
} else {
    array_push($DATA, ["id"=>"","text"=>"No se han encontrado boletas"]);
}

echo json_encode($DATA);