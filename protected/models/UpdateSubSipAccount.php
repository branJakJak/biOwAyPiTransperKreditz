<?php 

/**
* UpdateSubSipAccount
*/
class UpdateSubSipAccount extends CFormModel
{
	public $amount;
	public $subSipOwner;
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('amount, subSipOwner', 'required'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'amount'=>'Amount',
			'subSipOwner'=>'Sub SIP account',
		);
	}

    /**
     * @return SubSipAccount $mdl
     * @throws CHttpException
     */
    public function getSubSipAccountModel()
	{
		$mdl = SubSipAccount::model()->findByPk($this->subSipOwner);
		if (!$mdl) {
			throw new CHttpException(404,"Cant find Sub SIP Account model");
		}
		return $mdl;
	}
	public function update()
	{
        /**
         * @var SubSipAccount $model
         */
        $model = $this->getSubSipAccountModel();
		$remoteAcctUpdated = new ApiRemoteUpdateBalance($model->password, $model->username, $model->parentSip->password, $model->parentSip->username,$this->amount);
        return $remoteAcctUpdated->update();
	}

}