<?php 

/**
* FreeVoipListAccountsArray
*/
class FreeVoipListAccountsArray 
{
	/**
	 * Returns array map  , where key is the id of account and value is username and password of the account
	 * @return array
	 */
	public static function getList()
	{
		$retVal = array(); 
		$allMdls = FreeVoipAccounts::model()->findAll();
		foreach ($allMdls as $key => $value) {
			$retVal[$value->id] = sprintf("%s - %s" ,$value->username , $value->password);
		}
		return $retVal;
	}
}