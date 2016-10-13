<?php
//phpinfo();
    require("ResponseData.php");
    require("DataTransaction.php");

    $type = $_GET['type'];

    if(isset($type) == true) {
        $dataOp = new DataTransaction();

        if($type == 'setViewTimes') {
            $user = $_GET['user'];
            $albumId = $_GET['album_id'];
            $dishId = $_GET['dish_id'];
            if(isset($user) == true && isset($dishId) == true) {
                $ret = $dataOp->set_dish_view_times($user, $albumId, $dishId);
            }
        } 
        else if($type == 'setActiveDays') {
            $user = $_GET['user'];
            $channel = $_GET['channel'];
            if(isset($user) == true && isset($channel) == true) {
                $ret = $dataOp->set_user_base_info($user, $channel);
            }   
        }
        else if($type == 'setVideoLikeTimes') {
            $user = $_GET['user'];
            $dishId = $_GET['dish_id'];
            if(isset($user) == true && isset($dishId) == true) {
                $ret = $dataOp->set_user_video_like_times($user, $dishId);
            }   
        }
        else if($type == 'setImgLikeTimes') {
            $user = $_GET['user'];
            $imgId = $_GET['img_id'];
            if(isset($user) == true && isset($imgId) == true) {
                $ret = $dataOp->set_user_img_like_times($user, $imgId);
            }   
        }
    }

    echo $ret;
?>