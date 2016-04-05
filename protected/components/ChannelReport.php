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
		return 0;
// 		$sqlCommandStr = <<<EOL
// 		SELECT count(*) as currentLive FROM asterisk.vicidial_auto_calls where status='LIVE';
// EOL;
// 		$sqlCommandObj = Yii::app()->asterisk_db->createCommand($sqlCommandStr);
// 		$res = $sqlCommandObj->queryRow();
// 		return intval($res['currentLive']);		
	}
}