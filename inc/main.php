<?php
class Main extends F3instance {
	function home() {
		$this->set('title','Open Postbox | India');
		$this->set('caption','Latest postboxes added.');
		$q = 'select * from post_box order by cast(created_time as int) desc limit 5';
		$POSTBOX_DB=F3::get('POSTBOX_DB');
		$POSTBOX_DB->sql($q);
		$array_all_postboxes = array();
		foreach (F3::get('POSTBOX_DB->result') as $row){
			$single_postbox = array();
			$single_postbox['post_id']=	$row["post_id"];	
			$single_postbox['lat']=	$row["lat"];
			$single_postbox['lan']=	$row["lan"];
			$single_postbox['pincode']=	$row["pincode"];	
			$single_postbox['caption']=	$row["caption"];
			$single_postbox['img']=	$row["img"];
			$single_postbox['picture_url']=	$row["picture_url"];
			$array_all_postboxes[$row["post_id"]]	= $single_postbox;
        }
        $this->set('array_all_postboxes',$array_all_postboxes);

		$q = 'select * from stats order by sl desc limit 1';
		$POSTBOX_DB=F3::get('POSTBOX_DB');
		$POSTBOX_DB->sql($q);
		foreach (F3::get('POSTBOX_DB->result') as $row){
			$post_count =	$row["post_count"];	
			$user_count =	$row["user_count"];	
	        $this->set('is_home',1);
	        $this->set('post_count',$post_count);
	        $this->set('user_count',$user_count);

        }


        $this->set('sub','sub_home.html');
		$out=$this->render('basic/layout.html');
		$this->set('sub_out_put',$out);
		$this->set('LANGUAGE','en-US');		
        $this->set('enable_maps',1);
		echo $this->render('basic/main.html');	

	}

	function about() {
		$this->set('title','About');
        $this->set('sub','sub_about.html');
		$out=$this->render('basic/layout.html');		
		$this->set('sub_out_put',$out);
		$this->set('LANGUAGE','en-US');		
		echo $this->render('basic/main.html');
	}

	function contribute() {
		$this->set('title','Contribute');
        $this->set('sub','sub_contribute.html');
		$out=$this->render('basic/layout.html');		
		$this->set('sub_out_put',$out);
		$this->set('LANGUAGE','en-US');		
		echo $this->render('basic/main.html');
	}

	function api() {
		$this->set('title','API');
        $this->set('sub','sub_api.html');
		$out=$this->render('basic/layout.html');		
		$this->set('sub_out_put',$out);
		$this->set('LANGUAGE','en-US');		
		echo $this->render('basic/main.html');
	}
}
?>