<?php
//This is my controller
session_start();
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

//Define a home route
$f3->route('GET /home', function(){

    //Instantiate a view
    $view = new Template();
    echo $view->render("views/home-page.html");

});

//Define a login route
$f3->route('GET|POST /login', function($f3){
    var_dump($_POST);
    if($_SERVER['REQUEST_METHOD'] == ['POST']){
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];

        //redirect to logged in frontpage(but home for right now)
        $f3->reroute('views/frontpage');
    }

    //Instantiate a view
    $view = new Template();
    echo $view->render("views/login.html");

});

$f3->route('GET /frontpage', function(){

    //Instantiate a view
    $view = new Template();
    echo $view->render("views/front-page.html");

});

//Run Fat Free
$f3->run();
