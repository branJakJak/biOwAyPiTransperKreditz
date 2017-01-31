<?php

class m170130_194733_add_new_cols_creditsUsed_logs extends CDbMigration
{
	public function safeUp()
	{
		$this->addColumn("credits_used_logs", 'remote_data_cache_accout_id', 'integer');
		$this->addForeignKey("credits_used_logs_fk",'credits_used_logs','remote_data_cache_accout_id','tbl_remote_data_cache','id','NO ACTION','NO ACTION');
	}

	public function safeDown()
	{
		$this->dropColumn("credits_used_logs", "remote_data_cache_accout_id");
		$this->dropForeignKey("credits_used_logs_fk", 'credits_used_logs');
	}
}