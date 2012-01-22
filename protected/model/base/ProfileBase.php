<?php
Doo::loadCore('db/DooModel');

class ProfileBase extends DooModel{

    /**
     * @var int Max length is 11.
     */
    public $profile_id;

    /**
     * @var text
     */
    public $info;

    public $_table = 'profile';
    public $_primarykey = 'profile_id';
    public $_fields = array('profile_id','info');

    public function getVRules() {
        return array(
                'profile_id' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'optional' ),
                ),

                'info' => array(
                        array( 'notnull' ),
                )
            );
    }

}