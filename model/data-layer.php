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
        $id = $this->_dbh->lastInsertId();
        return $id;
    }
}