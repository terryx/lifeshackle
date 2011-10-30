<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/master-nav.php"; ?>
<section id="main-container" class="row">
	<div class="form-div">
		<form id="status-update-form-0" class ="form-stacked" method ="POST" action ="<?php echo $data['baseurl']; ?>status-update/save">
			<div class ="clearfix">
				<label for="status-update"> Update status </label>
				<div class="input">
					<textarea id="status-update" name="status_update" cols="70" rows="3" class="span10" placeholder="What's in your mind ?"></textarea >
				</div>
			</div >
			<button type="submit" class ="btn primary d-hide">Post</button>
		</form >
	</div>
	<div id="main-content" class="span11">
	</div >
</section>
<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/footer.php"; ?>
<script type="text/javascript">
	function fetchStatusUpdate(data){
		var str = '';
		var id = 0;
		var msg = '';
		for(var i = 0; i < data.length; i++){
			id = data[i].status_update_id;
			msg = data[i].message;
			str += ' <div class = "row"onclick = "showStatusForm(\''+ id +'\')" > ';
			str += ' <div id = "status-block-'+ id +'" class = "span11 status-block d-show" > ';
			str += msg;
			str += ' </div>';
			str += '<form id="status-update-form-'+ id  +'" class="form-stacked d-hide" method="POST" action="<?php echo $data['baseurl']; ?>status-update/save ">';
			str += '<div class="clearfix ">';
			str += '<div class="input ">';
			str += '<textarea id="status - update - '+ id +'" name="status_update " cols="70 " rows="3 " class="span10 hide ">'+ msg +'</textarea>';
			str += '</div>';
			str += '</div>';
			str += '<button onclick="submitStatusUpdate(\'' + id + '\'); return false" class="btn primary">Post</button>';
			str += '</form>';
			str += '</div>';
		}
		$('#main-content').prepend(str);
	}

	function submitStatusUpdate(id) {
		var form = $('#status-update-form-' + id),
		term = form.serialize(),
		url = form.attr('action');
		$.ajax({
			type: 'POST',
			url: url,
			data: term,
			dataType: 'json',
			statusCode: {
				200: function(data) {
					console.log(data.user_id);
				},
				201: function(data) {

                },
				400: function(data) {
					console.log(data);
				},
				404: function(data) {
					//console.log('ok');
                }
			}
		});
 }
	function showStatusForm(id) {
		var block = $('#status-block-' + id);
		var form = $('#status-update-form-' + id);
		$(block).removeClass('d-show').addClass('d-hide');
		$(form).removeClass('d-hide').addClass('d-show');
	}

	$(function() {
		$('#status-update-form-0').click(function() {
			var div = $(this).children('.d-hide');
			$(div).removeClass('d-hide').addClass('d-show');
		});

		//fetch status update
		$.ajax({
			type: 'GET',
			url: '<?php echo $data['baseurl']; ?>status-update/get-all',
			statusCode: {
				200: function(data) {
					fetchStatusUpdate(data);
				},
				404: function() {
					displayMessage('error', 'Document not found');
				}
			}

		});
	});
</script>