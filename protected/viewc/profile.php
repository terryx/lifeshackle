<section id="navigation">
	<div class="topbar" >
		<div class="topbar-inner">
			<div class="container">
				<a class="brand" href="<?php echo $data['baseurl']; ?>home">Life's Shackle</a>
				<ul class="nav">
					<li><a href="<?php echo $data['baseurl']; ?>video">Video</a></li>
					<li><a href="<?php echo $data['baseurl']; ?>profile">Profile</a></li>
				</ul>
				<ul class="secondary-nav">
					<li><a href="<?php echo $data['baseurl']; ?>sign-in">Sign in</a></li>
				</ul>
			</div>
		</div>
    </div>
</section>
<section id="main-container" class="row">
<div id="main-content" class="span11">
	<section id="personal">
		<h5>Personal Info</h5>
		<div id="personal-info">
			
		</div>
	</section>

	<section id="technical">
		<h5>Technical Skills</h5>
		<div id="technical-info">

		</div>
	</section>
	
	<section id="quote">
		<h5>Favorite Quotes</h5>
		<div id="quote-info">

		</div>
	</section>
</div>
<div class="span5">
	<img src="<?php echo $data['baseurl']; ?>global/img/terry.jpg" alt="terry" /> 
</div>
</section>
<div id="footer"></div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/twitter-bootstrap/bootstrap-all.js"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/common.js?<?php echo $data['version']; ?>"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/min/jquery.validationEngine.js?<?php echo $data['version']; ?>"></script>
<script type="text/javascript">
	$(function(){
	
		//render all info here
		getProfile();
	
	});
	
	function getProfile(){
		$.get('<?php echo $data['baseurl']; ?>profile/get', function(data){
			if(data){
				//insert data to personal div
				Common.clearDiv('#personal-info');
				var str0 = '<div class="span10 bottom-padding">';
				str0 += data.personal;
				str0 += '</div>';
				$('#personal-info').append(str0);
					
				//insert data to technical div
				Common.clearDiv('#technical-info');
				var str1 = '<div class="span10 bottom-padding">';
				str1 += data.technical;
				str1 += '</div>';
				$('#technical-info').append(str1);
				
				//insert data to quote div
				Common.clearDiv('#quote-info');
				var str2 = '<div class="span10">';
				str2 += data.quote;
				str2 += '</div>';
				$('#quote-info').append(str2);
				
			}
		});
	}
	
</script>