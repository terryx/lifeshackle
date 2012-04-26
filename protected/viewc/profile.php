<!DOCTYPE html>
<html>
	<head>
		<?php include "{$data['header']}.php"; ?>
	</head>
	<body>
		<?php include "{$data['nav']}.php"; ?>
		<div class="container">
			<div class="row">
				<div class="span9">
					<div id="profile-container" class="well">
					</div>
				</div>
				<div class="span3">
					<div id="profile-picture">
					</div>
				</div>
			</div><!--/row -->
			<hr />

			<?php include "{$data['footer']}.php"; ?>
		</div><!-- end container-fluid -->
		<script>
			$(function(){
				
				$.ajax({
					type: 'GET',
					url: '/profile/get',
					success: function(data){
						var image;
						image = '<a href="'+ data[1][0] +'"><img src="/'+ data[1][1] +'" /></a>'; 
						$('#profile-container').append(data[0]);
						$('#profile-picture').append(image);
					}
				});
				
			});
		</script>
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
	</body>
</html>