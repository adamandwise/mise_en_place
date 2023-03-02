<?php

class Recipe
{
    private $_name;
    private $_station;
    private $_index;
    private $_ingredient;
    private $_amount;
    private $_unit;
    private $_instruction;

    function __construct($name,$station,$index,$ingredient,$amount,$unit,$instruction)
    {
        $this->_name = $name;
        $this->_station = $station;
        $this->_index = $index;
        $this->_ingredient = $ingredient;
        $this->_amount = $amount;
        $this->_unit = $unit;
        $this->_instruction = $instruction;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->_name = $name;
    }

    /**
     * @return mixed
     */
    public function getStation()
    {
        return $this->_station;
    }

    /**
     * @param mixed $station
     */
    public function setStation($station): void
    {
        $this->_station = $station;
    }

    /**
     * @return mixed
     */
    public function getIndex()
    {
        return $this->_index;
    }

    /**
     * @param mixed $index
     */
    public function setIndex($index): void
    {
        $this->_index = $index;
    }

    /**
     * @return mixed
     */
    public function getIngredient()
    {
        return $this->_ingredient;
    }

    /**
     * @param mixed $ingredient
     */
    public function setIngredient($ingredient): void
    {
        $this->_ingredient = $ingredient;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->_amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getUnit()
    {
        return $this->_unit;
    }

    /**
     * @param mixed $unit
     */
    public function setUnit($unit): void
    {
        $this->_unit = $unit;
    }

    /**
     * @return mixed
     */
    public function getInstruction()
    {
        return $this->_instruction;
    }

    /**
     * @param mixed $instruction
     */
    public function setInstruction($instruction): void
    {
        $this->_instruction = $instruction;
    }





}