<?php

/**
 * Constructor
 */
class UserSelect extends Recipe
{

    function __construct($name = "",$station = "",$index = "",$ingredient="",$amount="",$unit="",$instruction="", $id="")
    {
        $this->_name = $name;
        $this->_station = $station;
        $this->_index = $index;
        $this->_ingredient = $ingredient;
        $this->_amount = $amount;
        $this->_unit = $unit;
        $this->_instruction = $instruction;
        $this->_id = $id;
    }
    private $_id;



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->_id = $id;
    }


}
