<?php

class GIS extends BaseController {

	function reverse_geocode_batch(){
		$this->view->set('title','PostBox - Google Reverse Geo Code');
		$data_pull_messages = array();
		$POSTBOX_DB=\F3::get('POSTBOX_DB');
		$q = 'select post_id,lat,lan from post_box where state is null';
		$data_pull_messages[] = "START of Reverse geo code process";
		$result = $POSTBOX_DB->exec($q);
		foreach ($result as $row){
			$post_id = $row["post_id"];			
			$lat = $row["lat"];
			$lan =$row["lan"];
			$data_pull_messages[] = "For id.".$post_id;
			$url ="http://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$lan."&sensor=false&region=in";
			$ch = curl_init ($url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
			$json=curl_exec($ch);
			curl_close ($ch);

			$data = json_decode($json, true);
			$road ='';
			$locality='';
			$district='';
			$state='';
			$formatted_address='';

			foreach ($data["results"] as $key => $val) {
				foreach ($val["address_components"] as $key1 => $val1) {
					if (in_array( "route" , $val1['types']  )){
						$road = $val1['long_name'];
					}	
					if (in_array( "locality" , $val1['types']  )){
						$locality=$val1['long_name'];
					}	
					if (in_array( "administrative_area_level_2" , $val1['types']  )){
						$district=$val1['long_name'];
					}	
					if (in_array( "administrative_area_level_1" , $val1['types']  )){
						$state=$val1['long_name'];
					}	
					$data_pull_messages[] ="adding ".$val1['long_name']." type".implode($val1['types']);
				}
				$formatted_address=$val["formatted_address"];
			 	break;
			 }

			$q = 'update post_box set road=:road,locality=:locality,district=:district, state=:state, formatted_address=:formatted_address where post_id=:post_id';
			$data_pull_messages[] = "add the reverse geocode details for the post_id=".$post_id;
			$POSTBOX_DB->exec($q,array(':post_id' => $post_id, ':road' =>$road, ':locality' =>$locality, ':district' =>$district, ':state' =>$state, ':formatted_address' =>$formatted_address));
	    }

	    $data_pull_messages[] = "END of Reverse geo code process";
		$this->view->set('data_pull_messages',$data_pull_messages);
	    $out=Template::instance()->render('basic/sub_data_pull.html');
	    $this->view->set('sub_out_put',$out);
	    echo Template::instance()->render('basic/main.html');
	}

} 
?>
