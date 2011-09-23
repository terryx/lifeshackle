<?php $this->renderc('template/head-start'); ?>
<title>Lifeshackle | Comic</title>
<link rel="stylesheet" href="global/css/blk-form.css" type="text/css" media="screen" />
<?php $this->renderc('template/head-end'); ?>
<?php $this->renderc($data['nav']); ?>

<div id="container" class="clearall">
  <div id="main-content">
    <div id="progress"></div>
 <?php $this->renderc($data['menu']); ?>
    <div class="content">
				Welcome to my website
    </div>
  </div><!-- end container-->


  <div id="side-content">

  </div>
</div><!-- end container -->
<?php $this->renderc('template/footer'); ?>
<script type="text/javascript">


  $(function(){
    setLoader();



    $('#loader').remove();
  });

</script>
</body>
</html>
