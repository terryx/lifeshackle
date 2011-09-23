function loadIframe(){

  var url = $('#videolink').val();

  var id = videoLinkId(url);
  Common.clearDiv('#video-frame');

  var str = '<iframe width="560" height="349" src="http://www.youtube.com/embed/'+id+'" frameborder="0" allowfullscreen></iframe>';
  $('#video-frame').append(str);

  $('iframe').load(function(){
    $.get('https://gdata.youtube.com/feeds/api/videos/'+id+'?v=2&alt=json', function(data){
      if(data){
        if($.browser.mozilla){
          data = JSON.parse(data);
        }
        var title = data.entry.title.$t;
        var thumbnail = data.entry.media$group.media$thumbnail[0].url;
        $('#title').val(title);
        $('#thumbnail').val(thumbnail);
      }
    });
    var str = '<input type="submit" id="submit" name="submit" value="Post" class=pre />';
    $('#manage-video-form').append(str);
  });
}

function videoLinkId(url){
  var id;
  id = url.replace(/^[^v]+v.(.{11}).*/,"$1");
  return id;
}

function deleteVideo(id){
  $.delete_('video/delete_video/'+id, function(data){
    if(data){
      $('#newForm').click();
      $('#video-frame').html('');
      Search.onload('video/get_video_list', '#manage-video-form');
    }
    else {
      ajaxFail('Video could not be removed');
    }
  });
}

function beforeCall(){
  Common.wait();
  Common.bindLoading('#submit');
  return true;
}
function ajaxValidationCallback(status, form, json){
  Common.end();
  if(status === true){
    if(json[2] !== undefined){
      refreshForm(json[2]);
    } else {
      ajaxSuccess(json[0], json[1]);
    }

  }
  else {
    ajaxFail('System database error. Please try again later', 'Error');
  }
  Search.onload('video/get_video_list', '#manage-video-form');
}

function refreshForm(id){
  Common.wait();
  $.get('video/get_one_video/'+id, function(data){
    if(data){
      var id = videoLinkId(data.link);
      var iframe = '<iframe width="560" height="349" src="http://www.youtube.com/embed/'+id+'?wmode=transparent" frameborder="0" allowfullscreen></iframe>';

      Common.clearDiv('#video-frame');
      $('#video-frame').append(iframe);

      $('iframe').load(function(){
        Common.clearDiv('#manage-video-form');

        var str = '<input type="hidden" id="video_id" name="video_id" value="'+data.video_id+'"/>';
        str += '<label for="visible" class="flat">Visible to public ?</label>';
        str +=  is_visible(data.visible);
        str += '<br />';
        str += '<label for="title" class="flat">Title</label>';
        str += data.title;
        str += '<br />';
        str += '<input type="submit" id="submit" name="submit" value="Update" class="pre" />';
        str += '<span id="deleteButton"><input class="glassbutton" type="button" onclick="deleteVideo('+ data.video_id +');" value="Delete" /></span>';
        $('#manage-video-form').append(str);
        Common.end();
      });
    }

  });
}

function is_visible(data){
  var visible = '';
  if(data === "1"){
    visible  = '<input type="radio" name="visible" value="1" checked />Yes';
    visible += '<input type="radio" name="visible" value="0" /> No';
  }

  else{
    visible = '<input type="radio" name="visible" value="1" />Yes';
    visible += '<input type="radio" name="visible" value="0" checked /> No';
  }
  return visible;
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
  Common.unbindLoading("#submit", "Update");
}
$(function(){

  MenuSetting.resetButton({
    form         : '#manage-video-form'
  });

  //form validation
  $('#manage-video-form').validationEngine({
    ajaxFormValidation: true,
    onAjaxFormComplete: ajaxValidationCallback,
    onBeforeAjaxFormValidation: beforeCall
  });

  //Render search list at side content
  Search.onload('video/get_video_list', '#manage-video-form');

  $('#newForm').click(function(){
    Common.clearDiv('#manage-video-form');
    Common.clearDiv('#video-frame');
    var str = '<input type="hidden" id="video_id" name="video_id" />' +
    '<input type="hidden" id="title" name="title" />' +
    '<input type="hidden" id="thumbnail" name="thumbnail" />' +
    '<label for="videolink" class="flat">Video Link</label>' +
    '<input type="text" id="videolink" name="videolink" class="extend validate[required]" onchange="loadIframe();" /><br />';
    $('#manage-video-form').append(str);
  });

}); //end document ready