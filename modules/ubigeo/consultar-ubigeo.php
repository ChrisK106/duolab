<?php
require '../../global/connection.php';
$MODO_UBIGEO = $_POST["MODE_UBIGEO"];
$RETURN = "";
switch ($MODO_UBIGEO) {
    case 'DEPARTMENTS':
        $sqlStatement = $pdo->prepare("SELECT * FROM ubigeo_peru_departments");
        $sqlStatement->execute();
        $rowsNumber = $sqlStatement->rowCount();
        $DATA = array();

        if ($rowsNumber > 0) {
            while ($LST = $sqlStatement->fetch()) {
                $ID_DEPA = $LST["id"];
                $NOM_DEPA = $LST["name"];
                $ROW = [
                    "id" => $ID_DEPA,
                    "text" => $NOM_DEPA
                ];
                array_push($DATA, $ROW);
            }
        }

        $RETURN = json_encode($DATA);
        break;

    case 'PROVINCES':
        $ID_DEPARTMENT = $_POST["ID_DEPART"];
        $sqlStatement = $pdo->prepare("SELECT * FROM ubigeo_peru_provinces WHERE department_id=:IDDEP");
        $sqlStatement->bindParam("IDDEP", $ID_DEPARTMENT, PDO::PARAM_STR);
        $sqlStatement->execute();
        $rowsNumber = $sqlStatement->rowCount();
        $DATA = array();

        if ($rowsNumber > 0) {
            array_push($DATA, ["id"=>"","text"=>"Seleccione una provincia"]);
            while ($LST = $sqlStatement->fetch()) {
                $ID_PROV = $LST["id"];
                $NOM_PROV = $LST["name"];
                $ROW = [
                    "id" => $ID_PROV,
                    "text" => $NOM_PROV
                ];
                array_push($DATA, $ROW);
            }
        }

        $RETURN = json_encode($DATA);
        break;

    case 'DISTRICTS':
        $ID_PROV = $_POST["ID_PROV"];
        $sqlStatement = $pdo->prepare("SELECT * FROM ubigeo_peru_districts WHERE province_id=:IDPROV");
        $sqlStatement->bindParam("IDPROV", $ID_PROV, PDO::PARAM_STR);
        $sqlStatement->execute();
        $rowsNumber = $sqlStatement->rowCount();
        $DATA = array();

        if ($rowsNumber > 0) {
            array_push($DATA, ["id"=>"","text"=>"Seleccione un distrito"]);
            while ($LST = $sqlStatement->fetch()) {
                $ID_DIST = $LST["id"];
                $NOM_DIST = $LST["name"];
                $ROW = [
                    "id" => $ID_DIST,
                    "text" => $NOM_DIST
                ];
                array_push($DATA, $ROW);
            }
        }

        $RETURN = json_encode($DATA);
        break;
        
}
echo $RETURN;
