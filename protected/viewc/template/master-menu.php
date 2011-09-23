<div id="menubar" class="clearall">
  <div class="menu">
    <div class="indicator">Manage</div>
    <a href="<?php echo Doo::conf()->APP_URL; ?>manage-article">Article</a>
    <a href="<?php echo Doo::conf()->APP_URL; ?>manage-expense">Expense</a>
    <a href="<?php echo Doo::conf()->APP_URL; ?>manage-finance">Finance</a>
    <a href="<?php echo Doo::conf()->APP_URL; ?>manage-picture">Picture</a>
    <a href="<?php echo Doo::conf()->APP_URL; ?>manage-video">Video</a>
    <a href="<?php echo Doo::conf()->APP_URL; ?>manage-user">User</a>
  </div>
    <?php if($_SERVER['REQUEST_URI'] === '/lifeshackle/about'): ?>
  <div class="menu" style="margin-left:130px">
     <div class="indicator">Manage</div>
    <a href="<?php echo Doo::conf()->APP_URL; ?>manage-user">Edit</a>
  </div>
  <?php endif; ?>
</div>