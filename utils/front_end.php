<?php

function jsspecialchars( $string = '') {
    $string = preg_replace("/\r*\n/","\\n",$string);
    $string = preg_replace("/\//","\\\/",$string);
    $string = preg_replace("/\"/","\\\"",$string);
    $string = preg_replace("/'/"," ",$string);
    return $string;
}

class BaseController {

    /**
     * view helper
     *
     * @var helpers_View
     */
    protected $view;
    
    /**
     * initialize controller
     *
     * @return void
     */
    public function __construct() {
        $this->view = Base::instance();
    }//end of constructor

}

?>