<?php

class m150923_104231_create_vicidial_iden_col extends CDbMigration
{
	public function safeUp()
	{
		$this->addColumn("tbl_sip_account", "vicidial_identification", "string");
	}

	public function safeDown()
	{
		$this->dropColumn("tbl_sip_account","vicidial_identification");
	}
}