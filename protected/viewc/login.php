<div class="content">
	<div class="row">
		<div id="main-content" class="span16">
			<div class="page-header">
				<h6>Sign In</h6>
			</div>
			<form id="login-form" method="post" action="<?php echo $data['baseurl']; ?>login/process-login">
				<div class="custom-login-form">
					<div class="error-message"></div>
					<div class="clearfix" style="padding-top: 20px">
						<label for="username">Username</label>
						<div class="input">
							<input type="text" id="username" name="username" />
						</div>
					</div>
					<div class="clearfix">
						<label for="password">Password</label>
						<div class="input">
							<input type="text" id="password" name="password" />
						</div>
					</div>
					<div class="input">
						Remember me <input type="checkbox" id="remember" name="remember" />
					</div>
					<div class="actions">
						<button class="btn primary" type="submit">Sign in</button>&nbsp;
						<button class="btn" type="reset">Reset</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/footer.php"; ?>

<!--Login-->
<script>
	$('#login-form').bind('submit', function(e){
		e.preventDefault();
			
		var form = $(this);
		var username = $('#username').val();
		var password = $('#password').val();
			
		$.ajax({
			type : 'POST',
			url : form.attr('action'),
			data : form.serialize(),
			dataType : 'json',
			beforeSend: function(){
				if(username === '' || password === ''){
					displayMessage('error', 'Please fill in username/password', '.error-message');
					return false;
				}
			},
			success: function(data){
				window.location = '<?php echo $data['baseurl']; ?>'+ data;
			},
			error: function(){
				displayMessage('error', 'Invalid username/password', '.error-message');
			},
			complete: function(){
				
			}
		});
	});
</script>
