<?php

class m131210_144542_soft_deletion extends CDbMigration
{
	public function up()
	{
		$this->addColumn('ophmiscan_document_category','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophmiscan_document_category_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophmiscan_document_scan','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophmiscan_document_scan_version','deleted','tinyint(1) unsigned not null');
	}

	public function down()
	{
		$this->dropColumn('ophmiscan_document_category','deleted');
		$this->dropColumn('ophmiscan_document_category_version','deleted');
		$this->dropColumn('ophmiscan_document_scan','deleted');
		$this->dropColumn('ophmiscan_document_scan_version','deleted');
	}
}
