<?php $this->renderc('template/head-start'); ?>
<title>Lifeshackle | Articles</title>
<link rel="stylesheet" href="<?php echo Doo::conf()->APP_URL; ?>global/css/blk-form.css" type="text/css" media="screen" />
<?php $this->renderc('template/head-end'); ?>
<?php $this->renderc($data['nav']); ?>

<div id="container" class="clearall">
  <?php $this->renderc($data['menu']); ?>
  <div id="main-content">
<!--	<div class="content">
		<h1>Test 1</h1>
		abcfdfdfdfdfdfdfdfdfdfdfgwertfdbcbfghgfhfgd

	</div>-->
  </div><!-- end container-->


  <div id="side-content"></div>
</div><!-- end container -->
<?php $this->renderc('template/footer'); ?>
<script type="text/javascript">

function getArticle(){
  $.get('article/get_article', function(data){
    if(data){
      var str = '';
      for(var i=0;i<data.length;i++){
        str += '<div class="content">';
		str += '<h1>'+data[i].k0+'</h1>';
		str += 'Published on '+data[i].k1 + '<br />';
        str += 'by '+data[i].k4 + '<hr />';
		str += data[i].k2
		str += '</div>';
      }
	   $(str).appendTo('#main-content');
    }

  });
}
  $(function(){
//set navigation indicator
 $('#nav a:eq(1)').addClass('active');

  Common.wait();
getArticle();


  });

</script>
</body>
</html>
