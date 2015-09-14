<?php 

/**
* ClientListViewProvider
*/
class ClientListViewProvider extends CArrayDataProvider
{
    // @TODO list client information
    public $clientAccounts = array(

    );

	function __construct() {
        // retrieve all data using client accounts
        //use retrieveClientData for data retrival

        // put data here
        //$this->data
	}
    public function retrieveClientData($username, $password)
    {
        /*login and scrap the data*/
    }
}