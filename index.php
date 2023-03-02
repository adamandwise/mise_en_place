<?php
//This is my controller
session_start();
//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require autoload file
require_once('vendor/autoload.php');
require('/home/adamthew/pdo-config.php');

try{
    //Instantiate a PDO object

    $dbh = new PDO(DB_DRIVER,USERNAME,PASSWORD);
}catch(PDOException $e){
    echo $e->getMessage();

}

//Instantiate F3 Base Class
$f3 = Base::instance();

$con = new Controller($f3);

//Define a default route
$f3->route('GET|POST /', function($f3){

    $GLOBALS['con']->home($f3);
});

//Define a login route
$f3->route('GET|POST /login', function($f3){

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];

        //redirect to logged in frontpage(but home for right now)
        $f3->reroute('frontpage');
    }

    //Instantiate a view
    $view = new Template();
    echo $view->render("views/login.html");
//    var_dump($_POST);

});

//Initial Dashboard Route after login
$f3->route('GET|POST /frontpage', function(){

    //Instantiate a view
    $view = new Template();
    echo $view->render("views/front-page.html");

});

//Route to create a new account
$f3->route('GET|POST /newaccount', function(){

    //Instantiate a view
    $view = new Template();
    echo $view->render("views/create-account.html");

});

//Route to service page
$f3->route('GET|POST /service', function(){

    //Instantiate a view
    $view = new Template();
    echo $view->render("views/service.html");

});

//Route to prep page
$f3->route('GET|POST /prep', function(){

    //Instantiate a view
    $view = new Template();
    echo $view->render("views/prep.html");

});

//Route to add recipe page
$f3->route('GET|POST /insert', function(){

    //Instantiate a view
    $view = new Template();
    echo $view->render("views/insert-recipe.html");

});

//Run Fat Free
$f3->run();
