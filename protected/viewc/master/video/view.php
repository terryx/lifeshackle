<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/master-nav.php"; ?>
<section id="main-container" class="row">
	<div id="main-content" class="span11">
	</div>

	<div class="span5">
		<div id="pagination">

		</div>
	</div>
</section>
<div id="footer"></div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/twitter-bootstrap/bootstrap-all.js"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/common.js?v1"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/min/jquery.paginate.js?v1"></script>
<script type="text/javascript">
	function videoLinkId(url){
		var id;
		id = url.replace(/^[^v]+v.(.{11}).*/,"$1");
		return id;
	}

	// function setVideo(id, src){
	// 
	// 	var url_id	= videoLinkId(src);
	// 	var modal	= 'modal-video-'+id; 
	// 
	// 	var str = '';
	// 	str += '<div id="'+ modal +'" class="modal hide fade">';
	// 	str += '<div class="modal-body">';
	// 	str += '<iframe width="420" height="315" src="http://www.youtube.com/embed/'+ url_id +'" frameborder="0" allowfullscreen></iframe>';
	// 	str += '</div>';
	// 	str += '<div class="modal-footer">';
	// 	str += '<a href="#" class="close">&times;</a>';
	// 	str += '</div>';
	// 	str += '</div>';
	// 	$('#main-content').append(str);
	// 
	// 	renderModal(modal);
	// }

	function renderModal(modal){
		$('#'+ modal).modal({
			show : true,
			backdrop : true,
			keyboard : true
		});
	}

	function getPagination(page){
    
		$.get('<?php echo $data['baseurl']; ?>video/get-pagination/'+page, function(data){
			if(data){
				console.log(data);
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
				//setVideo(id, title, src);

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
		Common.wait();
		countPage();
		getPagination(1);

	});

</script>