jQuery.noConflict();
$('.ui-autocomplete-input').removeClass('ui-autocomplete-input');
jQuery(document).ready(function($){
	$('#send-notification').on( "click", function(e) {
		var title = $('#ajax-title').html(),
			thumb_url = $('#thumb-url').html(),
			post_id = $('#post-id').html();
	
		var data = {
			action: 'hybrid_send_notification',
			title: title,
			thumb_url: thumb_url,
			post_id: post_id
		};

        e.preventDefault();
        if (window.confirm("هل أنت متأكد من أنك تريد إرسال هذا المقال كإشعار ؟")) {
			$.post(ajaxurl, data, function(response) {
				$('#notification-response').html('لقد تم إرسال المقال');
			});
        }
		return false; 
	});
});