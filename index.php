<?php
//This is my controller

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require autoload file
require_once('vendor/autoload.php');

//Instantiate F3 Base Class
$f3 = Base::instance();

//Define a default route
$f3->route('GET /', function(){

    //Instantiate a view
    $view = new Template();
    echo $view->render("views/home-page.html");

});

//Define a login route
$f3->route('GET /login', function(){

    //Instantiate a view
    $view = new Template();
    echo $view->render("views/login.html");

});

//Run Fat Free
$f3->run();
