<div class="content">
	<div class="row">
		<div id="main-content" class="span11">
			<div id="article">

			</div>

		</div>
		<div id="side-content" class="span5">
			<div id="archive">
			</div>
			<div class="archive-expansion"></div>
		</div>
	</div>
</div>
<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/footer.php"; ?>
<script>
	function fetchArticle(){
		$.ajax({
			type: 'GET',
			url: '<?php echo $data['baseurl']; ?>article/fetch-article',
			beforeSend: function(){
				Common.wait();	
			},
			success: function(data){
				if(data){
					var str = '';
					for(var i=0, len=data.length; i<len; i++){
						str += '<h2>'+ data[i].k1 +'</h2>';
						str += '<div class="a-date">';
						
						if(data[i].k3 !== '0'){
							str += 'Last edited on ' + timeHistory(data[i].k3);
						} else {
							str += 'Created on ' + timeHistory(data[i].k2);
						}
						
						str += '</div>'
						str += data[i].k5;
						str += '<hr />';
					}
					Common.end();
					$('#article').append(str);
					
					archive();
				}
			}
		});
	}
	
	function archive(){
		$.ajax({
			type: 'GET',
			url: '<?php echo $data['baseurl']; ?>article/archive',
			dataType: 'json',
			success: function(data){
				if(data){
					var str = '<div id="archive-tb">';
					str += '<h3>Archive</h3>';
					str += '<ul>';
					for(var i=0, len=data.length; i<len; i++){
						str += '<li data-id="'+ data[i].k1 +'">'+ data[i].k1 +'</li>';
					}
					str += '</ul>';
					str += '</div>';
					
					$('#archive').append(str);
				}
			},
			complete: function(){
				$('#archive-tb ul li').bind('click', function(){
					var date = $(this).data('id');
					
					$.ajax({
						type: 'GET',
						url: '<?php echo $data['baseurl']; ?>article/archive-date-filter/'+date,
						dataType: 'json',
						beforeSend: function(){
							$('#article').html('')
							Common.wait();
						},
						success: function(data){
							if(data){
								var str = '';
								for(var i=0, len=data.length; i<len; i++){
									str += '<h2>'+ data[i].k1 +'</h2>';
									str += '<div class="a-date">';
						
									if(data[i].k3 === '0'){
										str += 'Created on ' + timeHistory(data[i].k2);
									} else {
										str += 'Last edited on ' + timeHistory(data[i].k3);
									}
						
									str += '</div>'
									str += data[i].k5;
									str += '<hr />';
								}
								Common.end();
								$('#article')
								.html('')
								.append(str);
							}
						}
					})
				});
			}
		});
	}
	
	$(function(){
		fetchArticle();
	});
</script>
<!-- Google Analytics -->
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