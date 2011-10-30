var Common = {
	load : function(){
		var body= $('html').height();
		$('#loader').height(body);
	},
	wait : function() {
		var str = '<div id="progress"></div>';
		$('#main-content').append(str);
	},
	end : function(){
		$('#progress').remove();
	},
	clearDiv : function(div){
		div = div ? $(div).html('') : false;
	},
	removeDiv : function(div){
		div = div ? $(div).remove() : false;
	},
	bindLoading: function(id){
		$(id).removeClass('pre').addClass('post');
		$(id).val('');
	},
	unbindLoading: function(id, msg){
		$(id).removeClass('post').addClass('pre');
		$(id).val(msg);
	}
}
var MenuSetting = {
	//	create : function(){
	//		$('.menu').mouseover(function(){
	//			$(this).children('a').css('display', 'block');
	//		});
	//		$('.menu').mouseout(function(){
	//			$(this).children('a').css('display', 'none');
	//		});
	//	},
	resetButton : function(options){

		var str = '<div class="menu" style="margin-left:105px"><div id="newForm">New</div></div>';
		$(str).appendTo('#menubar');

			options : {
				form          : null
				iframe        : null
				hiddenId      : null
			}
		$('#newForm').click(function(){
			$(options.form)[0].reset();

			//clear hidden field
			options.hiddenId = null ? null : $(options.hiddenId).val('');

			//clear iframe
			if(options.iframe !== null){
				$(options.iframe).contents().find('body').html('');
			}

			//clear delete button
			$('#deleteButton').html('');

		});
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

function displayMessage(type, msg, div, close){
	//type = warning, success, error, info
	var checked = $('.alert-message').length >= 0 ? $('.alert-message').remove() : false;
	var closeView = '';
	
	//element setup - position where message box located
	if(div === undefined){
		div = '#main-content';
	}
	
	//close button setup - enabled by default
	if(close === undefined){
		close = true;
	} else {
		close = false;
	}
	
	if(close === true){
		closeView = '<a class="close" href="#">x</a>';
	}
	
	if(checked){
		if(type !== 'warning' && type !== 'error' && type !== 'success' && type !== 'info'){
			type = 'warning';
		}
		
		var str = '<div class="alert-message '+ type +'" data-alert>'+
		closeView +
		'<p>'+ msg +'</p>'+
		'</div>';
		
		$(div).prepend(str);
	}	
}

$(function(){
	Common.load();
	//	MenuSetting.create();
	$('#loader').remove();
  
	$('.nav > li').each(function(){
		
		if($(this).children('a').attr('href') == document.URL){
			
			$(this).addClass('active');
		
		}
	});

	// POSITION STATIC TWIPSIES
	$(window).bind( 'load resize', function () {
		  
		$('body > .topbar').scrollSpy();
		
		$(".twipsies a").each(function () {
			$(this)
			.twipsy({
				live: false
				, 
				placement: $(this).attr('title')
				, 
				trigger: 'manual'
				, 
				offset: 2
			})
			.twipsy('show');
		});
	});
});