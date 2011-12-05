<?php
Doo::loadCore('db/DooModel');

class ProductBase extends DooModel{

    /**
     * @var int Max length is 11.
     */
    public $product_id;

    /**
     * @var int Max length is 11.
     */
    public $category_id;

    /**
     * @var varchar Max length is 100.
     */
    public $product_name;

    /**
     * @var varchar Max length is 50.
     */
    public $product_code;

    /**
     * @var double
     */
    public $price;

    /**
     * @var int Max length is 11.
     */
    public $quantity;

    /**
     * @var text
     */
    public $description;

    /**
     * @var varchar Max length is 100.
     */
    public $image;

    /**
     * @var varchar Max length is 100.
     */
    public $thumbnail;

    /**
     * @var tinyint Max length is 4.
     */
    public $visible;

    public $_table = 'product';
    public $_primarykey = 'product_id';
    public $_fields = array('product_id','category_id','product_name','product_code','price','quantity','description','image','thumbnail','visible');

    public function getVRules() {
        return array(
                'product_id' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'optional' ),
                ),

                'category_id' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'notnull' ),
                ),

                'product_name' => array(
                        array( 'maxlength', 100 ),
                        array( 'notnull' ),
                ),

                'product_code' => array(
                        array( 'maxlength', 50 ),
                        array( 'notnull' ),
                ),

                'price' => array(
                        array( 'float' ),
                        array( 'notnull' ),
                ),

                'quantity' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'notnull' ),
                ),

                'description' => array(
                        array( 'notnull' ),
                ),

                'image' => array(
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
                )
            );
    }

}