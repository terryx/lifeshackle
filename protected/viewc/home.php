<div class="container-fluid">
	<div class="row-fluid">
        <div class="span3">
			<!--			<div id="status-update">
							<div class="pagination">
			
							</div>
							<div id="pagination-container">
			
							</div>
						</div>-->

			<div class="well">
				<h3>Archive</h3>
				<div id="archive">
				</div>
				<div class="archive-expansion"></div>
			</div>

        </div><!--/span3-->

		<div class="span6">
			<div id="article">

			</div>
		</div>
		
		<div class="span3">
			<!-- render($data['master-tab'], $data, true) -->
		</div>

	</div><!--/row fluid -->

	<div class="row-fluid">
		<footer class="footer">
			<p>Terry Yuen's website</p>
			<p class="pull-right"><a href="#">Back to top</a></p>
		</footer>
	</div>
</div>

<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/jquery.js?v=<?php echo $data['version']; ?>"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/bootstrap/js/bootstrap.min.js?v=<?php echo $data['version']; ?>"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/common.js?v=<?php echo $data['version']; ?>"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/pagination.js?v=<?php echo $data['version']; ?>"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/home-min.js?v=<?php echo $data['version']; ?>"></script>
<!--Status Update-->
<script>
	//	$(function(){
	//		Pagination({
	//			set		: 5, 
	//			start	: '<?php echo $data['baseurl']; ?>status-update/set-pagination/',
	//			get		: '<?php echo $data['baseurl']; ?>status-update/get-pagination/'
	//		});
	//	});
</script>



<script>
	

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
