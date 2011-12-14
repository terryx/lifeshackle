<div class="content">
	<div class="row">
		<div id="main-content" class="span11">
			<div id="status-update">
				<div class="pagination">

				</div>
				<div id="status-update-container">

				</div>
			</div>
		</div>
		<div id="side-content" class="span5">
			<div style="float:right">
				<!-- Facebook Badge START --><a href="https://www.facebook.com/terryxlife" target="_TOP" style="font-family: &quot;lucida grande&quot;,tahoma,verdana,arial,sans-serif; font-size: 11px; font-variant: normal; font-style: normal; font-weight: normal; color: #3B5998; text-decoration: none;" title="Terry Yuen">Terry Yuen</a><br/><a href="https://www.facebook.com/terryxlife" target="_TOP" title="Terry Yuen"><img src="https://badge.facebook.com/badge/620130201.5435.1987480309.png" style="border: 0px;" /></a><!-- Facebook Badge END -->
			</div>
		</div>
	</div>
</div>

<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/footer.php"; ?>

<!--Status Update-->
<script>
	$(window).bind('hashchange', function(){
		getPagination();
	});
	
	function timeHistory(string){
		var now			= new Date().getTime(),
		record		= parseInt((string), 10) * 1000,
		diffTime	= now - record,
		timeMsg     = '';
   
		var daysDifference  = Math.floor(diffTime / 1000 / 60 / 60 / 24);
    
		if (daysDifference > 7) {
			var months = [
				"January", "February", "March", "April",
				"May", "June", "July", "August",
				"September", "October", "November", "December"
			];
        
			timeMsg = months[record.getMonth()] + ' ' + record.getDate() + ', ' + record.getFullYear();
		} else if (daysDifference) {
			timeMsg =  'about ' + daysDifference + ' days ago';
		} else {
			var hoursDifference = Math.floor(diffTime / 1000 / 60 / 60);

			if (hoursDifference) {
				timeMsg = 'about ' + hoursDifference + ' hours ago';
			} else {
				var minutesDifference = Math.floor(diffTime / 1000 / 60);

				if (minutesDifference) {
					timeMsg = 'about ' + minutesDifference + ' minutes ago';
				} else {
					var secondsDifference = Math.floor(diffTime / 1000);
                
					if (secondsDifference) {
						timeMsg = 'about ' + secondsDifference + ' seconds ago';
					} else {
						timeMsg = 'few seconds ago';
					}
				}
			}
		}
    
		return timeMsg;
	}
	
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
			url: '<?php echo $data['baseurl']; ?>status-update/get-pagination/'+page,
			dataType: 'json',
			success: function(data){
				if(data){
					$('#status-update-container').html('');
					for(var i=0, len=data.length; i<len; i++){
						str += '<div class="st-block">';
						str += '<div class="st-content">';
						str += data[i].k1;
						str += '</div>';
						str += '<div class="st-time">'+ timeHistory(data[i].k2) +'</div>';
						str += '</div>';
					}
				}
			},
			error: function(){
				window.location = '<?php echo $data['baseurl']; ?>error';
			},
			complete: function(){
				delete page;
				$(str).appendTo('#status-update-container').slideDown(1000, function(){
					$(this).find('.st-block').show();
				});
			}
		});
	}
	
	$(function(){
		//build pagination block
		$.ajax({
			type: 'GET',
			url: '<?php echo $data['baseurl']; ?>status-update/total-page',
			dataType: 'json',
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
				getPagination();
			}
		});
		
	});
</script>

<!-- Mini profile -->