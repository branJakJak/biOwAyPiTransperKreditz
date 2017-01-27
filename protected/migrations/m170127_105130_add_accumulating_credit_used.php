<?php

class m170127_105130_add_accumulating_credit_used extends CDbMigration
{

	public function safeUp()
	{
        $this->addColumn("tbl_remote_data_cache", "accumulating_credits_used", 'double default 0');
        /*make all remote datacache last_balance_since_topup equal to current balance*/
        $allModels = RemoteDataCache::model()->findAll();
        foreach ($allModels as $currentModel) {
            $currentModel->last_balance_since_topup = $currentModel->exact_balance;
            $currentModel->save();
        }
	}

	public function safeDown()
	{
        $this->dropColumn("tbl_remote_data_cache", "accumulating_credits_used");
	}
}