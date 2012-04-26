<div class="content">
	<div class="row">
		<div id="main-content" class="span11">
			<div id="video-frame"></div>
			<div class="clear"></div>
			<form id="manage-video-form" action="<?php echo $data['baseurl']; ?>video/save_video" method="post" class="form-stacked">
				<input type="hidden" id="video_id" name="video_id" />
				<input type="hidden" id="title" name="title" />
				<input type="hidden" id="thumbnail" name="thumbnail" />
				<div class="clearfix">
					<label for="videolink">Video Link</label>
					<div class="input">
						<input type="text" id="videolink" name="videolink" class="extend validate[required] span6" />
					</div>
				</div>
			</form>
		</div>

		<div id="side-content" class="span5">
			<!--			<div id="pagination">
			
						</div>
						<div id="search-container">
							<form id="search-form">
								<input type="text" id="search" name="search" placeholder="Search" onkeyup="Search.filter();" class="span5" />
								<button type="submit" id="search-button" name="search-button"></button>
							</form>
						</div>
						<div id="search-result"></div>
						<button class="btn info" onclick="clearForm()">New</button>-->
			<div class="pagination">

			</div>
			<div id="video-container">

			</div>
			<div id="search-container">
				<form id="search-form">
					<input type="text" id="search" name="search" placeholder="Search" onkeyup="Search.filter();" class="span5" />
					<button type="submit" id="search-button" name="search-button"></button>
				</form>
			</div>
			<div id="search-result"></div>
			<button class="btn info" onclick="clearForm()">New Form</button><br /><br />
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
		
		if(total > 1){
			str += '<li class="prev"><a data-name="prev-page">Prev</a></li>';
			str += '<span class="set-content">';
			var page = checkHashKey();
			
			if(page > 1){
				//var currentset = Math.floor(total / page);
				//var prevpage = (currentset - 1) * set;
				
				for(var i=1, len=set; i<=total && i>=1 && page>=1 && page<=total; i++, page++){
					str += '<li title="page'+page+'"><a href="#'+page+'">'+page+'</a></li>';
				}
			} else {
				for(var i=1; i<=total; i++){
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
			url: '<?php echo $data['baseurl']; ?>video/admin-set-pagination/'+ set,
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
				url: '<?php echo $data['baseurl']; ?>video/admin-get-pagination/'+page,
				dataType: 'json',
				success: function(data){
					if(data){
						$('#video-container').html('');
						for(var i=0, len=data.length; i<len; i++){
							str += '<div class="ar-block" data-id="'+ data[i].k0 +'">';
							str += '<div class="ar-content">';
							str += data[i].k1;
							str += '</div>';
							str += '</div>';
						}
					}
				},
				error: function(){
					window.location = '<?php echo $data['baseurl']; ?>error';
				},
				complete: function(){
					delete page;
					$(str).appendTo('#video-container').slideDown(800, function(){
						$(this).find('.ar-block').show();
					});
					
					$('.ar-block').bind('click', function(){
						id = $(this).data('id');
						
						fetchOneVideo(id);
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
		setPagination(10);
	});
</script>
<script>
	function videoLinkId(url){
		var id;
		id = url.replace(/^[^v]+v.(.{11}).*/,"$1");
		return id;
	}
	
	//inside fetchOneVideo as radio button
	function is_visible(data){
		var visible = '';
		if(data === "1"){
			visible  = '<input type="radio" name="visible" value="1" checked />&nbsp;Yes&nbsp;&nbsp;';
			visible += '<input type="radio" name="visible" value="0" /> No';
		}

		else{
			visible = '<input type="radio" name="visible" value="1" />&nbsp;Yes&nbsp;&nbsp;';
			visible += '<input type="radio" name="visible" value="0" checked /> No';
		}
		return visible;
	}
	
	function fetchOneVideo(id){
		Common.clearDiv('#video-frame');
		Common.clearDiv('#manage-video-form');
		Common.wait();
		$.get('<?php echo $data['baseurl']; ?>video/get_one_video/'+id, function(data){
			if(data){
				var id = videoLinkId(data.link);
				var iframe = '<iframe width="545" height="349" src="http://www.youtube.com/embed/'+id+'?wmode=transparent" frameborder="0" allowfullscreen></iframe>';
				
				var str = '<input type="hidden" id="video_id" name="video_id" value="'+data.video_id+'"/>';
				str += '<div class="clearfix">';
				str += '<label for="visible">Visible to public ?</label>';
				str +=  is_visible(data.visible);
				str += '</div>';
				str +='<div class="clearfix">';
				str += '<label for="title">Title</label>';
				str += data.title;
				str += '</div>';
				str += '<div class="actions">';
				str += '<button class="btn primary" type="submit" id="submit" name="submit">Update</button>&nbsp;';
				str += '<span id="deleteButton"><button type="button" class="btn danger" onclick="deleteVideo('+ data.video_id +');">Delete</button></span>';
				str += '</div>';
				$('#video-frame').append(iframe);
				$('#manage-video-form').append(str);
					
				Common.end();
			}

		});
	}
	
	function deleteVideo(id){
		$.delete_('<?php echo $data['baseurl']; ?>video/delete_video/'+id, function(data){
			if(data){
				clearForm();
				getPagination();
			}
			else {
				displayMessage('warning', 'Video could not be deleted');
			}
		});
	}
	
	function loadIframe(){

		var url = $('#videolink').val();

		var id = videoLinkId(url);
		Common.clearDiv('#video-frame');

		var str = '<iframe width="560" height="349" src="http://www.youtube.com/embed/'+id+'" frameborder="0" allowfullscreen></iframe>';
		$('#video-frame').append(str);

		$('iframe').load(function(){
			$.get('https://gdata.youtube.com/feeds/api/videos/'+id+'?v=2&alt=json', function(data){
				if(data){
					if($.browser.mozilla){
						data = JSON.parse(data);
					}
					var title = data.entry.title.$t;
					var thumbnail = data.entry.media$group.media$thumbnail[0].url;
					$('#title').val(title);
					$('#thumbnail').val(thumbnail);
				}
			});
			var str = '<input type="submit" id="submit" name="submit" value="Post" class="btn primary" />';
			$('#manage-video-form').append(str);
		});
	}
	
	$(function(){
		$('#videolink').bind('change', function(){
			loadIframe();
		});
		
		$('#manage-video-form').bind('submit', function(e){
			e.preventDefault();
			
			$.ajax({
				type : 'POST',
				url : '<?php echo $data['baseurl']; ?>video/save_video',
				data : $(this).serialize(),
				dataType : 'json',
				statusCode : {
					200: function(){
						displayMessage('info', 'Video updated');
					},
					201 : function(data){
						refreshForm(data);
						Search.onload('<?php echo $data['baseurl']; ?>video/admin-get-pagination/1');
					}
				}
			});
		});
	});
	
	function clearForm(){
		Common.clearDiv('#video-frame');
		Common.clearDiv('#manage-video-form');
		var str = '<input type="hidden" id="video_id" name="video_id" />';
		str += '<input type="hidden" id="title" name="title" />';
		str += '<input type="hidden" id="thumbnail" name="thumbnail" />';
		str += '<div class="clearfix">';
		str += '<label for="videolink">Video Link</label>';
		str += '<div class="input">';
		str += '<input type="text" id="videolink" name="videolink" class="extend validate[required] span6" onchange="loadIframe();" />'
		str += '</div>';
		str += '</div>';
		$('#manage-video-form').append(str);
	}
</script>