<div class="content">
	<div class="row">
		<div id="main-content" class="span11">
			<div class="page-header">
				<h6>Recent article</h6>
			</div>
			<div id="article">

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

<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/footer.php"; ?>
<script type="text/javascript">
	function fetchArticleList(){
		$.ajax({
			type : 'GET',
			url : '<?php echo $data['baseurl']; ?>article/fetch-article-list',
			statusCode : {
				200 : function(data){
					if(data){
						var str = '';
						for(var i = 0; i < data.length; i++){
							str += '<div class="i-content">';
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
		fetchArticleList();
	});
</script>
<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/chat.php"; ?>