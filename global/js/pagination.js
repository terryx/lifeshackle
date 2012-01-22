
var Pagination = function pagination(options){
	
	var defaults = {
		set				: 10,
		findTotalPage	: {}	
	};
	var settings = $.extend({}, defaults, options);
	return settings;
}
