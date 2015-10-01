<?php

/**
 * This is the model class for table "{{sub_sip_account}}".
 *
 * The followings are the available columns in table '{{sub_sip_account}}':
 * @property integer $id
 * @property integer $parent_sip
 * @property string $username
 * @property string $password
 * @property string $account_status
 * @property string $customer_name
 * @property double $balance
 * @property double $exact_balance
 * @property string $last_checked_bal
 * @property string $date_updated
 * @property string $date_created
 *
 * The followings are the available model relations:
 * @property SipAccount $parentSip
 */
class SubSipAccount extends CActiveRecord
{
	public $last_checked_bal;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{sub_sip_account}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password', 'required'),
			array('parent_sip,balance,exact_balance,last_checked_bal', 'numerical'),
			array('username, password,customer_name', 'length', 'max'=>255),
			array('date_created, date_updated,account_status', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_sip, username, password,last_checked_bal ,date_created, date_updated', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'parentSip' => array(self::BELONGS_TO, 'SipAccount', 'parent_sip'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_sip' => 'Parent Sip',
			'username' => 'Username',
			'password' => 'Password',
			'account_status' => 'Status',
			'customer_name' => 'Customer Name',
			'balance' => 'Balance',
			'exact_balance' => 'Exact Balance',
			'last_checked_bal' => 'Last Balance Checked',
			'date_created' => 'Date Created',
			'date_updated' => 'Date Updated',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('parent_sip',$this->parent_sip);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('account_status',$this->account_status,true);
		$criteria->compare('customer_name',$this->customer_name,true);
		$criteria->compare('balance',$this->balance,true);
		$criteria->compare('exact_balance',$this->exact_balance,true);
		$criteria->compare('last_checked_bal',$this->last_checked_bal,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SubSipAccount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function behaviors()
    {
        return array(
            'CTimestampBehavior'=>array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'date_created',
                'updateAttribute' => 'date_updated',
                'setUpdateOnCreate' => true,
            ),
        );
    }
	
}
