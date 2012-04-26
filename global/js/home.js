var Life = {
	start: function start(){
		var self = this;
		
		$.ajax({
			type: 'GET',
			url: '/article/fetch-articles',
			beforeSend: function(){
				Loader.show();
			},
			success: function(data){
				var html = new EJS({url: '/global/template/article.ejs'}).render(data);
				$main.append(html);
			}
		});
	},
	
	firstLoad: function firstLoad(frame){
		
		var self = this;
		var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
		var date, year, month, active, output;
		
		date = new Date();
		year = date.getFullYear();
		month = months[date.getMonth()];
		active = month + '-' + year;
		
		$.ajax({
			type: 'GET',
			url: '/get-article/'+ active,
			dataType: 'json',
			success: function(data){
				if(data){
					Loader.remove();
					$main.append(frame);
					
					if($('#article-date').children('li').data('id') === active){
						$('#article-date').children('li').addClass('active');
					}
					
					if(data.length > 0){
						output = self.renderArticle(data);
						$('#article').append(output);
					} else {
						$('#article').append('<div class="pager"><h3>There is no article in this month, because I\'\m so lazy</h3></div>');
					}
				}
			},
			complete: function(){
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
		
		if(undefined !== month && null !== month){
			year = date.getFullYear();
			filter = month + '-' + year;
			Loader.show();
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
			},
			success: function(data){
				if(data){
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