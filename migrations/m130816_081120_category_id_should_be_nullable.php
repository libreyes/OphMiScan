<?php

class m130816_081120_category_id_should_be_nullable extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('ophmiscan_document_scan','category_id','int(10) unsigned NULL');
	}

	public function down()
	{
		$this->alterColumn('ophmiscan_document_scan','category_id','int(10) unsigned NOT NULL');
	}
}
