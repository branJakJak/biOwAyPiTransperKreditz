<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 3/18/16
 * Time: 1:36 AM
 */

class AutoTopUpUpdateForm extends CFormModel{
    public $remoteDataCacheId;
    public $autoConfigIdentity;
    public $newTopUpValue;
    public $newBudget;
    public $activated;

    public function rules()
    {
        return array(
            array('remoteDataCacheId , autoConfigIdentity,newTopUpValue,newBudget', 'required','on'=>'updateVal'),
            array('remoteDataCacheId , autoConfigIdentity,newTopUpValue,newBudget', 'numerical','on'=>'updateVal'),
            array('remoteDataCacheId , autoConfigIdentity,newTopUpValue,newBudget,activated', 'safe','on'=>'updateVal'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'remoteDataCacheId'=>'VOIP Account',
            'autoConfigIdentity'=>'Auto Topup Configuration',
            'newTopUpValue'=>'Top-up value',
            'activated'=>'Status',
            'newBudget'=>'Allotted Budget'
        );
    }
    public function updateRecord()
    {
        $result = false;
        /*find the autotopup configuration*/
        $autoTopUpConfiguration = AutoTopupConfiguration::model()->findByPk($this->autoConfigIdentity);
        if($autoTopUpConfiguration){
            $autoTopUpConfiguration->topUpValue = $this->newTopUpValue;
            $autoTopUpConfiguration->budget = $this->newBudget;
            $autoTopUpConfiguration->activated = $this->activated;
            $autoTopUpConfiguration->save();
            $result = true;
        }else{
            throw new CHttpException(404,"Auto topup configuration not found.");
        }
        return $result;
    }

    /**
     *
     * @return RemoteDataCache $remoteDataCacheObj
     */
    public function getRemoteDataCacheObject(){
        /**
         * @var RemoteDataCache $remoteDataCacheObj
         */
        $remoteDataCacheObj = RemoteDataCache::model()->findByPk($this->remoteDataCacheId);
        return $remoteDataCacheObj;
    }
} 