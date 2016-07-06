<?php 
/**
* CampaignInformationRetriever
*/
class CampaignInformationRetriever extends CComponent
{
	
	public function init()
	{
	}
	public function getInformation($accountName)
	{
		return "temp";
		$tempAccountNameContainer = $accountName;
		$resultContainer = "";
		$sqlCommandStr = <<<EOL
	SELECT campaign FROM user_carrier
	WHERE sub_user = :accountName
EOL;
		try {
			$sqlCommandObject = Yii::app()->asterisk_db->createCommand($sqlCommandStr);
			$sqlCommandObject->bindParam(":accountName",$tempAccountNameContainer);
			$result = $sqlCommandObject->queryRow();
			if (isset($result['campaign'])) {
				$resultContainer = $result['campaign'];
			}else{
				$resultContainer = "Not Set";
			}
		} catch (Exception $e) {
			$resultContainer = "Not Set";
		}
		return $resultContainer;
	}
}