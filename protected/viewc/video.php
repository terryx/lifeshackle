<div class="content">
	<div class="row">
		<div id="main-content" class="span11">
			<div class="page-header">
				<div id="pagination">

				</div>
			</div>
			<div id="video">

			</div>
		</div>

		<div id="side-content" class="span5">
			
		</div>
	</div>
</div>

<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/footer.php"; ?>

<!--Video-->
<script>
	function videoLinkId(url){
		var id;
		id = url.replace(/^[^v]+v.(.{11}).*/,"$1");
		return id;
	}

	function getPagination(page){
		$.get('<?php echo $data['baseurl']; ?>video/get-pagination/'+page, function(data){
			if(data){
				Common.clearDiv('#video');
				var id;
				var title;
				var src;
				var thumbnail;
				var str = '<ul class="media-grid">';
				for(var i = 0; i<data.length; i++){
					id = data[i].k0;
					title = data[i].k1;
					src = data[i].k2
					thumbnail = data[i].k3;

					str += '<li><a href="'+ src +'" target="_blank" title="'+ title +'"><img id="video-'+ id +'" src="'+ thumbnail +'" class="video-box" alt="" /></a></li>';
				}

				str += '</ul>';
				Common.end();
				$('#video').append(str);
			}
		});
	}
	
	function countPage(){
		$.get('<?php echo $data['baseurl']; ?>video/count-page', function(data){
			if(data){
				paginate(data);
			}
		});
	}

	function paginate(count){
		$("#pagination").paginate({
			count 		: count,
			start 		: 1,
			border					: true,
			border_color			: '#fff',
			text_color  			: '#fff',
			background_color    	: 'black',
			border_hover_color		: '#ccc',
			text_hover_color  		: '#000',
			background_hover_color	: '#fff',
			images					: false,
			mouse					: 'press',
			onChange     			: function(page){
				getPagination(page);
			}
		});
	}
	
	$(function(){
		//video settings
		Common.wait();
		countPage();
		getPagination(1);
		
	});
</script>

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
