<?php
Doo::loadCore('db/DooModel');

class ChatBase extends DooModel{

    /**
     * @var int Max length is 11.
     */
    public $chat_id;

    /**
     * @var datetime
     */
    public $created;

    /**
     * @var text
     */
    public $message;

    /**
     * @var varchar Max length is 50.
     */
    public $username;

    /**
     * @var varchar Max length is 50.
     */
    public $email;

    public $_table = 'chat';
    public $_primarykey = 'chat_id';
    public $_fields = array('chat_id','created','message','username','email');

    public function getVRules() {
        return array(
                'chat_id' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'optional' ),
                ),

                'created' => array(
                        array( 'datetime' ),
                        array( 'notnull' ),
                ),

                'message' => array(
                        array( 'notnull' ),
                ),

                'username' => array(
                        array( 'maxlength', 50 ),
                        array( 'notnull' ),
                ),

                'email' => array(
                        array( 'maxlength', 50 ),
                        array( 'notnull' ),
                )
            );
    }

}