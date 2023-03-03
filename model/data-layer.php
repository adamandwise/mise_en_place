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
}