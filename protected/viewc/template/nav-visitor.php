<div class="topbar">
	<div class="fill">
        <div class="container">
			<a class="brand" href="<?php echo $data['baseurl']; ?>">Life's Shackle</a>
			<ul class="nav">
				<li><a href="<?php echo $data['baseurl']; ?>article">Article</a></li>
				<li><a href="<?php echo $data['baseurl']; ?>video">Video</a></li>
				<li><a href="<?php echo $data['baseurl']; ?>profile">Profile</a></li>
			</ul>
			<form id="login-form" class="pull-right">
				<input id="username" class="input-small" type="text" placeholder="Username">
				<input id="password" class="input-small" type="password" placeholder="Password">
				<button class="btn" type="submit">Sign in</button>
			</form>
        </div>
	</div>
</div>
<div id="nav-modal" class="modal hide fade">
	<div class="modal-header">
		<a href="#" class="close">&times;</a>
		<h4 class="header-message"></h4>
	</div>
	<div class="modal-body">
		<div class="error-message"></div>
	</div>
	<div class="modal-footer"></div>
</div>