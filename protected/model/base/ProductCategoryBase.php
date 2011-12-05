<?php
Doo::loadCore('db/DooModel');

class ProductCategoryBase extends DooModel{

    /**
     * @var int Max length is 11.
     */
    public $category_id;

    /**
     * @var varchar Max length is 100.
     */
    public $category_name;

    /**
     * @var text
     */
    public $description;

    public $_table = 'product_category';
    public $_primarykey = 'category_id';
    public $_fields = array('category_id','category_name','description');

    public function getVRules() {
        return array(
                'category_id' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'optional' ),
                ),

                'category_name' => array(
                        array( 'maxlength', 100 ),
                        array( 'notnull' ),
                ),

                'description' => array(
                        array( 'notnull' ),
                )
            );
    }

}