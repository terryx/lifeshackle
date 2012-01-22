<div class="topbar" data-dropdown="dropdown">
	<div class="topbar-inner">
		<div class="container">
			<a class="brand" href="<?php echo $data['baseurl']; ?>">Life's Shackle</a>
			<ul class="nav">
				<li><a href="<?php echo $data['baseurl']; ?>article">Article</a></li>
				<li><a href="<?php echo $data['baseurl']; ?>store">Store</a></li>
				<li><a href="<?php echo $data['baseurl']; ?>video">Video</a></li>
				<li><a href="<?php echo $data['baseurl']; ?>profile">Profile</a></li>
				<li><a href="<?php echo $data['baseurl']; ?>contact">Contact me</a></li>
			</ul>
			<ul class="secondary-nav">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">Edit</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo $data['baseurl']; ?>article/edit">Article</a></li>
						<li><a href="<?php echo $data['baseurl']; ?>chat/edit">Chat</a></li>
						<li><a href="<?php echo $data['baseurl']; ?>status-update/edit">Status Update</a></li>
						<li><a href="<?php echo $data['baseurl']; ?>store/edit">Store</a></li>
						<li><a href="<?php echo $data['baseurl']; ?>store/edit-category">Store Category</a></li>
						<li><a href="<?php echo $data['baseurl']; ?>video/edit">Video</a></li>
						<li><a href="<?php echo $data['baseurl']; ?>profile/edit">Profile</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">Settings</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo $data['baseurl']; ?>logout">Sign out</a></li>
					</ul>
				</li>
			</ul>
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