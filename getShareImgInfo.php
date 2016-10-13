<?php
//phpinfo();
    require("ResponseData.php");
    require("DataTransaction.php");

    $type = $_GET['type'];

    if(isset($type) == true) {
        $dataOp = new DataTransaction();

        if($type == 'dish') {
            $dishId = $_GET['dish_id'];
            if(isset($dishId) == true) {
                $shareImgInfo = $dataOp->get_share_img_info($dishId);
            }
        }
        else if($type == 'user') {
            $account = $_GET['user_account'];
            if(isset($account) == true) {
                $shareImgInfo = $dataOp->get_my_share_img_info($account);
            }
        }
    }

    if($shareImgInfo) {
	    $json = json_encode(array('status' => 'success', 'info' => $shareImgInfo));
	}
	else {
	    $json = json_encode(array('status' => 'failed', 'message' => 'no share img info'));
	}

	echo $json;
?>