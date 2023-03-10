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
    static function validIngredientName($ingredientName)
    {
        $pattern = '/^[a-zA-Z]+$/';
        return preg_match($pattern, $ingredientName) & strlen($ingredientName) > 0;
        //return strlen($fname) > 2;

    }

    /**
     * this function validates wether or not the amount given in the amount field is valid data, so either a number
     * greater than 0, or a string length greater than 0
     * @param $amount
     * @return int
     */
    static function validAmount($amount)
    {
       // $pattern = '/^[a-zA-Z]+$/';
        //return preg_match($pattern, $ingredientName);
        return strlen($amount) > 0 | $amount > 0;

    }

    /**
     * this function validates wether or not the unit given matches the regex pattern saying no numbers can be inserted here, as well
     * as a string length greater than 0
     * @param $unit
     * @return int
     */
    static function validUnit($unit)
    {
        $pattern = '/^[a-zA-Z]+$/';
        return preg_match($pattern, $unit) & strlen($unit) > 0;

    }



}

