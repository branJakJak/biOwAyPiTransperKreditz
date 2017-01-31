<?php

class m170131_143725_add_is_hidden_column extends CDbMigration
{
	public function safeUp()
	{
		$this->addColumn("tbl_remote_data_cache", 'is_hidden', 'boolean');
	}

	public function safeDown()
	{
		$this->dropColumn("tbl_remote_data_cache", "is_hidden");
	}
}