<?php $this->renderc('template/head-start'); ?>
<title>Lifeshackle</title>
<link rel="stylesheet" href="<?php echo Doo::conf()->APP_URL; ?>global/css/blk-form.css" type="text/css" media="screen" />
<?php $this->renderc('template/head-end'); ?>
<?php $this->renderc($data['nav']); ?>

<div id="container" class="clearall">
	<?php $this->renderc($data['menu']); ?>
	<div id="pagination"></div>
	<div id="main-content">
		<div class="content">
			<h3>Summary</h3>
			A PHP freak and jQuery ninja wannable.
		</div>

		<div class="content about">
			<h3>Software skills</h3>
			Experience with :
			<ul>
				<li>Databases : MySQL, Access</li>
				<li>Language :
					<ul>
						<li>PHP Framework : CodeIgniter, DooPHP, Zend </li>
						<li>JavaScript : jQuery</li>
						<li>HTML & CSS</li>
						<li>HTML 5 & CSS 3</li>
					</ul>
				</li>
				<li>Software :
					<ul>
						<li>Adobe Products : Dreamweaver, Illustrator, Photoshop</li>
						<li>Microsoft Office : Access, Project, Word</li>
						<li>Open Source Products : Open Office, Gimp, Netbeans, Aptana,</li>
					</ul>
				</li>
				<li>Operating Systems : Windows XP, Windows 7, Mac OS X</li>

			</ul>
		</div>

	</div><!-- end container-->

</div>
</div><!-- end container -->
<?php $this->renderc('template/footer'); ?>
<!--<script type="text/javascript" src="<?php echo Doo::conf()->local_url; ?>global/min/index.js?v1"></script>-->

<script type="text/javascript">
	$(function(){
		$('#nav a:eq(3)').addClass('active');
	});
</script>
</body>
</html>
