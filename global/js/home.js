var Life = {
	start: function start(){
		var self = this, month;
		
		$.ajax({
			type: 'GET',
			url: '/article',
//			beforeSend: function(){
//				$main.html('');
//				Loader.show();
//			},
			success: function(data){
//				Loader.remove();
				$main.html('');
				$main.append(data);
			},
			complete: function(){
				self.getArticle();
							
				$('#article-date').children('li').bind('click', function(){
					month = $(this).data('id');
					self.getArticle(month);
				});
			}
		});
	},
	getArticle: function getArticle(month){
		var self = this;
		var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
		var date, year, filter, output;
		var id, li = $('#article-date').children('li');
					
		date = new Date();
					
		if(undefined !== month){
			year = date.getFullYear();
			filter = month + '-' + year;
		} else {
			year = date.getFullYear();
			month = months[date.getMonth()];
			filter = month + '-' + year;
		}
					
		//get current tab
		for(var i=0; i<12; i++){
			id = $(li[i]).data('id');
					
			if(id === filter.split('-')[0]){
				li.removeClass('active');
						
				$(li[i]).addClass('active');
			}
		}
				
		$.ajax({
			type: 'GET',
			url: '/get-article/'+ filter,
			dataType: 'json',
			beforeSend: function(){
				$('#article').html('');
				Loader.show();
			},
			success: function(data){
				if(data){
					$('#article').html('');
					Loader.remove();
								
					if(data.length > 0){
						output = self.renderArticle(data);
						$('#article').append(output);
					} else {
						$('#article').append('<div class="pager"><h3>There is no article in this month, because I\'\m so lazy</h3></div>');
					}
				}
			}
		});
	},
	renderArticle: function renderArticle(data){
		var str = '';
		for(var i=0, len=data.length; i<len; i++){
			str += '<div class="row-fluid">';
			str += '<h2>' + data[i].k1 + '</h2>';
			str += '<p><small>';
			
			if(data[i].k3 !== '0'){
				str += 'Last edited on ' + timeHistory(data[i].k3);
			} else {
				str += 'Created on ' + timeHistory(data[i].k2);
			}
						
			str += '</small></p>';
			str += data[i].k5;
			str += '<hr />';
			str += '</div>';
		}
		return str;
	}
}