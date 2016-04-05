<?php 

/**
* RingingReport
*/
class RingingReport extends CComponent
{
	public function init()
	{
	}
	public function getData()
	{
		$sqlCommandStr = <<<EOL
		SELECT count(*) as currentRinging FROM asterisk.vicidial_auto_calls where status = 'SENT'
EOL;
		$sqlCommandObj = Yii::app()->asterisk_db->createCommand($sqlCommandStr);
		$res = $sqlCommandObj->queryRow();
		return intval($res['currentRinging']);		
	}
}