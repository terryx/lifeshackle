<?php $this->renderc('template/head-start'); ?>
<title>Life Shackle | Picture Gallery</title>
<link rel="stylesheet" href="<?php echo Doo::conf()->APP_URL; ?>global/min/galleriffic.css" type="text/css" media="screen" />
<?php $this->renderc('template/head-end'); ?>
<?php $this->renderc($data['nav']); ?>

<div id="container">
  <?php $this->renderc($data['menu']); ?>
  <div id="main-content">
    <div id="progress"></div>

    <div id="gallery" class="gallery-content">
      <div id="controls" class="controls"></div>
      <div class="slideshow-container">
        <div id="loading" class="loader"></div>
        <div id="slideshow" class="slideshow"></div>
      </div>
      <div id="caption" class="caption-container"></div>
    </div>
  </div><!-- end main-content -->
  <div id="side-content">
    <div id="thumbs" class="navigation">
      <ul class="thumbs"></ul>
    </div>
  </div>
  <div class="clear"></div>

</div><!-- end container -->
<?php $this->renderc('template/footer'); ?>
<script type="text/javascript" src="<?php echo Doo::conf()->APP_URL; ?>global/min/jquery.galleriffic.js"></script>
<script type="text/javascript" src="<?php echo Doo::conf()->APP_URL; ?>global/min/jquery.opacityrollover.js"></script>
<script type="text/javascript">
  function getPictureGallery(){
    $('div.navigation').css({'width' : '280px', 'float' : 'left'});
    $('.gallery-content').css('display', 'block');
    $.get('<?php echo Doo::conf()->APP_URL; ?>picture/get_picture_gallery', function(data){
      if(data){
        var str='';
        for(var i=0;i<data.length;i++){
          str += '<li><a class="thumb" href="<?php echo Doo::conf()->APP_URL; ?>global/resized_pic/'+data[i].k0+'_shac.jpg" title="">';
          str += '<img src="<?php echo Doo::conf()->APP_URL; ?>global/resized_pic/'+data[i].k0+'_shac.jpg" alt="" />';
          str +='</a></li>';
        }
        var pic = $('ul.thumbs').append(str);

        if(pic){
          initPictureGallery();
        }
      }
	  else {
		  return false;
	  }
    });
  }

  function initPictureGallery(){

    // Initially set opacity on thumbs and add
    // additional styling for hover effect on thumbs
    var onMouseOutOpacity = 0.67;
    $('#thumbs ul.thumbs li').opacityrollover({
      mouseOutOpacity:   onMouseOutOpacity,
      mouseOverOpacity:  1.0,
      fadeSpeed:         'fast',
      exemptionSelector: '.selected'
    });
    // Initialize Advanced Galleriffic Gallery
    $('#thumbs').galleriffic({
      delay:                     2500,
      numThumbs:                 15,
      preloadAhead:              10,
      enableTopPager:            true,
      enableBottomPager:         true,
      maxPagesToShow:            7,
      imageContainerSel:         '#slideshow',
      controlsContainerSel:      '#controls',
      captionContainerSel:       '#caption',
      loadingContainerSel:       '#loading',
      renderSSControls:          true,
      renderNavControls:         true,
      playLinkText:              'Play Slideshow',
      pauseLinkText:             'Pause Slideshow',
      prevLinkText:              '&lsaquo; Previous Photo',
      nextLinkText:              'Next Photo &rsaquo;',
      nextPageLinkText:          'Next &rsaquo;',
      prevPageLinkText:          '&lsaquo; Prev',
      enableHistory:             false,
      autoStart:                 false,
      syncTransitions:           true,
      defaultTransitionDuration: 900,
      onSlideChange:             function(prevIndex, nextIndex) {
        // 'this' refers to the gallery, which is an extension of $('#thumbs')
        this.find('ul.thumbs').children()
        .eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end()
        .eq(nextIndex).fadeTo('fast', 1.0);
      },
      onPageTransitionOut:       function(callback) {
        this.fadeTo('fast', 0.0, callback);
      },
      onPageTransitionIn:        function() {
        this.fadeTo('fast', 1.0);
      }
    });
  }

  $(function(){
    getPictureGallery();
  });

</script>
</body>
</html>
