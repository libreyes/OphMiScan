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
<div class="scan-preview"></div>
<div class="to-delete"></div>
<ul class="scan-thumbnails">
	<?php foreach ($element->scans as $i => $scan) {?>
		<li>
			<div class="scan-thumbnail-container">
				<div class="scan-thumbnail<?php if ($element->isSelected($scan->id)) {?> selected<?php }?>">
					<div class="scan-thumbnail-image" style="background-image:url('<?php echo Yii::app()->createUrl('/file/view/'.$scan->file->id.'/200_60x60/'.$scan->file->name)?>');" data-id="<?php echo $scan->id?>" data-attr-preview-link="<?php echo Yii::app()->createUrl('/file/view/'.$scan->file->id.'/600x800/'.$scan->file->name)?>"></div>
					<div class="scan-thumbnail-date">
						<?php echo date('j M Y H:i',strtotime($scan->created_date))?>
					</div>
					<div>
						<?php echo CHtml::dropDownList('category_id[]',(!empty($_POST) ? @$_POST['category_id'][$i] : $scan->category_id),CHtml::listData(OphMiScan_Document_Category::model()->findAll(array('order'=>'name')),'id','name'),array('empty'=>'- No category -','disabled'=>!$element->isSelected($scan->id)))?>
					</div>
					<div class="scan-thumbnail-preview-link">
						<button type="submit" class="classy blue mini preview-thumbnail"><span class="button-span button-span-blue">View</span></button>
						<?php if (@$can_delete) {?>
							<button type="submit" class="classy red mini delete"><span class="button-span button-span-red">Delete</span></button>
						<?php }?>
					</div>
					<input type="hidden" name="ProtectedFile[]" value="<?php echo $scan->id?>"<?php if (!$element->isSelected($scan->id)){?> disabled="disabled"<?php }?> />
				</div>
			</div>
		</li>
	<?php }?>
</ul>
<div id="confirm_delete_scan" title="Confirm delete scan" style="display: none;">
	<div>
		<div id="delete_scan">
			<div class="alertBox" style="margin-top: 10px; margin-bottom: 15px;">
				<strong>WARNING: This will permanently delete the scanned document.</strong>
			</div>
			<p>
				<strong>Are you sure you want to proceed?</strong>
			</p>
			<div class="buttonwrapper" style="margin-top: 15px; margin-bottom: 5px;">
				<button type="submit" class="classy red venti btn_delete_scan"><span class="button-span button-span-red">Delete scan</span></button>
				<button type="submit" class="classy green venti btn_cancel_delete_scan"><span class="button-span button-span-green">Cancel</span></button>
				<img class="loader" src="<?php echo Yii::app()->createUrl('img/ajax-loader.gif')?>" alt="loading..." style="display: none;" />
				<input type="hidden" id="delete_scan_id" name="delete_scan_id" value="" />
			</div>
		</div>
	</div>
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
			dialogClass: 'dialog',
		}).open();
	});

	$('div.scan-thumbnail-image').click(function() {
		if ($(this).parent().hasClass('selected')) {
			$(this).parent().removeClass('selected');
			$(this).parent().children('input[type="hidden"]').attr('disabled','disabled');
			$(this).next('div').next('div').children('select').attr('disabled','disabled');
		} else {
			$(this).parent().addClass('selected');
			$(this).parent().children('input[type="hidden"]').removeAttr('disabled');
			$(this).next('div').next('div').children('select').removeAttr('disabled');
		}
	});

	$('div.pagination .page').die('click').live('click',function(e) {
		e.preventDefault();

		OphMiScan_selectPage($(this).text());
	});

	$('a.prev').die('click').live('click',function(e) {
		e.preventDefault();

		var page = parseInt($('div.pagination span.page').text());

		OphMiScan_selectPage(page-1);
	});

	$('a.next').die('click').live('click',function(e) {
		e.preventDefault();

		var page = parseInt($('div.pagination span.page').text());

		OphMiScan_selectPage(page+1);
	});

	<?php if (@$dragsort) {?>
		$('.scan-thumbnails').sortable();
	<?php }?>

	$('button.delete').click(function(e) {
		e.preventDefault();

		$('#delete_scan_id').val($(this).parent().parent().children('div').attr('data-id'));

		new OpenEyes.Dialog.Confirm({
			title: "Confirm delete scan",
			content: "<strong><p>WARNING: This will permanently delete the scanned document.</p><br/><p>Are you sure you want to proceed?</p></strong>",
			okButton: "Delete scan",
			onOk: function() {
				$.ajax({
					'type': 'POST',
					'url': baseUrl+'/OphMiScan/default/deleteScan',
					'data': "scan_id="+$('#delete_scan_id').val()+"&YII_CSRF_TOKEN="+YII_CSRF_TOKEN,
					'success': function(resp) {
						if (resp != '1') {
							alert("An internal error occurred, please try again or contact support for assistance.");
						} else {
							$('div.to-delete').append('<input type="hidden" name="ToDelete[]" value="'+$('#delete_scan_id').val()+'" />');
							$('div.scan-thumbnail-image[data-id="'+$('#delete_scan_id').val()+'"]').closest('li').remove();
						}
					}
				});
			}
		}).open();
	});

function OphMiScan_selectPage(page) {
	$('div.scan-thumbnails').hide();
	$('#scan-thumbnails-'+((page-1) * 18)).show();
	$('#scan-thumbnails-'+(((page-1) * 18)+6)).show();
	$('#scan-thumbnails-'+(((page-1) * 18)+12)).show();

	$('div.pagination span.page').replaceWith('<a href="#" class="page" data-attr-page="'+$('div.pagination span.page').text()+'">'+$('div.pagination span.page').text()+'</a>');
	$('div.pagination a[data-attr-page="'+page+'"]').replaceWith('<span class="page">'+page+'</span>');

	if (page >1) {
		$('span.prev').replaceWith('<a href="#" class="prev">&laquo; back</a>');
	} else {
		$('a.prev').replaceWith('<span class="prev">&laquo; back</span>');
	}

	if ($('a.page[data-attr-page="'+(page+1)+'"]').length >0) {
		$('span.next').replaceWith('<a href="#" class="next">next &raquo;</a>');
	} else {
		$('a.next').replaceWith('<span class="next">next &raquo;</span>');
	}
}
</script>
