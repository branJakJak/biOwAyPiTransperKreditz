<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kevin
 * Date: 10/6/15
 * Time: 11:19 PM
 * To change this template use File | Settings | File Templates.
 */

class RemoteVoipResult {
    public $customer;
    public $balance;
    public $specificBalance;
    public $blocked;

    function __construct(SimpleXMLElement $xmlObject)
    {
        $this->balance = doubleval($xmlObject->Balance);
        $this->customer= (string)$xmlObject->Customer;
        $this->specificBalance = doubleval($xmlObject->SpecificBalance);
        $this->blocked = (boolean)$xmlObject->Blocked;
    }

    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function setBlocked($blocked)
    {
        $this->blocked = $blocked;
    }

    public function getBlocked()
    {
        return $this->blocked;
    }

    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function setSpecificBalance($specificBalance)
    {
        $this->specificBalance = $specificBalance;
    }

    public function getSpecificBalance()
    {
        return $this->specificBalance;
    }


}