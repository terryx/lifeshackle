<?php $this->renderc('template/head-start'); ?>
<title>Life Shackle | Manage pictures</title>
<link rel="stylesheet" href="global/css/gre-form.css" type="text/css" media="screen" />
<?php $this->renderc('template/head-end'); ?>
<?php $this->renderc('template/a-nav'); ?>
<div id="container">
  <?php $this->renderc('template/master-menu'); ?>
  <div id="main-content">
    <div id="progress"></div>

    <div id="img-content">

    </div>
    <div id="upload-picture" class="content">
      <form id="manage-picture-form" class="gre-form" action="picture/save_picture" method="post" enctype="multipart/form-data">
        <input type="hidden" id="picture_id" name="picture_id" value="" />
        <label for="picture" class="flat">Upload picture</label>
        <input type="file" name="picture" id="picture" /><br />
        <input type="submit" value="submit" style="margin-left: 130px" />
      </form>
    </div>
  </div>

  <div id="side-content">

    <div id="search_result"> </div>
  </div>

  <?php $this->renderc('template/footer'); ?>
  <script type="text/javascript" src="global/js/lazyload.js"></script>
  <script type="text/javascript">
    function showUploadForm(){
      $('#img-content').hide();
      $('#upload-picture').show();
    }

    function deletePicture(id){
      $.delete_('picture/delete_picture/'+id, function(data){
        if(data){
          window.location.reload();
        }
        else {
          ajaxFail('Picture could not be deleted');
        }
      });
    }

    function getPicture(id){
      $('#img-content').show();
      $.get('picture/get_one_picture/'+id, function(data){
        if(data){
          $('#img-content').html('');
          //          $('#picture_id').val(data[0]);
          //          $('#picture_name').val(data[1]);
          //          $('#created').val(data[3]);
          var str = '<img src="global/resized_pic/'+data[3]+'_shac.jpg" alt="'+data[1]+'" />';
          str += '<div id="delete" onclick="deletePicture('+data[0]+')"></div>';

          $(str).appendTo('#img-content');
          $('#upload-picture').hide();
        } else {
          ajaxFail('An error occured. Please contact administrator');
          window.location.reload();
        }

      });
    }

    function setThumbnails(){
      $.get('picture/get_picture_list', function(data){
        if(data){
          var str = '<div class="img-thumbnails">';
          for(var i=0;i<data.length;i++){
            //            str += '<li>';
            str += '<img id="'+data[i].k0+'" src="global/resized_pic/'+data[i].k1+'_shac.jpg" alt="" />';
            //             str += '</li>';
          }
          str +='</div>';
          $(str).appendTo('#search_result');
        }
        // setup LazyLoad
        $(".img-thumbnails > img").lazyload({
          placeholder : "global/img/loader.gif",
          container: $("#search_result")
        });

        //trigger thumbnail click event
        $('.img-thumbnails > img').click(function(){
          $('#manage-picture-form')[0].reset();

          var id = ($(this)).attr('id');

          getPicture(id);
        });
      });
    }

    $(function(){

      var str = '<div class="menu" style="margin-left:105px"><div id="newForm">New</div></div>';
      $(str).appendTo('#menubar');

      $('#newForm').click(function(){
        showUploadForm();
      });

      setThumbnails();


    }); //end document ready


  </script>
</body>
</html>
