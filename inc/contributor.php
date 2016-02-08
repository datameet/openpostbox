<?php

class Contributor extends BaseController {
    function listContributors() {
        $q = 'SELECT distinct username, count(*) as post_box_count FROM post_box group by username order by post_box_count desc';
        $POSTBOX_DB=\F3::get('POSTBOX_DB');
        $result = $POSTBOX_DB->exec($q);
        $array_all_users = array();
        foreach ($result as $row){
            $single_user = array();
            $single_user['username']=   $row["username"];  
            $single_user['post_box_count']=  $row["post_box_count"];
            $array_all_users[$row["username"]]    = $single_user;
        }

        $this->view->set('caption','Our Contributors');     
        $this->view->set('array_all_users',$array_all_users);
        $out=Template::instance()->render('basic/sub_list_contributors.html');
        $this->view->set('sub_out_put',$out);
        echo Template::instance()->render('basic/main.html');
    }

    function listPostBoxByUsername(){
        $username = $this->view->get('PARAMS["username"]');
        $this->view->set('title','Contributor - '.$this->view->scrub($username));
        $q = 'select * from post_box where username=:username';
        $POSTBOX_DB=\F3::get('POSTBOX_DB');
        $result = $POSTBOX_DB->exec($q, array(":username"=>$username));
        $array_all_postboxes = array();
        foreach ($result as $row){
            $single_postbox = array();
            $single_postbox['post_id']= $row["post_id"];    
            $single_postbox['lat']= $row["lat"];
            $single_postbox['lan']= $row["lan"];
            $single_postbox['pincode']= $row["pincode"];    
            $single_postbox['caption']= $row["caption"];
            $single_postbox['formatted_address']=   $row["formatted_address"];
            $array_all_postboxes[$row["post_id"]]   = $single_postbox;
        }


        $this->view->set('caption','Post boxes by our contributor -'.$this->view->scrub($username)); 
        $this->view->set('array_all_postboxes',$array_all_postboxes);
        $out=Template::instance()->render('basic/sub_by_username.html');
        $this->view->set('sub_out_put',$out);
        echo Template::instance()->render('basic/main.html');
    }

}
?>