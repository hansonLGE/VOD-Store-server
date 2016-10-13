<?php
//phpinfo();
    require("ResponseData.php");
    require("DataTransaction.php");

    $dataOp = new DataTransaction();
    $navigationInfo = $dataOp->get_navigation_info();


    if($navigationInfo) {
        $json = json_encode(array('status' => 'success', 'info' => $navigationInfo));
    }
    else {
        $json = json_encode(array('status' => 'failed', 'info' => 'no navigation info'));
    }

    echo $json;
?>