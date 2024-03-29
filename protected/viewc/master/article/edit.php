<div class="content">
	<div class="row">
		<div id="main-content" class="span11">
			<form id="article-form" class="form-stacked" method="post" action="<?php echo $data['baseurl']; ?>article/save-article">
				<fieldset>
					<input type="hidden" id="article_id" name="article_id" value="" />
					<div class="clearfix">
						<label for="title">Title</label>
						<div class="input">
							<input type="text" id="title" name="title" class="span8 validate[required]" />
						</div>
					</div>
					<div class="clearfix">
						<div class="input">
							<textarea id="txtcontent" name="txtcontent" cols="60" rows="10"></textarea>
						</div>
					</div>
					<div class="clearfix">
						<label for="tag">Tag</label>
						<div class="input">
							<input type="text" id="tag" name="tag" class="span8"/>
						</div>
					</div>
					<div class="actions">
						<button type="submit" class="btn primary">Save</button>
						<button class="btn" type="reset">Cancel</button>
						<span></span>
					</div>
				</fieldset>
			</form>
		</div>

		<div id="side-content" class="span5">
			<div class="pagination">

			</div>
			<div id="pagination-container">

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
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/plugin/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/pagination.js"></script>

<script type="text/javascript">
	$('#txtcontent').tinymce({
		script_url : '<?php echo $data['baseurl']; ?>global/plugin/tiny_mce/tiny_mce_gzip.php',

		theme : "advanced",
		plugins : "advimage,advlink,emotions,inlinepopups,preview,media,print,contextmenu,paste,fullscreen,noneditable,nonbreaking",
		dialog_type : "modal",
		content_css : "<?php echo $data['baseurl']; ?>global/css/editor.css",
		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "image,media,emotions,|,bullist,numlist,|,blockquote,|,undo,redo,|,anchor,cleanup,code,|,forecolor,backcolor,|,hr,removeformat,|,charmap,|,print,|,fullscreen,|,preview",
		theme_advanced_buttons3 : '',
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true
	});
</script>
<!-- Pagination -->
<!--<script>
	
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
		url: '<?php echo $data['baseurl']; ?>article/admin-set-pagination/'+ set,
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
			url: '<?php echo $data['baseurl']; ?>article/admin-get-pagination/'+page,
			dataType: 'json',
			success: function(data){
				if(data){
					$('#article-container').html('');
					for(var i=0, len=data.length; i<len; i++){
						str += '<div class="ar-block" data-id="'+ data[i].k0 +'">';
						str += '<div class="ar-content">';
						str += data[i].k1;
						str += '<div class="ar-time">'+ timeHistory(data[i].k2) +'</div>';
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
				$(str).appendTo('#article-container').slideDown(800, function(){
					$(this).find('.ar-block').show();
				});
					
				$('.ar-block').bind('click', function(){
					id = $(this).data('id');
						
					fetchOneArticle(id);
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
</script>-->
<script>
function clearForm(){
	$('#article_id').val('');
	$('#article-form')[0].reset();
}					
					
function fetchOneArticle(id){
	$.ajax({
		type: 'GET',
		url: '<?php echo $data['baseurl']; ?>article/fetch-one-article/'+id,
		dataType: 'json',
		beforeSend: function(){
			$('#txtcontent').html('Content is loading..');
		},
		success: function(data){
			if(data){
				$('#article_id').val(data.k0);
					
				$('#title').val(data.k1);
					
				$('#txtcontent')
				.html('')
				.append(data.k6);
					
				$('#tag').val(data.k4);
				
				//delete button
				$('.actions')
				.children('span')
				.html('')
				.append('<button class="btn danger" type="button">Delete</button>');
				
				//check alert message
				$('.alert-message').length >= 0 ? $('.alert-message').remove() : false;
			}
		},
		complete: function(){
			$('.danger').bind('click', function(){
				deleteOneArticle($('#article_id').val());
			});
		}
	});
}
	
function deleteOneArticle(id){
	$.ajax({
		type: 'GET',
		url: '<?php echo $data['baseurl']; ?>article/delete-one-article/'+id,
		success: function(data){
			if(data){
				if(data[0] === 'deleted'){
					displayMessage('info', data[1] + ' is deleted', '.actions');
				}
				
				clearForm();
			}
		},
		complete: function(){
			customGetPagination();
		}
	})
}
	
$(function(){
//	setPagination(10);
	
	Pagination({
			set		: 5, 
			start	: '<?php echo $data['baseurl']; ?>article/admin-set-pagination/',
			get		: '<?php echo $data['baseurl']; ?>article/admin-get-pagination/',
			custom	: true
		});
		
	$('#article-form').bind('submit', function(e){
		e.preventDefault();
		var $this = $(this);
			
		$.ajax({
			type: 'POST',
			url: $this.attr('action'),
			data: $this.serialize(),
			dataType: 'json',
			success: function(data){
				if(data){
					switch(data[0]){
						case 'created':
							displayMessage('success', data[2] + ' has been created', '.actions');
							$('#article_id').val(data[1]);
							break;
						case 'updated':
							displayMessage('info', data[2] + ' is updated', '.actions');
							$('#article_id').val(data[1]);
							break;
						default:
							displayMessage('error', data[1], '.actions');
					}
				}
			},
			complete: function(){
				customGetPagination();
			}
		});
	});
});
</script>

