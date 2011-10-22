function beforeCall(){
	Common.bindLoading('#submit');
	return true;
}

function ajaxCallback(status, form, json){
	if(status === true && json.is_logged_in === true) {
		window.location = 'home';
	}
}

function ajaxFail(msg){
	if ($('.alert-message').length === 0) {
		var str = '<div id="test" class="alert-message error" data-alert>'+
		'<a class="close" href="g">x</a>'+
		'<p>'+$.parseJSON(msg)+'</p>'+
		'</div>';
		$('#main-content').prepend(str);
	}
}

$(function(){
	jQuery("#login-form").validationEngine({
		ajaxFormValidation: true,
		onBeforeAjaxFormValidation: beforeCall,
		onAjaxFormComplete: ajaxCallback
	});

});
