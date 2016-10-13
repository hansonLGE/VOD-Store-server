<?php
//phpinfo();
    require("ResponseData.php");
    require("DataTransaction.php");

    $dishId = $_GET['dish_id'];

    if(isset($dishId) == true) {
        $dataOp = new DataTransaction();
        $cookInfo = $dataOp->get_dish_cook_info($dishId);
    }

    if($cookInfo) {
	    $json = json_encode(array('status' => 'success', 'info' => $cookInfo));
	}
	else {
	    $json = json_encode(array('status' => 'failed', 'message' => 'no cook step'));
	}

	echo $json;
?>