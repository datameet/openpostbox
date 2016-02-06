<?php
/*
class InstagramService extends F3instance {

function startswith4($haystack, $needle) {
    return strpos($haystack, $needle) === 0;
}

function pull_data(){
	$this->set('title','PostBox - Instagram Data Pull');
	$instagram_api_clinet_id = 'b9d4b604105648168c671293d10cc67e';
	$instagram_api_url = 'https://api.instagram.com/v1/tags/openpostboxindia/media/recent?client_id='.$instagram_api_clinet_id;
	$data_pull_messages = array();

	$ch = curl_init ($instagram_api_url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
	$json=curl_exec($ch);
	curl_close ($ch);
	$data = json_decode ($json,true);
	//var_dump($data);
	if($data['meta']['code']==200){
	   //echo 'sucess';
	   $picture_dicts = $data['data'];
	   foreach($picture_dicts as $pic){
		    $tags 			= implode(', ', $pic['tags']);
		    $pincode 		= 0;
		    foreach($pic['tags'] as $tag){
		    	if($this->startswith4($tag, 'pin')){
		    		$pincode = substr($tag,3,10);
		    	}
		    }
		    $lat 			= $pic['location']['latitude'];
		    $lan 			= $pic['location']['longitude'];
		    $created_time 	= $pic['created_time'];
		    $picture_url 	= $pic['images']['standard_resolution']['url'];
		    $post_id 		= $pic['id'];
		    $username 		= 'instagram-'.$pic["user"]["username"];
	        $website 		= '';//$pic["user"]["website"];
	        $caption		= $pic["caption"]["text"];
			//check if post_id exists, if yes then go to next one. else insert
			$data_pull_messages[] = "Processing the post_id=".$post_id;
			$q = 'select count(*) as count_posts from post_box where post_id="'.$post_id.'"';
			$POSTBOX_DB=F3::get('POSTBOX_DB');
			$POSTBOX_DB->sql($q);
			//print '\n'.$q; 
			$count_posts = 0;
			foreach (F3::get('POSTBOX_DB->result') as $row){
	        	$count_posts = $row['count_posts'];

	        }
	        if ($count_posts == 0){
	        	$data_pull_messages[] = "Lets INSERT.";
	        	$i = 'insert into post_box( post_id , picture_url , tags , lat , lan , created_time , username , website,pincode, caption, provider) values('.'"'.$post_id .'","'.$picture_url .'","'.$tags .'","'.$lat .'","'.$lan .'","'.$created_time .'","'.$username .'","'.$website .'","'.$pincode .'","'.$caption .'"'.',"Instagram")';
	        	//print $i;
	        	$POSTBOX_DB->sql($i);
	        }else{
	        	$data_pull_messages[] =  "Already exists.";
	        }

		}
	}
	$this->set('LANGUAGE','en-US');
	$this->set('sub','sub_data_pull.html');
	$this->set('data_pull_messages',$data_pull_messages);
	$out=$this->render('basic/layout.html');
	$this->set('sub_out_put',$out);
	$this->set('LANGUAGE','en-US');
	echo $this->render('basic/main.html');
}

function pull_images(){
	$this->set('title','PostBox - Instagram Pull Pictures');
	$data_pull_messages = array();
	$POSTBOX_DB=F3::get('POSTBOX_DB');
	$q = 'select post_id,picture_url from post_box where img is null';
	$data_pull_messages[] = "Staring the process.";
	$POSTBOX_DB->sql($q);
	foreach (F3::get('POSTBOX_DB->result') as $row){
		$post_id = $row["post_id"];			
		$picture_url = $row["picture_url"];
		$ch = curl_init ($picture_url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		$content=curl_exec($ch);
		curl_close ($ch);
		$img = base64_encode($content);
		$q = 'update post_box set img=:img where post_id=:post_id';
		$data_pull_messages[] = "add the img for the post_id=".$post_id;
		$POSTBOX_DB->exec($q,array(':post_id' => $post_id, ':img' =>$img));
    }
	$data_pull_messages[] = "Process complete.";
    //echo implode($data_pull_messages);
	$this->set('LANGUAGE','en-US');
	$this->set('sub','sub_data_pull.html');
	$this->set('data_pull_messages',$data_pull_messages);
	$out=$this->render('basic/layout.html');
	$this->set('sub_out_put',$out);
	$this->set('LANGUAGE','en-US');
	echo $this->render('basic/main.html');
}


}//calss end 
*/
?>