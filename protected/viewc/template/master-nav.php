<!--<section id="navigation">
	<div class="page-header">

		<h1>Navigation</h1>
	</div>
	<h2>Fixed topbar</h2>
	<div class="topbar-wrapper" style="z-index: 5;">
		<div class="topbar" data-dropdown="dropdown" >
			<div class="topbar-inner">
				<div class="container">
					<h3><a href="#" class="brand">Life&CloseCurlyQuote;s Shackle</a></h3>

					<ul class="nav">
						<li class="active"><a href="#">Home</a></li>
						<li><a href="#">Link</a></li>
						<li><a href="#">Link</a></li>
						<li><a href="#">Link</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle">Dropdown</a>

							<ul class="dropdown-menu">
								<li><a href="#">Secondary link</a></li>
								<li><a href="#">Something else here</a></li>
								<li class="divider"></li>
								<li><a href="#">Another link</a></li>
							</ul>
						</li>

					</ul>
					<form class="pull-left" action="">
						<input type="text" placeholder="Search" />
					</form>
					<ul class="nav secondary-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle">Dropdown</a>
							<ul class="dropdown-menu">

								<li><a href="#">Secondary link</a></li>
								<li><a href="#">Something else here</a></li>
								<li class="divider"></li>
								<li><a href="#">Another link</a></li>
							</ul>
						</li>
					</ul>

				</div>
			</div> /topbar-inner 
		</div> /topbar 
	</div> /topbar-wrapper 

</section>-->

<section id="navigation1">
	<div class="topbar" data-dropdown="dropdown">
		<div class="topbar-inner">
			<div class="container">
				<a class="brand" href="<?php echo $data['baseurl']; ?>home">Life's Shackle</a>
				<ul class="nav">
					<li><a href="<?php echo $data['baseurl']; ?>video">Video</a></li>
					<li><a href="<?php echo $data['baseurl']; ?>about">About</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle">Manage</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $data['baseurl']; ?>manage-article">Article</a></li>
							<li><a href="<?php echo $data['baseurl']; ?>manage-video">Video</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo $data['baseurl']; ?>manage-about">About</a></li>
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