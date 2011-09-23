<?php

class ExpenseController extends CommonController {

  public function manageExpensePage() {
    $menu = self::assignMenu();
    $this->renderc('/manage-expense', $menu);
  }

  public function saveExpense() {
    if ($_POST['submit'] && $_POST['date']) {

      $getDate = $this->db()->find('Expense', array(
                  'limit' => 1,
                  'where' => 'expense.date = ?',
                  'param' => array($_POST['date'])
              ));

      //create new expense record if no date found
      if (!$getDate) {

        foreach ($_POST as $post) {
          if (empty($post)) {
            $post == 0;
          }
        }
        $date = $_POST['date'];
        $breakfast = $_POST['breakfast'];
        $lunch = $_POST['lunch'];
        $dinner = $_POST['dinner'];
        $supper = $_POST['supper'];
        $travel = $_POST['travel'];
        $leisure = $_POST['leisure'];
        $misc = $_POST['misc'];

        $total = $breakfast + $lunch + $dinner + $supper + $travel + $leisure + $misc;

        $expense_array = array(
            'date' => $date,
            'breakfast' => $breakfast,
            'lunch' => $lunch,
            'dinner' => $dinner,
            'supper' => $supper,
            'travel' => $travel,
            'leisure' => $leisure,
            'misc' => $misc
        );
        Doo::loadModel('Expense');
        $e = new Expense($expense_array);
        $e->insert();
        $this->toJSON(array('New expense is recorded'), true);
        return 201;
      }

      //update expense record from existed date
      if($getDate){}
    }


      return 500;

  }

}

?>
