<?php

/**
 * This is the model class for table "{{user_request}}".
 *
 * The followings are the available columns in table '{{user_request}}':
 * @property integer $id
 * @property string $user_agent
 * @property string $ip_address
 * @property string $url_refferer
 * @property string $date_created
 * @property string $date_updated
 */
class UserRequest extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_request}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_agent, ip_address, url_refferer', 'length', 'max'=>255),
			array('date_created, date_updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_agent, ip_address, url_refferer, date_created, date_updated', 'safe', 'on'=>'search'),
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
			'user_agent' => 'User Agent',
			'ip_address' => 'Ip Address',
			'url_refferer' => 'Url Refferer',
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
		$criteria->compare('user_agent',$this->user_agent,true);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('url_refferer',$this->url_refferer,true);
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
	 * @return UserRequest the static model class
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
			)
		);
	}
	public function getFlagImageLabel()
	{
		Yii::import('ext.EGeoIP.*');
		$imagePath = "";
		$geoIp = new EGeoIP();
		$countryLabel = "";
		$geoIp->locate($this->ip_address);
		$baseUrl = Yii::app()->theme->baseUrl; 
		$imagePath .= $baseUrl."/img/countries/".strtolower($geoIp->countryCode)."_16.png";
		$countryLabel .= " ".CHtml::image($imagePath, $geoIp->countryName);
		return $countryLabel." ".$geoIp->countryName;
	}
	public static function getRecentLogins()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition("date(date_created) = date(now())");
		$criteria->limit = 20;
		$criteria->order = "date_created DESC";
		$dataProvider = new CActiveDataProvider('UserRequest',array(
				'criteria'=>$criteria,
				'pagination'=>false,
			));
		return $dataProvider;
	}

}
