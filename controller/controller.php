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
            $this->_f3->reroute('frontpage');
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

    function insert($f3)
    {
        //Add data for Select menus to the beehive
        $f3->set('measurementUnits', $GLOBALS['dataLayer']->getUnit());
        $f3->set('index', $GLOBALS['dataLayer']->getIndex());
        $f3->set('station', $GLOBALS['dataLayer']->getStation());

        //Check if the form has been submitted
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Create the recipe object
            $newRecipe = new Recipe();

            //Recipe Name
            $name = $_POST['recipeName'];
            $newRecipe->setName($name);

            //Recipe Station
            $station = $_POST['station'];
            $newRecipe->setStation($station);

            //Recipe Index
            $index = $_POST['index'];
            $newRecipe->setIndex($index);

            //Recipe Ingredients
            $ingredients = $_POST['ingredient'];
            $newRecipe->setIngredient($ingredients);

            //Set Amount
            $amount = $_POST['amount'];
            $newRecipe->setAmount($amount);

            //Set Measurement Unit
            $unit = $_POST['unit'];
            $newRecipe->setUnit($unit);

            //Recipe Instructions
            $instructions = $_POST['instruction'];
            $newRecipe->setInstruction($instructions);

            //Put new recipe into $_SESSION array
            $_SESSION['newRecipe'] = $newRecipe;

            $id = $GLOBALS['dataLayer']->saveRecipe($newRecipe);
            echo "Order Id: $id inserted successfully";
        }

        //Instantiate a view
        $view = new Template();
        echo $view->render("views/insert-recipe.html");
    }

    function display_list($f3)
    {
        //Instantiate a view
        $view = new Template();
        echo $view->render("views/display-list.html");
    }
    function display_page($f3)
    {
        //Instantiate a view
        $view = new Template();
        echo $view->render("views/display-page.html");
    }

    function display_recipe($f3)
    {
        //Instantiate a view
        $view = new Template();
        echo $view->render("views/display-recipe.html");
    }
}