<?php

class m150914_124552_add_status_to_sip_account extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->addColumn("tbl_sip_account", "account_status", "enum('active','blocked') default 'active'");
	}

	public function safeDown()
	{
		$this->dropColumn("tbl_sip_account","account_status");
	}
}