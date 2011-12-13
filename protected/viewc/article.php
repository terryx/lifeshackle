<div class="content">
	<div class="row">
		<div id="main-content" class="span11">
			<div class="pagination">

			</div>
			<div id="article">

			</div>
		</div>
		<div id="side-content" class="span5">
			<div id="archive">

			</div>
		</div>
	</div>
</div>
<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/footer.php"; ?>

<!--Article-->
<script type="text/javascript">
	function filterByArchive(date){
		$.get("<?php echo $data['baseurl']; ?>article/filter-by-archive/"+date, function(data){
			if(data){
				var str = '';
				Common.clearDiv("#main-content");
				for(var i=0;i<data.length;i++){
					str += '<div class="span10 i-content">';
					str += '<h2>'+data[i].k1+'</h2>';
					str += '<strong>'+data[i].k2+'</strong><br />';
					str += data[i].k3;
					str += '</div>';
				}
			}
			$(str).appendTo('#article');

		});
	}
  
	function archive(){
		$.get("<?php echo $data['baseurl']; ?>article/archive", function(data){
			if(data){
				var str = "<h3>Archive</h3>";
				str += "<ul class='span4'>";
				for(var i=0;i<data.length;i++){
					str += "<li><div class='num' onclick='filterByArchive(\""+data[i].k1+"\")'>"+data[i].k0+"</div><div class='date' onclick='filterByArchive(\""+data[i].k1+"\")'>"+data[i].k1+"</div></li>";
				}
				str += "</ul>";
				$("#archive").append(str);
			}
		});
	}
	
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
			url: '<?php echo $data['baseurl']; ?>article/get-pagination/'+page,
			dataType: 'json',
			success: function(data){
				if(data){
					Common.clearDiv('#article');
					for(var i=0;i<data.length;i++){
						str += '<div class="span10 i-content">';
						str += '<h2>'+data[i].k1+'</h2>';
						str += '<strong>'+data[i].k2+'</strong><br />';
						str += data[i].k3;
						str += '</div>';
					}
				}
			},
			error: function(){
				window.location = '<?php echo $data['baseurl']; ?>error';
			},
			complete: function(){
				delete page;
				$('#article').append(str).hide().slideDown(800, function(){
					$(str).show();
				});
			}
		});
	}

	$(function(){
		//build pagination block
		$.ajax({
			type: 'GET',
			url: '<?php echo $data['baseurl']; ?>article/total-page',
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

		archive();

	});
</script>