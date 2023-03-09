<?php
//This is my controller

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require autoload file
require_once('vendor/autoload.php');

session_start();

//Instantiate F3 Base Class
$f3 = Base::instance();

//Instantiate a controller object
$con = new Controller($f3);

//Instantiate a datalayer
$dataLayer = new DataLayer();

//Define a default route
$f3->route('GET|POST /', function($f3){

    $GLOBALS['con']->home($f3);
});

//Define a login route
$f3->route('GET|POST /login', function($f3){

    $GLOBALS['con']->login($f3);
});

//Initial Dashboard Route after login
$f3->route('GET|POST /frontpage', function($f3){

    $GLOBALS['con']->frontpage($f3);

});

//Route to create a new account
$f3->route('GET|POST /newaccount', function($f3){

    $GLOBALS['con']->newAccount($f3);

});

//Route to service page
$f3->route('GET|POST /service', function($f3){


    $GLOBALS['con']->service($f3);
});

//Route to prep page
$f3->route('GET|POST /prep', function($f3){

    $GLOBALS['con']->prep($f3);

});

//Route to add recipe page
$f3->route('GET|POST /insert', function($f3){

    $GLOBALS['con']->insert($f3);

});
//Route to add recipe page
//$f3->route('GET|POST /display-page', function($f3){
//
//    $GLOBALS['con']->display_page($f3);
//
//});
//Run Fat Free
$f3->run();
