<div class="content">
	<div class="row">
		<div id="main-content" class="span16">
			<div class="pagination">

			</div>
			<div id="video">

			</div>
		</div>
	</div>
</div>

<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/footer.php"; ?>

<!--Video-->
<script>
	$(window).bind('hashchange', function(){
		getPagination();
	});
	
	function checkHashKey(){
		var hashkey = window.location.hash;
		if(hashkey !== ''){
			hashkey = window.location.hash.replace('#', '');
		} else {
			hashkey = 1;
		}
		return parseInt(hashkey, 10);
	}
	
	function getPagination(){
		var page = checkHashKey();
		var last = $('.pagination ul li:last-child').children('a').attr('href');
		var str = '';
		
		//Clear all active pages
		if($('.pagination ul li').is('.active')){
			$('.pagination ul li').removeClass('active');
		}
		
		//First page
		if(page === 1){
			$('.pagination ul li:nth-child(2)').addClass('active');
			
			$('.pagination ul li:first-child').addClass('disabled');
			$('.pagination ul li:last-child').removeClass('disabled');
		}
		
		//Last page
		if(last === '#'+page){
			$('.pagination ul li:nth-child('+(page + 1)+')').addClass('active');
			
			$('.pagination ul li:last-child').addClass('disabled');
			$('.pagination ul li:first-child').removeClass('disabled');
		}
		
		//Active pages
		if(page !== 1 && last !== '#'+page){
			$('.pagination ul li:nth-child('+ (page+1) +')').addClass('active');
			
			$('.pagination ul li:first-child').removeClass('disabled');
			$('.pagination ul li:last-child').removeClass('disabled');
		}
		
		$.ajax({
			type: 'GET',
			url: '<?php echo $data['baseurl']; ?>video/get-pagination/'+page,
			dataType: 'json',
			success: function(data){
				if(data){
					Common.clearDiv('#video');
					var id, title, src, thumbnail;
					str += '<ul class="media-grid">';
					for(var i=0, len=data.length; i<len; i++){
						id = data[i].k0;
						title = data[i].k1;
						src = data[i].k2
						thumbnail = data[i].k3;

						str += '<li><a href="'+ src +'" target="_blank" title="'+ title +'"><img id="video-'+ id +'" src="'+ thumbnail +'" class="video-box" alt="" /></a></li>';
					}
					str += '</ul>';
				}
			},
			error: function(){
				window.location = '<?php echo $data['baseurl']; ?>error';
			},
			complete: function(){
				delete page;
				$('#video').append(str).hide().slideDown(1000, function(){
					$(str).show();
				});
			}
		});
	}
	
	function videoLinkId(url){
		var id;
		id = url.replace(/^[^v]+v.(.{11}).*/,"$1");
		return id;
	}

	$(function(){
		//build pagination block
		$.ajax({
			type: 'GET',
			url: '<?php echo $data['baseurl']; ?>video/total-page',
			dataType: 'json',
			beforeSend: function(){
				Common.wait();
			},
			success: function(data){
				var str			= '';
				str += '<ul>';
				str += '<li class="prev"><a href="#1">First</a></li>';
					
				for(var i=1, len=data; i<=len; i++){
					str += '<li><a href="#'+i+'">'+i+'</a></li>';
				}
				str += '<li class="next"><a href="#'+data+'">Last</a></li>';
				str += '</ul>';
				$('.pagination').append(str);
			},
			error: function(){
				console.log('Error part: initialize');
			},
			complete: function(){
				Common.end();
				getPagination();
			}
		});
		
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