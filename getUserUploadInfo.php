<?php
//phpinfo();
    require("ResponseData.php");
    require("DataTransaction.php");

    $account = $_GET['user_account'];

    if(isset($account) == true) {
        $dataOp = new DataTransaction();
        $uploadInfo = $dataOp->get_my_share_video_info($account);
    }

    if($uploadInfo) {
	    $json = json_encode(array('status' => 'success', 'info' => $uploadInfo));
	}
	else {
	    $json = json_encode(array('status' => 'failed', 'message' => 'no upload record'));
	}

	echo $json;
?>