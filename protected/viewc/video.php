<div class="content">
	<div class="page-header">
		<div id="pagination">

		</div>
	</div>
	<div class="row">
		<div id="main-content" class="span11">
		</div>

		<div id="side-content" class="span5">
		</div>
	</div>
</div>

<div id="login-modal" class="modal hide fade">
	<div class="modal-header">
		<a href="#" class="close">&times;</a>
		<h3>Login Error</h3>
	</div>
	<div class="modal-body">
		<div class="error-message"></div>
	</div>
</div>
<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/footer.php"; ?>
<script type="text/javascript">
	function videoLinkId(url){
		var id;
		id = url.replace(/^[^v]+v.(.{11}).*/,"$1");
		return id;
	}

	function getPagination(page){
		$.get('<?php echo $data['baseurl']; ?>video/get-pagination/'+page, function(data){
			if(data){
				Common.clearDiv('#main-content');
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
				$('#main-content').append(str);
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
	
	function setLoginModal(){
		$('#login-modal').modal({
			backdrop : true,
			keyboard : true,
			show 	 : true
		});
	}

	$(function(){
		Common.wait();
		countPage();
		getPagination(1);

		$('#login-form').bind('submit', function(e){
			e.preventDefault();
			$.ajax({
				type : 'POST',
				url : '<?php echo $data['baseurl']; ?>login',
				data : {username : $('#username').val(), password : $('#password').val()},
				dataType : 'json',
				statusCode : {
					200 : function(data){
						window.location = data;
					},
					400 : function(data){
						var str = "Invalid combination of username/password";
						var message = $('.error-message');
						Common.clearDiv(message);
						message.html(str);
						setLoginModal();
					},
					404 : function(){
						var str = "The page is not found.";
						var message = $('.error-message');
						Common.clearDiv(message);
						message.html(str);
						setLoginModal();
					}
				}
			});
		});
	});

</script>