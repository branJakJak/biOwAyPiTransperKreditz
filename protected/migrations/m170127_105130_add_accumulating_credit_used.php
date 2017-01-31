<?php

class m170127_105130_add_accumulating_credit_used extends CDbMigration
{

	public function safeUp()
	{
        $this->addColumn("tbl_remote_data_cache", "accumulating_credits_used", 'double default 0');
        /*make all remote datacache last_balance_since_topup equal to current balance*/
	}

	public function safeDown()
	{
        $this->dropColumn("tbl_remote_data_cache", "accumulating_credits_used");
	}
}