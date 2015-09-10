<?php

class m150910_104650_create_foreign_key_freevoip_transaction extends CDbMigration
{
	public function safeUp()
	{
		$this->addForeignKey("freevoip_transaction_fk", "tbl_transaction_log", "freevoip_account", "tbl_freevoip_accounts", "id", "CASCADE", "CASCADE");
		/**/
	}

	public function safeDown()
	{
        $this->dropForeignKey("freevoip_transaction_fk", "tbl_transaction_log");
	}
}