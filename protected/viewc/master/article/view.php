<section id="navigation">
	<div class="topbar" data-dropdown="dropdown">
		<div class="topbar-inner">
			<div class="container">
				<a class="brand" href="<?php echo $data['baseurl']; ?><?php echo $data['role']; ?>">Life's Shackle</a>
				<ul class="nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle">Article</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $data['baseurl']; ?>article/view">View</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo $data['baseurl']; ?>article/edit">Edit</a></li>
						</ul>
					</li>
					<li><a href="<?php echo $data['baseurl']; ?><?php echo $data['role']; ?>/profile">Profile</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle">Video</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $data['baseurl']; ?>video/view">View</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo $data['baseurl']; ?>video/edit">Edit</a></li>
						</ul>
					</li>
				</ul>
				<ul class="secondary-nav">
					<li><a href="<?php echo $data['baseurl']; ?>logout">Sign out</a></li>
				</ul>
			</div>
		</div>
    </div>
</section>
<section id="main-container" class="row">
	<div id="main-content" class="span11">			
	</div>

	<div class="span5">
		<div id="pagination"></div>
		<hr />
		<div id="archive"></div>
	</div>
</section>

<div class="pagination"></div>
<div id="footer"></div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/twitter-bootstrap/bootstrap-all.js"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/common.js?<?php echo $data['version']; ?>"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/min/jquery.paginate.js?<?php echo $data['version']; ?>"></script>
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
			$(str).appendTo('#main-content');

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

	function getPagination(page){
		$.get('<?php echo $data['baseurl']; ?>article/get-pagination/'+page, function(data){
			if(data){
				Common.clearDiv('#main-content');
				var str = '';
				for(var i=0;i<data.length;i++){
					str += '<div class="span10 i-content">';
					str += '<h2>'+data[i].k1+'</h2>';
					str += '<strong>'+data[i].k2+'</strong><br />';
					str += data[i].k3;
					str += '</div>';
				}
				$(str).appendTo('#main-content');

			}
		});
	}
	function countPage(){
		$.get('<?php echo $data['baseurl']; ?>article/count-page', function(data){
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
		countPage();
		getPagination(1);

		archive();

	});
</script>