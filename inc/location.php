<?php
/*
class Location extends F3instance {

	function locationListStates() {
		$this->set('title','States');
		$q = 'SELECT distinct state, count(*) as post_box_count FROM post_box group by state';
		$POSTBOX_DB=F3::get('POSTBOX_DB');
		$POSTBOX_DB->exec($q);
		$array_all_states = array();
		foreach (F3::get('POSTBOX_DB->result') as $row){
			$single_postbox = array();
			$single_postbox['state']=	$row["state"];	
			$single_postbox['post_box_count']=	$row["post_box_count"];
			$array_all_states[$row["state"]]	= $single_postbox;
        }


		$this->set('caption','States for which we have postboxes.');		
        $this->set('array_all_states',$array_all_states);
        $this->set('sub','sub_list_states.html');
		$out=$this->render('basic/layout.html');
		$this->set('sub_out_put',$out);
		$this->set('LANGUAGE','en-US');		
		echo $this->render('basic/main.html');	
	}

	function districtsListByState() {
		$state = $this->get('PARAMS["state"]');
		$this->set('title','State - '.$state);
		$q = 'SELECT distinct district, pincode, count(*) as post_box_count FROM post_box where state=:state group by district, pincode order by district';
		$POSTBOX_DB=F3::get('POSTBOX_DB');
		$POSTBOX_DB->exec($q, array(":state"=>$state));
		$array_all_districts = array();
		foreach (F3::get('POSTBOX_DB->result') as $row){
			$single_postbox = array();
			$single_postbox['district']=	$row["district"];	
			$single_postbox['pincode']=	$row["pincode"];
			$single_postbox['post_box_count']=	$row["post_box_count"];
			$array_all_districts[$row["district"].$row["pincode"]]	= $single_postbox;
        }


		$this->set('caption','Disctricts in '.$state.' for which we have postboxes.');		
        $this->set('array_all_districts',$array_all_districts);
        $this->set('sub','sub_list_districts.html');
		$out=$this->render('basic/layout.html');
		$this->set('sub_out_put',$out);
		$this->set('LANGUAGE','en-US');		
		echo $this->render('basic/main.html');	
	}


}
*/
?>