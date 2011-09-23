<?php $this->renderc('template/head-start'); ?>
<link rel="stylesheet" href="global/css/blk-form.css" type="text/css" media="screen" />
<?php $this->renderc('template/head-end'); ?>
<?php $this->renderc('template/a-nav'); ?>
<div id="container">
  <?php $this->renderc('template/master-menu'); ?>
  <div id="main-content">
    <div class="content">
      <p>Enter the cost of your daily expenses</p>
      <form id="manage-expense-form" class="blk-form" action="expense/save-expense" method="post">
        <label for="date" class="flat">Date</label>
        <input type="text" id="date" name="date" /><br />
        <label for="breakfast" class="flat">Breakfast</label>
        <input type="text" id="breakfast" name="breakfast" class="validate[optional,custom[number]]" /><br />
        <label for="lunch" class="flat">Lunch</label>
        <input type="text" id="lunch" name="lunch" class="validate[optional,custom[number]]" /><br />
        <label for="dinner" class="flat">Dinner</label>
        <input type="text" id="dinner" name="dinner" class="validate[optional,custom[number]]" /><br />
        <label for="supper" class="flat">Supper</label>
        <input type="text" id="supper" name="supper" class="validate[optional,custom[number]]" /><br />
        <label for="travel" class="flat">Travel</label>
        <input type="text" id="travel" name="travel" class="validate[optional,custom[number]]" /><br />
        <label for="leisure" class="flat">Leisure</label>
        <input type="text" id="leisure" name="leisure" class="validate[optional,custom[number]]" /><br />
        <label for="msic" class="flat">Misc</label>
        <input type="text" id="misc" name="misc" class="validate[optional,custom[number]]" /><br />
        <input type="submit" name="submit" value="Post" />
        <div class="dynamic-container">
          <label for="abc">abc</label>
          <div class="add-input" style="cursor:pointer;color:#F00">Click to add</div>
        </div>
        <span id="deleteButton"></span>
    </div>
  </div>

  <div id="side-content">
    <div class="content">
    Expense for /selected date/
    </div>
  </div>

  <?php $this->renderc('template/footer'); ?>
  <script type="text/javascript">

    //get mySQL date format - credit to Mike Boone
    function formatDate(date1) {
      return date1.getFullYear() + '-' +
        (date1.getMonth() < 9 ? '0' : '') + (date1.getMonth()+1) + '-' +
        (date1.getDate() < 10 ? '0' : '') + date1.getDate();
    }
    $(function(){

      //create a new button for form reset
      MenuSetting.resetButton({
        form         : '#manage-expense-form'
      });

      $("#date").datepicker({
        dateFormat  : 'yy-mm-dd'
      });

      var jsDate = new Date();
      var mysqlDate = formatDate(jsDate);
      $('#date').val(mysqlDate);

      $("#manage-expense-form").validationEngine({
        //        ajaxFormValidation: true,
        //        onAjaxFormComplete: ajaxValidationCallback,
        //        onBeforeAjaxFormValidation: beforeCall
      });




    }); //end document ready


  </script>
</body>
</html>