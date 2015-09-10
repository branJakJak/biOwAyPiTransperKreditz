<?php

/**
 * This is the model class for table "{{transaction_log}}".
 *
 * The followings are the available columns in table '{{transaction_log}}':
 * @property integer $id
 * @property integer $freevoip_account
 * @property string $to_username
 * @property string $amount
 * @property string $pincode
 * @property string $date_created
 * @property string $date_updated
 *
 * The followings are the available model relations:
 * @property FreevoipAccounts $freevoipAccount
 */
class TransactionLog extends CActiveRecord
{
	/**
	 * 
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{transaction_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('to_username, amount, pincode,freevoip_account', 'required'),
			array('freevoip_account,amount', 'numerical', 'integerOnly'=>true),
			array('to_username, amount, pincode', 'length', 'max'=>255),
			array('date_created, date_updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, freevoip_account, to_username, amount, pincode, date_created, date_updated', 'safe', 'on'=>'search'),
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
			'freevoipAccount' => array(self::BELONGS_TO, 'FreevoipAccounts', 'freevoip_account'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'freevoip_account' => 'Freevoip Account',
			'to_username' => 'Recipient',
			'amount' => 'Amount',
			'pincode' => 'Pincode',
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
		$criteria->compare('freevoip_account',$this->freevoip_account);
		$criteria->compare('to_username',$this->to_username,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('pincode',$this->pincode,true);
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
	 * @return TransactionLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
 	public function behaviors(){
 		return array(
 			'CTimestampBehavior' => array(
 				'class' => 'zii.behaviors.CTimestampBehavior',
 				'createAttribute' => 'date_created',
 				'updateAttribute' => 'date_updated',
 				'setUpdateOnCreate' => true,
 			)
 		);
 	}
}
