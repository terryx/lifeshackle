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
			<form id="chat-form" method="post">
				<div class="clearfix">
					<textarea id="chat-content" class="span5" disabled="disabled"></textarea>
				</div>
				<div id="chat-actions">

				</div>
			</form>
			<div class="chatbox">

			</div>
		</div>
	</div>
</div>

<div id="chat-modal" class="modal hide fade">
	<form id="user-form">
		<div class="modal-header">
			<a href="#" class="close">&times;</a>
			<h3>Please tell me about yourself :)</h3>
		</div>
		<div class="modal-body">
			<div class="clearfix">
				<label for="chatuser">Name</label>
				<div class="input">
					<input type="text" id="chatuser" name="chatuser" />
				</div>
			</div>
			<div class="clearfix">
				<label for="chatemail">Email</label>
				<div class="input">
					<input type="text" id="chatemail" name="chatemail" />
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="submit" class="btn primary">Save</button>
		</div>
	</form>
</div>

<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/footer.php"; ?>
<script type="text/javascript">
	var c_user = '<?php echo $data['chatuser']; ?>';
	var c_email = '<?php echo $data['chatemail']; ?>';
	var last_id = 0;
	
	function sendCommand(){
		$('#chat-actions').html('');
		$('#chat-content').removeAttr('disabled');
		var str = '<button type="submit" class="btn primary">Send</button>&nbsp;';
		str += '<button type="button" onclick="setUserInfo()" class="btn">Change name</button>&nbsp;';
		$('#chat-actions').append(str);
	}
	
	function setUserInfo(){
		$('#chat-modal').modal({
			backdrop : true,
			keyboard : true,
			show 	 : true
		});
	}
	
	function checkCookie(){
		if(c_user && c_email !== undefined){
			sendCommand();
		} else {
			var str = '<button type="button" id="lets-chat" onclick="setUserInfo()" class="btn">Lets Chat</button>';
			$('#chat-actions').append(str);
		}
	}
	
	function fetchChatList(){
		$.ajax({
			type : 'GET',
			url : '<?php echo $data['baseurl']; ?>chat/fetch-chat-list',
			dataType: 'json',
			statusCode : {
				200 : function(data){
					Common.clearDiv('.chatbox');
					var str = '';
					
					if(data){
						for(var i = 0; i < data.length; i++){
							str += '<div class="chatpost">';
							str += '<a href="http://'+ data[i].k4 +'">'+ data[i].k3 + '</a>&nbsp;';
							str += '<span class="chat-time">' + data[i].k1 + '</span><br />';
							str += data[i].k2;
							str += '</div>';
						}
						last_id = data.length;
						$('.chatbox').append(str);
					}
				},
				400 : function(){
					
				},
				404 : function(){
					displayMessage('error', 'Page not found', '.modal-body', false);
				}
			}
		});
	}
	
	function poolChat(){
		$.ajax({
			type : 'GET',
			url : '<?php echo $data['baseurl']; ?>chat/pool-chat/'+last_id,
			dataType : 'json',
			statusCode : {
				200 : function(data){
					if(data){
						var str = '';
						last_id = data[1];
						for(var i = 0; i < data[0].length; i++){
							str += '<div class="chatpost">';
							str += '<a href="http://'+ data[0][i].k4 +'">'+ data[0][i].k3 + '</a>&nbsp;';
							str += '<span class="chat-time">' + data[0][i].k1 + '</span><br />';
							str += data[0][i].k2;
							str += '</div>';
							$('.chatbox').prepend(str);
						}
					}
				},
				400 : function(){
				
				},
				404 : function(){
				
				}
			}
		});
	}
	
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
	
	function setLoginModal(){
		$('#login-modal').modal({
			backdrop : true,
			keyboard : true,
			show 	 : true
		});
	}

	$(function(){
		//video settings
		Common.wait();
		countPage();
		getPagination(1);
		
		//chat settings
		checkCookie();
		fetchChatList();
		setInterval(poolChat, 3000);
		
		$('#chat-form').submit(function(){
			
			//send chat
			$.ajax({
				type : 'POST',
				url : '<?php echo $data['baseurl']; ?>chat/save-chat',
				data : { c_user : c_user, c_email : c_email, chat_content : $('#chat-content').val() },
				dataType : 'json',
				statusCode : {
					201 : function(data){
						$('#chat-form')[0].reset();
						poolChat();
						Common.removeDiv('.alert-message');
					},
					400 : function(data){
						displayMessage('error', eval(data.responseText), '#side-content');
					},
					404 : function(){
						displayMessage('error', 'Page not found', '.modal-body', false);
					}
				}
			});
			
			return false;
		});
		
		$('#user-form').bind('submit', function(e){
			e.preventDefault();
			
			$.ajax({
				type: 'POST',
				url: '<?php echo $data['baseurl']; ?>chat/save-user',
				data : {chatuser : $('#chatuser').val(), chatemail : $('#chatemail').val()},
				dataType : 'json',
				statusCode : {
					200 : function(data){
						if(data){
							c_user = data[0];
							c_email = data[1];
							sendCommand();
							$('#chat-modal').modal('hide');
						}
					},
					400 : function(data){
						displayMessage('error', eval(data.responseText), '.modal-body', false);
					},
					404 : function(){
						displayMessage('error', 'Page not found', '.modal-body', false);
					}
				}
			});
		});

		$('#login-form').bind('submit', function(e){
			e.preventDefault();
			
			//declare class to be appended
			var headerDiv = $('.header-message');
			var errorDiv = $('.error-message');
			
			//declare message variable
			var header = "";
			var message = "";
			
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
						
						Common.clearDiv(errorDiv);
						headerDiv.html(header);
						errorDiv.html(message);
						Common.navModal();
					},
					404 : function(){
						header = "Login Error";
						message = "The page is not found.";
						
						Common.clearDiv(message);
						message.html(str);
						Common.navModal();
					}
				}
			});
		});
	});

</script>