<div class="content">
	<div class="page-header">
		<h6>have a nice day xD</h6>
	</div>
	<div class="row">
		<div id="main-content" class="span11">
			<?php echo $data['profile_content']; ?>
		</div>
		<div id="side-content" class="span5">
			<ul class="media-grid">
				<li>
					<a href="<?php echo $data['profile_img_link']; ?>">
					<img src="<?php echo $data['profile_img_src']; ?>" alt="" />
					</a>
				</li>
			</ul>
			<ul class="media-grid">
				
			</ul>
		</div>
	</div>
</div>
<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/footer.php"; ?>

<!--Profile-->
<script type="text/javascript">
	$(function(){
	
		$.ajax({
			
		});
		
	});
	
	
</script>

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