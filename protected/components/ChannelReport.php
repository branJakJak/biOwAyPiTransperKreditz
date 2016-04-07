<?php 
/**
* ChannelReport
*/
class ChannelReport extends CComponent
{
	public function init()
	{
	}
	public function getData()
	{
		$sqlCommandStr = <<<EOL
		SELECT count(*) as currentLive FROM vicidial_live_agents;
EOL;
		$sqlCommandObj = Yii::app()->asterisk_db->createCommand($sqlCommandStr);
		$res = $sqlCommandObj->queryRow();
		return intval($res['currentLive']);		
	}
}