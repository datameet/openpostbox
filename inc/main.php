<?php
class Main extends BaseController {

	function home() {
		$this->view->title ='Open Postbox | India';
		$this->view->caption= 'Latest postboxes added.';
		$q = 'select * from post_box order by cast(created_time as int) desc limit 14';
		$POSTBOX_DB=\F3::get('POSTBOX_DB');
		$result = $POSTBOX_DB->exec($q);
		$array_all_postboxes = array();

		foreach ($result as $row){
			$single_postbox = array();
			$single_postbox['post_id']=	$row["post_id"];	
			$single_postbox['lat']=	$row["lat"];
			$single_postbox['lan']=	$row["lan"];
			$single_postbox['pincode']=	$row["pincode"];	
			$single_postbox['caption']=	$row["caption"];
			$img="http://openpostbox.org/postboximg/".$row["img"];
			$single_postbox['img']=	$img;
			$single_postbox['picture_url']=	$img;
			$array_all_postboxes[$row["post_id"]]	= $single_postbox;
        }
        $this->view->set('array_all_postboxes',$array_all_postboxes);

		$q = 'select * from stats order by sl desc limit 1';
        $result = $POSTBOX_DB->exec($q);
		foreach ($result as $row){
			$post_count =	$row["post_count"];	
			$user_count =	$row["user_count"];	
	        $this->view->set('is_home',1);
	        $this->view->set('post_count',$post_count);
	        $this->view->set('user_count',$user_count);

        }
		$out=Template::instance()->render('basic/sub_home.html');
		$this->view->set('sub_out_put',$out);
        $this->view->set('enable_maps',1);
        echo Template::instance()->render('basic/main.html');
	}

	function about() {
        $this->view->set('title','About');
		$out=Template::instance()->render('basic/sub_about.html');		
		$this->view->set('sub_out_put',$out);
		echo Template::instance()->render('basic/main.html');

	}

	function contribute() {
		$this->view->set('title','Contribute');
		$out=Template::instance()->render('basic/sub_contribute.html');		
		$this->view->set('sub_out_put',$out);
		echo Template::instance()->render('basic/main.html');
	}

	function api() {
		$this->view->set('title','API');
		$out=Template::instance()->render('basic/sub_api.html');		
		$this->view->set('sub_out_put',$out);
		echo Template::instance()->render('basic/main.html');
	}

    function license() {
        $this->view->set('title','License');
        $out=Template::instance()->render('basic/sub_license.html');        
        $this->view->set('sub_out_put',$out);
        echo Template::instance()->render('basic/main.html');
    }
    
}
?>