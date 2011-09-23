<?php
Doo::loadCore('db/DooModel');

class VisitorCountBase extends DooModel{

    /**
     * @var int Max length is 11.
     */
    public $count_id;

    /**
     * @var int Max length is 11.
     */
    public $count;

    /**
     * @var varchar Max length is 100.
     */
    public $page;

    /**
     * @var varchar Max length is 30.
     */
    public $remote_ip;

    public $_table = 'visitor_count';
    public $_primarykey = 'count_id';
    public $_fields = array('count_id','count','page','remote_ip');

    public function getVRules() {
        return array(
                'count_id' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'optional' ),
                ),

                'count' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'notnull' ),
                ),

                'page' => array(
                        array( 'maxlength', 100 ),
                        array( 'notnull' ),
                ),

                'remote_ip' => array(
                        array( 'maxlength', 30 ),
                        array( 'notnull' ),
                )
            );
    }

}