<section id="navigation1">
	<div class="topbar" data-dropdown="dropdown">
		<div class="topbar-inner">
			<div class="container">
				<a class="brand" href="<?php echo $data['baseurl']; ?>home">Life's Shackle</a>
				<ul class="nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle">Article</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $data['baseurl']; ?>article">Main</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo $data['baseurl']; ?>manage-article">Edit</a></li>
						</ul>
					</li>
					<li><a href="<?php echo $data['baseurl']; ?>profile">Profile</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle">Video</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $data['baseurl']; ?>video">Main</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo $data['baseurl']; ?>manage-video">Edit</a></li>
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