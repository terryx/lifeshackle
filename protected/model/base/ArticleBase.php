<?php
Doo::loadCore('db/DooModel');

class ArticleBase extends DooModel{

    /**
     * @var int Max length is 11.
     */
    public $article_id;

    /**
     * @var varchar Max length is 100.
     */
    public $title;

    /**
     * @var int Max length is 11.
     */
    public $created;

    /**
     * @var int Max length is 11.
     */
    public $last_edited;

    /**
     * @var text
     */
    public $tag;

    /**
     * @var tinyint Max length is 4.
     */
    public $visible;

    /**
     * @var int Max length is 11.
     */
    public $latest_id;

    public $_table = 'article';
    public $_primarykey = 'article_id';
    public $_fields = array('article_id','title','created','last_edited','tag','visible','latest_id');

    public function getVRules() {
        return array(
                'article_id' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'optional' ),
                ),

                'title' => array(
                        array( 'maxlength', 100 ),
                        array( 'notnull' ),
                ),

                'created' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'notnull' ),
                ),

                'last_edited' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'notnull' ),
                ),

                'tag' => array(
                        array( 'notnull' ),
                ),

                'visible' => array(
                        array( 'integer' ),
                        array( 'maxlength', 4 ),
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