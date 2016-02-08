<?php

class STAT extends BaseController {

    function stat_update_batch(){
        $this->view->set('title','PostBox - Running stat update');
        $data_pull_messages = array();
        $post_count = 0;
        $user_count = 0;
        $POSTBOX_DB=\F3::get('POSTBOX_DB');
        $data_pull_messages[] = "START of stat update process";

        #updating stats table
        $q = 'select count(post_id) as post_count from post_box';
        $result = $POSTBOX_DB->exec($q);
        foreach ($result as $row){
            $post_count = $row["post_count"];         
        }

        $q = 'select count(distinct username) as user_count from post_box';
        $result = $POSTBOX_DB->exec($q);
        foreach ($result as $row){
            $user_count = $row["user_count"];         
        }

        $q = 'insert into stats(post_count,user_count) values ('.$post_count.','. $user_count.')';
        $data_pull_messages[] = "inserting values";
        $POSTBOX_DB->exec($q);

        $data_pull_messages[] = "Working on pincodes now";


        #update pincode table
        $q = 'select distinct pincode from post_box where pincode is not null and pincode !="" ';
        $result = $POSTBOX_DB->exec($q);
        $db_pincode = array();
        foreach ($result as $row){ 
            $p = $row["pincode"];
            $db_pincode[] = $p;
        }

        $new_pincode = array();
        foreach($db_pincode as $row){
            $q = 'select count(pincode) as pincode_exists from pin_code where pincode='.$row;
            $result1 = $POSTBOX_DB->exec($q);
            foreach ($result1 as $row1){
                $pincode_exists = $row1["pincode_exists"];
                $data_pull_messages[] = "pincode count= ".$pincode_exists;
                if ($pincode_exists > 0)  {
                    $data_pull_messages[] = "exists pincode= ".$row;
                }else{
                    $new_pincode[] = $row;
                    $data_pull_messages[] = "new pincode= ".$row;
                }    
            }        
        }


        //insert new pincodes
        foreach($new_pincode as $row){
            $POSTBOX_DB=\F3::get('POSTBOX_DB');
            $q = 'insert into pin_code(pincode,total_post_boxes) values( :pincode  , :total_post_boxes)';
            $data_pull_messages[] = "inserting pincode= ".$row;
            $POSTBOX_DB->exec($q,array(':pincode' => $row, ':total_post_boxes' =>0));
        }


        //update count
        $q = "select  pincode, count(pincode) as pincode_count, lat, lan   from post_box group by pincode";
        $result2 = $POSTBOX_DB->exec($q);
        $update_array_pin = array();
        $update_array_count = array();
        $update_array_lat = array();
        $update_array_lan = array();

        foreach ($result2 as $row2){
            $update_array_pin[]   = $row2['pincode'];
            $update_array_count[] = $row2['pincode_count'];
            $update_array_lat[] = $row2['lat'];
            $update_array_lan[] = $row2['lan'];

        }
        $update_array = array_map(null, $update_array_pin, $update_array_count,$update_array_lat, $update_array_lan);
        foreach ($update_array as $row3){
            //var_dump($update_array);
            $data_pull_messages[] = "stat update pin= ".$row3[0];
            $data_pull_messages[] = "stat update count= ".$row3[1];
            $q = 'update pin_code set total_post_boxes=:total_post_boxes, center_lat=:center_lat, center_long=:center_long  where pincode=:pin';
            $POSTBOX_DB->exec($q,array(':total_post_boxes' => $row3[1], ':pin' =>$row3[0],':center_lat' =>$row3[2],':center_long' =>$row3[3]));
        }

        //make one of the postboxes as center point for pincode
        $data_pull_messages[] = "END of stat update process";
        $this->view->set('data_pull_messages',$data_pull_messages);
        $out=Template::instance()->render('basic/sub_data_pull.html');
        $this->view->set('sub_out_put',$out);
        echo Template::instance()->render('basic/main.html');
    }

}

?>
