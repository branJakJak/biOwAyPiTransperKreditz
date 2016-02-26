<?php

class TopupForm extends CFormModel
{
	public $accounts;
	public $topupvalue;
	public $freeVoipAccountUsername;
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('accounts, topupvalue,freeVoipAccountUsername', 'required'),
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
		$groupId = uniqid();
		foreach ($accountsArr as $key => $currentAccountName) {
			$model = RemoteDataCache::model()->findByAttributes(array('sub_user'=>$currentAccountName));
			if ($model) {
				//topup the main account
				$this->topUpMainAccount($model);
				//topup the sub accounts
				$remoteAcctUpdated = new ApiRemoteUpdateBalance(
					$model->sub_pass,
					$model->sub_user,
					$model->main_pass,
					$model->main_user,
					$this->topupvalue
				);
				ViciActionLogger::logAction("SUB_ACCOUNT_TOPUP" , "Top upping {$model->sub_user} with {$this->topupvalue}" , $this->topupvalue , $groupId);
				if ($remoteAcctUpdated->update()) {
					$accountsAffectedInt++;
				}
			}
		}
		return $accountsAffectedInt;
	}
	public function topUpMainAccount(RemoteDataCache $subAccount)
	{
        $criteria = new CDbCriteria;
        $criteria->compare("username",$this->freeVoipAccountUsername);
        $freeVoipAccount = FreeVoipAccounts::model()->find($criteria);
        if ($freeVoipAccount) {
        	//transfer fund from FreeVoipAccount to SipAccount
	        $rmt = new RemoteTransferFund();
	        $remoteResult = $rmt->commitTransaction(
	        	$freeVoipAccount->username,
	            $freeVoipAccount->password,
	            $subAccount->main_user,//user or the resller
	            doubleval($this->topupvalue),
	            $freeVoipAccount->pincode
	        );
	        ViciActionLogger::logAction("MAIN_TOPUP" , "Top upping {$subAccount->main_user}",$this->topupvalue,uniqid(),time());
        }else{
        	throw new CHttpException(404,"$this->freeVoipAccountUsername doesnt exists");
        }

	}
}