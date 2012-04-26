<!DOCTYPE html>
<html>
	<head>
		<?php include "{$data['header']}.php"; ?>
	</head>
	<body>
		<?php include "{$data['nav']}.php"; ?>
		<div class="container">
			<div class="row">
				<div class="span9">
					<div id="video-pager"></div>
					<div id="video-panel"></div>
				</div>
			</div><!--/row -->
			<hr />

			<?php include "{$data['footer']}.php"; ?>
		</div><!-- end container-fluid -->
		<script>
			$(function(){
				//count total
				$.ajax({
					type: 'GET',
					url: '/video/count-total',
					beforeSend: function(){
						Loader({panel: '#video-panel', display: true});
					},
					success: function(data){
						if(data){
							pagination(data);
						}
					}
				});
				
			});
			
			function pagination(total){
				var self = this;
				
				var str = '';
				str += '<div class="pagination">';
				str += '<ul>';
				str += '<li data-id="prev-video"><a href="#">Prev</a></li>'; 
				for(var i=1; i<=total; i++){
					if(i===1){
						str += '<li class="active"><a href="#">'+ i +'</a></li>';
					} else{
						str += '<li><a href="#">'+ i +'</a></li>';
					}
				}
				str += '<li data-id="next-video"><a href="#">Next</a></li>';
				str += '</ul>';
				str += '</div>';
		
				$('#video-pager').append(str);
		
				get(1);
				onChange();
			}
			
			function get(page){
				var str = '', $panel = $('#video-panel');
				
				$.ajax({
					type: 'GET',
					url: '/video/get-pagination/' + page,
					beforeSend: function(){
						Loader({panel: '#video-panel', display: true});
					},
					success: function(data){
						if(data){
							str += '<ul class="thumbnails">';
							for(var i=0, len=data.length; i<len; i++){
								str += '<li class="span2">';	
								str += '<a href="'+ data[i].k2 +'/" class="thumbnail" target="_blank">';
								str += '<img src="'+ data[i].k3+'" alt="">'
								str += '</a>';
								str += '</li>';
							}
							str += '</ul>';
					
							Loader({panel: '#video-panel', display: false});
							$panel.append(str);
						}
					}
				});
			}
			
			function onChange(){
				var page, $active, activeId, self = this;
		
				$('.pagination ul').children('li').bind('click', function(e){
					page = $(e.target).html();
			
					$active = $('.pagination ul').children('li.active');
					activeId = $('.pagination ul').children('li.active').children('a').html();
					activeId = parseInt(activeId);
			
					switch(page){
						case 'Prev':
							page = prev(activeId);
							break;
						case 'Next':
							page = next(activeId);
							break;
						default:
							$active.removeClass('active');
							$(this).addClass('active');
					}
			
					get(page);
			
					function prev(activeId){
						var page = activeId - 1;
						if(page !== 0){
							$active.removeClass('active');
							$active.prev().addClass('active');
						} else {
							page = 1;
						}
						return page;
					}
			
					function next(activeId){
						var page = activeId + 1;
						var totalpage = $('.pagination ul').children('li').length - 2;
						if(page <= totalpage){
							$active.next().addClass('active');
							$active.removeClass('active');
						} else {
							page = totalpage;
						}
						return page;
					}
				});
			}
		</script>
		<script type="text/javascript">
			var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
			document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
		</script>
		<script type="text/javascript">
			try{
				var pageTracker = _gat._getTracker("UA-27701779-1");
				pageTracker._trackPageview();
			} catch(err) {}
		</script>
	</body>
</html>