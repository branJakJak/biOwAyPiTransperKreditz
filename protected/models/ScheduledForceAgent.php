<?php

/**
 * This is the model class for table "scheduled_force_agent".
 *
 * The followings are the available columns in table 'scheduled_force_agent':
 * @property integer $id
 * @property string $scheduled_date
 * @property string $forceAgent
 * @property integer $account_id
 * @property double $topup_amount
 * @property integer $activate
 * @property string $created_at
 * @property string $updated_at
 */
class ScheduledForceAgent extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'scheduled_force_agent';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, activate', 'numerical', 'integerOnly'=>true),
			array('topup_amount', 'numerical'),
			array('forceAgent,scheduled_date, created_at, updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, scheduled_date, account_id, topup_amount, activate, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'scheduled_date' => 'Scheduled Date',
			'account_id' => 'Account',
			'topup_amount' => 'Topup Amount',
			'forceAgent' => 'Force Agent',
			'activate' => 'Activate',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
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
		$criteria->compare('scheduled_date',$this->scheduled_date,true);
		$criteria->compare('forceAgent',$this->forceAgent);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('topup_amount',$this->topup_amount);
		$criteria->compare('activate',$this->activate);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ScheduledForceAgent the static model class
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
                'createAttribute' => 'created_at',
                'updateAttribute' => 'updated_at',
            )
        );
    }

}
