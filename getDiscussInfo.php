<?php
//phpinfo();
    require("ResponseData.php");
    require("DataTransaction.php");

    $dishId = $_GET['dish_id'];

    if(isset($dishId) == true) {
        $dataOp = new DataTransaction();
        $discussInfo = $dataOp->get_dish_discuss_info($dishId);
    }

    if($discussInfo) {
	    $json = json_encode(array('status' => 'success', 'info' => $discussInfo));
	}
	else {
	    $json = json_encode(array('status' => 'failed', 'message' => 'no discuss info'));
	}

	echo $json;
?>