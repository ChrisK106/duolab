<?php
require '../../global/connection.php';
$query_adic = "";
if(isset($_POST["ESTADO"])){
    $estado = $_POST["ESTADO"];
    $query_adic = " WHERE status=$estado ";
}
$sqlStatement = $pdo->prepare("SELECT * FROM tbl_quotation $query_adic ORDER BY id DESC");
$sqlStatement->execute();
$rowsNumber = $sqlStatement->rowCount();
$DATA = array();
if ($rowsNumber > 0) {
    array_push($DATA, ["id"=>"","text"=>"Seleccione una cotización"]);
    while ($LST = $sqlStatement->fetch()) {
        $ID_COTIZ = $LST["id"];
        $NOM_COTIZ = $LST["number"] . " | ". date("d-m-Y",strtotime($LST["registration_date"]));
        $ROW = [
            "id" => $ID_COTIZ,
            "text" => $NOM_COTIZ
        ];
        array_push($DATA, $ROW);
    }
} else {
    array_push($DATA, ["id"=>"","text"=>"No se han encontrado cotizaciones"]);
}
echo json_encode($DATA);
