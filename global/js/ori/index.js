function filterByArchive(date){
	$.get("article/filter-by-archive/"+date, function(data){
		if(data){
			var str = '';
			Common.removeDiv("#pagination");
			Common.clearDiv("#main-content");
			for(var i=0;i<data.length;i++){
				str += '<div class="content">';
				str += '<h1>'+data[i].k1+'</h1>';
				str += 'Published by '+data[i].k5 + ' on '+data[i].k2+'<hr />';
				str += data[i].k3
				str += '</div>';
			}
		}
		$(str).appendTo('#main-content');

	});
}
  
  function archive(){
	$.get("article/archive", function(data){
		if(data){
			var str = "<div class='content'>";
			str += "<h2>archive</h2>";
			str += "<ul>";
			for(var i=0;i<data.length;i++){
				str += "<li><div class='num' onclick='filterByArchive(\""+data[i].k1+"\")'>"+data[i].k0+"</div><div class='date' onclick='filterByArchive(\""+data[i].k1+"\")'>"+data[i].k1+"</div></li>";
			}
			str += "</ul>";
			str += "</div>";
			$("#archive").append(str);
		}
	});
}

function getPagination(page){
	$.get('article/get-pagination/'+page, function(data){
		if(data){
			Common.clearDiv('#main-content');
			var str = '';
			for(var i=0;i<data.length;i++){
				str += '<div class="content">';
				str += '<h1>'+data[i].k1+'</h1>';
				str += '<div class="i-publish">By <span class="i-bold">'+data[i].k5 + '</span> on '+data[i].k2+'</div>';
				str += data[i].k3
				str += '</div>';
			}
			$(str).appendTo('#main-content');

		}
		else {
			return false;
		}
	});
}
function countPage(){
	$.get('article/count-page', function(data){
		if(data){
			paginate(data);
		} else {
			return false;
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
	//set navigation indicator
	$('#nav a:eq(0)').addClass('active');
	countPage();
	getPagination(1);
	archive();

});
