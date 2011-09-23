<?php
Doo::loadCore('db/DooModel');

class PictureBase extends DooModel{

    /**
     * @var int Max length is 11.
     */
    public $picture_id;

    /**
     * @var varchar Max length is 255.
     */
    public $name;

    /**
     * @var datetime
     */
    public $created;

    /**
     * @var varchar Max length is 150.
     */
    public $resized_name;

    /**
     * @var tinyint Max length is 4.
     */
    public $visible;

    /**
     * @var int Max length is 11.
     */
    public $user_id;

    public $_table = 'picture';
    public $_primarykey = 'picture_id';
    public $_fields = array('picture_id','name','created','resized_name','visible','user_id');

    public function getVRules() {
        return array(
                'picture_id' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'optional' ),
                ),

                'name' => array(
                        array( 'maxlength', 255 ),
                        array( 'notnull' ),
                ),

                'created' => array(
                        array( 'datetime' ),
                        array( 'notnull' ),
                ),

                'resized_name' => array(
                        array( 'maxlength', 150 ),
                        array( 'notnull' ),
                ),

                'visible' => array(
                        array( 'integer' ),
                        array( 'maxlength', 4 ),
                        array( 'notnull' ),
                ),

                'user_id' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'notnull' ),
                )
            );
    }

}