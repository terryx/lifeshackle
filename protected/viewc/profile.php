<div class="content">
	<div class="page-header">
		<h6>have a nice day xD</h6>
	</div>
	<div class="row">
		<div id="main-content" class="span11">
			<div id="personal">
				<h5>Personal Info</h5>
				<div id="personal-info">

				</div>
			</div>

			<div id="technical">
				<h5>Technical Skills</h5>
				<div id="technical-info">

				</div>
			</div>

			<div id="quote">
				<h5>Favorite Quotes</h5>
				<div id="quote-info">

				</div>
			</div>
		</div>
		<div id="side-content" class="span5">
			<img src="<?php echo $data['baseurl']; ?>global/img/terry.jpg" alt="terry" /> 
		</div>
	</div>
</div>
<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/footer.php"; ?>
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
<?php include "{$data['module_login']}.php"; ?>
<?php include "{$data['module_chat']}.php"; ?>