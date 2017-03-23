<?php

/**
 * This is the model class for table "{{freevoip_accounts}}".
 *
 * The followings are the available columns in table '{{freevoip_accounts}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $credits
 * @property string $description
 * @property string $date_created
 * @property string $date_updated
 *
 * The followings are the available model relations:
 * @property TransactionLog[] $transactionLogs
 */
class FreeVoipAccounts extends CActiveRecord
{
	public $pincode = 2580;
	public $credits;
	/**
	 * 
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_freevoip_accounts';
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
			array('username, password', 'length', 'max'=>255),
			array('credits,date_created,description ,date_updated', 'safe'),
			array('id, username, password,description ,date_created, date_updated', 'safe', 'on'=>'search'),
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
			'transactionLogs' => array(self::HAS_MANY, 'TransactionLog', 'freevoip_account'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'credits' => 'Credit',
			'description' => 'Description',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('credits',$this->credits,true);
		$criteria->compare('description',$this->description,true);
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
	 * @return FreeVoipAccounts the static model class
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
