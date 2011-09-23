<?php $this->renderc('template/head-start'); ?>
<link rel="stylesheet" href="global/css/blk-form.css" type="text/css" media="screen" />
<link rel="stylesheet" href="global/editor/jquery.cleditor.css" type="text/css" media="screen" />
<?php $this->renderc('template/head-end'); ?>
<?php $this->renderc('template/a-nav'); ?>
<div id="container">
  <?php $this->renderc('template/master-menu'); ?>
  <div id="main-content">
    <form id="manage-finance-form" class="blk-form" action="finance/save-finance" method="post">
    <label for="breakfast">Breakfast</label>
<input type="text" id="breakfast" name="breakfast" class="flat" />
  </div>

  <div id="side-content">
  </div>

  <?php $this->renderc('template/footer'); ?>
  <script type="text/javascript" src="global/editor/jquery.cleditor.min.js"></script>
  <script type="text/javascript">

    $(function(){



      //create a new button for form reset
      MenuSetting.resetButton({
        form         : '#manage-article-form',
        iframe       : '.cleditorMain >iframe',
        hiddenId     : '#article_id'
      });



    }); //end document ready


  </script>
</body>
</html>