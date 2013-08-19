<?php
class DefaultController extends BaseEventTypeController {
	public function actionCreate() {
		Yii::app()->clientScript->registerScriptFile(Yii::app()->createUrl('js/jquery.zoom.js'));
		return parent::actionCreate();
	}

	public function actionUpdate($id) {
		Yii::app()->clientScript->registerScriptFile(Yii::app()->createUrl('js/jquery.zoom.js'));
		return parent::actionUpdate($id);
	}

	public function actionDeleteScan() {
		if ($scan = OphMiScan_Document_Scan::model()->findByPk($_POST['scan_id'])) {
			if (!$scan->delete()) {
				echo "0";
				return;
			}

			echo "1";
		}
	}
}
