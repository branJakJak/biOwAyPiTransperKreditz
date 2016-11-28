<?php

class m160317_133855_create_autotopup_rel extends CDbMigration
{

	public function safeUp()
	{
        $this->addForeignKey("autoTopUpRemoteDataCache_fk", "tbl_auto_topup_configuration", "freeVoipAccount", "tbl_freevoip_accounts", "id","CASCADE","CASCADE");
        $this->addForeignKey("autoTopUpFreeVoipAccount_fk", "tbl_auto_topup_configuration", "remote_data_cache", "tbl_remote_data_cache", "id","CASCADE","CASCADE");
    }

	public function safeDown()
	{
        $this->dropForeignKey("autoTopUpRemoteDataCache_fk", "tbl_auto_topup_configuration");
        $this->dropForeignKey("autoTopUpFreeVoipAccount_fk", "tbl_auto_topup_configuration");			
	}
}