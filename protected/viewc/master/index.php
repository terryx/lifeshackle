<section id="navigation">
	<div class="topbar" data-dropdown="dropdown">
		<div class="topbar-inner">
			<div class="container">
				<a class="brand" href="<?php echo $data['baseurl']; ?><?php echo $data['role']; ?>">Life's Shackle</a>
				<ul class="nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle">Article</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $data['baseurl']; ?>article/view">View</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo $data['baseurl']; ?>article/edit">Edit</a></li>
						</ul>
					</li>
					<li><a href="<?php echo $data['baseurl']; ?><?php echo $data['role']; ?>/profile">Profile</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle">Video</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $data['baseurl']; ?>video/view">View</a></li>
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
</section>
<section id="main-container" class="row">
	<div id="main-content" class="span11">
		<ul class="breadcrumb">
			<li>Master Setting
				<span class="divider">/</span>
			</li>
			<li>
				<a href="#" data-controls-modal="edit-profile-modal" data-backdrop="true" data-keyboard="true">Edit</a>
			</li>
		</ul>


	</div>

	<div class="span5">

	</div>
</section>
<div class="pagination"></div>
<div id="footer"></div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/twitter-bootstrap/bootstrap-all.js"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/min/common.js?<?php echo $data['version']; ?>"></script>
<script type="text/javascript">
	
</script>