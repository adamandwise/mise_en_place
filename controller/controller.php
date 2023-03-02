<?php

class Controller
{
    private $_f3;

    /**
     * this function instantiates the controller class, with a fatfree object
     * @param $f3
     */
    function __construct($f3){
        $this->_f3 = $f3;
    }



    function home()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->_f3->reroute('frontpage');
        }
        //Instantiate a view
        $view = new Template();
        echo $view->render("views/home-page.html");
    }

    function login()
    {
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
    }

    function frontpage()
    {
        //Instantiate a view
        $view = new Template();
        echo $view->render("views/front-page.html");
    }

    function newAccount()
    {
        //Instantiate a view
        $view = new Template();
        echo $view->render("views/create-account.html");
    }

    function service()
    {
        //Instantiate a view
        $view = new Template();
        echo $view->render("views/service.html");
    }

    function prep()
    {
        //Instantiate a view
        $view = new Template();
        echo $view->render("views/prep.html");
    }

    function insert()
    {
        //Instantiate a view
        $view = new Template();
        echo $view->render("views/insert-recipe.html");
    }
}