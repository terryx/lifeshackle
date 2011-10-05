function videoLinkId(url){
	var id;
	id = url.replace(/^[^v]+v.(.{11}).*/,"$1");
	return id;
}

function setVideo(id, src){
	
		var url_id	= videoLinkId(src);
		var modal	= 'modal-video-'+id; 
	
		var str = '';
		str += '<div id="'+ modal +'" class="modal hide fade">';
//		str += '<div class="modal-header">';
//		str += '<a href="#" class="close">&times;</a>';
//		str += '<h3></h3>';
//		str += '</div>';
		str += '<div class="modal-body">';
		str += '<iframe width="420" height="315" src="http://www.youtube.com/embed/'+ url_id +'" frameborder="0" allowfullscreen></iframe>';
		str += '</div>';
		str += '<div class="modal-footer">';
		str += '<a href="#" class="close">&times;</a>';
		str += '</div>';
		str += '</div>';
		$('#main-content').append(str);
		
		renderModal(modal);
}

function renderModal(modal){
	$('#'+ modal).modal({
		show : true,
		backdrop : true,
		keyboard : true
	});
}

function getPagination(page){
	$.get('video/get-pagination/'+page, function(data){
		if(data){
			Common.clearDiv('#main-content');
			var id;
			var title;
			var src;
			var thumbnail;
			
			var str = '<ul class="media-grid">';
			for(var i = 0; i<data.length; i++){
				id = data[i].k0;
				title = data[i].k1;
				src = data[i].k2
				thumbnail = data[i].k3;
				
				str += '<li><img id="video-'+ id +'" src="'+ thumbnail +'" class="video-box" alt="" title="'+ title +'" onclick="setVideo(\''+ id +'\', \'' + src +'\')" /></li>';
			}
			
			str += '</ul>';
			$('#main-content').append(str);
		//setVideo(id, title, src);
			
		}
	});
	
}
function countPage(){
	$.get('video/count-page', function(data){
		if(data){
			paginate(data);
		}
	});
}

function paginate(count){
	$("#pagination").paginate({
		count 		: count,
		start 		: 1,
		//      display     : 3,
		border					: true,
		border_color			: '#fff',
		text_color  			: '#fff',
		background_color    	: 'black',
		border_hover_color		: '#ccc',
		text_hover_color  		: '#000',
		background_hover_color	: '#fff',
		images					: false,
		mouse					: 'press',
		onChange     			: function(page){
			getPagination(page);
		}
	});

}

$(function(){
	countPage();
	getPagination(1);
	
});//end document ready
