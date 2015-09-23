<?php

/**
 * This is the model class for table "{{sip_account}}".
 *
 * The followings are the available columns in table '{{sip_account}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $account_status
 * @property string $vicidial_identification
 * @property string $date_created
 * @property string $date_updated
 *
 * The followings are the available model relations:
 * @property SubSipAccount[] $subSipAccounts
 */
class SipAccount extends CActiveRecord
{
	public $vicidial_identification;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{sip_account}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username', 'unique'),
			array('username, password', 'required'),
			array('username, password', 'length', 'max'=>255),
			array('date_created, date_updated , account_status,vicidial_identification', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, date_created, date_updated', 'safe', 'on'=>'search'),
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
			'subSipAccounts' => array(self::HAS_MANY, 'SubSipAccount', 'parent_sip'),
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
			'account_status' => 'Status',
			'vicidial_identification' => 'Vicidial Indentification',
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
		$criteria->compare('account_status',$this->account_status,true);
		$criteria->compare('vicidial_identification',$this->vicidial_identification,true);
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
	 * @return SipAccount the static model class
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
