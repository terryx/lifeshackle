<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/master-nav.php"; ?>
<section id="main-container" class="row">
	<div id="main-content" class="span11">
		<button class="btn info" onclick="clearForm()">New</button>
		<div id="video-frame" class="span10"></div>
		<div class="clear"></div>
		<form id="manage-video-form" action="<?php echo $data['baseurl']; ?>video/save_video" method="post" class="form-stacked">
			<input type="hidden" id="video_id" name="video_id" />
			<input type="hidden" id="title" name="title" />
			<input type="hidden" id="thumbnail" name="thumbnail" />
			<div class="clearfix">
				<label for="videolink">Video Link</label>
				<div class="input">
					<input type="text" id="videolink" name="videolink" class="extend validate[required] span6" />
				</div>
			</div>
		</form>
	</div>

	<div class="span5">
		<div id="pagination">

		</div>
		<div id="search-container">
			<form id="search-form">
				<input type="text" id="search" name="search" placeholder="Search" onkeyup="Search.filter();" class="span5" />
				<button type="submit" id="search-button" name="search-button"></button>
			</form>
		</div>
		<div id="search-result"></div>
	</div>
</section>
<div id="footer"></div>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>-->
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/jquery-ui.js?<?php echo $data['version']; ?>"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/twitter-bootstrap/bootstrap-all.js"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/common.js?<?php echo $data['version']; ?>"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/min/jquery.paginate.js?<?php echo $data['version']; ?>"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/min/jquery.validationEngine.js?<?php echo $data['version']; ?>"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/jquery.tablesorter.min.js?<?php echo $data['version']; ?>"></script>
<script type="text/javascript">
	var cachePage = 1;
	
	function clearForm(){
		Common.clearDiv('#video-frame');
		Common.clearDiv('#manage-video-form');
		var str = '<input type="hidden" id="video_id" name="video_id" />';
		str += '<input type="hidden" id="title" name="title" />';
		str += '<input type="hidden" id="thumbnail" name="thumbnail" />';
		str += '<div class="clearfix">';
		str += '<label for="videolink">Video Link</label>';
		str += '<div class="input">';
		str += '<input type="text" id="videolink" name="videolink" class="extend validate[required] span6" onchange="loadIframe();" />'
		str += '</div>';
		str += '</div>';
		$('#manage-video-form').append(str);
	}
	
	function loadIframe(){

		var url = $('#videolink').val();

		var id = videoLinkId(url);
		Common.clearDiv('#video-frame');

		var str = '<iframe width="560" height="349" src="http://www.youtube.com/embed/'+id+'" frameborder="0" allowfullscreen></iframe>';
		$('#video-frame').append(str);

		$('iframe').load(function(){
			$.get('https://gdata.youtube.com/feeds/api/videos/'+id+'?v=2&alt=json', function(data){
				if(data){
					if($.browser.mozilla){
						data = JSON.parse(data);
					}
					var title = data.entry.title.$t;
					var thumbnail = data.entry.media$group.media$thumbnail[0].url;
					$('#title').val(title);
					$('#thumbnail').val(thumbnail);
				}
			});
			var str = '<input type="submit" id="submit" name="submit" value="Post" class="btn primary" />';
			$('#manage-video-form').append(str);
		});
	}

	function videoLinkId(url){
		var id;
		id = url.replace(/^[^v]+v.(.{11}).*/,"$1");
		return id;
	}

	function deleteVideo(id){
		$.delete_('<?php echo $data['baseurl']; ?>video/delete_video/'+id, function(data){
			if(data){
				clearForm();
				Search.onload('<?php echo $data['baseurl']; ?>video/admin-get-pagination/'+cachePage, '#manage-video-form');
			}
			else {
				displayMessage('warning', 'Video could not be deleted');
			}
		});
	}

	function refreshForm(id){
		Common.clearDiv('#video-frame');
		Common.clearDiv('#manage-video-form');
		Common.wait();
		$.get('<?php echo $data['baseurl']; ?>video/get_one_video/'+id, function(data){
			if(data){
				var id = videoLinkId(data.link);
				var iframe = '<iframe width="545" height="349" src="http://www.youtube.com/embed/'+id+'?wmode=transparent" frameborder="0" allowfullscreen></iframe>';
				
				var str = '<input type="hidden" id="video_id" name="video_id" value="'+data.video_id+'"/>';
				str += '<div class="row">';
				str += '<div class="clearfix">';
				str += '<label for="visible">Visible to public ?</label>';
				str +=  is_visible(data.visible);
				str += '</div>';
				str +='<div class="clearfix">';
				str += '<label for="title">Title</label>';
				str += data.title;
				str += '</div>';
				str += '<div class="actions">';
				str += '<button class="btn primary" type="submit" id="submit" name="submit">Update</button>&nbsp;';
				str += '<span id="deleteButton"><button type="button" class="btn danger" onclick="deleteVideo('+ data.video_id +');">Delete</button></span>';
				str += '</div>';
				str += '</div>';
				$('#video-frame').append(iframe);
				$('#manage-video-form').append(str);
				//				$('iframe').load(function(){
					
				Common.end();
				//				});
			}

		});
	}

	function is_visible(data){
		var visible = '';
		if(data === "1"){
			visible  = '<input type="radio" name="visible" value="1" checked />&nbsp;Yes&nbsp;&nbsp;';
			visible += '<input type="radio" name="visible" value="0" /> No';
		}

		else{
			visible = '<input type="radio" name="visible" value="1" />&nbsp;Yes&nbsp;&nbsp;';
			visible += '<input type="radio" name="visible" value="0" checked /> No';
		}
		return visible;
	}

	function ajaxCallback(status, form, json){
		$('body').css('cursor', 'default');
		if(status === true ) {
			if(json === 200){
				displayMessage('info', 'Video has updated');
			}
			if(json[0] === 201){
				displayMessage('success', 'Video posted successfully');
				refreshForm(json[1]);
			}
		}
		Search.onload('<?php echo $data['baseurl']; ?>video/admin-get-pagination/'+cachePage, '#manage-video-form');
	}
	
	function countPage(){
		$.get('<?php echo $data['baseurl']; ?>video/admin-count-page', function(data){
			if(data){
				paginate(data);
				Search.onload('<?php echo $data['baseurl']; ?>video/admin-get-pagination/'+cachePage, '#manage-video-form');
			} else {
				return false;
			}
		});
	}

	function paginate(count){
		$("#pagination").paginate({
			count 		: count,
			start 		: 1,
			//      display     : 3,
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
				cachePage = page;
				Search.onload('<?php echo $data['baseurl']; ?>video/admin-get-pagination/'+page);
			}
		});
	}
	
	$(function(){
		
		countPage();
	
		//form validation
		$('#manage-video-form').validationEngine({
			ajaxFormValidation: true,
			onAjaxFormComplete: ajaxCallback
		});

		$('#videolink').bind('change', function(){
			loadIframe();
			
		});

		
	}); //end document ready
</script>