<?php

function jsspecialchars( $string = '') {
    $string = preg_replace("/\r*\n/","\\n",$string);
    $string = preg_replace("/\//","\\\/",$string);
    $string = preg_replace("/\"/","\\\"",$string);
    $string = preg_replace("/'/"," ",$string);
    return $string;
}
?>