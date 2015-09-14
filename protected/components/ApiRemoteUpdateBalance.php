<?php 

/**
* ApiRemoteUpdateBalance
*/
class ApiRemoteUpdateBalance
{
	protected $reseller_username;
	protected $reseller_password;
	protected $client_username;
    protected $client_password;
	protected $amount;
    function __construct($client_password, $client_username, $reseller_password, $reseller_username,$amount)
    {
        $this->client_password = $client_password;
        $this->client_username = $client_username;
        $this->reseller_password = $reseller_password;
        $this->reseller_username = $reseller_username;
        $this->amount= $amount;
    }


    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setClientPassword($client_password)
    {
        $this->client_password = $client_password;
    }

    public function getClientPassword()
    {
        return $this->client_password;
    }

    public function setClientUsername($client_username)
    {
        $this->client_username = $client_username;
    }

    public function getClientUsername()
    {
        return $this->client_username;
    }

    public function setResellerPassword($reseller_password)
    {
        $this->reseller_password = $reseller_password;
    }

    public function getResellerPassword()
    {
        return $this->reseller_password;
    }

    public function setResellerUsername($reseller_username)
    {
        $this->reseller_username = $reseller_username;
    }

    public function getResellerUsername()
    {
        return $this->reseller_username;
    }


    public function update()
    {
        $status = false;
        $curlURL = "https://77.72.173.130/API/Request.ashx?";
        $httpParams = array(
                "command"=>"settransaction",
                "username"=>$this->getResellerUsername(),
                "password"=>$this->getResellerPassword(),
                "customer"=>$this->getClientUsername(),
                "customerpassword"=>$this->getClientPassword(),
                "amount"=>$this->getAmount(),
            );
        $curlURL .= http_build_query($httpParams);
        die($curlURL);
        $curlres = curl_init($curlURL);
        curl_setopt($curlres, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlres, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlres, CURLOPT_SSL_VERIFYHOST, false);
        $curlResRaw = curl_exec($curlres);
        $xmlObject = simplexml_load_string($curlResRaw);
        if (isset($xmlObject->Result) && $xmlObject->Result == "Success") {
            $status = true;
        }
        $this->logData($curlResRaw.PHP_EOL);
        return $status;
    }
    private function logData($message)
    {
        $logPath = Yii::getPathOfAlias("application.data");
        $logFilePath = Yii::getPathOfAlias("application.data.REMOTE_UPDATE_BALANCE").'.log';
        if (!file_exists($logPath)) {
            mkdir($logPath, 0777);
        }
        if (!file_exists($logFilePath)) {
            file_put_contents($logFilePath, PHP_EOL);
        }
        $message .= PHP_EOL.str_repeat("-", 15);
        file_put_contents($logFilePath, PHP_EOL.$message,FILE_APPEND);
    }


}