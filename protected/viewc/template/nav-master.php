<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
        <div class="container-fluid">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="<?php echo $data['baseurl']; ?>">Life's Shackle</a>
			<div class="nav-collapse">
				<ul class="nav">
					<li><a href="<?php echo $data['baseurl']; ?>master">Master</a></li>
					<li class="divider-vertical"></li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Article <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li data-id="article"><a href="<?php echo $data['baseurl']; ?>article">Public</a></li>
							<li data-id="edit-article"><a href="<?php echo $data['baseurl']; ?>master/article">Edit</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Video <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li data-id="video"><a href="<?php echo $data['baseurl']; ?>video">Public</a></li>
							<li data-id="edit-video"><a href="<?php echo $data['baseurl']; ?>master/video">Edit</a></li>
						</ul>
					</li>
					<li><a href="<?php echo $data['baseurl']; ?>video">Video</a></li>
					<li><a href="<?php echo $data['baseurl']; ?>profile">Profile</a></li>
				</ul>
				<p class="navbar-text pull-right"><a href="<?php echo $data['baseurl']; ?>logout">Logout</a></p>
			</div><!--/.nav-collapse -->

        </div>
	</div>
</div>