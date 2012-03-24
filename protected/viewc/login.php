<!DOCTYPE html>
<html>
	<head>
		<?php include "{$data['header']}.php"; ?>
	</head>
	<body>
		<?php include "{$data['nav']}.php"; ?>

		<div class="container-fluid">
			<div class="row">
				<div class="span6 offset4">
					<div class="alert-row">
						<div class="alert-block"></div>
					</div>
					<form id="login-form" class="form-horizontal well-white" method="post" action="<?php echo $data['baseurl']; ?>login/process-login">
						<div class="control-group">
							<label class="control-label" for="username">Username</label>
							<div class="controls">
								<input type="text" id="username" name="username" placeholder="Please enter username" />
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="password">Password</label>
							<div class="controls">
								<input type="password" id="password" name="password" placeholder="Please enter password" />
							</div>
						</div>

						<div class="control-group">
							<label class="control-label checkbox"></label>
							<div class="controls">
								<input type="checkbox" id="remember" name="remember" />
								Remember me
							</div>
						</div>
						<div class="form-actions">
							<button class="btn btn-primary" type="submit">Sign in</button>&nbsp;
							<button class="btn" type="reset">Reset</button>
						</div>
					</form>
				</div>
			</div>

			<?php include "{$data['footer']}.php"; ?>
		</div><!-- end container-fluid -->
		<!--Login-->
		<script>
			$('#login-form').bind('submit', function(e){
				e.preventDefault();
			
				var form = $(this);
				var username = $('#username').val();
				var password = $('#password').val();
				var control;
			
				$.ajax({
					type : 'POST',
					url : form.attr('action'),
					data : form.serialize(),
					dataType : 'json',
					beforeSend: function(){
						if(username === ''){
							control = $('.control-group:eq(0)');
							control.addClass('error');
							return false;
						}
						
						if(password === ''){
							control = $('.control-group:eq(1)');
							control.addClass('error');
							return false;
						}
					},
					success: function(data){
						window.location = '<?php echo $data['baseurl']; ?>'+ data;
					},
					error: function(){
						Alert.message('Invalid username/password', 'error');
					}
				});
			});
			
			$('#username').bind('keypress', function(){
				console.log($(this).parent().parent().removeClass('error'));
			});
			
			$('#password').bind('keypress', function(){
				console.log($(this).parent().parent().removeClass('error'));
			});
		</script>
	</body>
</html>
