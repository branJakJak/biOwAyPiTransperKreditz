<?php

class m150914_140030_add_customer_name_and_balance_sub_sip_account extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->addColumn("tbl_sub_sip_account", "customer_name", "string");
		$this->addColumn("tbl_sub_sip_account", "balance", "double");
		$this->addColumn("tbl_sub_sip_account", "exact_balance", "double");
	}

	public function safeDown()
	{
		$this->dropColumn("tbl_sub_sip_account","customer_name");
		$this->dropColumn("tbl_sub_sip_account","balance");
		$this->dropColumn("tbl_sub_sip_account","exact_balance");
	}
}