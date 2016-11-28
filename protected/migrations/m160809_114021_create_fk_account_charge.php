<?php

class m160809_114021_create_fk_account_charge extends CDbMigration
{
    public function safeUp()
    {
        $this->addForeignKey("account_charge_log_account_id_fk", "tbl_account_charge_log", "account_id", "tbl_remote_data_cache", "id");
    }

    public function safeDown()
    {
        $this->dropForeignKey("account_charge_log_account_id_fk", "tbl_account_charge_log");
    }

}