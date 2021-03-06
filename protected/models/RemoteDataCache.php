<?php

/**
 * This is the model class for table "{{remote_data_cache}}".
 *
 * The followings are the available columns in table '{{remote_data_cache}}':
 * @property integer $id
 * @property string $main_user
 * @property string $main_pass
 * @property string $sub_user
 * @property string $sub_pass
 * @property integer $vici_user
 * @property string $is_active
 * @property double $last_balance
 * @property double $balance
 * @property double $exact_balance
 * @property string $ip_address
 * @property integer $num_lines
 * @property string $campaign
 * @property double $last_balance_since_topup
 * @property double $accumulating_credits_used
 * @property integer $is_hidden
 * @property string $priority
 * @property datetime $date_created
 * @property datetime $date_updated
 */
class RemoteDataCache extends CActiveRecord
{
    public $last_balance_since_topup;
    public $accumulating_credits_used;
    public $is_hidden;
    public $priority;//[top , bottom]
    /**
     * @var string Contains the date since the last credit update.
     */
    public $last_credit_update;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_remote_data_cache';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('main_user, main_pass, sub_user, sub_pass, is_active', 'required'),
			array('vici_user, num_lines', 'numerical', 'integerOnly'=>true),
			array('balance, exact_balance,last_balance,last_balance_since_topup,accumulating_credits_used', 'numerical'),
			array('main_user, main_pass, sub_user, sub_pass, is_active, ip_address,priority', 'length', 'max'=>255),
			array('campaign, date_created,date_updated,last_credit_update,is_hidden,priority', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, main_user, main_pass, sub_user, sub_pass, vici_user, is_active, balance, exact_balance, ip_address, num_lines,last_balance_since_topup,accumulating_credits_used', 'safe', 'on'=>'search'),
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
			'main_user' => 'Main User',
			'main_pass' => 'Main Pass',
			'sub_user' => 'Sub User',
			'sub_pass' => 'Sub Pass',
			'vici_user' => 'Vici User',
			'is_active' => 'Is Active',
			'last_balance' => 'Last balance',
			'balance' => 'Balance',
			'exact_balance' => 'Exact Balance',
			'ip_address' => 'Ip Address',
			'num_lines' => 'Num Lines',
			'campaign' => 'Campaign',
			'last_balance_since_topup' => 'Last balance since topup',
			'last_credit_update' => 'Last balance since topup date',
			'accumulating_credits_used' => 'Accumulating credits used',
			'is_hidden' => 'Visibility',
			'priority' => 'Position',
			'date_created' => 'Date created',
			'date_updated' => 'Date updated',
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
		$criteria->compare('main_user',$this->main_user,true);
		$criteria->compare('main_pass',$this->main_pass,true);
		$criteria->compare('sub_user',$this->sub_user,true);
		$criteria->compare('sub_pass',$this->sub_pass,true);
		$criteria->compare('vici_user',$this->vici_user);
		$criteria->compare('is_active',$this->is_active,true);
		$criteria->compare('last_balance',$this->last_balance);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('exact_balance',$this->exact_balance);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('num_lines',$this->num_lines);
		$criteria->compare('campaign',$this->campaign);
		$criteria->compare('last_balance_since_topup',$this->last_balance_since_topup);
		$criteria->compare('accumulating_credits_used',$this->accumulating_credits_used);
		$criteria->compare('is_hidden',$this->is_hidden);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('date_created',$this->date_created);
		$criteria->compare('date_updated',$this->date_updated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RemoteDataCache the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    protected function afterSave()
    {
        if ($this->isNewRecord) {
            /*create AutoTopUpConfiguration*/
            $freeVoipObject = FreeVoipAccounts::model()->findByAttributes(array('username'=>'jawdroppingcalls'));
            $autoTopUpConf = new AutoTopupConfiguration();
            $autoTopUpConf->activated = false;
            $autoTopUpConf->budget = 0;
            $autoTopUpConf->freeVoipAccount = $freeVoipObject->id;
            $autoTopUpConf->remote_data_cache = $this->id;
            $autoTopUpConf->topUpValue = 0;
            $autoTopUpConf->save(false);


            if (!isset($this->is_hidden) || empty($this->is_hidden)) {
            	$this->is_hidden = false;
            }

        }
        parent::afterSave();
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
