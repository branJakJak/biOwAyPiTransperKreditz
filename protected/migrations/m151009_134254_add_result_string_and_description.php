<?php

class m151009_134254_add_result_string_and_description extends CDbMigration
{
	public function up()
	{
		$this->addColumn("tbl_transaction_log", "result_string", "string");
		$this->addColumn("tbl_transaction_log", "result_description", "string");
	}

	public function down()
	{
		$this->dropColumn("tbl_sub_sip_account","result_string");
		$this->dropColumn("tbl_sub_sip_account","result_description");
	}

}