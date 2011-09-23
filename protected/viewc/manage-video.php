<?php $this->renderc('template/head-start'); ?>
<link rel="stylesheet" href="<?php echo Doo::conf()->APP_URL; ?>global/css/blk-form.css" type="text/css" media="screen" />
<?php $this->renderc('template/head-end'); ?>
<?php $this->renderc('template/a-nav'); ?>
<div id="container">
	<?php $this->renderc('template/master-menu'); ?>
	<div id="main-content">
		<div class="content-black">
			<div id="video-frame" style="text-align: center"></div>
		</div>
		<div class="content">
			<form id="manage-video-form" class="blk-form" action="<?php echo Doo::conf()->APP_URL; ?>video/save_video" method="post">
				<input type="hidden" id="video_id" name="video_id" />
				<input type="hidden" id="title" name="title" />
				<input type="hidden" id="thumbnail" name="thumbnail" />
				<label for="videolink" class="flat">Video Link</label>
				<input type="text" id="videolink" name="videolink" class="extend validate[required]" onchange="loadIframe();" /><br />
			</form>
		</div>

	</div>

	<div id="side-content">
		<div id="search-container">
			<form id="search-form">
				<input type="text" id="search" name="search" placeholder="Search" onkeyup="Search.filter();" />
				<button type="submit" id="search-button" name="search-button"></button>
			</form>
		</div>
		<div id="search_result"> </div>
	</div>

	<?php $this->renderc('template/footer'); ?>
	<script type="text/javascript" src="<?php echo Doo::conf()->APP_URL; ?>global/js/ori/manage-video.js"></script>
</body>
</html>
