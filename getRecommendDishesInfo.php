<?php
//phpinfo();
    require("ResponseData.php");
    require("DataTransaction.php");

    $dataOp = new DataTransaction();
    $dishesInfo = $dataOp->get_recommend_dishes_info();


    if($dishesInfo) {
        $json = json_encode(array('status' => 'success', 'info' => $dishesInfo));
    }
    else {
        $json = json_encode(array('status' => 'failed', 'info' => 'no recommend dishes'));
    }

    echo $json;
?>