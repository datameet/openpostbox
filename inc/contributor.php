<?php
class Contributor extends F3instance {
    function listContributors() {
        $q = 'SELECT distinct username, count(*) as post_box_count FROM post_box group by username';
        $POSTBOX_DB=F3::get('POSTBOX_DB');
        $POSTBOX_DB->exec($q);
        $array_all_users = array();
        foreach (F3::get('POSTBOX_DB->result') as $row){
            $single_user = array();
            $single_user['username']=   $row["username"];  
            $single_user['post_box_count']=  $row["post_box_count"];
            $array_all_users[$row["username"]]    = $single_user;
        }


        $this->set('caption','Our Contributors');     
        $this->set('array_all_users',$array_all_users);
        $this->set('sub','sub_list_contributors.html');
        $out=$this->render('basic/layout.html');
        $this->set('sub_out_put',$out);
        $this->set('LANGUAGE','en-US');     
        echo $this->render('basic/main.html');  
    }

    function listPostBoxByUsername(){
        $username = $this->get('PARAMS["username"]');
        $this->set('title','Contributor - '.$username);
        $q = 'select * from post_box where username=:username';
        $POSTBOX_DB=F3::get('POSTBOX_DB');
        $POSTBOX_DB->exec($q, array(":username"=>$username));
        $array_all_postboxes = array();
        foreach (F3::get('POSTBOX_DB->result') as $row){
            $single_postbox = array();
            $single_postbox['post_id']= $row["post_id"];    
            $single_postbox['lat']= $row["lat"];
            $single_postbox['lan']= $row["lan"];
            $single_postbox['pincode']= $row["pincode"];    
            $single_postbox['caption']= $row["caption"];
            $single_postbox['formatted_address']=   $row["formatted_address"];
            $array_all_postboxes[$row["post_id"]]   = $single_postbox;
        }

/*        $q = 'select * from pin_code where pincode=:pincode';
        $POSTBOX_DB=F3::get('POSTBOX_DB');
        $POSTBOX_DB->exec($q, array(":pincode"=>$pincode));
        foreach (F3::get('POSTBOX_DB->result') as $row1){
            $this->set('center_lat',$row1['center_lat']);
            $this->set('center_lan',$row1['center_long']);
            $this->set('caption',$row1['total_post_boxes'].' postboxe(s) in this pincode area. Check <a href="'.$this->get('BASE').'/pb/pincode/map/'.$pincode.'/">Map</a> view.');
        }
*/
        $this->set('caption','Post boxes by our contributor -'.$username); 
        $this->set('array_all_postboxes',$array_all_postboxes);
        $this->set('sub','sub_by_username.html');
        $out=$this->render('basic/layout.html');
        $this->set('sub_out_put',$out);
        $this->set('LANGUAGE','en-US');     
        echo $this->render('basic/main.html');  
 
    }

}
?>