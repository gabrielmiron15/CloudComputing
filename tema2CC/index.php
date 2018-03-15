<?php
require 'functions.php';
$request_method = $_SERVER["REQUEST_METHOD"];
$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$firstSegment = $uriSegments[0];
$lastUriSegment = array_pop($uriSegments);
if($lastUriSegment=='filme') {
   redirect('/filme');
}
if(is_int($lastUriSegment)) {
    redirect('/filme');
}
function redirect($url) {
    ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}
