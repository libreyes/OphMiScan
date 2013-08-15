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
<div class="selectedFiles">
	<?php
	if (!empty($_POST['ProtectedFile'])) {
		foreach ($_POST['ProtectedFile'] as $file_id) {?>
			<input type="hidden" name="ProtectedFile[]" value="<?php echo $file_id?>" />
		<?php }
	}?>
</div>
<div class="scan-preview"></div>
<div class="scan-thumbnails">
	<?php foreach (ProtectedFile::model()->findAllBySource('Scanner') as $i => $file) {?>
		<?php if ($i >0 && ($i % 6) == 0) {?>
			</div><div class="scan-thumbnails">
		<?php }?>
		<div class="scan-thumbnail<?php if (!empty($_POST['ProtectedFile']) && in_array($file->id,$_POST['ProtectedFile'])) {?> selected<?php }?>">
			<div class="scan-thumbnail-image" style="background-image:url('<?php echo Yii::app()->createUrl('/file/view/'.$file->id.'/200_60x60/'.$file->name)?>');" data-id="<?php echo $file->id?>" data-attr-preview-link="<?php echo Yii::app()->createUrl('/file/view/'.$file->id.'/600x800/'.$file->name)?>"></div>
			<div class="scan-thumbnail-date">
				<?php echo date('j M Y H:i',strtotime($file->created_date))?>
			</div>
			<div class="scan-thumbnail-preview-link">
				<button type="submit" class="classy blue mini preview-thumbnail"><span class="button-span button-span-blue">Preview</span></button>
			</div>
		</div>
	<?php }?>
</div>
<script type="text/javascript">
	$('div.scan-thumbnail-image').map(function() {
		var url = $(this).attr('data-attr-preview-link');

		$(this).zoom({
			url: url
		});
	});

	$('button.preview-thumbnail').click(function(e) {
		e.preventDefault();

		var url = $(this).parent().parent().children('div.scan-thumbnail-image').attr('data-attr-preview-link');

		new OpenEyes.Dialog({
			content: '<img src="'+url+'" />',
			width: 600,
			position: 'top',
			dialogClass: 'dialog pdf-preview',
		}).open();
	});

	$('div.scan-thumbnail-image').click(function() {
		if ($(this).parent().hasClass('selected')) {
			$(this).parent().removeClass('selected');
			$('input[name="ProtectedFile[]"][value="'+$(this).attr('data-id')+'"]').remove();
		} else {
			$(this).parent().addClass('selected');
			$('.selectedFiles').append('<input type="hidden" name="ProtectedFile[]" value="'+$(this).attr('data-id')+'" />');
		}
	});
</script>
