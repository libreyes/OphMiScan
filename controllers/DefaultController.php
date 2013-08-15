<?php

class DefaultController extends BaseEventTypeController {
	public function actionCreate() {
		Yii::app()->clientScript->registerScriptFile(Yii::app()->createUrl('js/jquery.zoom.js'));
		return parent::actionCreate();
	}
}
