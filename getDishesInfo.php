<?php
//phpinfo();
    require("ResponseData.php");
    require("DataTransaction.php");

    $dataOp = new DataTransaction();
    $dishesBaseInfo = $dataOp->get_dishes_info();


    if($dishesBaseInfo) {
        $json = json_encode(array('status' => 'success', 'info' => $dishesBaseInfo));
    }
    else {
        $json = json_encode(array('status' => 'failed', 'info' => 'no dishes'));
    }

    echo $json;
?>