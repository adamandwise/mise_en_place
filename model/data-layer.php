<?php
//connect to db
require $_SERVER['DOCUMENT_ROOT'].'/../config.php';

class DataLayer
{
    // Database Connection Object
    private $_dbh;

    /**
     * Constructor
     */
    function __construct()
    {
        try{
            //Instantiate a database object
            $this->_dbh = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @return string[]
     */
    function getUnit()
    {
        return array ("Cups","Oz","Tbsp","Tsp","Grams","Fl Oz","Each");
    }

    /**
     * @return string[]
     */
    static function getIndex()
    {
        return array ("Service", "Prep");

    }

    /**
     * @return string[]
     */
    static function getStation()
    {
        return array ("Dessert", "Entree", "Appetizer", "Pantry", "Protein", "Sauce", "Seasoning", "Soup");
    }

    /**
     * @param $recipeObj
     * @return false|string
     */
    function saveRecipe($recipeObj)
    {
        //Save to Recipes Table
        //1. Define the Query
        $sql = "INSERT INTO recipes (name, type, station) VALUES (:rname, :indexType , :station)";
        //2. Prepare the Statement
        $statement = $this->_dbh->prepare($sql);
        //3. Bind the parameters
        $name = $recipeObj->getName();
        $station = $recipeObj->getStation();
        $index = $recipeObj->getIndex();
        $statement->bindParam(':rname', $name);
        $statement->bindParam(':station', $station);
        $statement->bindParam(':indexType', $index);
        //4. Execute the query
        $statement->execute();
        //5. Process the results
        $id = $this->_dbh->lastInsertId(); //ID will be used to sync the table


        $i=0;
        foreach ($recipeObj->getIngredient() as $ingredient) {
            $amount = $recipeObj->getAmount()[$i];
            $unit = $recipeObj->getUnit()[$i];
            if(!empty($unit) && !empty($amount) && !empty($ingredient)){

                //Check if ingredient is in ingredient table
                $sql = "SELECT * FROM ingredients WHERE name = (:ingredientName)";
                $statement = $this->_dbh->prepare($sql);
                $statement->bindParam(':ingredientName', $ingredient);
                $statement->execute();
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                
                if(empty($row)){
                    //Save to Ingredients Table if ingredient not already in table
                    $sql = "INSERT INTO ingredients (name) VALUES (:name)";
                    $statement = $this->_dbh->prepare($sql);
                    $statement->bindParam(':name', $ingredient);
                    $statement->execute();
                    $indId = $this->_dbh->lastInsertId();
                } else {
                    //Ingredient already in table get the preexisting ingredient id
                    $indId = $row['id'];
                }

                //Save to recipe_ingredients table
                $sql = "INSERT INTO recipe_ingredients (recipe_id, ingredient_id,amount,measurement) VALUES (:recId, :indId, :amount, :unit)";
                $statement = $this->_dbh->prepare($sql);
                $statement->bindParam(':recId', $id);
                $statement->bindParam(':indId', $indId);
                $statement->bindParam(':amount', $amount);
                $statement->bindParam(':unit', $unit);
                $statement->execute();
            }
            $i++;
        }

        $step = 1;
        foreach ($recipeObj->getInstruction() as $instruction){
            if(!empty($instruction)) {
                //Save to instructions table
                $sql = "INSERT INTO instructions (recipe_id, step_number , instruction) VALUES (:recId, :step_number, :instruction)";
                $statement = $this->_dbh->prepare($sql);
                $statement->bindParam(':recId', $id);
                $statement->bindParam(':step_number', $step);
                $statement->bindParam(':instruction', $instruction);
                $statement->execute();

            }
            $step++;
        }

        return $id;
    }

    function recipeList($userSelectObject)
    {
        $station = $userSelectObject->getStation();
//        echo $station;

        //Check if ingredient is in ingredient table
        $sql = "SELECT * FROM recipes WHERE (station = :station)";
        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':station', $station);
        $statement->execute();
//        var_dump($statement->errorInfo());
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function searchRecipeList($search)
    {
        $search_query = '%' . $search . '%';
        //Check if ingredient is in ingredient table
        $sql = "SELECT * FROM recipes WHERE name LIKE :search_query";
        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':search_query', $search_query);
        $statement->execute();
//        var_dump($statement->errorInfo());
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    function createUser($newUser){

        //1.define the query
        $sql = "INSERT INTO users (restaurant_name,username,password,manager,email) VALUES (:restaurant_name,:username,:password,:manager,:email)";
           //2. Prepare the Statement
        $statement = $this->_dbh->prepare($sql);
        //3, bind the parameters
        $org = $newUser ->getOrg();
        $username = $newUser ->getUsername();
        $password = $newUser -> getPassword();
        $email = $newUser -> getEmail();

        if($newUser instanceof UserManager){
            $manager = 1;
        }else{
            $manager = 0;
        }
        $statement->bindParam(':restaurant_name',$org);
        $statement->bindParam(':username',$username);
        $statement->bindParam(':password',$password);
        $statement->bindParam(':email',$email);
        $statement->bindParam(':manager',$manager);

        //4.execute statement
        $statement->execute();

        //5.process the results
//        var_dump($statement->errorInfo());
        $id = $this->_dbh->lastInsertId(); //ID will be used to sync the table
        return $id;
    }

   //validation for username
         function callUser($username){
            $sql = "SELECT * FROM users WHERE username = :username ";
            $statement = $this->_dbh->prepare($sql);
            $statement->bindParam(':username',$username);
            $statement->execute(); // Execute the prepared statement
            $userCheck= $statement->fetchAll(PDO::FETCH_ASSOC);
            //var_dump($userCheck);
            if($userCheck == null){
                return true;
            }else{
                return false;
            }
        }

    /**
     * Checks if the input password matches the hashed password stored in the database for the given user.
     *
     * @param string $username The username of the user to check the password for.
     * @param string $password The password to check.
     * @return bool Returns true if the password matches, or false otherwise.
     */
    function checkPassword($username, $password) {
        $sql = "SELECT password FROM users WHERE username = :username";
        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':username', $username);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            // User not found in the database
            return false;
        }

        $hashed_password = $user['password'];

        if ($password == $hashed_password) {
            // Passwords match
            return true;
        } else {
            // Passwords don't match
            return false;
        }
    }

    function isManager($username){
        $sql = "SELECT * FROM users WHERE username = :username ";
        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':username', $username);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        $isManager = $user['manager'];

        return ($isManager == 1);
    }

    function displayRecipe($userSelection)
    {

        //Handles Name,Station,Index
        $id = $userSelection->getId();
        $sql = "SELECT * FROM recipes WHERE id = :id ";
        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $recipe = $statement->fetch(PDO::FETCH_ASSOC);
        return $recipe;

    }

    function displayIngredients($userSelection)
    {
        //Handles Ingredients, Amount, Unit
        $id = $userSelection->getId();
//        var_dump($id);
        $sql = "SELECT ingredients.name, recipe_ingredients.amount, recipe_ingredients.measurement  FROM ingredients JOIN recipe_ingredients ON ingredients.id = recipe_ingredients.ingredient_id WHERE recipe_ingredients.recipe_id = :id ";
        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $ingredients = $statement->fetchALL(PDO::FETCH_ASSOC);
//        var_dump($statement->errorInfo());
        return $ingredients;
    }

    function displayInstructions($userSelection)
    {
        //Handles Ingredients, Amount, Unit
        $id = $userSelection->getId();
//        var_dump($id);
        $sql = "SELECT *  FROM instructions WHERE recipe_id = :id ";
        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $instructions = $statement->fetchALL(PDO::FETCH_ASSOC);
//        var_dump($statement->errorInfo());
        return $instructions;
    }





}