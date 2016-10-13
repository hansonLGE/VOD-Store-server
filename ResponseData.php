<?php

Class ResponseData {
    public $status;
    public $message;
    public $user;

    function __construct() {
        
    }
    
    function __destruct() {
        
    }
    
    public function __get($name) {
        return $this->$name;
    }
    
    public function __set($name, $value) {
        $this->$name = $value;
    }

}

Class ResponseDishInfo {
    public $dish_id;
    public $upload_time;
    public $uploader;
    public $name;
    public $type;
    public $thumbnail_url;
    public $video_url;
    public $tips;
    public $materials;

    function __construct() {
        
    }
    
    function __destruct() {
        
    }
    
    public function __get($name) {
        return $this->$name;
    }
    
    public function __set($name, $value) {
        $this->$name = $value;
    }

}

Class ResponseHomeDishInfo {
    public $dish_id;
    public $uploader;
    public $name;
    public $thumbnail_url;
    public $video_url;
    public $tips;
    public $materials;

    function __construct() {
        
    }
    
    function __destruct() {
        
    }
    
    public function __get($name) {
        return $this->$name;
    }
    
    public function __set($name, $value) {
        $this->$name = $value;
    }

}

Class ResponseNavigationInfo {
    public $item_id;
    public $type;
    public $title;
    public $en_title;
    public $code;
    public $order_num;

    function __construct() {
        
    }

    function __destruct() {
        
    }
    
    public function __get($name) {
        return $this->$name;
    }
    
    public function __set($name, $value) {
        $this->$name = $value;
    }

}

Class ResponseDishCookInfo {
    public $dish_id;
    public $cook_sn;
    public $cook_text;

    function __construct() {
        
    }
    
    function __destruct() {
        
    }
    
    public function __get($name) {
        return $this->$name;
    }
    
    public function __set($name, $value) {
        $this->$name = $value;
    }

}

Class ResponseDishDiscussInfo {
    public $discuss_id;
    public $dish_id;
    public $send_time;
    public $sender;
    public $receiver;
    public $content;
    public $status;

    function __construct() {
        
    }
    
    function __destruct() {
        
    }
    
    public function __get($name) {
        return $this->$name;
    }
    
    public function __set($name, $value) {
        $this->$name = $value;
    }

}

Class ResponseShareImgInfo {
    public $img_id;
    public $dish_id;
    public $dish_name;
    public $upload_time;
    public $uploader;
    public $img_url;
    public $feeling;
    public $like_times;
    public $published;

    function __construct() {
        
    }
    
    function __destruct() {
        
    }
    
    public function __get($name) {
        return $this->$name;
    }
    
    public function __set($name, $value) {
        $this->$name = $value;
    }

}

Class ResponseRecordVideoInfo {
    public $album_id;
    public $dish_id;
    public $uploader;
    public $name;
    public $thumbnail_url;
    public $video_url;
    public $tips;
    public $materials;
    public $view_times;
    public $like_times;

    function __construct() {
        
    }
    
    function __destruct() {
        
    }
    
    public function __get($name) {
        return $this->$name;
    }
    
    public function __set($name, $value) {
        $this->$name = $value;
    }

}

Class ResponseShareVideolInfo {
    public $share_id;
    public $upload_time;
    public $uploader;
    public $name;
    public $thumbnail_url;
    public $video_url;
    public $published;

    function __construct() {
        
    }
    
    function __destruct() {
        
    }
    
    public function __get($name) {
        return $this->$name;
    }
    
    public function __set($name, $value) {
        $this->$name = $value;
    }

}

Class ResponseShareVideoAlbumInfo {
    public $album_id;
    public $uploader;
    public $name;
    public $thumbnail_url;
    public $upload_time;

    function __construct() {
        
    }

    function __destruct() {
        
    }
    
    public function __get($name) {
        return $this->$name;
    }
    
    public function __set($name, $value) {
        $this->$name = $value;
    }

}

?>