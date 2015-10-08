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
				"newCampaign"=>$newCampaignValue,
				"viciUser"=>$viciUser,
				"mainUser"=>$mainUser,
				"mainPass"=>$mainPass
			);
		return $command->execute();
	}
}