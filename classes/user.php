<?php

class User
{
    private $_org;
    private $_username;
    private $_fName;
    private $_lName;
    private $_password;
    private $_email;

    /**
     * @param $_org
     * @param $_username
     * @param $_fName
     * @param $_lName
     * @param $_password
     * @param $_email
     */
    public function __construct($_org, $_username, $_fName, $_lName, $_password, $_email)
    {
        $this->_org = $_org;
        $this->_username = $_username;
        $this->_fName = $_fName;
        $this->_lName = $_lName;
        $this->_password = $_password;
        $this->_email = $_email;
    }

    /**
     * @return mixed
     */
    public function getOrg()
    {
        return $this->_org;
    }

    /**
     * @param mixed $org
     */
    public function setOrg($org): void
    {
        $this->_org = $org;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->_username = $username;
    }

    /**
     * @return mixed
     */
    public function getFName()
    {
        return $this->_fName;
    }

    /**
     * @param mixed $fName
     */
    public function setFName($fName): void
    {
        $this->_fName = $fName;
    }

    /**
     * @return mixed
     */
    public function getLName()
    {
        return $this->_lName;
    }

    /**
     * @param mixed $lName
     */
    public function setLName($lName): void
    {
        $this->_lName = $lName;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->_password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->_email = $email;
    }


}