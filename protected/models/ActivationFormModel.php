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
        $this->accounts = explode(",", $this->accounts);
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
        /**
         * @var VicidialDbDeactivator $deactivator
         */
        $activator = Yii::app()->vicidialActivator;
        $activator->setVicidialUser($sipAccount->vicidial_identification);
        if ($activator->run()) {

            $groupId = uniqid();
            ViciActionLogger::logAction(ViciLogAction::VICILOG_ACTION_SUBSIP_ACTIVIVATE , "$remoteDataCacheMdl->sub_user under $remoteDataCacheMdl->main_user is now activated" , 0  , $groupId, time());

            Yii::log(json_encode("$remoteDataCacheMdl->sub_user under $remoteDataCacheMdl->main_user is now activated"), CLogger::LEVEL_INFO, "activation");
        }else{
            Yii::log(json_encode("deactivation failed $sipAccount->vicidial_identification"), CLogger::LEVEL_INFO, "activation");
        }
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