<?php
//phpinfo();
    require("ResponseData.php");
    require("DataTransaction.php");

    $type = $_GET['type'];

    if(isset($type) == true) {
        $dataOp = new DataTransaction();
        $info = $dataOp->test_set_dish_bandwidth($type);
    }

    if($info) {
	    $json = json_encode(array('status' => 'success'));
	}
	else {
	    $json = json_encode(array('status' => 'failed'));
	}

	echo $json;
?>