<?php 
/**
* CampaignForcer
*/
class RemoteCampaignEnforcer extends CComponent
{
	public function init()
	{
	}
	/**
	 * Updates the campaign and subuser
	 * @param  string $campaignName The campaign name
	 * @param  string $subUser      Sub user
	 * @return integer               
	 */
	public function update($campaignName , $subUser)
	{
		//proceed updating the table/view
		$sqlCommandStr = <<<EOL
		update user_carrier set campaign=:campaignName where sub_user=:subUser
EOL;
		$sqlCommandObj = Yii::app()->asterisk_db->createCommand($sqlCommandStr);
		$sqlCommandObj->bindParam(":campaignName",$campaignName);
		$sqlCommandObj->bindParam(":subUser",$subUser);
		return $sqlCommandObj->execute();
	}
}