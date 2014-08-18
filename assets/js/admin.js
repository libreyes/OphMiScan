$(function() {
	$('img.thumbnail').load(function() {
		$(this).prev('img.thumbnail-loader').hide();
		$(this).show();

		var url = $(this).closest('.column').attr('data-attr-preview-link');

		$(this).parent().zoom({
			url: url
		});
	});
})