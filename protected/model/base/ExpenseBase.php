<?php
Doo::loadCore('db/DooModel');

class ExpenseBase extends DooModel{

    /**
     * @var int Max length is 11.
     */
    public $expense_id;

    /**
     * @var date
     */
    public $date;

    /**
     * @var double
     */
    public $breakfast;

    /**
     * @var double
     */
    public $lunch;

    /**
     * @var double
     */
    public $dinner;

    /**
     * @var double
     */
    public $supper;

    /**
     * @var double
     */
    public $travel;

    /**
     * @var double
     */
    public $leisure;

    /**
     * @var double
     */
    public $misc;

    public $_table = 'expense';
    public $_primarykey = 'expense_id';
    public $_fields = array('expense_id','date','breakfast','lunch','dinner','supper','travel','leisure','misc');

    public function getVRules() {
        return array(
                'expense_id' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'optional' ),
                ),

                'date' => array(
                        array( 'date' ),
                        array( 'notnull' ),
                ),

                'breakfast' => array(
                        array( 'float' ),
                        array( 'notnull' ),
                ),

                'lunch' => array(
                        array( 'float' ),
                        array( 'notnull' ),
                ),

                'dinner' => array(
                        array( 'float' ),
                        array( 'notnull' ),
                ),

                'supper' => array(
                        array( 'float' ),
                        array( 'notnull' ),
                ),

                'travel' => array(
                        array( 'float' ),
                        array( 'notnull' ),
                ),

                'leisure' => array(
                        array( 'float' ),
                        array( 'notnull' ),
                ),

                'misc' => array(
                        array( 'float' ),
                        array( 'notnull' ),
                )
            );
    }

}