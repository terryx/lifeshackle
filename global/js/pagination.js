//(function($) {
//  $.fn.pagination = function(count) {
//	 
//	console.log($(this).attr('class'));
////	  var str = '<div class="'++'"'
//	  
//	  
//	  
//	  
//  }
//  })(jQuery);


//    <div class="pagination">
//    <ul>
//    <li class="prev disabled"><a href="#">&larr; Previous</a></li>
//    <li class="active"><a href="#">1</a></li>
//    <li><a href="#">2</a></li>
//    <li><a href="#">3</a></li>
//    <li><a href="#">4</a></li>
//    <li><a href="#">5</a></li>
//    <li class="next"><a href="#">Next &rarr;</a></li>
//    </ul>
//    </div>

var Pagination = {
	
	init : function(count){
		
		var str = '<div class="pagination">';
			str += '<ul>';
			str += '<li class="prev disabled"><a href="#">&larr; Previous</a></li>';
			str += ' <li class="active"><a href="#">1</a></li>';
			str += '<li><a href="#">2</a></li>';
			str += '<li class="next"><a href="#">Next &rarr;</a></li>';
			str += '</ul>';
			str += '</div>';
			
		$('.pagination').append(str);	
	}
}