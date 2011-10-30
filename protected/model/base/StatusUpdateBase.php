<?php
Doo::loadCore('db/DooModel');

class StatusUpdateBase extends DooModel{

    /**
     * @var int Max length is 11.
     */
    public $status_update_id;

    /**
     * @var int Max length is 11.
     */
    public $user_id;

    /**
     * @var datetime
     */
    public $created;

    /**
     * @var text
     */
    public $message;

    public $_table = 'status_update';
    public $_primarykey = 'status_update_id';
    public $_fields = array('status_update_id','user_id','created','message');

    public function getVRules() {
        return array(
                'status_update_id' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'optional' ),
                ),

                'user_id' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'notnull' ),
                ),

                'created' => array(
                        array( 'datetime' ),
                        array( 'notnull' ),
                ),

                'message' => array(
                        array( 'notnull' ),
                )
            );
    }

}