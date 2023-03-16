<?php

/**
 * this is our validation layer lass.we this class extensively to test user submitted recipes
 * these methods are used to make sure proper data is entered, and if it is not, we send a suggestion
 * to the user on how to fullfill the form properly, as this is the first step in getting data into
 * the recipe and user classes
 */
class Validate
{
    /**
     * this method checks the recipe name the user submitted to a regex pattern, and is looking for alphabet letters
     * only, no numbers or symbols. it returns either false or an  int value, which i use as the true state
     *
     * @param $fname
     * @return false|int
     */
    static function validRecipeName($recipeName)
    {
        $pattern = '/^[a-zA-Z\s]+$/';
        return preg_match($pattern, $recipeName);
        //return strlen($fname) > 2;

    }

    /**
     * this validation function prevent sspoofing by making sure the station selected is within the getStation function
     * @param $station
     * @return bool
     */
    static function validStation($station)
    {
        if (in_array($station, DataLayer::getStation())) {
            return true;
        } else {
            return false;
        }


    }

    /**
     * this validation function prevent sspoofing by making sure the station selected is within the getIndex function
     * @param $station
     * @return bool
     */
    static function validIndex($index)
    {
        if (in_array($index, DataLayer::getIndex())) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * this method checks the recipe name the user submitted to a regex pattern, and is looking for alphabet letters
     * only, no numbers or symbols. it returns either false or an  int value, which i use as the true state
     *
     * @param $fname
     * @return false|int
     */
    static function validIngredientName($ingredientNames)
    {
        foreach($ingredientNames as $ingredient) {

            if(strlen($ingredient) <= 2){
                return false; // return false if the length is less than or equal to 2
            }
        }
        return true; // if all elements pass validation return true

    }

    /**
     * this function validates wether or not the amount given in the amount field is valid data, so either a number
     * greater than 0, or a string length greater than 0
     * @param $amount
     * @return int
     */
    static function validAmount($amounts)
    {

        foreach($amounts as $amount) {

            if(strlen($amount) <= 0){
                return false; // return false if the length is less than or equal to 2
            }
        }
        return true; // if all elements pass validation return true

    }

    /**
     * this function validates wether or not the unit given matches the regex pattern saying no numbers can be inserted here, as well
     * as a string length greater than 0
     * @param $unit
     * @return int
     */
    static function validUnit($units)
    {
        foreach($units as $unit) {

            if(strlen($unit) <= 0){
                return false; // return false if the length is less than or equal to 2
            }
        }
        return true; // if all elements pass validation return true

    }

    static function validInstruction($instructionNames)
    {
        foreach($instructionNames as $instruction) {

            if(!is_string($instruction)){
                return false; // return false if the length is less than or equal to 2
            }
        }
        return true; // if all elements pass validation return true

    }

    static function validateUser($username){

        $result = $GLOBALS['dataLayer']->callUser($username);
        //var_dump($result);
        return $result;
    }

    static function validLogin($username,$password){
        $result = $GLOBALS['dataLayer']->checkPassword($username,$password);
        //var_dump($result);
        return $result;
    }




}

