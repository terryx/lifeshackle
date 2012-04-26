var Video = {
	start: function start(){
		var self = this;
		
		$.ajax({
			type: 'GET',
			url: '/video',
			beforeSend: function(){
			},
			success: function(data){
				$main.html('');
				$main.append(data);
			},
			complete: function(){
				self.get();
			}
		});
	},
	get: function get(){
		var self = this, $content = $('#video-panel');
		
		self.countTotal(function(total){
			self.pagination(total);
			
		});
	},
	countTotal: function countTotal(callback){
		$.ajax({
			type: 'GET',
			url: '/video/count-total',
			success: function(data){
				if(data){
					callback(data);
				}
			}
		});
	},
	pagination: function pagination(total){
		var self = this;
		
		var str = '';
		str += '<div class="pagination">';
		str += '<ul>';
		str += '<li data-id="prev-video"><a href="#">Prev</a></li>'; 
		for(var i=1; i<=total; i++){
			if(i===1){
				str += '<li class="active"><a href="#">'+ i +'</a></li>';
			} else{
				str += '<li><a href="#">'+ i +'</a></li>';
			}
		}
		str += '<li data-id="next-video"><a href="#">Next</a></li>';
		str += '</ul>';
		str += '</div>';
		
		$('#video-pager').append(str);
		
		self.getPagination(1);
		self.onChange();
	},
	getPagination: function getPagination(page){
		var str = '', $panel = $('#video-panel');
		
		$.ajax({
			type: 'GET',
			url: '/video/get-pagination/' + page,
			beforeSend: function(){
				$panel.html('');
				Loader.show();
			},
			success: function(data){
				if(data){
					str += '<ul class="thumbnails">';
					for(var i=0, len=data.length; i<len; i++){
						str += '<li class="span2">';	
						str += '<a href="'+ data[i].k2 +'/" class="thumbnail" target="_blank">';
						str += '<img src="'+ data[i].k3+'" alt="">'
						str += '</a>';
						str += '</li>';
					}
					str += '</ul>';
					
					Loader.remove();
					$panel.append(str);
				}
			}
		});
	},
	onChange: function onChange(){
		var page, $active, activeId, self = this;
		
		$('.pagination ul').children('li').bind('click', function(e){
			page = $(e.target).html();
			
			$active = $('.pagination ul').children('li.active');
			activeId = $('.pagination ul').children('li.active').children('a').html();
			activeId = parseInt(activeId);
			
			switch(page){
				case 'Prev':
					page = prev(activeId);
					break;
				case 'Next':
					page = next(activeId);
					break;
				default:
					$active.removeClass('active');
					$(this).addClass('active');
			}
			
			self.getPagination(page);
			
			function prev(activeId){
				var page = activeId - 1;
				if(page !== 0){
					$active.removeClass('active');
					$active.prev().addClass('active');
				} else {
					page = 1;
				}
				return page;
			}
			
			function next(activeId){
				var page = activeId + 1;
				var totalpage = $('.pagination ul').children('li').length - 2;
				if(page <= totalpage){
					$active.next().addClass('active');
					$active.removeClass('active');
				} else {
					page = totalpage;
				}
				return page;
			}
		});
	}
}