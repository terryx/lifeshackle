<!DOCTYPE html>
<html>
	<head>
		<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/header.php"; ?>
	</head>
	<body>
		<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/nav-master.php"; ?>
		<div class="container">
			<div class="row">
				<div class="span9">
					<div id="article-container" class="well">
					</div>
				</div>
				<div class="span3">
					<div class="pagination"></div>
					<div id="article-list">
					</div>
				</div>
			</div><!--/row -->
			<hr />

			<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/footer.php"; ?>
		</div><!-- end container-fluid -->
		<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/plugin/tiny_mce/jquery.tinymce.js"></script>
		<script>
			var Article = function Article(setting){
				var version = '<?php echo $data['version']; ?>';
				var default_setting = {
					start: 1,
					content: 1
				};
				
				setting = $.extend({}, default_setting, setting);
				
				var controller = {};
				
				controller.create_pager = function create_pager(setting){
					var self = this;
					
					$.ajax({
						type: 'GET',
						url: '/article/create-pager/' + setting.content,
						success: function(data){
							if(data){
								
								var str = '';
								
								str += '<ul>';
								
								for(var i=1, len=data; i<=data; i++){
									str += '<li><a data-id="'+i+'" href="#">'+i+'</a></li>';
								}
								
								str += '</ul>';
							}
							
							$('.pagination').append(str);
						},
						complete: function(){
							self.pager_onChange(setting.content);
						}
					});
				}
				
				controller.make_pagination = function make_pagination(id, page){
					var self = this;
					var str = '';
					$.ajax({
						type: 'GET',
						url: '/article/master/make-pagination/' + id + '/' + page,
						beforeSend: function(){
							$('#article-list').html('');
						},
						success: function(data){
								
							str += '<ul class="nav nav-pills nav-stacked">';
								
							for(var i=0, len=data.length; i<len; i++){
									
								str += '<li><a data-id="'+ data[i].article_id +'">'+ data[i].title +'</a></li>';
							}
								
							str += '</ul>';
								
							$('#article-list').append(str);
						},
						complete: function(){
							self.pagination_onChange();
						}
					});
				}
				
				controller.pager_onChange = function pager_onChange(page){
					var self = this;
					self.make_pagination(1, page);
					
					$('.pagination ul').children('li:eq(0)').addClass('active');
					
					$('.pagination ul').children('li').bind('click', function(e){
						$('.pagination ul').children('li.active').removeClass('active');
						
						$(this).addClass('active');
						var id = $(e.target).data('id');
						
						self.make_pagination(id, page);
					});
				}
				
				controller.fetchArticle = function fetchArticle(id){
					$.ajax({
						type: 'GET',
						url: '/article/fetch-one-article/'+id,
						beforeSend: function(){
							Loader({
								panel: '#article-container',
								display: true
							});
						},
						success: function(data){
							if(data){
								Loader({
									panel: '#article-container',
									display: false
								});
									
								var ejs = new EJS({url :  '/global/template/edit_article.ejs?v='+ version}).render(data);
								$('#article-container').append(ejs);
								showEditor();
							}
						}
					});
				}
				
				controller.pagination_onChange = function pagination_onChange(){
					
					var self = this;
					var $first_element = $('#article-list ul').children('li:eq(0)');
					
					$first_element.addClass('active');
					self.fetchArticle($first_element.children('a').data('id'));
					
					$('#article-list ul').children('li').bind('click', function(e){
						$('#article-list ul').children('li.active').removeClass('active');
						
						$(this).addClass('active');
						var id = $(e.target).data('id');
						
						self.fetchArticle(id);
					});
				}
				
				if(setting.content){
					controller.create_pager(setting);
				}
				
				return controller;
			}
		</script>
		<script type="text/javascript">
			function showEditor(){
				$('#txtcontent').tinymce({
					script_url : '<?php echo $data['baseurl']; ?>global/plugin/tiny_mce/tiny_mce_gzip.php',

					theme : "advanced",
					plugins : "advimage,advlink,emotions,inlinepopups,preview,media,print,contextmenu,paste,fullscreen,noneditable,nonbreaking",
					dialog_type : "modal",
					content_css : "<?php echo $data['baseurl']; ?>global/css/editor.css",
					// Theme options
					theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
					theme_advanced_buttons2 : "image,media,emotions,|,bullist,numlist,|,blockquote,|,undo,redo,|,anchor,cleanup,code,|,forecolor,backcolor,|,hr,removeformat,|,charmap,|,print,|,fullscreen,|,preview",
					theme_advanced_buttons3 : '',
					theme_advanced_toolbar_location : "top",
					theme_advanced_toolbar_align : "left",
					theme_advanced_statusbar_location : "bottom",
					theme_advanced_resizing : true
				});
			}
			
			$(function(){
				//create pagination
				
				Article({
					start: 1,
					content: 10
				});
			});
		</script>
	</body>
</html>