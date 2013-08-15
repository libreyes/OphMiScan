<?php 	$this->breadcrumbs=array($this->module->id);
	$this->header();
?>
<h3 class="withEventIcon" style="background:transparent url(<?php echo $this->assetPath?>/img/medium.png) center left no-repeat;"><?php echo $this->event_type->name ?></h3>

<div>
	<?php 		$form = $this->beginWidget('BaseEventTypeCActiveForm', array(
			'id'=>'clinical-create',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('class'=>'sliding'),
			// 'focus'=>'#procedure_id'
		));
		$this->event_actions[] = EventAction::button('Save', 'save', array('colour' => 'green'));
		$this->renderPartial('//patient/event_actions');
	?>
	<?php  $this->displayErrors($errors)?>
	<?php  $this->renderDefaultElements($this->action->id, $form); ?>
	<?php  $this->renderOptionalElements($this->action->id, $form); ?>
	<?php  $this->displayErrors($errors)?>
		<div class="cleartall"></div>
	<?php  $this->endWidget(); ?></div>
<?php  $this->footer(); ?>
