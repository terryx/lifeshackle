<!DOCTYPE html>
<html>
	<head>
		<?php include "{$data['header']}.php"; ?>
	</head>
	<body>
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span2">
					<div class="well">
						<div class="row-fluid">
							<ul class="nav nav-list">
								<li class="nav-header"><a href="/">Life's Shackle</a></li>
								<li data-id="home"><a href="#"><i class="icon-home"></i> Home</a></li>
								<li data-id="profile"><a href="#"><i class="icon-user"></i> Profile</a></li>
								<li data-id="video"><a href="#"><i class="icon-facetime-video"></i> Youtube</a></li>
								<li class="divider"></li>
							</ul>
						</div>
					</div> <!-- /well -->
				</div>
				<div class="span8">
					<div class="main-panel"></div>
				</div>
			</div><!--/row fluid -->

			<?php include "{$data['footer']}.php"; ?>

		</div><!-- end container-fluid -->
		<script type="text/javascript" src="/global/js/home-min.js"></script>
		<script type="text/javascript" src="/global/js/profile-min.js"></script>
		<script type="text/javascript" src="/global/js/video-min.js"></script>
		<script>
			var $main = $('.main-panel');
			
			$(function(){
				var nav;
				
				$('.nav-list').children('li').bind('click', function(){
					var $this = $(this); 
					nav = $this.data('id');
					
					$('.nav-list').children('li').removeClass('active');
					$('.nav-list').children('li').children('a').children('i').removeClass('icon-white');
					
					$this.addClass('active');
					$this.children('a').children('i').addClass('icon-white');
					
					switch(nav){
						case 'home':
							Life.start();
							break;
						case 'profile':
							Profile.start();
							break;
						case 'video':
							Video.start();
							break;
					}
				});
				
				Life.start();
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
	</body>
</html>