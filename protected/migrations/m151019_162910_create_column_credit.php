<?php

class m151019_162910_create_column_credit extends CDbMigration
{
	public function safeUp()
	{
		$this->addColumn("tbl_freevoip_accounts", "credits", "string");
	}

	public function safeDown()
	{
		$this->dropColumn("tbl_freevoip_accounts","credits");
	}
}