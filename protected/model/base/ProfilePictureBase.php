<?php
Doo::loadCore('db/DooModel');

class ProfilePictureBase extends DooModel{

    /**
     * @var int Max length is 11.
     */
    public $picture_id;

    /**
     * @var varchar Max length is 100.
     */
    public $original;

    /**
     * @var varchar Max length is 100.
     */
    public $resized;

    /**
     * @var enum 'yes','no').
     */
    public $visible;

    /**
     * @var varchar Max length is 50.
     */
    public $caption;

    /**
     * @var enum 'no','yes').
     */
    public $is_current;

    public $_table = 'profile_picture';
    public $_primarykey = 'picture_id';
    public $_fields = array('picture_id','original','resized','visible','caption','is_current');

    public function getVRules() {
        return array(
                'picture_id' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'optional' ),
                ),

                'original' => array(
                        array( 'maxlength', 100 ),
                        array( 'notnull' ),
                ),

                'resized' => array(
                        array( 'maxlength', 100 ),
                        array( 'notnull' ),
                ),

                'visible' => array(
                        array( 'notnull' ),
                ),

                'caption' => array(
                        array( 'maxlength', 50 ),
                        array( 'notnull' ),
                ),

                'is_current' => array(
                        array( 'notnull' ),
                )
            );
    }

}