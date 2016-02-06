<?php
/*
class TwitterService extends F3instance {

function startswith4($haystack, $needle) {
    return strpos($haystack, $needle) === 0;
}

function pull_data(){
    $this->set('title','Twitter - Twitter Data Pull');
    $api_url = 'http://search.twitter.com/search.json?q=openpostboxindia&include_entities=true';

    $ch = curl_init ($api_url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
    $json=curl_exec($ch);
    curl_close ($ch);
    $data = json_decode ($json,true);
   
       //echo 'sucess';
       $picture_dicts = $data['results'];
       foreach($picture_dicts as $pic){
           //we need to remove the tags and text from this
            $caption        = $pic["text"];
            $regex = "(http|www)\S+";
            $caption = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', '', $caption);
            $tags = $pic['entities']['hashtags'];
            foreach($tags as $tag){
                $caption = str_replace("#".$tag['text'] , "", $caption);
                $all_tags = $tag['text'].', ';
                $pincode  = 0;
                if($this->startswith4($tag['text'], 'pin')){
                    $pincode = substr($tag['text'],3,10);
                }
            }
            if (array_key_exists('geo', $pic)) {
                //no coordinates break
                if ($pic['geo']){
                    if (!array_key_exists('coordinates', $pic['geo'])) {
                         //no coordinates break
                        break;
                    }
                }else{
                    //null geo
                    break;
                }
            }else{
                //no geo break
                break;
            }
            $lat            = $pic['geo']['coordinates'][0];
            $lan            = $pic['geo']['coordinates'][0];
            $created_time   = $pic['created_at'];
            if (!array_key_exists('media', $pic['entities'])) {
                //no media break
                break;
            }

            $picture_url    = $pic['entities']['media'][0]['media_url'];
            
            $post_id        = $pic['id'];
            //print $post_id;
            $username       = 'twitter-'.$pic["from_user"];
            $website        = 'http://twitter.com/'.$pic["from_user"];

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
                $i = 'insert into post_box( post_id , picture_url , tags , lat , lan , created_time ,';
                $i = $i.'username , website, pincode, caption, provider) values('.'"'.$post_id .'","';
                $i = $i.$picture_url .'","'.$all_tags .'","'.$lat .'","'.$lan .'","'.$created_time .'","';
                $i = $i.$username .'","'.$website .'","'.$pincode .'","'.$caption .'"'.',"Twitter")';
                print $i;
                $POSTBOX_DB->sql($i);
            }else{
                $data_pull_messages[] =  "Already exists.";
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