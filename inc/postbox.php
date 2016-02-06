<?php
/*
class Postbox extends F3instance {
	function postboxById() {
		$id = $this->get('PARAMS["id"]');
		$this->set('title','PostBox');
		$caption = 'Error';
		$out='';
		if($id){
			$POSTBOX_DB=F3::get('POSTBOX_DB');
			$q = 'select * from post_box where post_id=:id';
			$POSTBOX_DB->exec($q,array(':id' => $id));

			$post_id =null;
			foreach (F3::get('POSTBOX_DB->result') as $row){
				$post_id = $row["post_id"];
				$this->set('post_id',$post_id );			
				$this->set('post_id',$row["post_id"]);
				$this->set('picture_url',$row["picture_url"]);
				$this->set('tags',$row["tags"]);
				$this->set('lat',$row["lat"]);
				$this->set('lan',$row["lan"]);
				$this->set('created_time',$row["created_time"]);
				$this->set('username',$row["username"]);
				$this->set('website',$row["website"]);
				$this->set('pincode',$row["pincode"]);
				$this->set('img',$row["img"]);
				$this->set('formatted_address',$row["formatted_address"]);
				$this->set('caption',htmlspecialchars($row["caption"]));
				$caption = $row["caption"];
	        	break;
	        }

	        if(isset($post_id)){
				$map="http://maps.googleapis.com/maps/api/staticmap?center=";
				$map=$map.$row["lat"].",".$row["lan"]."&zoom=17&size=400x300&markers=color:blue|label:P|";
				$map=$map.$row["lat"].",".$row["lan"]."&sensor=true";
				$this->set('map',$map);
				$this->set('LANGUAGE','en-US');
				$this->set('sub','sub_postbox.html');
				$out=$this->render('basic/layout.html');
	        }else{
				$this->set('LANGUAGE','en-US');
				$this->set('error_msg','No postbox exists with that id.');
				$this->set('sub','sub_error.html');
				$out=$this->render('basic/layout.html');
	        }
		}else{
			$this->set('LANGUAGE','en-US');
			$this->set('error_msg','No postbox exists with that id.');
			$this->set('sub','sub_error.html');
			$out=$this->render('basic/layout.html');
		}
		
		$this->set('sub_out_put',$out);
		$this->set('caption',$caption);
		$this->set('LANGUAGE','en-US');
		echo $this->render('basic/main.html');
	}

	function pincode() {
		$this->set('title','All Pincodes');
		$this->set('caption','List of All pincode where we have mapped postboxes.');
		$q = 'select pincode, total_post_boxes from pin_code order by pincode';
		$pincode_count_array = array();
		$POSTBOX_DB=F3::get('POSTBOX_DB');
		$POSTBOX_DB->sql($q);
		foreach (F3::get('POSTBOX_DB->result') as $row){
			$pincode_count_array[$row["pincode"]] = $row["total_post_boxes"];
        }
        $this->set('pincode_count_array',$pincode_count_array);
        $this->set('sub','sub_list_pincode.html');
		$out=$this->render('basic/layout.html');
		$this->set('sub_out_put',$out);
		$this->set('LANGUAGE','en-US');		
		echo $this->render('basic/main.html');
	}

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

	function search() {
		//TODO:simple search, we will improve it later
		$pincode = $_REQUEST['pincode'];
		if($pincode != ""){
			//this seems to give problem in prod. so added HTTP_HOST. We might have to do in other
			//places too
			$url ='http://'.$_SERVER['HTTP_HOST'].$this->get('BASE').'/pb/pincode/'.$pincode;
			$this->reroute($url);
		}else{
			$this->set('LANGUAGE','en-US');
			$this->set('error_msg','Enter something for searching :)');
			$this->set('sub','sub_error.html');
			$out=$this->render('basic/layout.html');
			$this->set('sub_out_put',$out);
			$this->set('caption','Error');
			$this->set('LANGUAGE','en-US');
			echo $this->render('basic/main.html');			
		}
	}

	function postboxMapByPincode() {
		$pincode = $this->get('PARAMS["pincode"]');
		$this->set('title','Pincode - '.$pincode);
		$q = 'select * from post_box where pincode=:pincode and lat != "" ';
		$POSTBOX_DB=F3::get('POSTBOX_DB');
		$POSTBOX_DB->exec($q, array(":pincode"=>$pincode));
		$array_all_postboxes = array();
		foreach (F3::get('POSTBOX_DB->result') as $row){
			$single_postbox = array();
			$single_postbox['post_id']=	$row["post_id"];	
			$single_postbox['lat']=	$row["lat"];
			$single_postbox['lan']=	$row["lan"];
			$single_postbox['pincode']=	$row["pincode"];	
			$single_postbox['caption']=	$row["caption"];
			$single_postbox['picture_url']=	$row["picture_url"];
			
			$array_all_postboxes[$row["post_id"]]	= $single_postbox;
        }

		$q = 'select * from pin_code where pincode=:pincode';
		$POSTBOX_DB=F3::get('POSTBOX_DB');
		$POSTBOX_DB->exec($q, array(":pincode"=>$pincode));
		foreach (F3::get('POSTBOX_DB->result') as $row1){
			$this->set('center_lat',$row1['center_lat']);
			$this->set('center_lan',$row1['center_long']);
        }

		$this->set('caption',$row1['total_post_boxes'].' postboxe(s) in this pincode area. Check <a href="'.$this->get('BASE').'/pb/pincode/'.$pincode.'/">List</a> view.');		
        $this->set('array_all_postboxes',$array_all_postboxes);
        $this->set('sub','sub_by_pincode_map.html');
		$out=$this->render('basic/layout.html');
		$this->set('sub_out_put',$out);
		$this->set('LANGUAGE','en-US');		
        $this->set('enable_maps',1);
		echo $this->render('basic/main.html');	
	}

	//same as above. Just for making it future proof
	function postboxListByPincode() {
		$pincode = $this->get('PARAMS["pincode"]');
		$this->set('title','Pincode - '.$pincode);
		$q = 'select * from post_box where pincode=:pincode';
		$POSTBOX_DB=F3::get('POSTBOX_DB');
		$POSTBOX_DB->exec($q, array(":pincode"=>$pincode));
		$array_all_postboxes = array();
		foreach (F3::get('POSTBOX_DB->result') as $row){
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
		$POSTBOX_DB=F3::get('POSTBOX_DB');
		$POSTBOX_DB->exec($q, array(":pincode"=>$pincode));
		foreach (F3::get('POSTBOX_DB->result') as $row1){
			$this->set('center_lat',$row1['center_lat']);
			$this->set('center_lan',$row1['center_long']);
			$this->set('caption',$row1['total_post_boxes'].' postboxe(s) in this pincode area. Check <a href="'.$this->get('BASE').'/pb/pincode/map/'.$pincode.'/">Map</a> view.');
        }

		
        $this->set('array_all_postboxes',$array_all_postboxes);
        $this->set('sub','sub_by_pincode.html');
		$out=$this->render('basic/layout.html');
		$this->set('sub_out_put',$out);
		$this->set('LANGUAGE','en-US');		
		echo $this->render('basic/main.html');	
	}


	function postboxByLocation() {
		$lat = $this->get('PARAMS["lat"]');
		$lat = $this->get('PARAMS["long"]');
		$this->set('title','Location');
		echo $this->render('basic/main.html');
	}
}
*/
?>