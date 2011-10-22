function filterByArchive(date){
	$.get("article/filter-by-archive/"+date, function(data){
		if(data){
			var str = '';
			//			Common.removeDiv("#pagination");
			Common.clearDiv("#main-content");
			for(var i=0;i<data.length;i++){
				str += '<div class="span11">';
				str += '<h1>'+data[i].k1+'</h1>';
				str += 'By '+data[i].k5 + ' on '+data[i].k2+'<hr />';
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
			var str = "<h3>Archive</h3>";
			str += "<ul class='span4'>";
			for(var i=0;i<data.length;i++){
				str += "<li><div class='num' onclick='filterByArchive(\""+data[i].k1+"\")'>"+data[i].k0+"</div><div class='date' onclick='filterByArchive(\""+data[i].k1+"\")'>"+data[i].k1+"</div></li>";
			}
			str += "</ul>";
			$("#archive").append(str);
		}
	});
}


//<li class="dropdown">
//              <a href="#" class="dropdown-toggle">Dropdown</a>
//              <ul class="dropdown-menu">
//
//                <li><a href="#">Secondary link</a></li>
//                <li><a href="#">Something else here</a></li>
//                <li class="divider"></li>
//                <li><a href="#">Another link</a></li>
//              </ul>
//            </li>
			
function getPagination(page){
	$.get('article/get-pagination/'+page, function(data){
		if(data){
			Common.clearDiv('#main-content');
			var str = '';
			for(var i=0;i<data.length;i++){
				str += '<div class="row" onmouseover="editContent(\''+ data[i].k0 +'\')" onmouseout="hideControl(\''+ data[i].k0 +'\')">';
				str += '<h2>'+data[i].k1+'</h2>';
				str += '<div class="i-publish">By <span class="i-bold">'+data[i].k5 + '</span> on '+data[i].k2+'</div>';
				str += '<div class="i-control" id="control-panel-'+ data[i].k0 +'"><button class="btn">Edit</button>&nbsp;<button class="btn">Delete</button></div>';
				str += '<div class="i-content" id="content-panel-'+ data[i].k0 +'">';
				str += data[i].k3;
				str += '</div>';
				str += '</div>';
			}
			$(str).appendTo('#main-content');

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

function editContent(id){
$('#control-panel-'+ id).show();
$('#content-panel-'+ id).show();
	
} 
function hideControl(id){
$('#control-panel-'+ id).hide();
}

$(function(){
	countPage();
	getPagination(1);
	archive();

});


