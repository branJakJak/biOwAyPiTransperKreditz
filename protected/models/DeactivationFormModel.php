<?php


class DeactivationFormModel extends CFormModel
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
        $this->deactivateAccounts($remoteDataCacheCollection);
    }

    /**
     *
     * @param RemoteDataCache $remoteDataCacheMdl
     * @return bool
     */
    public function deactivateAccount(RemoteDataCache $remoteDataCacheMdl)
    {
        $sipAccount = new SipAccount();
        $sipAccount->vicidial_identification = $remoteDataCacheMdl->vici_user;

        /**
         * @var VicidialDbDeactivator $deactivator
         */
        $deactivator = Yii::app()->vicidialDeactivator;
        $deactivator->setVicidialUser($sipAccount->vicidial_identification);
        if ($deactivator->run()) {
            $groupId = uniqid();
            ViciActionLogger::logAction(ViciLogAction::VICILOG_ACTION_SUBSIP_DEACTIVIVATE , "$remoteDataCacheMdl->sub_user under $remoteDataCacheMdl->main_user is now deactivated - via remote trigger" , 0  , $groupId, time());
            Yii::log(json_encode("$remoteDataCacheMdl->sub_user under $remoteDataCacheMdl->main_user is now deactivated - via remote trigger"), CLogger::LEVEL_INFO, "deactivation");
        }else{
            Yii::log(json_encode("deactivation failed $remoteDataCacheMdl->sub_user under $remoteDataCacheMdl->main_user"), CLogger::LEVEL_INFO, "deactivation");
        }
        /* find the RemoteDataCache and update it too */
        $remoteDataCacheMdl->is_active = "INACTIVE";
        return $remoteDataCacheMdl->save();
    }

    /**
     *
     * @param array $remoteDataCacheAccountsColl
     * @internal param array $remoteDataCacheAccounts
     */
    public function deactivateAccounts(array $remoteDataCacheAccountsColl)
    {
        foreach ($remoteDataCacheAccountsColl as $currentRemoteDataMdl) {
            $this->deactivateAccount($currentRemoteDataMdl);
        }

    }
}