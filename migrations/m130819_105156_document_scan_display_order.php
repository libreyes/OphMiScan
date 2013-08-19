<?php

class m130819_105156_document_scan_display_order extends CDbMigration
{
	public function up()
	{
		$this->addColumn('ophmiscan_document_scan','display_order','int(10) unsigned NOT NULL');
	}

	public function down()
	{
		$this->dropColumn('ophmiscan_document_scan','display_order');
	}
}
