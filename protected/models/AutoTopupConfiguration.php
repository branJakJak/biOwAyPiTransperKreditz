<?php

/**
 * This is the model class for table "{{auto_topup_configuration}}".
 *
 * The followings are the available columns in table '{{auto_topup_configuration}}':
 * @property integer $id
 * @property integer $activated
 * @property double $topUpValue
 * @property double $budget
 * @property integer $freeVoipAccount
 * @property integer $remote_data_cache
 * @property string $date_created
 * @property string $date_updated
 */
class AutoTopupConfiguration extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{auto_topup_configuration}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('activated, freeVoipAccount, remote_data_cache', 'numerical', 'integerOnly'=>true),
			array('topUpValue, budget', 'numerical'),
			array('date_created, date_updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, activated, topUpValue, budget, freeVoipAccount, remote_data_cache, date_created, date_updated', 'safe', 'on'=>'search'),
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
			'activated' => 'Activated',
			'topUpValue' => 'Top Up Value',
			'budget' => 'Budget',
			'freeVoipAccount' => 'Free Voip Account',
			'remote_data_cache' => 'Remote Data Cache',
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
		$criteria->compare('activated',$this->activated);
		$criteria->compare('topUpValue',$this->topUpValue);
		$criteria->compare('budget',$this->budget);
		$criteria->compare('freeVoipAccount',$this->freeVoipAccount);
		$criteria->compare('remote_data_cache',$this->remote_data_cache);
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
	 * @return AutoTopupConfiguration the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    public function getFreeVoipAccountModel()
	{
		return FreeVoipAccounts::model()->findByPk($this->freeVoipAccount);
	}
	public function getRemoteDataCacheModel()
	{
		return RemoteDataCache::model()->findByPk($this->remote_data_cache);
	}
    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'date_created',
                'updateAttribute' => 'date_updated',
            )
        );
    }

}
