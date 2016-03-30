<?php 

/**
* ViciActionLoggerTest
*/
class ViciActionLoggerTest extends CDbTestCase
{
	public function tearDown()
	{
		ViciActionLogger::model()->deleteAll();
	}
	public function testLogActionSubAccountTopup()
	{
		$accountName = "test";
		$testTopupValue = 300;
		ViciActionLogger::logAction("SUB_ACCOUNT_TOPUP" , "Top upping {$accountName} with {$testTopupValue}" , $testTopupValue , uniqid());
		//there should be one log for sub account
		$criteria = new CDbCriteria;
		$criteria->compare("action_type" , "SUB_ACCOUNT_TOPUP");
		$foundCount = ViciActionLogger::model()->count($criteria);
		$this->assertEquals(1, $foundCount, 'there should be one record inserted');
	}
	public function testLogActionMainTopup()
	{
		ViciActionLogger::logAction("MAIN_TOPUP" , "Top upping {$subAccount->main_user}",$this->topupvalue);		
		$criteria = new CDbCriteria;
		$criteria->compare("action_type" , "SUB_ACCOUNT_TOPUP");
		$foundCount = ViciActionLogger::model()->count($criteria);
		$this->assertEquals(1, $foundCount, 'there should be one record inserted');

	}
	public function testTopUpToday()
	{
		$accountName = "test";
		$testTopupValue = 300;
		ViciActionLogger::logAction("SUB_ACCOUNT_TOPUP" , "Top upping {$accountName} with {$testTopupValue}" , $testTopupValue , uniqid());
		
		
	}
	public function testTopUpTotalAll()
	{
		
	}
	public function testGroup($value='')
	{
		# code...
	}
}