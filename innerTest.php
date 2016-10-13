<?php
//phpinfo();
    require("ResponseData.php");
    require("DataTransaction.php");

    $id = $_GET['id'];
    $count = $_GET['count'];

    if(isset($id) == true && isset($count) == true) {
        $dataOp = new DataTransaction();
        $info = $dataOp->test_set_dish_activity_info($id, $count);
    }

    if($info) {
	    $json = json_encode(array('status' => 'success'));
	}
	else {
	    $json = json_encode(array('status' => 'failed'));
	}

	echo $json;
?>