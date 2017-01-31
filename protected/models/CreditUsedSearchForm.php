<?php 


/**
* CreditUsedSearchForm
*/
class CreditUsedSearchForm extends CFormModel
{
	public $logDate;
	protected $accountid;
	public function rules()
	{
		return array(
			array('logDate', 'required'),
		);
	}
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'logDate'=>'Log Date',
		);
	}
	public function search()
	{
		/*using log date search for log records*/
	}
	public function setAccountId($accountid)
	{
		$this->accountid = $accountid;
	}

}