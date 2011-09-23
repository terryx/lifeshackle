<?php

class FinanceController extends CommonController {

  public function manageFinancePage() {
    $menu = self::assignMenu();
    $this->renderc('/manage-finance', $menu);
  }
}

?>
