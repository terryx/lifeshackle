<div class="content">
	<div class="row">
		<div id="main-content" class="span16">
			<div class="profile-picture">
				<ul class="media-grid">

				</ul>
				<button type="button" class="btn primary">Upload picture</button>
			</div>
			<form id="profile-form" method="post" action="<?php echo $data['baseurl']; ?>profile/save">
				<input type="hidden" id="profile_id" name="profile_id" value="" />
				<div class="clearfix">
					<textarea id="txtcontent" name="txtcontent" cols="60" rows="10"><?php echo $data['profile_content']; ?></textarea>
				</div>
				<div class="actions">
					<button type="submit" class="btn primary">Save</button>
					<button class="btn" type="reset">Cancel</button>
				</div>
			</form>
		</div>
	</div>

	<div id="edit-picture-modal" class="modal hide fade">
		<div class="modal-header">
			<a href="#" class="close">&times;</a>
			<h3>Change Picture</h3>
		</div>
		<div class="modal-body">
			<div class="clearfix">
				<iframe src="<?php echo $data['baseurl']; ?>template/picture-form" style="width:500px;border:none">
				</iframe>
			</div>
		</div>
	</div>
</div>
<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/footer.php"; ?>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/plugin/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
	$('#txtcontent').tinymce({
		script_url : '<?php echo $data['baseurl']; ?>global/plugin/tiny_mce/tiny_mce_gzip.php',

		theme : "advanced",
		plugins : "advimage,advlink,emotions,inlinepopups,preview,media,print,contextmenu,paste,fullscreen,noneditable,nonbreaking,fullpage",
		dialog_type : "modal",
		content_css : "<?php echo $data['baseurl']; ?>global/css/editor.css",
		gecko_spellcheck : true,

		// Theme options
		theme_advanced_resizing : true,
		theme_advanced_source_editor_width : 2000,
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "image,media,emotions,|,bullist,numlist,|,blockquote,|,undo,redo,|,anchor,cleanup,code,|,forecolor,backcolor,|,hr,removeformat,|,charmap,|,print,|,fullscreen,|,preview",
		theme_advanced_buttons3 : 'fullpage',
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom"

	});
</script>

<script>
	function deletePopup(id){
		$.ajax({
			type: 'GET',
			url: '<?php echo $data['baseurl']; ?>profile/delete-picture/'+id,
			dataType: 'json',
			success: function(data){
				if(data[0] === 'deleted'){
					fetchPicture();
				}
			}
		});
	}
	
	function setCurrent(id){
		$.ajax({
			type: 'GET',
			url: '<?php echo $data['baseurl']; ?>profile/set-current-picture/'+id,
			dataType: 'json',
			success: function(data){
				if(data[0] === 'updated'){
					if ($('a').hasClass('is_current')) {
						$('.is_current').removeClass('is_current');
					}
					
					$('.img-'+id).addClass('is_current');
				}
			}
		});
	}
	
	function fetchPicture(){
		var ul = $('ul.media-grid');
		var current = '';
		var str = '';
				
		//fetch all pictures
		$.ajax({
			type: 'GET',
			url: '<?php echo $data['baseurl']; ?>profile/fetch-picture',
			dataType: 'json',
			success: function(data){
				if(data){
					for(var i=0, len=data.length; i<len; i++){
						current = (data[i].is_current === 'yes') ? 'is_current' : null;
						str += '<li>';
						str += '<a class="img-'+ data[i].picture_id +' '+ current +'" href="<?php echo $data['baseurl']; ?>global/uploaded_pic/'+ data[i].original +'" target="_blank" title="'+ data[i].caption +'">';
						str += '<span class="zoom-in" onclick="return false">';
						str += '<span class="zoom-link" onclick="setCurrent('+ data[i].picture_id +');"> Set as current</span>';
						str += '<span class="zoom-link" onclick="deletePopup('+ data[i].picture_id +');">Delete</span>';
						str += '</span>';
						str += '<img src="<?php echo $data['baseurl']; ?>global/resized_pic/'+ data[i].resized +'" alt="" />';
						str += '</a></li>';
						
					}
				}
			},
			complete: function(){
				Common.clearDiv('ul.media-grid');
				ul.append(str);
			}
		});
	}
	
	$(function(){
		fetchPicture();
	
		$('.profile-picture').children('button').bind('click', function(){
			
			var strUrl			= '<?php echo $data['baseurl']; ?>profile/upload-picture-page',
			strWindowName		= 'Upload profile picture',
			strWindowFeatures	= 'fullscreen=0 , height=200 , width=450 , location=0 ,resizable=0 ,menubar=, left=200';
		
			var uploadpopup = window.open(strUrl, strWindowName, strWindowFeatures);
		
			$(uploadpopup).unload(function(){
				fetchPicture();
			});
		});
		
		$('#profile-form').bind('submit', function(e){
			e.preventDefault();
			
			var form = $(this);
			
			$.ajax({
				type: 'POST',
				url: form.attr('action'),
				data: { profile_id: $('#profile_id').val(), txtcontent : $('#txtcontent').val() },
				dataType: 'json',
				success: function(data){
					console.log(data);
				}
				
			});
		});
		
	})
</script>
