<?php

class Postbox extends BaseController {
	function postboxById() {
		$id = $this->view->get('PARAMS["id"]');
		$this->view->set('title','PostBox');
		$caption = 'Error';
		$out='';
		if($id){
			$q = 'select * from post_box where post_id=:id limit 1';
			$POSTBOX_DB=\F3::get('POSTBOX_DB');
			$result= $POSTBOX_DB->exec($q,array(':id' => $id));
			$post_id =null;
			foreach ($result as $row){
				$post_id = $row["post_id"];
				$this->view->set('post_id',$post_id );			
				$this->view->set('post_id',$row["post_id"]);
				$this->view->set('picture_url',$row["picture_url"]);
				$this->view->set('tags',$row["tags"]);
				$this->view->set('lat',$row["lat"]);
				$this->view->set('lan',$row["lan"]);
				$this->view->set('created_time',$row["created_time"]);
				$this->view->set('username',$row["username"]);
				$this->view->set('website',$row["website"]);
				$this->view->set('pincode',$row["pincode"]);
				$this->view->set('img',$row["img"]);
				$this->view->set('formatted_address',$row["formatted_address"]);
				$this->view->set('caption',htmlspecialchars($row["caption"]));
				$caption = $row["caption"];
	        	break;
	        }

	        if(isset($post_id)){
				$map="http://maps.googleapis.com/maps/api/staticmap?center=";
				$map=$map.$row["lat"].",".$row["lan"]."&zoom=17&size=400x300&markers=color:blue|label:P|";
				$map=$map.$row["lat"].",".$row["lan"]."&sensor=true";
				$this->view->set('map',$map);
				$out=Template::instance()->render('basic/sub_postbox.html');
	        }else{
				$this->view->set('error_msg','No postbox exists with that id.');
				$out=Template::instance()->render('basic/sub_error.html');
	        }
		}else{
			$this->view->set('error_msg','No postbox exists with that id.');
			$out=Template::instance()->render('basic/sub_error.html');		
		}
		
		$this->view->set('caption',$caption);
		$this->view->set('sub_out_put',$out);
		echo Template::instance()->render('basic/main.html');
	}

	function pincode() {
		$this->view->set('title','All Pincodes');
		$this->view->set('caption','List of All pincode where we have mapped postboxes.');
		$q = 'select pincode, total_post_boxes from pin_code order by pincode';
		$array_all_pincodes = array();
		$POSTBOX_DB=\F3::get('POSTBOX_DB');
		$result= $POSTBOX_DB->exec($q);

		foreach ($result as $row){
			$single_pincode = array();
			$single_pincode['pincode'] =  $row["pincode"];
			$single_pincode['count'] = $row["total_post_boxes"];
			$array_all_pincodes[$row["pincode"]]	= $single_pincode;
        }

        $this->view->set('array_all_pincodes',$array_all_pincodes);
		$out=Template::instance()->render('basic/sub_list_pincode.html');
		$this->view->set('sub_out_put',$out);
		echo Template::instance()->render('basic/main.html');
	}
/*
	function location() {
		$this->set('title','Location');
		$q = 'select * from post_box, pin_code where post_box.pincode = pin_code.pincode and post_box.loc = 1 and lat != "" order by pin_code.pincode ';
		$this->set('notes','Mouse over a cluster to see the bounds of its children and click a cluster to zoom to those bounds.');
		$this->set('caption','Cluster view');

		$POSTBOX_DB=F3::get('POSTBOX_DB');
		$POSTBOX_DB->exec($q, array());
		$array_all_postboxes = array();
		foreach (F3::get('POSTBOX_DB->result') as $row){
			$single_postbox = array();
			$single_postbox['post_id']=	$row["post_id"];	
			$single_postbox['lat']=	$row["lat"];
			$single_postbox['lan']=	$row["lan"];
			$single_postbox['pincode']=	$row["pincode"];	
			$single_postbox['center_lat']=	$row["center_lat"];
			$single_postbox['center_long']=	$row["center_long"];
			$single_postbox['caption']=	$row["caption"];
			$single_postbox['picture_url']=	$row["picture_url"];			
			$single_postbox['formatted_address']=	$row["formatted_address"];
			$array_all_postboxes[$row["post_id"]]	= $single_postbox;
        }


		
        $this->set('array_all_postboxes',$array_all_postboxes);
        $this->set('sub','sub_location_map.html');
		$out=$this->render('basic/layout.html');
		$this->set('sub_out_put',$out);
		$this->set('LANGUAGE','en-US');		
		echo $this->render('basic/main.html');	
	}
*/
	function search() {
		//TODO:simple search, we will improve it later
		$pincode = $_REQUEST['pincode'];
		if($pincode != ""){
			//this seems to give problem in prod. so added HTTP_HOST. We might have to do in other
			//places too
			$url =$this->view->get('BASE').'/pincode/'.$pincode;
			$this->view->reroute($url, false);
		}else{
			$this->view->set('caption','Error');
			$this->view->set('error_msg','Enter something for searching :)');
			$out=Template::instance()->render('basic/sub_error.html');
			$this->view->set('sub_out_put',$out);
			echo Template::instance()->render('basic/main.html');
		}
	}



	function postboxListByPincode() {
		$pincode = $this->view->get('PARAMS["pincode"]');
		$type = $this->view->get('PARAMS["type"]');

		$this->view->set('title','Pincode - '.$pincode);
		$q = 'select * from post_box where pincode=:pincode';
		$POSTBOX_DB=\F3::get('POSTBOX_DB');
		$result= $POSTBOX_DB->exec($q, array(":pincode"=>$pincode));
		$array_all_postboxes = array();
		foreach ($result as $row){
			$single_postbox = array();
			$single_postbox['post_id']=	$row["post_id"];	
			$single_postbox['lat']=	$row["lat"];
			$single_postbox['lan']=	$row["lan"];
			$single_postbox['pincode']=	$row["pincode"];	
			$single_postbox['caption']=	$row["caption"];
			$single_postbox['formatted_address']=	$row["formatted_address"];
			$array_all_postboxes[$row["post_id"]]	= $single_postbox;
        }

		$q = 'select * from pin_code where pincode=:pincode';
		$POSTBOX_DB=\F3::get('POSTBOX_DB');
		$result=$POSTBOX_DB->exec($q, array(":pincode"=>$pincode));
		$total_post_boxes = 0;
		foreach ($result as $row1){
			$this->view->set('center_lat',$row1['center_lat']);
			$this->view->set('center_lan',$row1['center_long']);
			$total_post_boxes = $row1['total_post_boxes'];
        }
    	$this->view->set('array_all_postboxes',$array_all_postboxes);
        if(isset($type) || $type =="map"){
			$this->view->set('enable_maps',1);
			$this->view->set('caption',$row1['total_post_boxes'].' postboxe(s) in this pincode area. Check <a href="'.$this->view->get('BASE').'/pincode/'.$pincode.'/">List</a> view.');
			$out=Template::instance()->render('basic/sub_by_pincode_map.html');
		}else{
			$this->view->set('caption',$row1['total_post_boxes'].' postboxe(s) in this pincode area. Check <a href="'.$this->view->get('BASE').'/pincode/'.$pincode.'/map">Map</a> view.');
			$out=Template::instance()->render('basic/sub_by_pincode.html');
		}

		$this->view->set('sub_out_put',$out);
		echo Template::instance()->render('basic/main.html');

	}

}

?>