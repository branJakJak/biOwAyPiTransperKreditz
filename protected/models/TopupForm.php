<?php

class TopupForm extends CFormModel
{
    public $accounts;
    public $topupvalue;
    public $freeVoipAccountUsername = 'jawdroppingcalls';
    public $andActivate = false;
    public $forceAgent;
    public $scheduleForceAgent = false;
    public $scheduleTime;


    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('accounts, topupvalue,freeVoipAccountUsername', 'required'),
            array('topupvalue', 'numerical'),
            array('andActivate,forceAgent,scheduleForceAgent,scheduleTime', 'safe'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'accounts' => 'Accounts',
            'topupvalue' => 'Top-up value',
            'andActivate' => 'And activate',
            'forceAgent' => 'Force agent'
        );
    }

    /**
     *
     * @throws Exception
     * @return integer Returns number of updated accounts
     */
    public function topupAccounts()
    {
        $accountsAffectedInt = 0;
        $accountsArr = explode(",", $this->accounts);
        $groupId = uniqid();
        foreach ($accountsArr as $key => $currentAccountName) {
            /**
             * @var $model RemoteDataCache
             */
            $model = RemoteDataCache::model()->findByAttributes(array('sub_user' => $currentAccountName));
            if ($model) {
                //is this scheduled top up ?
                if ($this->scheduleForceAgent) {
                    /*schedule the topup and force agent*/
                    $newScheduledTopup = new ScheduledForceAgent();
                    $newScheduledTopup->forceAgent = $this->forceAgent;
                    $newScheduledTopup->activate = intval($this->andActivate);
                    $newScheduledTopup->topup_amount = $this->topupvalue;
                    $newScheduledTopup->scheduled_date = $this->scheduleTime;
                    $newScheduledTopup->account_id = $model->id;
                    if (!$newScheduledTopup->save()) {
                        throw new Exception(CHtml::errorSummary($newScheduledTopup));
                    }
                } else {
                    //proceed as normal
                    //topup the main account
                    /**
                     * @var $topUpMainAccount TopUpMainAccount
                     */
                    $topUpMainAccount = Yii::app()->topUpMainAccount;
                    $topUpMainAccount->topUp($this->freeVoipAccountUsername, $this->topupvalue, $model);
                    //$this->topUpMainAccount($model); // topup the main account  , old implementation

                    //TOPUP the sub accounts
                    $remoteAcctUpdated = new ApiRemoteUpdateBalance(
                        $model->sub_pass,
                        $model->sub_user,
                        $model->main_pass,
                        $model->main_user,
                        $this->topupvalue
                    );
                    /**
                     * Logger
                     */
                    ViciActionLogger::logAction("SUB_ACCOUNT_TOPUP", "Top upping {$model->sub_user} with {$this->topupvalue}", $this->topupvalue, $groupId, time());

                    if ($remoteAcctUpdated->update()) {
                        if ($this->andActivate) {
                            /**
                             * @TODO - use Yii component
                             */
                            $activator = new ActivationFormModel();
                            $activator->activateAccount($model);
                        }
                    }

                    /**
                     * Get the latest data from remote api
                     */
                    $lastBalance = $model->balance;
                    $voipInfoRetriever = new BestVOIPInformationRetriever();
                    $remoteVoipResult = $voipInfoRetriever->getInfo($model->main_user, $model->main_pass, $model->sub_user, $model->sub_pass);

                    /**
                     * Checking
                     */
                    if ($model->last_balance_since_topup !== 0 && !is_null($model->last_balance_since_topup)) {
                        /**
                         * Create a charge log for certain remote data cache
                         */
                        $newChargeLog = new AccountChargeLog();
                        $newChargeLog->account_id = $model->id;
                        $newChargeLog->charge = doubleval($model->last_balance_since_topup) - doubleval($model->exact_balance);
                        if (!$newChargeLog->save()) {
                            throw new Exception(CHtml::errorSummary($newChargeLog));
                        }
                    }
                    $model->balance = doubleval($remoteVoipResult->getBalance());
                    $model->exact_balance = doubleval($remoteVoipResult->getSpecificBalance());
                    $model->last_balance = $lastBalance;
                    $model->last_balance_since_topup = $remoteVoipResult->getSpecificBalance();
                    $model->save();

                    /**
                     * Force the RemoteDataCache instance to update its current campaign
                     */
                    $campaignForcer = Yii::app()->campaignForcer;
                    $campaignForcer->update($this->forceAgent, $model->sub_user);
                }
                /**
                 * Update the counter
                 */
                $accountsAffectedInt++;

            }
        }
        return $accountsAffectedInt;
    }

    public function topUpMainAccount(RemoteDataCache $subAccount)
    {
        $criteria = new CDbCriteria;
        $criteria->compare("username", $this->freeVoipAccountUsername);
        $freeVoipAccount = FreeVoipAccounts::model()->find($criteria);
        if ($freeVoipAccount) {
            //transfer fund from FreeVoipAccount to SipAccount
            $rmt = new RemoteTransferFund();
            $remoteResult = $rmt->commitTransaction(
                $freeVoipAccount->username,
                $freeVoipAccount->password,
                $subAccount->main_user, //user or the resller
                doubleval($this->topupvalue),
                $freeVoipAccount->pincode
            );
            ViciActionLogger::logAction("MAIN_TOPUP", "Credit increased account {$subAccount->main_user}", $this->topupvalue, uniqid(), time());
        } else {
            throw new CHttpException(404, "$this->freeVoipAccountUsername doesnt exists");
        }

    }

    public function refreshCreditsUsed()
    {
        /**
         * @var $currentModel RemoteDataCache
         */
        $allRemoteDataCacheModels = RemoteDataCache::model()->findAll();
        foreach ($allRemoteDataCacheModels as $currentModel) {
            //get credit used ,
            $currentModel->last_balance_since_topup = floatval($currentModel->last_balance_since_topup);
            $currentModel->exact_balance = floatval($currentModel->exact_balance);
            $currentModel->accumulating_credits_used = floatval($currentModel->accumulating_credits_used);
            $creditsUsed = (  $currentModel->last_balance_since_topup - $currentModel->exact_balance) + $currentModel->accumulating_credits_used;
            // add it to current occumulating credits used
            if ($creditsUsed > 0) {
                $currentModel->accumulating_credits_used = $creditsUsed;
            } else {
                $currentModel->accumulating_credits_used = 0;
            }
            //done
            $currentModel->update();
            $traceMessage = sprintf("Updated occumulated credits used of %s using record %s", $currentModel->accumulating_credits_used, $currentModel->id);
            Yii::trace($traceMessage);
        }
    }
}