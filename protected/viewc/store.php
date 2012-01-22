<div class="content">
	<div class="row">
		<div id="main-content" class="span16">
			<div class="page-header">
				<div id="pagination"></div>
			</div>
			<div id="store">
				
			</div>
		</div>
	</div>
</div>
<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/footer.php"; ?>

<!--Login-->
<script>
	//module login will use the nav modal
	$('#login-form').bind('submit', function(e){
		e.preventDefault();
			
		//declare class to be appended
		var headerDiv = $('.header-message');
		var errorDiv = $('.error-message');
			
		//declare message variable
		var header = "";
		var message = "";
			
		Common.clearDiv(headerDiv);
		Common.clearDiv(errorDiv);
			
		$.ajax({
			type : 'POST',
			url : '<?php echo $data['baseurl']; ?>login',
			data : {username : $('#username').val(), password : $('#password').val()},
			dataType : 'json',
			statusCode : {
				200 : function(data){
					window.location = data;
				},
				400 : function(){
					header = "Login Error";
					message = "Invalid combination of username/password";
					headerDiv.html(header);
					errorDiv.html(message);
					Common.navModal();
				},
				404 : function(){
					header = "Login Error";
					message = "The page is not found.";
					headerDiv.html(header);
					errorDiv.html(message);
					Common.navModal();
				}
			}
		});
	});
</script>
<script>
	$(function(){
		$.ajax({
			type: 'GET',
			url: '<?php echo $data['baseurl']; ?>store/fetch-store-item',
			success: function(data){
				if(data){
					var str = '<ul class="media-grid">';
				
					for(var i = 0; i < data.length; i++){
						str += '<li>';
						str += '<a href="#">';
						str += '<img class="thumbnail store-img" src="<?php echo $data['baseurl']; ?>'+ data[i].thumbnail+'" alt="'+ data[i].product_name +'">';
						str += '</a>';
						str += '</li>';
					}
					str += '</ul>';
				}
				$('#store').append(str);
			}
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