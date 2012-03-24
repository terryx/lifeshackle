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
					<li class="divider-vertical"></li>
					<li><a href="<?php echo $data['baseurl']; ?>video">Video</a></li>
				</ul>
				<p class="navbar-text pull-right">Sign in <a href="<?php echo $data['baseurl']; ?>login">here</a></p>
			</div><!--/.nav-collapse -->

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