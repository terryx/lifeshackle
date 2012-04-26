<div class="content">
	<div class="page-header">
		<ul class="breadcrumb">
			<li>My Profile
				<span class="divider">/</span>
			</li>
			<li>
				<a href="#" data-controls-modal="edit-profile-modal" data-backdrop="true" data-keyboard="true">Edit</a>
				<span class="divider">/</span>
			</li>
			<li>
				<a href="#" data-controls-modal="edit-picture-modal" data-backdrop="true" data-keyboard="true">Change pic</a>
			</li>
		</ul>
	</div>
	<div class="row">
		<div id="main-content" class="span11">
			<div id="personal">
				<h5>Personal Info</h5>
				<div id="personal-info">

				</div>
			</div>

			<div id="technical">
				<h5>Technical Skills</h5>
				<div id="technical-info">

				</div>
			</div>

			<div id="quote">
				<h5>Favorite Quotes</h5>
				<div id="quote-info">

				</div>
			</div>
		</div>
		<div id="side-content" class="span5">
			<img src="<?php echo $data['baseurl']; ?>global/img/terry.jpg" alt="terry" /> 
		</div>
	</div>
	<!-- personal info modal -->
	<div id="edit-profile-modal" class="modal hide fade" style="width: 820px;left:35%">
		<form id="edit-profile-form" method="post" action="<?php echo $data['baseurl']; ?>profile/save">
			<div class="modal-header">
				<a href="#" class="close">&times;</a>
				<h3>Edit Profile</h3>
			</div>
			<div class="modal-body">
				<input type="hidden" id="profile_id" name="profile_id" value="" />
				<div class="clearfix">
					<label for="personal-content">Personal Info</label>
					<div class="input">
						<textarea id="personal-content" name="personal-content" class="span9" rows="5" cols="70" wrap="hard" placeholder="Enter personal detail here.."></textarea>
					</div>
				</div>

				<div class="clearfix">
					<label for="technical-content">Technical Skills</label>
					<div class="input">
						<textarea id="technical-content" name="technical-content" class="span9" rows="5" cols="70" wrap="hard" placeholder="Enter technical detail here.."></textarea>
					</div>
				</div>

				<div class="clearfix">
					<label for="technical-content">Favorite Quotes</label>
					<div class="input">
						<textarea id="quote-content" name="quote-content" class="span9" rows="5" cols="70" wrap="hard" placeholder="Enter quote here.."></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn danger" onclick="$('#edit-profile-modal').modal('hide')">Cancel</a>
				<button type="submit" class="btn primary">Confirm</button>
			</div>
		</form>
	</div>

	<div id="edit-picture-modal" class="modal hide fade">
		<div class="modal-header">
			<a href="#" class="close">&times;</a>
			<h3>Change Picture</h3>
		</div>
		<div class="modal-body">
			<div class="clearfix">
				<iframe src="<?php echo $data['baseurl']; ?>template/picture-form" style="width:500px;border:none">
				</iframe>
			</div>
		</div>
	</div>
</div>
<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/footer.php"; ?>
<script type="text/javascript">
	$(function(){
	
		$('#edit-picture-modal').show();
		//render all info here
		getProfile();

		var $form = $('#edit-profile-form');
		$form.submit(function(e){
			e.preventDefault();
			
			$.ajax({
				type: 'POST',
				url: $form.attr('action'),
				data: $form.serialize(),
				dataType: 'json',
				success: function(data){
					if(data){
						$('#edit-profile-modal').modal('hide');
						if(data !== 'failed'){
							getProfile();
						} else {
							displayMessage('error', 'Page not found', '.modal-body', false);
						}
					}
				}
			});
		});
		
	});
	
	function getProfile(){
		$.get('<?php echo $data['baseurl']; ?>profile/get', function(data){
			if(data){
				//insert data to personal div
				Common.clearDiv('#personal-info');
				Common.clearDiv('#personal-content');
				var str0 = '<div class="span10 bottom-padding">';
				str0 += data.personal;
				str0 += '</div>';
				$('#personal-info').append(str0);
				$('#personal-content').append(data.personal);
					
				//insert data to technical div
				Common.clearDiv('#technical-info');
				Common.clearDiv('#technical-content');
				var str1 = '<div class="span10 bottom-padding">';
				str1 += data.technical;
				str1 += '</div>';
				$('#technical-info').append(str1);
				$('#technical-content').append(data.technical);
			
				//insert data to quote div
				Common.clearDiv('#quote-info');
				Common.clearDiv('#quote-content');
				var str2 = '<div class="span10">';
				str2 += data.quote;
				str2 += '</div>';
				$('#quote-info').append(str2);
				$('#quote-content').append(data.quote);
				
				$('#profile_id').val(data.profile_id);
			}
		});
	}
	
</script>
