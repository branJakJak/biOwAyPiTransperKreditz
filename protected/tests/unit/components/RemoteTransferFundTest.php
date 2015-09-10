<?php 

/**
* RemoteTransferFundTest
*/
class RemoteTransferFundTest extends CDbTestCase 
{
	
	public function testCommitTransaction()
	{
		Yii::import('application.components.*');
		$rmt = new RemoteTransferFund();
		
	}
}