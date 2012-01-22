<div class="content">
	<div class="row">
		<div id="main-content" class="span11">
			<div id="status-update">
				<div class="pagination">

				</div>
				<div id="status-update-container">

				</div>
			</div>
		</div>
		<div id="side-content" class="span5">
			<div style="float:right">
<!--				 Facebook Badge START <a href="https://www.facebook.com/terryxlife" target="_TOP" style="font-family: &quot;lucida grande&quot;,tahoma,verdana,arial,sans-serif; font-size: 11px; font-variant: normal; font-style: normal; font-weight: normal; color: #3B5998; text-decoration: none;" title="Terry Yuen">Terry Yuen</a><br/><a href="https://www.facebook.com/terryxlife" target="_TOP" title="Terry Yuen"><img src="https://badge.facebook.com/badge/620130201.5435.1987480309.png" style="border: 0px;" /></a> Facebook Badge END -->
			</div>
		</div>
	</div>
</div>

<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/footer.php"; ?>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/pagination.js"></script>
<!--Status Update & Pagination-->
<script>
	$(window).bind('hashchange', function(){
		getPagination();
	});
	
	
	
	
	function findPrevPage(total, set){
		var setcontent = $('.set-content'); //div class called set-content
		
		var str = '';
		
		//find last page from current set
		var firstTitle = $("li[title^='page']:first").attr('title').replace('page', '');
		var firstpage = parseInt(firstTitle, 10);
		
		//make next set of page
		var prevpage = firstpage - 1;
		var prevset = firstpage - set;
		
		//set minimum clickable page to 1
		if(prevset === 0){
			prevset = 1;
		}
		
		//avoid negative page value
		if(prevpage > 0){
			setcontent.html('');
	
			for(var i=prevset, len=prevpage; i<=len; i++){
				str += '<li title="page'+i+'"><a href="#'+i+'">'+i+'</a></li>';
				
			}
			setcontent.append(str);
			window.location.hash = '#'+prevpage;
		}
		
	}
	
	function findNextPage(total, set){
		var setcontent = $('.set-content'); //div class called set-content
		var str = '';
		
		//find last page from current set
		var lastTitle = $("li[title^='page']:last").attr('title').replace('page', '');
		var lastpage = parseInt(lastTitle, 10);
		
		//make next set of page
		var nextpage = lastpage + 1;
		var nextset = nextpage + set;
		
		//avoid empty entire page content
		if(nextpage <= total){
			setcontent.html('');
		
			for(var i=nextpage, len=nextset; i<len && i<=total; i++){
				str += '<li title="page'+i+'"><a href="#'+i+'">'+i+'</a></li>';
			}
			setcontent.append(str);
			
			window.location.hash = '#'+nextpage;
		}
	}
	
	function setActivePage(page){
		if($("li[class=active]")){
			$("li[class=active]").removeClass('active');
		}
		$("li[title=page"+page+"]").addClass('active');
	}

	function makePagination(total, set){
		total = parseInt(total);
		set = parseInt(set);
		var str = '<ul>';
		
		if(total > 1){
			str += '<li class="prev"><a data-name="prev-page">Prev</a></li>';
			str += '<span class="set-content">';
			var page = checkHashKey();
			
			if(page > 1){
				//var currentset = Math.floor(total / page);
				//var prevpage = (currentset - 1) * set;
				
				for(var i=1, len=set; i<=len && i>=1 && page>=1 && page<=total; i++, page++){
					str += '<li title="page'+page+'"><a href="#'+page+'">'+page+'</a></li>';
				}
			} else {
				for(var i=1, len=set; i<=len; i++){
					str += '<li title="page'+i+'"><a href="#'+i+'">'+i+'</a></li>';
				}
			}
			str += '</span>';
			str += '<li class="next"><a data-name="next-page">Next</a></li>';
		}
		str += '</ul>';
		
		var done = $('.pagination').append(str);
		if(done){
			$('.prev').bind('click', function(){
				findPrevPage(total, set);
			});
			
			$('.next').bind('click', function(){
				findNextPage(total, set);
			});
		}
	}
	
	function setPagination(set){
		$.ajax({
			type: 'GET',
			url: '<?php echo $data['baseurl']; ?>status-update/set-pagination/'+ set,
			dataType: 'json',
			success: function(data){
				makePagination(data, set);
			},
			complete: function(){
				//				window.location.hash = '#'+page;
				//				findCurrentPage();
				getPagination();
			}
		});
	}
	
	function getPagination(page){
		page = (page === undefined) ? checkHashKey() : page;
		
		setActivePage(page);

		var str = '';
		
		if(page >= 1){
			$.ajax({
				type: 'GET',
				url: '<?php echo $data['baseurl']; ?>status-update/get-pagination/'+page,
				dataType: 'json',
				success: function(data){
					if(data){
						$('#status-update-container').html('');
						for(var i=0, len=data.length; i<len; i++){
							str += '<div class="st-block">';
							str += '<div class="st-content">';
							str += data[i].k1;
							str += '</div>';
							str += '<div class="st-time">'+ timeHistory(data[i].k2) +'</div>';
							str += '</div>';
						}
					}
				},
				error: function(){
					window.location = '<?php echo $data['baseurl']; ?>error';
				},
				complete: function(){
					delete page;
					$(str).appendTo('#status-update-container').slideDown(800, function(){
						$(this).find('.st-block').show();
					});
				}
			});
		}
	}
	
	function checkHashKey(){
		var hash = window.location.hash,
		hashstring = hash.replace('#', ''),
		page;
		
		switch(hashstring){
			case '':
				page = 1;
				break;
			case 'next':
				page = 'next';
				break;
			case 'prev':
				page = 'prev';
				break;
			default:
				page = parseInt(hashstring, 10);
		}
		return page;
	}
	

	
	$(function(){
		setPagination(5);
	});

</script>
<!-- Mini profile -->