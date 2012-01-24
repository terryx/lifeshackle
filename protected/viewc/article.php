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
	function fetchArticle(){$.ajax({type:"GET",url:"<?php echo $data['baseurl']; ?>article/fetch-article",success:function(c){if(c){var d="";for(var b=0,a=c.length;b<a;b++){d+="<h2>"+c[b].k1+"</h2>";d+='<div class="a-date">';if(c[b].k3!=="0"){d+="Last edited on "+timeHistory(c[b].k3)}else{d+="Created on "+timeHistory(c[b].k2)}d+="</div>";d+=c[b].k5;d+="<hr />"}$("#article").append(d);archive()}}})}function archive(){$.ajax({type:"GET",url:"<?php echo $data['baseurl']; ?>article/archive",dataType:"json",success:function(c){if(c){var d='<div id="archive-tb">';d+="<h3>Archive</h3>";d+="<ul>";for(var b=0,a=c.length;b<a;b++){d+='<li data-id="'+c[b].k1+'">'+c[b].k1+"</li>"}d+="</ul>";d+="</div>";$("#archive").append(d)}},complete:function(){$("#archive-tb ul li").bind("click",function(){var a=$(this).data("id");$.ajax({type:"GET",url:"<?php echo $data['baseurl']; ?>article/archive-date-filter/"+a,dataType:"json",beforeSend:function(){$("#article").html("");Common.wait()},success:function(d){if(d){var e="";for(var c=0,b=d.length;c<b;c++){e+="<h2>"+d[c].k1+"</h2>";e+='<div class="a-date">';if(d[c].k3==="0"){e+="Created on "+timeHistory(d[c].k2)}else{e+="Last edited on "+timeHistory(d[c].k3)}e+="</div>";e+=d[c].k5;e+="<hr />"}Common.end();$("#article").html("").append(e)}}})})}})};
</script>

<script>
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