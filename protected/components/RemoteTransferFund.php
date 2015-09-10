<?php 

/**
* RemoteTransferFund
*/
class RemoteTransferFund
{
	public function commitTransaction($username,$password,$recipient , $amount,$pincode)
	{
		$curlURL = "https://www.freevoipdeal.com/myaccount/moneytransfer.php?";
		$httpparams = array(
				"username"=>$username,
				"password"=>$password,
				"to"=>$recipient,
				"amount"=>$amount,
				"pincode"=>$pincode
			);
		$curlURL .= http_build_query($httpparams);
		$curlres = curl_init($curlURL);
		curl_setopt($curlres, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlres, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curlres, CURLOPT_SSL_VERIFYHOST, false);
		$curlResRaw = curl_exec($curlres);
		$logFileFolder = Yii::getPathOfAlias("application.data");
		$logFile = $logFileFolder.DIRECTORY_SEPARATOR.'REMOTE_TRANSFER_FUND.log';
		if (!file_exists($logFileFolder)) {
			mkdir($logFileFolder, 0777);
		}
		touch($logFile);
		file_put_contents($logFile,$curlResRaw.PHP_EOL."----------------".PHP_EOL, FILE_APPEND);//put to file
		return simplexml_load_string($curlResRaw);
	}
}