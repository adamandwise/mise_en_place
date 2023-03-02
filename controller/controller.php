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
}