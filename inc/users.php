<?php
class USERS extends F3instance {

function login(){
    $this->set('title','Users - Login');
    $this->set('LANGUAGE','en-US');
    $this->set('sub','sub_login.html');
    $data_pull_messages = array();
    $this->set('data_pull_messages',$data_pull_messages);
    $out=$this->render('basic/layout.html');
    $this->set('sub_out_put',$out);
    $this->set('LANGUAGE','en-US');
    echo $this->render('basic/main.html');
}

function login_token(){
    $this->set('title','Users - Login');
    $this->set('LANGUAGE','en-US');
    $data_pull_messages = array();
    //GET
    $this->set('data_pull_messages',$data_pull_messages);
    $out=$this->render('basic/layout.html');

    $email = 'i@thejeshgn.com';
    //POST
        F3::input('email',
            function($value) {
                if (empty($value))
                    F3::set('message','Email should not be blank');
                elseif (strlen($value)>255)
                    F3::set('message','Invalid email');
                 $email = $value;
            }
        );

        //1. validate email


        //2. generate login token
        $now = date('Y-m-d H:i:s');
        $login_token = md5($this->get('APP_LEVEL_SECRET_TOKEN').$email.rand(1000,100000000).$now);
        $out ="Login url has been sent to your email. Please check and login. Login token is me sensitive.";

        //3. save in db
        $POSTBOX_DB=F3::get('POSTBOX_DB');
        $q = 'update users set login_token=:login_token  , login_token_asked_time=:login_token_asked_time  where email=:email';

        $POSTBOX_DB->exec($q,array(':login_token' => $login_token, ':login_token_asked_time' =>$now, ':email' =>$email));

        //4. send email


        $this->set('sub_out_put',$out);
        $this->set('LANGUAGE','en-US');
        echo $this->render('basic/main.html');
}

function logout(){
    $this->set('title','Users - Login');
    $this->set('LANGUAGE','en-US');
    $this->set('sub','sub_login.html');
    $data_pull_messages = array();
    $this->set('data_pull_messages',$data_pull_messages);
    $out=$this->render('basic/layout.html');
    $this->set('sub_out_put',$out);
    $this->set('LANGUAGE','en-US');
    echo $this->render('basic/main.html');
}


function login_access(){
    $this->set('title','Users - Login');
    $this->set('LANGUAGE','en-US');
    $this->set('sub','sub_login.html');
    $data_pull_messages = array();
    $this->set('data_pull_messages',$data_pull_messages);
    $out=$this->render('basic/layout.html');

    //get from db where token and username matches

    //check if the time is within an hour

    //log him in
    
    $this->set('sub_out_put',$out);
    $this->set('LANGUAGE','en-US');
    echo $this->render('basic/main.html');
}



}
?>
