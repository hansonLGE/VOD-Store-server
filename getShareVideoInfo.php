<?php
//phpinfo();
    require("ResponseData.php");
    require("DataTransaction.php");

    $type = $_GET['type'];

    if(isset($type) == true) {
        $dataOp = new DataTransaction();

        if($type == 'album') {
            $videoInfo = $dataOp->get_share_video_album_info();
        }
        else if($type == 'detail_album') {
            $albumId = $_GET['album_id'];
            if(isset($albumId) == true) {
                $videoInfo = $dataOp->get_share_video_info($albumId);
            }
            
        }
       /* else if($type = 'user_album') {
            $userAlbum = $_GET['user_album'];
            if(isset($userAlbum) == true) {
                $videoInfo = $dataOp->get_share_video_info($userAlbum);
            }
            
        }*/
    }

    if($videoInfo) {
        $json = json_encode(array('status' => 'success', 'info' => $videoInfo));
    }
    else {
        $json = json_encode(array('status' => 'failed', 'info' => 'no info'));
    }

    echo $json;
?>