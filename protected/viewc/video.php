<?php $this->renderc('template/head-start'); ?>
<title>Lifeshackle | Video</title>
<link rel="stylesheet" href="<?php echo Doo::conf()->remote_url; ?>global/css/video.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo Doo::conf()->APP_URL; ?>global/plugin/lightbox/css/prettyPhoto.css" type="text/css" media="screen" />

<?php $this->renderc('template/head-end'); ?>
<?php $this->renderc($data['nav']); ?>

<div id="container" class="clearall">
  <?php $this->renderc($data['menu']); ?>
  <div id="pagination"></div>
  <div id="main-content">
    <div class="content">
      <div id="video-frame" class="clearall"></div>
    </div>
  </div><!-- end container-->
</div>
<div id="side-content"></div>
</div><!-- end container -->
<?php $this->renderc('template/footer'); ?>
<script type="text/javascript" src="<?php echo Doo::conf()->remote_url; ?>global/plugin/lightbox/jquery.prettyPhoto.js"></script>
<!--<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>-->
<script type="text/javascript" src="<?php echo Doo::conf()->remote_url; ?>global/min/video.js?v2"></script>

</html>
