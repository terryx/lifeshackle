<div class="content">
	<div class="row">
		<div id="main-content" class="span11">
			<div id="status-update">
				<form id="status-update-form" class="form-stacked" method ="POST" action ="<?php echo $data['baseurl']; ?>status-update/save">
					<div class ="clearfix">
						<div class="input">
							<textarea id="status-update-text" name="status_update_text" cols="70" rows="3" class="span10" placeholder="What's in your mind ?"></textarea >
						</div>
					</div >
					<button type="submit" class ="btn primary d-hide">Post</button>
				</form>
				<div class="pagination">
				</div>
				<div id="status-update-container">

				</div>
			</div>
			<div id="article">

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
					$('#status-update-container').append(str).hide().slideDown(1500);
				}
			},
			error: function(){
				window.location = '<?php echo $data['baseurl']; ?>error';
			},
			complete: function(){
				delete page;
				
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
		
		$('#status-update-form').bind('submit', function(e){
			e.preventDefault();
			var form = $(this);
			
			var st = $.ajax({
				type: 'POST',
				url: form.attr('action'),
				data: form.serialize(),
				dataType: 'json',
				beforeSend: function(){
					if($('#status-update-text').val() == ''){
						return false;
					}
				},
				success: function(data){
					if(data){
						if(data[0] === 'created'){
							getPagination();
						}
					}
				},
				error: function(){
					window.location = '<?php echo $data['baseurl']; ?>error';
				},
				complete: function(){
					form[0].reset();
				}
			});
		});
		
	});
</script>