function setVideo(){
		$("a[rel^='vid']").prettyPhoto();
		$(".gallery a[rel^='vid']").prettyPhoto({animation_speed:'normal',theme:'facebook',slideshow:3000, autoplay_slideshow: false, modal: true });
		$(".gallery:gt(0) a[rel^='vid']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});

		$('.pp_social').append('<g:plusone href="http://www.youtube.com/watch?feature=player_embedded&v=C75jnx7KKQY"></g:plusone>');

	}

	function getPagination(page){
		$.get('<?php echo Doo::conf()->APP_URL; ?>video/get-pagination/'+page, function(data){
			if(data){
				Common.clearDiv('#video-frame');
				var str = '';
				for(var i = 0;i<data.length;i++){
					str = '<div class="video-box">';

					str += '<a href="'+data[i].k2+'" title="'+data[i].k1+'" rel="vid">';
					str += '<img src="'+data[i].k3+'" /></a>';
					str += '</div>';
					$('#video-frame').append(str);
				}
				setVideo();
			}
			else {
				return false;
			}
		});
	}
	function countPage(){
		$.get('<?php echo Doo::conf()->APP_URL; ?>video/count-page', function(data){
			if(data){
				paginate(data);
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
				getPagination(page);
			}
		});

	}
	$(function(){
		//set navigation indicator
		$('#nav a:eq(3)').addClass('active');
		countPage();
		getPagination(1);

	});//end document ready


