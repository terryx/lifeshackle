<div class="page-header">
	<h3>Living under the shadow</h3>
</div>
<div id="main-content" class="span11 ">
	<form id="login-form" method="post" action="<?php echo $data['baseurl']; ?>login">
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
<div id="footer"></div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/twitter-bootstrap/bootstrap-all.js"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/min/common.js?<?php echo $data['version']; ?>"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/min/jquery.validationEngine.js?<?php echo $data['version']; ?>"></script>
<script type="text/javascript" src="<?php echo $data['customscript']; ?>"></script>