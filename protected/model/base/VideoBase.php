<?php
Doo::loadCore('db/DooModel');

class VideoBase extends DooModel{

    /**
     * @var int Max length is 11.
     */
    public $video_id;

    /**
     * @var varchar Max length is 100.
     */
    public $title;

    /**
     * @var datetime
     */
    public $created;

    /**
     * @var varchar Max length is 100.
     */
    public $link;

    /**
     * @var varchar Max length is 100.
     */
    public $thumbnail;

    /**
     * @var tinyint Max length is 4.
     */
    public $visible;

    /**
     * @var int Max length is 11.
     */
    public $user_id;

    /**
     * @var int Max length is 11.
     */
    public $latest_id;

    public $_table = 'video';
    public $_primarykey = 'video_id';
    public $_fields = array('video_id','title','created','link','thumbnail','visible','user_id','latest_id');

    public function getVRules() {
        return array(
                'video_id' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'optional' ),
                ),

                'title' => array(
                        array( 'maxlength', 100 ),
                        array( 'notnull' ),
                ),

                'created' => array(
                        array( 'datetime' ),
                        array( 'notnull' ),
                ),

                'link' => array(
                        array( 'maxlength', 100 ),
                        array( 'notnull' ),
                ),

                'thumbnail' => array(
                        array( 'maxlength', 100 ),
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
                ),

                'latest_id' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'notnull' ),
                )
            );
    }

}