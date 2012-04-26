var Loader = function Loader(option){
	var default_option = {
		panel: '',
		display: false
	};
	
	option = $.extend({}, default_option, option);
	
	var loader = '<div id="loader"></div>';
	
	if(option.display === true){
		if($('#loader').length > 0){
			return;
		} else {
			$(option.panel).html('').append(loader);
		}
	} else {
		$(option.panel).html('');
	}
}

var Alert = {
	init: function init(){
		var block = $('.alert-block');
		
		return block;
	},
	message : function(content, type){
		var $alertBlock = this.init();
		switch(type){
			case 'alert':
				type = 'alert';
				break;
			case 'info':
				type = 'alert alert-info';
				break;
			case 'success':
				type = 'alert alert-success';
				break;
			case 'error':
				type = 'alert alert-error';
				break;
			case 'danger':
				type = 'alert alert-danger';
				break;
			default:
				type = 'alert alert-error';
				break;
		}
		$alertBlock.html('');
		$alertBlock.append('<div class="'+ type +'"><a class="close" data-dismiss="alert" href="#">&times;</a>'+ content +'</div>');
	},
	clear: function(){
		this.init().html('');
	}
}

var Search = {
	onload : function(ajaxCall, form){
		$('#search-result').html('');
		$.get(ajaxCall, function(data){
			if(data){
				var list = '<table class="zebra-striped">';

				for(var i=0;i<data.length;i++){
					list += '<tr onclick="Search.getOne(\''+ data[i].k0 +'\')"><td class="result-item">'+ data[i].k1+'</td></tr>';
				}

				list += '</table>';

				$('#search-result').append(list);
			}
		});
	},
	filter : function(){
		var keyword = $('#search').val();
		var list = $('.result-item');
		
		for(var count = 0; count < list.length; count++){
			if(list[count].textContent.length < keyword.length){
				$(list[count]).hide();
			} else {
				if(list[count].textContent.substr(0, keyword.length).toLowerCase() === keyword.toLowerCase()){
					$(list[count]).show();
				} else {
					$(list[count]).hide();
				}
			}
		} //end for loop
	},
	getOne : function(id){
	 
		//          if(form !== undefined){
		//            $(form)[0].reset();
		//            $(form).validationEngine('hideAll');
		//          }
		$('.alert-message').remove();

		refreshForm(id);
	}
};

function timeHistory(string){
	var now		= new Date().getTime(),
	intTime		= parseInt((string), 10) * 1000,
	record		= new Date(intTime),
	diffTime	= now - record,
	timeMsg     = '';
		
	var daysDifference  = Math.floor(diffTime / 1000 / 60 / 60 / 24);
		
	if (daysDifference > 7) {
		var months = [
		"January", "February", "March", "April",
		"May", "June", "July", "August",
		"September", "October", "November", "December"
		];
        
		timeMsg = months[record.getMonth()] + ' ' + record.getDate() + ', ' + record.getFullYear();
	} else if (daysDifference) {
		timeMsg =  daysDifference + ' days ago';
	} else {
		var hoursDifference = Math.floor(diffTime / 1000 / 60 / 60);

		if (hoursDifference) {
			timeMsg = hoursDifference + ' hours ago';
		} else {
			var minutesDifference = Math.floor(diffTime / 1000 / 60);

			if (minutesDifference) {
				timeMsg = minutesDifference + ' minutes ago';
			} else {
				var secondsDifference = Math.floor(diffTime / 1000);
                
				if (secondsDifference) {
					timeMsg = secondsDifference + ' seconds ago';
				} else {
					timeMsg = 'few seconds ago';
				}
			}
		}
	}
    
	return timeMsg;
}