<?php
Doo::loadCore('db/DooModel');

class ProfileBase extends DooModel{

    /**
     * @var int Max length is 11.
     */
    public $profile_id;

    /**
     * @var int Max length is 11.
     */
    public $user_id;

    /**
     * @var text
     */
    public $personal;

    /**
     * @var text
     */
    public $technical;

    /**
     * @var text
     */
    public $quote;

    /**
     * @var varchar Max length is 50.
     */
    public $picture;

    public $_table = 'profile';
    public $_primarykey = 'profile_id';
    public $_fields = array('profile_id','user_id','personal','technical','quote','picture');

    public function getVRules() {
        return array(
                'profile_id' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'optional' ),
                ),

                'user_id' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'notnull' ),
                ),

                'personal' => array(
                        array( 'notnull' ),
                ),

                'technical' => array(
                        array( 'notnull' ),
                ),

                'quote' => array(
                        array( 'notnull' ),
                ),

                'picture' => array(
                        array( 'maxlength', 50 ),
                        array( 'notnull' ),
                )
            );
    }

}