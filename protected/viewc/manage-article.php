<div id="main-content" class="span11">
	<form id="manage-article-form" class="form-stacked" action="<?php echo $data['baseurl']; ?>article/save-article" method="post">
		<fieldset>
			<legend>Manage Article</legend>
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
					<textarea id="txtcontent" name="txtcontent" cols="75" rows="10" class="span10"></textarea>
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
				<span id="deleteButton"></span>
			</div>
		</fieldset>
	</form>
</div>

<div class="span5">
	<div id="search-container">
		<form id="search-form">
			<input type="text" id="search" name="search" placeholder="Search" onkeyup="Search.filter();" class="span5" />
			<button type="submit" id="search-button" name="search-button"></button>
		</form>
    </div>
    <div id="search-result"></div>
</div>

<div id="footer"></div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/twitter-bootstrap/bootstrap-all.js"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/common.js?<?php echo $data['version']; ?>"></script>
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
	function deleteArticle(id){
		$.delete_('<?php echo $data['baseurl']; ?>article/delete_article/'+id, function(data){
			if(data){
				$('#newForm').click();
				Search.onload('<?php echo $data['baseurl']; ?>article/get_article_list', '#manage-article-form');

			}
			else {
				ajaxFail('Article could not be deleted');
			}
		});
	}

	function beforeCall(){
		Common.wait();
		Common.bindLoading('#submit');
		return true;
	}

	function ajaxFail(msg){
		Common.removeDiv('#dialog-confirm');
		$('body').append('<div id="dialog-confirm">'+$.parseJSON(msg)+'</div>');
		$('#dialog-confirm').dialog({
			width: 350,
			height: 160,
			title: 'Oops..Something has go wrong',
			modal: true,
			buttons: {
				"Ok": function() {
					$(this).dialog('close');
					$(this).remove();
				}
			}
		});
		Common.unbindLoading("#submit", "Post");
	}

	function ajaxSuccess(success, text){
		Common.removeDiv('#dialog-confirm');
		$('<div id="dialog-confirm">'+text+'</div>').appendTo('body');
		$('#dialog-confirm').dialog({
			width: 350,
			height: 160,
			title: success,
			modal: true,
			buttons: {
				"Ok": function() {
					$(this).dialog('close');
					$(this).remove();
				}
			}
		});
		Common.unbindLoading("#submit", "Post");
	}

	function ajaxValidationCallback(status, form, json){

		$('#progress').hide();
		if(status === true){
			ajaxSuccess(json[0], json[1]);
		}
		else {ajaxFail('System database error. Please try again later', 'Error');
		}
		Search.onload('article/get_article_list', '#manage-article-form');
	}

	function refreshForm(id){
		$('#progress').show();
		$.get('<?php echo $data['baseurl']; ?>article/get_one_article/'+id, function(data){
			if(data){
				$('#article_id').val(data.article_id);
				$('#title').val(data.title);
				$('#txtcontent').val(data.body);
				$('#tag').val(data.tag);

				var str = '<input class="glassbutton" type="button" onclick="deleteArticle('+ data.article_id +');" value="Delete" />';
				Common.clearDiv('#deleteButton');
				$('#deleteButton').append(str);
			} else {
				ajaxFail('An error occured. Please contact administrator');
				window.location.reload();
			}
			$('#progress').hide();
		});
	}

	$(function(){

		//create a new button for form reset
		MenuSetting.resetButton({
			form         : '#manage-article-form',
			iframe       : '.cleditorMain >iframe',
			hiddenId     : '#article_id'
		});

		//form validation
		$('#manage-article-form').validationEngine({
			ajaxFormValidation: true,
			onAjaxFormComplete: ajaxValidationCallback,
			onBeforeAjaxFormValidation: beforeCall
		});


		//Render search list at side content
		Search.onload('<?php echo $data['baseurl']; ?>article/get_article_list', '#manage-article-form');

	}); //end document ready


</script>