<?php
Doo::loadCore('db/DooModel');

class LatestUpdateBase extends DooModel{

    /**
     * @var int Max length is 11.
     */
    public $latest_id;

    /**
     * @var varchar Max length is 50.
     */
    public $type;

    public $_table = 'latest_update';
    public $_primarykey = 'latest_id';
    public $_fields = array('latest_id','type');

    public function getVRules() {
        return array(
                'latest_id' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'optional' ),
                ),

                'type' => array(
                        array( 'maxlength', 50 ),
                        array( 'notnull' ),
                )
            );
    }

}