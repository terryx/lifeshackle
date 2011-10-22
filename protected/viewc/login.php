<section id="navigation">
	<div class="topbar" >
		<div class="topbar-inner">
			<div class="container">
				<a class="brand" href="<?php echo $data['baseurl']; ?>home">Life's Shackle</a>
				<ul class="nav">
					<li><a href="<?php echo $data['baseurl']; ?>video">Video</a></li>
					<li><a href="<?php echo $data['baseurl']; ?>profile">Profile</a></li>
				</ul>
				<ul class="secondary-nav">
					<li><a href="<?php echo $data['baseurl']; ?>sign-in">Sign in</a></li>
				</ul>
			</div>
		</div>
    </div>
</section>
<section id="main-container" class="row">
	<div class="page-header">
		<h3>Living under the shadow</h3>
	</div>
	<div id="main-content" class="span11 ">
		<form id="login-form" method="get" action="<?php echo $data['baseurl']; ?>login">
			<div class="clearfix">
				<label for="username">Username</label>
				<div class="input">
					<input type="text" id="username" name="username" class="validate[required] span3" />
				</div>
			</div>
			<div class="clearfix">
				<label for="password">Password</label>
				<div class="input">
					<input type="password" id="password" name="password" class="validate[required] span3" />
				</div>
			</div>
			<div class="clearfix">
				<div class="input">
					<input type="checkbox" name="remember">
					<span>Remember me</span>
				</div>
			</div>
			<div class="actions">
				<button id="submit" type="submit" class="btn primary">Login</button>&nbsp;<button type="reset" class="btn">Cancel</button>
			</div>
		</form>
	</div>
	<div class="span5">
		<p>This is my personal space where the shackles bind my life</p>
	</div>
</section>
<div id="footer"></div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/twitter-bootstrap/bootstrap-all.js"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/min/common.js?<?php echo $data['version']; ?>"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/min/jquery.validationEngine.js?<?php echo $data['version']; ?>"></script>
<script type="text/javascript">

	function ajaxCallback(status, form, data){
		$('body').css('cursor', 'default');
		
		if(status === true ) {
			if(data[0] === true){
				window.location = data[1];
			} else {
				if ($('.alert-message').length === 0) {
					var str = '<div class="alert-message error" data-alert>'+
						'<a class="close" href="#">x</a>'+
						'<p>'+data+'</p>'+
						'</div>';
					$('#main-content').prepend(str);
				}
			}// failed to authenticate
		}
	}
	
	$(function(){
		jQuery("#login-form").validationEngine({
			ajaxFormValidation: true,
			onBeforeAjaxFormValidation: beforeCall,
			onAjaxFormComplete: ajaxCallback
		});

	});

</script>