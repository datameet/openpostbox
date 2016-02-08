<?php

class Location extends BaseController {

	function locationListStates() {
		$this->view->set('title','States');
		$q = 'SELECT distinct state, count(*) as post_box_count FROM post_box group by state';
		$POSTBOX_DB=\F3::get('POSTBOX_DB');
		$result = $POSTBOX_DB->exec($q);
		$array_all_states = array();
		foreach ($result as $row){
			$single_postbox = array();
			$single_postbox['state']=	$row["state"];	
			$single_postbox['post_box_count']=	$row["post_box_count"];
			$array_all_states[$row["state"]]	= $single_postbox;
        }

		$this->view->set('caption','States for which we have postboxes.');		
        $this->view->set('array_all_states',$array_all_states);
		$out=Template::instance()->render('basic/sub_list_states.html');
		$this->view->set('sub_out_put',$out);
        echo Template::instance()->render('basic/main.html');		
	}

	function districtsListByState() {
		$state = $this->view->get('PARAMS["state"]');
		$this->view->set('title','State - '.$state);
		$q = 'SELECT distinct district, pincode, count(*) as post_box_count FROM post_box where state=:state group by district, pincode order by district';
		$POSTBOX_DB=\F3::get('POSTBOX_DB');
		$result = $POSTBOX_DB->exec($q, array(":state"=>$state));
		$array_all_districts = array();
		foreach ($result as $row){
			$single_postbox = array();
			$single_postbox['district']=	$row["district"];	
			$single_postbox['pincode']=	$row["pincode"];
			$single_postbox['post_box_count']=	$row["post_box_count"];
			$array_all_districts[$row["district"].$row["pincode"]]	= $single_postbox;
        }

		$this->view->set('caption','Disctricts in '.$state.' for which we have postboxes.');		
        $this->view->set('array_all_districts',$array_all_districts);
        $out=Template::instance()->render('basic/sub_list_districts.html');
		$this->view->set('sub_out_put',$out);
        echo Template::instance()->render('basic/main.html');	
	}

}

?>