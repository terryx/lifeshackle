<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/master-nav.php"; ?>
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