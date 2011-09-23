<?php $this->renderc('template/head-start'); ?>
<title>Lifeshackle | Sign in</title>
<link rel="stylesheet" href="global/css/blk-form.css" type="text/css" media="screen" />
<?php $this->renderc('template/head-end'); ?>
<?php $this->renderc($data['nav']); ?>

<div id="container" class="clearall">
  <?php $this->renderc($data['menu']); ?>
  <div id="main-content">
    <div class="content">
      <h3>Shackles of Life</h3>
      <form id="login-form" class="blk-form" action="<?php echo Doo::conf()->APP_URL; ?>login">
        <div class="center">
          <label for="username" class="flat">Username</label>
          <input type="text" id="username" name="username" class="validate[required]" />
          <br>

          <label for="password" class="flat">Password</label>
          <input type="password" id="password" name="password" class="validate[required]" />

          <div class="clear"></div>
          <div class="button-wrap">
            <input type="submit" id="submit" value="Login" class="pre" />
            <input type="checkbox" name="remember" />Remember me
          </div>
        </div>
      </form>

      <p><a href="#">Forgot your password ?</a></p>

      <p><a href="#">Forgot your username ?</a></p>
      <br /><br />
    </div>
  </div><!-- end container-->

  <div id="side-content">

  </div>
</div><!-- end container -->
<?php $this->renderc('template/footer'); ?>
<script type="text/javascript">
  function beforeCall(){
    Common.bindLoading('#submit');
    return true;
  }

  function ajaxCallback(status, form, json){
    if(status === true && json.is_logged_in === true) {
      window.location = json.role;
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

</script>
</body>
</html>
