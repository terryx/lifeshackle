<?php $this->renderc('template/head-start'); ?>
<title>Lifeshackle</title>
<link rel="stylesheet" href="<?php echo Doo::conf()->APP_URL; ?>global/css/blk-form.css" type="text/css" media="screen" />
<?php $this->renderc('template/head-end'); ?>
<?php $this->renderc($data['nav']); ?>

<div id="container" class="clearall">
	<?php $this->renderc($data['menu']); ?>
	<div id="pagination"></div>
	<div id="main-content">
	</div>

	<div id="side-content">
		<div id="archive">
		</div>
	</div>
</div><!-- end container -->
<?php $this->renderc('template/footer'); ?>
<script type="text/javascript" src="<?php echo Doo::conf()->local_url; ?>global/js/ori/index.js?v1"></script>
</body>
</html>
