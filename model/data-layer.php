<?php
//connect to db
require $_SERVER['DOCUMENT_ROOT'].'/../config.php';

class DataLayer
{
    // Database Connection Object
    private $_dbh;
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

    function getUnit()
    {
        return array ("Cups","Oz","Tbsp","Tsp","Grams","Fl Oz","Each");
    }

    function getIndex()
    {
        return array ("Desert", "Entree", "Appetizer", "Pantry", "Protein", "Sauce", "Seasoning", "Soup");
    }

    function getStation()
    {
        return array ("Service", "Prep");
    }

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
            //Save to Ingredients Table
            //TODO:Prevent Blank Instruction from Going Into Database
            //TODO: Check if ingredient already in ingredients table
            $sql = "INSERT INTO ingredients (name) VALUES (:name)";
            $statement = $this->_dbh->prepare($sql);
            $statement->bindParam(':name', $ingredient);
            $statement->execute();
            $indId = $this->_dbh->lastInsertId();

            $amount = $recipeObj->getAmount()[$i];
            $unit = $recipeObj->getUnit()[$i];

            //TODO:Prevent Blank Instruction from Going Into Database
            //Save to recipe_ingredients table
            $sql = "INSERT INTO recipe_ingredients (recipe_id, ingredient_id,amount,measurement) VALUES (:recId, :indId, :amount, :unit)";
            $statement = $this->_dbh->prepare($sql);
            $statement->bindParam(':recId', $id);
            $statement->bindParam(':indId', $indId);
            $statement->bindParam(':amount', $amount);
            $statement->bindParam(':unit', $unit);
            $statement->execute();
            $i++;
        }

        $step = 1;
        foreach ($recipeObj->getInstruction() as $instruction){
            //TODO:Prevent Blank Instruction from Going Into Database
            //Save to instructions table
            $sql = "INSERT INTO instructions (recipe_id, step_number , instruction) VALUES (:recId, :step_number, :instruction)";
            $statement = $this->_dbh->prepare($sql);
            $statement->bindParam(':recId', $id);
            $statement->bindParam(':step_number', $step);
            $statement->bindParam(':instruction', $instruction);
            $statement->execute();
            $step++;
        }

        return $id;
    }
}