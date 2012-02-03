<div class="content">
	<div class="row">
		<div id="main-content" class="span11">
			<div id="status-update">
				<div class="pagination">

				</div>
				<div id="pagination-container">

				</div>
			</div>
		</div>
		<div id="side-content" class="span5">
			<h5>My playlist</h5>
			<iframe width="280" height="172" src="http://www.youtube.com/embed/videoseries?list=PL38771D7D35A5BB42&amp;hl=en_US" frameborder="0" allowfullscreen></iframe>
		</div>
	</div>
</div>

<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/footer.php"; ?>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/pagination.js"></script>
<!--Status Update-->
<script>
	$(function(){
		Pagination({
			set		: 5, 
			start	: '<?php echo $data['baseurl']; ?>status-update/set-pagination/',
			get		: '<?php echo $data['baseurl']; ?>status-update/get-pagination/'
		});
	});
</script>

<!-- Mini profile -->

<!-- Google Analytics -->
<script type="text/javascript">
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
	try{
		var pageTracker = _gat._getTracker("UA-27701779-1");
		pageTracker._trackPageview();
	} catch(err) {}
</script>