<?php 

/**
* 
*/
class ApiRemoteStatusChecker
{
	public $sipAccountModel;
	function __construct($sipAccountId)
	{
		$this->sipAccountModel = SipAccount::model()->findByPk($sipAccountId);
		if (!$this->sipAccountModel) {
			throw new CHttpException(404,"Cant find SIP Account Model");
		}
	}
	public function checkAllSubAccounts()
	{
		/*get all sub accounts */
		foreach ($this->sipAccountModel->subSipAccounts as $currentSubSipAccount) {
			$this->check(
				"getuserinfo",
				$this->sipAccountModel->username , 
				$this->sipAccountModel->password,
				$currentSubSipAccount->username,
				$currentSubSipAccount->password,
				$currentSubSipAccount
			);
		}
	}
	protected function check($command,$username , $password , $customer , $customerpassword,$currentSubSipAccount)
	{
		$curlURL = "https://77.72.173.130/API/Request.ashx?";
		$httparams = compact('command','username','password','customer','customerpassword');
		$curlURL .= http_build_query($httparams);
		$curlres = curl_init($curlURL);
		curl_setopt($curlres, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlres, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curlres, CURLOPT_SSL_VERIFYPEER, false);
		$curlResRaw = curl_exec($curlres);
		/*check result and update the model*/
		$xmlObject = simplexml_load_string($curlResRaw);
		if (isset($xmlObject->Result) && $xmlObject->Result === "Failed") {
            $currentSubSipAccount->customer_name = $xmlObject->Customer;
            $currentSubSipAccount->balance = 0;
            $currentSubSipAccount->exact_balance = 0;
            if (!$currentSubSipAccount->save()) {
                $logMessage = " $curlResRaw \t " . CVarDumper::dumpAsString($currentSubSipAccount);
                Yii::log("CHtml::errorSummary($currentSubSipAccount)", CLogger::LEVEL_ERROR,'info');
            }
		}else{
            if ($xmlObject->Blocked == "False") {
                $currentSubSipAccount->account_status = 'active';
            }else{
                $currentSubSipAccount->account_status = 'blocked';
            }
            $currentSubSipAccount->customer_name = $xmlObject->Customer;
            $currentSubSipAccount->balance = doubleval($xmlObject->Balance);
            $currentSubSipAccount->exact_balance = doubleval($xmlObject->SpecificBalance);
            $checker = new SipAccountNotifier();
            $checker->check($currentSubSipAccount);
            if (!$currentSubSipAccount->save()) {
                Yii::log(CHtml::errorSummary($currentSubSipAccount), CLogger::LEVEL_ERROR,'info');
            }
        }
	}
}