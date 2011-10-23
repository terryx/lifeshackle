<section id="navigation">
	<div class="topbar" data-dropdown="dropdown">
		<div class="topbar-inner">
			<div class="container">
				<a class="brand" href="<?php echo $data['baseurl']; ?><?php echo $data['role']; ?>">Life's Shackle</a>
				<ul class="nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle">Article</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $data['baseurl']; ?>article/view">View</a></li>
							<li class="divider"></li>
							<li><a href="#" onclick="clearForm()">New</a></li>
						</ul>
					</li>
					<li><a href="<?php echo $data['baseurl']; ?><?php echo $data['role']; ?>/profile">Profile</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle">Video</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $data['baseurl']; ?>video/view">View</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo $data['baseurl']; ?>video/edit">Edit</a></li>
						</ul>
					</li>
				</ul>
				<ul class="secondary-nav">
					<li><a href="<?php echo $data['baseurl']; ?>logout">Sign out</a></li>
				</ul>
			</div>
		</div>
    </div>
</section>
<section id="main-container" class="row">
	<div id="main-content" class="span11">
		<form id="article-form" class="form-stacked" action="<?php echo $data['baseurl']; ?>article/save-article" method="post">
			<fieldset>
				<legend>Article Form</legend>
				<input type="hidden" id="article_id" name="article_id" />
				<div class="clearfix">
					<label for="title">Title</label>
					<div class="input">
						<input type="text" id="title" name="title" class="span8 validate[required]" />
					</div>
				</div>
				<div class="clearfix">
					<label for="txtcontent">Content</label>
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
					<button type="submit" class="btn primary">Post</button>
					<button class="btn" type="reset">Cancel</button>
				</div>
			</fieldset>
		</form>
	</div>

	<div class="span5">
		<div id="pagination">

		</div>
		<div id="search-container">
			<form id="search-form">
				<input type="text" id="search" name="search" placeholder="Search" onkeyup="Search.filter();" class="span5" />
				<button type="submit" id="search-button" name="search-button"></button>
			</form>
		</div>
		<div id="search-result"></div>
	</div>
</section>
<div id="footer"></div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/twitter-bootstrap/bootstrap-all.js"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/common.js?<?php echo $data['version']; ?>"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/min/jquery.paginate.js?<?php echo $data['version']; ?>"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/min/jquery.validationEngine.js?<?php echo $data['version']; ?>"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/plugin/tiny_mce/jquery.tinymce.js"></script>
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

<script type="text/javascript">
	var cachePage = 1;
	function ajaxCallback(status, form, json){
		$('body').css('cursor', 'default');
		
		if(status === true) {
			switch(json[0]){
				case 'updated':
					displayMessage('info', json[1] + ' has been updated');
					break;
				case 'created':
					displayMessage('success', json[2] + ' has been created');
					refreshForm(json[1]);
					break;
				default:
					displayMessage('error', json[1]);
			}
			Search.onload('<?php echo $data['baseurl']; ?>article/admin-get-pagination/'+cachePage, '#article-form');
		}
	}
	
	function deleteArticle(id){
		$.delete_('<?php echo $data['baseurl']; ?>article/delete_article/'+id, function(data){
			if(data){
				$('#newForm').click();
				Search.onload('<?php echo $data['baseurl']; ?>article/get_article_list', '#article-form');

			}
			else {
				ajaxFail('Article could not be deleted');
			}
		});
	}
	
	function clearForm(){
		$('#article-form')[0].reset();
		$('#article_id').val('');
		var str = '<button type="submit" class="btn primary">Post</button>&nbsp;';
		str += '<button type="reset" class="btn">Cancel</button>';
		Common.clearDiv('.actions');
		$('.actions').append(str);
		
	}
	
	function refreshForm(id){
		$.get('<?php echo $data['baseurl']; ?>article/get_one_article/'+id, function(data){
			if(data){
				$('#article_id').val(data.article_id);
				$('#title').val(data.title);
				$('#txtcontent').val(data.body);
				$('#tag').val(data.tag);

				var str = '<button type="submit" class="btn primary">Post</button>&nbsp;';
				str += '<button class="btn" type="reset">Cancel</button>&nbsp;';
				str += '<button class="btn danger" onclick="onclick="deleteArticle('+ data.article_id +')">Delete</button>';
				Common.clearDiv('.actions');
				$('.actions').append(str);
				
			}
		});
	}
	
	function countPage(){
		$.get('<?php echo $data['baseurl']; ?>article/admin-count-page', function(data){
			if(data){
				paginate(data);
				Search.onload('<?php echo $data['baseurl']; ?>article/admin-get-pagination/1', '#article-form');
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
				cachePage = page;
				Search.onload('<?php echo $data['baseurl']; ?>article/admin-get-pagination/'+page);
			}
		});
	}

	$(function(){

		countPage();

		//form validation
		$('#article-form').validationEngine({
			ajaxFormValidation: true,
			onAjaxFormComplete: ajaxCallback
		});

	}); //end document ready


</script>