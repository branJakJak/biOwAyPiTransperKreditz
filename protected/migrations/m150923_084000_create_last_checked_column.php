<?php

class m150923_084000_create_last_checked_column extends CDbMigration
{

	public function safeUp()
	{
		$this->addColumn("tbl_sub_sip_account", "last_checked_bal", "double");
	}

	public function safeDown()
	{
		$this->dropColumn("tbl_sub_sip_account","last_checked_bal");
	}
}