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
     * @var int Max length is 11.
     */
    public $created;

    /**
     * @var text
     */
    public $message;

    /**
     * @var int Max length is 11.
     */
    public $latest_id;

    public $_table = 'status_update';
    public $_primarykey = 'status_update_id';
    public $_fields = array('status_update_id','user_id','created','message','latest_id');

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
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'notnull' ),
                ),

                'message' => array(
                        array( 'notnull' ),
                ),

                'latest_id' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'notnull' ),
                )
            );
    }

}