<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2012
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2012, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */
?>
<section class="element">
	<header class="element-header">
		<h3 class="element-title"><?php echo $element->elementType->name?></h3>
	</header>

	<div class="element-data">
		<div class="row data-row">
			<div class="large-2 column">
				<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('title'))?>:</div>
			</div>
			<div class="large-10 column">
				<div class="data-value"><?php echo CHtml::encode($element->title)?></div>
			</div>
		</div>
		<div class="row data-row">
			<div class="large-2 column">
				<div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('description'))?>:</div>
			</div>
			<div class="large-10 column">
				<div class="data-value"><?php echo $element->textWithLineBreaks('description')?></div>
			</div>
		</div>
	</div>
</section>

<section class="element">
	<header class="element-header">
		<h3 class="element-title">Preview</h3>
	</header>
	<div class="element-data">
		<div class="row data-row panel">
			<?php echo $this->renderPartial('_pagination',array(
				'page' => 1,
				'pages' => count($element->files),
				'class' => 'view',
			))?>
		</div>
		<?php foreach ($element->files as $i => $scan) {?>
			<div class="row data-row view-scan" data-i="<?php echo $i?>"<?php if ($i >0) {?> style="display: none"<?php }?>>
				<img src="<?php echo Yii::app()->createUrl('/file/view/'.$scan->file->id.'/600x800/'.$scan->file->name)?>" />
			</div>
		<?php }?>
		<div class="row data-row panel">
			<?php echo $this->renderPartial('_pagination',array(
				'page' => 1,
				'pages' => count($element->files),
				'class' => 'view',
			))?>
		</div>
	</div>
</section>

<section class="element">
	<header class="element-header">
		<h3 class="element-title">Attachments</h3>
	</header>
	<div class="element-data">
		<table class="grid">
			<tr>
				<th>Scan date</th>
				<th>Filename</th>
				<th>Category</th>
			</tr>
			<?php foreach ($element->files as $i => $scan) {?>
				<tr>
					<td><?php echo date('j M Y H:i',strtotime($scan->created_date))?></td>
					<td><?php echo CHtml::link($scan->file->name,$scan->file->getDownloadURL())?></td>
					<td><?php echo $scan->category ? $scan->category->name : 'No category'?></td>
				</tr>
			<?php }?>
		</table>
	</div>
</section>
