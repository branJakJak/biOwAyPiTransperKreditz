<?php

/**
 * This is the model class for table "{{force_agent_table}}".
 *
 * The followings are the available columns in table '{{force_agent_table}}':
 * @property integer $id
 * @property string $force_agent_lbl
 * @property string $force_agent_value
 * @property string $date_created
 * @property string $date_updated
 */
class ForceAgentTable extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{force_agent_table}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('force_agent_lbl, force_agent_value', 'required'),
			array('force_agent_lbl, force_agent_value', 'length', 'max'=>255),
			array('date_created, date_updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, force_agent_lbl, force_agent_value, date_created, date_updated', 'safe', 'on'=>'search'),
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
			'force_agent_lbl' => 'Label',
			'force_agent_value' => 'Value',
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
		$criteria->compare('force_agent_lbl',$this->force_agent_lbl,true);
		$criteria->compare('force_agent_value',$this->force_agent_value,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ForceAgentTable the static model class
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
		       'createAttribute' => 'date_created',
		       'updateAttribute' => 'date_updated',
		   )
		);
	}
}
