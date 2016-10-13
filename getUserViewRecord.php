<?php
//phpinfo();
    require("ResponseData.php");
    require("DataTransaction.php");

    $user = $_GET['user'];

    if(isset($user) == true) {
        $dataOp = new DataTransaction();
        $viewInfo = $dataOp->get_user_view_record($user);
    }

    if($viewInfo) {
	    $json = json_encode(array('status' => 'success', 'info' => $viewInfo));
	}
	else {
	    $json = json_encode(array('status' => 'failed', 'message' => 'no view record'));
	}

	echo $json;
?>