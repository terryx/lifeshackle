<?php $this->renderc('template/head-start'); ?>
<link rel="stylesheet" href="global/css/blk-form.css" type="text/css" media="screen" />
<?php $this->renderc('template/head-end'); ?>
<?php $this->renderc('template/a-nav'); ?>

<div id="container">
  <div id="main-content">
    <div id="progress"></div>
    <?php $this->renderc('template/master-menu'); ?>
    <div class="content">
      <h1>User Management Form</h1>
      <form id="manage-user-form" class="blk-form" action="super_admin/save_user">
        <input type="hidden" id="user_id" name="user_id" />
        <label for="user_type">User Type</label>
        <select id="user_type" name="user_type" class="validate[required]">
          <option value="">Please select</option>
          <option value="super_admin">Master</option>
          <option value="admin">Administrator</option>
          <option value="normal">Member</option>
        </select>
        <br />

        <div class="d-field">
          <label for="username">Username <span class="ispan">as login user</span></label>
          <input type="text" id="username" name="username" class="validate[required,custom[onlyLetterNumber],maxSize[20]]" autocomplete="off" />
        </div>

        <div class="dual_left"><label for="firstname">First name</label></div>
        <div class="dual_left"><label for="lastname">Last name</label></div>

        <div class="dual_left">
          <input type="text" id="firstname" name="firstname" class="validate[required]" />
        </div>
        <div class="dual_left">
          <input type="text" id="lastname" name="lastname" class="validate[required]" /></div>
        <div class="clear"></div>

        <div class="d-field">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" class="validate[required,minSize[6],maxSize[15]]" />
        </div>

        <div class="d-field">
          <label for="password_confirm">Re-enter Password <span class="ispan"> to confirm password</span></label>
          <input type="password" id="password_confirm" name="password_confirm" class="validate[required,minSize[6],maxSize[15],equals[password]]" />
        </div>

        <label for="email">E-mail</label>
        <input type="text" id="email" name="email" class="validate[required,custom[email]]" />
        <br />
        <div class="right">
          <input type="submit" value="Submit" />
          <input type="button" value="Print" name="print" />
          <input type="button" value="Delete" />
        </div>
      </form>

    </div>

  </div>

  <div id="side-content">
    <div id="search-container">
      <form id="search-form">
        <input type="text" id="search" name="search" placeholder="Search" onkeyup="Search.filter();" />
        <button type="submit" id="search-button" name="search-button"></button>
      </form>
      <div id="new" onclick="selectNew();">Add user</div>
    </div>
    <div id="search_result"> </div>
  </div>
  <?php $this->renderc('template/footer'); ?>
  <script type="text/javascript">
    $(function(){
      $("#manage-user-form").validationEngine({
        ajaxFormValidation: true,
        onAjaxFormComplete: ajaxValidationCallback,
        onBeforeAjaxFormValidation: beforeCall
      });
      //			refreshUserList();
      Search.onload('super_admin/get_user_list', '#manage-user-form');

      $('#loader').remove();

    }); //end document ready

    function refreshForm(id){

      $.get('super_admin/get_one_user/'+id, function(data){
        if(data){

          if($('.d-field') !== ''){
            $('.d-field:eq(0)').html('');
            $('.d-field:eq(1)').html('');
            $('.d-field:eq(2)').html('');
          }
          var username_field = '<label class="flat">Username :</label><span class="d-name">'+ data[1] +'</span>';

          $(username_field).appendTo('.d-field:eq(0)');
          $('#user_id').val(data[0]);
          $('#firstname').val(data[2]);
          $('#lastname').val(data[3]);
          $('#email').val(data[4]);
          $('#user_type').val(data[6]);
        } else {
         ajaxFail('An error occured. Please contact administrator');
            window.location.reload();
        }
       
      });
    }

    function beforeCall(){
      $('#progress').show();
      return true;
    }

    function ajaxValidationCallback(status, form, json){
      $('#progress').hide();
      $(form)[0].reset();

      if(status === true){ajaxSuccess(json[0], json[1]);}
      else {ajaxFail('System database error. Please try again later', 'Error');
      }

      Search.onload('super_admin/get_user_list', '#manage-user-form');
    }
    function getErrorStatus(){
      jAlert('Username already exist in database', 'Error');
      $('#progress').hide();
    }

    function selectNew(){
      $('#manage-user-form')[0].reset();
      $('#user_id').removeAttr('value');

      //clear username field
      if($('#username') !== null){
        $('.d-field:eq(0)').html('');

        var username_field = '<label for="username">Username <span class="ispan">as login user</span></label>';
        username_field += '<input type="text" id="username" name="username" class="validate[required,custom[onlyLetterNumber],maxSize[20]]" value="" autocomplete="off" />';
        $(username_field).appendTo('.d-field:eq(0)');

        var password_field  ='<label for="password">Password</label>';
        password_field +='<input type="password" id="password" name="password" class="validate[required,minSize[6],maxSize[15]]" />';
        $(password_field).appendTo('.d-field:eq(1)');

        var password_confirm_field  ='<label for="password_confirm">Re-enter Password <span class="ispan"> to confirm password</span></label>';
        password_confirm_field +='<input type="password" id="password_confirm" name="password_confirm" class="validate[required,minSize[6],maxSize[15],equals[password]]" />';
        $(password_confirm_field).appendTo('.d-field:eq(1)');
      }
    }
  </script>
</body>
</html>