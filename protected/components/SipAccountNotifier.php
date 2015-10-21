<?php 

/**
* SipAccountNotifier
*/
class SipAccountNotifier
{
	public $notifyEmails = array("apivoipnotifier@gmail.com","leightxn@gmail.com","hellsing357@gmail.com","webgeekzs2015@gmail.com");
	public $allowedCredits = 10;
	public $currentAccount;
	public function check(SubSipAccount $sipAccount)
	{
		$this->currentAccount = $sipAccount;
		if (is_null($sipAccount->last_checked_bal)) {
            $this->notifyEmailAddress();
		}else{
            if (  
            	doubleval($sipAccount->balance) != 
            	doubleval($sipAccount->last_checked_bal) && 
            	doubleval($sipAccount->last_checked_bal) > $this->allowedCredits
            	&& 
            	doubleval($sipAccount->balance) < $this->allowedCredits
            	) {
                $this->notifyEmailAddress();

                $this->ringDialler("https://162.250.124.167/vicidial/non_agent_api.php?",  array(
					"source"=>"balance",
					"user"=>"admin",
					"pass"=>"Mad4itNOW",
					"function"=>"add_lead",
					"phone_number"=>"7786987117",
					"phone_code"=>"44",
					"list_id"=>"101",
					"add_to_hopper"=>"Y",
					"hopper_priority"=>"99",
				));

                $this->ringDialler("https://162.250.124.167/vicidial/non_agent_api.php?",  array(
					"source"=>"balance",
					"user"=>"admin",
					"pass"=>"Mad4itNOW",
					"function"=>"add_lead",
					"phone_number"=>"7454200980",
					"phone_code"=>"44",
					"list_id"=>"101",
					"add_to_hopper"=>"Y",
					"hopper_priority"=>"99",
				));

            }
            $dumpMessage = sprintf("Sip account balance : %s |  Sip account last checked : %s",$sipAccount->balance , $sipAccount->last_checked_bal);
            Yii::log( $dumpMessage  , CLogger::LEVEL_INFO,'info');
        }
	}
	public function quickRing()
	{
        $this->ringDialler("https://162.250.124.167/vicidial/non_agent_api.php?",  array(
			"source"=>"balance",
			"user"=>"admin",
			"pass"=>"Mad4itNOW",
			"function"=>"add_lead",
			"phone_number"=>"7786987117",
			"phone_code"=>"44",
			"list_id"=>"101",
			"add_to_hopper"=>"Y",
			"hopper_priority"=>"99",
		));
        $this->ringDialler("https://162.250.124.167/vicidial/non_agent_api.php?",  array(
			"source"=>"balance",
			"user"=>"admin",
			"pass"=>"Mad4itNOW",
			"function"=>"add_lead",
			"phone_number"=>"7454200980",
			"phone_code"=>"44",
			"list_id"=>"101",
			"add_to_hopper"=>"Y",
			"hopper_priority"=>"99",
		));		
	}
	public function notifyEmailAddress()
	{
		Yii::import('ext.YiiMailer.YiiMailer');
		// $checkoutLink = Yii::app()->createAbsoluteUrl('subSipAccount/updateBalance', array('subAccount' => $this->currentAccount->id));
		$checkoutLink = "https://apivoip.ml/index.php/subSipAccount/updateBalance?subAccount=".$this->currentAccount->id;
		$messagetemplate = sprintf("Account %s has reached credit limit. %s",$this->currentAccount->username , $checkoutLink);

		foreach ($this->notifyEmails as $currentEmail) {
			mail($currentEmail, 'balance-low', $messagetemplate);
		}
  
	}
	public function ringDialler($targetUrl , $httpParams)
	{
		$targetUrl .= http_build_query($httpParams);
		$curlres = curl_init($targetUrl);
		curl_setopt($curlres, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlres, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curlres, CURLOPT_SSL_VERIFYPEER, false);
		$curlResultStr = curl_exec($curlres);
		Yii::log($curlResultStr, CLogger::LEVEL_INFO,'info');
		Yii::log($targetUrl, CLogger::LEVEL_INFO,'info');
		curl_close($curlres);
	}
}