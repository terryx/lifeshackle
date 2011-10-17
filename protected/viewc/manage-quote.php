<div id="main-content" class="span11">
	<form id="manage-quote-form" class="form-stacked" action="<?php echo $data['baseurl']; ?>quote/save-quote" method="post">
		<fieldset>
			<legend>Manage quote</legend>
			<input type="hidden" id="quote_id" name="quote_id" />
			<div class="clearfix">
				<div class="input">
					<textarea id="txtcontent" name="txtcontent" class="xxlarge" rows="3" placeholder="Enter quote here.."></textarea>
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
	function deletequote(id){
		$.delete_('<?php echo $data['baseurl']; ?>quote/delete_quote/'+id, function(data){
			if(data){
				$('#newForm').click();
				Search.onload('<?php echo $data['baseurl']; ?>quote/get_quote_list', '#manage-quote-form');

			}
			else {
				ajaxFail('quote could not be deleted');
			}
		});
	}



	function ajaxCallback(status, form, json){

		$('#progress').hide();
		if(status === true){
			ajaxSuccess(json[0], json[1]);
		}
		else {ajaxFail('System database error. Please try again later', 'Error');
		}
		Search.onload('quote/get_quote_list', '#manage-quote-form');
	}

	function refreshForm(id){
		$('#progress').show();
		$.get('<?php echo $data['baseurl']; ?>quote/get_one_quote/'+id, function(data){
			if(data){
				$('#quote_id').val(data.quote_id);
				$('#title').val(data.title);
				$('#txtcontent').val(data.body);
				$('#tag').val(data.tag);

				var str = '<input class="glassbutton" type="button" onclick="deletequote('+ data.quote_id +');" value="Delete" />';
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

		//form validation
		$('#manage-quote-form').validationEngine({
			ajaxFormValidation: true,
			onAjaxFormComplete: ajaxCallback,
			onBeforeAjaxFormValidation: beforeCall
		});


		//Render search list at side content
		Search.onload('<?php echo $data['baseurl']; ?>quote/get_quote_list', '#manage-quote-form');

	}); //end document ready


</script>