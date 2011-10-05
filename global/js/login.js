  function beforeCall(){
    Common.bindLoading('#submit');
    return true;
  }

  function ajaxCallback(status, form, json){
    if(status === true && json.is_logged_in === true) {
      window.location = 'home';
    }
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
    Common.unbindLoading("#submit", "Login");
  }

  $(function(){
    jQuery("#login-form").validationEngine({
      ajaxFormValidation: true,
      onBeforeAjaxFormValidation: beforeCall,
      onAjaxFormComplete: ajaxCallback
    });

  });
