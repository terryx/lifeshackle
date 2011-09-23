<?php $this->renderc('template/head-start'); ?>
<link rel="stylesheet" href="<?php echo Doo::conf()->remote_url; ?>global/css/blk-form.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo Doo::conf()->remote_url; ?>global/css/editor.css" type="text/css" media="screen" />
<?php $this->renderc('template/head-end'); ?>
<?php $this->renderc('template/a-nav'); ?>
<div id="container">
  <?php $this->renderc('template/master-menu'); ?>
  <div id="main-content">
    <div class="content">
      <form id="manage-article-form" class="blk-form" action="<?php echo Doo::conf()->local_url; ?>article/save_article" method="post">
        <input type="hidden" id="article_id" name="article_id" />
        <label for="title" class="flat">Title</label>
        <input type="text" id="title" name="title" class="extend validate[required]" />
        <label for="txtcontent">Content</label>
        <textarea id="txtcontent" name="txtcontent" rows="13" cols="75"></textarea>
        <label for="tag" class="flat">Tags</label>
        <input type="text" id="tag" name="tag" class="extend" /><br />
        <input type="submit" id="submit" name="submit" value="Post" class="pre" />
        <span id="deleteButton"></span>
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
  <script type="text/javascript" src="<?php echo Doo::conf()->remote_url; ?>global/plugin/tiny_mce/jquery.tinymce.js"></script>
  <script type="text/javascript">
    $('#txtcontent').tinymce({
      script_url : '<?php echo Doo::conf()->local_url; ?>global/plugin/tiny_mce/tiny_mce_gzip.php',

      theme : "advanced",
      plugins : "advimage,advlink,emotions,inlinepopups,preview,media,print,contextmenu,paste,fullscreen,noneditable,nonbreaking",
      dialog_type : "modal",
      content_css : "<?php echo Doo::conf()->remote_url; ?>global/css/editor.css",
      // Theme options
      theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
      theme_advanced_buttons2 : "image,media,emotions,|,bullist,numlist,|,blockquote,|,undo,redo,|,anchor,cleanup,code,|,forecolor,backcolor,|,hr,removeformat,|,charmap,|,print,|,fullscreen,|,preview",
      theme_advanced_buttons3 : '',
      theme_advanced_toolbar_location : "top",
      theme_advanced_toolbar_align : "left",
      theme_advanced_statusbar_location : "bottom",
      theme_advanced_resizing : true


      // Drop lists for link/image/media/template dialogs
      //        template_external_list_url : "<?php echo Doo::conf()->APP_URL; ?>js/template_list.js",
      //        external_link_list_url : "<?php echo Doo::conf()->APP_URL; ?>js/link_list.js",
      //        external_image_list_url : "<?php echo Doo::conf()->APP_URL; ?>global/image_list.js",
      //        media_external_list_url : "<?php echo Doo::conf()->APP_URL; ?>js/media_list.js"

    });
  </script>

  <script type="text/javascript">
    function deleteArticle(id){
      $.delete_('<?php echo Doo::conf()->local_url; ?>article/delete_article/'+id, function(data){
        if(data){
          $('#newForm').click();
          Search.onload('<?php echo Doo::conf()->local_url; ?>article/get_article_list', '#manage-article-form');

        }
        else {
          ajaxFail('Article could not be deleted');
        }
      });
    }

    function beforeCall(){
      Common.wait();
      Common.bindLoading('#submit');
      return true;
    }

    function ajaxFail(msg){
      Common.removeDiv('#dialog-confirm');
      $('body').append('<div id="dialog-confirm">'+$.parseJSON(msg)+'</div>');
      $('#dialog-confirm').dialog({
        width: 350,
        height: 160,
        title: 'Oops..Something has go wrong',
        modal: true,
        buttons: {
          "Ok": function() {
            $(this).dialog('close');
            $(this).remove();
          }
        }
      });
       Common.unbindLoading("#submit", "Post");
    }

    function ajaxSuccess(success, text){
    Common.removeDiv('#dialog-confirm');
      $('<div id="dialog-confirm">'+text+'</div>').appendTo('body');
      $('#dialog-confirm').dialog({
        width: 350,
        height: 160,
        title: success,
        modal: true,
        buttons: {
          "Ok": function() {
            $(this).dialog('close');
            $(this).remove();
          }
        }
      });
      Common.unbindLoading("#submit", "Post");
    }

    function ajaxValidationCallback(status, form, json){

      $('#progress').hide();
      if(status === true){
        ajaxSuccess(json[0], json[1]);
      }
      else {ajaxFail('System database error. Please try again later', 'Error');
      }
      Search.onload('article/get_article_list', '#manage-article-form');
    }

    function refreshForm(id){
      $('#progress').show();
      $.get('<?php echo Doo::conf()->local_url; ?>article/get_one_article/'+id, function(data){
        if(data){
          $('#article_id').val(data.article_id);
          $('#title').val(data.title);
          $('#txtcontent').val(data.body);
          $('.cleditorMain >iframe').contents().find('body').html(data.body);
          $('#tag').val(data.tag);

          var str = '<input class="glassbutton" type="button" onclick="deleteArticle('+ data.article_id +');" value="Delete" />';
          Common.clearDiv('#deleteButton');
          $('#deleteButton').append(str);
        } else {
          ajaxFail('An error occured. Please contact administrator');
          window.location.reload();
        }
        $('#progress').hide();
      });
    }

    $(function(){

      //create a new button for form reset
      MenuSetting.resetButton({
        form         : '#manage-article-form',
        iframe       : '.cleditorMain >iframe',
        hiddenId     : '#article_id'
      });

      //form validation
      $('#manage-article-form').validationEngine({
        ajaxFormValidation: true,
        onAjaxFormComplete: ajaxValidationCallback,
        onBeforeAjaxFormValidation: beforeCall
      });


      //Render search list at side content
      Search.onload('<?php echo Doo::conf()->local_url; ?>article/get_article_list', '#manage-article-form');

    }); //end document ready


  </script>
</body>
</html>
