<?php 

/**
* ActiveMonitorForm
*/
class ActiveMonitorForm extends CFormModel
{
	public $accountsMonitor;
	public function rules()
	{
		return array(
			array('accountsMonitor' ,'required'),
		);
	}
	public function attributeLabels()
	{
		return array(
				'accountsMonitor'=>'Accounts to monitor',
		);
	}
}