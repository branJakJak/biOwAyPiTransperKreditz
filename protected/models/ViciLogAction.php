<?php

/**
 * This is the model class for table "{{vici_log_action}}".
 *
 * The followings are the available columns in table '{{vici_log_action}}':
 * @property integer $id
 * @property string $action_type
 * @property string $message
 * @property double $topUpValue
 * @property string $batch
 * @property string $logDate
 */
class ViciLogAction extends CActiveRecord
{
	const VICILOG_ACTION_TOPUP_MAIN = 'MAIN_TOPUP';
	const VICILOG_ACTION_TOPUP_SUBSIP = 'TOPUP_SUBSIP';
	const VICILOG_ACTION_SUBSIP_DEACTIVIVATE = 'SUBSIP_DEACTIVIVATE_GROUP';
	const VICILOG_ACTION_SUBSIP_ACTIVIVATE = 'SUBSIP_ACTIVIVATE_GROUP';


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{vici_log_action}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('action_type', 'required'),
			array('topUpValue', 'numerical'),
			array('action_type, message, batch', 'length', 'max'=>255),
			array('logDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, action_type, message, topUpValue, batch, logDate', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'action_type' => 'Action Type',
			'message' => 'Message',
			'topUpValue' => 'Top Up Value',
			'batch' => 'Batch',
			'logDate' => 'Log Date',
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
		$criteria->compare('action_type',$this->action_type,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('topUpValue',$this->topUpValue);
		$criteria->compare('batch',$this->batch,true);
		$criteria->compare('logDate',$this->logDate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ViciLogAction the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function behaviors()
	{
		return array(
		   'CTimestampBehavior' => array(
		       'class' => 'zii.behaviors.CTimestampBehavior',
		       'createAttribute' => 'logDate',
		       'updateAttribute' => 'logDate',
		   )
		);
	}
}
