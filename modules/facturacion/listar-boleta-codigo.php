<?php
    require '../../global/connection.php';
    $LSTMAXID = $pdo->prepare("SELECT MAX(id) AS MAXID FROM tbl_receipt ORDER BY id DESC");
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