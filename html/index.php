<?php
date_default_timezone_set('Asia/Calcutta');
$app=require __DIR__.'/../lib/base.php';
require __DIR__.'/../utils/front_end.php';
$app->set('AUTOLOAD','../inc/;');
$DB ='sqlite:../db/postbox.sqlite';


$DEBUG_PROD=0;
$DEBUG_TEST=4;
$app->set('DEBUG',$DEBUG_TEST);
$app->set('POSTBOX_DB',new DB\SQL($DB));
$app->set('APP_LEVEL_SECRET_TOKEN','SECRET_TOEKN_PASSWORD_CHANGE');
$app->set('BASE','http://localhost:8080'); 
$app->set('LANGUAGE','en-US');   
$app->set('AUTHOR','THEJESH GN');   
$app->set('top_menu',
    array(
        '/'=>'Home',
        'about'=>'About',
        'about#contribute'=>'Contribute',
        'api'=>'API'
    )
);
$app->set('side_menu',
    array(
        '/'=>'Error Handling',
        'globals'=>'Globals'
    )
);


$app->route('GET /','Main->home');
$app->route('GET /about','Main->about');
$app->route('GET /contribute','Main->contribute');
$app->route('GET /api','Main->api');
$app->route('GET /license','Main->license');
$app->route('GET /search','Postbox->search');

$app->route('GET /pb/id/@id','Postbox->postboxById');
$app->route('GET /pb/location/map','Postbox->location');

$app->route('GET /pincode/list','Postbox->pincode');
$app->route('GET /pincode/@pincode','Postbox->postboxListByPincode');
$app->route('GET /pincode/@pincode/@type','Postbox->postboxListByPincode');

$app->route('GET /location/list/states','Location->locationListStates');
$app->route('GET /location/list/districts/@state','Location->districtsListByState');

$app->route('GET /contributor/list','Contributor->listContributors');
$app->route('GET /contributor/username/@username','Contributor->listPostBoxByUsername');

$app->route('GET /batch/instagram_data_pull','Instagram->pull_data');

/*

$app->route('GET /twitter_data_pull_batch','TwitterService->pull_data');

$app->route('GET /reverse_geocode_batch','GIS->reverse_geocode_batch');
$app->route('GET /stat_update_batch','STAT->stat_update_batch');*/
//$app->route('GET /user/login','USERS->login');
//$app->route('POST /user/token','USERS->login_token');
//$app->route('POST /user/access/@token','USERS->login_access');
//$app->route('POST /user/logout','USERS->logout');

//as of not required. I dont want to increase db size on my server.
//$app->route('GET /image_pull','Instagram->pull_images');


$app->run();
?>
