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
<?php include "{$data['module_login']}.php"; ?>
<?php include "{$data['module_chat']}.php"; ?>