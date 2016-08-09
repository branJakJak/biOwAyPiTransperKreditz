<?php

class m160809_095703_create_last_top_up_column extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn("{{remote_data_cache}}","last_balance_since_topup","double default 0");
    }

    public function safeDown()
    {
        $this->dropColumn("{{remote_data_cache}}", "last_balance_since_topup");
    }
}