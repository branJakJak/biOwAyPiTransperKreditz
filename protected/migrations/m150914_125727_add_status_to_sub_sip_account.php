<?php

class m150914_125727_add_status_to_sub_sip_account extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn("tbl_sub_sip_account", "account_status", "enum('active','blocked') default 'active'");
    }

    public function safeDown()
    {
        $this->dropColumn("tbl_sub_sip_account","account_status");
    }

}