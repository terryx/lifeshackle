<div id="chat-modal" class="modal hide fade">
	<div class="modal-header">
		<a href="#" class="close">&times;</a>
		<h3>Please tell me about yourself :)</h3>
	</div>
	<div class="modal-body">
		<form id="user-form">
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
		</form>
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn primary">Save</button>
	</div>
</div>
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
					displayMessage('error', 'Page not found', '.modal-body', false);
				}
			},
			complete : function(){
				Common.removeDiv('.chat-loader');
			}
		});
	
	}
	
	$(function(){
		checkCookie();
		
		fetchChatList();
	
		setInterval(poolChat, 3000);
	
		$('#chat-form').submit(function(){
			var str = '<div class="chat-loader"></div>'; 
			//send chat
			$.ajax({
				type : 'POST',
				url : '<?php echo $data['baseurl']; ?>chat/save-chat',
				data : { c_user : c_user, c_email : c_email, chat_content : $('#chat-content').val() },
				dataType : 'json',
				beforeSend : function(){
					$('.chatbox').prepend(str);
				},
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
	});
</script>