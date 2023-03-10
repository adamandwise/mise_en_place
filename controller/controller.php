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


    /**
     * @return void
     */
    function home()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->_f3->reroute('frontpage');
        }
        //Instantiate a view
        $view = new Template();
        echo $view->render("views/home-page.html");
    }

    /**
     * @return void
     */
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

    /**
     * @return void
     */
    function frontpage()
    {
        //        Create the recipe object
        $userSelection = new UserSelect();
        $_SESSION['userSelection'] = $userSelection;

        //Instantiate a view
        $view = new Template();
        echo $view->render("views/front-page.html");
    }

    /**
     * @return void
     */
    function newAccount()
    {
        //Instantiate a view
        $view = new Template();
        echo $view->render("views/create-account.html");
    }

    /**
     * @return void
     */
    function service()
    {
        $_SESSION['userSelection']->setIndex('service');
        //Instantiate a view
        $view = new Template();
        echo $view->render("views/service.html");
    }

    /**
     * @return void
     */
    function prep()
    {
        $_SESSION['userSelection']->setIndex('prep');
        //Instantiate a view
        $view = new Template();
        echo $view->render("views/prep.html");
    }

    /**
     * Inserts in recipes from users
     * @param $f3
     * @return void
     */
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
            if(Validate::validRecipeName($name)){
                $newRecipe->setName($name);
            }else{
                $this->_f3->set('errors["recipeName"]',
                'Recipes cannot contain any numeric symbols in their name.');
            }
            //$newRecipe->setName($name);

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

            //$id = $GLOBALS['dataLayer']->saveRecipe($newRecipe);
            //echo "Order Id: $id inserted successfully";

            if(empty($this->_f3->get('errors'))){
                $id = $GLOBALS['dataLayer']->saveRecipe($newRecipe);
                $this->_f3->reroute('success');

            }
        }

        //Instantiate a view
        $view = new Template();
        echo $view->render("views/insert-recipe.html");
    }

    /**
     * @param $f3
     * @return void
     */
    function display_list($f3)
    {
        //Set station in the userSelection object
        $station = $f3->get('GET.station');
        $_SESSION['userSelection']->setStation($station);
        var_dump($_SESSION['userSelection']);

        //call recipeList function to get recipes
        $recipeList = $GLOBALS['dataLayer']->recipeList($_SESSION['userSelection']);

        //set recipeList to beehive
        $this->_f3->set('recipeList', $recipeList);

        //Instantiate a view
        $view = new Template();
        echo $view->render("views/display-list.html");
    }

    /**
     * @param $f3
     * @return void
     */
    function display_page($f3)
    {
        //Instantiate a view
        $view = new Template();
        echo $view->render("views/display-page.html");
    }

    /**
     * @param $f3
     * @return void
     */
    function display_recipe($f3)
    {
        //Instantiate a view
        $view = new Template();
        echo $view->render("views/display-recipe.html");
    }

    function success($f3)
    {
        $view = new Template();
        echo $view->render("views/success.html");
    }
}