<?php

class TopupForm extends CFormModel
{
	public $accounts;
	public $topupvalue;
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('accounts, topupvalue', 'required'),
			array('topupvalue', 'numerical'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'accounts'=>'Accounts',
			'topupvalue'=>'Top-up value',
		);
	}
	/**
	 * 
	 * @return integer Returns number of updated accounts
	 */
	public function topupAccounts()
	{
		$accountsAffectedInt = 0;
		$accountsArr = explode(",", $this->accounts);
		foreach ($accountsArr as $key => $currentAccountName) {
			$model = RemoteDataCache::model()->findByAttributes(array('sub_user'=>$currentAccountName));
			if ($model) {
				$remoteAcctUpdated = new ApiRemoteUpdateBalance(
					$currentAccountName->sub_pass,
					$currentAccountName->sub_user,
					$currentAccountName->main_pass,
					$currentAccountName->main_user,
					$this->topupvalue
				);
				if ($remoteAcctUpdated->update()) {
					$accountsAffectedInt++;
				}
			}
		}
		return $accountsAffectedInt;
	}
}