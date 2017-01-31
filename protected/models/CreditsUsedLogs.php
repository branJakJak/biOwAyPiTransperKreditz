<?php

/**
 * This is the model class for table "credits_used_logs".
 *
 * The followings are the available columns in table 'credits_used_logs':
 * @property integer $id
 * @property double $credit_used
 * @property string $log_date
 * @property integer $remote_data_cache_accout_id
 */
class CreditsUsedLogs extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'credits_used_logs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('remote_data_cache_accout_id', 'numerical', 'integerOnly'=>true),
			array('credit_used', 'numerical'),
			array('log_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, credit_used, log_date, remote_data_cache_accout_id', 'safe', 'on'=>'search'),
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
			'credit_used' => 'Credit Used',
			'log_date' => 'Log Date',
			'remote_data_cache_accout_id' => 'Remote Data Cache Accout',
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
		$criteria->compare('credit_used',$this->credit_used);
		$criteria->compare('log_date',$this->log_date,true);
		$criteria->compare('remote_data_cache_accout_id',$this->remote_data_cache_accout_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CreditsUsedLogs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getRemoteDataCache()
	{
		return RemoteDataCache::model()->findByPk($this->remote_data_cache_accout_id);
	}
}
