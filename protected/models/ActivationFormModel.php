<?php

class ActivationFormModel extends CFormModel
{
    public $accounts;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('accounts', 'required'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'accounts' => 'Accounts',
        );
    }

    public function run()
    {
        //find model by
        $criteria = new CDbCriteria();
        $criteria->addInCondition("sub_user", $this->accounts);
        $remoteDataCacheCollection = RemoteDataCache::model()->findAll($criteria);
        $this->activateAccounts($remoteDataCacheCollection);
    }

    /**
     *
     * @param RemoteDataCache $remoteDataCacheMdl
     * @return bool
     */
    public function activateAccount(RemoteDataCache $remoteDataCacheMdl)
    {
        $sipAccount = new SipAccount();
        $sipAccount->vicidial_identification = $remoteDataCacheMdl->vici_user;
        $activatorObj = new ActivateVicidialUser($sipAccount);
        $reqREs = $activatorObj->run();
        Yii::log($reqREs, CLogger::LEVEL_INFO, "activation");
        /* find the RemoteDataCache and update it too */
        $remoteDataCacheMdl->is_active = "ACTIVE";
        return $remoteDataCacheMdl->save();
    }

    /**
     *
     * @param array $remoteDataCacheAccountsColl
     * @internal param array $remoteDataCacheAccounts
     */
    public function activateAccounts(array $remoteDataCacheAccountsColl)
    {
        foreach ($remoteDataCacheAccountsColl as $currentRemoteDataMdl) {
            $this->activateAccount($currentRemoteDataMdl);
        }

    }
}