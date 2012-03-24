var Profile = {
	start: function start(){
		var self = this;
		
		$.ajax({
			type: 'GET',
			url: '/profile',
			beforeSend: function(){
//				$main.html('');
//				Loader.show();
			},
			success: function(data){
//				Loader.remove();
				$main.html('');
				$main.append(data);
			},
			complete: function(){
				self.get();
			}
		});
	},
	get: function get(){
		var image, $picture = $('#profile-picture'), $content = $('#profile-content');
		
		$.ajax({
			type: 'GET',
			url: '/profile/get',
			beforeSend: function(){
				$content.html('');
				$picture.html('');
				Loader.show();
			},
			success: function(data){
				image = '<a href="'+ data[1][0] +'"><img src="/'+ data[1][1] +'" /></a>'; 
				$('#profile-content').append(data[0]);
				Loader.remove();
				$picture.append(image);
			}
		});
	}
}

