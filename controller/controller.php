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
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['password'] = $_POST['password'];

                if(Validate::validLogin($_SESSION['username'],$_SESSION['password'])){
                    //this session variable will let us check if the user is able to create recipes or not
                    $_SESSION['userPrivilege'] = Validate::validManager($_SESSION['username']);
                    $this->_f3->reroute('frontpage');


                }else{
                    $this->_f3->set('errors["login"]',
                        'This username and password is invalid. Please try again.');
                }

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

           if(Validate::validLogin($_SESSION['username'],$_SESSION['password'])){
               $this->_f3->reroute('frontpage');
           }else{
               $this->_f3->set('errors["login"]',
                   'This username and password is invalid. Please try again.');
           }


            //redirect to logged in frontpage(but home for right now)
           // $this->_f3->reroute('frontpage');
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
       // var_dump($_SESSION);
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


        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if($_POST['isManager'] == 1){
                $newUser = new UserManager();
                $newUser ->setIsManager(1);
            }else{
                $newUser = new User();
            }

            $restaurant_name = $_POST['restaurant'];
            $newUser->setOrg($restaurant_name);

            $username = $_POST['username'];
            $newUser->setUsername($username);

            $password = $_POST['password'];
            $newUser ->setPassword($password);

            $email = $_POST['email'];
            $newUser -> setEmail($email);

            //var_dump($newUser);
            $check = Validate::validateUser($username);

            if($check){

                $result = $GLOBALS['dataLayer']->createUser($newUser);
                $_SESSION['newUser'] = $newUser;
                $_POST = array();

            }else{

                $this->_f3->set('errors["username"]',
                'This username is unavailable. Please choose another.');
            }

           // var_dump($result);

            if(empty($this->_f3->get('errors'))){
                $this->_f3->reroute('login');
            }


        }


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
            if(Validate::validStation($station)){
                $newRecipe->setStation($station);
            }else{
                $this->_f3->set('errors["station"]',
                    'Please choose a specified station.');
            }
            //$newRecipe->setStation($station);

            //Recipe Index
            $index = $_POST['index'];
            if(Validate::validIndex($index)){
                $newRecipe->setIndex($index);
            }else{
                $this->_f3->set('errors["index"]',
                    'Please choose a specified index.');
            }
            $newRecipe->setIndex($index);

            //Recipe Ingredients
            $ingredients = $_POST['ingredient'];
//            if(Validate::validIngredientName($ingredients)){
//                $newRecipe->setIngredient($ingredients);
//            }else{
//                $this->_f3->set('errors["ingredient"]',
//                    'Ingredient names must be at least 2 characters long.');
//            }
            $newRecipe->setIngredient($ingredients);

            //Set Amount
            $amount = $_POST['amount'];
//            if(Validate::validAmount($amount)){
//                $newRecipe->setAmount($amount);
//            }else{
//                $this->_f3->set('errors["amount"]',
//                    'Please enter an amount.');
//            }
            $newRecipe->setAmount($amount);

            //Set Measurement Unit
            $unit = $_POST['unit'];
//            if(Validate::validUnit($unit)){
//                $newRecipe->setUnit($unit);
//            }else{
//                $this->_f3->set('errors["unit"]',
//                    'Please enter a unit of measurement.');
//            }
            $newRecipe->setUnit($unit);

            //Recipe Instructions
            $instructions = $_POST['instruction'];
//            if(Validate::validInstruction($instructions)){
//                $newRecipe->setInstruction($instructions);
//            }else{
//                $this->_f3->set('errors["instruction"]',
//                    'Please leave more detailed instructions.');
//            }
            $newRecipe->setInstruction($instructions);

            if(Validate::validIndexStationMatch($index,$station)){
                $_SESSION['newRecipe'] = $newRecipe;
            }else{
                $this->_f3->set('errors["indexStation"]',
                    "The index does not match the station.
                        Prep = [Protein, Sauces, Seasoning, Soup] 
                        Service = [Entree,Appetizer, Salad, Dessert]");
            }

            //Put new recipe into $_SESSION array
           //$_SESSION['newRecipe'] = $newRecipe;


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
        if(ISSET($_POST['search'])){
            $search = $_POST['search'];
            $recipeList = $GLOBALS['dataLayer']->searchRecipeList($search);

            //set recipeList to beehive
            $this->_f3->set('recipeList', $recipeList);


        } else {
            //Set station in the userSelection object
            $station = $f3->get('GET.station');
            $_SESSION['userSelection']->setStation($station);
//        var_dump($_SESSION['userSelection']);

            //call recipeList function to get recipes
            $recipeList = $GLOBALS['dataLayer']->recipeList($_SESSION['userSelection']);


            //set recipeList to beehive
            $this->_f3->set('recipeList', $recipeList);

        }


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
        $id = $f3->get('GET.recipeId');
        $_SESSION['userSelection']->setId($id);

        //General recipe information from recipe table
        $recipeSelected = $GLOBALS['dataLayer']->displayRecipe($_SESSION['userSelection']);

        //Set the Recipe Name
        $_SESSION['userSelection']->setName($recipeSelected['name']);

        //Set the Recipe Station
        $_SESSION['userSelection']->setStation($recipeSelected['station']);

        //Set the Recipe Index
        $_SESSION['userSelection']->setIndex($recipeSelected['type']);

        //Set ingredients list to the beehive
        $ingredientList = $GLOBALS['dataLayer']->displayIngredients($_SESSION['userSelection']);
        $this->_f3->set('ingredientsList', $ingredientList);

        //Set instructions list to the beehive
        $instructionsList = $GLOBALS['dataLayer']->displayInstructions($_SESSION['userSelection']);
        $this->_f3->set('instructionsList', $instructionsList);
//        var_dump($ingredientList);

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