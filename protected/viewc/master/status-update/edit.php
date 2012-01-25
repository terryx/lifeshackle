<div class="content">
	<div class="row">
		<div id="main-content" class="span11">
			<div id="status-update">
				<form id="status-update-form" class="form-stacked" method ="POST" action ="<?php echo $data['baseurl']; ?>status-update/save">
					<div class ="clearfix">
						<div class="input">
							<textarea id="status-update-text" name="status_update_text" cols="70" rows="3" class="span10" placeholder="What's in your mind ?"></textarea >
						</div>
					</div >
					<button type="submit" class ="btn primary d-hide">Post</button>
				</form>
				<div class="pagination">
				</div>
				<div id="status-update-container">

				</div>
			</div>
		</div>
	</div>
</div>

<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/footer.php"; ?>

<!-- Pagination -->
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
		var page = checkHashKey();
		
		if(total > 1){
			str += '<li class="prev"><a data-name="prev-page">Prev</a></li>';
			str += '<span class="set-content">';
	
			for(var i=page; (i<=total); i++){
				str += '<li title="page'+i+'"><a href="#'+i+'">'+i+'</a></li>';
				if(i === 5){
					break;
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
			url: '<?php echo $data['baseurl']; ?>status-update/set-pagination/'+set,
			dataType: 'json',
			success: function(data){
				if(data){
					makePagination(data, set);
				}
			},
			complete: function(){
				getPagination();
			}
		});
	}
	
	function getPagination(page){
		page = (page === undefined) ? checkHashKey() : page;
		
		setActivePage(page);

		var str = '';
		var id = 0;
		
		if(page >= 1){
			$.ajax({
				type: 'GET',
				url: '<?php echo $data['baseurl']; ?>status-update/get-pagination/'+page,
				dataType: 'json',
				success: function(data){
					if(data){
						$('#status-update-container').html('');
						for(var i=0, len=data.length; i<len; i++){
							str += '<div class="st-block" data-id="'+ data[i].k0 +'">';
							str += '<div class="st-content">';
							str += data[i].k1;
							str += '<div class="st-time">'+ timeHistory(data[i].k2) +'</div>';
							str += '</div>';
							str += '<div class="st-admin"><button class="btn delete-st" id="del'+ data[i].k0 +'">Delete</button></div>';
							str += '</div>';
						}
					}
				},
				error: function(){
					window.location = '<?php echo $data['baseurl']; ?>error';
				},
				complete: function(){
					$(str).appendTo('#status-update-container').slideDown(1300, function(){
						$(this).find('.st-block').show();
					});
				
					var st = $('.delete-st').bind('click', function(){
						var id = $(this).attr('id').replace('del', '');
						id = parseInt(id);
						$.ajax({
							type: 'GET',
							url: '<?php echo $data['baseurl']; ?>status-update/delete/'+ id,
							dataType: 'json',
							beforeSend: function(){
								if(id < 1 || id === undefined){
									return false;
								}
							},
							success: function(data){
								if(data[0] === 'deleted'){
									getPagination();
								}
							},
							complete: function(){
								$(st).unbind();
							}
						})
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
	
</script>

<!--Status Update-->
<script>
	$(function(){
		setPagination(5);
		
	});
</script>