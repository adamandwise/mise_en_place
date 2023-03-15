<?php

class UserManager extends User
{
    private $_isManager;

    /**
     * @param $_isManager
     */
    public function __construct($_isManager="")
    {
        $this->_isManager = $_isManager;
    }

    /**
     * @return mixed
     */
    public function getIsManager()
    {
        return $this->_isManager;
    }

    /**
     * @param mixed $isManager
     */
    public function setIsManager($isManager): void
    {
        $this->_isManager = $isManager;
    }




}