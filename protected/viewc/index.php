<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/master-nav.php"; ?>
<section id="main-container" class="row">
	<div id="main-content" class="span10">
		<h6>Recent article</h6>
		<div id="article">
		</div>
	</div>
	<div id="side-content" class="span6">
		<div id="chat-container">
			<form id="chat-form"  method="post">
				<div class="clearfix">
					<textarea id="chat-content" class="span6" disabled="disabled"></textarea>
				</div>
				<div id="chat-actions">

				</div>
			</form>
		</div>
		<div class="chatbox">

		</div>
	</div>
</section>

<div id="user-form" class="modal hide fade">
	<div class="modal-header">
		<a href="#" class="close">&times;</a>
		<h3>Please tell me about yourself :)</h3>
	</div>
	<div class="modal-body">
		<form>
			<div class="clearfix">
				<label for="username">Name</label>
				<div class="input">
					<input type="text" id="username" />
				</div>
			</div>
			<div class="clearfix">
				<label for="email">Email</label>
				<div class="input">
					<input type="text" id="email" />
				</div>
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<a href="#" id="save" class="btn primary">Save</a>
	</div>
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
		$('#user-form').modal({
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
						Common.clearDiv('.chatbox');
						fetchChatList();
					}
				},
				400 : function(){
				
				},
				404 : function(){
				
				}
			}
		});
	}
	
	function fetchArticleList(){
		$.ajax({
			type : 'GET',
			url : '<?php echo $data['baseurl']; ?>article/fetch-article-list',
			statusCode : {
				200 : function(data){
					if(data){
						var str = '';
						for(var i = 0; i < data.length; i++){
							str += '<div class="span10 i-content">';
							str += '<h2>'+data[i].k1+'</h2>';
							str += '<strong>'+data[i].k2+'</strong><br />';
							str += data[i].k3;
							str += '</div>';
						}
						$(str).appendTo('#article');
					}
				},
				404 : function(){
					displayMessage('error', 'Page not found', '.modal-body', false);
				}
			}
		})
	}
	
	$(function(){
	
		checkCookie();
	
		fetchChatList();
			
		fetchArticleList();
		
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
						fetchChatList();
					},
					400 : function(data){
						displayMessage('error', eval(data.responseText));
					},
					404 : function(){
						displayMessage('error', 'Page not found', '.modal-body', false);
					}
				}
			});
			
			return false;
		});
		
		$('#save').bind('click', function(){
			var username = $('#username').val();
			var email = $('#email').val();
			
			$.ajax({
				type: 'POST',
				url: '<?php echo $data['baseurl']; ?>chat/save-user',
				data : {username : username, email : email},
				dataType : 'json',
				statusCode : {
					200 : function(data){
						if(data){
							c_user = data[0];
							c_email = data[1];
							sendCommand();
							$('#user-form').modal('hide');
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