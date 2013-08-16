<?php

class m130816_081447_remove_unnecessary_fields extends CDbMigration
{
	public function up()
	{
		$this->dropColumn('ophmiscan_document_scan','title');
		$this->dropColumn('ophmiscan_document_scan','description');
	}

	public function down()
	{
		$this->addColumn('ophmiscan_document_scan','title','varchar(255) COLLATE utf8_bin DEFAULT NULL');
		$this->addColumn('ophmiscan_document_scan','description','varchar(1024) COLLATE utf8_bin DEFAULT NULL');
	}
}
