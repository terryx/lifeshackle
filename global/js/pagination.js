'use strict';

var Paginate = function paginate(options){
	defaults : {
		item_per_page: 10
	}
	
	start : {
		
	}
	
}
//var Pagination = function pagination(options){
//	
//	var defaults = {
//		set		: 10,
//		start	: null,
//		get		: null,
//		custom	: false
//	};
//	
//	//merge defaults object
//	var settings = $.extend({}, defaults, options);
//	
//	if(settings.start !== null){
//		setPagination(settings.start, settings.set);
//	}
//	
//	$(window).bind('hashchange', function(){
//		if(settings.custom !== false){
//			customGetPagination();
//		} else {
//			getPagination();
//		}
//	});
//	
//	function checkHashKey(){
//		var hash = window.location.hash,
//		hashstring = hash.replace('#', ''),
//		page;
//		
//		switch(hashstring){
//			case '':
//				page = 1;
//				break;
//			case 'next':
//				page = 'next';
//				break;
//			case 'prev':
//				page = 'prev';
//				break;
//			default:
//				page = parseInt(hashstring, 10);
//		}
//		return page;
//	}
//	
//	function setActivePage(page){
//		if($("li[class=active]")){
//			$("li[class=active]").removeClass('active');
//		}
//		$("li[title=page"+page+"]").addClass('active');
//	}
//	
//	function findPrevPage(set){
//		var setcontent = $('.set-content'); //div class called set-content
//		var str = '';
//		var i, len;
//		
//		//find last page from current set
//		var firstTitle = $("li[title^='page']:first").attr('title').replace('page', '');
//		var firstpage = parseInt(firstTitle, 10);
//		
//		//make next set of page
//		var prevpage = firstpage - 1;
//		var prevset = firstpage - set;
//		if(prevset < 0){
//			prevset = 1;
//		}
//		
//		//set minimum clickable page to 1
//		if(prevset === 0){
//			prevset = 1;
//		}
//		
//		//avoid negative page value
//		if(prevpage > 0){
//			setcontent.html('');
//	
//			for(i=prevset, len=prevpage; i<=len && i>0; i++){
//				str += '<li title="page'+i+'"><a href="#'+i+'">'+i+'</a></li>';
//			}
//			setcontent.append(str);
//			window.location.hash = '#'+prevpage;
//		}
//		
//	}
//	
//	function findNextPage(total, set){
//		var setcontent = $('.set-content'); //div class called set-content
//		var str = '';
//		var i, len;
//		
//		//find last page from current set
//		var lastTitle = $("li[title^='page']:last").attr('title').replace('page', '');
//		var lastpage = parseInt(lastTitle, 10);
//		
//		//make next set of page
//		var nextpage = lastpage + 1;
//		var nextset = nextpage + set;
//		
//		//avoid empty entire page content
//		if(nextpage <= total){
//			setcontent.html('');
//		
//			for(i=nextpage, len=nextset; i<len && i<=total; i++){
//				str += '<li title="page'+i+'"><a href="#'+i+'">'+i+'</a></li>';
//			}
//			setcontent.append(str);
//			
//			window.location.hash = '#'+nextpage;
//		}
//	}
//	
//	//calculate total page after divided by set per page
//	function setPagination(url, set){
//		$.ajax({
//			type: 'GET',
//			url: url + set,
//			dataType: 'json',
//			success: function(data){
//				makePagination(data, set);
//			},
//			complete: function(){
//				if(settings.custom !== false){
//					customGetPagination();
//				} else {
//					getPagination();
//				}
//			}
//		});
//	}
//	
//	function makePagination(total, set){
//		total = parseInt(total);
//		set = parseInt(set);
//		var str = '';
//		var i, page, len, done;
//		
//		str += '<ul>'; 
//		if(total > 1){
//			str += '<li class="prev"><a data-name="prev-page">Prev</a></li>';
//			str += '<span class="set-content">';
//			page = checkHashKey();
//			
//			if(page > 1){
//				//var currentset = Math.floor(total / page);
//				//var prevpage = (currentset - 1) * set;
//				
//				for(i=1, len=set; i<=len && i>=1 && page>=1 && page<=total; i++, page++){
//					str += '<li title="page'+page+'"><a href="#'+page+'">'+page+'</a></li>';
//				}
//			} else {
//				for(i=1, len=set; i<=len; i++){
//					str += '<li title="page'+i+'"><a href="#'+i+'">'+i+'</a></li>';
//				}
//			}
//			str += '</span>';
//			str += '<li class="next"><a data-name="next-page">Next</a></li>';
//		}
//		str += '</ul>';
//		
//		done = $('.pagination').append(str);
//		
//		if(done){
//			$('.prev').bind('click', function(){
//				findPrevPage(total, set);
//			});
//			
//			$('.next').bind('click', function(){
//				findNextPage(total, set);
//			});
//		}
//	}
//	
//	function getPagination(page){
//		page = (page === undefined) ? checkHashKey() : page;
//		
//		setActivePage(page);
//
//		var str = '';
//		var i, len;
//		
//		if(page >= 1){
//			$.ajax({
//				type: 'GET',
//				url: settings.get + page,
//				dataType: 'json',
//				success: function(data){
//					if(data){
//						$('#pagination-container').html('');
//						for(i=0, len=data.length; i<len; i++){
//							str += '<div class="st-block">';
//							str += '<div class="st-content">';
//							str += data[i].k1;
//							str += '</div>';
//							str += '<div class="st-time">'+ timeHistory(data[i].k2) +'</div>';
//							str += '</div>';
//						}
//					}
//				},
//				error: function(){
//					window.location = '{{baseurl}}error';
//				},
//				complete: function(){
//					$(str).appendTo('#pagination-container').slideDown(500, function(){
//						$(this).find('.st-block').show();
//					});
//				}
//			});
//		}
//	}
//	
//	function customGetPagination(page){
//		page = (page === undefined) ? checkHashKey() : page;
//		
//		setActivePage(page);
//
//		var str = '';
//		var id = 0;
//		
//		if(page >= 1){
//			$.ajax({
//				type: 'GET',
//				url: settings.get + page,
//				dataType: 'json',
//				success: function(data){
//					if(data){
//						$('#pagination-container').html('');
//						for(var i=0, len=data.length; i<len; i++){
//							str += '<div class="ar-block" data-id="'+ data[i].k0 +'">';
//							str += '<div class="ar-content">';
//							str += data[i].k1;
//							str += '<div class="ar-time">'+ timeHistory(data[i].k2) +'</div>';
//							str += '</div>';
//							str += '</div>';
//						}
//					}
//				},
//				error: function(){
//					window.location = '{{baseurl}}error';
//				},
//				complete: function(){
//					delete page;
//					$(str).appendTo('#pagination-container').slideDown(800, function(){
//						$(this).find('.ar-block').show();
//					});
//					
//					$('.ar-block').bind('click', function(){
//						id = $(this).data('id');
//						
//						fetchOneArticle(id);
//					});
//				}
//			});
//		}
//	}
//}
