<?php 
/**
* CampaignNameUpdater
*/
class CampaignNameUpdater
{
	public function update($viciUser , $mainUser,$mainPass , $newCampaignValue)
	{
		$command = Yii::app()->asterisk_db->createCommand("
			UPDATE user_carrier SET campaign=:newCampaign 
			where vici_user = :viciUser and main_user = :mainUser and main_pass = :mainPass
		");
		$command->params = array(
				":newCampaign" =>$newCampaignValue,
				":viciUser" =>$viciUser,
				":mainUser" =>$mainUser,
				":mainPass" =>$mainPass
			);
		// $command->bindParam(":newCampaign",$newCampaignValue,PDO::PARAM_STR);
		// $command->bindParam(":viciUser",$viciUser,PDO::PARAM_INT);
		// $command->bindParam(":mainUser",$mainUser,PDO::PARAM_STR);
		// $command->bindParam(":mainPass",$mainPass,PDO::PARAM_STR);
		return $command->execute();
	}
}