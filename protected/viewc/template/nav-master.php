<div class="topbar" data-dropdown="dropdown">
		<div class="topbar-inner">
			<div class="container">
				<a class="brand" href="<?php echo $data['baseurl']; ?>">Life's Shackle</a>
				<ul class="nav">
					<li><a href="<?php echo $data['baseurl']; ?><?php echo $data['role']; ?>">Control Index</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle">Article</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $data['baseurl']; ?>article">View</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo $data['baseurl']; ?>article/edit">Edit</a></li>
						</ul>
					</li>
					<li><a href="<?php echo $data['baseurl']; ?><?php echo $data['role']; ?>/chat/edit">Chat</a></li>
					<li><a href="<?php echo $data['baseurl']; ?><?php echo $data['role']; ?>/profile">Profile</a></li>
					<li><a href="<?php echo $data['baseurl']; ?><?php echo $data['role']; ?>/status-update/edit">Status Update</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle">Video</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $data['baseurl']; ?>video">View</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo $data['baseurl']; ?>video/edit">Edit</a></li>
						</ul>
					</li>
				</ul>
				<ul class="secondary-nav">
					<li><a href="<?php echo $data['baseurl']; ?>logout">Sign out</a></li>
				</ul>
			</div>
		</div>
    </div>

<div id="nav-modal" class="modal hide fade">
	<div class="modal-header">
		<a href="#" class="close">&times;</a>
		<h3></h3>
	</div>
	<div class="modal-body">
		<div class="error-message"></div>
	</div>
	<div class="modal-footer">
		
	</div>
</div>
