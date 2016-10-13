<?php
//phpinfo();
    require("ResponseData.php");
    require("DataTransaction.php");

    $user = $_GET['user'];
    $type = $_GET['type'];

    if(isset($user) == true && isset($type) == true) {
        $dataOp = new DataTransaction();
		
		if($type == 'coin') {
			$info = $dataOp->get_user_coin($user);
		}
        
    }

	echo $info;
?>