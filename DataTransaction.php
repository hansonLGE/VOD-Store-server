<?php
define ('HOSTNAME', 'localhost'); //数据库主机名 
define ('USERNAME', '*********'); //数据库用户名 
define ('PASSWORD', '*********'); //数据库用户登录密码 
define ('DATABASE_NAME', 'cooking_show'); //需要查询的数据库 

class DataTransaction {
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

    public function get_dishes_info() {
        $con = mysql_connect(HOSTNAME,USERNAME,PASSWORD);
        if(!$con) {
            return null;
        }

        mysql_query("SET NAMES UTF8");

        mysql_select_db(DATABASE_NAME, $con);

        $res = mysql_query("SELECT `id`, `upload_time`, `uploader`, `name`, `type`, `thumbnail_url`, `video_url`, `tips`, `materials`
                            From `cy_dish_base_info` WHERE published = 1");

        $rows = array();

        while ($row=mysql_fetch_array($res)) {
            $data = new ResponseDishInfo();
            $data->dish_id = $row["id"];
            $data->upload_time = $row["upload_time"];
            $data->uploader = $row["uploader"];
            $data->name = $row["name"];
            $data->type = $row["type"];
            $data->thumbnail_url = $row["thumbnail_url"];
            $data->video_url = $row["video_url"];
            $data->tips = $row["tips"];
            $data->materials = $row["materials"];

            $rows[] = $data;
            unset($data);
        }

        mysql_close($con);

        if($rows) {
            return $rows;
        } else {
            return null;
        }
    }

    public function get_navigation_info() {
        $con = mysql_connect(HOSTNAME,USERNAME,PASSWORD);
        if(!$con) {
            return null;
        }

        mysql_query("SET NAMES UTF8");

        mysql_select_db(DATABASE_NAME, $con);

        $res = mysql_query("SELECT `item_id`, `type`, `title`, `en_title`, `code`, `order_num` From `cy_navigation_info`");

        $rows = array();

        while ($row=mysql_fetch_array($res)) {
            $data = new ResponseNavigationInfo();
            $data->item_id = $row["item_id"];
            $data->type = $row["type"];
            $data->title = $row["title"];
            $data->en_title = $row["en_title"];
            $data->code = $row["code"];
            $data->order_num = $row["order_num"];

            $rows[] = $data;
            unset($data);
        }

        mysql_close($con);

        if($rows) {
            return $rows;
        } else {
            return null;
        }
    }

    public function get_top_dishes_info() {
        $con = mysql_connect(HOSTNAME,USERNAME,PASSWORD);
        if(!$con) {
            return null;
        }

        mysql_query("SET NAMES UTF8");

        mysql_select_db(DATABASE_NAME, $con);

        $res = mysql_query("SELECT `a`.`id`, `a`.`uploader`, `a`.`name`, `a`.`thumbnail_url`, `a`.`video_url`, `a`.`tips`, `a`.`materials`
                            From `cy_dish_base_info` AS `a` inner join `cy_dish_activity_info` AS `b`
                            on `a`.id = `b`.dish_id WHERE `a`.published = 1 Order By `b`.view_times Desc limit 0, 12");

        $rows = array();

        while ($row=mysql_fetch_array($res)) {
            $data = new ResponseHomeDishInfo();
            $data->dish_id = $row["id"];
            $data->uploader = $row["uploader"];
            $data->name = $row["name"];
            $data->thumbnail_url = $row["thumbnail_url"];
            $data->video_url = $row["video_url"];
            $data->tips = $row["tips"];
            $data->materials = $row["materials"];

            $rows[] = $data;
            unset($data);
        }

        mysql_close($con);

        if($rows) {
            return $rows;
        } else {
            return null;
        }
    }

    public function get_recommend_dishes_info() {
        $con = mysql_connect(HOSTNAME,USERNAME,PASSWORD);
        if(!$con) {
            return null;
        }

        mysql_query("SET NAMES UTF8");

        mysql_select_db(DATABASE_NAME, $con);

        $res = mysql_query("SELECT `album_id`, `dish_id` From `cy_recommend_info`");

        $rows = array();

        $index = 0;

        while ($row=mysql_fetch_array($res)) {
            $index = $index + 1;
            $data = new ResponseHomeDishInfo();

            if($row["album_id"] == 0) {
                $dish_id = $row["dish_id"];

                $res2 = mysql_query("SELECT `id`, `uploader`, `name`, `thumbnail_url`, `video_url`, `tips`, `materials` From `cy_dish_base_info` WHERE id = '$dish_id' And published = 1");

                if ($row2=mysql_fetch_array($res2)) {
                    $data->dish_id = $row2["id"];
                    $data->uploader = $row2["uploader"];
                    $data->name = $row2["name"];
                    $data->thumbnail_url = $row2["thumbnail_url"];
                    $data->video_url = $row2["video_url"];
                    $data->tips = $row2["tips"];
                    $data->materials = $row2["materials"];                    
                }
            }
            else {
                $album_id = $row["album_id"];

                $res2 = mysql_query("SELECT `uploader`, `name`, `thumbnail_url`, `thumb_vertical_url` From `cy_user_share_video_album` WHERE id = '$album_id'");

                if ($row2=mysql_fetch_array($res2)) {
                    $data->dish_id = $row["album_id"];
                    $data->uploader = $row2["uploader"];
                    $data->name = $row2["name"];

                    if($index == 1) {
                        $data->thumbnail_url = $row2["thumb_vertical_url"];
                    }                       
                    else {
                        $data->thumbnail_url = $row2["thumbnail_url"];
                    }                 
                }
            }

            $rows[] = $data;
            unset($data);
        }

        mysql_close($con);

        if($rows) {
            return $rows;
        } else {
            return null;
        }
    }

    public function get_dish_cook_info($id) {
        $con = mysql_connect(HOSTNAME,USERNAME,PASSWORD);
        if(!$con) {
            return null;
        }

        mysql_query("SET NAMES UTF8");

        mysql_select_db(DATABASE_NAME, $con);

        $res = mysql_query("SELECT `dish_id`, `cook_sn`, `cook_text` From `cy_dish_cook_info` WHERE dish_id = '$id' Order By cook_sn Asc");

        $rows = array();

        while ($row=mysql_fetch_array($res)) {
            $data = new ResponseDishCookInfo();
            $data->dish_id = $row["dish_id"];
            $data->cook_sn = $row["cook_sn"];
            $data->cook_text = $row["cook_text"];

            $rows[] = $data;
            unset($data);
        }

        mysql_close($con);

        if($rows) {
            return $rows;
        } else {
            return null;
        }
    }

    public function get_dish_discuss_info($id) {
        $con = mysql_connect(HOSTNAME,USERNAME,PASSWORD);
        if(!$con) {
            return null;
        }

        mysql_query("SET NAMES UTF8");

        mysql_select_db(DATABASE_NAME, $con);

        $res = mysql_query("SELECT `id`, `dish_id`, `send_time`, `sender`, `receiver`, `content`, `status` From `cy_user_discuss_info` WHERE dish_id = '$id' Order By send_time Desc");

        $rows = array();

        while ($row=mysql_fetch_array($res)) {
            $data = new ResponseDishDiscussInfo();
            $data->discuss_id = $row["id"];
            $data->dish_id = $row["dish_id"];
            $data->send_time = $row["send_time"];
            $data->sender = $row["sender"];
            $data->receiver = $row["receiver"];
            $data->content = $row["content"];
            $data->status = $row["status"];

            $rows[] = $data;
            unset($data);
        }

        mysql_close($con);

        if($rows) {
            return $rows;
        } else {
            return null;
        }
    }

    public function get_share_img_info($id) {
        $con = mysql_connect(HOSTNAME,USERNAME,PASSWORD);
        if(!$con) {
            return null;
        }

        mysql_query("SET NAMES UTF8");

        mysql_select_db(DATABASE_NAME, $con);

        $res = mysql_query("SELECT `id`, `dish_id`, `name`, `upload_time`, `uploader`, `img_url`, `feeling`, `like_times`, `published` From `cy_user_share_img_info` WHERE dish_id = '$id' and published = 1 Order By upload_time Desc");

        $rows = array();

        while ($row=mysql_fetch_array($res)) {
            $data = new ResponseShareImgInfo();
            $data->img_id = $row["id"];
            $data->dish_id = $row["dish_id"];
            $data->dish_name = $row["name"];
            $data->upload_time = $row["upload_time"];
            $data->uploader = $row["uploader"];
            $data->img_url = $row["img_url"];
            $data->feeling = $row["feeling"];
            $data->like_times = $row["like_times"];
            $data->published = $row["published"];
            
            $rows[] = $data;
            unset($data);
        }

        mysql_close($con);

        if($rows) {
            return $rows;
        } else {
            return null;
        }
    }

    public function set_dish_view_times($user, $album, $id) {
        $con = mysql_connect(HOSTNAME,USERNAME,PASSWORD);
        if(!$con) {
            return false;
        }

        mysql_query("SET NAMES UTF8");

        mysql_select_db(DATABASE_NAME, $con);

        mysql_query("BEGIN"); //开始事务

        $res = mysql_query("SELECT `view_times` From `cy_dish_activity_info` WHERE dish_id = '$id'");
        $row = mysql_fetch_array($res);
        if($row){
            $new_view_times = $row['view_times'] + 1;
            $res = mysql_query("UPDATE `cy_dish_activity_info` SET view_times = '$new_view_times' WHERE dish_id = '$id'");
        }
        else {
            $res = mysql_query("INSERT INTO `cy_dish_activity_info`(dish_id) VALUES ('$id')");
        }   
        
        if($album == 0) {
            $res2 = mysql_query("SELECT `view_times` From `cy_user_view_record_info` WHERE device_id = '$user' and dish_id = '$id'");
            $row2 = mysql_fetch_array($res2);
            if($row2) {
                $new_lately_view =  date('Y-m-d H:i:s',time());
                $new_user_view_times = $row2["view_times"] + 1;
                $res2 = mysql_query("UPDATE `cy_user_view_record_info` SET lately_view = '$new_lately_view', view_times = '$new_user_view_times' WHERE device_id = '$user' and dish_id = '$id'");

            }
            else {
                $first_view =  date('Y-m-d H:i:s',time());
                $res2 = mysql_query("INSERT INTO `cy_user_view_record_info`(device_id, album_id, dish_id, first_view, lately_view) VALUES ('$user', '$album', '$id', '$first_view', '$first_view')");
            }        
        }
        else {
            $res2 = mysql_query("SELECT `view_times` From `cy_user_view_record_info` WHERE device_id = '$user' and album_id = '$album'");
            $row2 = mysql_fetch_array($res2);
            if($row2) {
                $new_lately_view =  date('Y-m-d H:i:s',time());
                $res2 = mysql_query("UPDATE `cy_user_view_record_info` SET dish_id = '$id', lately_view = '$new_lately_view', view_times = '$new_view_times' WHERE device_id = '$user' and album_id = '$album'");

            }
            else {
                $first_view =  date('Y-m-d H:i:s',time());
                $res2 = mysql_query("INSERT INTO `cy_user_view_record_info`(device_id, album_id, dish_id, first_view, lately_view) VALUES ('$user', '$album', '$id', '$first_view', '$first_view')");
            }
        }

        if($res && $res2) {
            mysql_query("COMMIT");
        } else {
            mysql_query("ROLLBACK");
        }

        mysql_query("END"); //结束事务

        $res = mysql_query("SELECT `like_times` From `cy_dish_activity_info` WHERE dish_id = '$id'");
        $row = mysql_fetch_array($res);        
        $like_times = $row['like_times'];

        mysql_close($con);

        return $like_times;
    }

    public function _get_default_nickname() {
        $ret = '';
        $str = '123456789abcdefghijkmlnopqrstuvwxyz';
        $len = strlen($str) - 1;
        
        for($i=0; $i<6; $i++) {
            $num = mt_rand(0, $len);
            $ret .= $str[$num];
        }

        return $ret;
    }

    public function set_user_base_info($user, $channel) {
        $con = mysql_connect(HOSTNAME,USERNAME,PASSWORD);
        if(!$con) {
            //echo "failed to connect mysql!";
            return null;
        }

        mysql_query("SET NAMES UTF8");

        mysql_select_db(DATABASE_NAME, $con);

        $res = mysql_query("SELECT `nickname`, `lately_login`, `active_days`, `active_count` From `cy_user_base_info` WHERE device_id = '$user'");
        $row = mysql_fetch_array($res);
        if($row) {
            $nickname = $row["nickname"];
            $new_lately_login =  date('Y-m-d H:i:s',time());

            $old_day = substr($row["lately_login"], 0, 10);
            $new_day = substr($new_lately_login, 0, 10);
            
            if(strcasecmp($old_day, $new_day) != 0) {
                $new_active_days = $row["active_days"] + 1;
            }
            else {
                $new_active_days = $row["active_days"];
            }

            $new_active_count = $row["active_count"] + 1;
            mysql_query("UPDATE `cy_user_base_info` SET channel = '$channel', lately_login = '$new_lately_login', active_days = '$new_active_days', active_count = '$new_active_count' WHERE device_id = '$user'");

        }
        else {
            $nickname = '匿名';
            $nickname .= $this->_get_default_nickname();
            $first_login =  date('Y-m-d H:i:s',time());
            $res = mysql_query("INSERT INTO `cy_user_base_info`(device_id, channel, nickname, first_login, lately_login) VALUES ('$user', '$channel', '$nickname', '$first_login', '$first_login')");
        }

        mysql_close($con);

        return $nickname;
    }

    public function set_user_video_like_times($user, $id) {
        $con = mysql_connect(HOSTNAME,USERNAME,PASSWORD);
        if(!$con) {
            //echo "failed to connect mysql!";
            return -2;
        }

        mysql_query("SET NAMES UTF8");

        mysql_select_db(DATABASE_NAME, $con);

        $res = mysql_query("SELECT `id` From `cy_user_video_like_times` WHERE device_id = '$user' and dish_id = '$id'");
        $row = mysql_fetch_array($res);
        if($row) {
            $ret = 0;

        }
        else {
            mysql_query("BEGIN"); //开始事务

            $res = mysql_query("SELECT `like_times` From `cy_dish_activity_info` WHERE dish_id = '$id'");
            $row = mysql_fetch_array($res);        
            $new_like_times = $row['like_times'] + 1;
            $res = mysql_query("UPDATE `cy_dish_activity_info` SET like_times = '$new_like_times' WHERE dish_id = '$id'");
            $res2 = mysql_query("INSERT INTO `cy_user_video_like_times`(device_id, dish_id) VALUES ('$user', '$id')");

            if($res && $res2) {
                mysql_query("COMMIT");
                $ret = $new_like_times;
                //echo "success to submit!";
            } else {
                mysql_query("ROLLBACK");
                $ret = -1;
            //echo "rollback data!";
            }

            mysql_query("END"); //结束事务
        }

        mysql_close($con);

        return $ret;
    }

    public function set_user_img_like_times($user, $id) {
        $con = mysql_connect(HOSTNAME,USERNAME,PASSWORD);
        if(!$con) {
            //echo "failed to connect mysql!";
            return -2;
        }

        mysql_query("SET NAMES UTF8");

        mysql_select_db(DATABASE_NAME, $con);

        $res = mysql_query("SELECT `id` From `cy_user_img_like_times` WHERE device_id = '$user' and share_img_id = '$id'");
        $row = mysql_fetch_array($res);
        if($row) {
            $ret = 0;

        }
        else {
            mysql_query("BEGIN"); //开始事务

            $res = mysql_query("SELECT `like_times` From `cy_user_share_img_info` WHERE id = '$id'");
            $row = mysql_fetch_array($res);        
            $new_like_times = $row['like_times'] + 1;
            $res = mysql_query("UPDATE `cy_user_share_img_info` SET like_times = '$new_like_times' WHERE id = '$id'");
            $res2 = mysql_query("INSERT INTO `cy_user_img_like_times`(device_id, share_img_id) VALUES ('$user', '$id')");

            if($res && $res2) {
                mysql_query("COMMIT");
                $ret = $new_like_times;
                //echo "success to submit!";
            } else {
                mysql_query("ROLLBACK");
                $ret = -1;
            //echo "rollback data!";
            }

            mysql_query("END"); //结束事务
        }

        mysql_close($con);

        return $ret;
    }

    public function get_user_view_record($user) {
        $con = mysql_connect(HOSTNAME,USERNAME,PASSWORD);
        if(!$con) {
            return null;
        }

        mysql_query("SET NAMES UTF8");

        mysql_select_db(DATABASE_NAME, $con);

        $res = mysql_query("SELECT `album_id`, `dish_id` From `cy_user_view_record_info` WHERE device_id = '$user' Order By lately_view Desc");

        $rows = array();

        while ($row=mysql_fetch_array($res)) {
            $tmp = $row["dish_id"];
            $tmp2 = $row["album_id"];

            if($tmp2 == "0") {
                $res2 = mysql_query("SELECT `a`.`id`, `a`.`uploader`, `a`.`name`, `a`.`thumbnail_url`, `a`.`video_url`, `a`.`tips`, `a`.`materials`, `b`.`view_times`, `b`.`like_times`
                            From `cy_dish_base_info` AS `a` inner join `cy_dish_activity_info` AS `b`
                            on `a`.id = `b`.dish_id WHERE `a`.published = 1 and `a`.id = '$tmp'");

                $row2=mysql_fetch_array($res2);

                $data = new ResponseRecordVideoInfo();
                $data->album_id = $row["album_id"];
                $data->dish_id = $row2["id"];
                $data->uploader = $row2["uploader"];
                $data->name = $row2["name"];
                $data->thumbnail_url = $row2["thumbnail_url"];
                $data->video_url = $row2["video_url"];
                $data->tips = $row2["tips"];
                $data->materials = $row2["materials"];
                $data->view_times = $row2["view_times"];
                $data->like_times = $row2["like_times"];
            
                $rows[] = $data;
                unset($data);
            }
            else {
                $res2 = mysql_query("SELECT `uploader`, `name`, `thumbnail_url` From `cy_user_share_video_album` WHERE id = '$tmp2'");
                $res3 = mysql_query("SELECT `name`, `video_url` From `cy_user_share_video_info` WHERE id = '$tmp'");
                $res4 = mysql_query("SELECT `view_times`, `like_times` From `cy_dish_activity_info` WHERE dish_id = '$tmp'");

                $row2=mysql_fetch_array($res2);
                $row3=mysql_fetch_array($res3);
                $row4=mysql_fetch_array($res4);

                $data = new ResponseRecordVideoInfo();
                $data->album_id = $row["album_id"];
                $data->dish_id = $row["dish_id"];
                $data->uploader = $row2["uploader"];
                $data->name = $row3["name"];
                $data->thumbnail_url = $row2["thumbnail_url"];
                $data->video_url = $row3["video_url"];
                $data->tips = $row2["name"];
                $data->materials = "";
                $data->view_times = $row4["view_times"];
                $data->like_times = $row4["like_times"];
            
                $rows[] = $data;
                unset($data);
            }

        }

        mysql_close($con);

        if($rows) {
            return $rows;
        } else {
            return null;
        }
    }
/*
    public function get_my_share_video_info($user_account) {
        $con = mysql_connect(HOSTNAME,USERNAME,PASSWORD);
        if(!$con) {
            return null;
        }

        mysql_query("SET NAMES UTF8");

        mysql_select_db(DATABASE_NAME, $con);

        $res = mysql_query("SELECT `id`, `upload_time`, `uploader`, `name`, `thumbnail_url`, `video_url`, `published` From `cy_user_share_video_info` WHERE uploader = '$user_account' Order By id Desc");

        $rows = array();

        while ($row=mysql_fetch_array($res)) {
            $data = new ResponseShareVideolInfo();
            $data->share_id = $row["id"];
            $data->upload_time = $row["upload_time"];
            $data->uploader = $row["uploader"];
            $data->name = $row["name"];
            $data->thumbnail_url = $row["thumbnail_url"];
            $data->video_url = $row["video_url"];
            $data->published = $row["published"];
            
            $res2 = mysql_query("SELECT `view_times` From `cy_dish_activity_info` WHERE dish_id = '$id'");
            $row2 = mysql_fetch_array($res2);
            if($row2) {
                $data->view_times = $row['view_times'];
            }
            else {
                $data->view_times = "0";
            }

            $rows[] = $data;
            unset($data);
        }

        mysql_close($con);

        if($rows) {
            return $rows;
        } else {
            return null;
        }
    }
*/
    public function get_my_share_img_info($user_account) {
        $con = mysql_connect(HOSTNAME,USERNAME,PASSWORD);
        if(!$con) {
            return null;
        }

        mysql_query("SET NAMES UTF8");

        mysql_select_db(DATABASE_NAME, $con);

        $res = mysql_query("SELECT `id`, `dish_id`, `name`, `upload_time`, `uploader`, `img_url`, `feeling`, `like_times`, `published` From `cy_user_share_img_info` WHERE uploader = '$user_account' Order By upload_time Desc");

        $rows = array();

        while ($row=mysql_fetch_array($res)) {
            $data = new ResponseShareImgInfo();
            $data->img_id = $row["id"];
            $data->dish_id = $row["dish_id"];
            $data->dish_name = $row["name"];
            $data->upload_time = $row["upload_time"];
            $data->uploader = $row["uploader"];
            $data->img_url = $row["img_url"];
            $data->feeling = $row["feeling"];
            $data->like_times = $row["like_times"];
            $data->published = $row["published"];
            
            $rows[] = $data;
            unset($data);
        }

        mysql_close($con);

        if($rows) {
            return $rows;
        } else {
            return null;
        }
    }

    public function get_share_video_album_info() {
        $con = mysql_connect(HOSTNAME,USERNAME,PASSWORD);
        if(!$con) {
            return null;
        }

        mysql_query("SET NAMES UTF8");

        mysql_select_db(DATABASE_NAME, $con);

        $res = mysql_query("SELECT `id`, `uploader`, `name`, `thumbnail_url`, `upload_time` From `cy_user_share_video_album`");

        $rows = array();

        while ($row=mysql_fetch_array($res)) {
            $data = new ResponseShareVideoAlbumInfo();
            $data->album_id = $row["id"];
            $data->uploader = $row["uploader"];
            $data->name = $row["name"];
            $data->thumbnail_url = $row["thumbnail_url"];
            $data->upload_time = $row["upload_time"];

            $rows[] = $data;
            unset($data);
        }

        mysql_close($con);

        if($rows) {
            return $rows;
        } else {
            return null;
        }
    }

    public function get_share_video_info($id) {
        $con = mysql_connect(HOSTNAME,USERNAME,PASSWORD);
        if(!$con) {
            return null;
        }

        mysql_query("SET NAMES UTF8");

        mysql_select_db(DATABASE_NAME, $con);

        $res = mysql_query("SELECT `id`, `upload_time`, `uploader`, `name`, `thumbnail_url`, `video_url`, `published` From `cy_user_share_video_info` WHERE album_id = '$id' Order By id Desc");

        $rows = array();

        while ($row=mysql_fetch_array($res)) {
            $data = new ResponseShareVideolInfo();
            $data->share_id = $row["id"];
            $data->upload_time = $row["upload_time"];
            $data->uploader = $row["uploader"];
            $data->name = $row["name"];
            $data->thumbnail_url = $row["thumbnail_url"];
            $data->video_url = $row["video_url"];
            $data->published = $row["published"];

            $rows[] = $data;
            unset($data);
        }

        mysql_close($con);

        if($rows) {
            return $rows;
        } else {
            return null;
        }
    }

    public function get_user_coin($user) {
        $con = mysql_connect(HOSTNAME,USERNAME,PASSWORD);
        if(!$con) {
            return 0;
        }

        mysql_query("SET NAMES UTF8");

        mysql_select_db(DATABASE_NAME, $con);

        $ret = 0;

        $res = mysql_query("SELECT `active_days` From `cy_user_base_info` WHERE device_id = '$user'");
        $row = mysql_fetch_array($res);
        if($row) {
            $ret = $row["active_days"];
        }

        mysql_close($con);

        return $ret;
    }


    public function test_set_dish_activity_info($id, $count) {
        $con = mysql_connect(HOSTNAME,USERNAME,PASSWORD);
        if(!$con) {
            //echo "failed to connect mysql!";
            return false;
        }

        mysql_query("SET NAMES UTF8");

        mysql_select_db(DATABASE_NAME, $con);

        $tmp = $id;

        for($i = 0; $i < $count; $i++) {
            mysql_query("INSERT INTO `cy_dish_activity_info`(dish_id) VALUES ('$tmp')");

            $tmp = $tmp + 1;
        } 


        mysql_close($con);

        return true;
    }
	
    public function test_set_dish_bandwidth($type) {
        $con = mysql_connect(HOSTNAME,USERNAME,PASSWORD);
        if(!$con) {
            //echo "failed to connect mysql!";
            return false;
        }

        mysql_query("SET NAMES UTF8");

        mysql_select_db(DATABASE_NAME, $con);

        $res = mysql_query("SELECT `id`, `video_url` From `cy_dish_base_info` WHERE type = '$type'");

        $rows = array();

        while ($row=mysql_fetch_array($res)) {
			$id = $row["id"];
			$tmp = str_replace("2000", "850", $row["video_url"]);
			
			mysql_query("UPDATE `cy_dish_base_info` SET video_url = '$tmp' WHERE id = '$id'");
			
            echo $tmp;
        }


        mysql_close($con);

        return true;
    }
}

?>