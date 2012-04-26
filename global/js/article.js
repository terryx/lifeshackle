$(function(){
	
	$.ajax({
		type: 'GET',
		url: '/article/list-articles',
		success: function(data){
			var str = '';
			
			str += '<ul class="nav nav-pills nav-stacked">';
			
			for(var i=0, len=data.length; i<len; i++){
				str += '<li><a data-id="'+ data[i].article_id +'">'+ data[i].title +'</a></li>';
			}
			
			str += '<ul>';
			
			$('#article-list').append(str);
			
			Article().checklist();
		}
	});
	
});

function Article(){
	var controller = {};
	
	controller.checklist = function checklist(){
		var self = this;
		$('#article-list ul').children('li').bind('click', function(e){
			
			var id = $(e.target).data('id');
			
			self.fetchArticle(id);
		});
	}
	
	controller.fetchArticle = function fetchArticle(id){
		
		$.ajax({
			type: 'GET',
			url: '/article/fetch-one-article/'+id,
			success: function(data){
				console.log(data);
				var str = '';
				
				if(data){
					$('#article-container').html('');
						str += '<h2>'+ data.title +'</h2><br />';
						str += '<div>'+ data.content +'</div>';
						str += '<hr />';
						str += '<p><small>'+ data.date +'</small></p>';
					
					
					
					$('#article-container').append(str);
				}
			}
		});
	}
	
	return controller;
}