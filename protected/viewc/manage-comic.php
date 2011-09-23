<?php $this->renderc('template/head-start'); ?>
<link rel="stylesheet" href="global/css/blk-form.css" type="text/css" media="screen" />
<link rel="stylesheet" href="global/editor/jquery.cleditor.css" type="text/css" media="screen" />
<?php $this->renderc('template/head-end'); ?>
<?php $this->renderc('template/a-nav'); ?>
<div id="container">
  <div id="main-content">
    <div id="progress"></div>
    <?php $this->renderc('template/master-menu'); ?>
    <div class="content">
      <form id="manage-article-form" class="blk-form" action="article/save_article" method="post">
        <input type="hidden" id="article_id" name="article_id" value="" />
        <label for="title" class="flat">Title</label>
        <input type="text" id="title" name="title" class="extend validate[required]" />
        <label for="txtcontent">Content</label>
        <textarea id="txtcontent" name="txtcontent"></textarea>
        <label for="tag" class="flat">Tags</label>
        <input type="text" id="tag" name="tag" class="extend" /><br />
        <input type="submit" name="submit" value="Post" />
      </form>
    </div>
  </div>

  <div id="side-content">
    <div id="search-container">
      <form id="search-form">
        <input type="text" id="search" name="search" placeholder="Search" onkeyup="Search.filter();" />
        <button type="submit" id="search-button" name="search-button"></button>
      </form>
    </div>
    <div id="search_result"> </div>
  </div>

  <?php $this->renderc('template/footer'); ?>
  <script type="text/javascript" src="global/editor/jquery.cleditor.min.js"></script>
  <script type="text/javascript">
    function beforeCall(){
      $('#progress').show();
      return true;
    }
    function ajaxValidationCallback(status, form, json){

      $('#progress').hide();
      $(form)[0].reset();

      if(status === true){ajaxSuccess(json[0], json[1]); console.log($('#txtcontent').val());}
      else {ajaxFail('System database error. Please try again later', 'Error');
      }

      Search.onload('article/get_article_list', '#manage-article-form');
    }

    function refreshForm(id){
      $('#progress').show();
      $.get('article/get_one_article/'+id, function(data){
        if(data){
          $('#article_id').val(data[0]);
          $('#title').val(data[1]);
          $('.cleditorMain >iframe').contents().find('body').html(data[3]);

//          $('#tag').val(data[4]);

        } else {
          ajaxFail('An error occured. Please contact administrator');
          window.location.reload();
        }
        $('#progress').hide();
      });
    }

    $(function(){
      $('#manage-article-form').validationEngine({
        ajaxFormValidation: true,
        onAjaxFormComplete: ajaxValidationCallback,
        onBeforeAjaxFormValidation: beforeCall
      });

	  initEditor(); //initialize text editor

      Search.onload('article/get_article_list', '#manage-article-form');
      $('#loader').remove();

    }); //end document ready


  </script>
</body>
</html>
