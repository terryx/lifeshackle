<div class="content">
	<div class="row">
		<div id="main-content" class="span11">
			<form id="article-form" class="form-stacked">
				<fieldset>
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

		<div id="side-content" class="span5">
			<div id="pagination">

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
	//declare class to be appended
	var headerDiv = $('.header-message');
	var errorDiv = $('.error-message');
			
	//declare message variable
	var header = "";
	var message = "";

	function deleteArticle(id){
		$.delete_('<?php echo $data['baseurl']; ?>article/delete_article/'+id, function(data){
			
			if(data){
				clearForm();
				Search.onload('<?php echo $data['baseurl']; ?>article/admin-get-pagination/'+cachePage);

			}
			else {
				header = "Delete Error";
				message = "The page is not found.";
				headerDiv.html(header);
				errorDiv.html(message);
				Common.navModal();
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
				str += '<button class="btn danger" type="button" onclick="deleteArticle('+ data.article_id +')">Delete</button>';
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
	
	function navModal(){
		$('#nav-modal').modal({
			backdrop : true,
			keyboard : true,
			show 	 : true
		});
	}

	$(function(){
		countPage();
		
		$('#article-form').bind('submit', function(e){
			e.preventDefault();
			var loader = '<img src="<?php echo $data['baseurl']; ?>global/img/post-loader.gif" alt="" />';
			$.ajax({
				type : 'POST',
				url : '<?php echo $data['baseurl']; ?>article/save-article',
				data : $('#article-form').serialize(),
				dataType: 'json',
				beforeSend : function(){
					$('.actions').append(loader);
				},
				statusCode : {
					200 : function(data){
						if(data[0] === 'updated'){
							refreshForm(data[1]);
						} else {
							header = "Post Error";
							message = data[0];
							headerDiv.html(header);
							errorDiv.html(message);
							Common.navModal();
							$('.actions').children('img').remove();
						}
					},
					201 : function(data){
						refreshForm(data);
						cachePage = 1; //latest post is always at 1st
						Search.onload('<?php echo $data['baseurl']; ?>article/admin-get-pagination/'+cachePage);
					}
				}
			})
		});

	}); //end document ready
</script>